<?php


namespace AppBundle\Form\Api;

use AppBundle\Form\Api\Type\ApiCollectionType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class ApiAbstractType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->buildApiForm($builder, $options);
        $collectionNames = [];
        $entityNames = [];

        foreach ($builder->all() as $key => $value) {
            if ($value->getFormConfig()->getType()->getInnerType() instanceof ApiCollectionType) {
                $collectionNames[] = $key;
            }
            if ($value->getFormConfig()->getType()->getInnerType() instanceof EntityType) {
                $entityNames[] = $key;
            }
        }


        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($collectionNames, $entityNames){

            /*==========================Fields to exclude======================*/
            $fieldsToRemove = ['lastUpdater', 'modificationDate'];
            $data =  [];

            foreach ($event->getData() as $property => $value) {
                if (!in_array($property, $fieldsToRemove)) {
                    $data[$property] = $value;
                }
            }

            $event->setData($data);
            /*==========================End Fields to exclude======================*/

            /*==========================EntityType treatment======================*/
            foreach ($entityNames as $entityName) {
                $data = $event->getData();

                if (isset($data[$entityName])) {

                    //If the field contains an array, there is a process to find the id
                    if (is_array($data[$entityName]))
                    {
                        //Special treatment if the option multiple => true
                        if ($event->getForm()->get($entityName)->getConfig()->getOptions()['multiple']) {
                            $collection = [];
                            /*              if (!is_array($data[$entityName])) {
                                              continue;
                                          }*/
                            foreach ($data[$entityName] as $key => $value) {
                                if (array_key_exists('id', $value)) {
                                    $collection[$key] = $value['id'];
                                } else {
                                    //todo: improve the origin message
                                    $event->getForm()->addError(new FormError('Il n\'y pas d\'id sur le champ ' . $entityName . '.' . $key ));
                                }
                            }
                            $data[$entityName] = $collection;
                            $event->setData($data);
                            continue;
                        }

                        if (array_key_exists('id', $data[$entityName])) {
                            $data[$entityName] = $data[$entityName]['id'];
                        } else {
                            //todo: improve the origin message
                            $event->getForm()->addError(new FormError('Il n\'y pas d\'id sur le champ ' . $entityName ));
                        }
                    }

                }

                $event->setData($data);
            }
            /*==========================End EntityType treatment======================*/

            $propertyAccessor = PropertyAccess::createPropertyAccessor();


            /*==========================ApiCollectionType treatment======================*/
            foreach ($collectionNames as $collectionName) {

                $data = $event->getData();
                if(isset($data[$collectionName]))
                {

                    if (!$event->getForm()->getData()) {
                        $dbCollections = new ArrayCollection();
                    }
                    else {
                        $dbCollections = $propertyAccessor->getValue($event->getForm()->getData(), $collectionName);
                    }

                    $submittedCollection = $data[$collectionName];
                    $newCollection = [];

                    $newIndex = $dbCollections->count();
                    foreach ($submittedCollection as $submittedItem) {

                        if (isset($submittedItem['id'])) {

                            foreach ($dbCollections as $oldIndex => $dbIndex){
                                if( $submittedItem['id'] === $dbIndex->getId()) {
                                    $newCollection[$oldIndex] = $submittedItem;
                                    continue 2;
                                }
                            }

                        }

                        $newCollection[$newIndex++] = $submittedItem;
                    }

                    $data[$collectionName] = $newCollection;
                }
                $event->setData($data);
            }
            /*==========================End ApiCollectionType treatment======================*/

        });

    }

    protected abstract function buildApiForm(FormBuilderInterface $builder, array $options);
}
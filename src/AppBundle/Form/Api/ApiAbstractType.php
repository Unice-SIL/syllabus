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
use Symfony\Component\Form\FormInterface;
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

                        //anonymous function setId definition
                        $setId = function (&$valueToTest, FormInterface $form, $fieldName, $options = []) {
                            $options = array_merge([
                                'key' => null
                            ], $options);
                            //If the field contains an array, there is a process to find the id
                            if (is_array($valueToTest)) {

                                if (array_key_exists('id', $valueToTest)) {
                                    $valueToTest = $valueToTest['id'];
                                } else {
                                    //todo: improve the origin message
                                    $message = 'Il n\'y pas d\'id sur le champ ' . $fieldName;

                                    if (null !== $options['key']) {
                                        $message .= '.' . $options['key'];
                                    }
                                    $form->addError(new FormError($message ));
                                }

                            }

                        };

                        //Treatment if the option multiple is set to true
                        if ($event->getForm()->get($entityName)->getConfig()->getOptions()['multiple']) {

                            $collection = [];

                            foreach ($data[$entityName] as $key => $value) {
                                $setId($value, $event->getForm(), $entityName, ['key' => $key]);
                                $collection[] = $value;
                            }

                            $data[$entityName] = $collection;
                            $event->setData($data);
                            continue;
                        }

                        //Treatment if the option multiple is set to false
                        $setId($data[$entityName], $event->getForm(), $entityName);



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
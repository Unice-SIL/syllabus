<?php


namespace AppBundle\Form\Api;


use AppBundle\Entity\CourseInfo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class ApiAbstractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $this->buildApiForm($builder, $options);
        $collectionNames = [];
        foreach ($builder->all() as $key => $value) {
            if ($value->getFormConfig()->getType()->getInnerType() instanceof CollectionType) {
                $collectionNames[] = $key;
            }
        }

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($collectionNames){
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
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
        });

    }

    protected abstract function buildApiForm(FormBuilderInterface $builder, array $options);
}
<?php


namespace AppBundle\Import\Matching;

abstract class AbstractMatching
{

    /**
     * example : [
     *     'title' => [
     *          'name' => 'Titre' // (name in the original data) optional, by default the name is the array key
     *          'type' => 'string' // (type in the entity) optional by default is string
     *          'choices' => [] //  optional by default is []
     *          'findBy' => 'id' // optional by default is 'id'
     *          'entity' => null // (entity classname) optional by default is null
     *          'required' => false // optional by default is false
     *          'description' => '' // optional by default is null
     *      ]
     * ]
     */
    abstract protected function getBaseMatching(): array;

    public function getCompleteMatching()
    {
        //todo: refacto to return array instead of generator
        $matching = $this->getBaseMatching();

        foreach ($matching as $key => $value) {
            $property = $value;
            $name = $value;
            $type = 'string';
            $nullable = false;
            $choices = [];
            $findBy = 'id';
            $entity = null;
            $required = false;
            $description = null;
            if (is_array($value)) {
                $property = $key;
                $name = isset($value['name']) ? $value['name'] :  $property;
                $type = isset($value['type']) ? $value['type'] : $type;
                $nullable = isset($value['nullable']) ? $value['nullable'] : $nullable;
                $choices = isset($value['choices']) ? $value['choices'] : $choices;
                $findBy = isset($value['findBy']) ? $value['findBy'] : $findBy;
                $entity = isset($value['entity']) ? $value['entity'] : $entity;
                $required = isset($value['required']) ? $value['required'] : $required;
                $description = isset($value['description']) ? $value['description'] : $description;

            }

            yield $property => [ 'name' => $name,
                'type' => $type,
                'nullable' => $nullable,
                'choices' => $choices,
                'entity' => $entity,
                'findBy' => $findBy,
                'required' => $required,
                'description' => $description
            ];
        }
    }

    /**
     *
     * @param string $type (could be source|entity)
     * @return array
     */
    public function getFields($type = 'source'): array
    {
        $fields = [];
        if ('entity' === $type) {
            foreach ($this->getCompleteMatching() as $property => $match) {
                $fields[] = $property;
            }
            return $fields;
        }

        if ('source' === $type) {
            foreach ($this->getCompleteMatching() as $match) {
                $fields[] = $match['name'];
            }
            return $fields;
        }

    }

}
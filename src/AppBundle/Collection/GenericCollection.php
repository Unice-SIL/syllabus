<?php

namespace AppBundle\Collection;

/**
 * Class GenericCollection
 * @package AppBundle\Collection
 */
abstract class GenericCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $container = [];

    /**
     * GenericCollection constructor.
     * @param $type
     * @throws \Exception
     */
    public function __construct($type)
    {
        if(!class_exists($type)){
            throw new \Exception(sprintf('Class %s does not exist.', $type));
        }
        $this->type = $type;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->container)? $this->container[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException('%s expected instead of %s.', $this->type, get_class($value));
        }
        $this->container[$offset] = $value;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    /**
     * @param $value
     */
    public function append($value){
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException('%s expected instead of %s.', $this->type, get_class($value));
        }
        $this->container[] = $value;
    }

    /**
     * @param $value
     */
    public function remove($value){
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException('%s expected instead of %s.', $this->type, get_class($value));
        }
        $offset = array_search($value, $this->container, true);
        if($offset !== false){
            $this->offsetUnset($offset);
        }
    }

    /**
     * @return int
     */
    public function count(){
        return count($this->container);
    }

    /**
     * @return array
     */
    public function toArray(){
        return $this->container;
    }
}
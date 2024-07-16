<?php

namespace App\Ldap\Collection;

use ArrayIterator;
use Exception;

/**
 * Class GenericCollection
 * @package App\Ldap\Collection
 */
abstract class GenericCollection implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var array
     */
    protected array $container = [];

    /**
     * GenericCollection constructor.
     * @param $type
     * @param array $data
     * @throws Exception
     */
    public function __construct($type, array $data = [])
    {
        if(!class_exists($type)){
            throw new Exception(sprintf('Class %s does not exist.', $type));
        }
        $this->type = $type;
        foreach ($data as $d){
            $this->append($d);
        }
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return array_key_exists($offset, $this->container)? $this->container[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException(sprintf('%s expected instead of %s.', $this->type, get_class($value)));
        }
        $this->container[$offset] = $value;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->container);
    }

    /**
     * @param $value
     */
    public function append($value): void
    {
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException(sprintf('%s expected instead of %s.', $this->type, get_class($value)));
        }
        $this->container[] = $value;
    }

    /**
     * @param $value
     */
    public function remove($value): void
    {
        if(!is_a($value, $this->type)){
            throw new \UnexpectedValueException(sprintf('%s expected instead of %s.', $this->type, get_class($value)));
        }
        $offset = array_search($value, $this->container, true);
        if($offset !== false){
            $this->offsetUnset($offset);
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->container);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->container;
    }
}
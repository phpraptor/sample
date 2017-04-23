<?php

namespace Raptor\Components;

class Collection
{
    /**
     * Collection storage.
     *
     * @var array
     */
    protected $collection;

    /**
     * Returns the collection.
     *
     * @return array An array of collection
     */
    public function all()
    {
        return $this->collection;
    }

    /**
     * Returns the collection keys.
     *
     * @return array An array of collection keys
     */
    public function keys()
    {
        return array_keys($this->collection);
    }

    /**
     * Replaces the current collection by a new set.
     *
     * @param array $collection An array of collection
     */
    public function replace(array $collection = array())
    {
        $this->collection = $collection;
    }

    /**
     * Adds collection.
     *
     * @param array $collection An array of collection
     */
    public function add(array $collection = array())
    {
        $this->collection = array_replace($this->collection, $collection);
    }

    /**
     * Returns a collection by name.
     *
     * @param string $key     The key
     * @param mixed  $default The default value if the collection key does not exist
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->collection) ? $this->collection[$key] : $default;
    }

    /**
     * Sets a collection by name.
     *
     * @param string $key   The key
     * @param mixed  $value The value
     */
    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }

    /**
     * Returns true if the collection is defined.
     *
     * @param string $key The key
     *
     * @return bool true if the collection exists, false otherwise
     */
    public function has($key)
    {
        return array_key_exists($key, $this->collection);
    }

    /**
     * Removes a collection.
     *
     * @param string $key The key
     */
    public function remove($key)
    {
        unset($this->collection[$key]);
    }

    /**
     * Returns the number of collection.
     *
     * @return int The number of collection
     */
    public function count()
    {
        return count($this->collection);
    }
}
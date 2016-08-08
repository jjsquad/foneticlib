<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 19:33
 */

namespace Fonetic\Vector;

use BadFunctionCallException;
use Fonetic\Vector\Contracts\VectorInterface;
use InvalidArgumentException;
use OutOfBoundsException;
use OutOfRangeException;

abstract class AbstractVector implements VectorInterface
{
    /**
     * Contains the Vector items
     */
    protected $elements = [];

    /**
     * Default delimiter
     */
    protected $delimiter;

    /**
     * The current element
     */
    protected $element;

    /**
     * Number of items in elements array
     */
    protected $count;

    /**
     * Vector constructor.
     * @param $value
     * @param $delimiter
     */
    public function __construct($value = null, $delimiter = ' ')
    {
        $this->delimiter = $delimiter;
        if(!is_null($value)) {
            $this->elements = explode($delimiter, $value);
            $this->count();
            return;
        }
    }

    /**
     * Magic function to convert to string
     * @return string
     */
    public function __toString()
    {
        return (string)$this->element;
    }

    /**
     * Explict toString conversion
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * Get the array of Vector elements
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * Set the current element of collection
     * @param $index
     * @return $this|mixed
     */
    public function elementAt($index)
    {
        if($index < 0 || $index > count($this->elements) - 1) {
            throw new OutOfRangeException("Index its out of range. (Undefined offset error).");
        }

        $this->element = $this->elements[$index];
        return $this;
    }

    /**
     * Non boolean compare 
     * (returns 0 at found a same value, otherwise returns de distance difference)
     * @param $value
     * @return int
     */
    public function compareTo($value)
    {
        if($this->element !== null) {
            $result = strcmp($this->element, $value);
            $this->element = null;
            return $result;
        }
        throw new BadFunctionCallException("No element set to compareTo.");
    }

    /**
     * Combine all elements into a string
     * @return string
     */
    public function combine()
    {
        return implode($this->delimiter, $this->elements);
    }

    /**
     * Insert a new element at $index position
     * @param mixed $value
     * @param $index
     * @return Vector
     */
    public function addElementAt($value, $index)
    {
        $this->checkBounds($index);
        
        $this->elements = array_splice($this->elements, $index, 0, $value);
        
        $this->element = null;
        $this->count();
        
        return $this;
    }

    public function setElementAt($index, $value)
    {
        $this->checkBounds($index);
        
        $this->elements[$index] = $value;
        
        $this->element = $value;
        
        return $this;
    }

    /**
     * Adds a new element at end of elements array
     * @param $value
     * @return $this|mixed
     */
    public function addElement($value)
    {
        if(is_array($value)) {
            $this->elements = array_merge($this->elements, $value);
        } else {
            array_push($this->elements, $value);
        }

        $this->element = null;
        $this->count();
        return $this;
    }

    /**
     * Remove a element at $index
     * @param $index
     * @return $this
     */
    public function removeElementAt($index)
    {
        $this->checkBounds($index);

        $this->element = null;

        array_splice($this->elements, $index, 1);
        
        $this->count();

        return $this;
    }

    /**
     * Remove elements that matches $array items
     * @param $array
     * @return $this
     */
    public function removeElements($array)
    {
        if(!is_array($array)) {
            throw new InvalidArgumentException("removeElements function needs an Array argument.");
        }

        $this->elements = array_diff($this->elements, $array);

        return $this;
    }

    /**
     * Check if 'HAS' a element with $value in elements array
     * Returns a boolean compareTo function
     * @param $value
     * @return bool
     */
    public function has($value)
    {
        return in_array($value, $this->elements);
    }

    /**
     * Return the number of items in elements array
     * @return int
     */
    public function count()
    {
        $this->count = count($this->elements);
        return $this->count;
    }

    /**
     * Magic function to access the Class Protected Properties
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if(property_exists($this, $name)) {
            return $this->{$name}();
        }
    }

    private function checkBounds($index)
    {
        if($index < 0 || $index > $this->count) {
            throw new OutOfBoundsException("Index $index its ou of bounds.");
        }
    }

}


<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 19:33
 */

namespace Fonetic\Vector;

use Fonetic\Vector\Contracts\VectorInterface;
use Fonetic\Vector\Exceptions\VectorUndefinedOffsetException;
use OutOfBoundsException;
use OutOfRangeException;

abstract class VectorAbstractor implements VectorInterface
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
        return ($this->element !== null) ? $this->element : $this->combine();
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
        return strcmp($this->element, $value);
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
        if($index < 0 || $index > $this->count) {
            throw new OutOfBoundsException("Index $index its ou of bounds.");
        }
        
        if($index === 0) {
            if(is_array($value)) {
                $this->elements = array_merge($value, $this->elements);
            } else {
                array_unshift($this->elements, $value);
            }
            return $this;
        }
        
        if($this->count === $index) {
            if(is_array($value)) {
                $this->elements = array_merge($this->elements, $value);
            } else {
                array_push($this->elements, $value);
            }
            return $this;
        }
        
        $leftPart = array_slice($this->elements, 0, $index);
        $rightPart = array_slice($this->elements, $index);

        if(is_array($value)) {
            $leftPart = array_merge($leftPart, $value);
        } else {
            array_push($leftPart, $value);
        }

        $this->elements = array_merge($leftPart, $rightPart);

        //Cleans the current element
        $this->element = null;
        $this->count();
        
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
        return $this;
    }

    public function removeElementAt($index)
    {
        // TODO: Implement removeElementAt() method.
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

}


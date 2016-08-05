<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 19:33
 */

namespace Fonetic\Vector;

use Fonetic\Vector\Contracts\VectorInterface;
use Fonetic\Vector\Exceptions\VectorOutOfBoundsException;
use Fonetic\Vector\Exceptions\VectorUndefinedOffsetException;

abstract class VectorAbstractor implements VectorInterface
{
    /**
     * Contains the Vector items
     * @var array
     */
    protected $elements;
    /**
     * Default delimiter
     * @var string
     */
    protected $delimiter;
    protected $element;
    
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

        $this->elements = [];
    }

    public function __toString()
    {
        return $this->element ?: $this->combine();
    }

    public function elementAt($index)
    {
        if($index > count($this->elements) - 1) {
            throw new VectorUndefinedOffsetException($index);
        }

        $this->element = $this->elements[$index];
        return $this;
    }

    public function compareTo($value)
    {
        return strcmp($this->element, $value);
    }

    /**
     *
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
            throw new VectorOutOfBoundsException($index);
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

        $this->count();
        
        return $this;
    }
    
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
    
    public function count()
    {
        $this->count = count($this->elements);
        return $this->count;
    }

    public function __get($name)
    {
        if(property_exists($this, $name)) {
            return $this->{$name}();
        }
    }

    public function has($value)
    {
        return in_array($value, $this->elements);
    }
}


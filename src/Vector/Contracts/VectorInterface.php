<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 19:34
 */

namespace Fonetic\Vector\Contracts;

use Fonetic\Vector\Vector;

interface VectorInterface
{
    public function __toString();

    /**
     * @param $index
     * @return $mixed
     */
    public function elementAt($index);

    /**
     * @param $item
     * @return integer
     */
    public function compareTo($value);

    /**
     * @return string
     */
    public function combine();

    /**
     * @param $index
     * @return Vector
     */
    public function removeElementAt($index);

    /**
     * @param $index
     * @return Vector
     */
    public function addElementAt($value, $index);

    /**
     * @param $value
     * @return Vector
     */
    public function addElement($value);

    /**
     * @return integer
     */
    public function count();

    /**
     * @param $value
     * @return boolean
     */
    public function has($value);
}
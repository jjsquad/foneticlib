<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 22:27
 */

namespace Fonetic\Vector\Exceptions;


use Exception;

class VectorOutOfBoundsException extends Exception
{

    /**
     * VectorOutOfBoundsException constructor.
     */
    public function __construct($index)
    {
        parent::__construct("Index ${index} its out of bounds.");
    }
}
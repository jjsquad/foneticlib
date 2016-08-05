<?php
/**
 * Created by PhpStorm.
 * User: squad
 * Date: 04/08/16
 * Time: 21:40
 */

namespace Fonetic\Vector\Exceptions;


use Exception;

class VectorUndefinedOffsetException extends Exception
{

    /**
     * VectorUndefinedOffsetException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($offset)
    {
        $message = "Undefined vector offset: {$offset}";
        parent::__construct($message);
    }
}
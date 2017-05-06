<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 29/04/2017
 * Time: 14:49
 */

namespace Corporatte\Filesystem\Exceptions;


use Throwable;

class FileReadException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
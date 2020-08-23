<?php

namespace MallardDuck\Whois\Exceptions;

use Exception;

/**
 * A basic exception for Missing Arguments.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
 */
class MissingArgException extends Exception
{
    /** @var int    An integer code for the exception. */
    public const CODE = 0;

    /**
     * Basic Exception Constructor
     *
     * @param string         $message  The Exceptions message: this type requires it be related to a missing item.
     * @param int            $code     The user defined exception code.
     * @param null|Exception $previous If present, the previous exception if nested exception.
     */
    public function __construct($message, $code = self::CODE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

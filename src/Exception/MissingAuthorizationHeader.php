<?php

use Cake\Core\Exception\Exception;

class MissingAuthorizationHeaderException extends Exception
{
    // Context data is interpolated into this format string.
    //protected $_messageTemplate = 'Seems that %s is missing.';

    // You can set a default exception code as well.
    protected $_defaultCode = 400;
}
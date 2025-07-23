<?php

namespace App\Exceptions;

use Exception;

class TrackingNotSupportedException extends Exception
{
    protected $message = 'Отслеживание для этого номера недоступно';

}

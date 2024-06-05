<?php

class CustomException extends Exception
{
    //if code is 0 this mean that the exception will be not diplayed in the log Error file
    public function setMessage($message, $code): void
    {
        $this->message = $message;
        $this->code = $code;
    }
}

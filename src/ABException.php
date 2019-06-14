<?php

namespace WhizSid\ArrayBase;

class ABException extends \Exception
{
    public function __toString()
    {
        return 'ABException [AB'.$this->getCode().'] '.$this->getMessage().' '.$this->getTraceAsString();
    }
}

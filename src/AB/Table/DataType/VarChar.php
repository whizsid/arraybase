<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class VarChar implements DataType{
    
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validate($str){
        return is_string($str);
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function format($str){
        return (string) $str;
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getName(){
        return 'varchar';
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getDefaultMaxLength(){
        return 45;
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validateMaxLength($max){
        if($max>500) throw new ABException('The given length is exceed the available max length.',35);
    }
}
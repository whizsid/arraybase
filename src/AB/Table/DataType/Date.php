<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class Date implements DataType{
    
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validate($date){
        return !!strtotime($date);
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function format($date){
        return date('Y-m-d',strtotime($date));
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getName(){
        return 'date';
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getDefaultMaxLength(){
        return 8;
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validateMaxLength($max){
        if($max>19) throw new ABException('The given length is exceed the available max length.',33);
    }
}
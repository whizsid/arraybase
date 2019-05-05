<?php
namespace WhizSid\ArrayBase\AB\Table\DataType;

use WhizSid\ArrayBase\ABException;

class Integer implements DataType{
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validate($int){
        return !!is_numeric($int);
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function format($int){
        return round($int);
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getName(){
        return 'integer';
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function getDefaultMaxLength(){
        return 11;
    }
    /**
     * @inherit
     *
     * {@inheritDoc}
     * {@inherit}
     */
    public function validateMaxLength($max){
        // <ABE13> \\
        if($max>256) throw new ABException('The given length is exceed the available max length.',13);
    }
}
<?php

namespace WhizSid\ArrayBase\AB\Table\DataType;

/*__________________ PHP ArrayBase ______________________
\ This is an open source project to properly manage your |
/ PHP array data. You can use SQL like functions to PHP  |
\ arrays with this library.                              |
/ This is an open source library and you can change or   |
\ republish this library. Please give credits to author  |
/ when you publish this library in another place without |
\ permissions. Thank you to look into my codes.          |
/ ------------------- 2019 - WhizSid --------------------|
\_________________________________________________________
*/

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
        // <ABE12> \\
        if($max>19) throw new ABException('The given length is exceed the available max length.',12);
    }
}
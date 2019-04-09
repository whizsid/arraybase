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
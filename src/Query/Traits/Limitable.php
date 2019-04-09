<?php
namespace WhizSid\ArrayBase\Query\Traits;

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

trait Limitable {
    protected $limit;

    protected $offset;
    /**
     * Limiting Results
     *
     * @param integer $limit
     * @param integer $offset
     * @return self
     */
    public function limit($limit,$offset=0){
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }
}
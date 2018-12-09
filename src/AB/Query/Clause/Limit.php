<?php

namespace WhizSid\ArrayBase\AB\Query\Clause;

use WhizSid\ArrayBase\ABException;

class Limit extends Clause{
    /**
     * Count of rows to limit
     *
     * @var int
     */
    protected $limit;
    /**
     * Count of skiping rows
     *
     * @var integer
     */
    protected $offset=0;
    /**
     * Setting limit row count
     *
     * @param int $num
     * @return void
     */
    public function take(int $num){
        $this->limit = $num;
    }
    /**
     * Count of rows that skiping
     *
     * @param int $num
     * @return void
     */
    public function skip(int $num){
        $this->offset = $num;
    }
    /**
     * If you are using paginations you can set offset to get only exact rows
     *
     * @param int $num
     * @return void
     */
    public function page($num){
        $this->skip(($num -1)*$this->limit);
    }
    /**
     * Returning the count of rows that limited
     *
     * @return int
     */
    public function getLimit(){
        return $this->limit;
    }
    /**
     * Retuning the offset
     *
     * @return int
     */
    public function getOffset(){
        return $this->offset;
    }
    /**
     * Validating the limit clause
     * 
     * @throws ABException
     */
    public function validate(){
        if(!$this->limit) throw new ABException('Please provide a valid limit value',16);
    }
}
<?php
namespace WhizSid\ArrayBase\AB\Data;

class Row {
    /**
     * Cells for the row
     *
     * @var Cell[]
     */
    protected $cells;
    /**
     * Setting cells
     *
     * @param array $cells
     * @return void
     */
    public function setCells(array $cells){
        $this->cells= $cells;
    }
    /**
     * Returning cells
     *
     * @return array
     */
    public function getCells(){
        return $this->cells;
    }
}
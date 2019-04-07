<?php
namespace WhizSid\ArrayBase\AB\Traits;

use WhizSid\ArrayBase\Query\Helpers\Alias;


trait Aliasable {
    public function as($alias){
        $alias = new Alias($alias,$this);

        return $alias;
    }

    public function getObject(){
        return $this;
    }

    public function getAlias(){
        return $this->getName();
    }
}
<?php
namespace Example;

/**
 * Description of AbstractEntity
 *
 * @author Dmitriy
 */
abstract class AbstractEntity{

    protected $id;

    function getId(){
	return $this->id;
    }

    function setId($id){
	$this->id = $id;
	return $this;
    }

    /**
     * Return an associative array containing all the properties in this object. 
     *
     * @return array
     */
    public function toArray(){
	return get_object_vars($this);
    }
}

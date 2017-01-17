<?php
namespace Example\User;

/**
 * Description of UserRepository
 *
 * @author Dmitriy
 */
class UserRepository{

    protected $mapper;

    protected $adapter;

    function __construct(\Example\AbstractDataMapper $mapper,
			 \Example\MemoryStorage $storage){
	$this->mapper	 = $mapper;
	$this->adapter	 = $storage;
    }

    public function findById($id){
	$arrayData = $this->adapter->retrieve($id);
	if(is_null($arrayData)){
	    throw new \InvalidArgumentException(sprintf('Post with ID %d does not exist',
						 $id));
	}
	return $this->mapper->assign(User::fromState($arrayData), $arrayData);
    }
    
}

<?php
namespace Example\User;

/**
 * Description of UserRepository
 *
 * @author Dmitriy
 */
class UserRepository{

    protected $mapper;

    protected $storage;

    function __construct(\Example\AbstractDataMapper $mapper,
			 \DataMapper\Storage\StorageDAO $storage){
		$this->mapper	 = $mapper;
		$this->storage	 = $storage;
    }

    public function findById($id){
		$arrayData = $this->storage->fetchRow($id);
		if (is_null($arrayData)) {
			throw new \InvalidArgumentException(sprintf('User with ID %d does not exist',$id));
		}
		return $this->build($row);    	
    }
    
	protected function build($row){
		return $this->mapper->assign(User::fromState($row), $row);
	}    
    
}

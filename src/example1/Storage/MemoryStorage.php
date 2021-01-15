<?php

namespace DataMapper\Storage;

/**
 * Description of MemoryStorage
 *
 * @author Dmitriy
 */
class MemoryStorage implements StorageDao {

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @var int
	 */
	private $lastId = 0;

	/**
	 * 
	 * @param type $id
	 * @throws \OutOfRangeException
	 */
	public function delete($id) {
		if (!isset($this->data[$id])) {
			throw new \OutOfRangeException(sprintf('No data found for ID %d', $id));
		}
		unset($this->data[$id]);
		return true;
	}
	
	/**
	 * 
	 * @return type
	 */
	public function fetchAll() {
		return $this->data;
	}

	/**
	 * 
	 * @param type $id
	 * @return type
	 * @throws \OutOfRangeException
	 */
	public function fetchRow($id) {
		if (!isset($this->data[$id])) {
			throw new \OutOfRangeException(sprintf('No data found for ID %d', $id));
		}
		return $this->data[$id];
	}

	/**
	 * 
	 * @param array $data
	 * @return type
	 */
	public function insert(array $data) {
		$this->lastId++;
		$data['id']					 = $this->lastId;
		$this->data[$this->lastId]	 = $data;
		return $this->lastId;		
	}

	/**
	 * 
	 * @param type $id
	 * @param array $data
	 * @return boolean
	 * @throws \OutOfRangeException
	 */
	public function update($id,array $data) {
		if (!isset($this->data[$id])) {
			throw new \OutOfRangeException(sprintf('No data found for ID %d', $id));
		}
		$this->data[$id]	 = $data;
		return true;
	}


}

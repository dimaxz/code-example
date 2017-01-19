<?php

namespace DataMapper;

/**
 * Description of AbstractDataMapper
 *
 * @author Dmitriy
 */
abstract class AbstractDataMapper {

	/**
	 * @var array
	 */
	protected $map = array();

	/**
	 * Class constructor.
	 *
	 * @param array $map
	 * @return void
	 */
	public function __construct(array $map = null) {
		if (null !== $map) {
			$this->setMap($map);
		}
	}

	/**
	 * Set map array. 
	 *
	 * @param array $map
	 * @return void
	 */
	public function setMap(array $map) {
		$this->map = $map;
	}
	
	public function addMap($alias,$field = null){
		$field = !$field ? $alias : $field;
		$this->map[$field] = $alias;
		return $this;
	}

	/**
	 * Return map array.
	 *
	 * @return array
	 */
	public function getMap() {
		return $this->map;
	}

	/**
	 * Append fields to the map array.
	 *
	 * @param array
	 * @return void
	 */
	public function append(array $fields) {
		$this->setMap(array_merge($this->getMap(), $fields));
	}

	/**
	 * Заполняет данными объект
	 *
	 * @param Zf_Orm_Entity $entity
	 * @param array $element
	 * @return void
	 * @throws Zf_Orm_DataMapperException
	 */
	public function assign(AbstractEntity $entity, array $element) {
		foreach ($element as $key => $value) {
			$map = $this->getMap();
			if (!array_key_exists($key, $map)) {
				throw new DataMapperException(sprintf('No such field "%s"', $key));
			}
			$property	 = $map[$key];
			$method_name = 'set' . $property;
			if (!method_exists($entity, $method_name)) {
				// if(!property_exists($entity, $property)){
				$message = sprintf('method "%s" not defined in %s', $method_name, get_class($entity));
				throw new DataMapperException($message);
			}
			$entity->$method_name($value);
		}
		return $entity;
	}

	/**
	 * Маппит поля объекта в массив
	 *
	 * @param Zf_Orm_Entity $entity
	 * @return array
	 */
	public function map(AbstractEntity $entity) {
		$array = array();
		foreach ($this->getMap() as $field => $property) {
			$array[$field] = $entity->$property;
		}
		return $array;
	}		

}

<?php

/**
 * Пример работы контролера работающего напрямую с моделемя
 */
class UserController {

	/**
	 * ServiceProvider
	 * @var type 
	 */
	protected $conteiner;

	/**
	 * Library for views
	 * @var type 
	 */
	protected $View;

	function getUsers($Request) {


		if ($id = $Request->get('id')) {

			$User = UserQuery::create()->findByPk($id);

			return $this->View('user_info', $User->toArray());
		}
	}

}

/**
 * UserQuery класс для получения User из бд
 * 
 * сгенерирован Propel
 * @method     UserQuery findByPk($pk) 
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) 
 */
class UserQuery extends Order\Base\UserQuery {}

/**
 * Модель
 * 
 * сгенерирован Propel
 * @method  User save() 
 * @method  User update() 
 * @method  User delete() 
 */
class User extends \User\Base\Order{}

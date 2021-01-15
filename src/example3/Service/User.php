<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Service;

/**
 * Description of User
 *
 * @author d.lanec
 */
class User {

	protected $userQuery;

	function __construct(\Model\UserQuery $UserQuery) {
		$this->userQuery = $userQuery;
	}

	/**
	 * получем по ключу
	 * @param type $id
	 * @return type
	 * @throws Exception
	 */
	public function getByid($id) {

		if ($User = $this->userQuery->findByPk($id)) {
			throw new Exception('User not find');
		}
		return $User;
	}

	/**
	 * сохраняем
	 * @param User $User
	 * @return boolean
	 * @throws Exception
	 */
	public function save(Model\User $User) {
		if (!$User->save($User)) {
			throw new Exception('User not save');
		}
		return true;
	}

}
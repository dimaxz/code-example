<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Repository;

/**
 * Description of User
 *
 * @author d.lanec
 */
class User {

	/**
	 * получение по ключу
	 * @param type $id
	 * @return type
	 */
	public function findByid($id) {
		return \Model\UserQuery::create()->findByPk($id);
	}

	/**
	 * Сохраняем
	 * 
	 * @param User $User
	 * @return type
	 */
	public function save(Model\User $User) {
		return $User->save();
	}

}

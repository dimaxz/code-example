<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

/**
 * Description of User
 *
 * @author d.lanec
 */
class User {

	/**
	 * ServiceProvider
	 * @var type 
	 */
	protected $userService;

	/**
	 * Library for views
	 * @var type 
	 */
	protected $View;

	function __construct(\League\Container\Container $conteiner) {
		$this->userService = $conteiner->get('user.service');
	}

	/**
	 * страница с информацией о пользоывателе
	 * @param type $Request
	 * @return type
	 */
	function getUsers(Request $Request) {

		if ($id = $Request->get('id')) {

			try {
				$User = $this->userService->getByid($id);
			} catch(Exception $exc) {

				return $exc->getMessage();
			}

			return $this->View('user_info', $User->toArray());
		}
	}

}
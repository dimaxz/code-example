<?php

namespace Example\User;

/**
 * Description of User
 *
 * @author Dmitriy
 */
class User extends \DataMapper\AbstractEntity {

	protected $name;

	protected $email;

	protected $password;

	function __construct($name, $email, $password) {
		$this
				->setEmail($email)
				->setfirstName($name)
				->setPassword($password)
		;
	}

	function getFirstName() {
		return $this->name;
	}

	function getEmail() {
		return $this->email;
	}

	function getPassword() {
		return $this->password;
	}

	function setFirstName($name) {
		$this->name = $name;
		return $this;
	}

	function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	public static function fromState(array $state) {
		return new self(
				$state['name'], $state['email'], $state['password']
		);
	}

}

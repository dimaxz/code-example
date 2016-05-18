<?php

/**
 * Поставщик сервисов
 */
class ServiceProvider extends AbstractServiceProvider {

	protected $provides = ['user.service'];

	public function register() {
		$this->getContainer()->add('user.service', \Service\User::class)
				->withArgument(new \Model\UserQuery());
	}

}
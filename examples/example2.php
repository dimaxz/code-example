<?php

/**
 * Пример работы контролера работающего с моделью через сервис и репозиторий с использованием контейнера
 */
class UserController {

	/**
	 * ServiceProvider
	 * @var type 
	 */
	protected $UserService;

	/**
	 * Library for views
	 * @var type 
	 */
	protected $View;

	function __construct(\League\Container\Container $conteiner) {
		$this->UserService = $conteiner->get('UserService');
	}

	/**
	 * страница с информацией о пользоывателе
	 * @param type $Request
	 * @return type
	 */
	function getUsers(Request $Request) {

		if ($id = $Request->get('id')) {

			try {
				$User = $this->UserService->getByid($id);
			} catch(Exception $exc) {

				return $exc->getMessage();
			}

			return $this->View('user_info', $User->toArray());
		}
	}

}

/**
 * Поставщик сервисов
 */
class ServiceProvider extends AbstractServiceProvider {

	protected $provides = ['UserService'];

	public function register() {
		$this->getContainer()->add('UserService', UserService::class)
				->withArgument(new UserRepository());
	}

}

/**
 * Седержит бизнес логику для работы с User
 */
class UserService {

	protected $UserRepository;

	function __construct(UserRepository $UserRepository) {
		$this->UserRepository = $UserRepository;
	}

	/**
	 * получем по ключу
	 * @param type $id
	 * @return type
	 * @throws Exception
	 */
	public function getByid($id) {

		if (!$User = $this->UserRepository->findById($id)) {
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
	public function save(User $User) {
		if (!$this->UserRepository->save()) {
			throw new Exception('User not save');
		}
		return true;
	}

}

/**
 * вся логика работы User с бд здесь
 */
class UserRepository {

	/**
	 * получение по ключу
	 * @param type $id
	 * @return type
	 */
	public function findByid($id) {
		return UserQuery::create()->findByPk($id);
	}

	/**
	 * Сохраняем
	 * 
	 * @param User $User
	 * @return type
	 */
	public function save(User $User) {
		return $User->save();
	}

}

/**
 * UserQuery класс для получения User из бд
 * 
 * сгенерирован Propel
 * @method     UserQuery findByPk($pk) 
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) 
 */
class UserQuery extends Order\Base\UserQuery {
	
}

/**
 * Модель User 
 * работает на измениение в бд
 * сгенерирован Propel
 * @method  User save() 
 * @method  User update() 
 * @method  User delete() 
 */
class User extends \User\Base\Order {
	
}

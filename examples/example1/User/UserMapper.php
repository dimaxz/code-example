<?php
namespace Example\User;

/**
 * Description of UserMapper
 *
 * @author Dmitriy
 */
class UserMapper extends \Example\AbstractDataMapper{

    public function __construct(){
	$this->setMap(
		array(
		    'id'	 => 'id',
		    'name'	 => 'firstName',
		    'email'	 => 'email',
		    'code'	 => 'password'
		)
	);
    }
}

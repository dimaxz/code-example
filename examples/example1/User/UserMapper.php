<?php
namespace Example\User;

/**
 * Description of UserMapper
 *
 * @author Dmitriy
 */
class UserMapper extends \Example\AbstractDataMapper{

    public function __construct(){
	$this
		->addMap('id')
		->addMap('name','firstName')
		->addMap('email')
		->addMap('code','password')
	;
    }
}

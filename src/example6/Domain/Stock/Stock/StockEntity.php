<?php


namespace Demo6\Domain\Stock\Stock;

use Demo6\Domain\Stock\User\UserEntity;

/**
 * Class UserEntity
 * @package Demo5\Domain\User
 */
class StockEntity
{

    protected $name;
    protected $email;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getUserById(): UserEntity{

    }


}
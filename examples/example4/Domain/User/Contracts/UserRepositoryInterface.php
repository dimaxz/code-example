<?php


namespace Domain\User\Contracts;

use Domain\User\UserCollection;
use Domain\User\UserEntity;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function findById(int $id):?UserEntity;

    /**
     * @param UserCriteriaInterface $criteria
     * @return UserCollection
     */
    public function findByCriteria(UserCriteriaInterface $criteria):UserCollection;
}
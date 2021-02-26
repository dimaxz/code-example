<?php


namespace Demo6\Domain\Stock\User\Contracts;

use Demo6\Domain\User\UserCollection;
use Demo6\Domain\User\UserEntity;

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

    public function save(UserEntity $entity): void ;
}
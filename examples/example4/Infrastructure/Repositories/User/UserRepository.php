<?php


namespace Infrastructure\Repositories\User;


use Domain\User\Contracts\UserCriteriaInterface;
use Domain\User\Contracts\UserRepositoryInterface;
use Domain\User\UserCollection;
use Domain\User\UserEntity;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?UserEntity
    {
        // TODO: Implement findById() method.
    }

    public function findByCriteria(UserCriteriaInterface $criteria): UserCollection
    {
        // TODO: Implement findByCriteria() method.
    }

}
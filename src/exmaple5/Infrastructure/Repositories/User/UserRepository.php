<?php


namespace Demo5\Infrastructure\Repositories\User;


use Demo4\Domain\User\Contracts\UserCriteriaInterface;
use Demo4\Domain\User\Contracts\UserRepositoryInterface;
use Demo4\Domain\User\UserCollection;
use Demo4\Domain\User\UserEntity;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?UserEntity
    {
        return null;
    }

    public function findByCriteria(UserCriteriaInterface $criteria): UserCollection
    {
        return new UserCollection();
    }

    public function save(UserEntity $entity): void
    {
        // TODO: Implement save() method.
    }


}
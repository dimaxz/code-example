<?php


namespace Demo6\Domain\Stock\Stock\Contracts;

use Demo6\Domain\Stock\UserCollection;
use Demo6\Domain\Stock\UserEntity;

interface StockRepositoryInterface
{
    /**
     * @param int $id
     * @return UserEntity|null
     */
    public function findById(int $id):?StockEntity;

    /**
     * @param UserCriteriaInterface $criteria
     * @return UserCollection
     */
    public function findByCriteria(StockCriteriaInterface $criteria):StockCollection;

    public function save(UserEntity $entity): void ;
}
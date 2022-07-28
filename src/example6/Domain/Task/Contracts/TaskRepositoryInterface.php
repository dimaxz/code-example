<?php

namespace Demo\Domain\Task\Contracts;

interface TaskRepositoryInterface
{
    public function findByCriteria(TaskSearchCriteriaInterface $criteria): array;
}
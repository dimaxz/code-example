<?php


namespace Demo5\Domain\User\Contracts;




interface UserCriteriaInterface
{

    public function filterByName(?string $name);

    public function filterById(?string $id);

    public function filterByEmail(?string $email);

}
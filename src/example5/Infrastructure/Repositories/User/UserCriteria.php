<?php


namespace Demo5\Infrastructure\Repositories\User;


use Demo5\Domain\User\Contracts\UserCriteriaInterface;

class UserCriteria implements UserCriteriaInterface
{
    protected $filterByName;
    protected $filterByEmail;
    protected $filterById;

    public function filterByName(?string $name)
    {
        return $this->filterByName;
    }

    public function filterById(?string $id)
    {
        return $this->filterById;
    }

    public function filterByEmail(?string $email)
    {
        return $this->filterByEmail;
    }

    /**
     * @param mixed $filterByName
     * @return UserCriteria
     */
    public function setFilterByName($filterByName)
    {
        $this->filterByName = $filterByName;
        return $this;
    }

    /**
     * @param mixed $filterByEmail
     * @return UserCriteria
     */
    public function setFilterByEmail($filterByEmail)
    {
        $this->filterByEmail = $filterByEmail;
        return $this;
    }

    /**
     * @param mixed $filterById
     * @return UserCriteria
     */
    public function setFilterById($filterById)
    {
        $this->filterById = $filterById;
        return $this;
    }


}
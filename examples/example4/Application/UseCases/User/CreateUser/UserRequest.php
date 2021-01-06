<?php


namespace Application\UseCases\CreateUser;


class UserRequest
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UserRequest
     */
    public function setName(string $name): UserRequest
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserRequest
     */
    public function setEmail(string $email): UserRequest
    {
        $this->email = $email;
        return $this;
    }


}
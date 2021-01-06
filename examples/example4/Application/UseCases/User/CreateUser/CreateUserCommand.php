<?php


namespace Application\UseCases\CreateUser;


class CreateUserCommand
{

    protected $userRequest;

    protected $userResult;

    public function __construct(UserRequest $userRequest, UserResult $userResult)
    {
        $this->userRequest = $userRequest;
        $this->userResult = $userResult;
    }

    /**
     * @return UserRequest
     */
    public function getUserRequest(): UserRequest
    {
        return $this->userRequest;
    }


    /**
     * @return UserResult
     */
    public function getUserResult(): UserResult
    {
        return $this->userResult;
    }


}
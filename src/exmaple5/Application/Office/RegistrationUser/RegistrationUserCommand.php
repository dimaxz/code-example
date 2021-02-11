<?php


namespace Demo4\Application\Commands\Registration\RegistrationUser;


class RegistrationUserCommand
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
     * @var int
     */
    protected $sourceId;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return RegistrationUserCommand
     */
    public function setName(string $name): RegistrationUserCommand
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
     * @return RegistrationUserCommand
     */
    public function setEmail(string $email): RegistrationUserCommand
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int
     */
    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    /**
     * @param int $sourceId
     * @return RegistrationUserCommand
     */
    public function setSourceId(int $sourceId): RegistrationUserCommand
    {
        $this->sourceId = $sourceId;
        return $this;
    }



}
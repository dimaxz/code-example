<?php


namespace Demo4\Application\Commands\Registration\RegistrationUser;


class UserResult
{
    /**
     * @var int
     */
    protected $sourceId;

    /**
     * @return int
     */
    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    /**
     * @param int $sourceId
     * @return UserResult
     */
    public function setSourceId(int $sourceId): UserResult
    {
        $this->sourceId = $sourceId;
        return $this;
    }

}
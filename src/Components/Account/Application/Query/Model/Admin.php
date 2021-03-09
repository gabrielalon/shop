<?php

namespace App\Components\Account\Application\Query\Model;

class Admin
{
    /** @var string */
    private string $id;

    /** @var string */
    private string $userId;

    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /** @var string */
    private string $email;

    /** @var AdminAvatar */
    private AdminAvatar $avatar;

    /**
     * Admin constructor.
     *
     * @param string      $id
     * @param string      $userId
     * @param string      $firstName
     * @param string      $lastName
     * @param string      $email
     * @param AdminAvatar $avatar
     */
    public function __construct(
        string $id,
        string $userId,
        string $firstName,
        string $lastName,
        string $email,
        AdminAvatar $avatar
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return AdminAvatar
     */
    public function avatar(): AdminAvatar
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return sprintf('%s %s', $this->firstName(), $this->lastName());
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isOfUser(User $user): bool
    {
        return $this->userId === $user->id();
    }
}

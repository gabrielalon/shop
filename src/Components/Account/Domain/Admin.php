<?php

namespace App\Components\Account\Domain;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing as VO;

final class Admin extends AggregateRoot
{
    /** @var Valuing\Name */
    private $name;

    /** @var VO\Char\Text */
    private $email;

    /** @var VO\Identity\Uuid */
    private $userId;

    /**
     * @param VO\Identity\Uuid $id
     *
     * @return Admin
     */
    public function setId(VO\Identity\Uuid $id): Admin
    {
        $this->setAggregateId($id);

        return $this;
    }

    /**
     * @param Valuing\Name $name
     *
     * @return Admin
     */
    public function setName(Valuing\Name $name): Admin
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param VO\Char\Text $email
     *
     * @return Admin
     */
    public function setEmail(VO\Char\Text $email): Admin
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid $userId
     *
     * @return $this
     */
    public function setUserId(VO\Identity\Uuid $userId): Admin
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param string $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $userId
     *
     * @return Admin
     */
    public static function create(
        string $id,
        string $firstName,
        string $lastName,
        string $email,
        string $userId
    ): Admin {
        $admin = new static();

        $admin->recordThat(Event\AdminCreated::occur($id, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'user_id' => $userId,
        ]));

        return $admin;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function changeName(string $firstName, string $lastName): void
    {
        $this->recordThat(Event\AdminNameChanged::occur($this->aggregateId(), [
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\AdminRemoved::occur($this->aggregateId()));
    }
}

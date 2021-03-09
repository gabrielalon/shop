<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\User;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;

class UserCreated extends UserEvent
{
    /**
     * @return Text
     */
    public function userLogin(): Text
    {
        return Text::fromString($this->payload['login']);
    }

    /**
     * @return Text
     */
    public function userPassword(): Text
    {
        return Text::fromString($this->payload['password']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var User $user */
        $user = $aggregateRoot;

        $user->setId($this->userId());
        $user->setLogin($this->userLogin());
        $user->setPassword($this->userPassword());
    }
}

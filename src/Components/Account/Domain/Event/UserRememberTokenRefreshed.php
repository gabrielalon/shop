<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\User;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;

class UserRememberTokenRefreshed extends UserEvent
{
    /**
     * @return Text
     */
    public function userRememberToken(): Text
    {
        return Text::fromString($this->payload['remember_token']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var User $user */
        $user = $aggregateRoot;

        $user->setRememberToken($this->userRememberToken());
    }
}

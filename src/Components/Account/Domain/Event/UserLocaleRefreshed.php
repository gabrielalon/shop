<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\User;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Intl\Language\Code;

class UserLocaleRefreshed extends UserEvent
{
    /**
     * @return Code
     */
    public function userLocale(): Code
    {
        return Code::fromCode($this->payload['locale']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        /** @var User $user */
        $user = $aggregateRoot;

        $user->setLocale($this->userLocale());
    }
}

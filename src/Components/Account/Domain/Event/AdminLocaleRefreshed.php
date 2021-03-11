<?php

namespace App\Components\Account\Domain\Event;

use App\Components\Account\Domain\Admin;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Intl\Language\Code;

final class AdminLocaleRefreshed extends AdminEvent
{
    /**
     * @return Code
     */
    public function adminLocale(): Code
    {
        return Code::fromCode($this->payload['locale']);
    }

    /**
     * {@inheritdoc}
     */
    public function populate(AggregateRoot $aggregateRoot): void
    {
        $user = $aggregateRoot;

        assert($user instanceof Admin);

        $user->setLocale($this->adminLocale());
    }
}

<?php

namespace App\Components\Account\Application\Widget;

use App\Components\Account\Application\Query\UserQuery;

class UserWidget
{
    /** @var UserQuery */
    private UserQuery $query;

    /**
     * UserWidget constructor.
     *
     * @param UserQuery $query
     */
    public function __construct(UserQuery $query)
    {
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function totalUserCount(): int
    {
        return $this->query->totalUserCount();
    }
}

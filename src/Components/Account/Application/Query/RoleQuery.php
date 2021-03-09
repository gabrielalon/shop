<?php

namespace App\Components\Account\Application\Query;

use App\Components\Account\Application\Query\Model\RoleCollection;
use App\System\Messaging\Query\Query;

interface RoleQuery extends Query
{
    /**
     * @return RoleCollection
     */
    public function findAllRoles(): RoleCollection;
}

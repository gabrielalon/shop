<?php

namespace App\Components\Account\Domain;

use App\Components\Account\Application\Query\AdminQuery;

class AdminSpecification
{
    /** @var AdminQuery */
    private $adminQuery;

    /**
     * AdminSpecification constructor.
     *
     * @param AdminQuery $adminQuery
     */
    public function __construct(AdminQuery $adminQuery)
    {
        $this->adminQuery = $adminQuery;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isUniqueEmailSatisfied(string $email): bool
    {
        return $this->adminQuery->existsAdminByEmail($email);
    }
}

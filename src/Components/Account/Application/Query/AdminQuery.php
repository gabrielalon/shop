<?php

namespace App\Components\Account\Application\Query;

use App\Components\Account\Application\Query\Exception\AdminNotFoundException;
use App\Components\Account\Application\Query\Model\Admin;
use App\Components\Account\Application\Query\Model\AdminCollection;
use App\System\Messaging\Query\Query;

interface AdminQuery extends Query
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function existsAdminByEmail(string $email): bool;

    /**
     * @param string $id
     *
     * @return Admin
     *
     * @throws AdminNotFoundException
     */
    public function findAdminById(string $id): Admin;

    /**
     * @param string $userId
     *
     * @return Admin
     *
     * @throws AdminNotFoundException
     */
    public function findAdminByUserId(string $userId): Admin;

    /**
     * @return AdminCollection
     */
    public function findAdminCollection(): AdminCollection;
}

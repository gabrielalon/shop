<?php

namespace App\Components\Account\Domain\Persist;

use App\Components\Account\Domain\Admin;

interface AdminRepository
{
    /**
     * @param string $id
     *
     * @return Admin
     */
    public function find(string $id): Admin;

    /**
     * @param Admin $admin
     */
    public function flush(Admin $admin): void;
}

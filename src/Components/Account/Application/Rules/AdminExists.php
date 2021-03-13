<?php

namespace App\Components\Account\Application\Rule;

use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use Illuminate\Contracts\Validation\ImplicitRule;

final class AdminExists implements ImplicitRule
{
    /** @var AdminEntity */
    private AdminEntity $db;

    /**
     * AdminExists constructor.
     * @param AdminEntity $db
     */
    public function __construct(AdminEntity $db)
    {
        $this->db = $db;
    }

    /**
     * @return AdminExists
     */
    public static function prepare(): AdminExists
    {
        return new self(new AdminEntity());
    }

    /**
     * {@inheritDoc}
     */
    public function passes($attribute, $value): bool
    {
        return $this->db->newQuery()
            ->join('user', 'admin.user_id', '=', 'user.id')
            ->where('user.email', '=', $value)
            ->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function message(): string
    {
        return 'The :attribute not exist';
    }
}

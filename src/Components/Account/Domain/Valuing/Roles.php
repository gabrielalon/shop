<?php

namespace App\Components\Account\Domain\Valuing;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Valuing\VO;

final class Roles extends VO
{
    /** @var RoleEnum[] */
    private $roles;

    /**
     * @param array $roles
     *
     * @return Roles
     */
    public static function fromRoles(array $roles): Roles
    {
        return new static($roles);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        $this->roles = [];

        foreach ($value as $role) {
            $this->roles[] = new RoleEnum($role);
        }
    }

    /**
     * @return array
     */
    public function roles(): array
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = $role->getValue();
        }

        return $roles;
    }
}

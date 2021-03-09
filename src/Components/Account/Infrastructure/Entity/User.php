<?php

namespace App\Components\Account\Infrastructure\Entity;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string     $id'
 * @property string     $name
 * @property string     $login
 * @property string     $password
 * @property string     $remember_token
 * @property string     $locale
 * @property Collection $roles
 * @property Collection $permissions
 */
class User extends Eloquent implements HasUuid
{
    use HasFactory;
    use HasUuidTrait;
    use SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'user';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_role',
            'user_id',
            'role_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'user_permission',
            'user_id',
            'permission_id'
        );
    }

    /**
     * @return string[]
     */
    public function roleTypes(): array
    {
        return $this->roles()
            ->where('is_active', true)
            ->orderBy('level')
            ->pluck('type')
            ->toArray()
        ;
    }

    /**
     * @param RoleEnum $role
     *
     * @return bool
     */
    public function hasRole(RoleEnum $role): bool
    {
        return $this->roles()->where('type', '=', $role->getValue())->exists();
    }

    /**
     * @return string[]
     */
    public function permissionTypes(): array
    {
        $permission = $this->permissions()
            ->where('is_active', true)
            ->pluck('type')
            ->toArray()
        ;

        /** @var Role $role */
        foreach ($this->roles()->where('is_active', true)->get() as $role) {
            $permission = array_merge($permission, $role->permissionTypes());
        }

        return array_unique($permission);
    }
}

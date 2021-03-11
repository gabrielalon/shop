<?php

namespace App\Components\Account\Infrastructure\Entity;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Enum\StateEnum;
use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string      $id
 * @property string      $state_id
 * @property string      $login
 * @property string      $password
 * @property string      $email
 * @property Carbon|null $email_verified_at
 * @property string      $phone
 * @property Carbon|null $phone_verified_at
 * @property string      $remember_token
 * @property string      $locale
 * @property Collection  $roles
 * @property Collection  $permissions
 *
 * @method static User|null findByUuid(string $uuid)
 */
final class User extends Eloquent implements HasUuid
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

    /** @var string[] */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    /**
     * @return HasOne
     */
    public function state(): HasOne
    {
        return $this->hasOne(
            State::class,
            'id',
            'state_id'
        );
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
     * @return HasMany
     */
    public function userRoles(): HasMany
    {
        return $this->hasMany(
            UserRole::class,
            'user_id',
            'id'
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
     * @param string[] $roles
     */
    public function assignRoles(array $roles): void
    {
        $this->userRoles()->delete();
        foreach ($roles as $role) {
            $this->userRoles()->create([
                'role_id' => Role::findByType(new RoleEnum($role))->id,
            ]);
        }
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

    /**
     * @param string $id
     * @param string $login
     * @param string $password
     *
     * @return User
     *
     * @throws BindingResolutionException
     */
    public static function createFromLogin(string $id, string $login, string $password): User
    {
        $entity = self::query()->create([
            'id' => $id,
            'state_id' => State::findByType(StateEnum::INACTIVE())->id,
            'login' => $login,
            'email_verified_at' => null,
            'password' => $password,
            'locale' => locale()->current(),
        ]);

        assert($entity instanceof self);

        return $entity;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return User
     *
     * @throws BindingResolutionException
     */
    public static function createFromEmail(string $email, string $password): User
    {
        $entity = self::query()->create([
            'state_id' => State::findByType(StateEnum::INACTIVE())->id,
            'login' => $email,
            'email' => $email,
            'email_verified_at' => null,
            'password' => $password,
            'locale' => locale()->current(),
        ]);

        assert($entity instanceof self);

        return $entity;
    }
}

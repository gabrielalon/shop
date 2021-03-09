<?php

namespace App\Components\Account\Infrastructure\Entity;

use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string     $id
 * @property string     $type
 * @property string     $guard
 * @property bool       $is_active
 * @property int        $level
 * @property Collection $users
 * @property Collection $permissions
 */
class Role extends Eloquent implements HasUuid, TranslatableContract
{
    use HasUuidTrait;
    use Translatable;

    /** @var string[] */
    public $translatedAttributes = ['description'];

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'role';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /** @var string[] */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_role',
            'role_id',
            'user_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permission',
            'role_id',
            'permission_id'
        );
    }

    /**
     * @return string[]
     */
    public function permissionTypes(): array
    {
        return $this->permissions()
            ->where('is_active', true)
            ->pluck('type')
            ->toArray()
        ;
    }

    /**
     * @return string[]
     */
    public function descriptions(): array
    {
        $descriptions = [];

        /** @var RoleTranslation $translation */
        foreach ($this->translations->all() as $translation) {
            $descriptions[$translation->locale] = $translation->description;
        }

        return $descriptions;
    }
}

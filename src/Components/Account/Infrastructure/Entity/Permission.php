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
 * @property bool       $is_active
 * @property Collection $users
 * @property Collection $roles
 */
class Permission extends Eloquent implements HasUuid, TranslatableContract
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
    protected $table = 'permission';

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
            'user_permission',
            'permission_id',
            'user_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'role_permission',
            'permission_id',
            'role_id'
        );
    }
}

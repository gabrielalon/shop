<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string     $id
 * @property bool       $is_active
 * @property string     $alias
 * @property Collection $domains
 */
class Site extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'site';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function domains(): HasMany
    {
        return $this->hasMany(
            SiteDomain::class,
            'site_id',
            'id'
        );
    }
}

<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $id
 * @property string $site_id
 * @property string $domain_url
 * @property Site   $site
 */
class SiteDomain extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'site_domain';

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(
            Site::class,
            'id',
            'site_id'
        );
    }
}

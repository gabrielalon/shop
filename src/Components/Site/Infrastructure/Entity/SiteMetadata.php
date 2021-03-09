<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $site_id
 * @property string $country_code
 * @property string $currency_code
 * @property string $language_code
 * @property bool   $is_default
 */
class SiteMetadata extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'site_metadata';

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'is_default' => 'boolean',
    ];
}

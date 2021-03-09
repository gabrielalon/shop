<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $site_id
 * @property string $currency_base_code
 * @property string $currency_target_code
 * @property float  $rate
 */
class SiteCurrencyRate extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'site_currency_rate';

    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $casts = [
        'rate' => 'float',
    ];
}

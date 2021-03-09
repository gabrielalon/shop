<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $country_code
 * @property string $currency_code
 */
class CountryCurrency extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'country_currency';

    /** @var array */
    protected $guarded = [];
}

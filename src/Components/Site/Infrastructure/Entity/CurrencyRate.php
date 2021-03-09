<?php

namespace App\Components\Site\Infrastructure\Entity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $currency_base_code
 * @property string $currency_target_code
 * @property Carbon $date_exchange
 * @property Carbon $date
 * @property float  $rate
 */
final class CurrencyRate extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'currency';

    /** @var array */
    protected $guarded = [];

    /** @var string[] */
    protected $casts = [
        'date_exchange' => 'date',
        'date' => 'date',
    ];
}

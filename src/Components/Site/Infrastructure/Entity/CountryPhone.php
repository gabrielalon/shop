<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string  $country_code
 * @property string  $prefix
 * @property Country $country
 */
class CountryPhone extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'country_phone';

    /** @var string */
    protected $primaryKey = 'country_code';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(
            Country::class,
            'code',
            'country_code'
        );
    }
}

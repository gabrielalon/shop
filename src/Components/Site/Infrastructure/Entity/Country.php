<?php

namespace App\Components\Site\Infrastructure\Entity;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string     $code
 * @property string     $continent_code
 * @property string     $native_name
 * @property Collection $phones
 * @property Collection $languages
 * @property Collection $currencies
 */
class Country extends Eloquent implements TranslatableContract
{
    use Translatable;

    /** @var string[] */
    public $translatedAttributes = ['name'];

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'country';

    /** @var string */
    protected $primaryKey = 'code';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function phones(): HasMany
    {
        return $this->hasMany(
            CountryPhone::class,
            'country_code',
            'code'
        );
    }

    /**
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this->hasMany(
            CountryLanguage::class,
            'country_code',
            'code'
        );
    }

    /**
     * @return HasMany
     */
    public function currencies(): HasMany
    {
        return $this->hasMany(
            CountryCurrency::class,
            'country_code',
            'code'
        );
    }
}

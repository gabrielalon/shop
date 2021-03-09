<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $country_code
 * @property string $language_code
 */
class CountryLanguage extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'country_language';

    /** @var array */
    protected $guarded = [];
}

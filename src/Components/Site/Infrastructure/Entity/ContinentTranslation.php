<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $continent_code
 * @property string $locale
 * @property string $name
 */
class ContinentTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'continent_translation';

    /** @var array */
    protected $guarded = [];
}

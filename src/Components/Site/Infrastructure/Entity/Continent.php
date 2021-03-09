<?php

namespace App\Components\Site\Infrastructure\Entity;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string $code
 */
class Continent extends Eloquent implements TranslatableContract
{
    use Translatable;

    /** @var string[] */
    public $translatedAttributes = ['name'];

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'continent';

    /** @var string */
    protected $primaryKey = 'code';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];
}

<?php

namespace App\Components\Site\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string $code
 */
class Currency extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'currency';

    /** @var string */
    protected $primaryKey = 'code';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];
}

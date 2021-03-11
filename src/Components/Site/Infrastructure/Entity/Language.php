<?php

namespace App\Components\Site\Infrastructure\Entity;

use App\System\Eloquent\Contracts\HasCode;
use App\System\Eloquent\Contracts\HasCodeTrait;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string $code
 * @property string $native_name
 *
 * @method static Language|null findByCode(string $code)
 */
class Language extends Eloquent implements HasCode
{
    use HasCodeTrait;

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'language';

    /** @var string */
    protected $primaryKey = 'code';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];
}

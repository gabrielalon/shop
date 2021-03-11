<?php

namespace App\Components\Account\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $state_id
 * @property string $locale
 * @property string $name
 */
final class StateTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'state_translation';

    /** @var array */
    protected $guarded = [];
}

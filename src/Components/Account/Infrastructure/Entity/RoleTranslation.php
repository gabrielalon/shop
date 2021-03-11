<?php

namespace App\Components\Account\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $role_id
 * @property string $locale
 * @property string $description
 */
final class RoleTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'role_translation';

    /** @var array */
    protected $guarded = [];
}

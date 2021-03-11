<?php

namespace App\Components\Account\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $permission_id
 * @property string $locale
 * @property string $description
 */
final class PermissionTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'permission_translation';

    /** @var array */
    protected $guarded = [];
}

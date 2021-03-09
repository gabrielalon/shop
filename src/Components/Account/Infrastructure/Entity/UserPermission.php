<?php

namespace App\Components\Account\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $user_id
 * @property string $permission_id
 */
class UserPermission extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'user_permission';

    /** @var array */
    protected $guarded = [];
}

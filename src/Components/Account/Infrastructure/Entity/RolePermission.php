<?php

namespace App\Components\Account\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $role_id
 * @property string $permission_id
 */
final class RolePermission extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'role_permission';

    /** @var array */
    protected $guarded = [];
}

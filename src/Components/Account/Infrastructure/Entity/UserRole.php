<?php

namespace App\Components\Account\Infrastructure\Entity;

use Database\Factories\UserRoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $user_id
 * @property string $role_id
 */
class UserRole extends Eloquent
{
    use HasFactory;

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'user_role';

    /** @var array */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory()
    {
        return UserRoleFactory::new();
    }
}

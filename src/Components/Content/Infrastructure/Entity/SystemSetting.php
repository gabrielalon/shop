<?php

namespace App\Components\Content\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $key
 * @property string $data_type
 * @property string $data
 */
class SystemSetting extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'system_setting';

    /** @var array */
    protected $guarded = [];
}

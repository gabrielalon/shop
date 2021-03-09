<?php

namespace App\System\Messaging\Integration\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $aggregate_id
 * @property string $aggregate_type
 * @property string $aggregate
 * @property int    $last_version
 */
class SnapshotEntity extends Model
{
    /** @var string */
    protected $table = 'snapshot_storage';

    /** @var bool */
    public $timestamps = false;

    /** @var array */
    protected $guarded = [];
}

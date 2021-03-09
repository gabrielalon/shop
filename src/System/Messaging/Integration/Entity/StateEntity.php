<?php

namespace App\System\Messaging\Integration\Entity;

use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string $id
 * @property string $aggregate_id
 * @property string $saga_type
 * @property bool   $is_done
 * @property string $scenario_name
 * @property array  $payload
 * @property Carbon $recorded_on
 */
class StateEntity extends Eloquent implements HasUuid
{
    use HasUuidTrait;

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'state_storage';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /** @var string[] */
    protected $casts = [
        'is_done' => 'boolean',
        'payload' => 'array',
        'recorded_on' => 'date',
    ];
}

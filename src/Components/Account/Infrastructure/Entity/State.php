<?php

namespace App\Components\Account\Infrastructure\Entity;

use App\Components\Account\Domain\Enum\StateEnum;
use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property string $id
 * @property string $type
 */
final class State extends Eloquent implements HasUuid, TranslatableContract
{
    use HasUuidTrait;
    use Translatable;

    /** @var string[] */
    public array $translatedAttributes = ['name'];

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'state';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /**
     * @param StateEnum $type
     *
     * @return State
     */
    public static function findByType(StateEnum $type): State
    {
        $entity = self::query()->firstOrCreate(['type' => $type->getValue()]);

        assert($entity instanceof self);

        return $entity;
    }
}

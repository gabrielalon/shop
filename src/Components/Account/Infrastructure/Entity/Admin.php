<?php

namespace App\Components\Account\Infrastructure\Entity;

use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use App\System\Spatie\Media\MediaEnum;
use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_id
 * @property User   $user
 *
 * @method static Admin|null findByUuid(string $uuid)
 */
final class Admin extends Eloquent implements HasUuid, HasMedia
{
    use HasFactory;
    use HasUuidTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $table = 'admin';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id',
            'user_id'
        );
    }

    /**
     * @param Media|null $media
     *
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion(MediaEnum::AVATAR()->getValue())
            ->quality(80)
            ->withResponsiveImages()
        ;
    }
}

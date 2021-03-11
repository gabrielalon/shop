<?php

namespace App\Components\Content\Infrastructure\Entity;

use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Carbon\Carbon;
use Database\Factories\BlogEntryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string     $id
 * @property bool       $is_active
 * @property Carbon     $publish_at
 * @property Collection $categories
 * @property Collection $withCategories
 *
 * @method static BlogEntry|null findByUuid(string $uuid)
 */
final class BlogEntry extends Eloquent implements HasUuid, TranslatableContract
{
    use Translatable;
    use HasFactory;
    use HasUuidTrait;
    use SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** @var string[] */
    public array $translatedAttributes = ['name', 'description'];

    /** @var string */
    protected $table = 'blog_entry';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /** @var string[] */
    protected $casts = [
        'is_active' => 'boolean',
        'publish_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory(): BlogEntryFactory
    {
        return BlogEntryFactory::new();
    }

    /**
     * @return HasManyThrough
     */
    public function categories(): HasManyThrough
    {
        return $this->hasManyThrough(
            BlogCategory::class,
            BlogEntryWithCategory::class,
            'blog_entry_id',
            'id',
            'id',
            'blog_category_id'
        );
    }

    /**
     * @return HasMany
     */
    public function withCategories(): HasMany
    {
        return $this->hasMany(
            BlogEntryWithCategory::class,
            'blog_entry_id',
            'id'
        );
    }

    /**
     * @return string[]
     */
    public function name(): array
    {
        $names = [];

        foreach (LocaleEnum::values() as $locale) {
            $names[$locale->getValue()] = $this->getTranslationOrNew($locale)->getAttributeValue('name');
        }

        return $names;
    }

    /**
     * @return string[]
     */
    public function description(): array
    {
        $names = [];

        foreach (LocaleEnum::values() as $locale) {
            $names[$locale->getValue()] = $this->getTranslationOrNew($locale)->getAttributeValue('description');
        }

        return $names;
    }
}

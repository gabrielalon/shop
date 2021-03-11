<?php

namespace App\Components\Content\Infrastructure\Entity;

use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Eloquent\Contracts\HasUuid;
use App\System\Eloquent\Contracts\HasUuidTrait;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Database\Factories\BlogCategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string       $id
 * @property BlogCategory $parent
 * @property string       $parent_id
 * @property bool         $is_active
 * @property int          $position
 * @property Collection   $children
 *
 * @method static BlogCategory|null findByUuid(string $uuid)
 */
final class BlogCategory extends Eloquent implements HasUuid, TranslatableContract
{
    use Translatable;
    use HasFactory;
    use HasUuidTrait;
    use SoftDeletes;

    /** @var bool */
    public $incrementing = false;

    /** @var string[] */
    public array $translatedAttributes = ['name'];

    /** @var string */
    protected $table = 'blog_category';

    /** @var string */
    protected $keyType = 'string';

    /** @var array */
    protected $guarded = [];

    /** @var string[] */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * {@inheritdoc}
     */
    protected static function newFactory(): BlogCategoryFactory
    {
        return BlogCategoryFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    /**
     * @return string[]
     */
    public function name(): array
    {
        $names = [];

        foreach (LocaleEnum::values() as $locale) {
            $names[$locale->getValue()] = $this->getTranslationOrNew($locale->getValue())->getAttributeValue('name');
        }

        return $names;
    }

    /**
     * @throws \Exception
     */
    public function remove(): void
    {
        /** @var BlogCategory $child */
        foreach ($this->children()->get()->all() as $child) {
            $child->remove();
        }

        $this->delete();
    }
}

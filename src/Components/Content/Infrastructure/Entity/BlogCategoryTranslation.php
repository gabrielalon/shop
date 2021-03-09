<?php

namespace App\Components\Content\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int          $id
 * @property BlogCategory $category
 * @property string       $blog_category_id
 * @property string       $locale
 * @property string       $name
 */
class BlogCategoryTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'blog_category_translation';

    /** @var array */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            BlogCategory::class,
            'id',
            'blog_category_id'
        );
    }
}

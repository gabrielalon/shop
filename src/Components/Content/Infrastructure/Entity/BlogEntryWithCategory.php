<?php

namespace App\Components\Content\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int          $id
 * @property BlogCategory $category
 * @property string       $blog_category_id
 * @property BlogEntry    $entry
 * @property string       $blog_entry_id
 */
class BlogEntryWithCategory extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'blog_entry_with_category';

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

    /**
     * @return BelongsTo
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(
            BlogEntry::class,
            'id',
            'blog_entry_id'
        );
    }
}

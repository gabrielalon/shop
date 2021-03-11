<?php

namespace App\Components\Content\Infrastructure\Entity;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int       $id
 * @property BlogEntry $entry
 * @property string    $blog_entry_id
 * @property string    $locale
 * @property string    $name
 * @property string    $description
 */
final class BlogEntryTranslation extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'blog_entry_translation';

    /** @var array */
    protected $guarded = [];

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

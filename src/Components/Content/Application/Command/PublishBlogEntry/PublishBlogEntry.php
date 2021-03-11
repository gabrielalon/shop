<?php

namespace App\Components\Content\Application\Command\PublishBlogEntry;

use App\Components\Content\Application\Command\BlogEntryCommand;
use Carbon\Carbon;

final class PublishBlogEntry extends BlogEntryCommand
{
    /** @var Carbon */
    private $publishAt;

    /**
     * PublishBlogEntry constructor.
     *
     * @param string $id
     * @param Carbon $publishAt
     */
    public function __construct(string $id, Carbon $publishAt)
    {
        $this->setId($id);
        $this->publishAt = $publishAt;
    }

    /**
     * @return Carbon
     */
    public function publishAt(): Carbon
    {
        return $this->publishAt;
    }
}

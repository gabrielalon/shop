<?php

namespace App\Components\Content\Application\Query\Exception;

use App\System\Messaging\Query\Exception\ModelNotFoundException;

class BlogEntryNotFoundException extends ModelNotFoundException
{
    /**
     * @param string $id
     *
     * @return BlogEntryNotFoundException
     */
    public static function fromId(string $id): BlogEntryNotFoundException
    {
        $message = sprintf('Blog entry not found for given id %s', $id);

        return new self($message, 404);
    }
}

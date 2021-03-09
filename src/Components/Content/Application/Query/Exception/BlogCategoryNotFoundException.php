<?php

namespace App\Components\Content\Application\Query\Exception;

use App\System\Messaging\Query\Exception\ModelNotFoundException;

class BlogCategoryNotFoundException extends ModelNotFoundException
{
    /**
     * @param string $id
     *
     * @return BlogCategoryNotFoundException
     */
    public static function fromId(string $id): BlogCategoryNotFoundException
    {
        $message = sprintf('Blog category not found for given id %s', $id);

        return new self($message, 404);
    }
}

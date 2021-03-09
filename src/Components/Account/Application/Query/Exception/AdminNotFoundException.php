<?php

namespace App\Components\Account\Application\Query\Exception;

use App\System\Messaging\Query\Exception\ModelNotFoundException;

class AdminNotFoundException extends ModelNotFoundException
{
    /**
     * @param string $id
     *
     * @return AdminNotFoundException
     */
    public static function fromId(string $id): AdminNotFoundException
    {
        $message = sprintf('Admin not found for given id %s', $id);

        return new self($message, 404);
    }
}

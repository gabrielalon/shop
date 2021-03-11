<?php

namespace App\System\Valuing\Identity\Utils;

use App\System\Valuing\Identity;
use ArrayIterator;
use InvalidArgumentException;

final class Collection extends ArrayIterator
{
    /**
     * @param Identity\Uuid $uuid
     */
    public function add(Identity\Uuid $uuid): void
    {
        $this->offsetSet($uuid->toString(), $uuid);
    }

    /**
     * @param Collection $other
     *
     * @return bool
     */
    public function equals($other): bool
    {
        if (false == $other instanceof Collection) {
            return false;
        }

        foreach ($this->getArrayCopy() as $uuid => $value) {
            assert($value instanceof Identity\Uuid);

            try {
                $otherValue = $other->get($uuid);
            } catch (InvalidArgumentException $e) {
                return false;
            }

            if (false === $value->equals($otherValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $uuid
     *
     * @return Identity\Uuid
     *
     * @throws InvalidArgumentException
     */
    public function get(string $uuid): Identity\Uuid
    {
        if (false === $this->offsetExists($uuid)) {
            throw new InvalidArgumentException('Not Found Uuid string: '.$uuid, 500);
        }

        return $this->offsetGet($uuid);
    }
}

<?php

namespace App\System\Valuing\Identity;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Valuing\VO;
use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

final class Uuid extends VO implements AggregateId
{
    /**
     * @param string $uuid
     *
     * @return Uuid
     *
     * @throws InvalidArgumentException
     */
    public static function fromIdentity(string $uuid): Uuid
    {
        return new self($uuid);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($uuid): void
    {
        Assertion::uuid($uuid, 'Invalid Uuid string: '.$uuid);
    }
}

<?php

namespace App\System\Valuing\Char;

use App\System\Valuing\VO;
use function filter_var;
use InvalidArgumentException;

final class Email extends VO
{
    /**
     * @param string $email
     *
     * @return Email
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $email): Email
    {
        return new self($email);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($email): void
    {
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid Email string: '.$email);
        }
    }
}

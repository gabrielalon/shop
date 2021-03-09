<?php

namespace App\System\Valuing\Char;

use App\System\Valuing\VO;
use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

final class Content extends VO implements Char
{
    /**
     * @param string $content
     *
     * @return Content
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $content): Content
    {
        return new self($content);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($content): void
    {
        Assertion::string($content, 'Invalid Content string: '.$content);
        Assertion::maxLength(
            $content,
            $this->maxLength(),
            sprintf('Invalid Content string length (%d)', $this->maxLength())
        );
    }

    /**
     * @return int
     */
    protected function maxLength(): int
    {
        return 2 ** 32;
    }
}

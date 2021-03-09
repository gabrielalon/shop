<?php

namespace App\System\Spatie\Media;

class MediaException extends \RuntimeException
{
    /**
     * @param \Throwable $exception
     *
     * @throws MediaException
     */
    public static function throwFromException(\Throwable $exception): void
    {
        throw new self($exception->getMessage(), $exception->getCode(), $exception);
    }
}

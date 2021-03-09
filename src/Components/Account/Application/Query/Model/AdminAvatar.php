<?php

namespace App\Components\Account\Application\Query\Model;

class AdminAvatar
{
    /** @var bool */
    private bool $exists;

    /** @var string */
    private string $mediaName;

    /** @var string */
    private string $mediaSource;

    /** @var string */
    private string $mediaHtml;

    /**
     * AdminAvatar constructor.
     *
     * @param bool   $exists
     * @param string $mediaName
     * @param string $mediaSource
     * @param string $mediaHtml
     */
    public function __construct(
        bool $exists,
        string $mediaName = '',
        string $mediaSource = '',
        string $mediaHtml = ''
    ) {
        $this->exists = $exists;
        $this->mediaName = $mediaName;
        $this->mediaSource = $mediaSource;
        $this->mediaHtml = $mediaHtml;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return $this->exists;
    }

    /**
     * @return string
     */
    public function mediaName(): string
    {
        return $this->mediaName;
    }

    /**
     * @return string
     */
    public function mediaSource(): string
    {
        return $this->mediaSource;
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    public function mediaHtml(array $attributes = []): string
    {
        if (false !== strpos($this->mediaHtml, 'img')) {
            $html = implode(' ', array_filter(array_map(function ($key, $value) {
                return $value ? $key.'="'.htmlspecialchars($value).'"' : false;
            }, array_keys($attributes), $attributes)));

            return str_replace(
                ['img'],
                [sprintf('img %s', $html)],
                $this->mediaHtml
            );
        }

        return $this->mediaHtml;
    }
}

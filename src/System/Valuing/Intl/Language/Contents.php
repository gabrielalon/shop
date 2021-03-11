<?php

namespace App\System\Valuing\Intl\Language;

use App\System\Valuing\Char;
use App\System\Valuing\VO;
use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

/**
 * @property Collection $value
 */
final class Contents extends VO
{
    /**
     * @param array $data
     *
     * @return Contents
     *
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): Contents
    {
        return new self($data);
    }

    /**
     * @param string $locale
     *
     * @return Char\Content
     *
     * @throws InvalidArgumentException
     */
    public function getLocale(string $locale): Char\Char
    {
        $content = Char\Content::fromString('');

        if (true === $this->value->offsetExists($locale)) {
            assert($content instanceof Char\Content);
            $content = $this->value->offsetGet($locale);
        }

        return $content;
    }

    /**
     * @param mixed $other
     *
     * @return bool
     */
    public function equals(mixed $other): bool
    {
        if (false === $other instanceof self) {
            return false;
        }

        return $this->value->equals($other->value);
    }

    /**
     * @return array
     */
    public function raw(): array
    {
        $data = [];

        foreach ($this->getLocales() as $locale => $content) {
            assert($content instanceof Char\Content);
            $data[$locale] = $content->toString();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getLocales(): array
    {
        return $this->value->getArrayCopy();
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        Assertion::isArray($value, 'Invalid Locales array');
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    protected function setValue($data): void
    {
        $this->value = new Collection();

        foreach ($data as $locale => $content) {
            $this->addLocale($locale, (string) $content);
        }
    }

    /**
     * @param string $locale
     * @param string $content
     *
     * @throws InvalidArgumentException
     */
    public function addLocale(string $locale, string $content): void
    {
        $this->value->add(Code::fromCode($locale), Char\Content::fromString($content));
    }
}

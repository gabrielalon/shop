<?php

namespace App\System\Valuing\Intl\Language;

use App\System\Valuing\Char;
use App\System\Valuing\VO;
use InvalidArgumentException;
use Webmozart\Assert\Assert as Assertion;

/**
 * @property Collection $value
 */
final class Texts extends VO
{
    /**
     * @param array $data
     *
     * @return Texts
     *
     * @throws InvalidArgumentException
     */
    public static function fromArray(array $data): Texts
    {
        return new self($data);
    }

    /**
     * @param string $locale
     *
     * @return Char\Text
     *
     * @throws InvalidArgumentException
     */
    public function getLocale(string $locale): Char\Char
    {
        $text = Char\Text::fromString('');

        if (true === $this->value->offsetExists($locale)) {
            assert($text instanceof Char\Text);
            $text = $this->value->offsetGet($locale);
        }

        return $text;
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

        foreach ($this->getLocales() as $locale => $text) {
            assert($text instanceof Char\Text);
            $data[$locale] = $text->toString();
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

        foreach ($data as $locale => $text) {
            $this->addLocale($locale, (string) $text);
        }
    }

    /**
     * @param string $locale
     * @param string $text
     *
     * @throws InvalidArgumentException
     */
    public function addLocale(string $locale, string $text): void
    {
        $this->value->add(Code::fromCode($locale), Char\Text::fromString($text));
    }
}

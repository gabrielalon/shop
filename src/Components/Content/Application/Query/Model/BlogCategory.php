<?php

namespace App\Components\Content\Application\Query\Model;

use App\System\Valuing\Intl\Language\Texts;

class BlogCategory
{
    /** @var string */
    private $id;

    /** @var Texts */
    private $name;

    /** @var bool */
    private $active;

    /**
     * BlogCategory constructor.
     *
     * @param string   $id
     * @param string[] $name
     * @param bool     $active
     */
    public function __construct(string $id, array $name, bool $active)
    {
        $this->id = $id;
        $this->name = Texts::fromArray($name);
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function name(string $locale): string
    {
        return $this->name->getLocale($locale)->toString();
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}

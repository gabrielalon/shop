<?php

namespace App\Components\Content\Application\Query\Model;

use App\System\Valuing\Intl\Language\Contents;
use App\System\Valuing\Intl\Language\Texts;
use Carbon\Carbon;

class BlogEntry
{
    /** @var string */
    private string $id;

    /** @var Texts */
    private Texts $name;

    /** @var Contents */
    private Contents $description;

    /** @var Carbon */
    private Carbon $publishAt;

    /** @var bool */
    private bool $active;

    /** @var BlogCategoryCollection */
    private BlogCategoryCollection $categories;

    /**
     * BlogEntry constructor.
     *
     * @param string                 $id
     * @param string[]               $name
     * @param string[]               $description
     * @param Carbon                 $publishAt
     * @param bool                   $active
     * @param BlogCategoryCollection $categories
     */
    public function __construct(
        string $id,
        array $name,
        array $description,
        Carbon $publishAt,
        bool $active,
        BlogCategoryCollection $categories
    ) {
        $this->id = $id;
        $this->name = Texts::fromArray($name);
        $this->description = Contents::fromArray($description);
        $this->publishAt = $publishAt;
        $this->active = $active;
        $this->categories = $categories;
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
     * @param string $locale
     *
     * @return string
     */
    public function description(string $locale): string
    {
        return $this->description->getLocale($locale)->toString();
    }

    /**
     * @return Carbon
     */
    public function publishAt(): Carbon
    {
        return $this->publishAt;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return BlogCategoryCollection
     */
    public function categories(): BlogCategoryCollection
    {
        return $this->categories;
    }
}

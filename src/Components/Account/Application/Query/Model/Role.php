<?php

namespace App\Components\Account\Application\Query\Model;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Valuing\Intl\Language\Texts;

class Role
{
    /** @var string */
    private string $id;

    /** @var RoleEnum */
    private RoleEnum $type;

    /** @var Texts */
    private Texts $descriptions;

    /**
     * Role constructor.
     *
     * @param string   $id
     * @param RoleEnum $type
     * @param string[] $descriptions
     */
    public function __construct(string $id, RoleEnum $type, $descriptions)
    {
        $this->id = $id;
        $this->type = $type;
        $this->descriptions = Texts::fromArray($descriptions);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type->getValue();
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function isOfType(string $type): bool
    {
        try {
            return $this->type->equals(new RoleEnum($type));
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function description(string $locale): string
    {
        return $this->descriptions->getLocale($locale)->toString();
    }
}

<?php

namespace App\Components\Site\Application\Query\Model;

use App\System\Valuing\Intl\Language\Texts;

class Language
{
    private string $code;

    private Texts $names;

    /**
     * Language constructor.
     *
     * @param string   $code
     * @param string[] $names
     */
    public function __construct(string $code, array $names)
    {
        $this->code = $code;
        $this->names = Texts::fromArray($names);
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function name(string $locale): string
    {
        return $this->names->getLocale($locale)->toString();
    }
}

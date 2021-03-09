<?php

namespace App\Components\Account\Application\Command\RefreshUserLocale;

use App\Components\Account\Application\Command\UserCommand;

class RefreshUserLocale extends UserCommand
{
    /** @var string */
    private $locale;

    /**
     * RefreshUserLocale constructor.
     *
     * @param string $id
     * @param string $locale
     */
    public function __construct(string $id, string $locale)
    {
        $this->setId($id);
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function locale(): string
    {
        return $this->locale;
    }
}

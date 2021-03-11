<?php

namespace App\Components\Account\Application\Command\RefreshAdminLocale;

use App\Components\Account\Application\Command\AdminCommand;

class RefreshAdminLocale extends AdminCommand
{
    /** @var string */
    private $locale;

    /**
     * RefreshAdminLocale constructor.
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

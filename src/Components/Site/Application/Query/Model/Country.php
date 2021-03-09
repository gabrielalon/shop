<?php

namespace App\Components\Site\Application\Query\Model;

class Country
{
    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /**
     * Country constructor.
     *
     * @param string $code
     * @param string $name
     */
    public function __construct(string $code, string $name)
    {
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}

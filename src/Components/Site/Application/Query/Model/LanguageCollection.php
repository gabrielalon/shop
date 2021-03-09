<?php

namespace App\Components\Site\Application\Query\Model;

class LanguageCollection extends \ArrayIterator
{
    /**
     * @param Language $language
     */
    public function add(Language $language): void
    {
        $this->offsetSet($language->code(), $language);
    }

    /**
     * @return Language[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}

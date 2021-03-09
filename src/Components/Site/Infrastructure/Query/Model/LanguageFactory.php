<?php

namespace App\Components\Site\Infrastructure\Query\Model;

use App\Components\Site\Application\Query\Model\Language;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\Components\Site\Infrastructure\Entity\Language as LanguageEntity;

class LanguageFactory
{
    /**
     * @param LanguageEntity $language
     *
     * @return Language
     */
    public function build(LanguageEntity $language): Language
    {
        return new Language($language->code, [
            $language->code => $language->native_name,
            LocaleEnum::EN()->getValue() => $language->native_name,
            LocaleEnum::PL()->getValue() => $language->native_name,
        ]);
    }
}

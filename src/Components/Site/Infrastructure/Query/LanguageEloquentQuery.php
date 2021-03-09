<?php

namespace App\Components\Site\Infrastructure\Query;

use App\Components\Site\Application\Query\LanguageQuery;
use App\Components\Site\Application\Query\Model\LanguageCollection;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\Components\Site\Infrastructure\Entity\Language as LanguageEntity;
use App\Components\Site\Infrastructure\Query\Model\LanguageFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageEloquentQuery implements LanguageQuery
{
    /** @var LanguageEntity */
    private $db;

    /** @var LanguageFactory */
    private $factory;

    /**
     * LanguageEloquentQuery constructor.
     *
     * @param LanguageEntity  $db
     * @param LanguageFactory $factory
     */
    public function __construct(LanguageEntity $db, LanguageFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function findAllSupportedLanguages(): LanguageCollection
    {
        $collection = new LanguageCollection();

        foreach (LocaleEnum::values() as $locale) {
            $collection->add($this->factory->build($this->findLanguage($locale)));
        }

        return $collection;
    }

    /**
     * @param string $code
     *
     * @return LanguageEntity|Model|null
     */
    private function findLanguage(string $code): ?LanguageEntity
    {
        return $this->db->newQuery()->find($code);
    }
}

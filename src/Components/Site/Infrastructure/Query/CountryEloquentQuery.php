<?php

namespace App\Components\Site\Infrastructure\Query;

use App\Components\Site\Application\Query\CountryQuery;
use App\Components\Site\Application\Query\Model\CountryCollection;
use App\Components\Site\Infrastructure\Entity\Country as CountryEntity;
use App\Components\Site\Infrastructure\Query\Model\CountryFactory;

final class CountryEloquentQuery implements CountryQuery
{
    /** @var CountryEntity */
    private CountryEntity $db;

    /** @var CountryFactory */
    private CountryFactory $factory;

    /**
     * CountryEloquentQuery constructor.
     *
     * @param CountryEntity  $db
     * @param CountryFactory $factory
     */
    public function __construct(CountryEntity $db, CountryFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function findCountryCollection(): CountryCollection
    {
        $collection = new CountryCollection();

        foreach ($this->db->newQuery()->get()->all() as $entity) {
            assert($entity instanceof CountryEntity);
            $collection->add($this->factory->build($entity));
        }

        return $collection;
    }
}

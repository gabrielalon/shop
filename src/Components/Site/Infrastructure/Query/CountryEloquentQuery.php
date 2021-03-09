<?php

namespace App\Components\Site\Infrastructure\Query;

use App\Components\Site\Application\Query\CountryQuery;
use App\Components\Site\Application\Query\Model\CountryCollection;
use App\Components\Site\Infrastructure\Entity\Country as CountryEntity;
use App\Components\Site\Infrastructure\Query\Model\CountryFactory;

class CountryEloquentQuery implements CountryQuery
{
    /** @var CountryEntity */
    private $db;

    /** @var CountryFactory */
    private $factory;

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

        /** @var CountryEntity $entity */
        foreach ($this->db->newQuery()->get()->all() as $entity) {
            $collection->add($this->factory->build($entity));
        }

        return $collection;
    }
}

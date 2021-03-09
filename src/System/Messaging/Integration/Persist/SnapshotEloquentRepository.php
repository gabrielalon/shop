<?php

namespace App\System\Messaging\Integration\Persist;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Messaging\Aggregate\AggregateRootDecorator;
use App\System\Messaging\Aggregate\AggregateTranslator;
use App\System\Messaging\Integration\Entity\SnapshotEntity;
use App\System\Messaging\Integration\Service\CallbackSerializer;
use App\System\Messaging\Snapshot\Snapshot;
use App\System\Messaging\Snapshot\SnapshotRepository;

class SnapshotEloquentRepository implements SnapshotRepository
{
    /** @var CallbackSerializer */
    private $serializer;

    /** @var AggregateTranslator */
    private $aggregateTranslator;

    /**
     * SnapshotEloquentRepository constructor.
     *
     * @param CallbackSerializer $serializer
     */
    public function __construct(CallbackSerializer $serializer)
    {
        $this->serializer = $serializer;
        $this->aggregateTranslator = new AggregateTranslator(AggregateRootDecorator::newInstance());
    }

    /**
     * {@inheritdoc}
     */
    public function save(Snapshot $snapshot): void
    {
        SnapshotEntity::query()->updateOrCreate($this->extractCreateData($snapshot), [
            'last_version' => $snapshot->lastVersion(),
            'aggregate' => $this->serializer->serialize($snapshot->aggregateRoot()),
        ]);
    }

    /**
     * @param Snapshot $snapshot
     *
     * @return array
     */
    private function extractCreateData(Snapshot $snapshot): array
    {
        return [
            'aggregate_id' => $snapshot->aggregateRoot()->aggregateId(),
            'aggregate_type' => $snapshot->aggregateType(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $aggregateType, AggregateId $aggregateId): Snapshot
    {
        $condition = ['aggregate_id' => $aggregateId->toString(), 'aggregate_type' => $aggregateType];

        try {
            /** @var SnapshotEntity $entity */
            $entity = SnapshotEntity::query()->where($condition)->firstOrFail();

            /** @var AggregateRoot $aggregateRoot */
            $aggregateRoot = $this->serializer->unserialize($entity->aggregate);

            return new Snapshot($aggregateRoot, $entity->last_version);
        } catch (\Exception $e) {
            $aggregateRoot = $this->aggregateTranslator->reconstituteAggregateFromType($aggregateType, $aggregateId);

            return new Snapshot($aggregateRoot, 0);
        }
    }
}

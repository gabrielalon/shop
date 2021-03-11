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

final class SnapshotEloquentRepository implements SnapshotRepository
{
    /** @var SnapshotEntity */
    private SnapshotEntity $db;

    /** @var CallbackSerializer */
    private CallbackSerializer $serializer;

    /** @var AggregateTranslator */
    private AggregateTranslator $aggregateTranslator;

    /**
     * SnapshotEloquentRepository constructor.
     *
     * @param SnapshotEntity     $db
     * @param CallbackSerializer $serializer
     */
    public function __construct(SnapshotEntity $db, CallbackSerializer $serializer)
    {
        $this->db = $db;
        $this->serializer = $serializer;
        $this->aggregateTranslator = new AggregateTranslator(AggregateRootDecorator::newInstance());
    }

    /**
     * {@inheritdoc}
     */
    public function save(Snapshot $snapshot): void
    {
        $this->db->newQuery()->updateOrCreate($this->extractCreateData($snapshot), [
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
            $entity = $this->db->newQuery()->where($condition)->firstOrFail();
            assert($entity instanceof SnapshotEntity);

            $aggregateRoot = $this->serializer->unserialize($entity->aggregate);
            assert($aggregateRoot instanceof AggregateRoot);

            return new Snapshot($aggregateRoot, $entity->last_version);
        } catch (\Exception $e) {
            $aggregateRoot = $this->aggregateTranslator->reconstituteAggregateFromType($aggregateType, $aggregateId);

            return new Snapshot($aggregateRoot, 0);
        }
    }
}

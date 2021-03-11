<?php

namespace App\System\Messaging\Integration\Persist;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Integration\Entity\StateEntity;
use App\System\Messaging\Saga\State;
use App\System\Messaging\Saga\State\StateRepository;
use Carbon\Carbon;

final class StateEloquentRepository implements StateRepository
{
    /** @var StateEntity */
    private StateEntity $db;

    /**
     * StateEloquentRepository constructor.
     *
     * @param StateEntity $db
     */
    public function __construct(StateEntity $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBy(AggregateId $aggregateId, string $sagaType): ?State
    {
        $query = $this->db->newQuery()
            ->where('aggregate_id', '=', $aggregateId->toString())
            ->where('saga_type', '=', $sagaType)
            ->where('is_done', '=', false);

        if ($entity = $query->first()) {
            assert($entity instanceof StateEntity);

            return new State($entity->id, $entity->aggregate_id, $entity->payload);
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(State $state, string $sagaType): void
    {
        $this->db->newQuery()->updateOrCreate(['id' => $state->id()], [
            'aggregate_id' => $state->aggregateId(),
            'recorded_on' => Carbon::now()->toDateTimeString(),
            'saga_type' => $sagaType,
            'payload' => $state->payload(),
        ]);

        if (true === $state->isDone()) {
            $where = ['aggregate_id' => $state->aggregateId(), 'saga_type' => $sagaType, 'is_done' => false];
            $this->db->newQuery()->where($where)->update(['is_done' => $state->isDone()]);
        }
    }
}

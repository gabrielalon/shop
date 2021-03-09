<?php

namespace App\System\Messaging\Integration\Persist;

use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Event\EventStreamRepository;
use App\System\Messaging\Integration\Entity\EventStreamEntity;
use App\System\Messaging\Integration\Service\JsonSerializer;
use Jenssegers\Agent\Agent;

class EventStreamEloquentRepository implements EventStreamRepository
{
    /** @var Agent */
    private $agent;

    /** @var JsonSerializer */
    private $serializer;

    /**
     * EventStreamEloquentRepository constructor.
     *
     * @param Agent          $agent
     * @param JsonSerializer $serializer
     */
    public function __construct(Agent $agent, JsonSerializer $serializer)
    {
        $this->agent = $agent;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function save(AggregateChanged $event): void
    {
        EventStreamEntity::query()->create(array_merge($event->baseData(), [
            'payload' => $this->serializer->encode($event->payload()),
            'metadata' => $this->serializer->encode($this->extractMetadata()),
            'user_id' => auth()->check() ? auth()->user()->getAuthIdentifier() : null,
        ]));
    }

    /**
     * @return array
     */
    private function extractMetadata(): array
    {
        $metadata = [];

        $metadata['device'] = $this->agent->device();
        $metadata['platform'] = $this->agent->platform();
        $metadata['platform_version'] = $this->agent->version($metadata['platform']);
        $metadata['browser'] = $this->agent->browser();
        $metadata['browser_version'] = $this->agent->version($metadata['browser']);
        $metadata['client_ip'] = $this->clientIP();
        $metadata['client_host'] = $this->clientHost();
        $metadata['environment'] = PHP_SAPI;

        return $metadata;
    }

    /**
     * @return string|null
     */
    private function clientIP(): ?string
    {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        $flags = FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
        foreach ($keys as $key) {
            if (true === array_key_exists($key, $_SERVER)) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (false !== filter_var($ip, FILTER_VALIDATE_IP, $flags)) {
                        return $ip;
                    }
                }
            }
        }

        return request()->ip();
    }

    /**
     * @return string|null
     */
    private function clientHost(): ?string
    {
        return request()->getHost();
    }

    /**
     * {@inheritdoc}
     */
    public function load(AggregateId $aggregateId, int $lastVersion): array
    {
        $collection = EventStreamEntity::query()
            ->where(['event_id' => $aggregateId->toString()])
            ->where('version', '>=', $lastVersion)
            ->get();

        if (0 === $collection->count()) {
            return [];
        }

        $stream = [];

        /** @var EventStreamEntity $entity */
        foreach ($collection as $entity) {
            /** @var AggregateChanged $event */
            $event = $entity->event_name;
            $event = $event::occur($entity->event_id, $this->serializer->decode($entity->payload));

            $stream[] = $event->withVersion($entity->version);
        }

        return $stream;
    }
}

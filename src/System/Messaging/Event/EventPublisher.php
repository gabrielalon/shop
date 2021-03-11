<?php

namespace App\System\Messaging\Event;

use App\System\Messaging\Aggregate\AggregateChanged;
use Psr\Container\ContainerInterface;

final class EventPublisher
{
    /** @var string[][] */
    private array $map;

    /** @var ContainerInterface */
    private ContainerInterface $container;

    /**
     * EventPublisher constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->map = [];
        $this->container = $container;
    }

    /**
     * @param AggregateChanged $event
     *
     * @throws \ReflectionException
     */
    public function release(AggregateChanged $event): void
    {
        foreach ($this->map($event) as $projectorName) {
            $projector = $this->container->get($projectorName);

            $reflection = new \ReflectionMethod($projector, $this->methodName($event));
            $reflection->invoke($projector, $event);
        }
    }

    /**
     * @param AggregateChanged $event
     *
     * @return string[]
     */
    private function map(AggregateChanged $event): array
    {
        if (true === empty($this->map)) {
            $map = [];
            $pathPattern = base_path('src/Components/*/Resource/events/');

            $iterator = new \GlobIterator($pathPattern.'*.php');
            $iterator->rewind();
            while (true === $iterator->valid()) {
                /** @var string[][] $tmp */
                $tmp = include $iterator->current();
                $map = array_merge($map, $tmp);

                $iterator->next();
            }

            $this->map = $map;
        }

        return $this->map[$event->eventName()] ?? [];
    }

    /**
     * @param AggregateChanged $event
     *
     * @return string
     *
     * @throws \ReflectionException
     */
    private function methodName(AggregateChanged $event): string
    {
        $reflectionClass = new \ReflectionClass($event->eventName());

        return 'on'.$reflectionClass->getShortName();
    }
}

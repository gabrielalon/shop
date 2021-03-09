<?php

namespace App\System\Messaging;

use Psr\Container\ContainerInterface;

class MessageBus
{
    /** @var ContainerInterface */
    private $container;

    /**
     * MessageBus constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Command\Command $command
     */
    public function handle(Command\Command $command): void
    {
        $handlerName = $command->messageName().'Handler';

        /** @var Command\CommandHandler $handler */
        $handler = $this->container->get($handlerName);
        $handler->run($command);
    }

    /**
     * @param string $queryClass
     *
     * @return Query\Query
     */
    public function query(string $queryClass): Query\Query
    {
        /** @var Query\Query $query */
        $query = $this->container->get($queryClass);

        return $query;
    }
}

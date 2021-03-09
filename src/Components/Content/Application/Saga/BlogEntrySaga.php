<?php

namespace App\Components\Content\Application\Saga;

use App\Components\Content\Application\Command\ActivateBlogEntry\ActivateBlogEntry;
use App\Components\Content\Application\Command\CategoriseBlogEntry\CategoriseBlogEntry;
use App\Components\Content\Application\Command\CreateBlogEntry\CreateBlogEntry;
use App\Components\Content\Application\Command\DeactivateBlogEntry\DeactivateBlogEntry;
use App\Components\Content\Application\Command\PublishBlogEntry\PublishBlogEntry;
use App\Components\Content\Application\Command\RemoveBlogEntry\RemoveBlogEntry;
use App\Components\Content\Application\Command\TranslateBlogEntry\TranslateBlogEntry;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Saga\SagaRoot;
use App\System\Messaging\Saga\State;
use App\System\Valuing\Identity\Uuid;

class BlogEntrySaga extends SagaRoot
{
    /** @var MessageBus */
    private $messageBus;

    /**
     * BlogEntrySaga constructor.
     *
     * @param MessageBus $messageBus
     */
    public function __construct(MessageBus $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * {@inheritdoc}
     */
    public function configuration(): array
    {
        return [
            Scenario\BlogEntryCreated::class => function (Scenario\BlogEntryCreated $scenario) {
                return null;
            },
            Scenario\BlogEntryUpdated::class => function (Scenario\BlogEntryUpdated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogEntryActivated::class => function (Scenario\BlogEntryActivated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogEntryDeactivated::class => function (Scenario\BlogEntryDeactivated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogEntryRemoved::class => function (Scenario\BlogEntryRemoved $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
        ];
    }

    /**
     * @param Scenario\BlogEntryCreated $scenario
     * @param State                     $state
     *
     * @return State
     */
    public function handleBlogEntryCreated(Scenario\BlogEntryCreated $scenario, State $state): State
    {
        list($name, $description) = [$scenario->name(), $scenario->description()];

        $this->messageBus->handle(new CreateBlogEntry($scenario->id()));
        $this->messageBus->handle(new TranslateBlogEntry($scenario->id(), $name, $description));
        $this->messageBus->handle(new PublishBlogEntry($scenario->id(), $scenario->publishAt()));
        $this->messageBus->handle(new CategoriseBlogEntry($scenario->id(), $scenario->categoriesID()));
        $this->messageBus->handle(new DeactivateBlogEntry($scenario->id()));

        $state->withAggregateId(Uuid::fromIdentity($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogEntryUpdated $scenario
     * @param State                     $state
     *
     * @return State
     */
    public function handleBlogEntryUpdated(Scenario\BlogEntryUpdated $scenario, State $state): State
    {
        list($name, $description) = [$scenario->name(), $scenario->description()];

        $this->messageBus->handle(new TranslateBlogEntry($scenario->id(), $name, $description));
        $this->messageBus->handle(new PublishBlogEntry($scenario->id(), $scenario->publishAt()));
        $this->messageBus->handle(new CategoriseBlogEntry($scenario->id(), $scenario->categoriesID()));

        return $state;
    }

    /**
     * @param Scenario\BlogEntryActivated $scenario
     * @param State                       $state
     *
     * @return State
     */
    public function handleBlogEntryActivated(Scenario\BlogEntryActivated $scenario, State $state): State
    {
        $this->messageBus->handle(new ActivateBlogEntry($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogEntryDeactivated $scenario
     * @param State                         $state
     *
     * @return State
     */
    public function handleBlogEntryDeactivated(Scenario\BlogEntryDeactivated $scenario, State $state): State
    {
        $this->messageBus->handle(new DeactivateBlogEntry($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogEntryRemoved $scenario
     * @param State                     $state
     *
     * @return State
     */
    public function handleBlogEntryRemoved(Scenario\BlogEntryRemoved $scenario, State $state): State
    {
        $this->messageBus->handle(new RemoveBlogEntry($scenario->id()));

        return $state->markDone();
    }
}

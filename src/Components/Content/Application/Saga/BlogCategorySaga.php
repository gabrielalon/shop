<?php

namespace App\Components\Content\Application\Saga;

use App\Components\Content\Application\Command\ActivateBlogCategory\ActivateBlogCategory;
use App\Components\Content\Application\Command\CreateBlogCategory\CreateBlogCategory;
use App\Components\Content\Application\Command\DeactivateBlogCategory\DeactivateBlogCategory;
use App\Components\Content\Application\Command\PositionBlogCategory\PositionBlogCategory;
use App\Components\Content\Application\Command\RemoveBlogCategory\RemoveBlogCategory;
use App\Components\Content\Application\Command\TranslateBlogCategory\TranslateBlogCategory;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Saga\SagaRoot;
use App\System\Messaging\Saga\State;
use App\System\Valuing\Identity\Uuid;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BlogCategorySaga extends SagaRoot
{
    /** @var MessageBus */
    private $messageBus;

    /**
     * BlogCategorySaga constructor.
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
            Scenario\BlogCategoryCreated::class => function (Scenario\BlogCategoryCreated $scenario) {
                return null;
            },
            Scenario\BlogCategoryUpdated::class => function (Scenario\BlogCategoryUpdated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogCategoryActivated::class => function (Scenario\BlogCategoryActivated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogCategoryDeactivated::class => function (Scenario\BlogCategoryDeactivated $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogCategoryRemoved::class => function (Scenario\BlogCategoryRemoved $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
            Scenario\BlogCategorySorted::class => function (Scenario\BlogCategorySorted $scenario) {
                return null;
            },
        ];
    }

    /**
     * @param Scenario\BlogCategoryCreated $scenario
     * @param State                        $state
     *
     * @return State
     */
    public function handleBlogCategoryCreated(Scenario\BlogCategoryCreated $scenario, State $state): State
    {
        $this->messageBus->handle(new CreateBlogCategory($scenario->id()));
        $this->messageBus->handle(new TranslateBlogCategory($scenario->id(), $scenario->name()));
        $this->messageBus->handle(new DeactivateBlogCategory($scenario->id()));

        $state->withAggregateId(Uuid::fromIdentity($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogCategoryUpdated $scenario
     * @param State                        $state
     *
     * @return State
     */
    public function handleBlogCategoryUpdated(Scenario\BlogCategoryUpdated $scenario, State $state): State
    {
        $this->messageBus->handle(new TranslateBlogCategory($scenario->id(), $scenario->name()));
        $this->messageBus->handle(new DeactivateBlogCategory($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogCategoryActivated $scenario
     * @param State                          $state
     *
     * @return State
     */
    public function handleBlogCategoryActivated(Scenario\BlogCategoryActivated $scenario, State $state): State
    {
        $this->messageBus->handle(new ActivateBlogCategory($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogCategoryDeactivated $scenario
     * @param State                            $state
     *
     * @return State
     */
    public function handleBlogCategoryDeactivated(Scenario\BlogCategoryDeactivated $scenario, State $state): State
    {
        $this->messageBus->handle(new DeactivateBlogCategory($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\BlogCategoryRemoved $scenario
     * @param State                        $state
     *
     * @return State
     */
    public function handleBlogCategoryRemoved(Scenario\BlogCategoryRemoved $scenario, State $state): State
    {
        $this->messageBus->handle(new RemoveBlogCategory($scenario->id()));

        return $state->markDone();
    }

    /**
     * @param Scenario\BlogCategorySorted $scenario
     * @param State                       $state
     *
     * @return State
     */
    public function handleBlogCategorySorted(Scenario\BlogCategorySorted $scenario, State $state): State
    {
        foreach ($scenario->data() as $position => $data) {
            $this->sortBlogCategory($position + 1, $data);
        }

        $state->withAggregateId(Uuid::fromIdentity(Str::uuid()->toString()));

        return $state->markDone();
    }

    /**
     * @param int         $position
     * @param array       $data
     * @param string|null $parentId
     */
    private function sortBlogCategory(int $position, array $data, string $parentId = null): void
    {
        if ($categoryId = Arr::get($data, 'id', null)) {
            $this->messageBus->handle(new PositionBlogCategory($categoryId, $position, $parentId));

            if ($children = Arr::get($data, 'children', false)) {
                foreach ($children as $position => $data) {
                    $this->sortBlogCategory($position + 1, $data, $categoryId);
                }
            }
        }
    }
}

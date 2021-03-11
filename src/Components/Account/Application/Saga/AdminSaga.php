<?php

namespace App\Components\Account\Application\Saga;

use App\Components\Account\Application\Command\CreateAdmin\CreateAdmin;
use App\Components\Account\Application\Command\RefreshAdminLocale\RefreshAdminLocale;
use App\Components\Account\Application\Command\RemoveAdmin\RemoveAdmin;
use App\Components\Account\Domain\AdminSpecification;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Saga\SagaRoot;
use App\System\Messaging\Saga\State;
use App\System\Valuing\Identity\Uuid;
use Webmozart\Assert\Assert;

final class AdminSaga extends SagaRoot
{
    /** @var MessageBus */
    private $messageBus;

    /** @var AdminSpecification */
    private $specification;

    /**
     * AdminSaga constructor.
     *
     * @param MessageBus         $messageBus
     * @param AdminSpecification $specification
     */
    public function __construct(MessageBus $messageBus, AdminSpecification $specification)
    {
        $this->messageBus = $messageBus;
        $this->specification = $specification;
    }

    /**
     * {@inheritdoc}
     */
    public function configuration(): array
    {
        return [
            Scenario\AdminCreate::class => function (Scenario\AdminCreate $scenario) {
                return null;
            },
            Scenario\AdminRemove::class => function (Scenario\AdminRemove $scenario) {
                return Uuid::fromIdentity($scenario->id());
            },
        ];
    }

    /**
     * @param Scenario\AdminCreate $scenario
     * @param State                $state
     *
     * @return State
     */
    public function handleAdminCreate(Scenario\AdminCreate $scenario, State $state): State
    {
        Assert::false($this->specification->isUniqueEmailSatisfied($scenario->email()), 'Admin is registered on given email');

        $this->messageBus->handle(new CreateAdmin(
            $scenario->id(),
            $scenario->firstName(),
            $scenario->lastName(),
            $scenario->email(),
            $scenario->password()
        ));
        $this->messageBus->handle(new RefreshAdminLocale($scenario->id(), $scenario->locale()));

        $state->withAggregateId(Uuid::fromIdentity($scenario->id()));

        return $state;
    }

    /**
     * @param Scenario\AdminRemove $scenario
     * @param State                $state
     *
     * @return State
     */
    public function handleAdminRemove(Scenario\AdminRemove $scenario, State $state): State
    {
        $this->messageBus->handle(new RemoveAdmin($scenario->id()));

        return $state->markDone();
    }
}

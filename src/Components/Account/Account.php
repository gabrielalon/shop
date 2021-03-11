<?php

namespace App\Components\Account;

use App\Components\Account\Application\Command\ChangeUserPassword\ChangeUserPassword;
use App\Components\Account\Application\Command\RefreshUserRememberToken\RefreshUserRememberToken;
use App\Components\Account\Application\Query\AdminQuery;
use App\Components\Account\Application\Query\RoleQuery;
use App\Components\Account\Application\Query\UserQuery;
use App\Components\Account\Application\Saga\Scenario;
use App\Components\Account\Application\Validator\AdminValidatorFactory;
use App\Components\Account\Application\Validator\UserValidatorFactory;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Saga\SagaProcessor;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory;
use Webmozart\Assert\Assert;

final class Account
{
    /** @var Factory */
    private Factory $factory;

    /** @var MessageBus */
    private MessageBus $messageBus;

    /** @var SagaProcessor */
    private SagaProcessor $sagaProcessor;

    /**
     * Account constructor.
     *
     * @param Factory       $factory
     * @param MessageBus    $messageBus
     * @param SagaProcessor $sagaProcessor
     */
    public function __construct(Factory $factory, MessageBus $messageBus, SagaProcessor $sagaProcessor)
    {
        $this->factory = $factory;
        $this->messageBus = $messageBus;
        $this->sagaProcessor = $sagaProcessor;
    }

    /**
     * @param string $userId
     * @param string $password
     */
    public function changeUserPassword(string $userId, string $password): void
    {
        $this->assertUserIdExists($userId);
        $this->messageBus->handle(new ChangeUserPassword($userId, $password));
        $this->refreshUserRememberToken($userId, Str::random(60));
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param string $locale
     *
     * @return string
     *
     * @throws \Exception
     */
    public function createAdmin(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $locale
    ): string {
        $this->sagaProcessor->run(new Scenario\AdminCreate(
            $adminId = Str::uuid(),
            $firstName,
            $lastName,
            $email,
            $password,
            $locale
        ));

        return $adminId;
    }

    /**
     * @param string $adminId
     *
     * @throws \Exception
     */
    public function remove(string $adminId): void
    {
        $this->assertAdminIdExists($adminId);
        $this->sagaProcessor->run(new Scenario\AdminRemove($adminId));
    }

    /**
     * @param string $userId
     * @param string $token
     */
    public function refreshUserRememberToken(string $userId, string $token): void
    {
        $this->assertUserIdExists($userId);
        $this->messageBus->handle(new RefreshUserRememberToken($userId, $token));
    }

    /**
     * @param string $adminId
     *
     * @throws \InvalidArgumentException
     */
    private function assertAdminIdExists(string $adminId): void
    {
        Assert::false(
            $this->adminValidator()->exists($adminId)->fails(),
            \sprintf('Admin does not exist on given id: %s.', $adminId)
        );
    }

    /**
     * @param string $userId
     *
     * @throws \InvalidArgumentException
     */
    private function assertUserIdExists(string $userId): void
    {
        Assert::false(
            $this->userValidator()->exists($userId)->fails(),
            \sprintf('User does not exist on given id: %s.', $userId)
        );
    }

    /**
     * @return AdminValidatorFactory
     */
    public function adminValidator(): AdminValidatorFactory
    {
        return AdminValidatorFactory::initialize($this->factory);
    }

    /**
     * @return UserValidatorFactory
     */
    public function userValidator(): UserValidatorFactory
    {
        return UserValidatorFactory::initialize($this->factory);
    }

    /**
     * @return AdminQuery
     */
    public function askAdmin(): AdminQuery
    {
        $query = $this->messageBus->query(AdminQuery::class);

        assert($query instanceof AdminQuery);

        return $query;
    }

    /**
     * @return RoleQuery
     */
    public function askRole(): RoleQuery
    {
        $query = $this->messageBus->query(RoleQuery::class);

        assert($query instanceof RoleQuery);

        return $query;
    }

    /**
     * @return UserQuery
     */
    public function askUser(): UserQuery
    {
        $query = $this->messageBus->query(UserQuery::class);

        assert($query instanceof UserQuery);

        return $query;
    }
}

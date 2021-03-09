<?php

namespace App\Components\Account;

use App\Components\Account\Application\Command\AssignUserRoles\AssignUserRoles;
use App\Components\Account\Application\Command\ChangeAdminName\ChangeAdminName;
use App\Components\Account\Application\Command\ChangeUserPassword\ChangeUserPassword;
use App\Components\Account\Application\Command\CreateAdmin\CreateAdmin;
use App\Components\Account\Application\Command\CreateUser\CreateUser;
use App\Components\Account\Application\Command\RefreshUserLocale\RefreshUserLocale;
use App\Components\Account\Application\Command\RefreshUserRememberToken\RefreshUserRememberToken;
use App\Components\Account\Application\Command\RemoveAdmin\RemoveAdmin;
use App\Components\Account\Application\Query\AdminQuery;
use App\Components\Account\Application\Query\RoleQuery;
use App\Components\Account\Application\Query\UserQuery;
use App\Components\Account\Domain\AdminSpecification;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Eloquent\Connection;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Query\Query;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

class Account
{
    /** @var Connection */
    private $connection;

    /** @var MessageBus */
    private $messageBus;

    /** @var AdminSpecification */
    private $adminSpecification;

    /**
     * Account constructor.
     *
     * @param Connection         $connection
     * @param MessageBus         $messageBus
     * @param AdminSpecification $adminSpecification
     */
    public function __construct(
        Connection $connection,
        MessageBus $messageBus,
        AdminSpecification $adminSpecification
    ) {
        $this->connection = $connection;
        $this->messageBus = $messageBus;
        $this->adminSpecification = $adminSpecification;
    }

    /**
     * @param string $userId
     * @param string $password
     */
    public function changeUserPassword(string $userId, string $password): void
    {
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
     * @throws \InvalidArgumentException
     */
    public function createAdmin(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $locale
    ): string {
        Assert::false($this->adminSpecification->isUniqueEmailSatisfied($email), 'Admin is registered on given email');

        $id = Str::uuid()->toString();
        $userId = Str::uuid()->toString();

        try {
            $this->connection->beginTransaction();
            $this->messageBus->handle(new CreateUser($userId, $email, $password));
            $this->messageBus->handle(new CreateAdmin($id, $firstName, $lastName, $email, $userId));
            $this->messageBus->handle(new AssignUserRoles($userId, [RoleEnum::ADMIN()->getValue()]));
            $this->messageBus->handle(new RefreshUserLocale($userId, $locale));
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }

        return $id;
    }

    /**
     * @param string $adminId
     *
     * @throws \Exception
     */
    public function remove(string $adminId): void
    {
        $this->askAdmin()->findAdminById($adminId);

        try {
            $this->connection->beginTransaction();
            $this->messageBus->handle(new RemoveAdmin($adminId));
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    /**
     * @param string $adminId
     * @param string $fullName
     * @param string $locale
     * @param array  $roles
     *
     * @throws \Exception
     */
    public function updateAdmin(
        string $adminId,
        string $fullName,
        string $locale,
        array $roles
    ): void {
        list($firstName, $lastName) = explode(' ', $fullName);

        try {
            $this->connection->beginTransaction();
            $userId = $this->askAdmin()->findAdminById($adminId)->userId();
            $this->messageBus->handle(new ChangeAdminName($adminId, $firstName, $lastName));
            $this->messageBus->handle(new AssignUserRoles($userId, $roles));
            $this->messageBus->handle(new RefreshUserLocale($userId, $locale));
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    /**
     * @param string $userId
     * @param string $token
     */
    public function refreshUserRememberToken(string $userId, string $token): void
    {
        $this->messageBus->handle(new RefreshUserRememberToken($userId, $token));
    }

    /**
     * @return AdminQuery|Query
     */
    public function askAdmin(): AdminQuery
    {
        return $this->messageBus->query(AdminQuery::class);
    }

    /**
     * @return RoleQuery|Query
     */
    public function askRole(): RoleQuery
    {
        return $this->messageBus->query(RoleQuery::class);
    }

    /**
     * @return UserQuery|Query
     */
    public function askUser(): UserQuery
    {
        return $this->messageBus->query(UserQuery::class);
    }
}

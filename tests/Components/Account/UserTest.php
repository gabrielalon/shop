<?php

namespace Tests\Components\Account;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\User;
use App\Components\Account\Domain\Valuing\Roles;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Illuminate\Support\Str;
use Tests\TestCase;

final class UserTest extends TestCase
{
    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itCreatesNewUser(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        $user = User::create(
            $userId->toString(),
            $userLogin->toString(),
            $userPassword->toString()
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\UserCreated);

        self::assertSame(Event\UserCreated::class, $event->eventName());
        self::assertTrue($userId->equals($event->userId()));
        self::assertTrue($userLogin->equals($event->userLogin()));
        self::assertTrue($userPassword->equals($event->userPassword()));
    }

    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itRefreshesUserLocale(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        $user = $this->reconstituteUserFromHistory($this->newUserCreated(
            $userId,
            $userLogin,
            $userPassword
        ));

        $locale = LocaleEnum::EN()->getValue();

        $user->refreshLocale($locale);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\UserLocaleRefreshed);

        self::assertSame(Event\UserLocaleRefreshed::class, $event->eventName());
        self::assertTrue($event->userLocale()->equals(Text::fromString($locale)));
    }

    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itChangesUserPassword(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        $user = $this->reconstituteUserFromHistory($this->newUserCreated(
            $userId,
            $userLogin,
            $userPassword
        ));

        $password = $this->faker->password;

        $user->changePassword($password);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\UserPasswordChanged);

        self::assertSame(Event\UserPasswordChanged::class, $event->eventName());
        self::assertTrue($event->userPassword()->equals(Text::fromString($password)));
    }

    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itRefreshesUserRememberToken(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        $user = $this->reconstituteUserFromHistory($this->newUserCreated(
            $userId,
            $userLogin,
            $userPassword
        ));

        $token = Str::random();

        $user->refreshRememberToken($token);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\UserRememberTokenRefreshed);

        self::assertSame(Event\UserRememberTokenRefreshed::class, $event->eventName());
        self::assertTrue($event->userRememberToken()->equals(Text::fromString($token)));
    }

    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itAssigneesUserRole(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        $user = $this->reconstituteUserFromHistory($this->newUserCreated(
            $userId,
            $userLogin,
            $userPassword
        ));

        $roles = Roles::fromRoles([RoleEnum::ADMIN()->getValue()]);

        $user->assignRoles($roles->roles());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\UserRolesAssigned);

        self::assertSame(Event\UserRolesAssigned::class, $event->eventName());
        self::assertTrue($event->userRoles()->equals($roles));
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return User
     */
    private function reconstituteUserFromHistory(AggregateChanged ...$events): User
    {
        $user = $this->reconstituteAggregateFromHistory(User::class, $events);

        assert($user instanceof User);

        return $user;
    }

    /**
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     *
     * @return Event\UserCreated
     */
    public function newUserCreated(Uuid $userId, Text $userLogin, Text $userPassword): Event\UserCreated
    {
        $event = Event\UserCreated::occur($userId->toString(), [
            'login' => $userLogin->toString(),
            'password' => $userPassword->toString(),
        ]);

        assert($event instanceof Event\UserCreated);

        return $event;
    }
}

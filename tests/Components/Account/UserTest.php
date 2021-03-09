<?php

namespace Tests\Components\Account;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\User;
use App\Components\Account\Domain\Valuing\Roles;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
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

        $this->assertCount(1, $events);

        /** @var Event\UserCreated $event */
        $event = $events[0];

        $this->assertSame(Event\UserCreated::class, $event->eventName());
        $this->assertTrue($userId->equals($event->userId()));
        $this->assertTrue($userLogin->equals($event->userLogin()));
        $this->assertTrue($userPassword->equals($event->userPassword()));
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

        $this->assertCount(1, $events);

        /** @var Event\UserLocaleRefreshed $event */
        $event = $events[0];

        $this->assertSame(Event\UserLocaleRefreshed::class, $event->eventName());
        $this->assertTrue($event->userLocale()->equals(Text::fromString($locale)));
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

        $this->assertCount(1, $events);

        /** @var Event\UserPasswordChanged $event */
        $event = $events[0];

        $this->assertSame(Event\UserPasswordChanged::class, $event->eventName());
        $this->assertTrue($event->userPassword()->equals(Text::fromString($password)));
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

        $this->assertCount(1, $events);

        /** @var Event\UserRememberTokenRefreshed $event */
        $event = $events[0];

        $this->assertSame(Event\UserRememberTokenRefreshed::class, $event->eventName());
        $this->assertTrue($event->userRememberToken()->equals(Text::fromString($token)));
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

        $this->assertCount(1, $events);

        /** @var Event\UserRolesAssigned $event */
        $event = $events[0];

        $this->assertSame(Event\UserRolesAssigned::class, $event->eventName());
        $this->assertTrue($event->userRoles()->equals($roles));
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot|User
     */
    private function reconstituteUserFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(User::class, $events);
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
        return Event\UserCreated::occur($userId->toString(), [
            'login' => $userLogin->toString(),
            'password' => $userPassword->toString(),
        ]);
    }
}

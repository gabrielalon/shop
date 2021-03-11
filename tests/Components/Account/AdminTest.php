<?php

namespace Tests\Components\Account;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Intl\Language\Code;
use Tests\TestCase;

final class AdminTest extends TestCase
{
    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Text $adminPassword
     */
    public function itCreatesNewAdmin(Uuid $adminId, Name $adminName, Text $adminEmail, Text $adminPassword): void
    {
        $user = Admin::create(
            $adminId->toString(),
            $adminName->firstName(),
            $adminName->lastName(),
            $adminEmail->toString(),
            $adminPassword->toString()
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\AdminCreated);

        self::assertSame(Event\AdminCreated::class, $event->eventName());
        self::assertTrue($adminId->equals($event->adminId()));
        self::assertTrue($adminName->equals($event->adminName()));
        self::assertTrue($adminEmail->equals($event->adminEmail()));
        self::assertTrue($adminPassword->equals($event->adminPassword()));
    }

    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Text $adminPassword
     */
    public function itChangesAdminName(Uuid $adminId, Name $adminName, Text $adminEmail, Text $adminPassword): void
    {
        $admin = $this->reconstituteAdminFromHistory($this->newAdminCreated(
            $adminId,
            $adminName,
            $adminEmail,
            $adminPassword
        ));

        $name = Name::fromData($firstName = 'admin', $lastName = 'admin');

        $admin->changeName($name->firstName(), $name->lastName());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($admin);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\AdminNameChanged);

        self::assertSame(Event\AdminNameChanged::class, $event->eventName());
        self::assertTrue($event->adminName()->equals($name));
    }

    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Text $adminPassword
     */
    public function itRefreshesAdminLocale(Uuid $adminId, Name $adminName, Text $adminEmail, Text $adminPassword): void
    {
        $admin = $this->reconstituteAdminFromHistory($this->newAdminCreated(
            $adminId,
            $adminName,
            $adminEmail,
            $adminPassword
        ));

        $code = Code::fromCode('en');

        $admin->refreshLocale($code->toString());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($admin);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\AdminLocaleRefreshed);

        self::assertSame(Event\AdminLocaleRefreshed::class, $event->eventName());
        self::assertTrue($event->adminLocale()->equals($code));
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return Admin
     */
    private function reconstituteAdminFromHistory(AggregateChanged ...$events): Admin
    {
        $admin = $this->reconstituteAggregateFromHistory(Admin::class, $events);

        assert($admin instanceof Admin);

        return $admin;
    }

    /**
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Text $adminPassword
     *
     * @return Event\AdminCreated
     */
    public function newAdminCreated(Uuid $adminId, Name $adminName, Text $adminEmail, Text $adminPassword): Event\AdminCreated
    {
        $event = Event\AdminCreated::occur($adminId->toString(), [
            'first_name' => $adminName->firstName(),
            'last_name' => $adminName->lastName(),
            'email' => $adminEmail->toString(),
            'password' => $adminPassword->toString(),
        ]);

        assert($event instanceof Event\AdminCreated);

        return $event;
    }
}

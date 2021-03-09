<?php

namespace Tests\Components\Account;

use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Event;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Uuid $adminUserId
     */
    public function itCreatesNewAdmin(Uuid $adminId, Name $adminName, Text $adminEmail, Uuid $adminUserId): void
    {
        $user = Admin::create(
            $adminId->toString(),
            $adminName->firstName(),
            $adminName->lastName(),
            $adminEmail->toString(),
            $adminUserId->toString()
        );

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($user);

        $this->assertCount(1, $events);

        /** @var Event\AdminCreated $event */
        $event = $events[0];

        $this->assertSame(Event\AdminCreated::class, $event->eventName());
        $this->assertTrue($adminId->equals($event->adminId()));
        $this->assertTrue($adminName->equals($event->adminName()));
        $this->assertTrue($adminEmail->equals($event->adminEmail()));
        $this->assertTrue($adminUserId->equals($event->adminUserId()));
    }

    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Uuid $adminUserId
     */
    public function itChangesAdminName(Uuid $adminId, Name $adminName, Text $adminEmail, Uuid $adminUserId): void
    {
        $admin = $this->reconstituteAdminFromHistory($this->newAdminCreated(
            $adminId,
            $adminName,
            $adminEmail,
            $adminUserId
        ));

        $name = Name::fromData($firstName = 'admin', $lastName = 'admin');

        $admin->changeName($name->firstName(), $name->lastName());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($admin);

        $this->assertCount(1, $events);

        /** @var Event\AdminNameChanged $event */
        $event = $events[0];

        $this->assertSame(Event\AdminNameChanged::class, $event->eventName());
        $this->assertTrue($event->adminName()->equals($name));
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot|Admin
     */
    private function reconstituteAdminFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(Admin::class, $events);
    }

    /**
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Uuid $adminUserId
     *
     * @return Event\AdminCreated
     */
    public function newAdminCreated(Uuid $adminId, Name $adminName, Text $adminEmail, Uuid $adminUserId): Event\AdminCreated
    {
        return Event\AdminCreated::occur($adminId->toString(), [
            'first_name' => $adminName->firstName(),
            'last_name' => $adminName->lastName(),
            'email' => $adminEmail->toString(),
            'user_id' => $adminUserId->toString(),
        ]);
    }
}

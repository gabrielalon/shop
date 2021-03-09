<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\RefreshUserLocale\RefreshUserLocale;
use App\Components\Account\Infrastructure\Entity\User;
use App\Components\Site\Domain\Enum\LocaleEnum;
use Tests\TestCase;

class RefreshUserLocaleTest extends TestCase
{
    /**
     * @test
     */
    public function itRefreshesUserLocale(): void
    {
        // given
        /** @var User $user */
        $user = User::factory()->create();
        $locale = LocaleEnum::PL()->getValue();

        // when
        $this->messageBus()->handle(new RefreshUserLocale($user->id, $locale));

        // then
        $this->assertDatabaseHas('user', ['id' => $user->id, 'locale' => $locale]);
    }
}

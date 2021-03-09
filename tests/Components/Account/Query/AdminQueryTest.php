<?php

namespace Tests\Components\Account\Query;

use App\Components\Account\Application\Query\Exception\AdminNotFoundException;
use App\Components\Account\Infrastructure\Entity\Admin;
use Tests\TestCase;

class AdminQueryTest extends TestCase
{
    /**
     * @test
     */
    public function itFindsAdminById(): void
    {
        /** @var Admin $entity */
        $entity = Admin::factory()->create();

        $admin = $this->account()->askAdmin()->findAdminById($entity->id);

        $this->assertEquals($entity->id, $admin->id());
        $this->assertEquals($entity->user_id, $admin->userId());
        $this->assertEquals($entity->first_name, $admin->firstName());
        $this->assertEquals($entity->last_name, $admin->lastName());
        $this->assertEquals($entity->email, $admin->email());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnAdminByIdNotFound(): void
    {
        $this->expectException(AdminNotFoundException::class);
        $this->account()->askAdmin()->findAdminById($this->faker->uuid);
    }

    /**
     * @test
     */
    public function itFindsAdminByUserId(): void
    {
        /** @var Admin $entity */
        $entity = Admin::factory()->create();

        $admin = $this->account()->askAdmin()->findAdminByUserId($entity->user_id);

        $this->assertEquals($entity->id, $admin->id());
        $this->assertEquals($entity->user_id, $admin->userId());
        $this->assertEquals($entity->first_name, $admin->firstName());
        $this->assertEquals($entity->last_name, $admin->lastName());
        $this->assertEquals($entity->email, $admin->email());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnAdminByUserIdNotFound(): void
    {
        $this->expectException(AdminNotFoundException::class);
        $this->account()->askAdmin()->findAdminByUserId($this->faker->uuid);
    }
}

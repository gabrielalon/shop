<?php

namespace Tests\System\Valuing\Identity;

use App\System\Valuing\Identity\Uuid;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class UuidTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesUuidTest(): void
    {
        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $this->assertInstanceOf(Uuid::class, Uuid::fromIdentity($uuid));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnUuidCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Uuid::fromIdentity('xxx');
    }
}

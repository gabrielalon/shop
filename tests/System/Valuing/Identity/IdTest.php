<?php

namespace Tests\System\Valuing\Identity;

use App\System\Valuing\Identity\Id;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class IdTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesIdTest(): void
    {
        $id = 1;
        $this->assertInstanceOf(Id::class, Id::fromIdentity($id));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnIdCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Id::fromIdentity(0);
    }
}

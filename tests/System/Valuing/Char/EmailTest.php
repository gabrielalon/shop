<?php

namespace Tests\System\Valuing\Char;

use App\System\Valuing\Char\Email;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class EmailTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesEmailTest(): void
    {
        $this->assertInstanceOf(Email::class, Email::fromString('test@test.pl'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnEmailCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Email::fromString('xxx');
    }
}

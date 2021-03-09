<?php

namespace Tests\System\Valuing\Number;

use App\System\Valuing\Number\Number;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class NumberTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesQuantityTest(): void
    {
        $this->assertInstanceOf(Number::class, Number::fromInt(12));
    }
}

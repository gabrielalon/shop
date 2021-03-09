<?php

namespace Tests\System\Valuing\Number;

use App\System\Valuing\Number\Decimal;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class DecimalTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesDecimalTest(): void
    {
        $this->assertInstanceOf(Decimal::class, Decimal::fromFloat(12.2));
    }
}

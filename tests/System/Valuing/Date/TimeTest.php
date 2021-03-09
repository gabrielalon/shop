<?php

namespace Tests\System\Valuing\Date;

use App\System\Valuing\Date\Time;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class TimeTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesTimeTest(): void
    {
        $this->assertInstanceOf(Time::class, Time::fromTimestamp(\time()));
    }
}

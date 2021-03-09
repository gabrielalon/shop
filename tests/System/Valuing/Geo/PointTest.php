<?php

namespace Tests\System\Valuing\Geo;

use App\System\Valuing\Geo\Point;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class PointTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesPointTest(): void
    {
        $this->assertInstanceOf(Point::class, Point::fromCoordinates(12, 18));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itValidatesPointTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(Point::class, Point::fromCoordinates(92, 183));
    }
}

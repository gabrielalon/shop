<?php

namespace Tests\System\Valuing\Option;

use App\System\Valuing\Option\Check;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class CheckTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesCheckTest(): void
    {
        $this->assertInstanceOf(Check::class, Check::fromBoolean(true));
    }
}

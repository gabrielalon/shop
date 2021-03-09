<?php

namespace Tests\System\Valuing\Intl\Country;

use App\System\Valuing\Intl\Country\Code;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class CodeTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesPolishCountryTest(): void
    {
        $this->assertInstanceOf(Code::class, Code::fromCode('pl'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnCountryCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Code::fromCode('xx');
    }
}

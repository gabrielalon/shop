<?php

namespace Tests\System\Valuing\Intl\Country;

use App\System\Valuing\Intl\Country\Codes;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class CodesTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesPolishCountryTest(): void
    {
        $this->assertInstanceOf(Codes::class, Codes::fromArray(['pl']));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnCountryCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Codes::fromArray(['xx']);
    }
}

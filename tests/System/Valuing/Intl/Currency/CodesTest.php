<?php

namespace Tests\System\Valuing\Intl\Currency;

use App\System\Valuing\Intl\Currency\Codes;
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
    public function itCreatesPolishCurrencyTest(): void
    {
        $this->assertInstanceOf(Codes::class, Codes::fromArray(['PLN']));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnCurrencyCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Codes::fromArray(['xxx']);
    }
}

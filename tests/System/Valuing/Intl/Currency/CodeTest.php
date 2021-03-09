<?php

namespace Tests\System\Valuing\Intl\Currency;

use App\System\Valuing\Intl\Currency\Code;
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
    public function itCreatesPolishCurrencyTest(): void
    {
        $this->assertInstanceOf(Code::class, Code::fromCode('PLN'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnCurrencyCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Code::fromCode('xxx');
    }
}

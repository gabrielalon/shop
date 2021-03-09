<?php

namespace Tests\System\Valuing\Intl\Language;

use App\System\Valuing\Intl\Language\Codes;
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
    public function itCreatesPolishLanguageTest(): void
    {
        $this->assertInstanceOf(Codes::class, Codes::fromArray(['pl']));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnLanguageCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Codes::fromArray(['xx']);
    }
}

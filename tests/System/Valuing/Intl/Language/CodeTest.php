<?php

namespace Tests\System\Valuing\Intl\Language;

use App\System\Valuing\Intl\Language\Code;
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
    public function itCreatesPolishLocaleTest(): void
    {
        $this->assertInstanceOf(Code::class, Code::fromCode('pl'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnLocaleCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Code::fromCode('xx');
    }
}

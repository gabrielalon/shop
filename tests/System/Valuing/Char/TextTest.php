<?php

namespace Tests\System\Valuing\Char;

use App\System\Valuing\Char\Text;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class TextTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesTextTest(): void
    {
        $this->assertInstanceOf(Text::class, Text::fromString('lorem ipsum'));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnTextCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Text::fromString(str_repeat('lorem ipsum', pow(2, 8)));
    }
}

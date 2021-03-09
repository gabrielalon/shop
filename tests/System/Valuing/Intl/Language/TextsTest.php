<?php

namespace Tests\System\Valuing\Intl\Language;

use App\System\Valuing\Intl\Language\Texts;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class TextsTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesPolishLocalesTest(): void
    {
        $this->assertInstanceOf(Texts::class, Texts::fromArray(['pl' => 'translate']));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnLocalesCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Texts::fromArray(['xx' => 'translate']);
    }
}

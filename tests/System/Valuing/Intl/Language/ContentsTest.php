<?php

namespace Tests\System\Valuing\Intl\Language;

use App\System\Valuing\Intl\Language\Contents;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class ContentsTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesPolishLocalesTest(): void
    {
        $this->assertInstanceOf(Contents::class, Contents::fromArray(['pl' => 'translate']));
    }

    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function throwsExceptionOnLocalesCreateTest(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Contents::fromArray(['xx' => 'translate']);
    }
}

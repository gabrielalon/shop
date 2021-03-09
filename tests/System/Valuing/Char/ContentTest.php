<?php

namespace Tests\System\Valuing\Char;

use App\System\Valuing\Char\Content;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * @internal
 * @coversNothing
 */
class ContentTest extends PHPUnitTestCase
{
    /**
     * @test
     *
     * @throws \InvalidArgumentException
     */
    public function itCreatesContentTest(): void
    {
        $this->assertInstanceOf(Content::class, Content::fromString('lorem ipsum'));
    }
}

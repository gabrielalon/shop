<?php

namespace Tests\Components\Content;

use App\Components\Content\Content;
use App\System\Valuing\Identity\Uuid;
use Illuminate\Support\Str;

trait ContentContext
{
    /**
     * @return array[]
     */
    public function blogCategoryDataProvider(): array
    {
        return [[
            Uuid::fromIdentity(Str::uuid()->toString()),
        ]];
    }

    /**
     * @return array[]
     */
    public function blogEntryDataProvider(): array
    {
        return [[
            Uuid::fromIdentity(Str::uuid()->toString()),
        ]];
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return $this->app->get(Content::class);
    }
}

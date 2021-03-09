<?php

namespace App\Components\Content\Domain\Event;

use App\System\Valuing\Option\Check;

class BlogEntryDeactivated extends BlogEntryActivated
{
    /**
     * @return Check
     */
    public function blogEntryActive(): Check
    {
        return Check::fromBoolean(false);
    }
}

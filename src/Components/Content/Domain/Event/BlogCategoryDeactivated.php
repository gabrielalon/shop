<?php

namespace App\Components\Content\Domain\Event;

use App\System\Valuing\Option\Check;

class BlogCategoryDeactivated extends BlogCategoryActivated
{
    /**
     * @return Check
     */
    public function blogCategoryActive(): Check
    {
        return Check::fromBoolean(false);
    }
}

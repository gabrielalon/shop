<?php

namespace App\Components\Content\Application\Validator;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class BlogCategoryValidatorFactory
{
    /** @var Factory */
    private $factory;

    /**
     * TicketValidatorFactory constructor.
     *
     * @param Factory $factory
     */
    private function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Factory $factory
     *
     * @return BlogCategoryValidatorFactory
     */
    public static function initialize(Factory $factory): BlogCategoryValidatorFactory
    {
        return new BlogCategoryValidatorFactory($factory);
    }

    /**
     * @param string $blogCategoryId
     *
     * @return Validator
     */
    public function exists(string $blogCategoryId): Validator
    {
        return $this->factory->make(['blog_category_id' => $blogCategoryId], [
            'blog_category_id' => 'required|exists:blog_category,id|uuid',
        ]);
    }
}

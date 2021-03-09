<?php

namespace App\Components\Content\Application\Validator;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class BlogEntryValidatorFactory
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
     * @return BlogEntryValidatorFactory
     */
    public static function initialize(Factory $factory): BlogEntryValidatorFactory
    {
        return new BlogEntryValidatorFactory($factory);
    }

    /**
     * @param string $blogEntryId
     *
     * @return Validator
     */
    public function exists(string $blogEntryId): Validator
    {
        return $this->factory->make(['blog_entry_id' => $blogEntryId], [
            'blog_entry_id' => 'required|exists:blog_entry,id|uuid',
        ]);
    }
}

<?php

namespace App\Components\Content\Infrastructure\Response;

use App\Components\Content\Application\Query\Model\BlogCategory;
use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\System\Illuminate\Service\AuthService;

class BlogCategoryCollectionTransformer
{
    /** @var AuthService */
    private $authService;

    /**
     * BlogCategoryCollectionTransformer constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param BlogCategoryCollection $collection
     *
     * @return array
     */
    public function transform(BlogCategoryCollection $collection): array
    {
        return array_values(array_map(
            [$this, 'transformCategory'],
            $collection->all())
        );
    }

    /**
     * @param BlogCategory $category
     *
     * @return array
     */
    private function transformCategory(BlogCategory $category): array
    {
        return [
            'value' => $category->id(),
            'text' => $category->name($this->authService->user()->locale()),
        ];
    }
}

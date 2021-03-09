<?php

namespace App\Components\Content;

use App\Components\Content\Application\Query\BlogQuery;
use App\Components\Content\Application\Query\BlogTreeQuery;
use App\Components\Content\Application\Saga\Scenario;
use App\Components\Content\Application\Service\SystemSettingRegistry;
use App\Components\Content\Application\Validator\BlogCategoryValidatorFactory;
use App\Components\Content\Application\Validator\BlogEntryValidatorFactory;
use App\System\Messaging\MessageBus;
use App\System\Messaging\Query\Query;
use App\System\Messaging\Saga\SagaProcessor;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory;
use Webmozart\Assert\Assert;

class Content
{
    /** @var Factory */
    private $factory;

    /** @var MessageBus */
    private $messageBus;

    /** @var SagaProcessor */
    private $sagaProcessor;

    /** @var SystemSettingRegistry */
    private $settingRegistry;

    /**
     * Content constructor.
     *
     * @param Factory               $factory
     * @param MessageBus            $messageBus
     * @param SagaProcessor         $sagaProcessor
     * @param SystemSettingRegistry $settingRegistry
     */
    public function __construct(
        Factory $factory,
        MessageBus $messageBus,
        SagaProcessor $sagaProcessor,
        SystemSettingRegistry $settingRegistry
    ) {
        $this->factory = $factory;
        $this->messageBus = $messageBus;
        $this->sagaProcessor = $sagaProcessor;
        $this->settingRegistry = $settingRegistry;
    }

    /**
     * @param string[] $name
     *
     * @throws \Exception
     */
    public function createBlogCategory(array $name): void
    {
        $this->sagaProcessor->run(new Scenario\BlogCategoryCreated(
            $id = Str::uuid()->toString(),
            $name
        ));
    }

    /**
     * @param array $data
     *
     * @throws \Exception
     */
    public function sortBlogCategory(array $data): void
    {
        $this->sagaProcessor->run(new Scenario\BlogCategorySorted($data));
    }

    /**
     * @param string   $categoryId
     * @param string[] $name
     *
     * @throws \Exception
     */
    public function updateBlogCategory(string $categoryId, array $name): void
    {
        $this->assertBlogCategoryIdExists($categoryId);
        $this->sagaProcessor->run(new Scenario\BlogCategoryUpdated(
            $categoryId,
            $name
        ));
    }

    /**
     * @param string $categoryId
     *
     * @throws \Exception
     */
    public function activateBlogCategory(string $categoryId): void
    {
        $this->assertBlogCategoryIdExists($categoryId);
        $this->sagaProcessor->run(new Scenario\BlogCategoryActivated($categoryId));
    }

    /**
     * @param string $categoryId
     *
     * @throws \Exception
     */
    public function deactivateBlogCategory(string $categoryId): void
    {
        $this->assertBlogCategoryIdExists($categoryId);
        $this->sagaProcessor->run(new Scenario\BlogCategoryDeactivated($categoryId));
    }

    /**
     * @param string $categoryId
     *
     * @throws \Exception
     */
    public function removeBlogCategory(string $categoryId): void
    {
        $this->assertBlogCategoryIdExists($categoryId);
        $this->sagaProcessor->run(new Scenario\BlogCategoryRemoved($categoryId));
    }

    /**
     * @param string $categoryId
     *
     * @throws \InvalidArgumentException
     */
    private function assertBlogCategoryIdExists(string $categoryId): void
    {
        Assert::false(
            $this->blogCategoryValidator()->exists($categoryId)->fails(),
            \sprintf('Blog category does not exist on given id: %s.', $categoryId)
        );
    }

    /**
     * @return BlogCategoryValidatorFactory
     */
    public function blogCategoryValidator(): BlogCategoryValidatorFactory
    {
        return BlogCategoryValidatorFactory::initialize($this->factory);
    }

    /**
     * @param string[] $name
     * @param string[] $description
     * @param Carbon   $publishAt
     * @param string[] $categoriesID
     *
     * @throws \Exception
     */
    public function createBlogEntry(
        array $name,
        array $description,
        Carbon $publishAt,
        array $categoriesID
    ): void {
        $this->sagaProcessor->run(new Scenario\BlogEntryCreated(
            $id = Str::uuid()->toString(),
            $name,
            $description,
            $publishAt,
            $categoriesID
        ));
    }

    /**
     * @param string   $entryId
     * @param string[] $name
     * @param string[] $description
     * @param Carbon   $publishAt
     * @param string[] $categoriesID
     *
     * @throws \Exception
     */
    public function updateBlogEntry(
        string $entryId,
        array $name,
        array $description,
        Carbon $publishAt,
        array $categoriesID
    ): void {
        $this->assertBlogEntryIdExists($entryId);
        $this->sagaProcessor->run(new Scenario\BlogEntryUpdated(
            $entryId,
            $name,
            $description,
            $publishAt,
            $categoriesID
        ));
    }

    /**
     * @param string $entryId
     *
     * @throws \Exception
     */
    public function activateBlogEntry(string $entryId): void
    {
        $this->assertBlogEntryIdExists($entryId);
        $this->sagaProcessor->run(new Scenario\BlogEntryActivated($entryId));
    }

    /**
     * @param string $entryId
     *
     * @throws \Exception
     */
    public function deactivateBlogEntry(string $entryId): void
    {
        $this->assertBlogEntryIdExists($entryId);
        $this->sagaProcessor->run(new Scenario\BlogEntryDeactivated($entryId));
    }

    /**
     * @param string $entryId
     *
     * @throws \Exception
     */
    public function removeBlogEntry(string $entryId): void
    {
        $this->assertBlogEntryIdExists($entryId);
        $this->sagaProcessor->run(new Scenario\BlogEntryRemoved($entryId));
    }

    /**
     * @param string $entryId
     *
     * @throws \InvalidArgumentException
     */
    private function assertBlogEntryIdExists(string $entryId): void
    {
        Assert::false(
            $this->blogEntryValidator()->exists($entryId)->fails(),
            \sprintf('Blog entry does not exist on given id: %s.', $entryId)
        );
    }

    /**
     * @return BlogEntryValidatorFactory
     */
    public function blogEntryValidator(): BlogEntryValidatorFactory
    {
        return BlogEntryValidatorFactory::initialize($this->factory);
    }

    /**
     * @return BlogQuery|Query
     */
    public function askBlog(): BlogQuery
    {
        return $this->messageBus->query(BlogQuery::class);
    }

    /**
     * @return BlogTreeQuery|Query
     */
    public function askBlogTree(): BlogTreeQuery
    {
        return $this->messageBus->query(BlogTreeQuery::class);
    }

    /**
     * @return SystemSettingRegistry
     */
    public function systemSettingRegistry(): SystemSettingRegistry
    {
        return $this->settingRegistry;
    }
}

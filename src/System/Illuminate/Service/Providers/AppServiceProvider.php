<?php

namespace App\System\Illuminate\Service\Providers;

use App\Components\Account\Application\Query\AdminQuery;
use App\Components\Account\Application\Query\RoleQuery;
use App\Components\Account\Application\Query\UserQuery;
use App\Components\Account\Application\Saga\AdminSaga;
use App\Components\Account\Domain\AuthProvider;
use App\Components\Account\Domain\Persist\AdminRepository;
use App\Components\Account\Domain\Persist\UserRepository;
use App\Components\Account\Domain\Projection\AdminProjection;
use App\Components\Account\Domain\Projection\UserProjection;
use App\Components\Account\Infrastructure\Persist\AdminAggregateRepository;
use App\Components\Account\Infrastructure\Persist\UserAggregateRepository;
use App\Components\Account\Infrastructure\Projection\AdminEloquentProjector;
use App\Components\Account\Infrastructure\Projection\UserEloquentProjector;
use App\Components\Account\Infrastructure\Query\AdminEloquentQuery;
use App\Components\Account\Infrastructure\Query\RoleEloquentQuery;
use App\Components\Account\Infrastructure\Query\UserEloquentQuery;
use App\Components\Account\Infrastructure\Service\UserAuthProvider;
use App\Components\Content\Application\Query\BlogQuery;
use App\Components\Content\Application\Query\BlogTreeQuery;
use App\Components\Content\Application\Saga\BlogCategorySaga;
use App\Components\Content\Application\Saga\BlogEntrySaga;
use App\Components\Content\Application\Service\SystemSettingRegistry;
use App\Components\Content\Domain\Persist\BlogCategoryRepository;
use App\Components\Content\Domain\Persist\BlogEntryRepository;
use App\Components\Content\Domain\Projection\BlogCategoryProjection;
use App\Components\Content\Domain\Projection\BlogEntryProjection;
use App\Components\Content\Infrastructure\Persist\BlogCategoryAggregateRepository;
use App\Components\Content\Infrastructure\Persist\BlogEntryAggregateRepository;
use App\Components\Content\Infrastructure\Projection\BlogCategoryEloquentProjector;
use App\Components\Content\Infrastructure\Projection\BlogEntryEloquentProjector;
use App\Components\Content\Infrastructure\Query\BlogEloquentQuery;
use App\Components\Content\Infrastructure\Query\BlogEloquentTreeQuery;
use App\Components\Site\Application\Query\CountryQuery;
use App\Components\Site\Application\Query\LanguageQuery;
use App\Components\Site\Infrastructure\Query\CountryEloquentQuery;
use App\Components\Site\Infrastructure\Query\LanguageEloquentQuery;
use App\Integrations\Gus\ClientFacade;
use App\System\Messaging\Event\EventStreamRepository;
use App\System\Messaging\Integration\Persist\EventStreamEloquentRepository;
use App\System\Messaging\Integration\Persist\SnapshotEloquentRepository;
use App\System\Messaging\Integration\Persist\StateEloquentRepository;
use App\System\Messaging\Saga\Metadata\MetadataFactory;
use App\System\Messaging\Saga\Metadata\SagaMetadataFactory;
use App\System\Messaging\Saga\SagaRegistry;
use App\System\Messaging\Saga\State\StateRepository;
use App\System\Messaging\Snapshot\SnapshotRepository;
use App\System\Spatie\Integration\Service\MediaSpatieService;
use App\System\Spatie\Media\MediaService;

class AppServiceProvider extends SupportServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function regularBindings(): array
    {
        return [
            AdminProjection::class => AdminEloquentProjector::class,
            AdminRepository::class => AdminAggregateRepository::class,
            AdminQuery::class => AdminEloquentQuery::class,

            BlogCategoryProjection::class => BlogCategoryEloquentProjector::class,
            BlogCategoryRepository::class => BlogCategoryAggregateRepository::class,
            BlogEntryProjection::class => BlogEntryEloquentProjector::class,
            BlogEntryRepository::class => BlogEntryAggregateRepository::class,
            BlogTreeQuery::class => BlogEloquentTreeQuery::class,
            BlogQuery::class => BlogEloquentQuery::class,

            CountryQuery::class => CountryEloquentQuery::class,

            EventStreamRepository::class => EventStreamEloquentRepository::class,

            LanguageQuery::class => LanguageEloquentQuery::class,

            MediaService::class => MediaSpatieService::class,
            MetadataFactory::class => SagaMetadataFactory::class,

            RoleQuery::class => RoleEloquentQuery::class,

            SnapshotRepository::class => SnapshotEloquentRepository::class,
            StateRepository::class => StateEloquentRepository::class,

            UserProjection::class => UserEloquentProjector::class,
            UserRepository::class => UserAggregateRepository::class,
            UserQuery::class => UserEloquentQuery::class,

            AuthProvider::class => UserAuthProvider::class,
        ];
    }

    public function register(): void
    {
        parent::register();

        $this->app->singleton(SagaRegistry::class);
        $this->app->singleton(SystemSettingRegistry::class);

        $this->app->singleton(ClientFacade::class, function ($app) {
            return new ClientFacade(env('GUS_KEY', ''));
        });
    }

    public function boot(): void
    {
        $this->app->make(SagaRegistry::class)
            ->register($this->app->get(AdminSaga::class))
            ->register($this->app->get(BlogCategorySaga::class))
            ->register($this->app->get(BlogEntrySaga::class))
        ;
    }
}

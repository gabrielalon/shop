<?php

namespace App\System\Illuminate\Service\Providers;

use App\Components\Account\Application\Query\Model\User;
use App\Components\Account\Domain\AuthProvider;
use App\Components\Account\Infrastructure\Entity\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('users', function () {
            return $this->app->get(AuthProvider::class);
        });

//        $permissions = Permission::query()->pluck('type');
//        $permissions->each(function(string $ability) {
//            Gate::define($ability, function (User $user) use ($ability) {
//                $userPermissions = new Collection($user->permissions());
//
//                $altPermissions = $this->altPermissions($ability);
//                return null !== $userPermissions->first(function (string $ident) use($altPermissions) {
//                    return \in_array($ident, $altPermissions, true);
//                });
//            });
//        });
    }

    private function altPermissions($permission)
    {
        $altPermissions = ['*', $permission];
        $permParts = explode('.', $permission);

        $currentPermission = '';
        for ($i = 0; $i < (count($permParts) - 1); ++$i) {
            $currentPermission .= $permParts[$i].'.';
            $altPermissions[] = $currentPermission.'*';
        }

        return $altPermissions;
    }
}

<?php

declare(strict_types=1);

namespace BombenProdukt\Pathfinder;

use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;
use Illuminate\Routing\Route as BoundRoute;
use Illuminate\Support\Facades\Route;

final class ServiceProvider extends AbstractServiceProvider
{
    private array $verbs = [
        'delete',
        'get',
        'patch',
        'post',
        'put',
    ];

    public function packageRegistered(): void
    {
        foreach ($this->verbs as $verb) {
            Route::macro("{$verb}Matched", function (string $uri, array|string|callable|null $action = null) use ($verb): BoundRoute {
                $route = Route::$verb($uri, $action);

                Pathfinder::apply($uri, $route);

                return $route;
            });
        }
    }
}

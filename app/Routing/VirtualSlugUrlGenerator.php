<?php

namespace App\Routing;

use App\Support\VirtualSlug;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;

class VirtualSlugUrlGenerator extends UrlGenerator
{
    /**
     * Get the URL for a given route instance, automatically converting numeric IDs
     * in route path parameters into non-DB signed virtual slugs.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    public function toRoute($route, $parameters, $absolute)
    {
        $routeParams = $route->parameterNames();

        if (! empty($routeParams)) {
            $parameters = Arr::wrap($parameters);
            $routeName = (string) ($route->getName() ?? '');

            foreach ($routeParams as $idx => $paramName) {
                if (array_key_exists($paramName, $parameters)) {
                    $val = $parameters[$paramName];
                    if (is_int($val) || (is_string($val) && ctype_digit($val))) {
                        $parameters[$paramName] = VirtualSlug::forRouteParam($routeName, $paramName, (int) $val);
                    }
                } elseif (array_key_exists($idx, $parameters)) {
                    $val = $parameters[$idx];
                    if (is_int($val) || (is_string($val) && ctype_digit($val))) {
                        $parameters[$idx] = VirtualSlug::forRouteParam($routeName, $paramName, (int) $val);
                    }
                }
            }
        }

        return parent::toRoute($route, $parameters, $absolute);
    }
}


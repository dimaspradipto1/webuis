<?php

namespace App\Http\Middleware;

use App\Support\VirtualSlug;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecodeVirtualSlugParameters
{
    /**
     * Decode signed virtual slug route parameters back into numeric IDs before
     * controller execution / route model binding, and redirect raw numeric GET URLs
     * to their canonical virtual slug URL.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        if (! $route) {
            return $next($request);
        }

        $params = $route->parameters();
        if (empty($params)) {
            return $next($request);
        }

        $hasRawNumericId = false;

        foreach ($params as $paramName => $paramValue) {
            if (! is_string($paramValue) && ! is_int($paramValue)) {
                continue;
            }

            $strVal = (string) $paramValue;

            if (ctype_digit($strVal)) {
                $hasRawNumericId = true;
                continue;
            }

            if (VirtualSlug::isSignedSlug($strVal)) {
                $decodedId = VirtualSlug::decode($strVal);
                if ($decodedId !== null) {
                    $route->setParameter($paramName, (string) $decodedId);
                    $request->attributes->set('_virtual_slug_decoded', true);
                }
            }
        }

        // Redirect raw numeric GET URLs (e.g. /gallery/1/edit) to the virtual slug URL
        if (
            $hasRawNumericId
            && $request->isMethod('GET')
            && ! $request->ajax()
            && ! $request->expectsJson()
            && $route->getName()
        ) {
            try {
                $canonicalUrl = route($route->getName(), $params);
                if ($request->getQueryString()) {
                    $canonicalUrl .= (str_contains($canonicalUrl, '?') ? '&' : '?') . $request->getQueryString();
                }
                if ($canonicalUrl !== $request->fullUrl()) {
                    return redirect()->to($canonicalUrl);
                }
            } catch (\Throwable $e) {
                // Ignore if route cannot be generated
            }
        }

        return $next($request);
    }
}


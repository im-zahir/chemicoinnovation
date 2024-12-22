<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    /**
     * Pages that should not be cached
     */
    private array $excludedPaths = [
        '/admin/*',
        '/login',
        '/logout',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't cache non-GET requests or excluded paths
        if (!$request->isMethod('GET') || $this->isExcluded($request->path())) {
            return $next($request);
        }

        // Generate a unique cache key based on URL and query parameters
        $key = $this->generateCacheKey($request);

        // Try to get from cache
        if (Cache::has($key)) {
            $cachedResponse = Cache::get($key);
            return response($cachedResponse['content'])
                ->header('Content-Type', $cachedResponse['content_type'])
                ->header('X-Cache', 'HIT');
        }

        // Get the response
        $response = $next($request);

        // Only cache successful responses
        if ($response->isSuccessful()) {
            Cache::put($key, [
                'content' => $response->getContent(),
                'content_type' => $response->headers->get('Content-Type'),
            ], now()->addHours(24));

            $response->header('X-Cache', 'MISS');
        }

        return $response;
    }

    /**
     * Generate a unique cache key for the request
     */
    private function generateCacheKey(Request $request): string
    {
        $url = $request->fullUrl();
        return 'page_cache.' . sha1($url);
    }

    /**
     * Check if the path should be excluded from caching
     */
    private function isExcluded(string $path): bool
    {
        foreach ($this->excludedPaths as $excludedPath) {
            // Use fnmatch for wildcard path matching
            if (fnmatch($excludedPath, $path)) {
                return true;
            }
        }
        return false;
    }
}

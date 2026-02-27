<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ApiCatalogController extends Controller
{
    public function index(): View
    {
        $catalog = config('api-catalog.modules', []);
        $stats   = $this->buildStats($catalog);

        return view('dev.api-catalog', compact('catalog', 'stats'));
    }

    public function probe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'method' => 'required|in:GET,POST,PATCH,PUT,DELETE',
            'uri'    => 'required|string',
            'params' => 'nullable|array',
        ]);

        $baseUrl = config('app.url');
        $uri     = ltrim($validated['uri'], '/');
        $method  = strtolower($validated['method']);
        $params  = $validated['params'] ?? [];

        $cookies = $request->cookies->all();

        $start = microtime(true);

        try {
            $http = Http::withCookies($cookies, parse_url($baseUrl, PHP_URL_HOST))
                ->withHeaders([
                    'Accept'       => 'application/json',
                    'X-CSRF-TOKEN' => csrf_token(),
                    'Referer'      => $baseUrl,
                ]);

            if ($method === 'get') {
                $response = $http->get("{$baseUrl}/{$uri}", $params);
            } else {
                $response = $http->{$method}("{$baseUrl}/{$uri}", $params);
            }

            $duration = round((microtime(true) - $start) * 1000);

            return response()->json([
                'status'   => $response->status(),
                'duration' => $duration,
                'headers'  => $response->headers(),
                'body'     => $response->json() ?? $response->body(),
                'ok'       => $response->successful(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'   => 500,
                'duration' => 0,
                'error'    => $e->getMessage(),
                'ok'       => false,
            ], 500);
        }
    }

    private function buildStats(array $catalog): array
    {
        $total      = 0;
        $active     = 0;
        $planned    = 0;
        $deprecated = 0;

        foreach ($catalog as $module) {
            foreach ($module['endpoints'] as $endpoint) {
                $total++;
                match ($endpoint['status'] ?? 'active') {
                    'active'     => $active++,
                    'planned'    => $planned++,
                    'deprecated' => $deprecated++,
                    default      => null,
                };
            }
        }

        return compact('total', 'active', 'planned', 'deprecated');
    }
}

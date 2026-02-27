<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Route;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Lista todas as rotas registradas na aplicação com método HTTP, URI, nome e action.')]
class RoutesTool extends Tool
{
    public function handle(Request $request): Response
    {
        $filter = $request->input('filter', '');

        $routes = collect(Route::getRoutes()->getRoutes())
            ->map(fn ($route) => sprintf(
                '%-8s %-50s %-30s %s',
                implode('|', $route->methods()),
                $route->uri(),
                $route->getName() ?? '-',
                $route->getActionName()
            ))
            ->when($filter, fn ($col) => $col->filter(
                fn ($line) => str_contains(strtolower($line), strtolower($filter))
            ))
            ->values();

        if ($routes->isEmpty()) {
            return Response::text('Nenhuma rota encontrada' . ($filter ? " para o filtro '{$filter}'" : '') . '.');
        }

        $header = sprintf('%-8s %-50s %-30s %s', 'METHOD', 'URI', 'NAME', 'ACTION');
        $separator = str_repeat('-', 120);

        return Response::text($header . "\n" . $separator . "\n" . $routes->implode("\n"));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'filter' => $schema->string()->description('Filtro opcional para URI, nome ou action (ex: "api", "auth", "user")'),
        ];
    }
}

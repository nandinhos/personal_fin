<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Artisan;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Executa comandos artisan do Laravel. Use para rodar migrations, seeders, tinker, etc.')]
class ArtisanTool extends Tool
{
    public function handle(Request $request): Response
    {
        $command = $request->input('command', '');

        if (empty($command)) {
            return Response::text('Erro: o parâmetro "command" é obrigatório.');
        }

        $blocked = ['serve', 'tinker', 'queue:work', 'queue:listen', 'schedule:work'];
        foreach ($blocked as $b) {
            if (str_starts_with(trim($command), $b)) {
                return Response::text("Comando bloqueado: '{$b}' requer interação contínua e não é suportado via MCP.");
            }
        }

        try {
            $parts = explode(' ', $command, 2);
            $artisanCommand = $parts[0];
            $arguments = isset($parts[1]) ? $this->parseArguments($parts[1]) : [];

            Artisan::call($artisanCommand, $arguments);
            $output = Artisan::output();

            return Response::text($output ?: 'Comando executado com sucesso (sem output).');
        } catch (\Throwable $e) {
            return Response::text('Erro: ' . $e->getMessage());
        }
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'command' => $schema->string()->description('Comando artisan a executar (ex: migrate, db:seed, route:list)')->required(),
        ];
    }

    private function parseArguments(string $args): array
    {
        $parsed = [];
        preg_match_all('/--(\w[\w-]*)(?:=([^\s]+))?/', $args, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $parsed['--' . $match[1]] = $match[2] ?? true;
        }
        return $parsed;
    }
}

<?php

namespace App\Mcp\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Lê as últimas linhas do log da aplicação Laravel (storage/logs/laravel.log).')]
class LogsTool extends Tool
{
    public function handle(Request $request): Response
    {
        $lines = (int) $request->input('lines', 50);
        $lines = max(1, min($lines, 500));

        $logPath = storage_path('logs/laravel.log');

        if (! file_exists($logPath)) {
            return Response::text('Arquivo de log não encontrado: ' . $logPath);
        }

        $content = $this->tailFile($logPath, $lines);

        if (empty(trim($content))) {
            return Response::text('Log vazio.');
        }

        return Response::text($content);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'lines' => $schema->integer()->description('Número de linhas finais a retornar (padrão: 50, máximo: 500)'),
        ];
    }

    private function tailFile(string $path, int $lines): string
    {
        $file = new \SplFileObject($path);
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();

        $startLine = max(0, $totalLines - $lines);
        $output = [];

        $file->seek($startLine);
        while (! $file->eof()) {
            $output[] = $file->current();
            $file->next();
        }

        return implode('', $output);
    }
}

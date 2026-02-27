<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\ArtisanTool;
use App\Mcp\Tools\LogsTool;
use App\Mcp\Tools\RoutesTool;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('boost')]
#[Version('1.0.0')]
#[Instructions('Servidor MCP do projeto personal_fin. Ferramentas: executar artisan, listar rotas e ler logs da aplicação.')]
class boost extends Server
{
    protected array $tools = [
        ArtisanTool::class,
        RoutesTool::class,
        LogsTool::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}

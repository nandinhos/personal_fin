# Lições Aprendidas - Laravel 12 MCP (Laravel Boost)

## O que mudou no Laravel 12
Anteriormente, utilizava-se o pacote `nando-goncalves/laravel-boost`. No Laravel 12, o ecossistema oficial utiliza o pacote `laravel/mcp`.

### Instalação
Sempre instale como dependência de desenvolvimento no ambiente Docker:
```bash
docker exec <container_name> composer require laravel/mcp --dev
```

### Comandos Artisan
Os comandos mudaram de `boost:mcp` para `mcp:start`. Além disso, o Laravel 12 exige a criação de um servidor específico.

### Fluxo de Configuração
1. Instalar pacote: `composer require laravel/mcp`
2. Criar servidor: `php artisan make:mcp-server boost`
3. Configurar no `.mcp.json`:
```json
"laravel-boost": {
  "command": "docker",
  "args": ["compose", "exec", "-T", "laravel.test", "php", "artisan", "mcp:start", "boost"]
}
```

### Problemas Comuns
- **EACCES**: Arquivos criados via `docker exec` pertencem ao `root`. Sempre execute `sudo chown -R $USER:$USER .` após criar classes.
- **Handle**: O comando `mcp:start` SEMPRE exige o nome (handle) do servidor criado.

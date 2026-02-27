---
titulo: "Configuração do MCP no Laravel 12 — pacote oficial laravel/mcp"
data: 2026-02-27
stack: Laravel 12, Docker
categoria: config
scope: global
tags: [laravel, laravel-12, mcp, docker, artisan]
---

# Laravel 12 — Configuração do MCP (Model Context Protocol)

## Contexto

No Laravel 12, o suporte a MCP (Model Context Protocol) passou a ser feito pelo pacote oficial `laravel/mcp`. Projetos migrados do Laravel 10/11 que usavam o pacote comunitário `nando-goncalves/laravel-boost` precisam atualizar o fluxo.

## Problema

Tentar usar `boost:mcp` ou instalar `nando-goncalves/laravel-boost` no Laravel 12 resulta em incompatibilidade. Os comandos Artisan e a estrutura de servidores mudaram.

## Causa Raiz

O ecossistema MCP para Laravel foi unificado no pacote oficial `laravel/mcp` a partir da versão 12. A nomenclatura de comandos e a forma de registrar servidores foi redesenhada.

## Solução

### 1. Instalar o pacote

Sempre como dependência de desenvolvimento, dentro do container Docker:

```bash
docker exec <container_name> composer require laravel/mcp --dev
```

### 2. Criar o servidor MCP

```bash
php artisan make:mcp-server boost
```

Isso cria `app/Mcp/Servers/boost.php`.

### 3. Configurar o `.mcp.json`

```json
"laravel-boost": {
  "command": "docker",
  "args": ["compose", "exec", "-T", "laravel.test", "php", "artisan", "mcp:start", "boost"]
}
```

### 4. Iniciar o servidor

```bash
php artisan mcp:start boost
```

O nome (`boost`) é obrigatório — `mcp:start` sem argumento gera erro.

## Problemas Comuns

| Erro | Causa | Solução |
|------|-------|---------|
| `EACCES` | Arquivos criados via `docker exec` pertencem ao `root` | `sudo chown -R $USER:$USER .` |
| `mcp:start` sem argumento | Handle do servidor não informado | Sempre passar o nome: `mcp:start boost` |

## Prevenção

- Instalar `laravel/mcp` via Docker exec (não diretamente no host)
- Corrigir permissões após criação de classes pelo container
- Documentar o handle do servidor no README do projeto

## Referências

- Origem: `.aidev/docs/lessons/laravel-12-mcp-setup.md`
- Arquivo de servidor criado: `app/Mcp/Servers/boost.php`
- Configuração: `.mcp.json`

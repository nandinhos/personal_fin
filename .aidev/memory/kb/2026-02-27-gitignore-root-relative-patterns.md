---
titulo: "Padrões root-relative no .gitignore do Laravel não cobrem subdiretórios"
data: 2026-02-27
stack: Laravel, git
categoria: config
scope: global
tags: [git, gitignore, laravel, vendor, node_modules, first-commit]
---

# .gitignore — Padrões Root-Relative Não Cobrem Subdiretórios

## Contexto

O `.gitignore` padrão gerado pelo Laravel usa padrões com barra inicial (`/vendor`, `/node_modules`). Esses padrões são **root-relative**: só ignoram o diretório na raiz do projeto, não em subpastas.

## Problema

No primeiro `git add .` do projeto `personal_fin`, o `git status --short | wc -l` retornou **8.599 arquivos** — muito acima do esperado.

O diretório `tmp_laravel/` (usado durante o setup via script) continha `tmp_laravel/vendor/` com todos os pacotes do Composer. Como o `.gitignore` só ignorava `/vendor` (raiz), o `tmp_laravel/vendor` foi completamente staged.

## Causa Raiz

```
# .gitignore do Laravel
/vendor       ← ignora apenas vendor/ na raiz
/node_modules ← ignora apenas node_modules/ na raiz
```

Padrões sem `/` inicial (ex: `vendor`) seriam ignorados em qualquer nível. Com `/`, o Git restringe à raiz.

## Solução

Adicionar o diretório temporário explicitamente ao `.gitignore` antes do primeiro commit:

```bash
# .gitignore
/tmp_laravel
```

Unstage e re-stage após a correção:

```bash
git rm -r --cached tmp_laravel
git add .
```

## Prevenção

Antes do primeiro commit em qualquer projeto Laravel, verificar o número de arquivos staged:

```bash
git add .
git status --short | wc -l
```

Se o número for maior que ~300, investigar antes de commitar. Padrão esperado para Laravel limpo: ~180–220 arquivos.

Diretórios temporários de setup (`tmp_*`, `setup_*`, `scratch_*`) devem ser adicionados ao `.gitignore` imediatamente ao serem criados.

## Referências

- Commit inicial do projeto `personal_fin`: `dbba632`
- Correção do `.gitignore`: linha adicionada `/tmp_laravel`

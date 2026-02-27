---
titulo: "git init cria branch master, não main"
data: 2026-02-27
stack: git
categoria: config
scope: universal
tags: [git, branch, github, init]
---

# git init — Branch Default é master, não main

## Contexto

Ao inicializar um repositório Git com `git init`, a branch criada por padrão se chama `master`. O GitHub e a convenção moderna adotam `main` como padrão. Isso gera divergência no push inicial e warnings do Git.

## Problema

```bash
$ git init
hint: Using 'master' as the name for the initial branch.
hint: ...Names commonly chosen instead of 'master' are 'main', 'trunk'...
```

Ao fazer `git push -u origin main`, o branch local `master` não encontra `main` no remote, causando erro ou push para branch errada.

## Causa Raiz

O Git não tem `init.defaultBranch` configurado globalmente na máquina. Sem essa configuração, o padrão histórico `master` é usado.

## Solução

Renomear imediatamente após o `git init`:

```bash
git init
git branch -m main
```

## Prevenção

Configurar globalmente para que todos os próximos repositórios usem `main`:

```bash
git config --global init.defaultBranch main
```

## Referências

- Commit inicial do projeto `personal_fin`: `dbba632`

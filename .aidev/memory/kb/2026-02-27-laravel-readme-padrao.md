---
titulo: "README padrão do Laravel não reflete o projeto — deve ser substituído no onboarding"
data: 2026-02-27
stack: Laravel
categoria: success-pattern
scope: global
tags: [laravel, readme, documentacao, onboarding, projeto]
---

# Laravel — README Padrão Não Reflete o Projeto

## Contexto

O comando `laravel new` (ou instalação via Composer) copia o README oficial do framework Laravel como arquivo do projeto. Esse README contém informações sobre o *framework*, não sobre a aplicação sendo desenvolvida.

## Problema

Após o primeiro commit, o `README.md` na raiz do repositório continha:
- Logo do Laravel
- Badges do repositório oficial `laravel/framework`
- Descrição do framework Laravel
- Links para documentação e parceiros do Laravel
- Seção de contribuição do *framework* (não do projeto)

Isso confunde qualquer desenvolvedor (ou ferramenta) que acessa o repositório pela primeira vez.

## Causa Raiz

O Laravel usa seu próprio README como template para novos projetos. Não há diferenciação entre o README do framework e o README do projeto criado.

## Solução

Substituir o README imediatamente no início do projeto com conteúdo real:

- Nome e descrição do projeto
- Stack técnica real (versões específicas)
- Tabela de funcionalidades com status
- Instruções de instalação (com e sem Docker)
- Roadmap visual
- Modelo de dados macro
- Guia de contribuição com padrão de commits do projeto

## Prevenção

Adicionar ao checklist de onboarding de todo novo projeto Laravel:

```markdown
- [ ] Substituir README.md com conteúdo real do projeto
- [ ] Incluir badges da stack real (não do framework)
- [ ] Documentar instruções de setup (Docker e local)
- [ ] Definir padrão de commits do projeto
```

O README deve ser tratado como **documentação viva** — atualizado a cada sprint concluída.

## Referências

- Commit de correção: `51bdddd` — `docs(readme): atualiza README com descricao real do projeto`

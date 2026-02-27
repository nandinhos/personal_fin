<?php

return [
    'modules' => [

        'dashboard' => [
            'label' => 'Dashboard',
            'icon'  => 'chart-bar',
            'color' => '#6366f1',
            'endpoints' => [
                [
                    'method'      => 'GET',
                    'uri'         => '/dashboard/summary',
                    'name'        => 'dashboard.summary',
                    'description' => 'Resumo financeiro do mês atual',
                    'params'      => [],
                    'response'    => ['total_balance', 'monthly_income', 'monthly_expenses', 'goals_progress'],
                    'status'      => 'active',
                ],
            ],
        ],

        'accounts' => [
            'label' => 'Contas',
            'icon'  => 'building-library',
            'color' => '#22c55e',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/accounts',                    'name' => 'accounts.index',        'description' => 'Lista contas do perfil',         'params' => [],                                         'status' => 'active'],
                ['method' => 'POST',   'uri' => '/accounts',                    'name' => 'accounts.store',        'description' => 'Cria nova conta',                'params' => ['name', 'type', 'balance', 'color', 'icon'], 'status' => 'active'],
                ['method' => 'GET',    'uri' => '/accounts/{id}',               'name' => 'accounts.show',         'description' => 'Exibe conta específica',          'params' => ['id'],                                     'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/accounts/{id}',               'name' => 'accounts.update',       'description' => 'Atualiza conta',                 'params' => ['id', 'name?', 'type?', 'balance?'],        'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/accounts/{id}',               'name' => 'accounts.destroy',      'description' => 'Remove conta',                   'params' => ['id'],                                     'status' => 'active'],
                ['method' => 'GET',    'uri' => '/accounts/{id}/transactions',   'name' => 'accounts.transactions', 'description' => 'Extrato da conta',               'params' => ['id'],                                     'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/accounts/{id}/toggle',         'name' => 'accounts.toggle',       'description' => 'Ativa/desativa conta',           'params' => ['id'],                                     'status' => 'planned'],
            ],
        ],

        'cards' => [
            'label' => 'Cartões',
            'icon'  => 'credit-card',
            'color' => '#3b82f6',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/cards',                  'name' => 'cards.index',        'description' => 'Lista cartões do perfil',      'params' => [],                                                            'status' => 'active'],
                ['method' => 'POST',   'uri' => '/cards',                  'name' => 'cards.store',        'description' => 'Cria novo cartão',             'params' => ['name', 'type', 'last_four_digits', 'limit'],                 'status' => 'active'],
                ['method' => 'GET',    'uri' => '/cards/{id}',             'name' => 'cards.show',         'description' => 'Exibe cartão específico',       'params' => ['id'],                                                        'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/cards/{id}',             'name' => 'cards.update',       'description' => 'Atualiza cartão',              'params' => ['id', 'name?', 'limit?', 'color?'],                           'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/cards/{id}',             'name' => 'cards.destroy',      'description' => 'Remove cartão',                'params' => ['id'],                                                        'status' => 'active'],
                ['method' => 'GET',    'uri' => '/cards/{id}/transactions', 'name' => 'cards.transactions', 'description' => 'Transações do cartão',         'params' => ['id'],                                                        'status' => 'planned'],
                ['method' => 'GET',    'uri' => '/cards/{id}/summary',     'name' => 'cards.summary',      'description' => 'Limite disponível e utilizado', 'params' => ['id'],                                                        'status' => 'planned'],
                ['method' => 'PATCH',  'uri' => '/cards/{id}/toggle',      'name' => 'cards.toggle',       'description' => 'Ativa/desativa cartão',        'params' => ['id'],                                                        'status' => 'planned'],
            ],
        ],

        'transactions' => [
            'label' => 'Transações',
            'icon'  => 'arrows-right-left',
            'color' => '#f59e0b',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/transactions',       'name' => 'transactions.index',   'description' => 'Lista transações (filtros: type, category_id, account_id, card_id, date_from, date_to)', 'params' => ['type?', 'category_id?', 'account_id?', 'card_id?', 'date_from?', 'date_to?'], 'status' => 'active'],
                ['method' => 'POST',   'uri' => '/transactions',       'name' => 'transactions.store',   'description' => 'Cria transação',     'params' => ['category_id', 'type', 'amount', 'date', 'account_id?', 'card_id?', 'description?'], 'status' => 'active'],
                ['method' => 'GET',    'uri' => '/transactions/{id}',  'name' => 'transactions.show',    'description' => 'Exibe transação',    'params' => ['id'],   'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/transactions/{id}',  'name' => 'transactions.update',  'description' => 'Atualiza transação', 'params' => ['id'],   'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/transactions/{id}',  'name' => 'transactions.destroy', 'description' => 'Remove transação',   'params' => ['id'],   'status' => 'active'],
            ],
        ],

        'categories' => [
            'label' => 'Categorias',
            'icon'  => 'tag',
            'color' => '#8b5cf6',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/categories',           'name' => 'categories.index',      'description' => 'Lista categorias com subcategorias', 'params' => [],                              'status' => 'active'],
                ['method' => 'POST',   'uri' => '/categories',           'name' => 'categories.store',      'description' => 'Cria categoria',                    'params' => ['name', 'type', 'icon?', 'color?'], 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/categories/{id}',      'name' => 'categories.update',     'description' => 'Atualiza categoria',                'params' => ['id', 'name?', 'type?'],          'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/categories/{id}',      'name' => 'categories.destroy',    'description' => 'Remove categoria',                  'params' => ['id'],                            'status' => 'active'],
                ['method' => 'GET',    'uri' => '/subcategories',        'name' => 'subcategories.index',   'description' => 'Lista subcategorias do perfil',     'params' => [],                                'status' => 'active'],
                ['method' => 'POST',   'uri' => '/subcategories',        'name' => 'subcategories.store',   'description' => 'Cria subcategoria',                 'params' => ['name', 'category_id'],           'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/subcategories/{id}',   'name' => 'subcategories.update',  'description' => 'Atualiza subcategoria',             'params' => ['id', 'name?'],                   'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/subcategories/{id}',   'name' => 'subcategories.destroy', 'description' => 'Remove subcategoria',               'params' => ['id'],                            'status' => 'active'],
            ],
        ],

        'limits' => [
            'label' => 'Limites',
            'icon'  => 'adjustments-horizontal',
            'color' => '#ef4444',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/limits',       'name' => 'limits.index',   'description' => 'Lista limites mensais do perfil',         'params' => [],                                   'status' => 'active'],
                ['method' => 'POST',   'uri' => '/limits',       'name' => 'limits.store',   'description' => 'Define limite por categoria',             'params' => ['category_id', 'amount', 'period?'],  'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/limits/{id}',  'name' => 'limits.update',  'description' => 'Atualiza valor do limite',                'params' => ['id', 'amount', 'is_active?'],        'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/limits/{id}',  'name' => 'limits.destroy', 'description' => 'Remove limite',                          'params' => ['id'],                                'status' => 'active'],
            ],
        ],

        'goals' => [
            'label' => 'Metas',
            'icon'  => 'trophy',
            'color' => '#10b981',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/goals',                 'name' => 'goals.index',    'description' => 'Lista metas de reserva',        'params' => [],                                          'status' => 'active'],
                ['method' => 'POST',   'uri' => '/goals',                 'name' => 'goals.store',    'description' => 'Cria meta de reserva',          'params' => ['name', 'target_amount', 'deadline'],       'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/goals/{id}',            'name' => 'goals.update',   'description' => 'Atualiza meta',                 'params' => ['id', 'name?', 'target_amount?', 'deadline?'], 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/goals/{id}',            'name' => 'goals.destroy',  'description' => 'Remove meta',                   'params' => ['id'],                                      'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/goals/{id}/progress',   'name' => 'goals.progress', 'description' => 'Atualiza valor atual da meta',  'params' => ['id', 'current_amount'],                    'status' => 'active'],
            ],
        ],

        'installments' => [
            'label' => 'Parcelas',
            'icon'  => 'queue-list',
            'color' => '#f97316',
            'endpoints' => [
                ['method' => 'GET',   'uri' => '/installments',           'name' => 'installments.index',   'description' => 'Lista todas as parcelas',       'params' => ['is_paid?'],   'status' => 'active'],
                ['method' => 'GET',   'uri' => '/installments/pending',   'name' => 'installments.pending', 'description' => 'Parcelas em aberto (não pagas)', 'params' => [],             'status' => 'active'],
                ['method' => 'PATCH', 'uri' => '/installments/{id}/pay',  'name' => 'installments.pay',     'description' => 'Marca parcela como paga',        'params' => ['id'],         'status' => 'active'],
                ['method' => 'PATCH', 'uri' => '/installments/{id}',      'name' => 'installments.update',  'description' => 'Atualiza dados da parcela',      'params' => ['id'],         'status' => 'active'],
                ['method' => 'DELETE','uri' => '/installments/{id}',      'name' => 'installments.destroy', 'description' => 'Remove parcela',                 'params' => ['id'],         'status' => 'active'],
            ],
        ],

        'investments' => [
            'label' => 'Investimentos',
            'icon'  => 'chart-bar',
            'color' => '#06b6d4',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/investments',           'name' => 'investments.index',   'description' => 'Lista investimentos',               'params' => [],                                               'status' => 'active'],
                ['method' => 'POST',   'uri' => '/investments',           'name' => 'investments.store',   'description' => 'Registra novo investimento',        'params' => ['name', 'type', 'amount', 'purchase_date'],      'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/investments/{id}',      'name' => 'investments.update',  'description' => 'Atualiza valor atual do investimento', 'params' => ['id', 'current_value?', 'name?'],            'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/investments/{id}',      'name' => 'investments.destroy', 'description' => 'Remove investimento',               'params' => ['id'],                                           'status' => 'active'],
                ['method' => 'GET',    'uri' => '/investments/summary',   'name' => 'investments.summary', 'description' => 'Rentabilidade geral da carteira',   'params' => [],                                               'status' => 'active'],
            ],
        ],

        'loans' => [
            'label' => 'Empréstimos',
            'icon'  => 'banknotes',
            'color' => '#dc2626',
            'endpoints' => [
                ['method' => 'GET',    'uri' => '/loans',             'name' => 'loans.index',   'description' => 'Lista empréstimos ativos',         'params' => [],                                                     'status' => 'active'],
                ['method' => 'POST',   'uri' => '/loans',             'name' => 'loans.store',   'description' => 'Registra novo empréstimo',         'params' => ['name', 'amount', 'interest_rate', 'installments', 'start_date'], 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/loans/{id}',        'name' => 'loans.update',  'description' => 'Atualiza dados do empréstimo',     'params' => ['id'],                                                 'status' => 'active'],
                ['method' => 'PATCH',  'uri' => '/loans/{id}/pay',    'name' => 'loans.pay',     'description' => 'Registra pagamento de parcela',    'params' => ['id'],                                                 'status' => 'active'],
                ['method' => 'DELETE', 'uri' => '/loans/{id}',        'name' => 'loans.destroy', 'description' => 'Remove empréstimo',                'params' => ['id'],                                                 'status' => 'active'],
            ],
        ],

        'reports' => [
            'label' => 'Relatórios',
            'icon'  => 'chart-pie',
            'color' => '#a855f7',
            'endpoints' => [
                ['method' => 'GET', 'uri' => '/reports/expenses-by-category', 'name' => 'reports.expensesByCategory', 'description' => 'Total de despesas por categoria',  'params' => [], 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/income-expense',       'name' => 'reports.incomeVsExpense',    'description' => 'Receitas vs Despesas + saldo',      'params' => [], 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/monthly',              'name' => 'reports.monthly',            'description' => 'Histórico mensal por tipo',         'params' => [], 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/by-card',              'name' => 'reports.byCard',             'description' => 'Total gasto por cartão',            'params' => [], 'status' => 'active'],
                ['method' => 'GET', 'uri' => '/reports/by-account',           'name' => 'reports.byAccount',          'description' => 'Total movimentado por conta',       'params' => [], 'status' => 'active'],
            ],
        ],

    ],
];

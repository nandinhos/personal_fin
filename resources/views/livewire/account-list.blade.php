<div>
    @if (session()->has('success'))
        <div class="mb-6 p-4 text-sm text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl dark:text-emerald-400 font-medium" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($accounts as $account)
            <div class="glass-card-premium group/card relative overflow-hidden transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] dark:hover:shadow-[0_8px_30px_rgba(255,255,255,0.05)]">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center border transition-transform duration-500 group-hover/card:scale-110" 
                                style="background-color: {{ $account->color ?? '#6366f1' }}15; border-color: {{ $account->color ?? '#6366f1' }}30">
                                <svg class="w-7 h-7" style="color: {{ $account->color ?? '#6366f1' }}; filter: drop-shadow(0 0 8px currentColor);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-lg text-slate-900 dark:text-white tracking-tight leading-tight">{{ $account->name }}</h3>
                                <p class="text-[10px] sm:text-xs uppercase font-bold tracking-wider text-slate-500 mt-1">
                                    @switch($account->type)
                                        @case('checking') Conta Corrente @break
                                        @case('savings') Poupança @break
                                        @case('investment') Investimento @break
                                        @case('cash') Carteira @break
                                        @case('other') Outros @break
                                        @default {{ $account->type }}
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex opacity-0 group-hover/card:opacity-100 transition-opacity duration-300 bg-white/50 dark:bg-black/20 backdrop-blur-md rounded-xl p-1 border border-black/5 dark:border-white/5">
                            <a href="{{ route('accounts.show', $account->id) }}" wire:navigate class="p-2 text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors rounded-lg hover:bg-black/5 dark:hover:bg-white/5" title="Ver Extrato e Detalhes">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                            <button wire:click.prevent="editAccount({{ $account->id }})" class="p-2 text-slate-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-colors rounded-lg hover:bg-black/5 dark:hover:bg-white/5" title="Editar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </button>
                            <button wire:click.prevent="deleteAccount({{ $account->id }})" wire:confirm="Tem certeza que deseja excluir esta conta? Esta ação não pode ser desfeita e excluirá todas as movimentações atreladas a ela." class="p-2 text-slate-400 hover:text-red-500 dark:hover:text-red-400 transition-colors rounded-lg hover:bg-black/5 dark:hover:bg-white/5" title="Excluir">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-2 pt-4 border-t border-black/5 dark:border-white/10 flex items-end justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Saldo Atual</p>
                            <p class="text-2xl sm:text-3xl font-black {{ $account->balance < 0 ? 'text-red-500 dark:text-red-400' : 'text-slate-900 dark:text-white' }} tracking-tight">
                                {{ 'R$ ' . number_format($account->balance, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="p-2 rounded-xl {{ $account->balance < 0 ? 'bg-red-500/10 text-red-500' : 'bg-emerald-500/10 text-emerald-500' }}">
                            <svg class="w-5 h-5 {{ $account->balance < 0 ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                {{-- Decorative gradient background subtle --}}
                <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full blur-3xl opacity-20 pointer-events-none transition-opacity duration-500 group-hover/card:opacity-30" style="background-color: {{ $account->color ?? '#6366f1' }}"></div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center glass-panel rounded-[2.5rem]">
                <div class="w-24 h-24 bg-indigo-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-indigo-500/20 shadow-[0_0_30px_rgba(99,102,241,0.15)]">
                    <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Nenhuma conta encontrada</h4>
                <p class="text-slate-500 mb-8 max-w-sm mx-auto">Você ainda não cadastrou nenhuma conta ou carteira. Comece adicionando sua conta principal.</p>
                <button wire:click="$parent.openForm" class="glass-button-primary mx-auto">
                    <span>Criar primeira conta</span>
                </button>
            </div>
        @endforelse
    </div>

    @if($accounts->hasPages())
    <div class="mt-8 glass-panel p-4 rounded-2xl">
        {{ $accounts->links() }}
    </div>
    @endif
</div>

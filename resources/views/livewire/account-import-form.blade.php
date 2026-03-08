<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full {{ $isPreviewing ? 'max-w-4xl lg:max-w-5xl' : 'max-w-md' }} max-h-full transition-all duration-300">
                <!-- Modal content -->
                <div class="relative bg-white rounded-[2rem] shadow-[0_0_50px_rgba(0,0,0,0.1)] dark:bg-slate-800 dark:border dark:border-white/10 overflow-hidden">
                    
                    <!-- Decorative Background -->
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-500 rounded-full blur-[80px] opacity-20 pointer-events-none"></div>

                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-6 border-b border-black/5 dark:border-white/10 relative z-10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-500/20 rounded-xl">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">
                                {{ $isPreviewing ? 'Visualizar Importação' : 'Importar Extrato' }}
                            </h3>
                        </div>
                        <button type="button" wire:click="closeModal" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-white transition-colors">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="p-6 relative z-10">
                        @if (session()->has('error'))
                            <div class="p-4 mb-4 text-sm text-red-700 bg-red-500/10 border border-red-500/20 rounded-2xl dark:text-red-400 font-medium" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session()->has('success') && $isPreviewing)
                            <div class="p-4 mb-4 text-sm text-emerald-700 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl dark:text-emerald-400 font-medium" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($isPreviewing)
                            <div class="space-y-4">
                                <div class="overflow-x-auto rounded-xl bg-slate-50 border border-slate-200 dark:bg-slate-900 dark:border-white/10 shadow-sm">
                                    <table class="w-full text-sm text-left rtl:text-right text-slate-500 dark:text-slate-400">
                                        <thead class="text-xs text-slate-700 uppercase bg-slate-100 dark:bg-slate-800 dark:text-slate-400 sticky top-0">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-center">Imp.</th>
                                                <th scope="col" class="px-4 py-3">Data</th>
                                                <th scope="col" class="px-4 py-3">Detalhe</th>
                                                <th scope="col" class="px-4 py-3 text-right">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parsedTransactions as $index => $tx)
                                                <tr class="border-b dark:border-slate-800 {{ $tx['is_duplicate'] ? 'bg-red-50/50 dark:bg-red-900/10' : 'bg-white dark:bg-slate-900/50' }} hover:bg-slate-50 dark:hover:bg-slate-800">
                                                    <td class="px-4 py-3 text-center">
                                                        <div class="flex items-center justify-center">
                                                            <input type="checkbox" wire:model.live="parsedTransactions.{{ $index }}.import" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 font-medium whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($tx['date'])->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-4 py-3 truncate max-w-[150px]" title="{{ $tx['description'] }}">
                                                        {{ $tx['description'] }}
                                                        @if($tx['is_duplicate'])
                                                            <span class="inline-flex items-center px-2 py-0.5 ml-2 text-xs font-semibold text-red-800 bg-red-100 rounded dark:bg-red-200 dark:text-red-900">Duplicado</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-right font-bold {{ $tx['type'] === 'expense' ? 'text-red-500' : 'text-emerald-500' }}">
                                                        {{ $tx['type'] === 'expense' ? '- ' : '+ ' }}R$ {{ number_format($tx['amount'], 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="flex flex-col sm:flex-row items-center gap-3 mt-4">
                                    <button wire:click="cancelPreview" type="button" class="w-full sm:w-1/3 py-2.5 px-5 text-sm font-medium text-slate-900 focus:outline-none bg-white rounded-xl border border-slate-200 hover:bg-slate-100 hover:text-indigo-700 focus:z-10 focus:ring-4 focus:ring-slate-100 dark:focus:ring-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-600 dark:hover:text-white dark:hover:bg-slate-700 transition-colors">
                                        Cancelar
                                    </button>
                                    <button wire:click="confirmImport" type="button" class="w-full sm:w-2/3 text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-2.5 text-center dark:bg-indigo-600 dark:hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-500/30">
                                        <span wire:loading.remove wire:target="confirmImport">Confirmar e Salvar</span>
                                        <span wire:loading wire:target="confirmImport">Salvando Lançamentos...</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <form wire:submit="previewImport" class="space-y-6">
                                
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700 dark:text-slate-300">
                                        Arquivo de Extrato (OFX)
                                    </label>
                                    
                                    <div class="flex items-center justify-center w-full">
                                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-indigo-300 border-dashed rounded-[1.5rem] cursor-pointer bg-indigo-50 dark:hover:bg-indigo-900/20 dark:bg-slate-900/50 hover:bg-indigo-100 dark:border-indigo-500/30 dark:hover:border-indigo-500 transition-all duration-300 group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-10 h-10 mb-3 text-indigo-400 group-hover:text-indigo-500 transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400 font-medium"><span class="font-bold text-indigo-600 dark:text-indigo-400">Clique para selecionar</span> ou arraste</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Apenas arquivos OFX do seu banco</p>
                                            </div>
                                            <input id="dropzone-file" type="file" wire:model.live="file" class="hidden" accept=".ofx,.xml,.txt,.csv" />
                                        </label>
                                    </div>
                                    
                                    <div wire:loading wire:target="file" class="mt-2 text-sm text-indigo-600 font-medium flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Carregando arquivo...
                                    </div>

                                @error('file') <span class="text-sm text-red-500 dark:text-red-400 mt-2 block font-medium">{{ $message }}</span> @enderror
                                
                                @if($file)
                                    <div class="mt-3 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3">
                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        <span class="text-sm font-medium text-emerald-700 dark:text-emerald-400 truncate">{{ $file->getClientOriginalName() }}</span>
                                    </div>
                                @endif
                            </div>

                            <button type="submit" @if(!$file) disabled @endif class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-indigo-600 dark:hover:bg-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-lg shadow-indigo-500/30">
                                <span wire:loading.remove wire:target="previewImport">Processar Importação</span>
                                <span wire:loading wire:target="previewImport">Importando...</span>
                            </button>
                            
                            <p class="text-xs text-center text-slate-500 mt-4">
                                O sistema identificará e ignorará transações duplicadas automaticamente.
                            </p>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

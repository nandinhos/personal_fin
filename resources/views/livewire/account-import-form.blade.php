<div>
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-slate-900/50 dark:bg-slate-900/80 backdrop-blur-sm transition-opacity">
            <div class="relative p-4 w-full max-w-md max-h-full">
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
                                Importar Extrato
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
                        <form wire:submit="processImport" class="space-y-6">
                            
                            @if (session()->has('error'))
                                <div class="p-4 text-sm text-red-700 bg-red-500/10 border border-red-500/20 rounded-2xl dark:text-red-400 font-medium" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

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
                                        <input id="dropzone-file" type="file" wire:model="file" class="hidden" accept=".ofx,.xml,.txt,.csv" />
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
                                <span wire:loading.remove wire:target="processImport">Processar Importação</span>
                                <span wire:loading wire:target="processImport">Importando...</span>
                            </button>
                            
                            <p class="text-xs text-center text-slate-500 mt-4">
                                O sistema identificará e ignorará transações duplicadas automaticamente.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

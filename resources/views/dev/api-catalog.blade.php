<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Área Dev — API Explorer</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 h-full font-mono" x-data="apiExplorer()" x-init="init()">

{{-- HEADER --}}
<header class="border-b border-slate-800 bg-slate-900/80 backdrop-blur-sm sticky top-0 z-50">
    <div class="px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
            <span class="text-sm font-semibold text-white">🔧 Área Dev — API Explorer</span>
            <span class="text-xs text-slate-500">personal_fin</span>
        </div>
        <div class="flex items-center gap-4">
            {{-- Stats --}}
            <div class="flex gap-3 text-xs">
                <span class="text-slate-400">Total: <span class="text-white font-bold">{{ $stats['total'] }}</span></span>
                <span class="text-green-400">● active: <span class="font-bold">{{ $stats['active'] }}</span></span>
                <span class="text-slate-500">○ planned: <span class="font-bold">{{ $stats['planned'] }}</span></span>
                @if($stats['deprecated'] > 0)
                    <span class="text-red-400">✕ deprecated: <span class="font-bold">{{ $stats['deprecated'] }}</span></span>
                @endif
            </div>
            <span class="text-xs text-slate-500 border border-slate-700 rounded px-2 py-1">{{ auth()->user()->email }}</span>
        </div>
    </div>
</header>

<div class="flex h-[calc(100vh-57px)]">

    {{-- SIDEBAR — Módulos --}}
    <aside class="w-48 border-r border-slate-800 bg-slate-900/50 overflow-y-auto flex-shrink-0">
        <div class="p-3">
            <p class="text-xs text-slate-500 uppercase tracking-widest mb-2 px-1">Módulos</p>
            @foreach($catalog as $key => $module)
                <button
                    @click="activeModule = '{{ $key }}'"
                    :class="activeModule === '{{ $key }}' ? 'bg-slate-700/80 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800'"
                    class="w-full text-left px-3 py-2 rounded-lg text-xs transition-colors flex items-center justify-between gap-2 mb-1"
                >
                    <span>{{ $module['label'] }}</span>
                    <span class="text-slate-600 text-[10px]">{{ count($module['endpoints']) }}</span>
                </button>
            @endforeach
        </div>
    </aside>

    {{-- MAIN — Endpoints --}}
    <main class="flex-1 overflow-y-auto">
        @foreach($catalog as $key => $module)
            <div x-show="activeModule === '{{ $key }}'" x-cloak>
                <div class="px-6 py-4 border-b border-slate-800">
                    <h2 class="text-base font-semibold text-white flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full inline-block" style="background-color: {{ $module['color'] }}"></span>
                        {{ $module['label'] }}
                        <span class="text-xs text-slate-500 font-normal ml-1">{{ count($module['endpoints']) }} endpoints</span>
                    </h2>
                </div>

                <div class="divide-y divide-slate-800/50">
                    @foreach($module['endpoints'] as $idx => $endpoint)
                        <div class="px-6 py-3 hover:bg-slate-900/30 transition-colors group">
                            <div class="flex items-center gap-4">
                                {{-- Method badge --}}
                                <span class="text-xs font-bold w-14 text-center rounded px-1.5 py-0.5 flex-shrink-0 {{ match($endpoint['method']) {
                                    'GET'    => 'bg-emerald-900/50 text-emerald-400 border border-emerald-800',
                                    'POST'   => 'bg-blue-900/50 text-blue-400 border border-blue-800',
                                    'PATCH'  => 'bg-amber-900/50 text-amber-400 border border-amber-800',
                                    'PUT'    => 'bg-amber-900/50 text-amber-400 border border-amber-800',
                                    'DELETE' => 'bg-red-900/50 text-red-400 border border-red-800',
                                    default  => 'bg-slate-800 text-slate-400',
                                } }}">
                                    {{ $endpoint['method'] }}
                                </span>

                                {{-- URI --}}
                                <code class="text-sm text-slate-200 flex-1">{{ $endpoint['uri'] }}</code>

                                {{-- Description --}}
                                <span class="text-xs text-slate-500 flex-1 hidden lg:block">{{ $endpoint['description'] }}</span>

                                {{-- Status --}}
                                @if($endpoint['status'] === 'active')
                                    <span x-show="!healthResults['{{ $key }}_{{ $idx }}']" class="text-xs text-green-400">● active</span>
                                    <span x-show="healthResults['{{ $key }}_{{ $idx }}']" x-cloak>
                                        <span :class="healthResults['{{ $key }}_{{ $idx }}']?.ok ? 'text-green-400' : 'text-red-400'" class="text-xs font-mono">
                                            <span x-text="healthResults['{{ $key }}_{{ $idx }}']?.status"></span>
                                            <span class="text-slate-500 ml-1" x-text="healthResults['{{ $key }}_{{ $idx }}']?.duration + 'ms'"></span>
                                        </span>
                                    </span>
                                @elseif($endpoint['status'] === 'planned')
                                    <span class="text-xs text-slate-600">○ planned</span>
                                @else
                                    <span class="text-xs text-red-500">✕ deprecated</span>
                                @endif

                                {{-- Botão testar --}}
                                @if($endpoint['status'] === 'active')
                                    <button
                                        @click="openProbe('{{ $endpoint['method'] }}', '{{ $endpoint['uri'] }}', '{{ $endpoint['description'] }}', {{ json_encode($endpoint['params'] ?? []) }})"
                                        class="opacity-0 group-hover:opacity-100 text-xs px-2 py-1 bg-indigo-600 hover:bg-indigo-500 text-white rounded transition-all"
                                    >
                                        ▶ Test
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </main>

    {{-- PAINEL LATERAL — Probe --}}
    <aside
        x-show="probeOpen"
        x-cloak
        class="w-96 border-l border-slate-800 bg-slate-900/80 overflow-y-auto flex-shrink-0 flex flex-col"
    >
        {{-- Header do painel --}}
        <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
            <span class="text-xs font-semibold text-white">Endpoint Tester</span>
            <button @click="probeOpen = false" class="text-slate-500 hover:text-white text-lg leading-none">×</button>
        </div>

        <div class="p-4 flex flex-col gap-4 flex-1">
            {{-- Endpoint info --}}
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold px-1.5 py-0.5 rounded bg-indigo-900 text-indigo-300 border border-indigo-700" x-text="probe.method"></span>
                    <code class="text-xs text-slate-300" x-text="probe.uri"></code>
                </div>
                <p class="text-xs text-slate-500" x-text="probe.description"></p>
            </div>

            {{-- Params --}}
            <div>
                <label class="text-xs text-slate-400 block mb-1">Parâmetros (JSON)</label>
                <textarea
                    x-model="probe.paramsJson"
                    class="w-full bg-slate-800 border border-slate-700 rounded text-xs text-slate-200 p-2 font-mono resize-none h-28 focus:outline-none focus:border-indigo-500"
                    placeholder="{}"
                ></textarea>
            </div>

            {{-- Botão fire --}}
            <button
                @click="fireProbe()"
                :disabled="probeLoading"
                class="w-full py-2 bg-indigo-600 hover:bg-indigo-500 disabled:opacity-50 text-white text-xs font-bold rounded transition-colors flex items-center justify-center gap-2"
            >
                <span x-show="!probeLoading">▶ FIRE</span>
                <span x-show="probeLoading" x-cloak>⏳ aguardando...</span>
            </button>

            {{-- Copy cURL --}}
            <button
                @click="copyCurl()"
                class="w-full py-1.5 border border-slate-700 hover:border-slate-500 text-slate-400 hover:text-white text-xs rounded transition-colors"
            >
                📋 Copy cURL
            </button>

            {{-- Response --}}
            <div x-show="probeResult" x-cloak>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-bold" :class="probeResult?.ok ? 'text-green-400' : 'text-red-400'" x-text="probeResult?.status + ' ' + (probeResult?.ok ? 'OK' : 'ERROR')"></span>
                    <span class="text-xs text-slate-500" x-text="probeResult?.duration + 'ms'"></span>
                </div>
                <pre class="bg-slate-800 border border-slate-700 rounded p-3 text-xs text-slate-300 overflow-auto max-h-64 whitespace-pre-wrap" x-text="JSON.stringify(probeResult?.body, null, 2)"></pre>
            </div>
        </div>
    </aside>

</div>

{{-- Loading overlay health check --}}
<div
    x-show="healthLoading"
    x-cloak
    class="fixed bottom-4 right-4 bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-xs text-slate-400 flex items-center gap-2"
>
    <div class="w-3 h-3 border-2 border-indigo-400 border-t-transparent rounded-full animate-spin"></div>
    Verificando endpoints...
</div>

<script>
function apiExplorer() {
    return {
        activeModule: '{{ array_key_first($catalog) }}',
        probeOpen: false,
        probeLoading: false,
        healthLoading: false,
        healthResults: {},
        probeResult: null,
        probe: {
            method: 'GET',
            uri: '',
            description: '',
            paramsJson: '{}',
        },

        init() {
            this.runHealthCheck();
        },

        async runHealthCheck() {
            this.healthLoading = true;
            const catalog = @json($catalog);

            for (const [moduleKey, module] of Object.entries(catalog)) {
                for (const [idx, endpoint] of module.endpoints.entries()) {
                    if (endpoint.status !== 'active' || endpoint.method !== 'GET') continue;

                    const key = `${moduleKey}_${idx}`;
                    try {
                        const uri = endpoint.uri.replace(/\{[^}]+\}/g, '1');
                        const start = performance.now();
                        const res = await fetch(`/${uri.replace(/^\//, '')}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            credentials: 'same-origin',
                        });
                        const duration = Math.round(performance.now() - start);
                        this.healthResults = { ...this.healthResults, [key]: { status: res.status, duration, ok: res.ok } };
                    } catch (e) {
                        this.healthResults = { ...this.healthResults, [key]: { status: 0, duration: 0, ok: false } };
                    }
                }
            }

            this.healthLoading = false;
        },

        openProbe(method, uri, description, params) {
            this.probe.method = method;
            this.probe.uri    = uri;
            this.probe.description = description;
            this.probe.paramsJson  = params.length > 0
                ? JSON.stringify(Object.fromEntries(params.map(p => [p.replace('?',''), ''])), null, 2)
                : '{}';
            this.probeResult  = null;
            this.probeOpen    = true;
        },

        async fireProbe() {
            this.probeLoading = true;
            this.probeResult  = null;

            let params = {};
            try { params = JSON.parse(this.probe.paramsJson || '{}'); } catch {}

            try {
                const res = await fetch('{{ route("dev.catalog.probe") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        method: this.probe.method,
                        uri: this.probe.uri,
                        params,
                    }),
                });

                this.probeResult = await res.json();
            } catch (e) {
                this.probeResult = { ok: false, status: 0, duration: 0, body: e.message };
            }

            this.probeLoading = false;
        },

        copyCurl() {
            let params = {};
            try { params = JSON.parse(this.probe.paramsJson || '{}'); } catch {}

            const appUrl = '{{ config("app.url") }}';
            const uri = this.probe.uri;
            let curl = `curl -X ${this.probe.method} '${appUrl}/${uri.replace(/^\//, '')}' \\\n  -H 'Accept: application/json' \\\n  -H 'X-CSRF-TOKEN: <token>'`;

            if (['POST', 'PATCH', 'PUT'].includes(this.probe.method) && Object.keys(params).length > 0) {
                curl += ` \\\n  -H 'Content-Type: application/json' \\\n  -d '${JSON.stringify(params)}'`;
            }

            navigator.clipboard.writeText(curl).then(() => {
                alert('cURL copiado!');
            });
        },
    };
}
</script>

</body>
</html>

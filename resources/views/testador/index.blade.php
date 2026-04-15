@extends('layouts.app')

@section('title', 'Testador de Links')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Testador de Links</h1>

    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-link"></i> Verificar Segurança de um Link
                    </h5>

                    <form id="testadorForm" action="{{ route('testador.test') }}" method="POST">
                        @csrf

                        <div class="input-group input-group-lg mb-3">
                            <input type="url" name="url" id="urlInput" class="form-control @error('url') is-invalid @enderror" 
                                   placeholder="https://exemplo.com" required value="{{ old('url') }}">
                            <button class="btn btn-primary" type="submit" id="testBtn">
                                <i class="bi bi-search"></i> Testar
                            </button>
                            @error('url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <small class="text-muted">Digite a URL completa (incluindo https:// ou http://)</small>
                    </form>

                    <div id="resultadoDiv" style="display: none;" class="mt-4">
                        <div id="resultadoContent"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Estatísticas</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between">
                            <span>Links Testados</span>
                            <strong id="stat-total">{{ $estatisticas['total'] }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span class="text-success">Seguros</span>
                            <strong class="text-success" id="stat-seguro">{{ $estatisticas['seguro'] }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span class="text-warning">Suspeitos</span>
                            <strong class="text-warning" id="stat-suspeito">{{ $estatisticas['suspeito'] }}</strong>
                        </div>
                        <div class="list-group-item d-flex justify-content-between">
                            <span class="text-danger">Perigosos</span>
                            <strong class="text-danger" id="stat-perigoso">{{ $estatisticas['perigoso'] }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="page-title">Histórico de Testes</h4>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>URL</th>
                    <th>Classificação</th>
                    <th>Tempo</th>
                    <th>Data</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody id="historicoBody">
                @forelse($historico as $teste)
                    <tr>
                        <td>
                            <code class="text-break">{{ \Illuminate\Support\Str::limit($teste->url_testada, 50) }}</code>
                        </td>
                        <td>
                            <span class="badge bg-{{ $teste->getRiscoColor() }}">
                                {{ ucfirst($teste->classificacao_risco) }}
                            </span>
                        </td>
                        <td>{{ $teste->tempo_verificacao }}ms</td>
                        <td>{{ $teste->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('testador.show', $teste) }}" class="btn btn-sm btn-outline-primary">
                                Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr id="historicoVazio">
                        <td colspan="5" class="text-center text-muted py-4">
                            Nenhum teste realizado ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($historico->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                {{ $historico->links() }}
            </div>
        </div>
    @endif
</div>

<script>
document.getElementById('testadorForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const url = document.getElementById('urlInput').value;
    const testBtn = document.getElementById('testBtn');
    const resultadoDiv = document.getElementById('resultadoDiv');
    const resultadoContent = document.getElementById('resultadoContent');
    const historicoBody = document.getElementById('historicoBody');
    
    testBtn.disabled = true;
    testBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Testando...';
    
    try {
        const response = await fetch('{{ route("testador.test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ url: url })
        });
        
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Falha ao testar link');
        }
        
        const riscoColor = {
            'seguro': 'success',
            'suspeito': 'warning',
            'perigoso': 'danger'
        }[data.classificacao_risco] || 'secondary';
        
        resultadoContent.innerHTML = `
            <div class="alert alert-${riscoColor}">
                <h6><i class="bi bi-shield-check"></i> Resultado: ${data.classificacao_risco.toUpperCase()}</h6>
                <p class="mb-1">Tempo: ${data.tempo_verificacao}ms</p>
                <p class="mb-0">Status HTTP: ${data.resultado?.status_code ?? 'N/A'}</p>
            </div>
        `;

        const linhaVazia = document.getElementById('historicoVazio');
        if (linhaVazia) {
            linhaVazia.remove();
        }

        const dataTeste = new Date(data.created_at ?? new Date().toISOString());
        const dataFormatada = `${String(dataTeste.getDate()).padStart(2, '0')}/${String(dataTeste.getMonth() + 1).padStart(2, '0')}/${dataTeste.getFullYear()} ${String(dataTeste.getHours()).padStart(2, '0')}:${String(dataTeste.getMinutes()).padStart(2, '0')}`;
        const urlCurta = data.url_testada.length > 50 ? `${data.url_testada.slice(0, 50)}...` : data.url_testada;

        const linha = document.createElement('tr');
        linha.innerHTML = `
            <td><code class="text-break">${urlCurta}</code></td>
            <td><span class="badge bg-${riscoColor}">${data.classificacao_risco.charAt(0).toUpperCase() + data.classificacao_risco.slice(1)}</span></td>
            <td>${data.tempo_verificacao}ms</td>
            <td>${dataFormatada}</td>
            <td><a href="/testador-links/${data.id}" class="btn btn-sm btn-outline-primary">Detalhes</a></td>
        `;

        const primeiraLinha = historicoBody.querySelector('tr');
        if (primeiraLinha) {
            primeiraLinha.before(linha);
        } else {
            historicoBody.appendChild(linha);
        }

        const totalEl = document.getElementById('stat-total');
        const riscoEl = document.getElementById(`stat-${data.classificacao_risco}`);
        if (totalEl) {
            totalEl.textContent = Number(totalEl.textContent) + 1;
        }
        if (riscoEl) {
            riscoEl.textContent = Number(riscoEl.textContent) + 1;
        }
        
        resultadoDiv.style.display = 'block';
    } catch (error) {
        resultadoContent.innerHTML = `<div class="alert alert-danger">${error.message || 'Erro ao testar o link. Tente novamente.'}</div>`;
        resultadoDiv.style.display = 'block';
    } finally {
        testBtn.disabled = false;
        testBtn.innerHTML = '<i class="bi bi-search"></i> Testar';
    }
});
</script>
@endsection

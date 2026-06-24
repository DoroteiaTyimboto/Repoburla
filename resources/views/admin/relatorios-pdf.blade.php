<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório - Ondyove</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Relatório de Atividades</h1>
    <p>Gerado em: {{ now()->format('d/m/Y H:i') }}</p>
    
    <h2>Denúncias por Tipo</h2>
    <table>
        <tr><th>Tipo</th><th>Total</th></tr>
        @foreach($relatorios['denunciasPorTipo'] as $tipo => $total)
            <tr><td>{{ $tipo }}</td><td>{{ $total }}</td></tr>
        @endforeach
    </table>
    
    <h2>Denúncias por Status</h2>
    <table>
        <tr><th>Status</th><th>Total</th></tr>
        @foreach($relatorios['denunciasPorStatus'] as $status => $total)
            <tr><td>{{ $status }}</td><td>{{ $total }}</td></tr>
        @endforeach
    </table>
</body>
</html>
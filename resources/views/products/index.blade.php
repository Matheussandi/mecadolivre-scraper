<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produtos Armazenados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .product {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .price {
            color: green;
        }
        .export-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <h1>Produtos Armazenados no Banco de Dados</h1>

    <div class="export-button">
        <form action="{{ route('export.csv') }}" method="GET">
            <button type="submit" class="btn btn-primary">Exportar como CSV</button>
        </form>
    </div>
    
    @if (!empty($products))
        @foreach ($products as $product)
            <div class="product">
                <div class="title">{{ $product->title }}</div>
                <div class="price">Preço: R$ {{ $product->price ?? 'Preço não disponível' }}</div>
            </div>
        @endforeach
    @else
        <p>Nenhum produto encontrado.</p>
    @endif
</body>
</html>
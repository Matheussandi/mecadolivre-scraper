@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')

<table class="w-full table-auto my-4">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2 text-left">Nome</th>
            <th class="px-4 py-2 text-left">Preço Antigo</th>
            <th class="px-4 py-2 text-left">Preço Novo</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $product->name }}</td>
                <td class="px-4 py-2 text-red-500 line-through">R$ {{ $product->old_price ?? 'Preço não disponível' }}</td>
                <td class="px-4 py-2 text-green-500">R$ {{ $product->new_price ?? 'Preço não disponível' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="px-4 py-2 text-center">Nenhum produto encontrado</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}



<a href="{{ route('products.exportCsv') }}" class="fixed bottom-4 right-4 bg-blue-500 text-white rounded-full p-4 shadow-lg hover:bg-blue-600">
    <i class="fas fa-file-csv"></i>
</a>

@endsection
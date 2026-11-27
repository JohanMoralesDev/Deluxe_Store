@extends('layouts.admin')

@section('title', 'Editar producto | Deluxe Store')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Editar producto</h1>
        <p>{{ $product->nombre }} · {{ $product->codigo_sku }}</p>
    </div>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['submitLabel' => 'Guardar cambios'])
        </form>
    </div></div>
</div>
@endsection

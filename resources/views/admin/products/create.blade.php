@extends('layouts.admin')

@section('title', 'Registrar producto | Deluxe Store')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1>Registrar producto</h1>
        <p>Completa la información del producto.</p>
    </div>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form', ['product' => null, 'submitLabel' => 'Guardar producto'])
        </form>
    </div></div>
</div>
@endsection

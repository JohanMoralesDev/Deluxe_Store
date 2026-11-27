@extends('layouts.admin')
@section('title', 'Crear categoría | Deluxe Store')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Crear categoría</h1>
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            @include('admin.categories._form', ['category' => null, 'submitLabel' => 'Guardar categoría'])
        </form>
    </div></div>
</div>
@endsection

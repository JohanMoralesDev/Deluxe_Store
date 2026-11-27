@extends('layouts.admin')
@section('title', 'Editar categoría | Deluxe Store')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Editar categoría</h1>
    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            @include('admin.categories._form', ['submitLabel' => 'Guardar cambios'])
        </form>
    </div></div>
</div>
@endsection

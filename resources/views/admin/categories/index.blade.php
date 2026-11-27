@extends('layouts.admin')
@section('title', 'Categorías | Deluxe Store')
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><h1>Categorías</h1><p>Gestiona las categorías del catálogo.</p></div>
        <a class="btn btn-success" href="{{ route('admin.categories.create') }}">Crear categoría</a>
    </div>
    <div class="card"><div class="table-responsive"><table class="table table-hover align-middle mb-0">
        <thead><tr><th>Nombre</th><th>Productos</th><th>Estado</th><th class="text-end">Acciones</th></tr></thead>
        <tbody>
        @forelse ($categorias as $category)
            <tr>
                <td>{{ $category->nombre }}</td>
                <td>{{ $category->products_count }}</td>
                <td>{{ $category->esta_activa ? 'Activa' : 'Inactiva' }}</td>
                <td class="text-end text-nowrap">
                    <a class="btn btn-sm btn-outline-success" href="{{ route('admin.categories.show', $category) }}">Ver</a>
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.categories.edit', $category) }}">Editar</a>
                    @if ($category->esta_activa)
                        <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('¿Desactivar esta categoría?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Desactivar</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center py-4">No hay categorías registradas.</td></tr>
        @endforelse
        </tbody>
    </table></div><div class="card-body">{{ $categorias->links() }}</div></div>
</div>
@endsection

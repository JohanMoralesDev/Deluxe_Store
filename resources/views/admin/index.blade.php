@extends('layouts.admin')

@section('title', 'Administración | Deluxe Store')

@section('content')
<div class="container-fluid">
    <header class="mb-4">
        <p class="text-uppercase small fw-semibold">Panel de control</p>
        <h1>Administración de Deluxe Store</h1>
        <p>Selecciona un módulo para continuar.</p>
    </header>

    <div class="row g-3">
        <div class="col-sm-6 col-xl-4"><a class="card h-100 text-decoration-none" href="{{ route('admin.productos.index') }}"><div class="card-body"><h2 class="h5">Productos</h2><p class="mb-0">Consulta y gestiona el catálogo.</p></div></a></div>
        <div class="col-sm-6 col-xl-4"><a class="card h-100 text-decoration-none" href="{{ route('admin.inventory.index') }}"><div class="card-body"><h2 class="h5">Inventario</h2><p class="mb-0">Revisa existencias y movimientos.</p></div></a></div>
        <div class="col-sm-6 col-xl-4"><a class="card h-100 text-decoration-none" href="{{ route('admin.categories.index') }}"><div class="card-body"><h2 class="h5">Categorías</h2><p class="mb-0">Organiza las categorías del catálogo.</p></div></a></div>
    </div>

    <form class="mt-4" action="{{ route('auth.logout') }}" method="POST">
        @csrf
        <button class="btn btn-outline-secondary" type="submit">Cerrar sesión</button>
    </form>
</div>
@endsection

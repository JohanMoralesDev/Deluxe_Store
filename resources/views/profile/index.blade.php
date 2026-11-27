@extends('layouts.app')

@section('title', 'Mi cuenta | Deluxe Store')

@push('head')
<style>
    .perfil-pagina { min-height: 65vh; padding: 3rem 1rem; background: aliceblue; }
    .perfil-contenedor { display: grid; gap: 1.5rem; width: min(100%, 850px); margin: auto; }
    .perfil-tarjeta { padding: clamp(1.35rem, 4vw, 2.25rem); border: 1px solid #e4e7e5; border-radius: 16px; background: #fff; box-shadow: 0 12px 36px rgb(0 77 49 / 8%); }
    .perfil-tarjeta h1, .perfil-tarjeta h2 { margin: 0 0 1rem; color: #006d46; font-family: "Cormorant Garamond", serif; }
    .perfil-resumen { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; margin: 0; }
    .perfil-resumen div { padding: .9rem; border-radius: 10px; background: aliceblue; }
    .perfil-resumen dt, .perfil-campo label { color: #004d31; font-weight: 600; }
    .perfil-resumen dd { margin: .25rem 0 0; overflow-wrap: anywhere; }
    .perfil-formulario { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
    .perfil-campo { display: grid; align-content: start; gap: .4rem; }
    .perfil-campo input { width: 100%; min-height: 44px; padding: .65rem .8rem; border: 1px solid #d8dfda; border-radius: 8px; }
    .perfil-campo input:focus-visible { outline: 2px solid #ecc440; outline-offset: 2px; }
    .perfil-campo [aria-invalid="true"] { border-color: #b02a37; }
    .perfil-error { margin: 0; color: #b02a37; font-size: .9rem; }
    .perfil-ayuda { grid-column: 1 / -1; margin: 0; color: #626b66; }
    .perfil-formulario .boton { grid-column: 1 / -1; justify-self: start; }
    @media (max-width: 560px) { .perfil-resumen, .perfil-formulario { grid-template-columns: 1fr; } .perfil-formulario .boton { width: 100%; } }
</style>
@endpush

@section('content')
<main class="perfil-pagina">
    <div class="perfil-contenedor">
        <section class="perfil-tarjeta" aria-labelledby="titulo-perfil">
            <h1 id="titulo-perfil">Mi cuenta</h1>
            <dl class="perfil-resumen">
                <div><dt>Nombre completo</dt><dd>{{ $usuario->nombre }}</dd></div>
                <div><dt>Correo electrónico</dt><dd>{{ $usuario->correo }}</dd></div>
                @if ($usuario->creado_en)
                    <div><dt>Fecha de registro</dt><dd>{{ $usuario->creado_en->format('d/m/Y') }}</dd></div>
                @endif
                <div><dt>Estado de la cuenta</dt><dd>{{ $usuario->esta_activo ? 'Activa' : 'Inactiva' }}</dd></div>
            </dl>
        </section>

        <section class="perfil-tarjeta" id="editar-informacion" aria-labelledby="titulo-editar-cuenta">
            <h2 id="titulo-editar-cuenta">Editar información</h2>
            <form class="perfil-formulario" action="{{ route('account.update') }}" method="POST" data-loading-label="Guardando...">
                @csrf
                @method('PUT')

                <div class="perfil-campo">
                    <label for="perfil-nombre">Nombre completo</label>
                    <input id="perfil-nombre" type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" minlength="2" maxlength="150" autocomplete="name" required @if($errors->has('nombre')) aria-invalid="true" aria-describedby="error-perfil-nombre" @endif>
                    @error('nombre')<p class="perfil-error" id="error-perfil-nombre">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-correo">Correo electrónico</label>
                    <input id="perfil-correo" type="email" name="correo" value="{{ old('correo', $usuario->correo) }}" maxlength="150" autocomplete="email" required @if($errors->has('correo')) aria-invalid="true" aria-describedby="error-perfil-correo" @endif>
                    @error('correo')<p class="perfil-error" id="error-perfil-correo">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-telefono">Teléfono</label>
                    <input id="perfil-telefono" type="text" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" maxlength="25" autocomplete="tel">
                    @error('telefono')<p class="perfil-error">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-direccion">Dirección</label>
                    <input id="perfil-direccion" type="text" name="direccion" value="{{ old('direccion', $usuario->direccion) }}" maxlength="255" autocomplete="street-address">
                    @error('direccion')<p class="perfil-error">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-ciudad">Ciudad</label>
                    <input id="perfil-ciudad" type="text" name="ciudad" value="{{ old('ciudad', $usuario->ciudad) }}" maxlength="100" autocomplete="address-level2">
                    @error('ciudad')<p class="perfil-error">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-departamento">Departamento</label>
                    <input id="perfil-departamento" type="text" name="departamento" value="{{ old('departamento', $usuario->departamento) }}" maxlength="100" autocomplete="address-level1">
                    @error('departamento')<p class="perfil-error">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="perfil-contrasena-actual">Contraseña actual para confirmar</label>
                    <input id="perfil-contrasena-actual" type="password" name="current_password" autocomplete="current-password" required @if($errors->has('current_password')) aria-invalid="true" aria-describedby="error-perfil-contrasena" @endif>
                    @error('current_password')<p class="perfil-error" id="error-perfil-contrasena">{{ $message }}</p>@enderror
                </div>
                <p class="perfil-ayuda">Se solicitará tu contraseña actual antes de guardar los cambios.</p>
                <button class="boton" type="submit">Guardar información</button>
            </form>
        </section>

        <section class="perfil-tarjeta" aria-labelledby="titulo-cambiar-contrasena">
            <h2 id="titulo-cambiar-contrasena">Cambiar contraseña</h2>
            <form class="perfil-formulario" action="{{ route('account.password.update') }}" method="POST" data-loading-label="Actualizando...">
                @csrf
                @method('PUT')
                <div class="perfil-campo">
                    <label for="actual-password">Contraseña actual</label>
                    <input id="actual-password" type="password" name="current_password" autocomplete="current-password" required @if($errors->has('current_password')) aria-invalid="true" aria-describedby="error-password-actual" @endif>
                    @error('current_password')<p class="perfil-error" id="error-password-actual">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="nueva-password">Nueva contraseña</label>
                    <input id="nueva-password" type="password" name="password" minlength="8" autocomplete="new-password" required @if($errors->has('password')) aria-invalid="true" aria-describedby="error-password-nueva" @endif>
                    <small>Mínimo 8 caracteres, con al menos una letra y un número.</small>
                    @error('password')<p class="perfil-error" id="error-password-nueva">{{ $message }}</p>@enderror
                </div>
                <div class="perfil-campo">
                    <label for="confirmar-nueva-password">Confirmar nueva contraseña</label>
                    <input id="confirmar-nueva-password" type="password" name="password_confirmation" autocomplete="new-password" required @if($errors->has('password_confirmation')) aria-invalid="true" aria-describedby="error-password-confirmacion" @endif>
                    @error('password_confirmation')<p class="perfil-error" id="error-password-confirmacion">{{ $message }}</p>@enderror
                </div>
                <button class="boton" type="submit">Actualizar contraseña</button>
            </form>
        </section>

        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-secondary" type="submit">Cerrar sesión</button>
        </form>
    </div>
</main>
@endsection

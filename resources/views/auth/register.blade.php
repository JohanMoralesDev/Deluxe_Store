@extends('layouts.app')

@section('title', 'Registro | Deluxe Store')

@push('head')
<style>
    .cuenta-pagina { min-height: 65vh; display: grid; place-items: center; padding: 3rem 1rem; background: aliceblue; }
    .cuenta-tarjeta { width: min(100%, 480px); padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid #e4e7e5; border-radius: 16px; background: #fff; box-shadow: 0 12px 36px rgb(0 77 49 / 8%); }
    .cuenta-tarjeta h1 { margin: 0; color: #006d46; font-family: "Cormorant Garamond", serif; text-align: center; }
    .cuenta-tarjeta > p { margin: .5rem 0 1.5rem; color: #5f6863; text-align: center; }
    .cuenta-formulario { display: grid; gap: .65rem; }
    .cuenta-formulario label { margin-top: .5rem; color: #004d31; font-weight: 600; }
    .cuenta-formulario input { width: 100%; min-height: 44px; padding: .65rem .8rem; border: 1px solid #d8dfda; border-radius: 8px; }
    .cuenta-formulario input:focus-visible { outline: 2px solid #ecc440; outline-offset: 2px; }
    .cuenta-enlace { margin: 1.25rem 0 0; text-align: center; }
    .cuenta-enlace a { color: #006d46; font-weight: 600; }
    .cuenta-enlace a:hover { color: #004d31; }
</style>
@endpush

@section('content')
<main class="cuenta-pagina">
    <section class="cuenta-tarjeta" aria-labelledby="titulo-registro">
        <h1 id="titulo-registro">Deluxe Store</h1>
        <p>¡Crea tu cuenta para continuar!</p>

        <form class="cuenta-formulario" action="{{ route('register.store') }}" method="POST" data-loading-label="Creando cuenta...">
            @csrf
            <label for="nombre-registro">Nombre completo</label>
            <input id="nombre-registro" type="text" name="nombre" value="{{ old('nombre') }}" minlength="2" maxlength="150" autocomplete="name" required @if($errors->has('nombre')) aria-invalid="true" aria-describedby="registro-nombre-error" @endif>
            @error('nombre')<span class="mensaje-campo-error" id="registro-nombre-error">{{ $message }}</span>@enderror

            <label for="correo-registro">Correo electrónico</label>
            <input id="correo-registro" type="email" name="email" value="{{ old('email', old('correo')) }}" maxlength="150" autocomplete="email" required @if($errors->has('email')) aria-invalid="true" aria-describedby="registro-correo-error" @endif>
            @error('email')<span class="mensaje-campo-error" id="registro-correo-error">{{ $message }}</span>@enderror

            <label for="contrasena-registro">Contraseña</label>
            <input id="contrasena-registro" type="password" name="password" minlength="8" autocomplete="new-password" required @if($errors->has('password')) aria-invalid="true" aria-describedby="registro-contrasena-error" @endif>
            <small>Usa al menos 8 caracteres, con una letra y un número.</small>
            @error('password')<span class="mensaje-campo-error" id="registro-contrasena-error">{{ $message }}</span>@enderror

            <label for="confirmar-contrasena">Confirmar contraseña</label>
            <input id="confirmar-contrasena" type="password" name="password_confirmation" autocomplete="new-password" required @if($errors->has('password_confirmation')) aria-invalid="true" aria-describedby="registro-confirmacion-error" @endif>
            @error('password_confirmation')<span class="mensaje-campo-error" id="registro-confirmacion-error">{{ $message }}</span>@enderror

            <button class="boton" type="submit">Crear cuenta</button>
        </form>

        <p class="cuenta-enlace">¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
    </section>
</main>
@endsection

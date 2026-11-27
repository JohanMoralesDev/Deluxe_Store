@extends('layouts.app')

@section('title', 'Iniciar sesión | Deluxe Store')

@push('head')
<style>
    .cuenta-pagina { min-height: 65vh; display: grid; place-items: center; padding: 3rem 1rem; background: aliceblue; }
    .cuenta-tarjeta { width: min(100%, 440px); padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid #e4e7e5; border-radius: 16px; background: #fff; box-shadow: 0 12px 36px rgb(0 77 49 / 8%); }
    .cuenta-tarjeta h1 { margin: 0; color: #006d46; font-family: "Cormorant Garamond", serif; text-align: center; }
    .cuenta-tarjeta > p { margin: .5rem 0 1.5rem; color: #5f6863; text-align: center; }
    .cuenta-formulario { display: grid; gap: .65rem; }
    .cuenta-formulario label { margin-top: .5rem; color: #004d31; font-weight: 600; }
    .cuenta-formulario input:not([type="checkbox"]) { width: 100%; min-height: 44px; padding: .65rem .8rem; border: 1px solid #d8dfda; border-radius: 8px; }
    .cuenta-formulario input:focus-visible { outline: 2px solid #ecc440; outline-offset: 2px; }
    .cuenta-recordar { display: flex; align-items: center; gap: .55rem; margin-top: .75rem; }
    .cuenta-recordar input { accent-color: #006d46; }
    .cuenta-enlace { margin: 1.25rem 0 0; text-align: center; }
    .cuenta-enlace a { color: #006d46; font-weight: 600; }
    .cuenta-enlace a:hover { color: #004d31; }
</style>
@endpush

@section('content')
<main class="cuenta-pagina">
    <section class="cuenta-tarjeta" aria-labelledby="titulo-login">
        <h1 id="titulo-login">Deluxe Store</h1>
        <p>Inicia sesión en tu cuenta</p>

        <form class="cuenta-formulario" action="{{ route('login.store') }}" method="POST" data-loading-label="Validando...">
            @csrf
            <label for="correo-login">Correo electrónico</label>
            <input id="correo-login" type="email" name="email" value="{{ old('email', old('correo')) }}" autocomplete="email" required @if($errors->has('email')) aria-invalid="true" aria-describedby="login-correo-error" @endif>
            @error('email')<span class="mensaje-campo-error" id="login-correo-error">{{ $message }}</span>@enderror

            <label for="contrasena-login">Contraseña</label>
            <input id="contrasena-login" type="password" name="password" autocomplete="current-password" required @if($errors->has('password')) aria-invalid="true" aria-describedby="login-contrasena-error" @endif>
            @error('password')<span class="mensaje-campo-error" id="login-contrasena-error">{{ $message }}</span>@enderror
            @error('login')<span class="mensaje-campo-error">{{ $message }}</span>@enderror

            <label class="cuenta-recordar" for="recordar-login">
                <input id="recordar-login" type="checkbox" name="recordar" value="1">
                Recordarme
            </label>

            <button class="boton" type="submit">Iniciar sesión</button>
        </form>

        <p class="cuenta-enlace">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    </section>
</main>
@endsection


<section class="modal-auth" id="modalAutenticacion" data-auth-start="{{ session('abrir_modal') }}" role="dialog" aria-modal="true"
    aria-labelledby="tituloModal" aria-hidden="true" hidden>

    <div class="modal__container">

        <button type="button" class="modal__cerrar" id="cerrarModal" aria-label="Cerrar ventana">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>

        {{-- FORMULARIO DE INICIO DE SESIÓN --}}
        <div class="modal__sign_in">
            <h2 class="modal__title" id="tituloModal">Iniciar Sesión</h2>

            <form id="formularioLogin" method="POST" action="{{ route('auth.login.store') }}" data-loading-label="Validando...">
                @csrf

                <p id="mensajeLogin" class="mensaje-formulario" role="status" aria-live="polite"></p>

                <label for="loginEmail">Correo electrónico</label>
                <input type="email" id="loginEmail" name="email" value="{{ old('email', old('correo')) }}"
                    autocomplete="email" required @if($errors->has('email')) aria-invalid="true" aria-describedby="error-login-correo" @endif>
                @error('email')<span class="mensaje-campo-error" id="error-login-correo">{{ $message }}</span>@enderror

                <label for="loginPassword">Contraseña</label>
                <div class="campo-password">
                    <input type="password" id="loginPassword" name="password"
                        autocomplete="current-password" required @if($errors->has('password')) aria-invalid="true" aria-describedby="error-login-contrasena" @endif>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="loginPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password')<span class="mensaje-campo-error" id="error-login-contrasena">{{ $message }}</span>@enderror
                @error('login')<span class="mensaje-campo-error">{{ $message }}</span>@enderror

                <a href="#" class="modal__enlace">¿Olvidaste tu contraseña?</a>

                <button type="submit" class="modal__boton">Iniciar Sesión</button>

                <p class="modal__cambio">
                    ¿No tienes cuenta?
                    <button type="button" id="mostrarRegistro">Regístrate</button>
                </p>
            </form>
        </div>

        {{-- FORMULARIO DE REGISTRO --}}
        <div class="modal__registro" hidden>
            <h2 class="modal__title">Crear cuenta</h2>

            <form id="formularioRegistro" method="POST"
                action="{{ route('auth.register.store') }}" data-loading-label="Creando cuenta...">
                @csrf

                <p id="mensajeRegistro" class="mensaje-formulario"
                    role="status" aria-live="polite"></p>

                <label for="registroNombre">Nombre completo</label>
                <input type="text" id="registroNombre" name="nombre" value="{{ old('nombre') }}"
                    autocomplete="name" minlength="2" maxlength="150" required @if($errors->has('nombre')) aria-invalid="true" aria-describedby="error-registro-nombre" @endif>
                @error('nombre')<span class="mensaje-campo-error" id="error-registro-nombre">{{ $message }}</span>@enderror

                <label for="registroEmail">Correo electrónico</label>
                <input type="email" id="registroEmail" name="email" value="{{ old('email', old('correo')) }}"
                    autocomplete="email" required @if($errors->has('email')) aria-invalid="true" aria-describedby="error-registro-correo" @endif>
                @error('email')<span class="mensaje-campo-error" id="error-registro-correo">{{ $message }}</span>@enderror

                <label for="registroPassword">Contraseña</label>
                <div class="campo-password">
                    <input type="password" id="registroPassword" name="password"
                        autocomplete="new-password" minlength="8" required @if($errors->has('password')) aria-invalid="true" aria-describedby="error-registro-contrasena" @endif>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="registroPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>
                <small class="ayuda-contrasena">Usa al menos 8 caracteres, con una letra y un número.</small>
                @error('password')<span class="mensaje-campo-error" id="error-registro-contrasena">{{ $message }}</span>@enderror

                <label for="confirmarPassword">Confirmar contraseña</label>
                <div class="campo-password">
                    <input type="password" id="confirmarPassword"
                        name="password_confirmation" autocomplete="new-password" required @if($errors->has('password_confirmation')) aria-invalid="true" aria-describedby="error-registro-confirmacion" @endif>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="confirmarPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password_confirmation')<span class="mensaje-campo-error" id="error-registro-confirmacion">{{ $message }}</span>@enderror

                <button type="submit" class="modal__boton">Registrarse</button>

                <p class="modal__cambio">
                    ¿Ya tienes cuenta?
                    <button type="button" id="mostrarLogin">Iniciar sesión</button>
                </p>
            </form>
        </div>

    </div>
</section>

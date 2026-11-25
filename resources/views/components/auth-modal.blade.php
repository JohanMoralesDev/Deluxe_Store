
<section class="modal-auth" id="modalAutenticacion" role="dialog" aria-modal="true"
    aria-labelledby="tituloModal" aria-hidden="true" hidden>

    <div class="modal__container">

        <button type="button" class="modal__cerrar" id="cerrarModal" aria-label="Cerrar ventana">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>

        {{-- FORMULARIO DE INICIO DE SESIÓN --}}
        <div class="modal__sign_in">
            <h2 class="modal__title" id="tituloModal">Iniciar Sesión</h2>

            <form id="formularioLogin" method="POST" action="{{ route('auth.login.store') }}">
                @csrf

                <p id="mensajeLogin" class="mensaje-formulario" role="status" aria-live="polite"></p>

                <label for="loginEmail">Correo electrónico</label>
                <input type="email" id="loginEmail" name="email"
                    autocomplete="email" required>

                <label for="loginPassword">Contraseña</label>
                <div class="campo-password">
                    <input type="password" id="loginPassword" name="password"
                        autocomplete="current-password" required>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="loginPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>

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
                action="{{ route('auth.register.store') }}">
                @csrf

                <p id="mensajeRegistro" class="mensaje-formulario"
                    role="status" aria-live="polite"></p>

                <label for="registroNombre">Nombre completo</label>
                <input type="text" id="registroNombre" name="nombre"
                    autocomplete="name" required>

                <label for="registroEmail">Correo electrónico</label>
                <input type="email" id="registroEmail" name="email"
                    autocomplete="email" required>

                <label for="registroPassword">Contraseña</label>
                <div class="campo-password">
                    <input type="password" id="registroPassword" name="password"
                        autocomplete="new-password" required>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="registroPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>

                <label for="confirmarPassword">Confirmar contraseña</label>
                <div class="campo-password">
                    <input type="password" id="confirmarPassword"
                        name="password_confirmation" autocomplete="new-password" required>

                    <button type="button" class="alternar-password"
                        aria-label="Mostrar contraseña" aria-pressed="false"
                        data-target="confirmarPassword">
                        <i class="bi bi-eye" aria-hidden="true"></i>
                    </button>
                </div>

                <button type="submit" class="modal__boton">Registrarse</button>

                <p class="modal__cambio">
                    ¿Ya tienes cuenta?
                    <button type="button" id="mostrarLogin">Iniciar sesión</button>
                </p>
            </form>
        </div>

    </div>
</section>

/* ===== MODAL DE INICIO DE SESIÓN Y REGISTRO ===== */
const botonAbrirModal = document.getElementById("abrirModalPerfil");
const modalAutenticacion = document.getElementById("modalAutenticacion");
const botonCerrarModal = document.getElementById("cerrarModal");
let elemementoAnterior = null;

const formularioInicio = document.getElementById("formularioLogin");
const formularioRegistro = document.getElementById("formularioRegistro");
let usuarioActual = null;

console.log("Usuario actual:", usuarioActual);

const campoPassword = document.getElementById("registroPassword");
const campoConfirmarPassword = document.getElementById("confirmarPassword");
const mensajeRegistro = document.getElementById("mensajeRegistro");

const botonMostrarRegistro = document.getElementById("mostrarRegistro");
const botonMostrarLogin = document.getElementById("mostrarLogin");

const seccionInicio = document.querySelector(".modal__sign_in");
const seccionRegistro = document.querySelector(".modal__registro");

const mensajeLogin = document.getElementById("mensajeLogin");

/* Abrir el modal desde el perfil */
function abrirModal() {
  if (!modalAutenticacion) return;

  elemementoAnterior = document.activeElement;

  modalAutenticacion.hidden = false;
  modalAutenticacion.setAttribute("aria-hidden", "false");

  document.body.style.overflow = "hidden";

/* Mostrar primero el inicio de sesión */
  mostrarInicio();

  const campoEmail = document.getElementById("loginEmail");
  if(campoEmail) campoEmail.focus();
}

function cerrarModal() {
  if (!modalAutenticacion) return;

  modalAutenticacion.hidden = true;
  modalAutenticacion.setAttribute("aria-hidden", "true");

  document.body.style.overflow = "";

  if (elemementoAnterior && typeof elemementoAnterior.focus === "function") {
    elemementoAnterior.focus();
  }
}

/* Mostrar el formulario de inicio de sesión */
function mostrarInicio() {
  if (!seccionInicio || !seccionRegistro) return;

  seccionInicio.hidden = false;
  seccionRegistro.hidden = true;
}

/* Mostrar el formulario de registro */
function mostrarRegistro() {
  if (!seccionInicio || !seccionRegistro) return;

  seccionInicio.hidden = true;
  seccionRegistro.hidden = false;

  const campoNombre = document.getElementById("registroNombre");
  if (campoNombre) campoNombre.focus();
}

/* Conectar los botones */
if (botonAbrirModal) {
  botonAbrirModal.addEventListener("click", abrirModal);
}
 
if (botonCerrarModal) {
  botonCerrarModal.addEventListener("click", cerrarModal);
}

if (botonMostrarRegistro) {
  botonMostrarRegistro.addEventListener("click", mostrarRegistro);
}

if (botonMostrarLogin) {
  botonMostrarLogin.addEventListener("click", mostrarInicio);
}

/* Cerrar al hacer clic en el fondo del modal */
if (modalAutenticacion) {
  modalAutenticacion.addEventListener("click", (evento) => {
    if (evento.target === modalAutenticacion) {
      cerrarModal();
    }
  });
}

/* Cerrar al pulsar Escape */
document.addEventListener("keydown", (evento) => {
  if (
    evento.key === "Escape" &&
    modalAutenticacion &&
    !modalAutenticacion.hidden
  ) {
    cerrarModal();
  }
});

/* Mostrar u ocultar la contraseña */
document.querySelectorAll(".alternar-password").forEach((boton) => {
  boton.addEventListener("click", () => {
    const campo = document.getElementById(boton.dataset.target);
    const icono = boton.querySelector("i");

    if (!campo || !icono) return;

    const mostrar = campo.type === "password";

    campo.type = mostrar ? "text" : "password";

    icono.classList.toggle("bi-eye", !mostrar);
    icono.classList.toggle("bi-eye-slash", mostrar);

    boton.setAttribute(
      "aria-label",
      mostrar ? "Ocultar contraseña" : "Mostrar contraseña"
    );

    boton.setAttribute("aria-pressed", String(mostrar));
  });
});

/* Evitar recargas mientras probamos los formularios */
if (formularioInicio && formularioRegistro) {
  formularioInicio.addEventListener("input", () => {
    mensajeLogin.textContent = "";
  });
}

if (formularioInicio) {
  formularioInicio.addEventListener("submit", (evento) => {
    evento.preventDefault();
    
    const correoIngresado = document.getElementById("loginEmail").value.trim();
    const contrasenaIngresada = document.getElementById("loginPassword").value;

    if (correoIngresado === "") {
      mensajeLogin.textContent = "Por favor, ingresa tu correo electrónico.";
      return;
    }

    if (contrasenaIngresada === "") {
      mensajeLogin.textContent = "Por favor, ingresa tu contraseña.";
      return;
    }

    mensajeLogin.textContent = "Los campos están completos."

    console.log("Correo ingresado: ", correoIngresado);
  });
}

if (formularioRegistro) {
  formularioRegistro.addEventListener("submit", (evento) => {
    evento.preventDefault();
    
    if (campoPassword.value !== campoConfirmarPassword.value) {
      mensajeRegistro.textContent = "Las constraseñas no coinciden.";
      campoConfirmarPassword.focus();
      return;
    }

    mensajeRegistro.textContent = "¡Formulario valido correctamente!";
  });
}
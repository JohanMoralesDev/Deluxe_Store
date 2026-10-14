/* ===== MODAL DE INICIO DE SESIÓN Y REGISTRO ===== */
const botonAbrirModal = document.getElementById("abrirModalPerfil");
const modalAutenticacion = document.getElementById("modalAutenticacion");
const botonCerrarModal = document.getElementById("cerrarModal");
let elemementoAnterior = null;

const formularioInicio = document.getElementById("formularioLogin");
const formularioRegistro = document.getElementById("formularioRegistro");


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

/* ===== NAVEGACIÓN RESPONSIVE ===== */

const botonMenuTienda = document.getElementById("botonMenuTienda");
const menuPantallaCompleta = document.getElementById(
    "menuPantallaCompleta"
);

if (botonMenuTienda && menuPantallaCompleta) {

    const iconoMenu = botonMenuTienda.querySelector("i");
    function cambiarEstadoMenu(abrir) {
    // Activar o desactivar la clase que controla la animación.
    menuPantallaCompleta.classList.toggle("menu-abierto", abrir);

    // Actualizar los atributos de accesibilidad.
    menuPantallaCompleta.setAttribute(
        "aria-hidden",
        String(!abrir)
    );

    menuPantallaCompleta.inert = !abrir;

    botonMenuTienda.setAttribute(
        "aria-expanded",
        String(abrir)
    );

    botonMenuTienda.setAttribute(
        "aria-label",
        abrir
            ? "Cerrar menú de navegación"
            : "Abrir menú de navegación"
    );

    // Cambiar el icono entre menú y cierre.
    if (iconoMenu) {
        iconoMenu.classList.toggle("bi-list", !abrir);
        iconoMenu.classList.toggle("bi-x-lg", abrir);
    }

    // Bloquear el desplazamiento del fondo.
    document.body.style.overflow = abrir ? "hidden" : "";
}

    // Estado inicial.
    cambiarEstadoMenu(false);

    // Abrir y cerrar con el botón.
    botonMenuTienda.addEventListener("click", () => {
        const estaAbierto =
            botonMenuTienda.getAttribute("aria-expanded") === "true";

        cambiarEstadoMenu(!estaAbierto);
    });

    // Cerrar al seleccionar un enlace.
    menuPantallaCompleta.querySelectorAll("a").forEach((enlace) => {
        enlace.addEventListener("click", () => {
            cambiarEstadoMenu(false);
        });
    });

    // Cerrar con Escape.
    document.addEventListener("keydown", (evento) => {
        if (
            evento.key === "Escape" &&
            botonMenuTienda.getAttribute("aria-expanded") === "true"
        ) {
            cambiarEstadoMenu(false);
            botonMenuTienda.focus();
        }
    });
}



/* ===== CATALOGO ===== */

document.addEventListener("DOMContentLoaded", () => {
    // Comprobar que estamos en una página con catálogo.
    const catalogo = document.querySelector(".contenido-catalogo");
    if (!catalogo) return;

    const productos = Array.from(
        catalogo.querySelectorAll(".product-box")
    );

    const buscador = document.querySelector("#buscarProducto");
    const filtroColeccion = document.querySelector("#filtroColeccion");
    const filtroTamano = document.querySelector("#filtroTamano");
    const filtroPublico = document.querySelector("#filtroPublico");
    const botonesFiltro = document.querySelectorAll("[data-filtro]");

    let mostrarNuevos = false;

    function normalizar(texto) {
        return texto
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .trim();
    }

    function aplicarFiltros() {
        const busqueda = normalizar(buscador?.value || "");
        const coleccion = filtroColeccion?.value || "todas";
        const tamano = filtroTamano?.value || "todos";
        const publico = filtroPublico?.value || "todos";

        productos.forEach((producto) => {
            const nombre = normalizar(
                producto.dataset.nombre || producto.textContent
            );

            const textoCompleto = normalizar(producto.textContent);
            const publicoProducto = producto.dataset.publico || "";
            const coleccionProducto = producto.dataset.coleccion || "";
            const tamanoProducto = producto.dataset.tamano || "";

            const coincideBusqueda =
                nombre.includes(busqueda) ||
                textoCompleto.includes(busqueda);

            const coincideColeccion =
                coleccion === "todas" ||
                coleccionProducto === coleccion;

            const coincidePublico =
                publico === "todos" ||
                publicoProducto === publico;

            const coincideTamano =
                tamano === "todos" ||
                tamanoProducto === tamano;

            const mostrar =
                coincideBusqueda &&
                coincideColeccion &&
                coincidePublico &&
                coincideTamano;

            producto.hidden = !mostrar;
        });

        if (mostrarNuevos) {
            const visibles = productos.filter(
                (producto) => !producto.hidden
            );

            visibles.sort((a, b) => {
                const fechaA = a.dataset.fecha || "";
                const fechaB = b.dataset.fecha || "";
                return fechaB.localeCompare(fechaA);
            });

            const contenedor = productos[0]?.parentElement;

            if (contenedor) {
                visibles.forEach((producto) => {
                    contenedor.appendChild(producto);
                });
            }
        }
    }

    if (buscador) {
        buscador.addEventListener("input", aplicarFiltros);
    }

    [
        filtroColeccion,
        filtroTamano,
        filtroPublico
    ].forEach((control) => {
        control?.addEventListener("change", aplicarFiltros);
    });

    botonesFiltro.forEach((boton) => {
        boton.addEventListener("click", () => {
            const filtro = boton.dataset.filtro;

            botonesFiltro.forEach((otro) => {
                const activo = otro === boton;
                otro.classList.toggle("activo", activo);
                otro.setAttribute("aria-pressed", String(activo));
            });

            if (filtro === "todos") {
                mostrarNuevos = false;

                if (buscador) buscador.value = "";
                if (filtroColeccion) filtroColeccion.value = "todas";
                if (filtroTamano) filtroTamano.value = "todos";
                if (filtroPublico) filtroPublico.value = "todos";
            }

            if (filtro === "nuevos") {
                mostrarNuevos = true;
            }

            aplicarFiltros();
        });
    });

    aplicarFiltros();
});


document.addEventListener("DOMContentLoaded", () => {
    const tarjetas = document.querySelectorAll(
        ".contenido-catalogo .product-box"
    );

    if (tarjetas.length === 0) return;

    function obtenerPrecio(elemento) {
        if (!elemento) return 0;

        // Admite precios como "$160.000" o "160000".
        const numero = elemento.textContent.replace(/[^\d]/g, "");
        return Number(numero) || 0;
    }

    tarjetas.forEach((tarjeta) => {
        const precioActual = obtenerPrecio(
            tarjeta.querySelector(".product-price")
        );

        const precioAnterior = obtenerPrecio(
            tarjeta.querySelector(".precio-anterior")
        );

        let etiqueta = tarjeta.querySelector(".offer");

        if (!etiqueta) {
            etiqueta = document.createElement("span");
            etiqueta.className = "offer";
            tarjeta.prepend(etiqueta);
        }

        if (precioAnterior > precioActual && precioActual > 0) {
            const descuento = Math.round(
                ((precioAnterior - precioActual) / precioAnterior) * 100
            );

            etiqueta.textContent = `-${descuento}%`;
            etiqueta.classList.remove("hidden");
            etiqueta.hidden = false;
        } else {
            etiqueta.textContent = "";
            etiqueta.classList.add("hidden");
            etiqueta.hidden = true;
        }
    });
});
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

/* Los formularios envían sus datos a los controladores Laravel. */

/* Abrir el formulario solicitado tras una respuesta de autenticación. */
const tipoModalInicial = modalAutenticacion?.dataset.authStart;
if (tipoModalInicial === "login" || tipoModalInicial === "register") {
  abrirModal();
  if (tipoModalInicial === "register") mostrarRegistro();
}
/* ===== NAVEGACIÓN RESPONSIVE ===== */

/* Menú de cuenta autenticada: admite teclado y cierre al pulsar fuera. */
const botonMenuCuenta = document.getElementById("botonMenuCuenta");
const menuCuenta = document.getElementById("menuCuenta");

if (botonMenuCuenta && menuCuenta) {
  function cerrarMenuCuenta(devolverFoco = false) {
    menuCuenta.hidden = true;
    botonMenuCuenta.setAttribute("aria-expanded", "false");
    if (devolverFoco) botonMenuCuenta.focus();
  }

  function alternarMenuCuenta() {
    const abrir = menuCuenta.hidden;
    menuCuenta.hidden = !abrir;
    botonMenuCuenta.setAttribute("aria-expanded", String(abrir));
  }

  botonMenuCuenta.addEventListener("click", alternarMenuCuenta);
  botonMenuCuenta.addEventListener("keydown", (evento) => {
    if (evento.key === "ArrowDown") {
      evento.preventDefault();
      menuCuenta.hidden = false;
      botonMenuCuenta.setAttribute("aria-expanded", "true");
      menuCuenta.querySelector("a, button")?.focus();
    }
  });

  document.addEventListener("click", (evento) => {
    if (!menuCuenta.contains(evento.target) && !botonMenuCuenta.contains(evento.target)) {
      cerrarMenuCuenta();
    }
  });

  document.addEventListener("keydown", (evento) => {
    if (evento.key === "Escape" && !menuCuenta.hidden) cerrarMenuCuenta(true);
  });
}

document.querySelectorAll("form[data-loading-label]").forEach((formulario) => {
  formulario.addEventListener("submit", () => {
    const boton = formulario.querySelector('button[type="submit"]');
    if (!boton) return;
    boton.textContent = formulario.dataset.loadingLabel;
    boton.disabled = true;
    boton.setAttribute("aria-busy", "true");
  });
});

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

    function crearFiltroPersonalizado(select) {
        if (!select) return () => {};

        const etiqueta = catalogo.querySelector(`label[for="${select.id}"]`);
        const contenedor = document.createElement("div");
        contenedor.className = "filtro-personalizado";

        select.parentElement.insertBefore(contenedor, select);
        contenedor.appendChild(select);

        const boton = document.createElement("button");
        boton.type = "button";
        boton.className = "filtro-disparador";
        boton.id = `${select.id}Disparador`;
        boton.setAttribute("aria-haspopup", "listbox");
        boton.setAttribute("aria-expanded", "false");
        boton.setAttribute("aria-controls", `${select.id}Opciones`);
        boton.innerHTML = '<span class="filtro-valor"></span><i class="bi bi-chevron-down" aria-hidden="true"></i>';

        if (etiqueta) {
            if (!etiqueta.id) etiqueta.id = `${select.id}Etiqueta`;
            etiqueta.htmlFor = boton.id;
            boton.setAttribute("aria-labelledby", etiqueta.id);
        }

        const lista = document.createElement("div");
        lista.className = "filtro-opciones";
        lista.id = `${select.id}Opciones`;
        lista.setAttribute("role", "listbox");
        lista.setAttribute("aria-label", etiqueta?.textContent.trim() || "Opciones");
        lista.hidden = true;

        const opciones = Array.from(select.options).map((opcion) => {
            const elemento = document.createElement("div");
            elemento.className = "filtro-opcion-lista";
            elemento.id = `${select.id}Opcion${opcion.index}`;
            elemento.setAttribute("role", "option");
            elemento.tabIndex = -1;
            elemento.dataset.value = opcion.value;
            elemento.textContent = opcion.textContent.trim();
            lista.appendChild(elemento);
            return elemento;
        });

        select.classList.add("filtro-nativo-oculto");
        select.tabIndex = -1;
        select.setAttribute("aria-hidden", "true");
        contenedor.append(boton, lista);

        function opcionActiva() {
            return opciones.find((opcion) => opcion.dataset.value === select.value) || opciones[0];
        }

        function sincronizar() {
            const actual = opcionActiva();
            boton.querySelector(".filtro-valor").textContent = actual?.textContent || "";

            opciones.forEach((opcion) => {
                const seleccionada = opcion === actual;
                opcion.setAttribute("aria-selected", String(seleccionada));
                opcion.tabIndex = seleccionada ? 0 : -1;
            });
        }

        function cerrar(devolverFoco = false) {
            lista.hidden = true;
            boton.setAttribute("aria-expanded", "false");
            contenedor.classList.remove("abierto");
            if (devolverFoco) boton.focus();
        }

        function abrir() {
            document.querySelectorAll(".filtro-personalizado").forEach((otro) => {
                if (otro === contenedor) return;
                otro.querySelector(".filtro-opciones").hidden = true;
                otro.querySelector(".filtro-disparador").setAttribute("aria-expanded", "false");
                otro.classList.remove("abierto");
            });

            sincronizar();
            lista.hidden = false;
            boton.setAttribute("aria-expanded", "true");
            contenedor.classList.add("abierto");
            opcionActiva()?.focus();
        }

        function seleccionar(opcion) {
            if (!opcion) return;
            select.value = opcion.dataset.value;
            sincronizar();
            select.dispatchEvent(new Event("change", { bubbles: true }));
            cerrar(true);
        }

        boton.addEventListener("click", () => {
            if (lista.hidden) abrir();
            else cerrar();
        });

        opciones.forEach((opcion, indice) => {
            opcion.addEventListener("click", () => seleccionar(opcion));
            opcion.addEventListener("keydown", (evento) => {
                let destino = null;

                if (evento.key === "ArrowDown") destino = opciones[(indice + 1) % opciones.length];
                if (evento.key === "ArrowUp") destino = opciones[(indice - 1 + opciones.length) % opciones.length];
                if (evento.key === "Home") destino = opciones[0];
                if (evento.key === "End") destino = opciones[opciones.length - 1];

                if (destino) {
                    evento.preventDefault();
                    destino.focus();
                } else if (evento.key === "Enter" || evento.key === " ") {
                    evento.preventDefault();
                    seleccionar(opcion);
                } else if (evento.key === "Escape") {
                    evento.preventDefault();
                    cerrar(true);
                } else if (evento.key === "Tab") {
                    window.setTimeout(() => cerrar(), 0);
                }
            });
        });

        boton.addEventListener("keydown", (evento) => {
            if (["ArrowDown", "ArrowUp", "Enter", " "].includes(evento.key)) {
                evento.preventDefault();
                abrir();
            }
        });

        select.addEventListener("change", sincronizar);
        sincronizar();

        return sincronizar;
    }

    const sincronizarFiltrosPersonalizados = Array.from(
        catalogo.querySelectorAll("select.filtro"),
        crearFiltroPersonalizado
    );

    document.addEventListener("click", (evento) => {
        document.querySelectorAll(".filtro-personalizado").forEach((contenedor) => {
            if (contenedor.contains(evento.target)) return;
            const lista = contenedor.querySelector(".filtro-opciones");
            lista.hidden = true;
            contenedor.querySelector(".filtro-disparador").setAttribute("aria-expanded", "false");
            contenedor.classList.remove("abierto");
        });
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

            sincronizarFiltrosPersonalizados.forEach((sincronizar) => sincronizar());
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

    const claveFavoritos = "deluxeFavoritos";
    let favoritos = [];

    try {
        const guardados = JSON.parse(localStorage.getItem(claveFavoritos));
        favoritos = Array.isArray(guardados) ? guardados.map(String) : [];
    } catch (error) {
        favoritos = [];
    }

    function guardarFavoritos() {
        try {
            localStorage.setItem(claveFavoritos, JSON.stringify(favoritos));
        } catch (error) {
            console.error("No se pudieron guardar los favoritos:", error);
        }
    }

    tarjetas.forEach((tarjeta) => {
        const precioActual = Number(tarjeta.dataset.precio) || 0;
        const precioAnterior = Number(tarjeta.dataset.precioAnterior) || 0;

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
            etiqueta.setAttribute("aria-label", `Oferta: ${descuento}% de descuento`);
            etiqueta.classList.remove("hidden");
            etiqueta.hidden = false;
        } else {
            etiqueta.textContent = "";
            etiqueta.classList.add("hidden");
            etiqueta.hidden = true;
        }

        const id = tarjeta.dataset.id;
        if (!id) return;

        let botonFavorito = tarjeta.querySelector(".boton-favorito");
        if (!botonFavorito) {
            botonFavorito = document.createElement("button");
            botonFavorito.type = "button";
            botonFavorito.className = "boton-favorito";
            botonFavorito.innerHTML = '<i class="bi bi-heart" aria-hidden="true"></i>';
            tarjeta.appendChild(botonFavorito);
        }

        const estaEnFavoritos = favoritos.includes(String(id));
        botonFavorito.setAttribute("aria-pressed", String(estaEnFavoritos));
        botonFavorito.setAttribute(
            "aria-label",
            estaEnFavoritos ? "Quitar de favoritos" : "Añadir a favoritos"
        );
        botonFavorito.querySelector("i")?.classList.toggle("bi-heart-fill", estaEnFavoritos);
        botonFavorito.querySelector("i")?.classList.toggle("bi-heart", !estaEnFavoritos);

        botonFavorito.addEventListener("click", () => {
            const indice = favoritos.indexOf(String(id));
            if (indice === -1) favoritos.push(String(id));
            else favoritos.splice(indice, 1);

            const seleccionado = indice === -1;
            botonFavorito.setAttribute("aria-pressed", String(seleccionado));
            botonFavorito.setAttribute(
                "aria-label",
                seleccionado ? "Quitar de favoritos" : "Añadir a favoritos"
            );
            botonFavorito.querySelector("i")?.classList.toggle("bi-heart-fill", seleccionado);
            botonFavorito.querySelector("i")?.classList.toggle("bi-heart", !seleccionado);
            guardarFavoritos();
        });
    });
});

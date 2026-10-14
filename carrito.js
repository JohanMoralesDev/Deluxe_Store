
(function () {
  "use strict";

  const CLAVE_CARRITO = "deluxeCarrito";

  const CANTIDAD_MINIMA = 1;
  const CANTIDAD_MAXIMA = 99;


  function calcularEnvio(/* productos */) {
    return 0;
  }



  const listaCarrito = document.querySelector(".carrito-lista");
  const resumenSubtotal = document.getElementById("resumen-subtotal");
  const resumenDescuento = document.getElementById("resumen-descuento");
  const resumenEnvio = document.getElementById("resumen-envio");
  const resumenTotal = document.getElementById("resumen-total");
  const botonPagar = document.querySelector(".boton-pagar");
  const enlaceCarrito = document.querySelector('a[href="carrito.html"]');

  if (!listaCarrito) return;



  const formatoMoneda = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    maximumFractionDigits: 0,
  });

  function formatearPrecio(valor) {
    return formatoMoneda.format(valor);
  }

  function leerCarrito() {
    try {
      const datos = JSON.parse(localStorage.getItem(CLAVE_CARRITO));
      return Array.isArray(datos) ? datos : [];
    } catch (error) {
      return [];
    }
  }

  function guardarCarrito(productos) {
    try {
      localStorage.setItem(CLAVE_CARRITO, JSON.stringify(productos));
    } catch (error) {
      console.error("No se pudo guardar el carrito:", error);
    }
  }

  function crearElemento(etiqueta, clase, texto) {
    const elemento = document.createElement(etiqueta);
    if (clase) elemento.className = clase;
    if (texto !== undefined) elemento.textContent = texto;
    return elemento;
  }

 

  function crearBotonCantidad(clase, etiqueta, icono) {
    const boton = crearElemento("button", clase);
    boton.type = "button";
    boton.setAttribute("aria-label", etiqueta);
    boton.appendChild(crearElemento("i", "bi " + icono));
    return boton;
  }

  function crearTarjeta(producto) {
    const tarjeta = crearElemento("article", "carrito-item");
    tarjeta.dataset.id = producto.id;

   
    const contenedorImagen = crearElemento("div", "carrito-item-imagen");
    const imagen = document.createElement("img");
    imagen.src = producto.imagen || "";
    imagen.alt = producto.nombre;
    contenedorImagen.appendChild(imagen);

    const info = crearElemento("div", "carrito-item-info");
    info.appendChild(crearElemento("h2", "carrito-item-nombre", producto.nombre));
    info.appendChild(
      crearElemento("p", "carrito-item-descripcion", producto.descripcion || "")
    );

    const acciones = crearElemento("div", "carrito-item-acciones");

    const selector = crearElemento("div", "selector-cantidad");
    selector.setAttribute("role", "group");
    selector.setAttribute("aria-label", "Cantidad");

    const botonMenos = crearBotonCantidad(
      "cantidad-menos",
      "Disminuir cantidad",
      "bi-dash"
    );
    const valor = crearElemento("span", "cantidad-valor", String(producto.cantidad));
    valor.setAttribute("aria-live", "polite");
    const botonMas = crearBotonCantidad(
      "cantidad-mas",
      "Aumentar cantidad",
      "bi-plus"
    );

    botonMenos.disabled = producto.cantidad <= CANTIDAD_MINIMA;
    botonMas.disabled = producto.cantidad >= CANTIDAD_MAXIMA;

    selector.append(botonMenos, valor, botonMas);

    const botonEliminar = crearElemento("button", "boton-eliminar");
    botonEliminar.type = "button";
    botonEliminar.appendChild(crearElemento("i", "bi bi-trash3"));
    botonEliminar.appendChild(crearElemento("span", "", "Eliminar"));

    acciones.append(selector, botonEliminar);
    info.appendChild(acciones);

    
    const precios = crearElemento("p", "carrito-item-precios");
    if (producto.precioAntes && producto.precioAntes > producto.precio) {
      precios.appendChild(
        crearElemento(
          "span",
          "precio-antes",
          formatearPrecio(producto.precioAntes * producto.cantidad)
        )
      );
    }
    precios.appendChild(
      crearElemento(
        "span",
        "precio-actual",
        formatearPrecio(producto.precio * producto.cantidad)
      )
    );

    tarjeta.append(contenedorImagen, info, precios);
    return tarjeta;
  }

  

  function actualizarResumen(productos) {
    let subtotal = 0;
    let descuento = 0;

    productos.forEach((producto) => {
      const antes =
        producto.precioAntes && producto.precioAntes > producto.precio
          ? producto.precioAntes
          : producto.precio;

      subtotal += antes * producto.cantidad;
      descuento += (antes - producto.precio) * producto.cantidad;
    });

    const envio = productos.length ? calcularEnvio(productos) : 0;
    const total = subtotal - descuento + envio;

    resumenSubtotal.textContent = formatearPrecio(subtotal);
    resumenDescuento.textContent = "-" + formatearPrecio(descuento);
    resumenEnvio.textContent = envio === 0 ? "Gratis" : formatearPrecio(envio);
    resumenTotal.textContent = formatearPrecio(total);

    
    if (botonPagar) {
      botonPagar.setAttribute("aria-disabled", String(productos.length === 0));
      botonPagar.classList.toggle("deshabilitado", productos.length === 0);
    }
  }

  

  function actualizarContador(productos) {
    if (!enlaceCarrito) return;

  
    let contador = enlaceCarrito.querySelector(".contador-carrito");
    if (!contador) {
      contador = crearElemento("span", "contador-carrito");
      enlaceCarrito.appendChild(contador);
    }

    const unidades = productos.reduce((suma, p) => suma + p.cantidad, 0);
    contador.textContent = String(unidades);
  }



  function dibujarCarrito() {
    const productos = leerCarrito();

    listaCarrito.replaceChildren();

    if (productos.length === 0) {
     
      listaCarrito.appendChild(
        crearElemento("p", "carrito-vacio", "Tu carrito está vacío.")
      );
    } else {
      productos.forEach((producto) => {
        listaCarrito.appendChild(crearTarjeta(producto));
      });
    }

    actualizarResumen(productos);
    actualizarContador(productos);
  }



  function cambiarCantidad(id, cambio) {
    const productos = leerCarrito();
    const producto = productos.find((p) => String(p.id) === String(id));
    if (!producto) return;

    producto.cantidad = Math.min(
      CANTIDAD_MAXIMA,
      Math.max(CANTIDAD_MINIMA, producto.cantidad + cambio)
    );

    guardarCarrito(productos);
    dibujarCarrito();
  }

  function eliminarProducto(id) {
    const productos = leerCarrito().filter((p) => String(p.id) !== String(id));
    guardarCarrito(productos);
    dibujarCarrito();
  }


  listaCarrito.addEventListener("click", (evento) => {
    const boton = evento.target.closest("button");
    const tarjeta = evento.target.closest(".carrito-item");
    if (!boton || !tarjeta) return;

    const id = tarjeta.dataset.id;

    if (boton.classList.contains("cantidad-mas")) {
      cambiarCantidad(id, 1);
      devolverFoco(id, "cantidad-mas");
    } else if (boton.classList.contains("cantidad-menos")) {
      cambiarCantidad(id, -1);
      devolverFoco(id, "cantidad-menos");
    } else if (boton.classList.contains("boton-eliminar")) {
      eliminarProducto(id);
    }
  });

 
  function devolverFoco(id, clase) {
    const objetivo = listaCarrito.querySelector(
      `[data-id="${CSS.escape(id)}"] .${clase}`
    );
    if (objetivo && !objetivo.disabled) objetivo.focus();
  }

 
  if (botonPagar) {
    botonPagar.addEventListener("click", (evento) => {
      if (leerCarrito().length === 0) evento.preventDefault();
    });
  }


  window.addEventListener("storage", (evento) => {
    if (evento.key === CLAVE_CARRITO) dibujarCarrito();
  });



  dibujarCarrito();
})();
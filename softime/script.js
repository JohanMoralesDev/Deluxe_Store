const botonAbrirBuscador = document.getElementById("abrirBuscador");
const campoBuscar = document.getElementById("campoBuscar");

if (botonAbrirBuscador && campoBuscar) {
  botonAbrirBuscador.addEventListener("click", () => {
    campoBuscar.classList.toggle("activo");

    if (campoBuscar.classList.contains("activo")) {
      const input = campoBuscar.querySelector("input");
      if (inpuBuscar) inputBuscar.focus();
    }
  });
}

const botonDescubrirMas = document.querySelector(".Nueva.coleccion .Boton");
const seccionMasVendidos = document.querySelector(".Mas.vendidos");

if (botonDescubrirMas && seccionMasVendidos) {
  botonDescubrirMas.addEventListener("click", () => {
    seccionMasVendidos.scrollIntoView({ behavior: "smooth" });
  });
}

const botonesAnadirCarrito = document.querySelectorAll(".Productos .Boton");
const enlaceCarrito = document.querySelector('a[href="#Carrito"]');

let totalCarrito = 0;
let contadorCarrito = 0;

if (enlaceCarrito) {
  contadorCarrito = document.createElement("span");
  contadorCarrito.className = "contador-carrito";
  contadorCarrito.textContent = "0";
  enlaceCarrito.appendChild(contadorCarrito);
}

botonesAnadirCarrito.forEach((boton) => {
  boton.addEventListener("click", () => {
    totalCarrito++;

    if (contadorCarrito) {
      contadorCarrito.textContent = totalCarrito;
    }

    const textoOriginal = boton.textContent;

    boton.textContent = "Añadido";
    boton.disabled = true;

    setTimeout(() => {
      boton.textContent = textoOriginal;
      boton.disabled = false;
    }, 1000);
  });
});

document.querySelectorAll('a[href^="#"]').forEach((enlace) => {
  enlace.addEventListener("click", (evento) => {
    const idDestino = enlace.getAttribute("href").slice(1);
    const elementoDestino = document.getElementById(idDestino);

    if (elementoDestino) {
      evento.preventDefault();
      elementoDestino.scrollIntoView({ behavior: "smooth" });
    }
  });
});

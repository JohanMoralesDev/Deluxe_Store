/* ===== DATOS DEL INVENTARIO ===== */

const productos = [
    {
        nombre: "Reloj marca Curren para caballero",
        precio: 160000,
        stock: 12,
        stockMinimo: 5
    },
    {
        nombre: "Reloj marca Curren para mujer",
        precio: 130000,
        stock: 3,
        stockMinimo: 5
    },
    {
        nombre: "Reloj marca Q&Q",
        precio: 86000,
        stock: 8,
        stockMinimo: 4
    },
    {
        nombre: "Reloj marca Rolex para caballero",
        precio: 120000,
        stock: 2,
        stockMinimo: 4
    },
    {
        nombre: "Reloj marca Calvin Klein para caballero",
        precio: 20000,
        stock: 15,
        stockMinimo: 5
    },
    {
        nombre: "Reloj marca Pandora para dama",
        precio: 35000,
        stock: 6,
        stockMinimo: 4
    },
    {
        nombre: "Reloj Naviforce para caballero",
        precio: 115000,
        stock: 4,
        stockMinimo: 5
    },
    {
        nombre: "Reloj Cubano para caballero",
        precio: 86000,
        stock: 10,
        stockMinimo: 4
    },
    {
        nombre: "Reloj FairWhale para caballero",
        precio: 160000,
        stock: 7,
        stockMinimo: 4
    },
    {
        nombre: "Reloj G-Fox Automático para caballero",
        precio: 140000,
        stock: 3,
        stockMinimo: 4
    },
    {
        nombre: "Reloj FoxBox para caballero",
        precio: 145000,
        stock: 9,
        stockMinimo: 5
    }
];

/* ===== PEDIDOS DE EJEMPLO ===== */
const pedidos = [
    {id: 1001, total: 160000, estado: "pagado"},
    {id: 1002, total: 130000, estado: "pendiente"},
    {id: 1003, total: 86000, estado: "pagado"},
    {id: 1004, total: 120000, estado: "pagado"}
];

/* ===== FORMATO DE MONEDA ===== */
const formatoMoneda = new Intl.NumberFormat("es-CO", {
    style: "currency",
    currency: "COP",
    maximumFractionDigits: 0
});

/* ===== CALCULAR LOS INDICADORES ===== */

/* Suma únicamente de los pedidos pagados */
const totalVentas = pedidos
    .filter(pedido => pedido.estado === "pagado")
    .reduce((total, pedido) => total + pedido.total, 0);

/* Detectar productos con existencias bajas */
const productosBajos = productos.filter(
    producto => producto.stock <= producto.stockMinimo
);

/* Mostrar las cifras en las tarjetas del dashboard */
document.getElementById("totalVentas").textContent =
    formatoMoneda.format(totalVentas);

document.getElementById("totalPedidos").textContent =
    pedidos.length;

document.getElementById("totalProductos").textContent =
    productos.length;

document.getElementById("productosStockBajo").textContent =
    productosBajos.length;

/* ===== CONSTRUIR LA TABLA DEL INVENTARIO ===== */
const tablaProductos = document.getElementById("tablaProductos");

productos.forEach(producto => {

    // Crear fil apara cada producto
    const fila = document.createElement("tr");

    // Crear las cinco celdas de la fila
    const celdaNombre = document.createElement("td");
    const celdaPrecio = document.createElement("td");
    const celdaStock = document.createElement("td");
    const celdaMinimo = document.createElement("td");
    const celdaEstado = document.createElement("td");

    //Colocar los datos del producto
    celdaNombre.textContent = producto.nombre;
    celdaPrecio.textContent = formatoMoneda.format(producto.precio);
    celdaStock.textContent = producto.stock;
    celdaMinimo.textContent = producto.stockMinimo;

    //Comprobar si necesita reposición
    if (producto.stock <= producto.stockMinimo) {
        celdaEstado.textContent = "Stock bajo";
        celdaEstado.classList.add("estado-stock-bajo");
    } else {
        celdaEstado.textContent = "Disponible";
        celdaEstado.classList.add("estado-disponible");
    }

    // Incorporar las celdas a la fila
    fila.append(
        celdaNombre,
        celdaPrecio,
        celdaStock,
        celdaMinimo,
        celdaEstado
    );

    // Incorporar la fila a la tabla
    tablaProductos.appendChild(fila);
});

/* ===== MENÚ RESPONSIVE DE ADMINISTRACIÓN ===== */
const botonMenuMovil = document.getElementById("botonMenuMovil");
const barraLateral = document.getElementById("barraLateral");

if (botonMenuMovil && barraLateral) {

botonMenuMovil.addEventListener("click", () => {
    const menuAbierto = barraLateral.classList.toggle("menu-abierto");

    botonMenuMovil.setAttribute("aria-expanded", menuAbierto);

    botonMenuMovil.innerHTML = menuAbierto
    ? '<i class="bi bi-x-lg"></i><span>Cerrar menú</span>'
    : '<i class=bi bi-list"></i><span>Menú</span>';
});
} else {
    console.error("No se encontró el botón o la barra lateral del menú");
}

/* Navegación móvil del panel administrativo */
const botonMenuMovil = document.getElementById("botonMenuMovil");
const barraLateral = document.getElementById("barraLateral");

if (botonMenuMovil && barraLateral) {
    function cerrarMenu() {
        barraLateral.classList.remove("menu-abierto");
        botonMenuMovil.setAttribute("aria-expanded", "false");
        botonMenuMovil.setAttribute("aria-label", "Abrir menú administrativo");
        botonMenuMovil.innerHTML = '<i class="bi bi-list" aria-hidden="true"></i><span>Menú</span>';
    }

    botonMenuMovil.addEventListener("click", () => {
        const abierto = barraLateral.classList.toggle("menu-abierto");
        botonMenuMovil.setAttribute("aria-expanded", String(abierto));
        botonMenuMovil.setAttribute("aria-label", abierto ? "Cerrar menú administrativo" : "Abrir menú administrativo");
        botonMenuMovil.innerHTML = abierto
            ? '<i class="bi bi-x-lg" aria-hidden="true"></i><span>Cerrar menú</span>'
            : '<i class="bi bi-list" aria-hidden="true"></i><span>Menú</span>';
    });

    barraLateral.querySelectorAll("a").forEach((enlace) => {
        enlace.addEventListener("click", cerrarMenu);
    });

    document.addEventListener("keydown", (evento) => {
        if (evento.key === "Escape" && barraLateral.classList.contains("menu-abierto")) {
            cerrarMenu();
            botonMenuMovil.focus();
        }
    });
}

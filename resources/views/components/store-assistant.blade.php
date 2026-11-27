<section class="asistente-widget asistente-widget--tienda" data-assistant-widget>
    <button class="asistente-lanzador" type="button" data-assistant-toggle aria-expanded="false" aria-controls="asistenteTiendaPanel">
        <i class="bi bi-chat-dots" aria-hidden="true"></i><span>Asistente de compras</span>
    </button>
    <section class="asistente-panel" id="asistenteTiendaPanel" aria-label="Asistente de compras" data-assistant-panel hidden>
        <header class="asistente-panel__cabecera">
            <div><strong>Asistente Deluxe</strong><small>Consultas sobre el catálogo</small></div>
            <button type="button" class="asistente-cerrar" data-assistant-close aria-label="Cerrar asistente"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
        </header>
        <div class="asistente-mensajes" data-assistant-messages role="log" aria-live="polite" aria-relevant="additions text">
            <p class="asistente-mensaje asistente-mensaje--bot">¡Hola! Puedo buscar productos, categorías, precios y disponibilidad usando los datos del catálogo.</p>
        </div>
        <form class="asistente-formulario" data-assistant-form action="{{ route('assistant.store.ask') }}">
            <label class="visually-hidden" for="mensajeAsistenteTienda">Escribe tu consulta</label>
            <input id="mensajeAsistenteTienda" name="message" maxlength="500" required autocomplete="off" placeholder="Buscar marca, modelo, precio...">
            <button type="submit" aria-label="Enviar consulta"><i class="bi bi-send" aria-hidden="true"></i></button>
        </form>
    </section>
</section>

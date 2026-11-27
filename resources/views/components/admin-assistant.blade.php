<section class="asistente-widget asistente-widget--admin" data-assistant-widget>
    <button class="asistente-lanzador" type="button" data-assistant-toggle aria-expanded="false" aria-controls="asistenteAdminPanel">
        <i class="bi bi-stars" aria-hidden="true"></i><span>Asistente admin</span>
    </button>
    <section class="asistente-panel" id="asistenteAdminPanel" aria-label="Asistente de administración" data-assistant-panel hidden>
        <header class="asistente-panel__cabecera">
            <div><strong>Asistente administrativo</strong><small>Consultas de solo lectura</small></div>
            <button type="button" class="asistente-cerrar" data-assistant-close aria-label="Cerrar asistente"><i class="bi bi-x-lg" aria-hidden="true"></i></button>
        </header>
        <div class="asistente-mensajes" data-assistant-messages role="log" aria-live="polite" aria-relevant="additions text">
            <p class="asistente-mensaje asistente-mensaje--bot">Puedo consultar productos, inventario, movimientos, pedidos y cifras registradas.</p>
        </div>
        <form class="asistente-formulario" data-assistant-form action="{{ route('admin.assistant.ask') }}">
            <label class="visually-hidden" for="mensajeAsistenteAdmin">Escribe tu consulta</label>
            <input id="mensajeAsistenteAdmin" name="message" maxlength="500" required autocomplete="off" placeholder="Ej.: ¿Qué productos tienen stock bajo?">
            <button type="submit" aria-label="Enviar consulta"><i class="bi bi-send" aria-hidden="true"></i></button>
        </form>
    </section>
</section>

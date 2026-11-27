document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll("[data-assistant-widget]").forEach((widget) => {
    const toggle = widget.querySelector("[data-assistant-toggle]");
    const panel = widget.querySelector("[data-assistant-panel]");
    const close = widget.querySelector("[data-assistant-close]");
    const form = widget.querySelector("[data-assistant-form]");
    const input = form?.querySelector('input[name="message"]');
    const log = widget.querySelector("[data-assistant-messages]");
    if (!toggle || !panel || !close || !form || !input || !log) return;

    const setOpen = (open) => {
      panel.hidden = !open;
      toggle.setAttribute("aria-expanded", String(open));
      if (open) input.focus(); else toggle.focus();
    };
    toggle.addEventListener("click", () => setOpen(panel.hidden));
    close.addEventListener("click", () => setOpen(false));
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && !panel.hidden) setOpen(false);
    });
    document.addEventListener("click", (event) => {
      if (!panel.hidden && !widget.contains(event.target)) setOpen(false);
    });

    const append = (node) => { log.append(node); log.scrollTop = log.scrollHeight; };
    const addMessage = (text, kind = "bot", records = [], links = []) => {
      const bubble = document.createElement("div");
      bubble.className = `asistente-mensaje asistente-mensaje--${kind}`;
      const paragraph = document.createElement("p");
      paragraph.textContent = text;
      bubble.append(paragraph);

      records.forEach((record) => {
        const titleText = record.name || record.producto || record.pedido || "Registro";
        if (record.image) {
          const card = document.createElement("a");
          card.className = "asistente-tarjeta-producto";
          try {
            const imageUrl = new URL(record.image, location.origin);
            if (imageUrl.origin === location.origin) {
              const image = document.createElement("img");
              image.src = imageUrl.href; image.alt = ""; image.loading = "lazy";
              card.append(image);
            }
          } catch (_) { /* Una imagen inválida se omite. */ }
          const details = document.createElement("span");
          const title = document.createElement("strong"); title.textContent = titleText; details.append(title);
          Object.entries(record).forEach(([key, value]) => {
            if (["name", "image", "url", "link_label"].includes(key) || value == null || value === "") return;
            const detail = document.createElement("small");
            detail.textContent = `${key.replaceAll("_", " ")}: ${String(value)}`; details.append(detail);
          });
          card.append(details);
          try {
            const url = new URL(record.url, location.origin);
            if (record.url && url.origin === location.origin) card.href = url.href;
          } catch (_) { /* Un enlace inválido queda omitido. */ }
          bubble.append(card);
        } else {
          const data = document.createElement("dl"); data.className = "asistente-datos";
          const row = document.createElement("div");
          const term = document.createElement("dt"); term.textContent = titleText;
          const definition = document.createElement("dd");
          definition.textContent = Object.entries(record)
            .filter(([key, value]) => !["name", "producto", "pedido", "image", "url", "link_label"].includes(key) && value != null && value !== "")
            .map(([key, value]) => `${key.replaceAll("_", " ")}: ${String(value)}`).join(" · ");
          row.append(term, definition); data.append(row); bubble.append(data);
        }
      });

      const validLinks = document.createElement("div"); validLinks.className = "asistente-enlaces";
      links.forEach((item) => {
        try {
          const url = new URL(item.url, location.origin);
          if (url.origin !== location.origin) return;
          const link = document.createElement("a"); link.href = url.href;
          link.textContent = item.label || "Abrir"; validLinks.append(link);
        } catch (_) { /* Ignora enlaces inválidos. */ }
      });
      if (validLinks.childElementCount) bubble.append(validLinks);
      append(bubble);
    };

    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const message = input.value.trim(); if (!message) return;
      addMessage(message, "usuario"); input.value = "";
      const submit = form.querySelector('button[type="submit"]');
      if (submit) submit.disabled = true;
      input.disabled = true;
      try {
        const response = await fetch(form.action, {
          method: "POST",
          headers: { Accept: "application/json", "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "" },
          body: JSON.stringify({ message }),
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || "No se pudo completar la consulta.");
        addMessage(data.message || "No encontré resultados.", "bot", data.products || data.data || data.items || [], data.links || []);
      } catch (error) {
        addMessage(error.message || "No fue posible conectar con el asistente. Inténtalo de nuevo.");
      } finally {
        if (submit) submit.disabled = false;
        input.disabled = false; input.focus();
      }
    });
  });
});

(() => {
    'use strict';

    document.querySelectorAll('form[action*="/carrito"]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const method = form.querySelector('input[name="_method"]')?.value;

            if (method === 'DELETE' && !window.confirm('¿Deseas eliminar estos productos del carrito?')) {
                event.preventDefault();
                return;
            }

            const quantity = form.querySelector('input[name="quantity"]');
            if (quantity && (!quantity.value || Number(quantity.value) < 1)) {
                event.preventDefault();
                quantity.focus();
                quantity.reportValidity();
            }
        });
    });
})();

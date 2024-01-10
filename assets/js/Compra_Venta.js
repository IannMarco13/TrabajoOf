const relacionesAgenciaMoneda = {
    101: ['USD', 'CLP', 'BRL', 'EUR', 'ARS', 'ASD', 'CAD', 'PEN', 'GBP', 'CHF', 'NZD', 'PYG'], 
    202: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'], 
    210: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'],
    301: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'],
    401: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'], 
    501: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'],
    701: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'],
    702: ['USD', 'CLP', 'BRL', 'EUR', 'ARS','PEN'],
};

// Función para actualizar las opciones del menú de monedas según la agencia seleccionada
document.getElementById('agencia').addEventListener('change', function() {
    const agenciaSeleccionada = this.value;
    const opcionesMoneda = relacionesAgenciaMoneda[agenciaSeleccionada];

    const menuMoneda = document.getElementById('moneda');
    menuMoneda.innerHTML = ''; // Limpiar las opciones existentes

    if (opcionesMoneda) {
        opcionesMoneda.forEach(function(moneda) {
            const opcion = document.createElement('option');
            opcion.value = moneda;
            opcion.textContent = moneda; 

            menuMoneda.appendChild(opcion);
        });
    }
});

// Esta función calcula el valor en la columna "Total Bolivianos" y "Total USD" para una fila dada
function calcularDolarizado(fila) {
    // Obtener el valor de la moneda para la fila actual
    var moneda = fila.querySelector("td.moneda").innerText.trim();

    // Obtener el valor ingresado en el input "Total Enviado" y convertirlo a un número decimal
    var totalEnviado = parseFloat(fila.querySelector("input[name^='TotalEnviado']").value);//  ^= en el selector de atributo para encontrar el campo que comienza con el nombre TotalEnviado.
    
    // Obtener los tipos de cambio de venta y compra para la moneda de la fila actual
    var tipoCambioVenta = parseFloat(fila.querySelector("td.tipo-cambio-venta").innerText);
    var tipoCambioCompra = parseFloat(fila.querySelector("td.tipo-cambio-compra").innerText);

    // Calcular el resultado de la operación multiplicando el total enviado por el tipo de cambio de venta

    var resultadoOp = moneda === '' ? totalEnviado : totalEnviado * tipoCambioVenta;

    // Calcular el total dolarizado basado en la moneda
    var totalDolarizado = moneda === 'DÓLAR ESTADOUNIDENSE' ? totalEnviado : resultadoOp / tipoCambioCompra;

    // Mostrar el resultado de la operación en la columna "Total Bolivianos"
    fila.querySelector("td.resultado-op").innerText = resultadoOp.toFixed(2);

    // Mostrar el total dolarizado en la columna "Total USD", redondeado a número entero si es USD, de lo contrario con 2 decimales
    fila.querySelector("td.total-dolarizado").innerText = moneda === '' ? totalDolarizado.toFixed(0) : totalDolarizado.toFixed(2);
    // Actualizar el total dolarizado global y mostrarlo
    actualizarTotalDolarizado();
}

// Esta función actualiza el total dolarizado global sumando los valores de todas las filas
function actualizarTotalDolarizado() {
    var totalDolarizado = 0;

    // Obtener todas las filas que tienen el atributo "data-monedas"
    var filas = document.querySelectorAll("tr[data-monedas]");

    // Recorrer todas las filas y sumar los valores de "Total USD"
    filas.forEach(function(fila) {
        totalDolarizado += parseFloat(fila.querySelector("td.total-dolarizado").innerText);
    });

    // Mostrar el total dolarizado global en el elemento con el ID "total-dolarizado-global"
    document.getElementById("total-dolarizado-global").innerText = totalDolarizado.toFixed();
}

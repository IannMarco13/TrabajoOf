function Guardar() {
    var filas = document.querySelectorAll("tr[data-monedas]");
    filas.forEach(function(fila) {
        calcularDolarizado(fila);
    });
}

function GuardarActa(){
    Guardar();
    document.getElementById("FormularioActaEntrega").submit(); 
}

function calcularDolarizado(fila) {
    var moneda = fila.querySelector("td.moneda").innerText.trim();
    var totalEnviado = parseFloat(fila.querySelector("input.TotalEnviado").value) || 0;
    var tipoCambioVenta = parseFloat(fila.querySelector("td.tipo-cambio-venta").innerText);
    var tipoCambioCompra = parseFloat(fila.querySelector("td.tipo-cambio-compra").innerText);

    var resultadoOp = totalEnviado * tipoCambioVenta;
    var totalDolarizado = moneda === 'DÓLAR ESTADOUNIDENSE' ? totalEnviado : resultadoOp / tipoCambioCompra;
    fila.querySelector("td.resultado-op").innerText = resultadoOp.toFixed(2);
    fila.querySelector("td.total").innerText = moneda === '' ? totalDolarizado.toFixed(0) : totalDolarizado.toFixed(2);

    var index = Array.from(document.querySelectorAll("tr[data-monedas]")).indexOf(fila);
    document.querySelectorAll("input[name='moneda[]']")[index].value = moneda.trim();
    document.querySelectorAll("input[name='totalEnviado[]']")[index].value = totalEnviado.toFixed();
    document.querySelectorAll("input[name='resultadoOp[]']")[index].value = resultadoOp.toFixed(2);
    document.querySelectorAll("input[name='total[]']")[index].value = totalDolarizado.toFixed(2);

    actualizarTotalDolarizado();
}

function actualizarTotalDolarizado() {
    var totalDolarizado = 0;
    var filas = document.querySelectorAll("tr[data-monedas]");
    filas.forEach(function (fila) {
        totalDolarizado += parseFloat(fila.querySelector("td.total").innerText);
    });
    document.getElementById("total-dolarizado").innerText = totalDolarizado.toFixed(2);
    //console.log(totalDolarizado)
    document.querySelector("input[name='totalGloval[]']").value = totalDolarizado.toFixed(2);
}

function Reset() {
    window.location.href = '/RemesasT/view/ActaEntrega.php';
}
function Consulta() {
    window.location.href = '/RemesasT/view/ConsultaActaEntrega.php';
}
function Imprimir() {
    window.location.href = '/RemesasT/ReportesPDF/ActaEntregaPDF.php';
}

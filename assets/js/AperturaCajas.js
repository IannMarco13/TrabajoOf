function calcularApertura() {
    var filas = document.querySelectorAll("tr[Data-Monedas]");
    filas.forEach(function(fila) {
        calculaApertura(fila);
    });
}

function guardarApertura() {
    calcularApertura();
    document.getElementById("aperturaCajaForm").submit(); // Cambié el ID del formulario a "aperturaCajaForm"
}

function calculaApertura(fila){
    var corte     = parseFloat(fila.querySelector("td.Corte").innerText);
    var fajo      = parseFloat(fila.querySelector("input.Fajo").value) || 0;
    var unidad    = parseFloat(fila.querySelector("input.Unidad").value) || 0;
    var TotalFajo = (fajo*100);
    var total     = corte * (TotalFajo + unidad);

    fila.querySelector("td.Total").innerText   = total.toFixed(2);
    fila.querySelector("td.Total").style.color = "green";

    var index = Array.from(document.querySelectorAll("tr[Data-Monedas]")).indexOf(fila);

    document.querySelectorAll("input[name='Corte[]']")[index].value  = corte;
    document.querySelectorAll("input[name='Fajo[]']")[index].value   = fajo;
    document.querySelectorAll("input[name='Unidad[]']")[index].value = unidad;
    document.querySelectorAll("input[name='Total[]']")[index].value  = total.toFixed(2);

    actualizarTotal();
}

function actualizarTotal() {
    var total = 0;
    var filas = document.querySelectorAll("tr[Data-Monedas]");
    filas.forEach(function(fila) {
        total += parseFloat(fila.querySelector("td.Total").innerText);
    });

    document.getElementById("totalOP").innerText = "El total es: " + total.toFixed(2);
    document.getElementById("totalOP").style.color = "magenta";
    document.querySelector("input[name='totalOP[]']").value = total.toFixed(2);
}

function redirigir() {
    console.log("Función redirigir llamada");
    var seleccion = document.getElementById("Moneda");
    var valorSeleccionado = seleccion.options[seleccion.selectedIndex].value;
    switch (valorSeleccionado) {
        case "1":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaBOB.php";
            break;
        case "2":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaUSD.php";
            break;
        case "3":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaCLP.php";
            break;
        case "4":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaBLR.php";
            break;
        case "5":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaEUR.php";
            break;
        case "6":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaARS.php";
            break;
        case "7":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaAUD.php";
            break;
        case "8":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaCAD.php";
            break;
        case "9":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaPEN.php";
            break;
        case "10":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaGBP.php";
            break;
        case "11":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaCHF.php";
            break;
        case "12":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaNZD.php";
            break;
        case "13":
            window.location.href = "/RemesasT/view/AperturaCajas/AperturaCajaPYG.php";
            break;
    }
}

function Recet1() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaBOB.php';
}

function Recet2() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaUSD.php';
}

function Recet3() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaCLP.php';
}
function Recet4() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaBLR.php';
}
function Recet5() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaEUR.php';
}
function Recet6() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaARS.php';
}
function Recet7() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaAUD.php';
}
function Recet8() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaCAD.php';
}
function Recet9() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaPEN.php';
}
function Recet10() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaGBP.php';
}
function Recet11() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaCHF.php';
}
function Recet12() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaNZD.php';
}
function Recet13() {
    window.location.href = '/RemesasT/view/AperturaCajas/AperturaCajaPYG.php';
}
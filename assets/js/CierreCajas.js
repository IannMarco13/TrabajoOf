function calcularCierre() {

    var filas = document.querySelectorAll("tr[Data-Monedas]");
    filas.forEach(function(fila) {
        calculaCierre(fila);
    });
}

function guardarCierre() {
    calcularCierre();
    document.getElementById("cierreCajaForm").submit();
}

function calculaCierre(fila){

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
    document.getElementById("totalOP").style.color = "red";
    document.querySelector("input[name='totalOP[]']").value = total.toFixed(2);
}

function redirigir() {
    console.log("Función redirigir llamada")
    var seleccion = document.getElementById("Moneda");
    var valorSeleccionado = seleccion.options[seleccion.selectedIndex].value;
    switch (valorSeleccionado) {
        case "1":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaBOB.php";
            break; 
        case "2":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaUSD.php";
            break;
        case "3":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaCLP.php";
            break;
        case "4":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaBLR.php";
            break;
        case "5":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaEUR.php";
            break;
        case "6":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaARS.php";
            break;
        case "7":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaAUD.php";
            break;
        case "8":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaCAD.php";
            break;
        case "9":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaPEN.php";
            break;
        case "10":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaGBP.php";
            break;
        case "11":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaCHF.php";
            break;
        case "12":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaNZD.php";
            break;
        case "13":
            window.location.href = "/RemesasT/view/CierreCajas/CierreCajaPYG.php";
            break;
    }
}

function Recet1() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaBOB.php';
}

function Recet2() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaUSD.php';
}

function Recet3() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaCLP.php';
}
function Recet4() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaBLR.php';
}
function Recet5() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaEUR.php';
}
function Recet6() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaARS.php';
}
function Recet7() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaAUD.php';
}
function Recet8() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaCAD.php';
}
function Recet9() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaPEN.php';
}
function Recet10() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaGBP.php';
}
function Recet11() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaCHF.php';
}
function Recet12() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaNZD.php';
}
function Recet13() {
    window.location.href = '/RemesasT/view/CierreCajas/CierreCajaPYG.php';
}

function CompararCajero() {
    var codigoCajero = $('input.Cajero').val();

    // Verifica el código del cajero haciendo una solicitud al servidor
    $.post("/Remesast/controllers/CierreCajasController.php", { codigoCajero: codigoCajero }, function(response) {
        if (response.error) {
            alert(response.error); // Muestra un mensaje de error si el cajero no existe
        } else {
            // Envía el formulario si el cajero existe
            $('#cierreCajaForm').submit();
        }
    }, "json");
}


<?php
session_start();
include('../dist/includes/dbcon.php');
// Crear conexión
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar conexión
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

$mensaje = "";
$variedad_seleccionada = isset($_SESSION['variedad_seleccionada']) ? $_SESSION['variedad_seleccionada'] : ""; // Variable para almacenar la variedad seleccionada

// Procesar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $variedad_seleccionada = $_POST['variedad']; // Capturar la variedad seleccionada
    $_SESSION['variedad_seleccionada'] = $variedad_seleccionada;

   
    // Obtener la fecha y hora actual
    $fecha = date('Y-m-d'); // Solo la fecha
    $hora = date('H:i:s'); // Solo la hora

    // Insertar datos en la base de datos
    $sql = "INSERT INTO rendibancos (codigo, variedad, fecha, hora) VALUES ('$codigo', '$variedad_seleccionada', '$fecha', '$hora')";

    if ($con->query($sql) === TRUE) {
        $mensaje = "Lectura Registrada.";
        // Redirigir a la misma página para evitar el reenvío del formulario
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $con->error;
    }
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Flores</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function actualizarReloj() {
            const fechaHoraDiv = document.getElementById('fecha-hora');
            const ahora = new Date();
            const opcionesFecha = { year: 'numeric', month: '2-digit', day: '2-digit' };
            const opcionesHora = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            const fecha = ahora.toLocaleDateString('es-ES', opcionesFecha);
            const hora = ahora.toLocaleTimeString('es-ES', opcionesHora);
            fechaHoraDiv.textContent = "Fecha: " + fecha + " | Hora: " + hora;
        }

        // Actualizar el reloj cada segundo
        setInterval(actualizarReloj, 1000);

        // Función para mantener el foco en el campo de código
        function mantenerFoco() {
            document.getElementById('codigo').focus();
        }

        // Mantener el foco después de enviar el formulario
        window.onload = function() {
            mantenerFoco();
        };

        // Función para ocultar el mensaje después de un segundo
        function ocultarMensaje() {
            const mensajeDiv = document.getElementById('mensaje');
            if (mensajeDiv) {
                setTimeout(() => {
                    mensajeDiv.style.display = 'none';
                }, 1000); // Ocultar después de 1000 ms (1 segundo)
            }
        }
    </script>
</head>
<body>
    <h1>Rendimientos Bancos</h1>

    <!-- Mostrar la fecha y hora actual -->
    <div class="fecha-hora" id="fecha-hora">
        Fecha y Hora: <?php echo date('Y-m-d H:i:s'); ?>
    </div>

    <form action="" method="post">
        <label for="codigo">Código de Barras:</label>
        <input type="text" id="codigo" name="codigo" autofocus required>
        
        <input type="hidden" id="fecha_hora" name="fecha_hora" value="<?php echo date('Y-m-d H:i:s'); ?>">

        <label for="variedad">Variedad de Flor:</label>
        <select id="variedad" name="variedad" required>
            <option value="CRBL-Chewbacca-CR1502" <?php if ($variedad_seleccionada == "CRBL-Chewbacca-CR1502") echo 'selected'; ?>>CRBL-Chewbacca-CR1502</option>
            <option value="CRBZ-Copper-CR1105" <?php if ($variedad_seleccionada == "CRBZ-Copper-CR1105") echo 'selected'; ?>>CRBZ-Copper-CR1105</option>
            <option value="CRBZ-Fantail-CR1112" <?php if ($variedad_seleccionada == "CRBZ-Fantail-CR1112") echo 'selected'; ?>>CRBZ-Fantail-CR1112</option>
            <option value="CRBZ-Tusca-CR1115" <?php if ($variedad_seleccionada == "CRBZ-Tusca-CR1115") echo 'selected'; ?>>CRBZ-Tusca-CR1115</option>
            <option value="CRCR-Philadelphia-CR1001" <?php if ($variedad_seleccionada == "CRCR-Philadelphia-CR1001") echo 'selected'; ?>>CRCR-Philadelphia-CR1001</option>
            <option value="CRGR-Fuzzball-CR1403" <?php if ($variedad_seleccionada == "CRGR-Fuzzball-CR1403") echo 'selected'; ?>>CRGR-Fuzzball-CR1403</option>
            <option value="CRLB-77044-CR1501" <?php if ($variedad_seleccionada == "CRLB-77044-CR1501") echo 'selected'; ?>>CRLB-77044-CR1501</option>
            <option value="CRLV-Abriana-CR0722" <?php if ($variedad_seleccionada == "CRLV-Abriana-CR0722") echo 'selected'; ?>>CRLV-Abriana-CR0722</option>
            <option value="CRLV-Iza-CR0712" <?php if ($variedad_seleccionada == "CRLV-Iza-CR0712") echo 'selected'; ?>>CRLV-Iza-CR0712</option>
            <option value="CRLV-Pink Creation-CR0719" <?php if ($variedad_seleccionada == "CRLV-Pink Creation-CR0719") echo 'selected'; ?>>CRLV-Pink Creation-CR0719</option>
            <option value="CRLV-Primavera-CR0718" <?php if ($variedad_seleccionada == "CRLV-Primavera-CR0718") echo 'selected'; ?>>CRLV-Primavera-CR0718</option>
            <option value="CRLV-Rossano-CR0704" <?php if ($variedad_seleccionada == "CRLV-Rossano-CR0704") echo 'selected'; ?>>CRLV-Rossano-CR0704</option>
            <option value="CRPC-Linette-CR0901" <?php if ($variedad_seleccionada == "CRPC-Linette-CR0901") echo 'selected'; ?>>CRPC-Linette-CR0901</option>
            <option value="CRPK-Candyfloss-CR0402" <?php if ($variedad_seleccionada == "CRPK-Candyfloss-CR0402") echo 'selected'; ?>>CRPK-Candyfloss-CR0402</option>
            <option value="CRPU-Lamira-CR0612" <?php if ($variedad_seleccionada == "CRPU-Lamira-CR0612") echo 'selected'; ?>>CRPU-Lamira-CR0612</option>
            <option value="CRPU-Lotso-CR0614" <?php if ($variedad_seleccionada == "CRPU-Lotso-CR0614") echo 'selected'; ?>>CRPU-Lotso-CR0614</option>
            <option value="CRRD-Rojo-CR0110" <?php if ($variedad_seleccionada == "CRRD-Rojo-CR0110") echo 'selected'; ?>>CRRD-Rojo-CR0110</option>
            <option value="CRRD-Rosseta-CR0108" <?php if ($variedad_seleccionada == "CRRD-Rosseta-CR0108") echo 'selected'; ?>>CRRD-Rosseta-CR0108</option>
            <option value="CRWH-9551°-CR0226" <?php if ($variedad_seleccionada == "CRWH-9551°-CR0226") echo 'selected'; ?>>CRWH-9551°-CR0226</option>
            <option value="CRWH-Arctic Queen-CR0212" <?php if ($variedad_seleccionada == "CRWH-Arctic Queen-CR0212") echo 'selected'; ?>>CRWH-Arctic Queen-CR0212</option>
            <option value="CRWH-Gala White-CR0224" <?php if ($variedad_seleccionada == "CRWH-Gala White-CR0224") echo 'selected'; ?>>CRWH-Gala White-CR0224</option>
            <option value="CRWH-Pura-CR0223" <?php if ($variedad_seleccionada == "CRWH-Pura-CR0223") echo 'selected'; ?>>CRWH-Pura-CR0223</option>
            <option value="CRWH-Tutu°-CR0227" <?php if ($variedad_seleccionada == "CRWH-Tutu°-CR0227") echo 'selected'; ?>>CRWH-Tutu°-CR0227</option>
            <option value="CRYW-Cadiz-CR0323" <?php if ($variedad_seleccionada == "CRYW-Cadiz-CR0323") echo 'selected'; ?>>CRYW - Cadiz-CR0323</option>
            <option value="CRYW-TR436°-CR0324" <?php if ($variedad_seleccionada == "CRYW-TR436°-CR0324") echo 'selected'; ?>>CRYW - TR436°-CR0324</option>
            <option value="CRYW-Astroid-CR0312" <?php if ($variedad_seleccionada == "CRYW-Astroid-CR0312") echo 'selected'; ?>>CRYW-Astroid-CR0312</option>
            <option value="CRYW-Milagro-CR0320" <?php if ($variedad_seleccionada == "CRYW-Milagro-CR0320") echo 'selected'; ?>>CRYW-Milagro-CR0320</option>
            <option value="MWBD -Chivas Dark-MW1602" <?php if ($variedad_seleccionada == "MWBD -Chivas Dark-MW1602") echo 'selected'; ?>>MWBD-Chivas Dark-MW1602</option>
            <option value="MWGR-Alemani-MW1402" <?php if ($variedad_seleccionada == "MWGR-Alemani-MW1402") echo 'selected'; ?>>MWGR-Alemani-MW1402</option>
            <option value="MWLV-11506°-MW0705" <?php if ($variedad_seleccionada == "MWLV-11506°-MW0705") echo 'selected'; ?>>MWLV-11506°-MW0705</option>
            <option value="MWLV-How Sweet-MW0703" <?php if ($variedad_seleccionada == "MWLV-How Sweet-MW0703") echo 'selected'; ?>>MWLV-How Sweet-MW0703</option>
            <option value="MWLV-Jewelia-MW0706" <?php if ($variedad_seleccionada == "MWLV-Jewelia-MW0706") echo 'selected'; ?>>MWLV-Jewelia-MW0706</option>
            <option value="MWOR-Chivas-MW0801" <?php if ($variedad_seleccionada == "MWOR-Chivas-MW0801") echo 'selected'; ?>>MWOR-Chivas-MW0801</option>
            <option value="MWPK-Softball-MW0401" <?php if ($variedad_seleccionada == "MWPK-Softball-MW0401") echo 'selected'; ?>>MWPK-Softball-MW0401</option>
            <option value="MWPU-Lychee-MW0603" <?php if ($variedad_seleccionada == "MWPU-Lychee-MW0603") echo 'selected'; ?>>MWPU-Lychee-MW0603</option>
            <option value="MWRD-Testarrosa-MW0101" <?php if ($variedad_seleccionada == "MWRD-Testarrosa-MW0101") echo 'selected'; ?>>MWRD-Testarrosa-MW0101</option>
            <option value="MWWH-CDB020°-MW0203" <?php if ($variedad_seleccionada == "MWWH-CDB020°-MW0203") echo 'selected'; ?>>MWWH-CDB020°-MW0203</option>
            <option value="MWWH-Superbowl-MW0204" <?php if ($variedad_seleccionada == "MWWH-Superbowl-MW0204") echo 'selected'; ?>>MWWH-Superbowl-MW0204</option>
            <option value="MWYW-Paladov Sunny-MW0301" <?php if ($variedad_seleccionada == "MWYW-Paladov Sunny-MW0301") echo 'selected'; ?>>MWYW-Paladov Sunny-MW0301</option>
            <option value="MWYW-Yolk°-MW0303" <?php if ($variedad_seleccionada == "MWYW-Yolk°-MW0303") echo 'selected'; ?>>MWYW-Yolk°-MW0303</option>
            <option value="SLYW-Solidago-SL0301" <?php if ($variedad_seleccionada == "SLYW-Solidago-SL0301") echo 'selected'; ?>>SLYW-Solidago-SL0301</option>
        </select>
        <input type="submit" value="Registrar">
    </form>

    <?php if ($mensaje) { ?>
        <div class="mensaje" id="mensaje"><?php echo $mensaje; ?></div>
        <script>
            // Ocultar el mensaje después de un segundo
            setTimeout(() => {
                document.getElementById('mensaje').style.display = 'none';
            }, 1000);
        </script>
    <?php } ?>

    <!-- Tabla de Entradas -->
    

    <!-- Gráfico de Códigos por Hora -->
   
    
</body>
</html>
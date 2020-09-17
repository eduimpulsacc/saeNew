<?php
/*
Cliente de prueba para el servicio web getCalificaciones que ofrece Edugestor.
*/
require_once "lib/nusoap.php";

$base = "http://200.6.99.36/ws/";


if (!empty($_GET)) {

    $client = new nusoap_client($base . "api/applications.php");

    $error = $client->getError();
    if ($error) {
        $mensaje =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
    }

    $result = $client->call("getCalificaciones", array(
        "cod_aplicacion" => $_GET["cod"]
    ));

    if ($client->fault) {
        $mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            $mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
        }
        else {
            $mostrar = 1;
			if (file_put_contents ('./data2.xml', $result) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}

        }
    }

}
?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Cliente SOAP - GetCalificaciones</title>
    </head>
    <body>
<?php
if ($mostrar) {
?>
    <div id="estudiantes">
        RUT Estudiante - Calificación <br/>
        <?php
            foreach ($result as $estudiante) {
                echo $estudiante['rut'] . " - " . $estudiante['nota'] . "<br/>";
            }
        ?>
    </div>
    <p><?php echo '<a href="clienteS1.php">Regresar</a>';?></p>

<?php
} elseif (!empty($_POST)) {
    echo $mensaje;
}
?>
    </body>
</html>

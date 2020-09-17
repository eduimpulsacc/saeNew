<?
include('../../../../../../util/header.inc');  
include('../controlador/ramo.php');


// recibe las variables del formulario
$sub_obli   = $_POST['sub_obli'];
$bool_ip    = $_POST['bool_ip'];
$bool_sar   = $_POST['bool_sar'];
$bool_artis = $_POST['bool_artis'];
$modo_eval  = $_POST['modo_eval'];

$truncado  = $_POST['truncado'];
$tipo_aproximacion  = $_POST['tipo_aproximacion'];

$rut_docente   = $_POST['rut_docente'];
$rut_ayudante  = $_POST['rut_ayudante'];
$elim_ayu      = $_POST['elim_ayu'];
$con_examen    = $_POST['con_examen'];
$prueba_nivel  = $_POST['prueba_nivel'];

$porc_examen  = $_POST['porc_examen'];



// envío datos al controlador

$valor = actualizar_ramo(array(	'sub_obli' => $sub_obli,
									'bool_ip' => $bool_ip,
									'bool_sar' => $bool_sar,
									'bool_artis' => $bool_artis,
									'modo_eval' => $modo_eval,
									'truncado' => $truncado,
									'tipo_aproximacion' => $tipo_aproximacion,
									'rut_docente' => $rut_docente,
									'rut_ayudante' => $rut_ayudante,
									'elim_ayu' => $elim_ayu,
									'con_examen' => $con_examen,
									'prueba_nivel' => $prueba_nivel,	
									'porc_examen' => $porc_examen,	
									
									), $_RAMO, $conn);    
									
if ($valor!="0"){
    echo "<script>alert('Atención, la información no ha sido actualizada.');</script>";
}

echo "<script>window.location='ramo.php'</script>";
							
?>

<?
require('../../util/header.inc');

$ano			=$_ANO;
$profesor		=$_USUARIO;
$empleado = trim($_EMPLEADO);
if($empleado=="")$empleado=0;

if ($sw==0){
	$sqlInsert = "insert into sugerencias (id_ano, rut_publi, fecha_publi, titulo, detalle) values ($ano, '$empleado', '".fEs2En(date("d/m/Y"))."', '$titulo', '".nl2br($detalle)."')";
	$rsInsert = @pg_Exec($conn,$sqlInsert);
	if (!$rsInsert) {
	     echo "ERROR EN: $sqlInsert"; exit;
	}	 	
}


if ($sw==1){
	$sqlUpdate = "update sugerencias set rut_publi = '$empleado', fecha_publi = '".fEs2En(date("d/m/Y"))."', titulo = '$titulo', detalle = '".nl2br($detalle)."' where id = $id_diario";

	$rsUpdate = @pg_Exec($conn,$sqlUpdate);
	if (!$rsUpdate) { 
	    echo "ERROR EN: $sqlUpdate"; exit;
	}	 
}



if ($sw==3){
 	$sqlDelete = "delete from sugerencias where id = $id_diario";
	$rsDelete = @pg_Exec($conn,$sqlDelete);
	if (!$rsDelete) { echo "ERROR EN AL BORRAR NOTICIA"; exit;}	
}

$_SESSION['FRMMODO'] = "mostrar";

echo "<script>window.location = 'sugrec.php'</script>";	

?>
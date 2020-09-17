<?
require('../../util/header.inc');

$ano			=$_ANO;
$profesor		=$_USUARIO;

// tomamos el nombre de la foto
$tiempo = time();
$imagen1 = $_FILES['file']['name'];
$archivo = $_FILES['file']['tmp_name'];

if($_FILES['file']['size'] > 3000000){
	echo "<script>alert('archivo supero el tamaño permitido')</script>";
	echo "<script>window.location='IngresaDiario.php'</script>";
	exit;
}
if ($_FILES['file']['size']!= 0){   
   $imagen1 = "$tiempo";
}

if(pg_dbname($conn)=="Antofagasta" || pg_dbname($conn)=="coi_final"){
	$fecha = date("m/d/Y");
}else{
	$fecha = date("d/m/Y");
}

if ($sw==0){
	$sqlInsert = "insert into diario_mural (id_ano, rut_publi, fecha_publi, titulo, detalle,  nom_foto) values ($ano, '$profesor', CURRENT_DATE, '$titulo', '".nl2br($detalle)."', '$imagen1')";
	$rsInsert = @pg_Exec($conn,$sqlInsert);
	if (!$rsInsert) {
	     echo "ERROR EN: $sqlInsert"; exit;
	}else{
	    if ($_FILES['file']['size'] != 0){
	       if (!copy($archivo,"images/".$imagen1)) {
              echo "No se puede subir la foto 10";
			  exit();
           }
	    }
	
	}	 	
}


if ($sw==1){
	$sqlUpdate = "update diario_mural set rut_publi = '$profesor', fecha_publi = '".fEs2En(date("d/m/Y"))."', titulo = '$titulo', detalle = '".nl2br($detalle)."', nom_foto = '$imagen1' where id_diario = $id_diario";
	$rsUpdate = @pg_Exec($conn,$sqlUpdate);
	if (!$rsUpdate) { 
	    echo "ERROR EN: $sqlUpdate"; exit;
	}else{
	     if ($_FILES['file']['size'] != 0){
	       if (!copy($archivo,"images/".$imagen1)) {
              echo "No se puede subir la foto 11";
			  exit();
           }
	    }
	}	 
}



if ($sw==3){
	$sqlDelete = "delete from diario_mural where id_diario = $id_diario";
	$rsDelete = @pg_Exec($conn,$sqlDelete);
	if (!$rsDelete) { echo "ERROR EN AL BORRAR NOTICIA"; exit;}	
}

$_SESSION['FRMMODO'] = "mostrar";

echo "<script>window.location = 'ListadoNoticias.php'</script>";	

?>
<?php
require('../../../../util/header.inc');
$institucion	=$_INSTIT;
$frmModo		=$_FRMMODO;
$ano			=$_ANO;

$pais = isset( $_GET["cmbFIRMA"] ) ? intval( $_GET["cmbFIRMA"] ) : 0 ;
$posicion = $_GET['posicion'];

$sql = "select b.rut_emp,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || b.ape_mat as nombre from trabaja a INNER JOIN empleado b ON a.rut_emp=b.rut_emp where a.rdb=".$institucion." AND a.cargo=".$cmbFIRMA;
$rs_empleado = @pg_exec($conn,$sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Archivo Hijo</title>
</head>
<body>
<!--Es importante saber, que todo lo que este en este div será lo que ira al document padre segurn el ejemplo.-->
<div id="divContenido" name="divContenido">
<? if($cmbFIRMA==5){
		echo "Profesor Jefe de cada curso";
	}else{?>
		<select name="persona1<?=$posicion;?>" id="persona1<?=$posicion;?>"  onchange="alert( 'Código de Campo: ' + this.name )">
			<?php for($i=0;$i<@pg_numrows($rs_empleado);$i++){
					$fila=@pg_fetch_array($rs_empleado,$i); ?>
				<option value="<?php echo $fila['rut_emp'];?>"><?php echo $fila['nombre']."---".$posicion;?></option>
			<?php } ?>
		</select>
	<? } ?>
</div>
<?php 
#Este file se encargara de procesar el div de arriba y mostrarlo en el destino
require_once "_process.php"; 
?>
</body>
</html>
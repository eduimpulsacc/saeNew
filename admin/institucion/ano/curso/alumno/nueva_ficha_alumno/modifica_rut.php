	<?php
session_start();
include_once('mod_ficha_alumno.php');
//print_r($_GET);
$ob_alumno = new FichaAlumno($conn);

if(isset($_POST['rut'])){
	

	
$rut=$_GET['rut'];	
$cu=$_POST['cu'];	
$rr=$_POST['rr'];

$rut_sinpuntos=str_replace('.','',$_POST['rut']);
/*$rut_nuevo =  substr($rut_sinpuntos,0,-2);
$dig_nuevo = substr($rut_sinpuntos,9,1);*/
$rut_nuevo = substr($rut_sinpuntos,0,-1);// substr($rut_sinpuntos, 0, -2); 
$dig_nuevo = substr($rut_sinpuntos, -1);    // devuelve "f";//substr($rut_sinpuntos,-1);
  "digito nuevo-->".$dig_nuevo;
   "rut nuevo-->".$rut_nuevo;
  "rut antes-->".$rut_antes;
  "dig antes-->".$dig_antes;

$rs_alumno=$ob_alumno->datos_alumno($rut_nuevo);
$rut_alumno = pg_result($rs_alumno,0);

if($rut_alumno!=""){
	echo "<script>
	alert('El rut existe');
	</script>";
	}else{
		
$rs_update = $ob_alumno->update_rut($rut_antes,$dig_antes,$rut_nuevo,$dig_nuevo);		
		//echo $rs_update;
	if($rs_update==1){
		echo "<script>
	alert('Datos Modificados');
	</script>";
		}else{
		
		echo "<script>
	alert('Error al Modificar');
	</script>";			
	}	
		
	}
	
	?>
    <script language="JavaScript" type="text/JavaScript">
		//cargaTabs();
		opener.self.location='ficha_alumno.php?alumno=<?=$rut_nuevo ?>&r=<?php echo $rr ?>&crs=<?php echo $cu ?>';
		window.close();
	</script>
    <?php

}else{
	
$rut = base64_decode($ract);	
$dig_rut=$dact;
}





//$rs_dig = $ob_alumno->datos_alumno($rut);
//$dig_rut=pg_result($rs_dig,1);
?>

<!DOCTYPE html>
<html>
<head>
<title>Modifica Rut</title>
<script type="text/javascript" src="valida_rut.js"></script>

</head>

<body>
<form name="form1"  method="post" action="modifica_rut.php">
<input type="hidden" name="cu" value="<?php echo $cu ?>">
<input type="hidden" name="rr" value="<?php echo $rr ?>">
<table width="%" align="center">
<tr>
<td style="height:50">&nbsp;</td>
</tr>
<tr align="left">
<td>Rut Actual: <? if (isset($validado) and $validado==1){
			echo $rut;
	}else{ 
	echo $rut."-".$dig_rut;
	}
	?>
    
    </td>
</tr>
<tr>
<td style="height:10">&nbsp;</td>
</tr>
<tr align="left">
<td>
Nuevo Rut:&nbsp;<input type="text" name="rut" id="rut"  size="9" maxlength="10">(sin guion)
</td>
</tr>
<tr><td style="height:30">&nbsp;</td></tr>
<tr align="center">
<td ><input type="submit" value="Modificar rut" />
<input type="button" value="Cerrar" onClick="javascript:window.close();"/></td>
<input type="hidden" name="validado" id="validado" value="1">
<input type="hidden" name="rut antes" id="rut antes" value="<?=$rut;?>">
<input type="hidden" name="dig_antes" id="dig_antes" value="<?=$dig_rut;?>">

</tr>
</table>
<br>
</form>
<? pg_close($conn); ?>
</body>

</html>
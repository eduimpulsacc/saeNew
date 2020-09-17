<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$periodo 	= $_POST['cmbPERIODO'];
$ano		= $_POST['cmbANO'];

print_r($_POST);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

if(isset($cmbINS)){
	
$fila_instit= $ob_reporte->Membrete($cmbINS);
$fila_direc	= $ob_reporte->Director($cmbINS);
	
	}else{

$fila_instit= $ob_reporte->Membrete($_INSTIT);
$fila_direc	= $ob_reporte->Director($_INSTIT);
	}
$rs_evaluadores = $ob_reporte->Evaluadores($ano,$periodo);

//print_r($_POST);

?>
<script> 
function cerrar(){ 
window.close() 
} 

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link href="../../../css/estilos.css" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTE</title>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="IMPRIMIR"  onClick="imprimir();"/></td>
  </tr>
</table>
</div>
<table width="650" border="0" align="center">
 <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>LISTADO DE RELACION DE EVALUACIONES</u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td> <? for($i=0;$i<pg_numrows($rs_evaluadores);$i++){
			  	$fila = pg_fetch_array($rs_evaluadores,$i);
			?>
          <table width="100%" border="0" style="border-collapse:collapse">
          <tr>
            <td class="textonegrita">RUT&nbsp;:</td>
            <td class="textosimple"><?=$fila['rut_evaluador']."-".$fila['dig_rut'];?></td>
          </tr>
         
          <tr>
            <td class="textonegrita">CARGO&nbsp;:</td>
            <td class="textosimple"><?=$fila['cargo'];?></td>
          </tr>
          <tr>
            <td class="textonegrita">NOMBRE&nbsp;:</td>
            <td class="textosimple"><?=$fila['nombres'];?></td>
          </tr>
          <tr><td colspan="3">
          <table width="100%" border="0">
              <tr class="tabla01">
                <td>&nbsp;RUT</td>
                <td>&nbsp;CARGO</td>
                <td>&nbsp;NOMBRE</td>
                <TD>&nbsp;ESTADO</TD>
                <td>&nbsp;FECHA</td>
              </tr>
              <? $result = $ob_reporte->Relacion_Evaluacion($fila['rut_evaluador'],$ano,$periodo);
			  	for($x=0;$x<pg_numrows($result);$x++){
					$fila_eva = pg_fetch_array($result,$x);
				?>
              <tr>
                <td class="textosesion">&nbsp;<?=$fila_eva['rut_evaluado']."-".$fila_eva['dig_rut'];?></td>
                <td class="textosesion">&nbsp;<?=$fila_eva['cargo'];?></td>
                <td class="textosesion">&nbsp;<?=$fila_eva['nombre_evaluador'];?></td>
                <td class="textosesion">&nbsp;<?=$fila_eva['estado_evaluacion'];?></td>
                <td class="textosesion">&nbsp;<?=$fila_eva['fecha_evaluacion'];?></td>
              </tr>
              <? if($fila_eva['estado_evaluacion']=="No Evaluado"){
					$contador++;  
			  	}
			  } ?>
         </table>
         </td></tr>
         
        </table> <BR /><? } ?></td>
      </tr>
      <tr>
        <td>&nbsp;<? echo $cmbINS." ".$contador;?></td>
      </tr>
  </table></td>
  </tr>
  
</table>
</body>
</html>
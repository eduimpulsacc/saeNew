<?
require("../../../util/header.php");
require("../clases.php");

$ano = $cmbANO;
$docente = $cmbDOCENTE;
$institucion = $_INSTIT;
$periodo = $cmbPERIODO;


$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);
$fila_docente = $ob_reporte->Docente($conn,$docente);
$fila_ano = $ob_reporte->Ano($conn,$ano);
$rs_dicta = $ob_reporte->Dicta2($conn,$docente,$ano);

$rs_per = $ob_reporte->Periodo($conn,$ano,$periodo);
$fil_per = pg_fetch_array($rs_per,0);
$arr_prom = array();
$ar_prom_curso=array();

?>
<!doctype html>
<html>
<head>
<meta charset="latin1">
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<title>Documento sin título</title>
</head>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close() 
} 
</script>
<body>

<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="690" border="0" align="center">
  <tr>
    <td><?php include("../cabecera/cabecera.php"); ?><br><br>
<table width="100%" border="0">
  <tr>
    <td colspan="3" class="textonegrita" align="center">INFORMACI&Oacute;N PLANIFICACIONES CON OBSERVACIONES</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="11%" class="textonegrita">DOCENTE</td>
    <td width="2%" class="textonegrita">:</td>
    <td width="87%" class="textosimple" align="left"><? echo $fila_docente['ape_pat']." ".$fila_docente['ape_mat']." ".$fila_docente['nombre_emp'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">A&Ntilde;O</td>
    <td class="textonegrita">:</td>
    <td class="textosimple"><? echo $fila_ano['nro_ano'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">FECHA</td>
    <td class="textonegrita">:</td>
    <td class="textosimple"><? echo date("d-m-Y");?></td>
  </tr>
</table>
<br>
<br>
<table width="100%" border="0" cellpadding="5">
	<? for($i=0;$i<pg_numrows($rs_dicta);$i++){
			$fila_dicta = pg_fetch_array($rs_dicta,$i);
			
			
			
			?>
  <tr>
    <td width="18%" class="textonegrita">&nbsp;ASIGNATURA</td>
    <td width="2%" class="textonegrita">&nbsp;:</td>
    <td width="80%" class="textosimple">&nbsp;<? echo $fila_dicta['nombre']." ".$fila_dicta['cod_subsector'];?></td>
  </tr>
  <tr>
    <td colspan="3">
   <?php  
   $rs_curso = $ob_reporte->CursoDicta($conn,$ano,$docente,$fila_dicta['cod_subsector']);
   for($j=0;$j<pg_numrows($rs_curso);$j++){
   $fila_curso = pg_fetch_array($rs_curso,$j);	
				
	?>
    <table width="100%" border="0" class="tablaredonda">
   
  <tr class="cuadro01">
    <td>CURSO: <?=CursoPalabra($fila_curso['id_curso'], 1, $conn);?></td>
    </tr>
  <tr  >
    <td valign="top" class="textosimple">
   <?php $rs_unidad = $ob_reporte->traeUnidadRamoRocente($conn,$ano,$docente,$fila_curso['id_ramo']);
   if(pg_numrows($rs_unidad)>0){
   
   for($un=0;$un<pg_numrows( $rs_unidad);$un++){
	   $fila_unidad = pg_fetch_array($rs_unidad,$un);
	   
	   $rs_clases = $ob_reporte->traeClases($conn,$fila_unidad['id_unidad']);
	   ?>
    
    <table width="100%" border="0" class="tablaredonda">
      <tr class="cuadro01">
        <td width="19%">UNIDAD</td>
        <td width="81%"><?php echo $fila_unidad['nombre'] ?></td>
        </tr>
       <?php   
	  if(pg_numrows($rs_clases)>0){
	   for($cl=0;$cl<pg_numrows($rs_clases);$cl++){
		   $fila_clase = pg_fetch_array($rs_clases,$cl);
		    ?>
      <tr class="cuadro01">
        <td>CLASE</td>
        <td>OBSERVACIONES</td>
        </tr>
      <tr>
        <td valign="top" class="textosimple"> <?php echo $fila_clase['nombre'] ?><br>
	  <br>
	  Fecha Inicio<br>
	  <?php echo CambioFD($fila_clase['fecha_inicio']) ?></td>
        <td valign="top"><table width="100%" border="0">
        <tr class="cuadro01">
          <td width="17%">FECHA</td>
          <td width="83%">DESCRIPCI&Oacute;N</td>
        </tr>
        <?php 
		$clase = $fila_clase['id_clase'];
		$rs_obs = $ob_reporte->traeObsclase($conn,$clase);
		if(pg_numrows($rs_obs)>0){
		for($ob=0;$ob<pg_numrows($rs_obs);$ob++){
			if(($ob % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
			$fil_obs = pg_fetch_array($rs_obs,$ob);
		?>
        <tr class="textosimple <?php echo $clase ?>">
          <td align="center"><?php echo CambioFD($fil_obs['fecha']) ?></td>
          <td><?php echo $fil_obs['observacion'] ?></td>
        </tr>
        <?php }
		}else{
		?>
        <tr class="detalleoff">
          <td colspan="2">SIN OBSERVACIONES</td>
          
        </tr>
        <?php }?>
      </table></td>
        </tr>
     
      <tr>
        <td colspan="2" valign="top">&nbsp;</td>
        </tr>
        <?php }
   }else{echo ' <tr>
        <td valign="top" class="textosimple" colspan="2">SIN CLASES ASOCIADAS</td>
        
      </tr>';}
		?>
    </table><br>

    <?php }
   }else{
	   echo "SIN UNIDADES ASOCIADAS";
	   }
	?>
    </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
  </tr>
    </table>
    <br>

<?php }?>
</td>
  </tr>

  <? } 
  
  ?>

</table>


</td>
  </tr>
</table>
</body>
</html>

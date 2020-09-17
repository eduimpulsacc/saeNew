<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);



$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);



$rs_escala = $ob_reporte->escalaGeneral();

$rs_evaluados = ($cargo[0]!=0)?$ob_reporte->EvaluacionXCargo3($_INSTIT,$ano[0],$cargo[0],$periodo[0]):$ob_reporte->EvaluacionXAnoTodos($ano[0],$periodo[0]);


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
<style>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
</style>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="IMPRIMIR"  onClick="imprimir();"/></td>
  </tr>
</table>
</div><br />
 <table width="650" border="0" align="center">
  <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>RESUMEN EVALUADOS 
          <?="&nbsp;".$ano[1];?>   <?php  if($cmbCARGO>0){ echo strtoupper($cargo[1]); }?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td class="textosimple" align="justify">
              <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
          <tr class="tableindex">
            <td width="3%" align="center" class="textosimple">N&deg;</td>
          <?php  if($cmbCARGO==0){?>
            <td width="21%" align="justify" class="textosimple">Cargo</td>
            <?php }?>
            <td width="53%" align="justify" class="textosimple">Nombre</td>
            <td width="11%" align="center" class="textosimple">% Obtenido</td>
            <td width="12%" align="center" class="textosimple">Concepto</td>
          </tr>
          
         <?php 
		 $x=0;
		  for($e=0;$e<pg_numrows($rs_evaluados);$e++){
			 $fila_evaluado = pg_fetch_array($rs_evaluados,$e);
			  $x++;
			 $cuentares[$fila_evaluado['id_escala']][]=1; 
			 if($x>30){
				 $x=0;
				 ?>
                 </table>
                 <H1 class=SaltoDePagina></H1>
                 <table width="650" border="0" align="center">
  <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  </table>
<br />

                  <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
          <tr class="tableindex">
            <td width="3%" align="center" class="textosimple">N&deg;</td>
          <?php  if($cmbCARGO==0){?>
            <td width="21%" align="justify" class="textosimple">Cargo</td>
            <?php }?>
            <td width="53%" align="justify" class="textosimple">Nombre</td>
            <td width="11%" align="center" class="textosimple">% Obtenido</td>
            <td width="12%" align="center" class="textosimple">Concepto</td>
                 <?
				 }
			 ?>
          <tr>
            <td class="textosimple" align="justify"><?php echo $e+1 ?></td>
             <?php  if($cmbCARGO==0){
				
				 ?>
            <td class="textosimple" align="justify"><?php  $rsc = $ob_reporte->CargoEmpleadoUno($fila_evaluado['rut_emp'],$fila_evaluado['id_plantilla'],$ano[0],$periodo[0]);
			echo strtoupper(pg_result($rsc,0));
			 ?></td>
            <?php }?>
            <td class="textosimple" align="justify"><?php echo strtoupper($fila_evaluado['nombre']) ?></td>
            <td class="textosimple" align="center"><?php echo $fila_evaluado['valor_final'] ?></td>
            <td class="textosimple" align="center"><?php echo $fila_evaluado['evaluacion_final'] ?></td>
          </tr>
          <?php }?>
              </table>
             <br />
<br />

<table width="100%" border="0" cellpadding="0">
  <tr>
    <td width="50%"><table width="84%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="3" align="center">CUADRO RESUMEN</td>
    </tr>
  <tr class="tableindex">
    <td width="44%">Concepto</td>
    <td width="28%" align="center">Cantidad</td>
    <td width="28%" align="center">Porcentaje</td>
  </tr>
  <?php for($e=0;$e<pg_numrows($rs_escala);$e++){
	  $fila_escala = pg_fetch_array($rs_escala,$e);
	  ?>
  <tr class="textosimple">
    <td>&nbsp;<?php echo $fila_escala['concepto'] ?></td>
    <td align="center"> <?php echo  array_sum($cuentares[$fila_escala['id_escala']]); 
	$cueva = $cueva+array_sum($cuentares[$fila_escala['id_escala']]);
	?></td>
    <td align="center"><?php echo $cuepor = round((array_sum($cuentares[$fila_escala['id_escala']])*100)/pg_numrows($rs_evaluados),0) ;
	$totpor=$totpor+$cuepor;
	?>%</td>
  </tr>
  <?php }?>
  <tr class="tableindex">
    <td>Total establecimento</td>
    <td align="center"><?php echo $cueva ?></td>
    <td align="center"><?php echo $totpor ?></td>
  </tr>
</table></td>
    <td> <table width="100%" border="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><p>&nbsp;</p>
                  
                    <p>______________________________</p></td>
                </tr>
                <tr>
                  <td align="center" class="textonegrita"><?=$fila_direc['director'];?><br />
Director(a)</td>
                </tr>
        </table></td>
  </tr>
</table>

             
             </td>
          </tr>
        </table></td>
      </tr>
      
  </table></td>
  </tr>
  
</table>
<body>
</body>
</html>

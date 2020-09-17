<? 

require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');


$institucion			= $_INSTIT;
$ano			= $cmbAno;
$reporte		=$c_reporte;
$entrevistado	=$cmbEntrevistado;
$curso = 1;



$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
"</br>".$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];



	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_config->ano=$ano;
	$ob_config->rut_emp = $entrevistado;
	$rs_entrevista =  $ob_config->traeEntrevista($conn);
	
	$ob_config->Profesor($conn);
	
	/*******INSITUCION *******************/
	$ob_membrete = new Membrete();
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		$ob_reporte = new Reporte();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
			  <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr>
                <td width="114"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td width="361"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre_institucion?></font></div></td>
                <td width="161" rowspan="3" align="center" valign="top" >
				<?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../../".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ano_esc?></font></div></td>
  </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
  </tr>	
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="161" rowspan="5" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
		    </table><br />
<br />

<table width="650" border="0" align="center" cellspacing="0">
  <tr class="tableindex">
    <td align="center">ENTREVISTA DOCENTE</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellspacing="0">
  <tr>
    <td width="125" class="textonegrita">Entrevistado</td>
    <td width="3" align="center" class="textonegrita">:</td>
    <td width="521" class="textosimple"><?php echo $ob_config->profesor; ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  <tr class="textonegrita">
    <td colspan="3" align="center" class="textonegrita">LISTADO ENTREVISTAS</td>
  </tr>
 <?php  for($e=0;$e<pg_numrows($rs_entrevista);$e++){
	 $fila = pg_fetch_array($rs_entrevista,$i);
	 
	 $ob_config->rut_emp = $fila['entrevistador'];
	 $ob_config->Profesor($conn);	
	 
	 $ob_config->id_asunto = $fila['asunto'];
	 $rs_asunto = $ob_config->traeAsuntoDetalle($conn);
	 $asunto = pg_result($rs_asunto,1);
	 
	 ?>
  <tr>
    <td class="textonegrita">Fecha</td>
    <td width="3" align="center" class="textonegrita">:</td>
    <td class="textosimple"><?php echo CambioFD($fila['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Entrevistador</td>
    <td width="3" align="center" class="textonegrita">:</td>
    <td class="textosimple"><?php echo $ob_config->profesor; ?></td>
  </tr>
  <tr>
    <td class="textonegrita">Asunto</td>
    <td width="3" align="center" class="textonegrita">:</td>
    <td class="textosimple"><?php echo $asunto ?></td>
  </tr>
  <tr>
    <td valign="top" class="textonegrita">Observaciones</td>
    <td width="3" align="center" valign="top" class="textonegrita">:</td>
    <td valign="top" class="textosimple"><?php echo $fila['observaciones'] ?></td>
  </tr>
   <tr>
    <td colspan="3"><hr /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td width="3" class="textonegrita">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
 <?php }?>
</table>
<br />
  <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
</div>
</body>
</html>

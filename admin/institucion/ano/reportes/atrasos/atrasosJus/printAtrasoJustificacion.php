<? 

require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');


$institucion	= $_INSTIT;
$ano			= $cmb_ano;
$reporte		=$c_reporte;
$curso = $cmb_curso;



$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
$ano_esc = $fila_ano['nro_ano'];
$fecha_inicio = $fila_ano['fecha_inicio'];
$fecha_termino = $fila_ano['fecha_termino'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];



$ob_membrete = new Membrete();
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);


	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
		$ob_reporte->rdb=$institucion;
		$ob_reporte->item= $reporte;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->item= $fils_item['id_item'];
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
				
			
				}
				else{
				$crp = $aut;
				}
			
			$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}else{
		$crp=1;
		}
	
	
$ob_reporte->curso = $curso;
$ob_reporte->ano = $ano;
$ob_reporte->ProfeJefe($conn);
	$profe_jefe = $ob_reporte->profe_jefe;
if($cmb_alumno>0){
	$ob_reporte->alumno = $cmb_alumno;
	$rs_alu = $ob_reporte->TraeUnAlumno($conn);
}	
else{
	$ob_reporte->retirado = 0;
	$rs_alu = $ob_reporte->TraeTodosAlumnos($conn);
	
}	
		

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
<?php for($a=0;$a<pg_numrows($rs_alu);$a++){
	$fila_alumno=pg_fetch_array($rs_alu,$a);
	 $ob_reporte->CambiaDato($fila_alumno);
	?>
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
		   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
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
		    </table>
<br />
<table border="0" cellpadding="0" cellspacing="0" width="650" align="center">
<tr>
  <td colspan="3" class="tableindex"><div align="center">INFORME ATRASOS CON JUSTIFICACI&Oacute;N</div></td> 
<tr>
  <td colspan="3" >&nbsp;</td>
<tr>
  <td width="108" class="textonegrita">CURSO</td>
  <td width="12" align="center" class="textonegrita">:</td>
  <td width="530" class="textosimple">&nbsp;<?php echo CursoPalabra($curso,1,$conn); ?></td>
<tr>
  <td class="textonegrita">ALUMNO</td>
  <td align="center" class="textonegrita">:</td>
  <td class="textosimple">&nbsp;<?php echo strtoupper($ob_reporte->nombres); ?></td>
<tr>
<tr>
    <td class="textonegrita">PROFESOR JEFE</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<? echo $ob_reporte->profe_jefe?></td>
</tr>
  <td colspan="3" >&nbsp;</td>
</table>
<br />
<?php //busco atrasos
$ob_reporte->alumno = $fila_alumno['rut_alumno'];
$ob_reporte->tipo=2;
$ob_reporte->fecha_inicio = $fecha_inicio;
$ob_reporte->fecha_termino = $fecha_termino;
$rs_atraso = $ob_reporte->Anotaciones($conn);
?>
<br />
<?php if (@pg_numrows($rs_atraso)==0){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	   <tr>
		 <td align="center"><hr width="100%" color=#003b85>
	     <b>NO REGISTRA  ATRASOS</b></td>
	   </tr>
	 </table>
<?php }
else{
for($at=0;$at<@pg_numrows($rs_atraso);$at++){
	$fila_anota = @pg_fetch_array($rs_atraso,$e);
	$fecha = $fila_anota['fecha'];
	
	$ob_reporte->fecha=$fecha;
	$rs_justi = $ob_reporte->traeJustificaAtraso($conn);
	$fila_justi = pg_fetch_array($rs_justi,0);
	$js = (pg_numrows($rs_justi)>0)?"SI":"NO";
	$ad = ($fila_justi['adjuntadoc']>0)?"SI":"NO";
	
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156" class="textosimple"><strong>Fecha</strong></td>
    <td width="7" class="textosimple"><strong>:</strong></td>
    <td width="258" class="textosimple"><? impF($fecha);?></td>
    <td width="77" class="textosimple"><strong>Justificado</strong></td>
    <td width="9" class="textosimple"><strong>:</strong></td>
    <td width="143" class="textosimple">&nbsp;<?php echo $js ?></td>
  </tr>
  <?php if (pg_numrows($rs_justi)>0){
	 $observacion = $fila_justi['observacion'];
	   ?>
  <tr>
    <td class="textosimple"><strong>Justificaci&oacute;n</strong></td>
    <td class="textosimple"><strong>:</strong></td>
    <td colspan="4" class="textosimple"><? echo $observacion?></td>
    </tr>
  <tr>
    <td class="textosimple"><strong>Adjunta Documentos</strong></td>
    <td class="textosimple"><strong>:</strong></td>
    <td colspan="4" class="textosimple"><? echo $ad?></td>
  </tr>
    <?php  } ?>
</table><br />

<?php
}//fin for atrasos

 }?>
<!--<table width="650" border="0" align="center">
              <tr>
                <?  
			
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
	            <td width="25%" class="item" height="100"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? 		
				} ?>
                <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? } ?>
                <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? } ?>
                <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
                <td width="25%" class="item"><div align="center">________________________________ <br>
                        <?=$ob_reporte->nombre_emp;?>
                        <br>
                        <?=$ob_reporte->nombre_cargo;?>
                </div></td>
                <? }?>
              </tr>
            </table>-->
            		  <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 //$concur=0;
		 include("../../firmas/firmas.php");?>
    <?php   if(pg_numrows($rs_alu)>1){?>
<H1 class=SaltoDePagina>&nbsp;</H1>
      <?php }?>
      <?php } // fin alumnos?>
</div>
</body>
</html>

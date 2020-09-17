<? 

require('../../../../util/header.inc');

include('../../../clases/class_Reporte.php');


$institucion			= $_INSTIT;
"</br>".$ano			= $cmb_ano;
"</br>".$ciclo 			= $cmbCICLO;
"</br>".$periodo 		= $cmbPERIODO;
$reporte		=$c_reporte;


if($ciclo!=0){
$qry="SELECT * FROM ciclo_conf WHERE id_ano=".$ano." AND rdb=".$institucion." and id_ciclo=".$ciclo;
$result =@pg_Exec($conn,$qry);
}else{
$qry="SELECT * FROM ciclo_conf WHERE id_ano=".$ano." AND rdb=".$institucion;
$result =@pg_Exec($conn,$qry);
}

$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
"</br>".$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];

$qry_per="SELECT nombre_periodo FROM periodo WHERE id_periodo=".$periodo;
$result_per =@pg_Exec($conn,$qry_per);
$fila_per = @pg_fetch_array($result_per,0);
$nombre_periodo = $fila_per['nombre_periodo'];

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
				</td>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ano_esc?></font></div></td>
                </tr>
              <tr>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>PERIODO</strong></font></div></td>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
                <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">
				<?=$nombre_periodo?> 
				</font></div></td>
                </tr>	
              <tr>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
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
              </tr>
            </table>

<table width="650" border="1" align="center" style="border-collapse:collapse ">
<tr>
        <td colspan="7" class="tableindex">
          <div align="center">INFORME PROMEDIOS POR CICLO</div></td>
    </tr>
      <tr>
        <td colspan="7"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
    </tr>
		  <tr>
        <td width="170" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="480" colspan="3" class="Estilo8">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo8">Per&iacute;do</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nombre_periodo?></td>
      </tr>
      <tr>
        <td class="Estilo8">A&ntilde;o</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$ano_esc?></td>
    </tr>	
		
	<table border="1" align="center" width="650" cellpadding="0" cellspacing="0">	
		
  <? for ($i=0; $i < @pg_numrows($result); $i++){
  		$fila = @pg_fetch_array($result,$i);?>
  <tr>
    <td class="Estilo7"><? echo $ciclo = $fila['nomb_ciclo'];?></td>
    <td class="Estilo7">Promedio</td>
  </tr>
  		<? 
			$qry2="SELECT * FROM ciclos WHERE id_ano=".$ano." AND id_ciclo=".$fila['id_ciclo']." ORDER BY id_curso DESC";
			$result2 =@pg_Exec($conn,$qry2);		
			for ($j=0; $j < @pg_numrows($result2); $j++){
				$fila2 = @pg_fetch_array($result2,$j);?>
  <tr>
	<td class="Estilo8"><?  $qry3="SELECT curso.grado_curso,curso.letra_curso,tipo_ensenanza.nombre_tipo FROM curso ";
			$qry3.="INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo INNER JOIN ciclos ON ";
			$qry3.="curso.id_curso=ciclos.id_curso  WHERE curso.id_curso=".$fila2['id_curso']." AND ciclos.id_ciclo=".$fila['id_ciclo'];
			$result3 =@pg_Exec($conn,$qry3);
			$fila3 = @pg_fetch_array($result3,0);
			
			echo $fila3['grado_curso']."-".$fila3['letra_curso']." ".$fila3['nombre_tipo'];
		?></td>
    <td class="Estilo8"> 
	<? $qry4="SELECT AVG(CAST(notas$ano_esc.promedio as integer)) as prom FROM ramo INNER JOIN notas$ano_esc ON ramo.id_ramo=notas$ano_esc.id_ramo WHERE ramo.id_curso=".$fila2['id_curso']." AND notas$ano_esc.promedio not in ('MB','B','S','I','')";
			$result4 =@pg_Exec($conn,$qry4);
			$fila4 = @pg_fetch_array($result4,0);
			echo round($fila4['prom']);
			 ?>
		</td>

  </tr>
  		<? }?>
  <? }?>
  </table>
</table>
<table width="650" border="0" align="center">
              <tr>
                <?  
			
			if($ob_config->firma1=0){
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
            </table>
</div>
</body>
</html>

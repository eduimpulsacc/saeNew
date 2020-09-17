<?php 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$reporte		= $c_reporte;
	
	
	$fecha =date("d-m-Y");
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	$ob_reporte->rdb=$institucion;
	$ob_reporte->ano=$ano;
	$ob_reporte->id_pro=$cmbGRUPO;
	$rs_docente = $ob_reporte->DocenteProyecto($conn);
	$fila_doc = @pg_fetch_array($rs_docente,0);
	if($fila_doc['titulado']==1){
		$titulo = "Docente Titulado";
	}elseif($fila_doc['habilitado']==1){
		$titulo = "Docente Habilitado";
	}else{
		$titulo="Profesional de otras Áreas";
	}
	
	$rs_alumno = $ob_reporte->AlumnoProyecto($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($exportar ==1){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=GrupoDiferencial$Fecha.xls"); 
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
function enviapag2(form){
	form.target="_blank";
	document.form.action='printGrupoDiferencialPorColegio_C.php?cmbGRUPO=<?=$cmbGRUPO?>&c_reporte=<?=$reporte?>&exportar=1';
	document.form.submit(true);
}
</script>
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
 .txt_tabla {
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 7px;
	font-weight: bold;
}
 .txt_nro{
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 7px;
	font-weight:normal;
}
</style>
</head>

<body>
<form name="form" method="post">
<div id="capa0">
<tablE width="650" align="center">
	<tr>
		<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td>
		<td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
		<td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	</tr>
</tablE>

</div>
<br />
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center"><table width="125" height="100" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='90' height = '100' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>	  
<br />
<table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex">FICHA GRUPOS DIFERENCIALES POR ESTABLECIMIENTO </td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">&nbsp;</div></td>
  </tr>
  <tr>
    <td width="203" class="item">NOMBRE DOCENTE </td>
    <td width="447" class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_doc['nombre']));?>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">TITULO PROFESIONAL </td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_doc['titulo']));?>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">TITULO Y ESPECIALIDAD </td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($titulo));?>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">HORAS CONTRATO </td>
    <td class="subitem"><?=$fila_doc['hrs_contrato'];?>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">HORAS EN AULA </td>
    <td class="subitem"><?=$fila_doc['total_aula'];?>&nbsp;</td>
  </tr>
  <tr>
    <td class="item">FECHA</td>
    <td class="subitem"><?=$fecha;?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<br />
<br />
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td class="item">N&ordm;</td>
    <td class="item">ALUMNO</td>
    <td class="item">FECHA<br />
    NAC</td>
    <td class="item">EDAD</td>
    <td class="item">CURSO</td>
    <td class="item">DIAGNOSTICO<br />
      BASADO EN<br />
      EL RESPALDO<br />
      DE INFORMES<br />
      psicopedag&oacute;gicos<br />
      neurol&oacute;gicos y/o<br />
    psicol&oacute;gicos</td>
    <td class="item">PROFESIONAL<br />
            O 
      INSTITUCI&Oacute;N<br />
      QUE EMITE EL <br />
    DIAGNOSTICO</td>
    <td class="item">OBSERVACIONES</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
  		$fila_alu = @pg_fetch_array($rs_alumno,$i);
		$cont++;
		$primera = $fecha;  
  		$segunda = Cfecha($fila_alu['fecha_nac']);  
?>
  <tr>
    <td class="subitem"><?=$cont;?>&nbsp;</td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_alu['nombres']));?>&nbsp;</td>
    <td class="subitem"><? impF($fila_alu['fecha_nac']);?>&nbsp;</td>
    <td class="subitem"><? echo compararFechas($primera,$segunda);?> &nbsp;</td>
    <td class="subitem"><?=CursoPalabra($fila_alu['id_curso'], 1, $conn);?></td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_alu['nombre']));?>&nbsp;</td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_alu['institucion']));?>&nbsp;</td>
    <td class="subitem"><?=$ob_reporte->tildeM(strtoupper($fila_alu['obs']));?>&nbsp;</td>
  </tr>
  <? } ?>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000" />
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br />
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn); ?>
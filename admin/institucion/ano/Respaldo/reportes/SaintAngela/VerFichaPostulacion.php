<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	// AÑO ESCOLAR
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 	
	//------------------
	$ano_post = $ano_escolar;
	if($id_post>0)
	{
		$sql_postula = "select * from postulacion where id_post = ".$id_post;
		$result_postula =@pg_Exec($conn,$sql_postula);
		$fila_postula = @pg_fetch_array($result_postula,0);
		$ano_post = $fila_postula['id_ano'];
		if($fila_postula['nacionalidad_post']==1) 
			$nacionalidad = "CHILENA"; 
		else 
			$nacionalidad = "EXTRANJERA"; 
			
		if($fila_postula['vive_con']==1) $vive_con = "Ambos Padres";
		if($fila_postula['vive_con']==2) $vive_con = "Madre";
		if($fila_postula['vive_con']==3) $vive_con = "Padre";
		if($fila_postula['vive_con']==4) $vive_con = "Otro";
		
		if($fila_postula['situacion_padres']==1) $situacion_padres = "Casados";
		if($fila_postula['situacion_padres']==2) $situacion_padres = "Vuido(a)";
		if($fila_postula['situacion_padres']==3) $situacion_padres = "Separados";
		if($fila_postula['situacion_padres']==4) $situacion_padres = "Otros";
	}
	//-----------------------
	// CURSOS POSTULACION
	//-----------------------	
	$sql_cursos = "select * from tipo_ensenanza where cod_tipo = ".$fila_postula['ensenanza_post'];
	$result_cursos =@pg_Exec($conn,$sql_cursos);	
	$fila_cursos = @pg_fetch_array($result_cursos,0);
	$curso_post = $fila_postula['grado_post']."º ".$fila_cursos['nombre_tipo'];
	//-----------------
	// COMUNAS
	//------------------
	$sql_comuna = "select * from comuna where cor_com = ".$fila_postula['comuna_post']." and cor_pro = ".$fila_postula['provincia_post']." and cod_reg = ".$fila_postula['region_post'];
	$result_comuna =@pg_Exec($conn,$sql_comuna);
	$fila_comuna = @pg_fetch_array($result_comuna,0);	
	$comuna = $fila_comuna['nom_com'];
	//----------------------
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<FORM method=post name="frm" action="procesa_postulacion.php?id_post=<?php echo $id_post;?>">
<center>
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="justify">
	<table width="630"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<div id="capa0">
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="IMPRIMIR" name=btnModificar onclick="imprimir();" >
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar onclick=document.location="FichaPostulacion.php?id_post=<?php echo trim($fila_postula['id_post']);?>" >
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR" name=btnModificar onclick=document.location="BorraPostulante.php?id_post=<?php echo trim($fila_postula['id_post']);?>" >	  
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar3  onClick=document.location="ListadoPostulantes.php">
    </div>	  
	</td>	
  </tr>
</table>
<table width="630" height="93"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="476" height="91"><table width="400" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="4"><? echo $nombre_institu?></font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>  
    <td width="119" align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="FOTO"  width=70 ></td>
	<? }?>
  </tr>
</table>
<br>
<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#003b85">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif" size="4"><strong><font color="#FFFFFF">FICHA DE POSTULACI&Oacute;N </font></strong></font></td>
  </tr>
</table>
<br>
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="133"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO AL QUE POSTULA </strong></font></td>
    <td width="258"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp($curso_post)?></font></td>
    <td width="126"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&Ntilde;O AL QUE POSTULA </strong></font></td>
    <td width="113"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp($fila_postula['id_ano'])?></font></td>
  </tr>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTADO</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-1">
	<? if($fila_postula['estado']==1 {) echo "Lista de Espera";
	if($fila_postula['estado']==1 {) echo "Proceso de Selección";
	if($fila_postula['estado']==1 {) echo "Seleccionado(a)";?>
	</font></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>1 ) ANTECEDENTES ALUMNO(A)</strong></font></td>
	  </tr>
	</table>	
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO PATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO MATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRES</strong></font></td>
	  </tr>	
	  <tr>
		<td width="192" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp(strtoupper($fila_postula['ape_pat_post']))?></font></td>
		<td width="206" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp(strtoupper($fila_postula['ape_mat_post']))?></font></td>
		<td width="224" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp(strtoupper($fila_postula['nombre_post']))?></font></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	 <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NACIONALIDAD</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>RUT</strong></font></td>
	  </tr>	  
	<tr>	  
		<td width="172"><font face="Arial, Helvetica, sans-serif" size="-1"><?  imp(strtoupper($nacionalidad))?></font></td>
		<td width="120" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? impF(strtoupper($fila_postula['fecha_nac_post']))?></font></td>
		<td width="338" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['rut_post'])."-".strtoupper($fila_postula['dig_rut_post']))?></font></td>
	</tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CALLE</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm;</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>COMUNA</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TEL&Eacute;FONO</strong></font></td>
	  </tr>	
	  <tr>
		<td width="152" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['calle_post']))?></font></td>
		<td width="61" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nro_post']))?></font></td>
		<td width="291" align="left">
		  <font face="Arial, Helvetica, sans-serif" size="-1">
		  <?  imp($comuna)?>
	    </font></td>
		<td width="112" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['telefono_post']))?></font></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="278" align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PARIENTES EN EL COLEGIO (RECOMENDADOS POR) </strong></font></td>
		<td width="352" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['parientes']))?></font></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="78" rowspan="2" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N&ordm; DE HIJOS </strong></font></td>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>HOMBRES</strong></font></td>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MUJERES</strong></font></td>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>LUGAR QUE OCUPA ENTRE ELLOS </strong></font></td>		
	  </tr>
	  <tr>
		<td width="67" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nro_hijos']))?></font></td>
		<td width="70" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nro_hijas']))?></font></td>
		<td width="415" align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['lugar_ocupa']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="146"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>COLEGIO HERMANOS </strong></font></td>
		<td width="484"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['colegio_hermanos']))?></font></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>JARD&Iacute;N O COLEGIO ACTUAL </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OTROS COLEGIO QUE POSTULA </strong></font></td>
	  </tr>	
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['procedencia_post']))?></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['otros_colegios_post']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>2 ) ANTECEDENTES DEL PADRE:</strong></font></td>
	  </tr>
	</table>	
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO PATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO MATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRES</strong></font></td>	  
	  </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['ape_pat_padre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['ape_mat_padre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nombre_padre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="117"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO</strong></font></td>
        <td width="507"><font face="Arial, Helvetica, sans-serif" size="-1"><? impF(strtoupper($fila_postula['fecha_nac_padre']))?></font></td>
      </tr>
    </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="189"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SECUNDARIOS &iquest;D&Oacute;NDE?</strong></font></td>
		<td width="441"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['estudios_secundarios_padre']))?></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SUPERIORES &iquest;D&Oacute;NDE? </strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['estudios_superiores_padre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESI&Oacute;N O ACTIVIDAD </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>INSTITUCI&Oacute;N / EMPRESA DONDE TRABAJA </strong></font></td>	  
	  </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['profesion_actividad_padre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['empresa_padre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TEL&Eacute;FONO OFICINA </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CELULAR</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CARGO QUE DESEMPE&Ntilde;A </strong></font></td>
	  </tr>
	  <tr>
  		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['telefono_oficina_padre']))?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['celular_padre']))?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['cargo_padre']))?></font></td>
	  </tr>
	</table>
<H1 class=SaltoDePagina>&nbsp;</H1>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>3 ) ANTECEDENTES DE LA MADRE:</strong></font></td>
	  </tr>
	</table>	
	<br>
		<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO PATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>APELLIDO MATERNO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRES</strong></font></td>	  
	  </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['ape_pat_madre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['ape_mat_madre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nombre_madre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="117"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO</strong></font></td>
        <td width="507"><font face="Arial, Helvetica, sans-serif" size="-1"><? impF(strtoupper($fila_postula['fecha_nac_madre']))?></font></td>
      </tr>
    </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="189"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SECUNDARIOS &iquest;D&Oacute;NDE?</strong></font></td>
		<td width="441"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['estudios_secundarios_madre']))?></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SUPERIORES &iquest;D&Oacute;NDE? </strong></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['estudios_superiores_madre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESI&Oacute;N O ACTIVIDAD </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>INSTITUCI&Oacute;N / EMPRESA DONDE TRABAJA </strong></font></td>	  
	  </tr>
	  <tr>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['profesion_actividad_madre']))?></font></td>
		<td ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['empresa_madre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TEL&Eacute;FONO OFICINA </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CELULAR</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CARGO QUE DESEMPE&Ntilde;A </strong></font></td>
	  </tr>
	  <tr>
  		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['telefono_oficina_madre']))?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['celular_madre']))?></font></td>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['cargo_madre']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>4 ) SITUACIÓN FAMILIAR:</strong></font></td>
	  </tr>
	</table>	
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="185" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Alumno(a) vive con: </strong></font></td>
	    <td width="445" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($vive_con))?></font></td>
	  </tr>
  </table>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="185"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Situaci&oacute;n actual de los Padres:</strong></font></td>
		<td width="445"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($situacion_padres))?></font></td>
	  </tr>
  </table>
  <br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>5 ) OTROS ANTECEDENTES DE EL (LA) ALUMNO (A):</strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td colspan="4"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>a) Ha sido atendido(a) por al alg&uacute;n especialista como: </strong></font></td>
	  </tr>
	  <tr>
		<td width="148" align="center"><? if($fila_postula['psicologo']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Psic&oacute;logo</strong></font></td>
		<td width="164" align="center"><? if($fila_postula['neurologo']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Neur&oacute;logo</strong></font></td>
		<td width="163" align="center"><? if($fila_postula['psiquiatra']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Psiquiatra</strong></font></td>
		<td width="165" align="center"><? if($fila_postula['otros_especia']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Otros</strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="147" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha de &uacute;ltima atenci&oacute;n</strong></font></td>
		<td width="90" ><font face="Arial, Helvetica, sans-serif" size="-1"><? impF(strtoupper($fila_postula['fecha_ultima_especia']))?></font></td>
		<td width="105" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Especialista </strong></font></td>
		<td width="288" ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nombre_especialista_especia']))?></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Motivo</strong></font></td>
		<td colspan="3"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['motivo_especia']))?></font></td>
	  </tr>
  </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td colspan="4"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>b) Ha consultado el Pediatra por problemas de:</strong></font></td>
	  </tr>
	  <tr>
		<td width="148" align="center"><? if($fila_postula['oido']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>O&iacute;do</strong></font></td>
		<td width="164" align="center"><? if($fila_postula['vista']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Vista</strong></font></td>
		<td width="163" align="center"><? if($fila_postula['lenguaje']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Lenguaje</strong></font></td>
		<td width="165" align="center"><? if($fila_postula['otros_pediatra']==1){?> <img src="tic.gif"> <? } else {?> __ <? }?><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Otros</strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="147" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha de &uacute;ltima atenci&oacute;n</strong></font></td>
        <td width="90" ><font face="Arial, Helvetica, sans-serif" size="-1"><? impF(strtoupper($fila_postula['fecha_ultima_pediatra']))?></font></td>
        <td width="105" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Especialista </strong></font></td>
        <td width="288" ><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['nombre_especialista_pediatra']))?></font></td>
      </tr>
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Motivo</strong></font></td>
        <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['motivo_pediatra']))?></font></td>
      </tr>
    </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>6 ) RAZONES DE POSTULACIÓN AL COLEGIO:</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['razones']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>7 ) DESCRIPCIÓN BREVE DEL POSTULANTE:</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61" valign="top"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['descripcion']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>8 ) PERSONA QUE LO INSCRIBE: Nombre Completo, Parentesco y Teléfono</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61"valign="top"><font face="Arial, Helvetica, sans-serif" size="-1"><? imp(strtoupper($fila_postula['inscribiente']))?></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>* La direcci&oacute;n del Colegio se reserva el derecho de elegir a sus postulantes. </strong></font></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>* La documentaci&oacute;n entregada al postular no ser&aacute; devuelta. </strong></font></td>
	  </tr>
  </table>
	<br>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="272" align="center">_____________________________</td>
		<td width="309">&nbsp;</td>
		<td width="61" align="center">_____________________________</td>
	  </tr>
	  <tr>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FIRMA</strong></font></td>
		<td>&nbsp;</td>
		<td align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA</strong></font></td>
	  </tr>
	</table>
      </tr>
    </table>

	</td>
  </tr>
</table>

</center>
</form>
</body>
</html>

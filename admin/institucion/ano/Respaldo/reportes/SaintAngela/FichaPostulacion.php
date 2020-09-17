<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
		<SCRIPT language="JavaScript">
			function valida(form){
			
				if(!chkSelect(form.grado_post,'Seleccione Curso al que Postula')){
					return false;
				};

				if(!chkVacio(form.ape_pat_post,'Ingresar Apellido Paterno del Postulante.')){
					return false;
				};

				if(!chkVacio(form.ape_mat_post,'Ingresar Apellido Materno del Postulante.')){
					return false;
				};
				
				if(!chkVacio(form.nombre_post,'Ingresar Nombres del Postulante.')){
					return false;
				};
				
				if(!(form.nacionalidad_post[0].checked) && !(form.nacionalidad_post[1].checked)){
					alert("Seleccione Tipo de Nacionalidad");
					return false;
				};
				
				if(!chkFecha(form.fecha_nac_post,'Fecha Nacimiento Postulante no Válida')){
					return false;
				};
				
				if(!chkVacio(form.fecha_nac_post,'Ingresar Fecha Nacimiento Postulante')){
					return false;
				};
				
				if(!CheckRutDigito(form.rut_post.value, form.dig_rut_post.value)){
					alert("Rut Postulante no Válido");
					return false;
				};
				
				if(!chkVacio(form.calle_post,'Ingresar Calle del Domicilio del Postulante.')){
					return false;
				};
				
				if(!chkVacio(form.nro_post,'Ingresar Número del Domicilio del Postulante.')){
					return false;
				};
				
				if(!chkSelect(form.comuna_post,'Seleccione Comuna Residencia del Postulante.')){
					return false;
				};
				
				if(!chkVacio(form.telefono_post,'Ingresar Teléfono del Postulante.')){
					return false;
				};
				
				return true;
			}
		</SCRIPT>
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
	//-----------------
	// COMUNAS
	//------------------
	$sql_comuna = "select * from comuna order by nom_com";
	$result_comuna =@pg_Exec($conn,$sql_comuna);
	//----------------------
	// CURSOS POSTULACION
	//-----------------------	
	$sql_cursos = "select curso.grado_curso, ";
	$sql_cursos = $sql_cursos . "curso.ensenanza, ";
	$sql_cursos = $sql_cursos . "tipo_ensenanza.nombre_tipo ";
	$sql_cursos = $sql_cursos . "from   curso, tipo_ensenanza ";
	$sql_cursos = $sql_cursos . "where  id_ano = ".$ano." ";
	$sql_cursos = $sql_cursos . "and    tipo_ensenanza.cod_tipo = curso.ensenanza ";
	$sql_cursos = $sql_cursos . "order by curso.ensenanza ,curso.grado_curso ";
	$result_cursos =@pg_Exec($conn,$sql_cursos);
	//------------------
	$ano_post = $ano_escolar;
	if($id_post>0)
	{
		$sql_postula = "select * from postulacion where id_post = ".$id_post;
		$result_postula =@pg_Exec($conn,$sql_postula);
		$fila_postula = @pg_fetch_array($result_postula,0);
		$ano_post = $fila_postula['id_ano'];
		
	}
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
<table width="630"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	<div id="capa0">
	  <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnModificar onclick="return valida(this.form);" >
      <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnModificar3  onClick=document.location="VerFichaPostulacion.php?id_post=<?php echo trim($fila_postula['id_post']);?>" >
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
<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#003b85">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif" size="4"><strong><font color="#FFFFFF">FICHA DE POSTULACI&Oacute;N </font></strong></font></td>
  </tr>
</table>
<br>
<table width="630" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="94"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>CURSO AL QUE POSTULA </strong></font></td>
    <td width="297"><select name="grado_post">
      <option value=0 selected>(Seleccione Dato)</option>
      <? 	
		$cod_ense2 = $fila_postula['grado_post'].$fila_postula['ensenanza_post'];
		for($f=0 ; $f< @pg_numrows($result_cursos) ; $f++) 
		{
			$fila_curso = @pg_fetch_array($result_cursos,$f);
			$cod_ense = $fila_curso['grado_curso'].$fila_curso['ensenanza'];
			if ($cod_ense==$cod_ense2)
			{?>
		      <option value=<? echo $cod_ense;?> selected><? echo $fila_curso['grado_curso']. "º - ".$fila_curso['nombre_tipo'];?></option>
			 <? } else {?>
			  <option value=<? echo $fila_curso['grado_curso'].$fila_curso['ensenanza'];?> ><? echo $fila_curso['grado_curso']. "º - ".$fila_curso['nombre_tipo'];?></option> 
			 
      <? }
	  }
	  ?>
    </select>	</td>
    <td width="126"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>A&Ntilde;O AL QUE POSTULA </strong></font></td>
    <td width="113">
	  <select name="id_ano">
	  	<?  if($ano_post==$ano_escolar){?>
		  	<option value = <? echo $ano_escolar   ?> selected><? echo $ano_escolar   ?></option>
		<? } else {?>	
			<option value = <? echo $ano_escolar   ?> ><? echo $ano_escolar   ?></option>
		<? } ?>
	  	<?  if($ano_post==($ano_escolar+1)  ){?>
		  	<option value = <? echo $ano_escolar+1   ?> selected><? echo $ano_escolar+1   ?></option>
		<? } else {?>	
			<option value = <? echo $ano_escolar+1   ?> ><? echo $ano_escolar+1   ?></option>
		<? } ?>		
      </select>      <font face="Arial, Helvetica, sans-serif" size="-2"></font></td>
  </tr>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTADO</strong></font></td>
    <td>
	<select name="estado">
		<option value="1"<? if($fila_postula['estado']==1 {) ?> selected <? }?>>Lista de Espera		</option>
		<option value="2"<? if($fila_postula['estado']==1 {) ?> selected <? }?>>Proceso de Selección	</option>		
		<option value="3"<? if($fila_postula['estado']==1 {) ?> selected <? }?>>Seleccionado(a)		</option>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
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
		<td width="192" align="left"><input name="ape_pat_post" type="text" id="ape_pat_post" size="30" maxlength="40" value="<? echo trim(strtoupper($fila_postula['ape_pat_post'])) ?>"></td>
		<td width="206" align="left"><input name="ape_mat_post" type="text" id="ape_mat_post" size="30" maxlength="40" value="<? echo trim(strtoupper($fila_postula['ape_mat_post'])) ?>"></td>
		<td width="224" align="left"><input name="nombre_post"  type="text" id="nombre_post"  size="30" maxlength="40" value="<? echo trim(strtoupper($fila_postula['nombre_post']))  ?>"></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	 <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NACIONALIDAD</strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>RUT</strong></font></td>
	  </tr>	  
	<tr>	  
		<td width="172" align="left">
		  <input name="nacionalidad_post" <? if($fila_postula['nacionalidad_post']==1){ ?>checked <? }?> type="radio" value="1"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Chileno</strong></font>
		  <input name="nacionalidad_post" <? if($fila_postula['nacionalidad_post']==2){ ?>checked <? }?> type="radio" value="2"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Extranjero</strong></font>		</td>
		<td width="120" align="left"><input name=fecha_nac_post type="text" onChange="chkFecha(form.fecha_nac_post,'Fecha Nacimiento no Válida.');" value="<? echo cfecha($fila_postula['fecha_nac_post'])  ?>" size=10 maxlength=10></td>
		<td width="338" align="left"><input name=rut_post type="text" value="<? echo trim(strtoupper($fila_postula['rut_post']))  ?>" size="15" maxlength="8">
		-<input name=dig_rut_post type="text" value="<? echo trim(strtoupper($fila_postula['dig_rut_post']))  ?>" size="2" maxlength="1">		  
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
		<td width="152" align="left"><input name="calle_post" type="text" id="calle_post" value="<? echo trim(strtoupper($fila_postula['calle_post']))  ?>" size="25" maxlength="40"></td>
		<td width="61" align="left"><input name="nro_post" type="text" id="nro_post" value="<? echo trim(strtoupper($fila_postula['nro_post'])) ?>" size="10" maxlength="8"></td>
		<td width="291" align="left">
		<select name="comuna_post" id="comuna_post">
		<option value=0 selected>(Seleccione Dato)</option>		
		<? 	
			if($fila_postula['region_post']>9) $cod_reg_2 = $fila_postula['region_post']; else $cod_reg_2 = "0".$fila_postula['region_post'];
			if($fila_postula['provincia_post']>9) $cod_pro_2 = $fila_postula['provincia_post']; else $cod_pro_2 = "0".$fila_postula['provincia_post'];
			if($fila_postula['comuna_post']>9) $cod_com_2 = $fila_postula['comuna_post']; else $cod_com_2 = "0".$fila_postula['comuna_post'];
			$comuna2 = $cod_reg_2.$cod_pro_2.$cod_com_2;
			
			for($e=0 ; $e < @pg_numrows($result_comuna) ; $e++) 
			{
				$cod_reg = 0;
				$cod_pro = 0;
				$cod_com = 0;
				$fila_comuna = @pg_fetch_array($result_comuna,$e);
				if($fila_comuna['cod_reg']>9) $cod_reg = $fila_comuna['cod_reg']; else $cod_reg = "0".$fila_comuna['cod_reg'];
				if($fila_comuna['cor_pro']>9) $cod_pro = $fila_comuna['cor_pro']; else $cod_pro = "0".$fila_comuna['cor_pro'];
				if($fila_comuna['cor_com']>9) $cod_com = $fila_comuna['cor_com']; else $cod_com = "0".$fila_comuna['cor_com'];
				
				$comuna = $cod_reg.$cod_pro.$cod_com;
				?>
				<option value=<? echo $comuna;?><? if($comuna2==$comuna){?> selected <? }?>><? echo $fila_comuna['nom_com'];?></option>		
			<? }?>
	    </select></td>
		<td width="112" align="left"><input name="telefono_post" type="text" id="telefono_post" value="<? echo trim(strtoupper($fila_postula['telefono_post'])) ?>" size="15" maxlength="15"></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PARIENTES EN EL COLEGIO (RECOMENDADOS POR) </strong></font></td>
		<td align="left"><input name="parientes" type="text" id="parientes" value="<? echo trim(strtoupper($fila_postula['parientes'])) ?>" size="57" maxlength="50"></td>
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
		<td width="67" align="center"><input name="nro_hijos" type="text" id="nro_hijos" value="<? echo trim(strtoupper($fila_postula['nro_hijos'])) ?>" size="5" maxlength="2"></td>
		<td width="70" align="center"><input name="nro_hijas" type="text" id="nro_hijas" value="<? echo trim(strtoupper($fila_postula['nro_hijas'])) ?>" size="5" maxlength="2"></td>
		<td width="415" align="center"><input name="lugar_ocupa" type="text" id="lugar_ocupa" value="<? echo trim(strtoupper($fila_postula['lugar_ocupa'])) ?>" size="57" maxlength="60"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>COLEGIO HERMANOS </strong></font></td>
		<td><input name="colegio_hermanos" type="text" id="colegio_hermanos" value="<? echo trim(strtoupper($fila_postula['colegio_hermanos'])) ?>" size="80" maxlength="60"></td>
	  </tr>
	</table>
	<br>	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>JARD&Iacute;N O COLEGIO ACTUAL </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>OTROS COLEGIO QUE POSTULA </strong></font></td>
	  </tr>	
	  <tr>
		<td align="left"><input name="procedencia_post" type="text" id="procedencia_post" value="<? echo trim(strtoupper($fila_postula['procedencia_post'])) ?>" size="45" maxlength="60"></td>
		<td align="left"><input name="otros_colegios_post" type="text" id="otros_colegios_post" value="<? echo trim(strtoupper($fila_postula['otros_colegios_post'])) ?>" size="45" maxlength="60"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
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
		<td ><input name="ape_pat_padre" type="text" id="ape_pat_padre" value="<? echo trim(strtoupper($fila_postula['ape_pat_padre'])) ?>" size="30" maxlength="40"></td>
		<td ><input name="ape_mat_padre" type="text" id="ape_mat_padre" value="<? echo trim(strtoupper($fila_postula['ape_mat_padre'])) ?>" size="30" maxlength="40"></td>
		<td ><input name="nombre_padre" type="text" id="nombre_padre" value="<? echo trim(strtoupper($fila_postula['nombre_padre'])) ?>" size="30" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="117"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO</strong></font></td>
        <td width="507"><input name="fecha_nac_padre" type="text" id="fecha_nac_padre" value="<? echo cfecha($fila_postula['fecha_nac_padre']) ?>" size="15" maxlength="10"></td>		
      </tr>
    </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SECUNDARIOS &iquest;D&Oacute;NDE?</strong></font></td>
		<td><input name="estudios_secundarios_padre" type="text" id="estudios_secundarios_padre" value="<? echo trim(strtoupper($fila_postula['estudios_secundarios_padre'])) ?>" size="60" maxlength="40"></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SUPERIORES &iquest;D&Oacute;NDE? </strong></font></td>
		<td><input name="estudios_superiores_padre" type="text" id="estudios_superiores_padre" value="<? echo trim(strtoupper($fila_postula['estudios_superiores_padre'])) ?>" size="60" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESI&Oacute;N O ACTIVIDAD </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>INSTITUCI&Oacute;N / EMPRESA DONDE TRABAJA </strong></font></td>	  
	  </tr>
	  <tr>
		<td ><input name="profesion_actividad_padre" type="text" id="profesion_actividad_padre" value="<? echo trim(strtoupper($fila_postula['profesion_actividad_padre'])) ?>" size="40" maxlength="40"></td>
		<td ><input name="empresa_padre" type="text" id="empresa_padre" value="<? echo trim(strtoupper($fila_postula['empresa_padre'])) ?>" size="40" maxlength="40"></td>
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
  		<td><input name="telefono_oficina_padre" type="text" id="telefono_oficina_padre" value="<? echo trim(strtoupper($fila_postula['telefono_oficina_padre'])) ?>" size="30" maxlength="15"></td>
		<td><input name="celular_padre" type="text" id="celular_padre" value="<? echo trim(strtoupper($fila_postula['celular_padre'])) ?>" size="30" maxlength="15"></td>
		<td><input name="cargo_padre" type="text" id="cargo_padre" value="<? echo trim(strtoupper($fila_postula['cargo_padre'])) ?>" size="30" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
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
		<td ><input name="ape_pat_madre" type="text" id="ape_pat_madre" value="<? echo trim(strtoupper($fila_postula['ape_pat_madre'])) ?>" size="30" maxlength="40"></td>
		<td ><input name="ape_mat_madre" type="text" id="ape_mat_madre" value="<? echo trim(strtoupper($fila_postula['ape_mat_madre'])) ?>" size="30" maxlength="40"></td>
		<td ><input name="nombre_madre" type="text" id="nombre_madre" value="<? echo trim(strtoupper($fila_postula['nombre_madre'])) ?>" size="30" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="117"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FECHA NACIMIENTO</strong></font></td>
        <td width="507"><input name="fecha_nac_madre" type="text" id="fecha_nac_madre" value="<? echo cfecha($fila_postula['fecha_nac_madre']) ?>" size="15" maxlength="10"></td>		
      </tr>
    </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SECUNDARIOS &iquest;D&Oacute;NDE?</strong></font></td>
		<td><input name="estudios_secundarios_madre" type="text" id="estudios_secundarios_madre" value="<? echo trim(strtoupper($fila_postula['estudios_secundarios_madre'])) ?>" size="60" maxlength="40"></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ESTUDIOS SUPERIORES &iquest;D&Oacute;NDE? </strong></font></td>
		<td><input name="estudios_superiores_madre" type="text" id="estudios_superiores_madre" value="<? echo trim(strtoupper($fila_postula['estudios_superiores_madre'])) ?>" size="60" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROFESI&Oacute;N O ACTIVIDAD </strong></font></td>
		<td align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>INSTITUCI&Oacute;N / EMPRESA DONDE TRABAJA </strong></font></td>	  
	  </tr>
	  <tr>
		<td ><input name="profesion_actividad_madre" type="text" id="profesion_actividad_madre" value="<? echo trim(strtoupper($fila_postula['profesion_actividad_madre'])) ?>" size="40" maxlength="40"></td>
		<td ><input name="empresa_madre" type="text" id="empresa_madre" value="<? echo trim(strtoupper($fila_postula['empresa_madre'])) ?>" size="40" maxlength="40"></td>
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
  		<td><input name="telefono_oficina_madre" type="text" id="telefono_oficina_madre" value="<? echo trim(strtoupper($fila_postula['telefono_oficina_madre'])) ?>" size="30" maxlength="15"></td>
		<td><input name="celular_madre" type="text" id="celular_madre" value="<? echo trim(strtoupper($fila_postula['celular_madre'])) ?>" size="30" maxlength="15"></td>
		<td><input name="cargo_madre" type="text" id="cargo_madre" value="<? echo trim(strtoupper($fila_postula['cargo_madre'])) ?>" size="30" maxlength="40"></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>4 ) SITUACIÓN FAMILIAR:</strong></font></td>
	  </tr>
	</table>	
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="185" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Alumno(a) vive con: </strong></font></td>
	    <td width="445" align="left" valign="top">		<select name="vive_con" id="vive_con">
		<option value=0 selected>(Seleccione dato)</option>	
		<option value=1 <? if($fila_postula['vive_con']==1){?> selected <? }?>>Ambos Padres</option>
		<option value=2 <? if($fila_postula['vive_con']==2){?> selected <? }?>>Madre</option>
		<option value=3 <? if($fila_postula['vive_con']==3){?> selected <? }?>>Padre</option>		
		<option value=4 <? if($fila_postula['vive_con']==4){?> selected <? }?>>Otro</option>		
        </select></td>
	  </tr>
  </table>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="185"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Situaci&oacute;n actual de los Padres:</strong></font></td>
		<td width="445">
		<select name="situacion_padres" id="situacion_padres">
		<option value=0 selected>(Seleccione dato)</option>				
		<option value=1 <? if($fila_postula['situacion_padres']==1){?> selected <? }?>>Casados</option>
		<option value=2 <? if($fila_postula['situacion_padres']==2){?> selected <? }?>>Vuido(a)</option>
		<option value=3 <? if($fila_postula['situacion_padres']==3){?> selected <? }?>>Separados</option>		
		<option value=4 <? if($fila_postula['situacion_padres']==4){?> selected <? }?>>Otros</option>				
        </select></td>
	  </tr>
  </table>
  <br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
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
		<td width="148" align="center"><input name="psicologo" <? if($fila_postula['psicologo']==1){?> checked <? }?> type="checkbox" id="Psicologo" value="1"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Psic&oacute;logo</strong></font></td>
		<td width="164" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
		  <input name="neurologo"  <? if($fila_postula['neurologo']==1){?> checked <? }?> type="checkbox" id="neurologo" value="1">
	    Neur&oacute;logo</strong></font></td>
		<td width="163" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
		  <input name="psiquiatra" <? if($fila_postula['psiquiatra']==1){?> checked <? }?> type="checkbox" id="psiquiatra" value="1">
	    Psiquiatra</strong></font></td>
		<td width="165" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
		  <input name="otros_especia"  <? if($fila_postula['otros_especia']==1){?> checked <? }?> type="checkbox" id="Otros" value="1">
	    Otros</strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="147" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha de &uacute;ltima atenci&oacute;n</strong></font></td>
		<td width="90" ><input name="fecha_ultima_especia" type="text" id="fecha_ultima_especia" value="<? echo cfecha($fila_postula['fecha_ultima_especia']) ?>" size="10" maxlength="10"></td>
		<td width="105" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Especialista </strong></font></td>
		<td width="288" ><input name="nombre_especialista_especia" type="text" id="nombre_especialista_especia" value="<? echo trim(strtoupper($fila_postula['nombre_especialista_especia'])) ?>" size="45" maxlength="60"></td>
	  </tr>
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Motivo</strong></font></td>
		<td colspan="3"><input name="motivo_especia" type="text" id="motivo_especia" value="<? echo trim(strtoupper($fila_postula['motivo_especia'])) ?>" size="70" maxlength="60"></td>
	  </tr>
  </table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td colspan="4"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>b) Ha consultado el Pediatra por problemas de:</strong></font></td>
	  </tr>
	  <tr>
		<td width="148" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><input name="oido" <? if($fila_postula['oido']==1){?> checked <? }?> type="checkbox" id="oido" value="1">
		  O&iacute;do</strong></font></td>
		<td width="164" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><input name="vista" <? if($fila_postula['vista']==1){?> checked <? }?> type="checkbox" id="vista" value="1">
		  Vista</strong></font></td>
		<td width="163" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><input name="lenguaje" <? if($fila_postula['lenguaje']==1){?> checked <? }?> type="checkbox" id="lenguaje" value="1">
		  Lenguaje</strong></font></td>
		<td width="165" align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><input name="otros_pediatra" <? if($fila_postula['otros_pediatra']==1){?> checked <? }?> type="checkbox" id="otros" value="1">
		  Otros</strong></font></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="147" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha de &uacute;ltima atenci&oacute;n</strong></font></td>
        <td width="90" ><input name="fecha_ultima_pediatra" type="text" id="fecha_ultima_pediatra" value="<? echo cfecha($fila_postula['fecha_ultima_pediatra']) ?>" size="10" maxlength="10"></td>
        <td width="105" ><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nombre Especialista </strong></font></td>
        <td width="288" ><input name="nombre_especialista_pediatra" type="text" id="nombre_especialista_pediatra" value="<? echo trim(strtoupper($fila_postula['nombre_especialista_pediatra'])) ?>" size="45" maxlength="60"></td>
      </tr>
      <tr>
        <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Motivo</strong></font></td>
        <td colspan="3"><input name="motivo_pediatra" type="text" id="motivo_pediatra" value="<? echo trim(strtoupper($fila_postula['motivo_pediatra'])) ?>" size="70" maxlength="50"></td>
      </tr>
    </table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>6 ) RAZONES DE POSTULACIÓN AL COLEGIO:</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61" align="left" valign="top"><textarea name="razones" cols="76" rows="4" id="razones"><? echo trim(strtoupper($fila_postula['razones'])) ?>
</textarea></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>7 ) DESCRIPCIÓN BREVE DEL POSTULANTE:</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61"><textarea name="descripcion" cols="76" rows="4" id="descripcion"><? echo trim(strtoupper($fila_postula['descripcion'])) ?>
</textarea></td>
	  </tr>
	</table>
	<br>
	<table width="630" border="1" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
	  <tr>
		<td><font face="Arial, Helvetica, sans-serif" size="-1"><strong>8 ) PERSONA QUE LO INSCRIBE: Nombre Completo, Parentesco y Teléfono</strong></font></td>
	  </tr>
	</table>
	<table width="630" border="1" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="61"><textarea name="inscribiente" cols="76" rows="4" id="inscribiente"><? echo trim(strtoupper($fila_postula['inscribiente'])) ?>

</textarea></td>
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
</center>
<? pg_close($conn); ?>
</form>
</body>
</html>


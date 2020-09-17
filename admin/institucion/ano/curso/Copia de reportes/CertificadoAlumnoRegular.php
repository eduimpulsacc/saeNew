<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');

	setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	//---------------------------
	if ($curso==0){?>
		<script>alert("Debe seleccionar el Curso")</script>
	<? exit; }
	
	if ($alumno==0){?>
		<script>alert("Debe seleccionar el Alumno")</script>		
	<? exit; }		
	//---------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$ciudad = $fila_ins['nom_pro'];
	$fono = $fila_ins['telefono'];
	$direc = $fila_ins['calle'].$fila_ins['nro'];
	$region = $fila_ins['nom_reg'];
	$provincia = $fila_ins['nom_pro'];
	$comuna = $fila_ins['nom_com'];
	$rbd = $fila_ins['rdb']." - ". $fila_ins['dig_rdb'];
	//----------
	$Curso_pal = CursoPalabra($curso, 0, $conn);	
	//----------
	//----------
		$sql_ano = "select nro_ano from ano_escolar where id_ano=" . $ano;
		$result_ano = @pg_exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$Nano = $fila_ano['nro_ano'];
	//----------
	if ($alumno == 0){
		
	}else{
		$sqlAlumnos = "select * from alumno where rut_alumno = '".$alumno."'";
		$rsAlumno=@pg_Exec($conn,$sqlAlumnos);
		$fAlumno= @pg_fetch_array($rsAlumno,0);
		$nombre = trim(ucwords(strtolower($fAlumno['nombre_alu']." ".$fAlumno['ape_pat']." ".$fAlumno['ape_mat'])));
		$sexo = $fAlumno['sexo'];
		$Curso_pal  = ucwords(strtolower($Curso_pal));
		$Rut_Alum = $fAlumno['rut_alumno'].$fAlumno['dig_rut'];
		if ($sexo == 2){
			$tipo1 = "alumno";
			$tipo2 = "del interesado";
		}else{
			$tipo1 = "alumna";
			$tipo2 = "de la interesada";
		}			
	}
	
	
	//----------
	$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));

	Function rutF($txt){
		if ($txt!=0){
			$largo=strlen($txt);
			if ($largo==9){
				$millon =substr (($txt), 0,2); 
				$centena = substr (($txt), 2,3); 
				$decena = substr (($txt), 5,3); 
				$exten = substr (($txt), -1); 
			}else{
				$millon =substr (($txt), 0,1); 
				$centena = substr (($txt), 1,3); 
				$decena = substr (($txt), 4,3); 
				$exten = substr (($txt), -1); 
			}
		$txt = $millon.".".$centena.".".$decena." - ".$exten;
		echo $txt;
		}
	}
		//----------
		$sql_curso = "select ensenanza, cod_es, cod_sector, cod_rama from curso where id_curso=" . $curso;
		$result_curso = @pg_exec($conn,$sql_curso);
		$fila_curso = @pg_fetch_array($result_curso,0);
		$Ense = $fila_curso['ensenanza'];
		$Espec = $fila_curso['cod_es'];
		$Sector = $fila_curso['cod_sector'];
		$Rama = $fila_curso['cod_rama'];
		
		if ($Ense >310){
			$sql_esp = "select nombre_esp from especialidad where cod_esp=" .$Espec." and cod_sector=".$Sector." and cod_rama=".$Rama;
			$result_esp = @pg_exec($conn,$sql_esp);
			$fila_esp = @pg_fetch_array($result_esp,0);
			$Especialidad = $fila_esp['nombre_esp'];
		}
		
			$sql_Mat = "select num_mat from matricula where rut_alumno='" .$alumno."' and id_ano=".$ano;
			$result_Mat= @pg_exec($conn,$sql_Mat);
			$fila_Mat = @pg_fetch_array($result_Mat,0);
			$numero = $fila_Mat['num_mat'];
	//----------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<center>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr align="right">
      <td>
        <div id="capa0">
          <input name="button3" type="button" class="botonX" onClick="imprimir();" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' value="IMPRIMIR">
      </div></td>
    </tr>
  </table>
  <table width="699" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="431" align="left"><font size="-2" face="Arial, Helvetica, sans-serif"><? echo strtoupper($ins_pal);?></font></td>
      <td width="12">&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Regi&oacute;n</font></td>
      <td width="190"><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $region;?></font></td>
    </tr>
    <tr> 
      <td align="left"><font size="-2" face="Arial, Helvetica, sans-serif"><? echo strtoupper($direc);?>&nbsp;<? echo strtoupper($comuna);?></font></td>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Provincia</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $provincia;?></font></td>
    </tr>
    <tr> 
      <td align="left"><font size="-2" face="Arial, Helvetica, sans-serif">FONO <? echo $fono;?></font></td>
      <td>&nbsp;&nbsp;&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Comuna</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $comuna;?></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">Rbd</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $rbd;?></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td width="66"><font size="-2" face="Arial, Helvetica, sans-serif">A&ntilde;o Escolar</font></td>
      <td><font size="-2" face="Arial, Helvetica, sans-serif">:&nbsp;<? echo $Nano;?></font></td>
    </tr>
  </table>
  <br>
  <table width="649" border="0" cellspacing="1" cellpadding="1">
  <tr>
      <td width="561" align="center" valign="top">
        <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".chop($institucion)."');";
			$retrieve_result = @pg_exec($conn,$output);?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td align="left">
				<? if (retrieve_result){?>
					<img src=../../../../../../../tmp/<? echo chop($institucion) ?> ALT="INSIGNIA"  height="100"></td>
				<? } ?>
			 </tr>
             </table>
			<? } ?></td>
    
    </tr>
</table><br><br><br>
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#003b85">
      <td align="center"><strong><font color="White"  face="verdana, arial, geneva, helvetica">CERTIFICADO DE ALUMNO REGULAR </font></strong></td>
    </tr>
	<tr> 
      <td valign="top"><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
  </table>
  <div align="left"><br>
    <br>
    <br>
  </div>
  <table width="678" border="0" cellspacing="0" cellpadding="0">
  <? if ($numero!=""){?>
    <tr> 
      <td><font face="Arial, Helvetica, sans-serif" size="2">Nº de Matrícula <strong><? echo $numero ?></strong></font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
	<? } ?>
    <tr> 
      <td width="348"><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ucwords(strtolower($Nombre_Direc)); ?></strong>, 
        director(a) del</font></td>
      <td width="352"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2"><b><? echo ucwords(strtolower($ins_pal));?></b></font></div></td>
    </tr>
  </table>
  <table width="675" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td colspan="3">&nbsp;</td>
	</tr>
    <tr> 
      <td width="96"><font face="Arial, Helvetica, sans-serif" size="2">certifica que </font></td>
      <td width="425" align="center"><strong><? echo $nombre?></strong>&nbsp;</td>
      <td width="154" align="right"><b>R.U.T <? rutF($Rut_Alum);?></b>&nbsp;</td>
    </tr>
	<tr>
		<td colspan="3">&nbsp;</td>
	</tr>
    <tr> 
      <td colspan="3"></td>
    </tr>
    <tr> 
      <td colspan="3"></td>
    </tr>
    <tr> 
      <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;es 
        <? echo $tipo1;?> regular del <b><? echo $Curso_pal, " ";?><? echo ucwords(strtolower($Especialidad)); ?></b> de este Establecimiento</font> 
      </td>
    </tr>
    <tr> 
      <td colspan="3"><br> <font face="Arial, Helvetica, sans-serif" size="2">Se 
        extiende el presente certificado a solicitud del apoderado para los fines 
        que estime conveniente</font></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
  </table>
  <br>  <br>
  <br>
  <br><br><br><br><br><br><br>
<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr> 
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
	  </tr>
	  <tr> 
		<td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) 
			Establecimiento </font></div></td>
	  </tr>
		<tr>
		<?
		$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
		$result =@pg_Exec($conn,$sql4);
		$fila = @pg_fetch_array($result,0);	
		$nombre_profe = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp'])));
		?>
		<td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="1"> 
		<?
			
		echo $Nombre_Direc;
	?>
			</font></strong></div></td>
	  </tr>
  </table>
<br><br><br><br><br><br>
  <table width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
	 <td width="%" align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo ucwords(strtolower($ciudad . ", " . strftime("%d de %B del %Y",time())))?></strong></font></td>
  </tr>
</table>

</center>
</body>
</html>

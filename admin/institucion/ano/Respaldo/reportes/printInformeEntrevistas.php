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
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$_POSP = 4;
	$_bot = 8;
	
	$sql = "SELECT nro_ano FROM ano_escolar WHERE id_ano='$ano'";
	$result = @pg_exec($conn,$sql);
	$Nro_Ano = @pg_result($result,0);
		
	//if ($curso==0)
		// exit;
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<!-- AQUÍ EL CONTENIDO CENTRAL DE LA PÁGINA -->
<?
if ($curso != 0){
   ?><br> 
  <table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
	  <tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr></tablE>
	</div>
	</td>
  </tr>
</table><br>
<?
}

	if ($alumno > 0)
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	}
	else
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
		$sql_alumno.= " matricula.nro_lista FROM (matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) ";
		$sql_alumno.= " INNER JOIN entrevista ON (matricula.id_ano=entrevista.id_ano AND matricula.rdb=entrevista.rdb ";
		$sql_alumno.= " AND alumno.rut_alumno=entrevista.rut_alumno AND matricula.rut_alumno=entrevista.rut_alumno) ";
		$sql_alumno.= " WHERE ((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.") AND entrevista.id_ano=".$ano." ";
		$sql_alumno.= " order by ape_pat, ape_mat";
	}	
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$rut_alumno = strtoupper($fila_alumno['rut_alumno'] . " - " . $fila_alumno['dig_rut']);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre = ucwords(strtolower($fila_alumno['nombre_alu']));
		$ape_pat = ucwords(strtolower($fila_alumno['ape_pat']));
		$ape_mat = ucwords(strtolower($fila_alumno['ape_mat']));
		$nro_lista = $fila_alumno['nro_lista'];
		$fecha_nacimiento = $fila_alumno['fecha_nac'];
		$sexo = $fila_alumno['sexo'];
		if ($sexo==1)
			$sexo = "Femenino";
		else
			$sexo = "Masculino";
		$nacionalidad = $fila_alumno['nacionalidad'];
		if ($nacionalidad==2)
			$nacionalidad = "Chilena";
		else
			$nacionalidad = "Extranjera";
		$telefono_alu = $fila_alumno['telefono'];
		$email = $fila_alumno['email'];
		$fecha_matricula = $fila_alumno['fecha'];
		$fecha_retiro = $fila_alumno['fecha_retiro'];
		
		if ($fila_alumno['bool_baj']==1) $bool_baj = "SI"; else	$bool_baj = "NO";		
		if ($fila_alumno['bool_aoi']==1) $bool_aoi = "SI"; else	$bool_aoi = "NO";		
		if ($fila_alumno['bool_rg']==1) $bool_rg = "SI"; else	$bool_rg = "NO";		
		if ($fila_alumno['bool_ae']==1) $bool_ae = "SI"; else	$bool_ae = "NO";		
		if ($fila_alumno['bool_i']==1) $bool_i = "SI"; else	$bool_i = "NO";		
		if ($fila_alumno['bool_gd']==1) $bool_gd = "SI"; else	$bool_gd = "NO";		
		if ($fila_alumno['bool_ar']==1) $bool_ar = "SI"; else	$bool_ar = "NO";		
		if ($fila_alumno['bool_bchs']==1) $bool_bchs = "SI"; else	$bool_bchs = "NO";				
		
		$direccion_alu = ucwords(strtolower($fila_alumno['calle'] . " " . $fila_alumno['nro']));
		$comuna = ucwords(strtolower($fila_alumno['nom_com']));
		$provincia = ucwords(strtolower($fila_alumno['nom_pro']));
		$region = ucwords(strtolower($fila_alumno['nom_reg']));
		$block = ucwords(strtolower($fila_alumno['block']));
		$depto = ucwords(strtolower($fila_alumno['depto']));
		$villa = ucwords(strtolower($fila_alumno['villa']));	
			
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	   <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	    if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	    }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	    }
	  ?>
	</td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="4"><b> DIRECCI&Oacute;N ACAD&Eacute;MICA E INSPECTOR&Iacute;A </b></font></div></td>
    <td><div align="right">&nbsp;
	<?
	$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
	$arr=@pg_fetch_array($result,0);
	$fila_foto = @pg_fetch_array($result,0);
	
	if 	(!empty($fila_foto['foto'])){
		$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
		$retrieve_result = @pg_exec($conn,$output);?> 
		
		<img src=../../../../../../../infousuario/images/<? echo $alumno ?> ALT="FOTO"  height="100">
  <? } ?>	
	</div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="tableindex"><div align="center">REGISTRO DE ENTREVISTAS - <?=$Nro_Ano?> </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b>PROFESOR JEFE : </b></font></div></td>
    <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">
	      <?php
			$qry55="select * from supervisa where id_curso=".$curso;
		//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
			$result55 =@pg_Exec($conn,$qry55);
			$fila55 = @pg_fetch_array($result55,0);
			
			$qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
		//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
			$result5 =@pg_Exec($conn,$qry5);
			$fila5 = @pg_fetch_array($result5,0);

			imp($fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]);
			?>			
	     </font>		
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Alumno (a) : </strong></font></td>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><? echo "$nombre $ape_pat $ape_mat"; ?></font></td>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Curso : </strong></font></td>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><? $Curso_pal = CursoPalabra($curso,1,$conn); echo "$Curso_pal"; ?></font></td>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong> N&ordm; Lista : </strong></font></td>
    <td ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1">&nbsp; <?=$nro_lista; ?></font></td>
  </tr>
</table>
<br>
<br>
<table width="650" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><b>ENTREVISTAS - <?=$Nro_Ano?> </b></font></div></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">
      <hr size="1">
    </div></td>
  </tr>
  <?
  $sql = "select * from entrevista where rdb = '".$_INSTIT."' and id_ano = '".$_ANO."' and rut_alumno = '$alumno' order by id_entrevista";
  $res = @pg_Exec($conn,$sql);
  $num = @pg_numrows($res);
  
  for ($x=0; $x < $num; $x++){
      $fil = @pg_fetch_array($res,$x);
	  
	  $fecha = $fil['fecha'];
	  $asunto = $fil['asunto'];
	  $observaciones = $fil['observaciones'];
	  
	  ?>	
	  <tr>
		<td width="15%" valign="top" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"> <?=$fecha ?></font></td>
		<td width="25%" valign="top" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><?=$asunto ?></font></td>
		<td width="60%" valign="top" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><?=$observaciones ?></font></td>
	  </tr>
	  <tr>
	    <td colspan="3" valign="top" ><hr size="1"></td>
  </tr>
	  <?
  }
  
  ?>  
</table>
<br><br><br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div align="center">___________________________</div></td>
  </tr>
  <tr>
    <td>
	<?
	$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
	$sql = $sql . "WHERE trabaja.rdb=".$_INSTIT." ";
	if($institucion==14629){
		$sql.=" AND (trabaja.cargo=6) ";
	}else{
		$sql.=" AND (trabaja.cargo=2) ";
	}
	$result =@pg_Exec($conn,$sql);
	if (!$result) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}
	else
	{
		if (pg_numrows($result)!=0)
		{
			$fila = @pg_fetch_array($result,0);	
			if (!$fila)
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
		}
	}
	$nombre_utp = $fila['nombre_emp']." ".$fila['ape_pat']." ".$fila['ape_mat'];			
    ?> 
	
	 
	<font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><div align="center"><?=$nombre_utp ?></div></font>	
	
	<font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong><div align="center"> <? if($institucion==14629) echo "Sub-Director Academico"; else echo "Jefe de UTP"; ?> </div></strong></font></td>
  </tr>
</table>

<? 
if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
}

?>
</body>
</html>
<? pg_close($conn);?>
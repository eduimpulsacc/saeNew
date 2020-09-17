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

<body>
<!-- FIN DE COPIA DE BOTONES -->


<!-- AQU� EL CONTENIDO CENTRAL DE LA P�GINA -->
<?
if ($curso != 0){
   ?><br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	</td></tr></table>
      </div></td>
  </tr>
</table>
   <?
}   


	if ($alumno > 0)
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud, alumno.religion, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	}
	else
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, alumno.salud, alumno.religion, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
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
		$salud = ucwords(strtolower($fila_alumno['salud']));
		$religion = ucwords(strtolower($fila_alumno['religion']));		
?>
<?
 if ($institucion=="770"){ 
	    // no muestro los datos de la institucion
	    // por que ellos tienen hojas pre-impresas
	    echo "<br><br><br><br><br><br><br><br><br><br><br>";
			   
  }else{
		
       ?>
		<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
		  <tr>
		  <td>
			<?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## c�digo para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
			?>	
			</td>
			<td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $nombre_institu;?></strong></font></td>
				<?
				$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				if 	(!empty($fila_foto['foto']))
				{
					$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
					$retrieve_result = @pg_exec($conn,$output);?>  		
			<td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $alumno ?> ALT="FOTO"  height="100"></div></td>
			<? }?>
		  </tr>
		  <tr>
			<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $direccion;?></strong></font></td>
			</tr>
		  <tr>
			<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $telefono;?></strong></font></td>
			</tr>
		  <tr>
			<td>&nbsp;</td>
			</tr>
		  <tr>
			<td>&nbsp;</td>
			</tr>
		  <tr>
			<td>&nbsp;</td>
			</tr>
         </table>
<? } ?>



<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">FICHA DEL ALUMNO &nbsp;</div></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="140"><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Rut Alumno</strong></font></div></td>
    <td width="106">&nbsp;</td>
    <td width="196">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $rut_alumno?></font></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Nombres</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Apellido Paterno</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Apellido Materno</strong></font></div></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $nombre?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $ape_pat?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $ape_mat?></font></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Fecha 
          de Nacimiento</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Sexo</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Nacionalidad</strong></font></div></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo Cfecha2($fecha_nacimiento)?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $sexo?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $nacionalidad?></font></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Tel�fono</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>E-mail</strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $telefono_alu?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $email?></font></td>
    <td>&nbsp;</td>
  </tr>  
   <tr>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Sistema de salud</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Religion</strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $salud?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $religion?></font></td>
    <td>&nbsp;</td>
  </tr>  
  <tr>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Curso</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Fecha 
          de Matricula</strong></font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1">
				<? 
				$Curso_pal = CursoPalabra($curso, 0, $conn);
				echo $Curso_pal; 
				?>
	  </font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo Cfecha2($fecha_matricula)?></font></td>
    <td>&nbsp;</td>
  </tr>
</table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
             <? $qryD="select dependencia from institucion where rdb=".$_INSTIT;
		    	 $resultD =@pg_Exec($conn,$qryD);
			 		$filaD = @pg_fetch_array($resultD,0);
				 if (($filaD['dependencia']!=0) and ($filaD['dependencia']!=1)){ 
				 ?>

   <tr>
     <td width="101"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>BECA ALIMENTACION JUNAEB</strong></font></div></td>
     <td width="94"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>BENEFICIO CHILE SOLIDARIO </strong></font></div></td>
     <td width="103"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>ALUMNO ORIGEN INDIGENA</strong></font></div></td>
     <td width="76"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>REPITENTE DEL GRADO </strong></font></td>
     <td width="93"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>ALUMNA EMBARAZADA </strong></font></td>
     <td width="89"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>GRUPO DIFERENCIAL </strong></font></td>
     <td width="77"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>INTEGRADO</strong></font></div></td>
   </tr>
   <tr>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_baj?></font></div></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_bchs?></font></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_aoi?></font></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_rg?></font></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_ae?></font></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_gd?></font></td>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_i?></font></td>
   </tr>
               <? } ?>

   <tr>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Alumno Retirado </strong></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $bool_ar?></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Fecha Retiro </strong></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo Cfecha2($fecha_retiro)?></font></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
 </table>
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table> 
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td width="100"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Direcci&oacute;n</strong></font></td>
    <td width="105">&nbsp;</td>
    <td width="137">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $direccion_alu?></font></td>
    </tr>
  <tr>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Depto</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Block</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Villa/Poblaci&oacute;n</strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $depto?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $block?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $villa?></font></td>
  </tr>
  <tr>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Regi&oacute;n</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Provincia</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Comuna</strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $region?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $provincia?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $comuna?></font></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <?
	$sql_apo = "SELECT apoderado.rut_apo, apoderado.dig_rut, apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.telefono, apoderado.email, tiene2.responsable, apoderado.relacion ";
	$sql_apo = $sql_apo . "FROM tiene2 INNER JOIN apoderado ON tiene2.rut_apo = apoderado.rut_apo ";
	$sql_apo = $sql_apo . "WHERE (((tiene2.rut_alumno)=".$alumno.")); ";
	$result_apo = @pg_Exec($conn, $sql_apo);
	if (@pg_numrows($result_apo)>0)
	{
?>
    <tr> 
      <td colspan="3"><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>PADRES 
        Y APODERADOS </strong></font></td>
    </tr>
    <?	
}
	for($e=0 ; $e < @pg_numrows($result_apo) ; $e++)
	{
		$fila_apo = @pg_fetch_array($result_apo,$e);
		$rut_apo = $fila_apo['rut_apo'] . " - " . $fila_apo['dig_rut'];
		$nombre_apo = ucwords(strtolower($fila_apo['nombre_apo']));
		$ape_pat = ucwords(strtolower($fila_apo['ape_pat']));
		$ape_mat = ucwords(strtolower($fila_apo['ape_mat']));
		$telefono_apo = $fila_apo['telefono'];
		$email_apo = $fila_apo['email'];
		
		if ($fila_apo['responsable']==1)
			$relacion = "APODERADO - ";
		if ($fila_apo['relacion']==1)
			$relacion = $relacion."PADRE";
		if ($fila_apo['relacion']==1)
			$relacion = $relacion."MADRE";
		
?>
    <tr> 
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Rut</strong></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $rut_apo?></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Nombres</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Apellido Paterno </strong><strong> </strong></font></td>
      <td><strong><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1">Apellido Materno </font></strong></td>
    </tr>
    <tr> 
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $nombre_apo?></font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $ape_pat?></font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $ape_mat?></font></td>
    </tr>
    <tr> 
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Tel&eacute;fono</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>E-mail</strong></font></td>
      <td><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><strong>Relaci&oacute;n</strong></font></td>
    </tr>
    <tr> 
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $telefono_apo?></font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $email_apo?></font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $relacion?></font></td>
    </tr>
    <tr> 
      <td colspan="3"><hr width="100%" color=#003b85></td>
    </tr>
    <? } ?>
  </table>

 <? if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</center>

  <!-- FIN DEL CONTENIDO CENTRAL DE LA P�GINA -->
  
  
  
       <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
	  
	   
	   <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
								 
</body>
</html>
<? pg_close($conn);?>
<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
//	$periodo		=$c_periodo;
	$_POSP = 4;
	$_bot = 8;
	$empleado = $c_empleado;


?>		

<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAnotaciones.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>	

<?	//----------------------------------------------------------------------------
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	// Curso //
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------- PROFE JEFE
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------	
	//------------------FECHAS DE PERIODOS -----------------------
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


           <!-- INSERTO CUERPO DE LA PÁGINA -->

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	<tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr></tablE>
     
      </div></td>
     </tr>
</table>
   
<br>
<?
if($empleado != ""){
	if($empleado > 0)
	{

		$sql_alumno = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) and empleado.rut_emp = $empleado order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
	}
	else
	{
		$sql_alumno = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
	}	
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$cantidad_alumnos = @pg_numrows($result_alumno);
	$rut_ex[]="";
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		if (in_array($fila_alumno[rut_emp],$rut_ex)){}else{
		$rut_ex[]=$fila_alumno[rut_emp];
		$empleado = $fila_alumno['rut_emp'];
		$nombre = ucwords(strtoupper($fila_alumno['ape_pat'])) . " " . ucwords(strtoupper($fila_alumno['ape_mat'])) . " " . ucwords(strtoupper($fila_alumno['nombre_emp']));
?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>


	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
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
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
<? } ?>



<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE ANOTACIONES DEL PERSONAL </div></td>
    </tr>
  <tr>
</table>
<br>


<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="159"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nombre Empleado </strong></font></td>
          <td width="10"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td width="485"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nombre?></font></td>
        </tr>
  </table>
	 <br>
	 
	 <?
//******************* INASISTENCIA X ASIGNATURA *********************
$sql_asignatura = "select * from inasistencia_docente where rut_emp = '$empleado' and ano = '$ano'";
$res_asignatura = pg_Exec($conn, $sql_asignatura);
if (@pg_numrows($res_asignatura)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA INASISTENCIAS POR ASIGNATURAS</strong></center></font><br>";
else echo "<font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>INASISTENCIAS POR ASIGNATURA</strong></center></font><br>";
for($t=0 ; $t < @pg_numrows($res_asignatura) ; $t++)
{
	$fila_asignatura = @pg_fetch_array($res_asignatura,$t);
	$fecha_asig = $fila_asignatura['fecha'];
	$diaa = substr($fecha_asig,8,2);
	$mesa = substr($fecha_asig,5,2);
	$annoa = substr($fecha_asig,0,4);
	$fecha_asig = $diaa."-".$mesa."-".$annoa;
	$fecha_asig = fecha_espanol($fecha_asig);	
	$hora_asig = $fila_asignatura['hora'];
	$tipo_asig = $fila_asignatura['tipo'];
	$id_ramo_asig = $fila_asignatura['id_ramo'];	
	$sql_ramo = "	select r.cod_subsector, s.nombre 
					from ramo r, subsector s
					where r.id_ramo = '$id_ramo_asig' and r.cod_subsector = s.cod_subsector";
	$res_ramo = @pg_Exec($conn, $sql_ramo);
	$fila_ramo = pg_fetch_array($res_ramo);
	$ramo_asig = $fila_ramo['nombre'];
?>
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td><hr width="100%" color=#003b85></td>
		   </tr>
		 </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="50"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Dia:</strong></font></td>
			 <td width="140"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$fecha_asig;?></strong></font></td>
			 <td width="100"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$hora_asig." Hrs";?></strong></font></td>
			 <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>
			 	<? 	if($tipo_asig==1)echo "Tipo: Permiso Administrativo";
					if($tipo_asig==2)echo "Tipo: Licencia Medica";
					if($tipo_asig==3)echo "Tipo: Ausente";
					if($tipo_asig==4)echo "Tipo: Ausentes";			
				?></strong></font>
			 </td>
			 <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ramo_asig;?></strong></font></td>
		   </tr>
		 </table>	
<? }?>
	 
	 
	
	 
<? 
// *************************** INASISTENCIAS ********************
	$sql_anota = "select * from anotacion_empleado where rut_emp = '$empleado' and tipo = 2";
	$result_anota = @pg_Exec($conn, $sql_anota);
	if (@pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA INASISTENCIAS</strong></center></font><br>";
	else echo "<font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>INASISTENCIAS</strong></center></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		$fecha = $fila_anota[fecha];
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);		
		?>		
		
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td><hr width="100%" color=#003b85></td>
		   </tr>
		 </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el día:</strong></font></td><td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$fecha;?></strong></font></td>
		   </tr>
		 </table>
	<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<? 	
	$sql_anota = "select * from anotacion_empleado where rut_emp = '$empleado' and tipo = 1";
	$result_anota = @pg_Exec($conn, $sql_anota);
	if (@pg_numrows($result_anota)==0) echo "<br><br><font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA ATRASOS</strong></center></font><br>";
	else echo "<br><br><font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>ATRASOS</strong></center></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		$fecha = $fila_anota[fecha];
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);		
		?>		
		
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td><hr width="100%" color=#003b85></td>
		   </tr>
		 </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el día:</strong></font></td><td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$fecha;?></strong></font></td>
		   </tr>
		 </table>
	<? } ?>	
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
 }//asistencia

	} } 

 ?>
<br>
</center>

</body>
</html>
<? pg_close($conn);?>
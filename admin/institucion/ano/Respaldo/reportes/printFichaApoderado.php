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
				form.action = 'FichaApoderado.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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

	

	if($alumno==0){

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

		$SQL_Alu = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat ";
		$SQL_Alu = $SQL_Alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$SQL_Alu = $SQL_Alu . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
		$result_Alu =@pg_exec($conn,$SQL_Alu);
		
		$Curso_pal = CursoPalabra($curso, 0, $conn);

	}
	else{
		$SQL_Apoderado = "SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$alumno."";
		$result_Apoderado =@pg_exec($conn,$SQL_Apoderado);
		$fila_rut = @pg_fetch_array($result_Apoderado,0);
		$Rut_Apo = $fila_rut["rut_apo"];
		echo "<script>window.location = '../curso/alumno/apoderado/apoderado.php3?apoderado=".$Rut_Apo."&frmModo=reporte&institucion=".$institucion."&ano=".$ano."&curso=".$curso."&alumno=".$alumno."' </script>";
		 
	}
	


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso != 0){
 ?>
<center>
<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><div id="capa0">
					<table width="100%">
					  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
							<td align="right">
							  <input name="button3" type="button" class="botonXX"  value="IMPRIMIR"></td>
					  </tr></table>
							
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
			  <tr>
					<?
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					if 	(!empty($fila_foto['insignia']))
					{
						$output= "select lo_export(".$arr['insignia'].",'/opt/www/coeint/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);?>  
				<td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></div></td>
				<? }?>
				<td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $nombre_institu;?></strong></font></td>
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
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
	    <td  width="600" class="tableindex"><div align="center">LISTA DE APODERADOS</div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">Curso</font></strong></td>
					<td width="15"><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">:</font></strong></td>
					<td width="535"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><? echo $Curso_pal;?></font></td>
				</tr>
			</table>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td>
			<table width="600" border="1" cellspacing="0" cellpadding="0">
				<tr>
					<td><center><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">Apoderado</font></strong></center></td>
					<td><center><strong><font face="Verdana, Arial, Helvetica, sans-seri" size="1">Alumno</font></strong></center></td>
				</tr>
				
				<?
				for($i=0;$i<@pg_numrows($result_Alu);$i++){	
					$fila_alu = @pg_fetch_array($result_Alu,$i);
					$SQL_Apo = "SELECT apo.nombre_apo, apo.ape_pat as ape_pat_apo, apo.ape_mat as ape_mat_apo ";
					$SQL_Apo = $SQL_Apo ."FROM tiene2 INNER JOIN apoderado as apo ON tiene2.rut_apo=apo.rut_apo ";
					$SQL_Apo = $SQL_Apo ."WHERE rut_alumno=".$fila_alu["rut_alumno"]."";
					$result_Apo =@pg_exec($conn,$SQL_Apo);
					$fila_apo = @pg_fetch_array($result_Apo,0);
					
				?>
<!--					<tr bgcolor=#ffffff onmouseover="this.style.background='yellow';this.style.cursor='hand'"; onmouseout="this.style.background='transparent'" onClick="go('../curso/alumno/apoderado/seteaApoderado.php3?apoderado=<?php //echo trim($fila_apo["apo_rut_apo"]);?>&caso=1')"> -->
					<tr>
						<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1">&nbsp;&nbsp;<? echo ucwords(strtolower($fila_apo["nombre_apo"])) ." ". ucwords(strtolower($fila_apo["ape_pat_apo"])) ." ". ucwords(strtolower($fila_apo["ape_mat_apo"]));?></font></td>
						<td><font face="Verdana, Arial, Helvetica, sans-seri" size="1">&nbsp;&nbsp;<? echo ucwords(strtolower($fila_alu["nombre_alu"])) ." ". ucwords(strtolower($fila_alu["ape_pat"])) ." ".  ucwords(strtolower($fila_alu["ape_mat"])) ; ?></font></td>
					</tr>
				<?
				}
				?>
			</table>
		</td>
	</tr>		
</table>
</center>
  <?
}
?>  
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>
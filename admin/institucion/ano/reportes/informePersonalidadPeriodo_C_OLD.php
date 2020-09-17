<?php 	require('../../../../util/header.inc');
		include('../../../clases/class_Membrete.php');
		include('../../../clases/class_Reporte.php');

	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $cmb_curso;
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;
	$reporte	= $c_reporte;

	
	$fecha = strftime("%d %m %Y");
	$_POSP = 5;
	$_bot = 8;
	
	if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
	
	if ($cmb_curso){
		$curso=$cmb_curso;
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	}
	
	
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
<!--
function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.action = 'rpt19.php?institucion=$institucion';
		form.submit(true);

		}	
	}
			
</script>

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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


//-->
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg','<? echo $c; ?>botones/periodo_roll.gif','<? echo $c; ?>botones/feriados_roll.gif','<? echo $c; ?>botones/planes_roll.gif','<? echo $c; ?>botones/tipos_roll.gif','<? echo $c; ?>botones/cursos_roll.gif','<? echo $c; ?>botones/matricula_roll.gif','<? echo $c; ?>botones/informe_roll.gif','<? echo $c; ?>botones/reportes_roll.gif','<? echo $c; ?>botones/actas_roll.gif','<? echo $c; ?>botones/generar_roll.gif')">


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td height="589" align="left" valign="top">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
					<td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 

					<!-- DESDE ACÁ DEBE IR CON INCLUDE -->

					<table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
						<tr align="left" valign="top">
							<td height="75" valign="middle"><? include("../../../../cabecera/menu_superior.php");?></td>
						</tr>
					</table>
					</td>
				</tr>
				<tr align="left" valign="top"> 
					<td>
						<table width="100%"  border="0" cellpadding="0" cellspacing="0">
							<tr> 
								<td width="27%"  align="left" valign="top"><? $menu_lateral=3;	?><? include("../../../../menus/menu_lateral.php");?></td>
								<td width="73%" align="left" valign="top">

<? ///////////////////////////      DESDE AQUI ES LO UTIL DESDE AHORA  ///////////////////////////////////////////////?>

<form action="printInformePersonalidadPeriodo_C.php" name="form" target="_blank">
<? 

$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);

//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>			
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="100%" class="tableindex">Buscador Avanzado</td>
								</tr>
								<tr>
									<td class="cuadro01"> A&ntilde;o Escolar<br>
										<?
										$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
										$result =@pg_Exec($conn,$qry);
										if (!$result) {
											error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
										}else{
											if (pg_numrows($result)!=0){
												$filann = @pg_fetch_array($result,0);	
												if (!$filann){
													error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
													exit();
												}
											} ?>
										<input type="hidden" name="frmModo2" value="<?=$frmModo ?>">
										<select name="cmb_ano" class="ddlb_x" id="cmb_ano"  onChange="window.location='InformePersonalidadPeriodo_C.php?cmb_ano='+this.value;">
										<option value=0 selected>(Seleccione un A&ntilde;o)</option>
										<?		for($i=0;$i < @pg_numrows($result);++$i){
													$filann = @pg_fetch_array($result,$i); 
													$id_ano  = $filann['id_ano'];  
													$nro_ano = $filann['nro_ano'];
													$situacion = $filann['situacion'];
													if ($situacion == 0){
														$estado = "Cerrado";
													}
													if ($situacion == 1){
														$estado = "Abierto";
													}	 	 
													if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
														echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
													}else{	    
														echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
													}
													} ?>
										</select>
										<? }	?>
									</td>
								</tr>
								<tr>
									<td  class="cuadro01"><br>Curso<font size="1" face="arial, geneva, helvetica"><br>
									<? if($_PERFIL == 17){ ?>
										<select name="cmb_curso"  class="textosimple" id="cmb_curso" onChange="window.location='InformePersonalidadPeriodo_C.php?cmb_curso='+this.value;">
										<option value=0 selected>(Seleccione Curso)</option>
										<? 
										for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
											$fila = @pg_fetch_array($resultado_query_cue,$i); 
											if($fila["id_curso"]==$_CURSO){
												if($fila["id_curso"]==$cmb_curso){
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
												}else{
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
												}
											}	
										} ?>
										</select>
									<? }else{ ?> 					
										<select name="cmb_curso"  class="textosimple" id="cmb_curso" onChange="window.location='InformePersonalidadPeriodo_C.php?cmb_curso='+this.value;">
										<option value=0 selected>(Seleccione Curso)</option>
										<?	for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){
												$fila = @pg_fetch_array($resultado_query_cue,$i); 
												if ($fila["id_curso"]==$cmb_curso){
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
												}else{
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
												}
											} ?>
										</select>
									<? } ?>
										</font>
									</td>
								</tr>
								<tr>
									<td  class="cuadro01"><br>Alumno<br>
									<select name="cmb_alumno" class="textosimple" id="cmb_alumno">
									<option value=0 selected>(Todos los alumnos)</option>
									<? $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
									$result= @pg_Exec($conn,$sql);
									if ($cmb_curso!=0){
									for($i=0 ; $i < @pg_numrows($result) ; ++$i){
									$fila = @pg_fetch_array($result,$i);
									if ($fila["rut_alumno"] == $cmb_alumno){ ?>
									<option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
								<? }else{	    ?>
									<option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
									<?  		    }
									}
									}?>
									</select></td>
								</tr>
								<tr>
									<td  class="cuadro01"><br>Per&iacute;odo<br>
									<select name="periodo" class="textosimple" id="periodo">
									<option value=0 selected>(Seleccione Periodo)</option>
									<? for($i=0 ; $i < @pg_numrows($result_peri) ; ++$i){
											$filaP = @pg_fetch_array($result_peri,$i); 
											if ($filaP["id_periodo"]==$periodo){
												echo "<option selected value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
											}else{
												echo "<option value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
											}
										} ?>
									</select>
									</td>
								</tr>	
								<tr>
									<td  class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
									<? if($_PERFIL==0){?>		  
									<input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
									<? }?>	
									</td>
								</tr>
							</table> 
						</form>
				</td>
				</tr>
				<tr align="center" valign="middle"> 
					<td height="12" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</td>
		<td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
	</tr>
	</table>
</body>
</html>
<? pg_close($conn); ?>
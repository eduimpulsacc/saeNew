<?  
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

//setlocale("LC_ALL","es_ES");
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
				form.action = 'ActaDeCalificacionCara.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//echo "<h1>$ano</h1>";
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	
	
	
	if ($dia == ""){
	   ## si el campo esta vac�o poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
	}   
	
	
	
	//if ($curso==0) {exit;}
	
	//------------------------
	// A�o Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	//echo $sql_ano;
	
	$result_ano =pg_Exec($conn,$sql_ano);
	$fila_ano = pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, date_part('year',institucion.fecha_resolucion)as fecha_res, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.nu_resolucion ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$rdb = $institucion."-".$fila_ins['dig_rdb'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];
	$resolucion = $fila_ins['nu_resolucion'];
	$fecha_res = $fila_ins['fecha_res'];
	$comuna = $fila_ins['nom_com'];
	$ciudad = $fila_ins['nom_pro'];
	$region= $fila_ins['nom_reg'];
	//-------
	$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es ";
	$sql_curso = $sql_curso . "from curso, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval ";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$curso_pal = $fila_curso['grado_curso']."-".$fila_curso['letra_curso'];
	$grado_curso = $fila_curso['grado_curso'];
	$tipo_ensenanza = $fila_curso	['nombre_tipo'];
	$plan_estudio =  $fila_curso['nombre_decreto'];
	$decreto_eval =  $fila_curso['nombre_decreto_eval'];
	$ense = $fila_curso['ensenanza'];
	$cod_es = $fila_curso['cod_es'];
	//-------------------------
	if ($ense>309 and $grado_curso>2){
		$sql_espe = "select * from especialidad where cod_esp = $cod_es";
		$result_espe =@pg_Exec($conn,$sql_espe);
		$fila_espe = @pg_fetch_array($result_espe,0);	
		$especialidad = ucwords(strtolower(", ".$fila_espe['nombre_esp']));
	}
	//--------------------------------	
	//---------
	if (($grado_curso==1 or $grado_curso==2) and $ense == 110) $nb = "NB1";
	if (($grado_curso==3 or $grado_curso==4) and $ense == 110) $nb = "NB2";	
	if (($grado_curso==5) and $ense == 110) $nb = "NB3";
	if (($grado_curso==6) and $ense == 110) $nb = "NB4";
	if (($grado_curso==7) and $ense == 110) $nb = "NB5";
	if (($grado_curso==8) and $ense == 110) $nb = "NB6";
	//-------
	if (($grado_curso==1) and $ense > 300 ) $nb = "NM1";
	if (($grado_curso==2) and $ense > 300 ) $nb = "NM2";
	if (($grado_curso==3) and $ense > 300 ) $nb = "NM3";
	if (($grado_curso==4) and $ense > 300 ) $nb = "NM4";	
	//-------
	$sql_alumnos = "select upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))";
	$sql_alumnos = $sql_alumnos . "order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos);
	
	/*$sql_alumnos = "select upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 and matricula.fecha_retiro > '".$ano_escolar."-04-30') or ((matricula.bool_ar=0)or(matricula.bool_ar isnull)))";
	$sql_alumnos = $sql_alumnos . "order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos); */
	
//---------
//------------ PROFESOR  JEFE ---------------
$qry = "";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=" . $cmb_curso ."))";
$Rs_Profe =@pg_exec($conn,$qry);
$fila_Profe = @pg_fetch_array($Rs_Profe,0);
$Nombre_Profe = trim($fila_Profe['nombre_emp'])." ".trim($fila_Profe['ape_pat'])." ".trim($fila_Profe['ape_mat']);
//--------
//----------- DIRECTOR ----------------------
$qry="";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=" . $institucion . ") and cargo=1)";
$Rs_Dir	= @pg_exec($conn,$qry);
$fila_Dir = @pg_fetch_array($Rs_Dir,0);
$Nombre_Dir = trim($fila_Dir['nombre_emp'])." ".trim($fila_Dir['ape_pat'])." ". trim($fila_Dir['ape_mat']);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>/
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso != 0){
  ?>

<div align="right">
<div id="capa0">
<table width="1075" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><font face="Arial, Helvetica, sans-serif" size="-1" color="#000066"><strong>ESTE INFORME DEBE IMPRIMIRSE EN HOJA TAMA&Ntilde;O OFICIO</strong></font>
		</td>
        <td align="right"><div id="capa0">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printActaDeCalificacionCara_d.php?cmb_curso=<?=$cmb_curso ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano2=<?=$ano2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div></td>
      </tr>
  </table>
</div>
      <table width="1075"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="145" rowspan="4" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REP&Uacute;BLICA DE CHILE</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> MINISTERIO DE EDUCACI&Oacute;N</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> DIVISI&Oacute;N DE EDUCACI&Oacute;N </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SECRETARIA REGIONAL </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MINISTERIAL</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>DE EDUCACI&Oacute;N </strong></font></td>
          <td width="10" rowspan="4" align="left">&nbsp;</td>
          <td width="693" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ACTA DE CALIFICACIONES FINALES Y PROMOCI&Oacute;N ESCOLAR </strong></font></td>
          <td width="252" colspan="2" rowspan="4" align="left" valign="top"><table width="100%"  border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center"><span class="cuadro01"><u><? echo $region ?></u></span></td>
                      <td align="center"><span class="cuadro01"><u><? echo $ciudad ?></u></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="cuadro01">REGI&Oacute;N</span></td>
                      <td align="center"><span class="cuadro01">PROVINCIA</span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="cuadro01"><u><? echo $comuna ?></u></span></td>
                      <td align="center"><span class="cuadro01"><u><? echo $ano_escolar ?></u></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="cuadro01">COMUNA</span></td>
                      <td align="center"><span class="cuadro01">A&Ntilde;O ESCOLAR </span></td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="center" valign="top" class="cuadro02">Curso<? echo $curso_pal . " " . $nb?></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong><? echo $tipo_ensenanza . $especialidad?></strong></font></td>
        </tr>
        <tr>
          <td align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong><? echo $ins_pal ?></strong></font></td>
        </tr>
        <tr>
          <td valign="top"  align="left"><font face="Arial, Helvetica, sans-serif" size="1">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N DECRETO <u>N� <? echo $resolucion?> del <? echo $fecha_res ?> </u>ROL BASE DE DATOS <u>N�<? echo $rdb?> </u>PLAN DE ESTUDIOS APROBADOS POR DECRETO <u>N� <? echo $plan_estudio?></u> Y DEL REGLAMENTO DE EVALUACI�N Y PROMOCION ESCOLAR DECRETO EXENTO <u>N� <? echo $decreto_eval?></u></font></td>
        </tr>
      </table>

      <table width="1075"  border="1" cellspacing="0" cellpadding="0">
        <tr class="cuadro02">
          <td>&nbsp;</td>
          <td valign="top" class="cuadro02">NOMINA DE ALUMNOS </td>
          <td class="cuadro02" valign="top">RUN</td>
          <td class="cuadro02" valign="top" width="20">COD RUN </td>
          <td class="cuadro02" valign="top" width="27">SEXO</td>
          <td class="cuadro02" valign="top" width="40">FEC NAC </td>
          <td class="cuadro02" valign="top">COMUNA RESIDENCIA </td>
          <?
// nuevo2
		$sql_aprox = "SELECT truncado_per FROM curso WHERE id_curso=".$curso."";		  
		$rs_aprox = pg_Exec($conn,$sql_aprox);
		$fil_aprox = pg_fetch_array($rs_aprox,0);
		if($institucion==9566){
			$aprox = 0;
		}
		else{
			$aprox = $fil_aprox['truncado_per'];
		}
// fin nuevo2

   
	$sql_subsectores = "select * from subsector_ramo where id_curso = ".$curso." and (bool_ip = 1 or cod_subsector = 13) order by id_orden";
	$rsSubsectores=@pg_Exec($conn,$sql_subsectores);
			
	$cantidad_subsectores = @pg_numrows($rsSubsectores);
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
//****VEL*** busca los subsectores formulas
		$sql_formula = "select * from formula where id_ramo = '$id_ramo'";
		$res_formula = pg_Exec($conn,$sql_formula);
	    if(pg_numrows($res_formula)!=0){
			$fila_formula = pg_fetch_array($res_formula);
			$id_formula = $fila_formula['id_formula'];
			$sql_form_hijo = "select * from formula_hijo where id_formula = '$id_formula'";
			$res_form_hijo = pg_Exec($conn,$sql_form_hijo);
			if(pg_numrows($res_form_hijo)!=0)
			{
				pg_numrows($res_form_hijo);
				for($f=0; $f<=pg_numrows($res_form_hijo); $f++)
				{
					$fila_hijo = pg_fetch_array($res_form_hijo);
					$arreglo_hijo[] = $fila_hijo['id_hijo'];				
				}			
			}
		}//***VEL***
	}
//*****SE repite la condicion pero ahora muestra solamente los padres de los subsectores formulas
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];	
		$largo = strlen($arreglo_hijo);
		$existe = 0;
		for($h=0;$h<=$largo;$h++)
		{
			$id_hijo = $arreglo_hijo[$h];
			if($arreglo_hijo[$h] == $id_ramo)
			{
				$existe = 1;				
			}
		}
		if($existe == 0){
			if($cod_subsector!=13){?>
          <td class="cuadro02" valign="top"><? echo $cod_subsector?></td>
          <? }
		 }
	}//***VEL***?>
          <td align="center" valign="top"><img src="promedio-general.gif" width="11" height="61"></td>
    <? 
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
		
	
			if($cod_subsector==13){
				$religion=$id_ramo;	?>
          <td class="cuadro02" valign="top"><? echo $cod_subsector?></td>
          <? }}?>
    
	      <td align="center" valign="top"><img src="asistencia.gif"></td>
          <td align="center" valign="top"><img src="situacion-final.gif" width="11" height="59"></td>
          <td class="cuadro02" valign="top">OBSERVACIONES</td>
        </tr>
        <?
  	if (@pg_numrows($rsAlumnos)<30)
	  $espacio_lineas = 15;
  	if (@pg_numrows($rsAlumnos)>29)
	  $espacio_lineas = 5;
	for($i=0 ; $i < @pg_numrows($rsAlumnos) ; $i++)
	{
		$fAlumno = @pg_fetch_array($rsAlumnos,$i);
		$alumno = trim($fAlumno['rut_alumno']);
		$curso = $fAlumno['id_curso'];
		$sql_promocion = "select promedio, asistencia, situacion_final, observacion from promocion where rut_alumno = ".$alumno." and id_curso = ".$curso;
		$rsPromocion=@pg_Exec($conn,$sql_promocion);
		$fPromocion = @pg_fetch_array($rsPromocion,0);	
		$promedio = $fPromocion['promedio'];
		if (!empty($promedio)) $promedio = substr($promedio,0,1).".".substr($promedio,1,1); else $promedio = "&nbsp;";
		if (!empty($fPromocion['asistencia'])) $asistencia = $fPromocion['asistencia']."%"; else $asistencia = "&nbsp;";
		$situacion_final = $fPromocion['situacion_final'];
		if ($situacion_final==1) $situacion_final = "P";
		if ($situacion_final==2) $situacion_final = "R";
		if ($situacion_final==3) $situacion_final = "Y";
		if (!empty($fPromocion['observacion'])) $observacion = $fPromocion['observacion']; else $observacion = "&nbsp;";
  ?>
        <tr class="cuadro01">
          <td height=<? echo $espacio_lineas?>><? echo $i+1 ?></td>
          <td ><? echo trim($fAlumno['ape_pat']) . " " . trim($fAlumno['ape_mat'] ). " " . trim($fAlumno['nombre_alu']) ?></td>
          <td ><? echo $fAlumno['rut_alumno'] ?></td>
          <td ><? echo $fAlumno['dig_rut']."&nbsp;" ?></td>
          <td ><?  if ($fAlumno['sexo']==1){ echo "2"; }else{ echo "1";} ?></td>
          <td ><? echo Cfecha2($fAlumno['fecha_nac']) ?></td>
          <td ><? echo $fAlumno['nom_com'] ?></td>
          <?

		$sql_formula = "select * from formula where id_ramo = '$id_ramo'";
		$res_formula = pg_Exec($conn,$sql_formula);
	    if(pg_numrows($res_formula)!=0){
			$fila_formula = pg_fetch_array($res_formula);
			$id_formula = $fila_formula['id_formula'];
			$sql_form_hijo = "select * from formula_hijo where id_formula = '$id_formula'";
			$res_form_hijo = @pg_Exec($conn,$sql_form_hijo);
			if(@pg_numrows($res_form_hijo)!=0)
			{
				for($f=0; $f<=@pg_numrows($res_form_hijo); $f++)
				{
					$fila_hijo = pg_fetch_array($res_form_hijo);
					$arreglo_hijo[] = $fila_hijo['id_hijo'];				
				}			
			}
		}
			  
		  
	for($e=0 ; $e < $cantidad_subsectores ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);

//***VEL***		
		$largo = strlen($arreglo_hijo);
		$existe = 0;
		for($h=0;$h<=$largo;$h++)
		{
			$id_hijo = $arreglo_hijo[$h];
			if($arreglo_hijo[$h] == $id_ramo)
			{
				$existe = 1;				
			}
		}		
		
//***VEL***		
		if ($fEximido['cantidad']>0){
			if ($conex==1){
							
				$sql_notas = "select * from situacion_final where id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
				$rsNotas=@pg_Exec($conn,$sql_notas);
				$fNotas= @pg_fetch_array($rsNotas,0);
				if ($fNotas['nota_final']>0) $promedio_nota = $fNotas['nota_final']; else $promedio_nota = "&nbsp;";
			}else{			
				
				$sql_notas = "select promedio from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
				$rsNotas=@pg_Exec($conn,$sql_notas);				
				$suma_promedios = 0; $con_notas = 0;
				for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
				{
					$fNotas = @pg_fetch_array($rsNotas,$u);
									
					if ($modo_eval==1 or $_modo_eval==0){//numerico //caso que este null, lo setea como n�merico.
					
						$suma_promedios = $suma_promedios + $fNotas['promedio'];
						
						if ($fNotas['promedio']>0){
						    $con_notas = $con_notas + 1;
						}
					}else{
						$suma_promedios = $suma_promedios + Conceptual($fNotas['promedio'],2);
						if (Conceptual($fNotas['promedio'],2)!=""){
						    $con_notas = $con_notas + 1;
						}	
						
										
					}
					
					
					
				}
				if ($modo_eval==1 or $modo_eval==0){
					if ($suma_promedios>0){
					    
						if($aprox==0){
									$promedio_nota=intval($suma_promedios/$con_notas);
										
						}
						elseif($aprox==1){
									$promedio_nota=round($suma_promedios/$con_notas);
									
						}
						$promedio_nota = substr($promedio_nota,0,1).".".substr($promedio_nota,1,1);
					}else{
						$promedio_nota = "&nbsp;";
					}
				}
				else
				{
					if ($con_notas>0){ 				
						$promedio_nota = Conceptual(round($suma_promedios/$con_notas,0),1);
						//if ($promedio_nota=="I")
							//$promedio_nota = "&nbsp;";
					}
				}
			}
		}else{
			if ($fSubsectores['sub_obli']==1)
				$promedio_nota = "EX";
			else
				$promedio_nota = "&nbsp;";
		}
//***VEL*** Muestro solo si existe		
		if($existe == 0){
			if($cod_subsector!=13){?>
                <td align="center" ><? 
				     if ($situacion_final <> "Y") echo $promedio_nota; else echo "&nbsp;"; ?></td>
          <? }
		  }
		 } ?>
          <td align="center"><? if ($situacion_final <> "Y") echo $promedio; else echo "&nbsp;"; ?>&nbsp;</td>
     
	 
	     <?  for($e=0 ; $e < $cantidad_subsectores ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);		
		if ($fEximido['cantidad']>0){
			if ($conex==1){
				$sql_notas = "select * from situacion_final where id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
				$rsNotas=@pg_Exec($conn,$sql_notas);
				$fNotas= @pg_fetch_array($rsNotas,0);
				if ($fNotas['nota_final']>0) $promedio_nota = $fNotas['nota_final']; else $promedio_nota = "&nbsp;";
			}else{
				$sql_notas = "select promedio from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
				$rsNotas=@pg_Exec($conn,$sql_notas);				
				$suma_promedios = 0; $con_notas = 0;
				$promedio_num = 0;
				for($u=0 ; $u < @pg_numrows($rsNotas) ; $u++)
				{
					$fNotas = @pg_fetch_array($rsNotas,$u);
					if ($modo_eval==1 or $modo_eval==0){//numerico
						$suma_promedios = $suma_promedios + $fNotas['promedio'];
						if ($fNotas['promedio']>0){
						$con_notas = $con_notas + 1;
						}
					}else{
						$suma_promedios = $suma_promedios + Conceptual($fNotas['promedio'],2);
						if (Conceptual($fNotas['promedio'],2)!=""){
						$con_notas = $con_notas + 1;
						}						
					}
				}
				if ($modo_eval==1 or $modo_eval==0){
					if ($suma_promedios>0){ 
								if($aprox==0){
									$promedio_nota=intval($suma_promedios/$con_notas);	
								}
								elseif($aprox==1){
									$promedio_nota=round($suma_promedios/$con_notas);	
								}


						$promedio_nota = substr($promedio_nota,0,1).".".substr($promedio_nota,1,1);
					}
					else
					{
						$promedio_nota = "&nbsp;";
					}
				}
//				else
				elseif($modo_eval==2)
				{
					if ($con_notas>0){ 				
//						$promedio_nota = Conceptual(round($suma_promedios/$con_notas,0),1);
						$promedio_nota = Conceptual(intval($suma_promedios/$con_notas),1);
						//if ($promedio_nota=="I")
							//$promedio_nota = "&nbsp;";
					}
				}
// nuevo				
				elseif($modo_eval==3)
				{
				$sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; $g++)
					{
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}
					}
					
					
					 /// nuevo c�digo para sacar el promedio correcto de religion 
						$sql_1 = "select promedio from notas$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo;
						$res_1 = @pg_Exec($conn,$sql_1);
						$num_1 = @pg_numrows($res_1);
						for ($ii=0; $ii < $num_1; $ii++){
						    $fil_1 = @pg_fetch_array($res_1,$ii);
							$prom_per = $fil_1['promedio'];
							$prom_per = Conceptual($prom_per,2);
							
							$promedio_num = $promedio_num + $prom_per;
						}
												
						$promedio_ramo = Promediar($promedio_num,$num_1,0);
					
					
					if($aprox==0){
						$promedio_nota=@Conceptual(intval($prom/$con_notas),1);	
					}
					elseif($aprox==1){
						$promedio_nota=@Conceptual(round($prom/$con_notas),1);	
					}
					
					
					/// como es modo de evaluacion 3 debo convertir el promedio a conceptual
					if ($promedio_ramo > 0 and $promedio_ramo < 40){
						$promedio_nota = "I";
					}
					if ($promedio_ramo > 39 and $promedio_ramo < 50){
						$promedio_nota = "S";
					}
					if ($promedio_ramo > 49 and $promedio_ramo < 60){
						$promedio_nota = "B";
					}
					if ($promedio_ramo > 59 ){
						$promedio_nota = "MB";
					}				
					
					//$promedio_nota = Conceptual($promedio_nota,2);
					///////////////////////////////////////////////////////////////////////////
					
					
					
				}				
// fin nuevo				
			}
		}else{
			if ($fSubsectores['sub_obli']==1)
				$promedio_nota = "EX";
			else
				$promedio_nota = "EX"; // cambio solicitado por el coyancura
		}
		if($cod_subsector==13){ ?>
             <td align="center" >
			 <? if ($situacion_final <> "Y"){
			         if ($_INSTIT==9566){
					    					 
						 $promedio_nota = Conceptual($promedio_nota , 1);					 
			             echo $promedio_nota;
						 
					 }else{
					     echo $promedio_nota;
					 
					 }	 
			    }else{
				     echo "&nbsp;";
				}
			   ?></td>
   <? }} ?>
		  <td align="center"><? if ($situacion_final <> "Y") echo $asistencia; else echo "0%"; ?>&nbsp;</td>
          <td align="center"><? echo $situacion_final ?>&nbsp;</td>
          <td><? echo $observacion."&nbsp;"; ?></td>
        </tr>
        <? } ?>
      </table>
<table width="1074" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left">	  <font face="Arial, Helvetica, sans-serif" size="-2">
	  C�digos :        Promovido= P       Reprobado =  R       Retirado =  Y					Masculino = 1   -   Femenino = 2 *******
	  Nota :   El Subsector de Religi�n no tiene incidencia en su promedio general de calificaciones ni en la situaci�n final del alumno.															
	  </font></td>
  </tr>
</table>	  
      <?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
      <table width="1075" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1075" align="left" valign="top">&nbsp;
              <table width="1075" border="1" cellspacing="0" cellpadding="0">
                <tr valign="top">
                  <td width="52" class="cuadro02" >COD</span></td>
                  <td width="140" class="cuadro02">SUBSECTOR</span></td>
                  <td width="375" class="cuadro02">NOMBRES Y APELLIDOS DEL PROFESOR </span></td>
                  <td width="123" class="cuadro02">RUN</span></td>
                  <td width="147" class="cuadro02">TITULADO / HABILITADO </span></td>
                  <td width="224"class="cuadro02">FIRMA</span></td>
                </tr>
                <?
				$id_ramo = $fSubsectores['id_ramo'];				
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
				$titulo="";
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sql_dicta = "select empleado.rut_emp, empleado.dig_rut, empleado.ape_pat,empleado.ape_mat, empleado.nombre_emp, empleado.tipo_titulo, 
						empleado.nu_resol,empleado.habilitado,empleado.titulado,empleado.tit_otras,empleado.habilitado_para, empleado.titulo, ";
		$sql_dicta = $sql_dicta . "empleado.fecha_resol ";
 		$sql_dicta = $sql_dicta . "from dicta, empleado ";
		$sql_dicta = $sql_dicta . "where dicta.id_ramo = ".trim($id_ramo)." ";
		$sql_dicta = $sql_dicta . "and   dicta.rut_emp = empleado.rut_emp ";
	//	echo $sql_dicta;
		$rsDicta=pg_Exec($conn,$sql_dicta);
		$titulo="";
		$fDicta= @pg_fetch_array($rsDicta,0);
		if ($fDicta[rut_emp]){
		$query_dicta="select * from nivel_empleado where  id_curso='$curso' and id_ramo='$id_ramo' and rut_emp=$fDicta[rut_emp]";
		//echo "<br>".$query_dicta."<br>";
		$result_dicta=pg_exec($conn,$query_dicta);
		$num_dicta=pg_numrows($result_dicta);
		}
		
		
		if ($num_dicta>0){
			$row_dicta=pg_fetch_array($result_dicta);
			//imprime_array($row_dicta);
			$nivel_temp=$row_dicta[nivel];
			if ($nivel_temp==1){$titulo = "H / Res N� ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);}
			if ($nivel_temp==2){$titulo="T";}
			if ($nivel_temp==3){$titulo="T";}
		}
		
		
		
		
		//// NUEVO CODIGO PARA DETERMINAR SI ES HABILITADO O NO   ///////		
		$rsDicta=pg_Exec($conn,$sql_dicta);
		$titulo=NULL;
		$fDicta= @pg_fetch_array($rsDicta,0);
			if ($fDicta[habilitado]==1){
				$arreglo_temp=unserialize($fDicta[habilitado_para]);
			/*	echo "<pre>";
				print_r($arreglo_temp);
				echo "</pre>";*/
				if (in_array($cod_subsector,$arreglo_temp) and $fDicta['fecha_resol']!=NULL){
					$titulo = "H / Res N� ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);
				}
				
			}		
		/// nuevo cambio para que salga titulado o habilitado //	
		if ($titulo==NULL){
			if (($fDicta[titulado]==1)){
				$titulo = "T";
				   
			}
			if (($fDicta[tit_otras]==1)){
				   
				$titulo = "T"; 
			}
		}	
		/*if (($fDicta[titulo]==1)){
			$titulo = "T";
			
		}*/
			
		/*
		if ((!$titulo)&&($fDicta[titulado]==1)){
			$titulo = "T"; 
		}
		if ((!$titulo)&&($fDicta[tit_otras]==1)){
			$titulo = "T"; 
		}*/
				
		//// FIN NUEVO CODIGO  /////
			
		
		
		
		
		if ($titulo==NULL){ $titulo = "Indeterminado"; }	
?>
                <tr>
                  <td class="cuadro01"><? echo $fSubsectores['cod_subsector'] ?></td>
                  <td class="cuadro01"><? echo $fSubsectores['nombre'] ?></td>
                  <td class="cuadro01"><? echo strtoupper(trim($fDicta['ape_pat']." ".$fDicta['ape_mat']." ".$fDicta['nombre_emp'])) ?></td>
                  <td class="cuadro01"><? echo $fDicta['rut_emp']."-".$fDicta['dig_rut'] ?></td>
                  <td class="cuadro01"><? echo $titulo ?></td>
                  <td>&nbsp;</td>
                </tr>
                <? }?>
              </table>
              <ul>
                <li><br>
                    <?
//------------------ TOTAL MATRICULA INICIAL AL 30-04 HOMBRE
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_inicial_hombre = $fila2['cantidad'];
//------------------			  
//------------------ TOTAL MATRICULA INICIAL AL 30-04 MUJER
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1  and matricula.fecha < '$ano_escolar-05-01' ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_inicial_mujer = $fila2['cantidad'];
//------------------			  
//------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1� Mayo y 29 Noviembre
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_1_hombre = $fila2['cantidad'];
//------------------
//------------------ TOTAL MATRICULA MUJERES Ingresos entre el 1� Mayo y 29 Noviembre
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . " ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matricula_1_mujer = $fila2['cantidad'];
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1� de mayo y el 29 de noviembre - HOMBRES
//----------------------------------------------------------------
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados1 = $fila2['cantidad'];
//----------------------------------------------------------------	
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1� de mayo y el 29 de noviembre - MUJERES
//----------------------------------------------------------------
$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro  > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados2 = $fila2['cantidad'];
//----------------------------------------------------------------	
//------------------

$sql="";
$sql = "select count(*) as cantidad from matricula where id_curso = ".$curso." and matricula.fecha < '12-01-".($ano_escolar)."' and id_ano = ".$ano . " and matricula.bool_ar=0 " ;
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados = $fila2['cantidad'];	

/*$sql="";
$sql = "select count(*) as cantidad from matricula where id_curso = ".$curso." and matricula.fecha < '".($ano_escolar)."-12-01' and id_ano = ".$ano . " and ((matricula.bool_ar=0)or(matricula.bool_ar isnull)) " ;
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados = $fila2['cantidad'];	*/
//------------------
//------------------ MATRICULADOS HOMBRES

$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_hombre = $fila2['cantidad'];	

/*$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$ano_escolar."-12-01' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and ((matricula.bool_ar=0)or(matricula.bool_ar isnull))";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_hombre = $fila2['cantidad'];	*/
//------------------
//------------------ MATRICULADOS MUJERES

$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_mujer = $fila2['cantidad'];


/*$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$ano_escolar."-12-01' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and ((matricula.bool_ar=0)or(matricula.bool_ar isnull))";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_mujer = $fila2['cantidad'];	*/

//------------------ PROMOVIDOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados = $fila2['cantidad'];
//------------------
//------------------ PROMOVIDOS HOMBRE
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados_hombre = $fila2['cantidad'];
//------------------
//------------------ PROMOVIDOS MUJERES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$aprobados_mujer = $fila2['cantidad'];
//------------------ REPROVADOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados = $fila2['cantidad'];
//------------------

//------------------ REPROVADOS HOMBRES INASISTENCIA
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_hombre = $fila2['cantidad'];
//------------------
//------------------ REPROVADOS MUJERES INASISTENCIA
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_mujer = $fila2['cantidad'];
//------------------ REPROVADOS HOMBRES RENDIMIENTO
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_hombre1 = $fila2['cantidad'];
//------------------
//------------------ REPROVADOS MUJERES RENDIMIENTO
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$reprovados_mujer1 = $fila2['cantidad'];

//------------------ RETIRADOS
$sql="";
$sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 ";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados= $fila2['cantidad'];
//------------------
//------------------ RETIRADOS HOMBRES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados_hombre = $fila2['cantidad'];
//------------------
//------------------ RETIRADOS MUJERES
$sql="";
$sql = "select count(promocion.rut_alumno) as cantidad from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$retirados_mujer = $fila2['cantidad'];
//------------------
?>
                </li>
              </ul>
              <table width="778" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="171" bordercolor="#000000" class="cuadro02">RESULTADO GENERAL DEL CURSO</td>
                  <td align="center" bordercolor="#000000" class="cuadro02">M</td>
                  <td align="center" bordercolor="#000000" class="cuadro02">F</td>
                  <td align="center" bordercolor="#000000" class="cuadro02">TOTAL</td>
                  <td width="27">&nbsp;</td>
                  <td width="144">&nbsp;</td>
                  <td width="4">&nbsp;</td>
                  <td width="152">&nbsp;</td>
                  <td width="13">&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="cuadro01">MATRICULA:</span></td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="cuadro01">
                  <td bordercolor="#000000">Matr�cula 30 Abril (inicial)</td>
                  <td align="center" bordercolor="#000000"><? echo $matricula_inicial_hombre  ?></td>
                  <td align="center" bordercolor="#000000"><? echo $matricula_inicial_mujer?></td>
                  <td align="center" bordercolor="#000000"><? echo $matricula_inicial_hombre+$matricula_inicial_mujer ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="cuadro01">Ingresos entre el 
              1� Mayo y 29 Noviembre</span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $matricula_1_hombre ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $matricula_1_mujer ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $matricula_1_hombre +  $matricula_1_mujer?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="cuadro01">Retirados entre 1 � 
              Mayo y 29 Noviembre</span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $retirados1 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $retirados2 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="cuadro01"><? echo $retirados1 + $retirados2 ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="cuadro01"></span><span class="cuadro01">Matr�cula 30 Noviembre (final) </span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center">__________________</td>
                  <td>&nbsp;</td>
                  <td align="center">___________________</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="cuadro01">Promovidos</span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $aprobados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $aprobados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $aprobados ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="cuadro01">ENCARGADO CONFECCI&Oacute;N DEL ACTA </span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="cuadro01"><? echo strtoupper($Nombre_Profe);?><br>PROFESOR JEFE </span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="cuadro01">Reprobados por Inasistencia</span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre + $reprovados_mujer ?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="cuadro01">Reprobados por Rendimiento</span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center">________________________</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="cuadro01">Total Reprobados </span></td>
                 <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre + $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_mujer + $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $reprovados_hombre + $reprovados_mujer + $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><span class="cuadro01">
				  <?php if ($institucion == 9566){
							echo "PAVEZ MENESES ROBERTO";
						} 
						if ($institucion == 24511){
							echo "MARCELO MEZA GOTOR";
						} 						
						else {
 							 echo strtoupper($Nombre_Dir); }
					?><br>JEFE ESTABLECIMIENTO </span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
            </table></td>
        </tr>
    </table>
	<table width="1074" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left"><span class="cuadro01">OBSERVACIONES:______________________________________________________________________________________________________________________________________________</span></td>
  </tr>
  <tr>
    <td align="left"><span class="cuadro01">_______________________________________________________________________________________________________________________________________________________________</span></td>
  </tr>
  <tr>
    <td align="right"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($comuna)).", ".$dia." de ".$mes." del ".$ano2 ?></font></td>
    </tr>  
</table>

      </table>
      <?
//echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
<!--  Comentado tabla de subsectores.  motivo: paulina lo pidio explicacion : el MINEDUC no lo pide
<div align="center">
<font face="Arial, Helvetica, sans-serif"><strong>TABLA DE SUBSECTORES PARA <? echo $curso_pal." ".$tipo_ensenanza?></strong></font>
	<table width="600" border="1" cellspacing="1" cellpadding="3">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>C�digo Subsector</strong></font></td>
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Nombre Subsector</strong></font></td>
  </tr>
  <?
  	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$nombre_subsector = $fSubsectores['nombre'];
  ?>
  <tr>
    <td align="left"><font face="Arial, Helvetica, sans-serif" ><? echo $cod_subsector?></font></td>
    <td align="left"><font face="Arial, Helvetica, sans-serif" ><? echo $nombre_subsector?></font></td>
  </tr>
  <?
  }
  ?>
</table>

<font face="Arial, Helvetica, sans-serif">ESTA HOJA NO SE ADJUNTA AL ACTA IMPRESA POR AMBAS CARAS<br>ES SOLO UNA GU�A PARA LOS USUARIOS</font>	
</div>
-->
</div>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form action="ActaDeCalificacionCara.php" method="post">

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
<center>
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="600">
	<table width="600" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="600" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="cuadro01">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" >
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
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
</font>	  </div></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="submit" class="botonXX" id="cb_ok" value="Buscar">
    </div></td>
  </tr>
   <tr>
     <td colspan="3">
	 
	    <table width="320" border="0" cellspacing="2" cellpadding="0" align="center">
          <tr>
           <td><div align="center"><font size="1" face="arial, geneva, helvetica">Fecha del Informe</font></div></td>
           <td><div align="center">
              <input name="dia" type="text" id="dia" size="2" value="<?=$dia ?>">
            </div></td>
           <td><div align="center">
           <input name="mes" type="text" id="mes" size="11" value="<?=$mes ?>">
           </div></td>
           <td><div align="center">
           <input name="ano2" type="text" id="ano2" size="4" value="<?=$ano2 ?>">
           </div></td>
          </tr>
         </table>
	 
	 
	 </td>
   </tr>
  
  
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
<? pg_close($conn);?>
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

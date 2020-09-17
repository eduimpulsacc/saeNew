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
			function check(form){
				if (form.cmb_curso.value!=0){
					form.cmb_curso.target="self";		
					if (form.checkbox.checked==true){
						form.action = 'ActaDeCalificacionCara_new.php';
					}else{
						form.action = 'ActaDeCalificacionCara_d.php';
					}
					form.submit(true);
					}
				}	
			
			//function enviapag(form){
//			if (form.cmb_curso.value!=0){
//				form.cmb_curso.target="self";
//				form.action = 'ActaDeCalificacionCara.php?institucion=$institucion'; 
//				form.submit(true);
//	
//				}	
//			}
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
	   ## si el campo esta vacío poner la fecha actual
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
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
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
	$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es,curso.nivel_grado ";
	$sql_curso = $sql_curso . "from curso, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval ";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$nivel_grado = $fila_curso['nivel_grado'];
	/*$curso_pal = $fila_curso['grado_curso']."-".$fila_curso['letra_curso'];*/
	$grado_curso = $fila_curso['grado_curso'];
	$tipo_ensenanza = $fila_curso['nombre_tipo'];
	$plan_estudio =  $fila_curso['nombre_decreto'];
	$decreto_eval =  $fila_curso['nombre_decreto_eval'];
	$ense = $fila_curso['ensenanza'];
	$cod_es = $fila_curso['cod_es'];
	if($institucion==12086){
		if($fila_curso['ensenanza']==110){
			$curso_pal = CursoPalabra($curso, 4, $conn);			
		}elseif($fila_curso['ensenanza']==310){
			$curso_pal = CursoPalabra($curso, 5, $conn);			
		}
	}else{
		$curso_pal = CursoPalabra($curso, 0, $conn);
	}
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
	if ($institucion !=10774){
	$sql_alumnos = $sql_alumnos . "order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	}
	else
	{
	$sql_alumnos = $sql_alumnos . "order by nro_lista, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	}
	
	
	
	
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


//----------- RECTOR ----------------------
$qry="";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=" . $institucion . ") and cargo=23)";
$Rs_Rec	= @pg_exec($conn,$qry);
$fila_Rec = @pg_fetch_array($Rs_Rec,0);
$Nombre_Rec = trim($fila_Rec['nombre_emp'])." ".trim($fila_Rec['ape_pat'])." ". trim($fila_Rec['ape_mat']);

function validar_dav ($alumno,$dig_rut){
	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;
		 		  
		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;
			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;
				 
		 }
				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;   
		 }else{
		      
			  $ok=0;
			  	  
		 }	
		 return $ok;
		       	 
	}

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
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
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
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printActaDeCalificacionCara_new.php?cmb_curso=<?=$cmb_curso ?>&dia=<?=$dia ?>&mes=<?=$mes ?>&ano2=<?=$ano2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
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
                      <td height="30" colspan="2" align="center" valign="top" class="cuadro02">Curso <? echo $nivel_grado." ".$curso_pal;?></td>
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
          <td valign="top"  align="left"><font face="Arial, Helvetica, sans-serif" size="1">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N <? if($institucion==12086 and $ense > 110){ echo "RESOLUCIÓN EXENTA Nº 1379 DE FECHA 16 DE JUNIO DE 1987, modificada y ampliada según RESOLUCIÓN EXENTA"; }elseif($institucion==12086 and $ensenanza==110){ echo "RESOLUCIÓN EXENTA ";}else{ echo "DECRETO ";}?><u>Nº <? echo $resolucion?> del <? echo $fecha_res ?> </u>ROL BASE DE DATOS <u>Nº<? echo $rdb?> </u>PLAN DE ESTUDIOS APROBADOS POR DECRETO <u>Nº <? echo $plan_estudio?></u> Y DEL REGLAMENTO DE EVALUACIÓN Y PROMOCION ESCOLAR DECRETO EXENTO <u>Nº  <? echo trim($decreto_eval)?><?   if ((($grado_curso==1 or $grado_curso==2 or $grado_curso==3 or $grado_curso==4)and $ense==110) and $institucion==14912){ echo "MODIFICACION 107/2003.";}?>
      <? if ((($grado_curso==1 or $grado_curso==2 or $grado_curso==3 or $grado_curso==4)and $ense==110) and  $institucion ==25478){ echo "MODIFICACION 107/2003.";}?>
          </u></font></td>
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
		$bool_asist = $fSubsectores['bool_asist'];
		
	
			if($cod_subsector==13){
				$religion=$id_ramo;	?>
          <td class="cuadro02" valign="top"><? echo $cod_subsector?></td>
          <? }}?>
    
	      <td align="center" valign="top"><img src="asistencia.gif"></td>
          <td align="center" valign="top"><img src="situacion-final.gif" width="11" height="59"></td>
          <td class="cuadro02" valign="top">OBSERVACIONES</td>
        </tr>
        <?
	///// consultar si la institucion es de viña del mar
	$sql_vina = "select * from corp_instit where num_corp = '1' and rdb = '$_INSTIT'";
	$res_vina = pg_Exec($conn,$sql_vina);
	$num_vina = pg_numrows($res_vina);	
	
		
		
  	if (@pg_numrows($rsAlumnos)<30)
	  $espacio_lineas = 15;
  	if (@pg_numrows($rsAlumnos)>29)
	  $espacio_lineas = 5;
	  
	  $jj = 1;
	  
	for($i=0 ; $i < @pg_numrows($rsAlumnos) ; $i++)
	{
		$fAlumno = @pg_fetch_array($rsAlumnos,$i);
		$alumno = trim($fAlumno['rut_alumno']);
		
		$dig_rut = trim($fAlumno['dig_rut']);
				
		if ($num_vina > 0){
		      /// no entra a validar rut
			  $ok = 1;
			  
		}else{
		      /// si entra a validar rut		
		
			$ok = validar_dav($alumno,$dig_rut);		
			if ($dig_rut==NULL){
				if ($_INSTIT==516){			
					 $ok = 1;
				}else{
					 $ok = 0;			
				}	 
			}	
			if ($dig_rut== " "){
				if ($_INSTIT==516){			
					 $ok = 1;
				}else{
					 $ok = 0;			
				}
			}
		}
		
		
		
		if ($ok==1){
				
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
          <td height=<? echo $espacio_lineas?>><? echo $jj; ?></td>
          <td ><? echo trim($fAlumno['ape_pat']) . " " . trim($fAlumno['ape_mat'] ). " " . trim($fAlumno['nombre_alu']) ?></td>
          <td ><? echo $fAlumno['rut_alumno'] ?></td>
          <td ><? echo $fAlumno['dig_rut']."&nbsp;" ?></td>
          <td ><?  if ($fAlumno['sexo']==1){ echo "2"; }else{ echo "1";} ?></td>
          <td ><? echo Cfecha2($fAlumno['fecha_nac']) ?></td>
          <td ><? echo $fAlumno['nom_com'] ?></td>
          <?
		  
		  $jj++;
		 // echo "<br> cantidad de subsectores ".$cantidad_subsectores;
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
		
			$sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ramo = ".$id_ramo." and rut_alumno = ".$alumno." and id_curso = ".$curso;
			$rs_promedios = @pg_exec($conn,$sql);
			$promedio_nota = @pg_result($rs_promedios,0);
			//if($promedio_nota==0){
			if($modo_eval==1 and $promedio_nota==0){
				$promedio_nota="&nbsp;";
			}
		}else{
			if ($fSubsectores['sub_obli']==1){
			    if ($fSubsectores['bool_ip']==1){
				     $promedio_nota = "EX";
				}else{
				     $promedio_nota = "&nbsp;";
				}	 
			}else{
				$promedio_nota = "&nbsp;";
			}	
		}
//***VEL*** Muestro solo si existe		
		 // if($existe == "0"){		
		 if($cod_subsector!=13){?>
                 <td align="center"><? if ($situacion_final <> "Y") echo $promedio_nota; else echo "&nbsp;"; ?></td>
          <? }
		  }
		 // }
		 
		 
		 ?>
          <td align="center"><? if ($situacion_final <> "Y") echo $promedio; else echo "&nbsp;"; ?>&nbsp;</td>
     
	 
	     <?
		
		for($e=0 ; $e < $cantidad_subsectores ; $e++){
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$modo_eval = $fSubsectores['modo_eval']; 
		$conex = $fSubsectores['conex']; // 1 si 2 no
		$sql_eximido = "select count(*) as cantidad from tiene$ano_escolar where rut_alumno = ".$alumno." and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$rsEximido=@pg_Exec($conn,$sql_eximido);
		$fEximido= @pg_fetch_array($rsEximido,0);		
		if ($fEximido['cantidad']>0){
			$sql = "SELECT promedio FROM promedio_sub_alumno WHERE  id_curso = ".$curso." and id_ramo = ".$id_ramo." and rut_alumno = ".$alumno."";
			$rs_promedios = @pg_exec($conn,$sql);
			$promedio_nota = @pg_result($rs_promedios,0);
			
		}else{
			if ($fSubsectores['sub_obli']==1){
				if ($fSubsectores['bool_artis']==1){
				    $promedio_nota = "&nbsp;";
				}else{
				    $promedio_nota = "EX";
				}
			}else{
			   
				$promedio_nota = "EX"; // cambio solicitado por el coyancura
			    
			}	
		}
		if($cod_subsector==13){ ?>
             <td align="center" >
			 <? if ($situacion_final <> "Y"){
 			 
			         if ($_INSTIT==9566){
					     if($promedio_nota > 0){ 					 
							 $promedio_nota = Conceptual($promedio_nota , 1);					 
							 echo $promedio_nota;
						 }else{
						     	 
						     echo  $promedio_nota;
						 }						
					 }else{	
						 if ($institucion==9239){
						    echo "N/O";
						 }else{
						      if ($institucion==1653 and trim($promedio_nota)=="-"){
							       echo "N/O";
							  }else{					     			     
					               echo $promedio_nota;
							  }	   
						 }	
						/* if($promedio_nota!=""){
						 	echo $promedio_nota;
						}else{
							echo "EX";
						} 	*/				 
					 }	 
			    }else{
					echo "&nbsp;";
					
				}
			   ?></td>
   <? }} ?>
		  <td align="center">
		  <? if ($situacion_final <> "Y") echo $asistencia; else echo " "; ?>&nbsp;</td>
          <td align="center"><? echo $situacion_final ?>&nbsp;</td>
          <td><? echo $observacion."&nbsp;"; ?></td>
        </tr>
        <? 
		
		}
		
		
		} ?>
      </table>
<table width="1074" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left">	  <font face="Arial, Helvetica, sans-serif" size="-2">
	  Códigos :        Promovido= P       Reprobado =  R       Retirado =  Y					Masculino = 1   -   Femenino = 2 *******
	  Nota :   El Subsector de Religión no tiene incidencia en su promedio general de calificaciones ni en la situación final del alumno.															
	  </font></td>
  </tr>
</table>	  
      <?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
      <table width="1024" border="0"  cellspacing="0" cellpadding="0">
        <tr>
          <td width="1024" align="left" valign="top">&nbsp;
              <table width="1024" border="1" cellspacing="0" cellpadding="0">
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
			if($institucion==12086 and $cod_subsector==13){
				if ($nivel_temp==1){$titulo = "H / Aut. arzobispado Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);}
			}else{
				if ($nivel_temp==1){$titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);}
			}
			if ($nivel_temp==2){$titulo="T";}
			if ($nivel_temp==3){$titulo="T";}
		}
		
		
		
		
		//// NUEVO CODIGO PARA DETERMINAR SI ES HABILITADO O NO   ///////		
		$rsDicta=pg_Exec($conn,$sql_dicta);
		$titulo=NULL;
		$fDicta= @pg_fetch_array($rsDicta,0);
			if ($fDicta[habilitado]==1){
				$arreglo_temp=unserialize($fDicta[habilitado_para]);
				if (@in_array($cod_subsector,$arreglo_temp) and $fDicta['fecha_resol']!=NULL){
					$titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);
				}
				
			}
			
			
		/// nuevo código para ver que la habilitación corresponde para el tipo de enseñanza
		if ($_PERFIL==0){		
		     $sql_1 = "select * from habilitaciones where rut_emp = '$fDicta[rut_emp]' and id_ano = '$_ANO' and cod_subsector = '$cod_subsector' and tipo_ense = '$ense'";
		}else{
		     $sql_1 = "select * from habilitaciones where rut_emp = '$fDicta[rut_emp]' and id_ano = '$_ANO' and cod_subsector = '$cod_subsector' and tipo_ense = '$ense'";
		
		}
		$res_1 = @pg_Exec($conn,$sql_1);
		$num_1 = @pg_numrows($res_1);
		
		if ($num_1 > 0){
		    $fil_1 = @pg_fetch_array($res_1,0);
		    $te    = $fil_1['tipo_ense'];
				
		     if (trim($te)==trim($ense)){
			 	if($institucion==12086 and $fSubsectores['cod_subsector']==13){
					$titulo = "H / Aut. arzobispado Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
				}else{
				    $titulo = "H / Res Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
				}
				if($institucion==2278 and $fSubsectores['cod_subsector']==13){
					if($_PERFIL==0){
						echo  "observaciones ".$obshabilitado = "H / Res Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
						echo "titulo ".$titulo = "T";
					}
				}
		     }else{
		         $titulo=NULL;		
		     }
		}	 					
		/// nuevo cambio para que salga titulado o habilitado //	
		if ($titulo==NULL){
	        
		
			if (($fDicta[titulado]==1)){
				$titulo = "T";
				 if ($institucion == 1593){
				 $titulo = "Titulado";
				 }	
				   
			}
			if (($fDicta[tit_otras]==1)){
				  
				$titulo = "T"; 
				
			}
			 if ($institucion == 1593){
				 $titulo = "Titulado";
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
			
		
		if($_PERFIL==0){
						echo  "observaciones ".$obshabilitado = "H / Res Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
						echo "titulo ".$titulo = "T";
					}
		
		
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
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.fecha < '$ano_escolar-05-01' ";
$resultado = pg_exec($conn,$sql);
$num_resultado = pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut	
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
			
	if ($ok==1){
	    $contador++;
	}
}		
$matricula_inicial_hombre = $contador;





//------------------			  
//------------------ TOTAL MATRICULA INICIAL AL 30-04 MUJER
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut  from matricula, alumno where matricula.id_ano = $ano and matricula.id_curso = $curso and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1  and matricula.fecha < '$ano_escolar-05-01' ";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
	
			
	if ($ok==1){
	    $contador++;
	}
}	

$matricula_inicial_mujer = $contador;
//------------------			  
//------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1º Mayo y 29 Noviembre
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-12-01' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
}else{
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
}

$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		 
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
			
	if ($ok==1){
	    $contador++;
	}
}	

$matricula_1_hombre = $contador;
//------------------
//------------------ TOTAL MATRICULA MUJERES Ingresos entre el 1º Mayo y 29 Noviembre
$sql="";

if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-12-01' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . " ";
}else{
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-11-30' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . " ";
}
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
			
	if ($ok==1){
	    $contador++;
	}
}	


$matricula_1_mujer = $contador;
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - HOMBRES
//----------------------------------------------------------------
$sql="";

if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-12-01') ";
}else{
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
}
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
			
	if ($ok==1){
	    $contador++;
	}
}	


$retirados1 = $contador;
//----------------------------------------------------------------	
//----------------------------------------------------------------				
// ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre - MUJERES
//----------------------------------------------------------------
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro  > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-12-01') ";
}else{
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro  > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-11-30') ";
}
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
			
	if ($ok==1){
	    $contador++;
	}
}

$retirados2 = $contador;
//----------------------------------------------------------------	
//------------------

$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".($ano_escolar)."' and id_ano = ".$ano . " and matricula.bool_ar=0 and matricula.rut_alumno = alumno.rut_alumno" ;
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}

$matriculados = $contador;	

/*$sql="";
$sql = "select count(*) as cantidad from matricula where id_curso = ".$curso." and matricula.fecha < '".($ano_escolar)."-12-01' and id_ano = ".$ano . " and ((matricula.bool_ar=0)or(matricula.bool_ar isnull)) " ;
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados = $fila2['cantidad'];	*/
//------------------
//------------------ MATRICULADOS HOMBRES

$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$matriculados_hombre = $contador;	

/*$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$ano_escolar."-12-01' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and ((matricula.bool_ar=0)or(matricula.bool_ar isnull))";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_hombre = $fila2['cantidad'];	*/
//------------------
//------------------ MATRICULADOS MUJERES

$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".$ano_escolar."' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}  
		if ($dig_rut== " "){
				$ok = 0;
			} 
	}		
	if ($ok==1){
	    $contador++;
	}
}

$matriculados_mujer = $contador;


/*$sql="";
$sql = "select count(matricula.rut_alumno) as cantidad from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$ano_escolar."-12-01' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and ((matricula.bool_ar=0)or(matricula.bool_ar isnull))";
$resultado = pg_exec($conn,$sql);
$fila2 = @pg_fetch_array($resultado,0);
$matriculados_mujer = $fila2['cantidad'];	*/

//------------------ PROMOVIDOS
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}

$aprobados = $contador;
//------------------
//------------------ PROMOVIDOS HOMBRE
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}  
		if ($dig_rut== " "){
				$ok = 0;
			} 
	}
			
	if ($ok==1){
	    $contador++;
	}
}


$aprobados_hombre = $contador;
//------------------
//------------------ PROMOVIDOS MUJERES
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 1 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);
$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}  
		if ($dig_rut== " "){
				$ok = 0;
			} 
	}
			
	if ($ok==1){
	    $contador++;
	}
}


$aprobados_mujer = $contador;
//------------------ REPROVADOS
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$reprovados = $contador;
//------------------

//------------------ REPROVADOS HOMBRES INASISTENCIA
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$reprovados_hombre = $contador;
//------------------
//------------------ REPROVADOS MUJERES INASISTENCIA
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 2";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
	
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		} 
		if ($dig_rut== " "){
				$ok = 0;
			}  
	}		
	if ($ok==1){
	    $contador++;
	}
}


$reprovados_mujer = $contador;
//------------------ REPROVADOS HOMBRES RENDIMIENTO
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$reprovados_hombre1 = $contador;
//------------------
//------------------ REPROVADOS MUJERES RENDIMIENTO
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 2 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1  and tipo_reprova = 1";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$reprovados_mujer1 = $contador;

//------------------ RETIRADOS
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno ";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}  
		if ($dig_rut== " "){
				$ok = 0;
			} 
	}		
	if ($ok==1){
	    $contador++;
	}
}


$retirados= $contador;
//------------------
//------------------ RETIRADOS HOMBRES
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 2";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}		
	if ($ok==1){
	    $contador++;
	}
}


$retirados_hombre = $contador;
//------------------
//------------------ RETIRADOS MUJERES
$sql="";
$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.situacion_final = 3 and promocion.rut_alumno = alumno.rut_alumno and alumno.sexo = 1";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($num_vina > 0){
		/// no entra a validar rut
		$ok = 1;
	}else{
		 /// si entra a validar rut
		$ok = validar_dav($rut_alumno,$dig_rut);		
		if ($dig_rut==NULL){
		   $ok = 0;
		}   
		if ($dig_rut== " "){
				$ok = 0;
			}
	}
			
	if ($ok==1){
	    $contador++;
	}
}


$retirados_mujer = $contador;
//------------------
?>
                </li>
              </ul>
              <table width="778" align="left" border="0" cellspacing="0" cellpadding="0">
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
                  <td bordercolor="#000000">Matrícula 30 Abril (inicial)</td>
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
                  
            <td bordercolor="#000000"><span class="cuadro01">Ingresos entre el 1              º Mayo y <? if ($_INSTIT==9071){ ?> 30 Noviembre <? } else{ ?> 29 Noviembre  <? } ?></span></td>
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
                  
            <td bordercolor="#000000"><span class="cuadro01">Retirados entre 1 º            Mayo y <? if ($_INSTIT==9071){ ?> 30 Noviembre <? } else{ ?> 29 Noviembre  <? } ?></span></td>
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
                  <td bordercolor="#000000"><span class="cuadro01"></span><span class="cuadro01">Matrícula 30 Noviembre (final) </span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="cuadro01"><? echo $matriculados ?></span></td>
                  <td>&nbsp;</td>
				  <?  
				  // VEL ACTAS
				  	$sql_actas = "select * from curso where id_curso = '$curso'";
					$res_actas = @pg_Exec($conn, $sql_actas);
					$fila_actas = @pg_fetch_array($res_actas);
					$encargado_acta = $fila_actas['acta'];

					$sql_encargado = "select nombre_emp, ape_pat, ape_mat from empleado where rut_emp = '$encargado_acta'";
					$res_encargado	= @pg_Exec($conn, $sql_encargado);
					$fila_encargado = @pg_fetch_array($res_encargado);
					$encargado = $fila_encargado['ape_pat']." ".$fila_encargado['ape_mat'].", ".$fila_encargado['nombre_emp'];		
					
					$observaciones = $fila_actas['observaciones'];
				
				if(trim($encargado) == ","){ ?>				  
                  <td align="center">__________________</td>
				<? }else{ ?>
				  <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><u><?=$encargado?></u></font></td>
				<? } 
				// FIN VEL
				?>
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
                  <td align="center" width="200"><span class="cuadro01">
				  
				  <? if ((($grado_curso==1 or $grado_curso==2)and $ense==310) and $institucion==516){ 
				           echo "ENCARGADO CONFECCIÓN DEL ACTA <br> SRA. MYRIAM SEGURA";
					 }else{
					      if ((($grado_curso==3 or $grado_curso==4)and $ense==310) and $institucion==516){
						       echo "ENCARGADO CONFECCIÓN DEL ACTA <br> SRA. SONIA GUERRERO";
						  }else{
						       ?>			  
				               ENCARGADO CONFECCI&Oacute;N DEL ACTA
							   <?
						  }
					  }
					  ?>	  	   
					  </span></td>
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
				  <?php 
				  
				 
				  
				  if ($institucion == 9566){
							echo "PAVEZ MENESES ROBERTO";
						} 
						
						if ($institucion == 24511){
							echo "MARCELO MEZA GOTOR";
						} 						
						else {
 							 echo strtoupper($Nombre_Dir); }
							 
							
							 
					?><br>
					<? if ($institucion==9239){
					     echo "DIRECTORA";
					   }else{
					         if ($institucion==769){
							     echo strtoupper($Nombre_Rec);
								 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECTOR";
							 }else{
							     
					             echo "JEFE ESTABLECIMIENTO";
						     }		 
					   }
					   if ($institucion == 14912){ 
				  echo "<br>Hno. Manuel Martín Chilla Cruz csv";
				  }
					   ?>	 
						  </span></td>
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
    <td align="left"><span class="cuadro01">
	<? 
	  if ($_PERFIL==0){
	     echo "cursos: $curso <br>";
	  
	  } 
	
	
	   if ((($grado_curso==4 or $grado_curso==3)and $ense==310) and $institucion==11106){ ?>
	    OBSERVACIONES: Visión Sistemática de la Organización, una herramienta de gestión, Resolución Exenta 2688, 29/10/2002 MINEDUC – IV REGION.
	
	
	<? }else{
	        if ((($grado_curso==4 or $grado_curso==3 or $grado_curso==1 or $grado_curso==2)and $ense==110) and $institucion==1756){ ?>
			    OBSERVACIONES: Idioma Extranjero (Inglés), Resolución Exenta 3926 de 2005.
		 <?	}else{ 
//VEL		 
		 		if($observaciones==""){?>		 			
	            	OBSERVACIONES:______________________________________________________________________________________________________________________________________________
			<?	}else{ ?>
					OBSERVACIONES:&nbsp;<u><?=$observaciones;?></u>
			<? } 
//FIN VEL			?>
		
	      <? } ?>
	<? } ?>
	
	
	</span></td>
  </tr>
  <tr>
<? 
//vel
if($observaciones==""){?>
    <td align="left"><span class="cuadro01">_______________________________________________________________________________________________________________________________________________________________</span></td>
<? } ?>
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
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Código Subsector</strong></font></td>
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

<font face="Arial, Helvetica, sans-serif">ESTA HOJA NO SE ADJUNTA AL ACTA IMPRESA POR AMBAS CARAS<br>ES SOLO UNA GUÍA PARA LOS USUARIOS</font>	
</div>
-->
</div>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form action="ActaDeCalificacionCara_new.php" method="post">

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
      <input name="cb_ok" type="submit" class="botonXX" id="cb_ok" value="Buscar" onClick="check(this.form)">
    </div></td>
  </tr>
   <tr>
     <td colspan="3">
		<table width="100" border="0" align="left">
		  <tr>
			<td><div align="center">
			  <input type="checkbox" name="checkbox" value="1">
			  <font size="1" face="arial, geneva, helvetica">
			    Final</font></div></td>
		  </tr>
		</table>

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
<? pg_close($conn);?>
<div align="center">

<?

require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
//if($_PERFIL==0){show($_GET);}
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
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;
	
	/*echo "dia: $dia<br>";
	echo "mes: $mes<br>";
	echo "ano2: $ano2<br>";
	*/
	
	//if ($curso==0) //exit;
	
	//------------------------
	// Aï¿½o Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, date_part('year',institucion.fecha_resolucion)as fecha_res, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.nu_resolucion, institucion.region ";
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
	$cod_region =$fila_ins['region'];
	//-------
	/*$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es ";
	$sql_curso = $sql_curso . "from curso, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval ";*/
	
	$sql_curso = "select curso.grado_curso, curso.letra_curso,  tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.ensenanza, curso.cod_es,curso.nivel_grado, niveles.nombre, curso.cod_decreto ";
	$sql_curso = $sql_curso . "from curso left outer join niveles on curso.id_nivel=niveles.id_nivel, tipo_ensenanza, plan_estudio, evaluacion ";
	$sql_curso = $sql_curso . "where id_curso = ".$curso." and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "and plan_estudio.cod_decreto = curso.cod_decreto ";
	$sql_curso = $sql_curso . "and evaluacion.cod_eval = curso.cod_eval ";
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$curso_pal = $fila_curso['grado_curso']."-".$fila_curso['letra_curso'];
	$grado_curso = $fila_curso['grado_curso'];
	$letra_curso = $fila_curso['letra_curso'];
	$niveles = $fila_curso['nombre'].$letra_curso;
	$tipo_ensenanza = $fila_curso['nombre_tipo'];
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
	
	if($institucion==12086){
		if($fila_curso['ensenanza']==110){
			$curso_pal = CursoPalabra($curso, 4, $conn);			
		}elseif($fila_curso['ensenanza']==310){
			$curso_pal = CursoPalabra($curso, 4, $conn);			
		}
	}else{
		$curso_pal = CursoPalabra($curso, 0, $conn);
	}
	//-------
	
	//if($_PERFIL==0){
		$sql= "SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	//}else{
		//$corporacion=$_CORPORACION;
	//}
	/*if($corporacion==13){
		$fecha ="30-04-".$ano_escolar;
	}else{*/
		$fecha ="04-30-".$ano_escolar;
	//}
	//and matricula.fecha_retiro > '".$fecha."'
	/*$sql_alumnos = "select upper(alumno.ape_pat) as ape_pat, upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombre_alu, matricula.rut_alumno, upper(alumno.dig_rut) as dig_rut, alumno.sexo, alumno.fecha_nac, comuna.nom_com, matricula.id_curso, matricula.bool_ar ";
	$sql_alumnos = $sql_alumnos . "from matricula, alumno, comuna ";
	$sql_alumnos = $sql_alumnos . "where matricula.id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alumnos = $sql_alumnos . "and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region and comuna.cor_pro = alumno.ciudad and ((matricula.bool_ar=1 ) or (matricula.bool_ar=0)) and nacionalidad=2 ";
	
	/*if ($institucion !=10774){*/
/*	$sql_alumnos = $sql_alumnos . "order by numero_reporte, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";*/

$ord = ($_GET['ord']==1)?"a, ape_pat,ape_mat, nombre_alu":"matricula.numero_reporte";
$sql_alumnos=" 
SELECT  DISTINCT alumno.rut_alumno,matricula.numero_reporte, case WHEN (SUBSTRING(alumno.ape_pat,1,1)='Á') THEN REPLACE(alumno.ape_pat,'Á','A')
	 WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='É') THEN REPLACE(upper(alumno.ape_pat),'É','E')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Í') THEN REPLACE(upper(alumno.ape_pat),'Í','I')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Ó') THEN REPLACE(upper(alumno.ape_pat),'Ó','O')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Ú') THEN REPLACE(upper(alumno.ape_pat),'Ú','U')
     ELSE upper(alumno.ape_pat)
     END AS a,upper(alumno.ape_pat) as ape_pat,
 upper(alumno.ape_mat) as ape_mat,
upper(alumno.nombre_alu) as nombre_alu, upper(alumno.dig_rut) as dig_rut, 
alumno.sexo, alumno.fecha_nac, comuna.nom_com, promocion.id_curso, 
case when (promocion.situacion_final=3) then 1 else 0 end as bool_ar
FROM matricula 
INNER JOIN promocion on promocion.id_curso=matricula.id_curso
INNER JOIN alumno ON alumno.rut_alumno=promocion.rut_alumno AND matricula.rut_alumno=alumno.rut_alumno
INNER JOIN comuna ON comuna.cod_reg=alumno.region AND comuna.cor_pro=alumno.ciudad AND comuna.cor_com=alumno.comuna
WHERE promocion.id_curso = ".$curso."   
order by $ord ";
/*$sql_alumnos=" 
SELECT  DISTINCT alumno.rut_alumno, case WHEN (SUBSTRING(alumno.ape_pat,1,1)='Á') THEN REPLACE(alumno.ape_pat,'Á','A')
	 WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='É') THEN REPLACE(upper(alumno.ape_pat),'É','E')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Í') THEN REPLACE(upper(alumno.ape_pat),'Í','I')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Ó') THEN REPLACE(upper(alumno.ape_pat),'Ó','O')
     WHEN (SUBSTRING(upper(alumno.ape_pat),1,1)='Ú') THEN REPLACE(upper(alumno.ape_pat),'Ú','U')
     ELSE upper(alumno.ape_pat)
     END AS a,upper(alumno.ape_pat) as ape_pat,
 upper(alumno.ape_mat) as ape_mat,
upper(alumno.nombre_alu) as nombre_alu, upper(alumno.dig_rut) as dig_rut, 
alumno.sexo, alumno.fecha_nac, comuna.nom_com, promocion.id_curso, 
case when (promocion.situacion_final=3) then 1 else 0 end as bool_ar
FROM matricula 
INNER JOIN promocion on promocion.id_curso=matricula.id_curso
INNER JOIN alumno ON alumno.rut_alumno=promocion.rut_alumno AND matricula.rut_alumno=alumno.rut_alumno
INNER JOIN comuna ON comuna.cod_reg=alumno.region AND comuna.cor_pro=alumno.ciudad AND comuna.cor_com=alumno.comuna
WHERE promocion.id_curso = ".$curso."    and nacionalidad=2 
order by $ord ";*/
	/*if($_PERFIL==0){
		echo $sql_alumnos;
	}*/
	/*}
	else
	{
	$sql_alumnos = $sql_alumnos . "order by nro_lista, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	}*/
	//echo $sql_alumnos;
	$rsAlumnos =@pg_Exec($conn,$sql_alumnos);
//---------
//------------ PROFESOR  JEFE ---------------
$qry = "";
$qry = "SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.rut_emp FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=" . $cmb_curso ."))";
$Rs_Profe =@pg_exec($conn,$qry);
$fila_Profe = @pg_fetch_array($Rs_Profe,0);
$Nombre_Profe = trim($fila_Profe['nombre_emp'])." ".trim($fila_Profe['ape_pat'])." ".trim($fila_Profe['ape_mat']);
$rut_profesor = trim($fila_Profe['rut_emp']);
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


if($cb_ok!="Buscar" && $tipo!=1){ 
	$fecha_actual = date('d-m-Y_H:i');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Calificacion_Cara_$fecha_actual.xls"); 	 
}

/*******nuevo conteo matricula activos y retirador******/
$sql_activos="select count(alumno.rut_alumno) 
from matricula, 
alumno where matricula.id_ano = ".$ano." 
and matricula.id_curso = " . $curso . " and 
alumno.rut_alumno = matricula.rut_alumno and bool_ar=0
 ";

$rs_activos = pg_exec($conn,$sql_activos);
$activos = @pg_result($rs_activos,0);


$sql_retirados="select count(alumno.rut_alumno) 
from matricula, 
alumno where matricula.id_ano = ".$ano." 
and matricula.id_curso = " . $curso . " and 
alumno.rut_alumno = matricula.rut_alumno 
and matricula.bool_ar=1 ";

$rs_retirados = pg_exec($conn,$sql_retirados);
$retirados = @pg_result($rs_retirados,0);
/*************************************************/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<STYLE>
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
//-->
</script>

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<!--<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="window.print()">
<!-- INICIO CUERPO DE LA PAGINA -->
<div id="capa0">
<!--<table width="950" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left"><table>
            <tr>
              <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
              </td>
            </tr>
        </table></td>
        <td align="right">
          <font face="Arial, Helvetica, sans-serif" size="-1" color="#000066"><strong>ESTE INFORME DEBE IMPRIMIRSE EN HOJA TAMA&Ntilde;O OFICIO</strong></font>
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </td>
      </tr>
  </table>-->
</div>


      <table width="1100"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="111" rowspan="4" align="left" valign="top"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REP&Uacute;BLICA DE CHILE</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> MINISTERIO DE EDUCACI&Oacute;N</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> DIVISI&Oacute;N DE EDUCACI&Oacute;N </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SECRETARIA REGIONAL </strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong>MINISTERIAL</strong></font><font face="Arial, Helvetica, sans-serif" size="-2"><strong> DE EDUCACI&Oacute;N </strong></font></td>
          <td width="7" rowspan="4" align="left">&nbsp;</td>
          <td width="889" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ACTA DE CALIFICACIONES FINALES Y PROMOCI&Oacute;N ESCOLAR </strong></font></td>
          <td width="229" colspan="2" rowspan="4" align="left" valign="top"><table width="87%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#E9E9E9">
              <tr>
                <td colspan="2"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $region ?></u></span></span></td>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $ciudad ?></u></span></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="detalle">REGI&Oacute;N</span></td>
                      <td align="center"><span class="detalle">PROVINCIA</span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $comuna ?></u></span></span></td>
                      <td align="center"><span class="titulo"><span class="detalle"><u><? echo $ano_escolar ?></u></span></span></td>
                    </tr>
                    <tr>
                      <td align="center"><span class="detalle">COMUNA</span></td>
                      <td align="center"><span class="detalle">A&Ntilde;O ESCOLAR </span></td>
                    </tr>
                    <tr>
                      <td height="30" colspan="2" align="center" valign="top"><span class="titulo">Curso</span> <span class="titulo"><? /*if($institucion==283){
							if($fila_curso['grado_curso']==1 and $fila_curso['cod_decreto']==2572010 and $fila_curso['ensenanza']==663){
								echo $curso_pal = "PRIMER NIVEL ".ucwords(strtoupper($fila_curso['letra_curso']." ".$fila_curso['nombre_tipo']));
							}
							if($fila_curso['grado_curso']==3 and $fila_curso['cod_decreto']==2572010 and $fila_curso['ensenanza']==663){
								echo $curso_pal = "SEGUNDO NIVEL ".ucwords(strtoupper($fila_curso['letra_curso']." ".$fila_curso['nombre_tipo']));
							}
							if($fila_curso['grado_curso']==4 and $fila_curso['cod_decreto']==2572010 and $fila_curso['ensenanza']==663){
								echo $curso_pal = "TERCER NIVEL ".ucwords(strtoupper($fila_curso['letra_curso']." ".$fila_curso['nombre_tipo']));
							}
					  }else{
						  echo $nivel_grado." ".$curso_pal." ".$niveles;
					  }
					  
					  echo $nivel_grado." ".$curso_pal." ".$niveles;*/
					  echo CursoPalabra($curso,1,$conn);  
					  
					  ?></span></td>
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
          <td valign="top"  align="left"><font face="Arial, Helvetica, sans-serif" size="1">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACI&Oacute;N DE LA REP&Uacute;BLICA DE CHILE SEG&Uacute;N <? if($institucion==12086 and $ense > 110){ echo "RESOLUCION EXENTA Nº 1379 DE FECHA 16 DE JUNIO DE 1987, modificada y ampliada seg&uacute;n RESOLUCION EXENTA"; }elseif($institucion==12086 and $ense==110){ echo "RESOLUCION EXENTA ";} elseif($institucion==9940 and $ense==310) { echo "DECRETO Nº 03016 DE 1977 ";} else{ echo "DECRETO ";?>   <u>Nº; <? echo $resolucion?> del <? echo $fecha_res; } ?> </u>ROL BASE DE DATOS <u>Nº<? echo $rdb?> </u>PLAN DE ESTUDIOS APROBADOS POR DECRETO <u>Nº 
		  <?
		  if ($institucion==25182){
			     echo "150 de 2007, MODIFICADA POR Nº 4142 de 2009";
		 }else{
		  
		  
			 /* if ($grado_curso==1 and $ense==310 and $institucion==9239){ 
					echo "77 de 1999"; 
			  }else{
				   if ($grado_curso==2 and $ense==310 and $institucion==9239){ 
						echo "83 de 2000";
				   }else{*/
						echo $plan_estudio;
				  //}		
			  //}  
		 }	  
		  
		  ?></u> Y DEL REGLAMENTO DE EVALUACION Y PROMOCION ESCOLAR DECRETO EXENTO <u>Nº <? echo $decreto_eval;?>
		  
		  <?   if ((($grado_curso==1 or $grado_curso==2 or $grado_curso==3 or $grado_curso==4)and $ense==110) and $institucion==14912){ echo "MODIFICACION 107/2003.";}?>
          
		  <? if ((($grado_curso==1 or $grado_curso==2 or $grado_curso==3 or $grado_curso==4)and $ense==110) and  $institucion ==25478){ echo "MODIFICACION 107/2003.";} ?></u>
		  
		  <? /*if (($grado_curso==1 or $grado_curso==2 )and $ense==310 and  $institucion ==9239){ echo " MODIFICADO POR DOCTO.158/99"; } */?>
		  
		  </font></td>
        </tr>
</table>
      
       <table width="1100" height="88"  border="1" cellpadding="0" cellspacing="0" bordercolor="ddddddd" background="images/img_negra.jpg">
	   <tr>
          <td width="10" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="320" valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">NOMINA DE ALUMNOS</font></td>
          <td valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">RUN</font></td>
          <td width="20" valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">COD RUN</font></td>
          <td width="27" valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">SEXO</font></td>
          <td width="40" valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">FEC NAC</font></td>
          <td valign="top" bgcolor="#FFFFFF" class="titulo"><font style="font-size:9px">COMUNA RESIDENCIA</font></td>
          <?
// nuevo2
		$sql_aprox = "SELECT truncado_per FROM curso WHERE id_curso=".$curso."";		  
		$rs_aprox = @pg_Exec($conn,$sql_aprox);
		$fil_aprox = @pg_fetch_array($rs_aprox,0);
		$aprox = $fil_aprox['truncado_per'];
// fin nuevo2

//	 $sql_subsectores = "select * from ramo where id_curso = ".$curso." and (bool_ip = 1 or cod_subsector = 13) order by id_orden";
	 $sql_subsectores = "select * from ramo INNER JOIN subsector ON ramo.cod_subsector=subsector.cod_subsector where id_curso = ".$curso."  and (bool_ip = 1 or ramo.cod_subsector = 13) order by id_orden";
	$rsSubsectores=pg_Exec($conn,$sql_subsectores);
			
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
          <td valign="top" bgcolor="#FFFFFF" class="detalle"><? echo "&nbsp;  ".$cod_subsector?>&nbsp;</td>
          <? }
		 }
	}//***VEL***?>
          <td align="center" valign="top" bgcolor="#FFFFFF"><img src="promedio-general.gif" width="11" height="61"></td>
    <? 
	for($e=0 ; $e < @pg_numrows($rsSubsectores) ; $e++)
	{
		$fSubsectores= @pg_fetch_array($rsSubsectores,$e);
		$cod_subsector = $fSubsectores['cod_subsector'];
		$id_ramo = $fSubsectores['id_ramo'];
		$sub_obli = $fSubsectores['sub_obli'];
		
	
			if($cod_subsector==13){
				$religion=$id_ramo;	?>
          <td valign="top" bgcolor="#FFFFFF" class="detalle"><? echo $cod_subsector?></td>
          <? }}?>        
	      <td align="center" valign="top" bgcolor="#FFFFFF"><img src="asistencia.gif"></td>
          <td align="center" valign="top" bgcolor="#FFFFFF"><img src="situacion-final.gif" width="11" height="59"></td>
          <td width="150" valign="top" bgcolor="#FFFFFF" class="titulo">OBSERVACIONES</td>
        </tr>
        <?
		
	///// consultar si la institucion es de viï¿½a del mar
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
		
		
		if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
		if($_INSTIT==769){
			$promedio = substr($promedio,0,1).",".substr($promedio,1,1);
		}else{
			if($_INSTIT==9853 || $_INSTIT==5661){
				if (!empty($promedio)) $promedio = substr($promedio,0,1).",".substr($promedio,1,1); else $promedio = "&nbsp;";
			}else{
				if (!empty($promedio)) $promedio = substr($promedio,0,1).".".substr($promedio,1,1); else $promedio = "&nbsp;";
			}
		}
		//if (!empty($promedio)) $promedio = substr($promedio,0,1).".".substr($promedio,1,1); else $promedio = "&nbsp;";
		if (!empty($fPromocion['asistencia'])) $asistencia = $fPromocion['asistencia']."%"; else $asistencia = "&nbsp;";
		$situacion_final = $fPromocion['situacion_final'];
		if ($situacion_final==1) $situacion_final = "P";
		if ($situacion_final==2) $situacion_final = "R";
		if ($situacion_final==3) $situacion_final = "Y";
		if (!empty($fPromocion['observacion'])) $observacion = $fPromocion['observacion']; else $observacion = "&nbsp;";
  ?>
        <tr>
          <td height=<? echo $espacio_lineas?> bgcolor="#FFFFFF" class="detalle"><? echo $jj; ?></td>
          <td bgcolor="#FFFFFF" class="detalle"><? echo trim($fAlumno['ape_pat']) . " " . trim($fAlumno['ape_mat'] ). " " . trim($fAlumno['nombre_alu']) ?></td>
          <td bgcolor="#FFFFFF" class="detalle"><? echo $fAlumno['rut_alumno'] ?></td>
          <td bgcolor="#FFFFFF" class="detalle"><? echo $fAlumno['dig_rut']."&nbsp;" ?></td>
          <td bgcolor="#FFFFFF" class="detalle"><?  if($rd_genero==1){ 
		  				if ($fAlumno['sexo']==1){ echo "F"; }else{ echo "M";}
					}else{
						if ($fAlumno['sexo']==1){ echo "2"; }else{ echo "1";}
					} ?></td>
          <td bgcolor="#FFFFFF" class="detalle"><? echo Cfecha2($fAlumno['fecha_nac']) ?></td>
          <td bgcolor="#FFFFFF" class="detalle" width="70"><? echo $fAlumno['nom_com'] ?></td>
          <?
		  $jj++;
		  
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
			$decima = substr($promedio_nota,0,1);
			$centecima = substr($promedio_nota,1,1);
			if($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661){
				$promedio_nota =$decima.",".$centecima;
			}
			if($modo_eval==1 and $promedio_nota==0){
				if (($_INSTIT==1579) or ($situacion_final == "Y") or ($_INSTIT==1653) or ($_INSTIT==24977) or ($_INSTIT==9239) or ($_INSTIT==1672) or ($_INSTIT==2090) or ($_INSTIT==1973) or ($_INSTIT==14860) or ($_INSTIT==1515) or ($_INSTIT==12086) or ($_INSTIT==287)  or ($_INSTIT==1741 and $cod_subsector!=11)){
				     $promedio_nota="&nbsp;";
				}elseif($institucion==5661){
					$promedio_nota="-";		
				}else{
				     $promedio_nota="EX";
			    }
			}
			
		}else{
		   
			if ($fSubsectores['sub_obli']==1){
				if ($fSubsectores['bool_ip']==1){				    
				      if (($_INSTIT==1672 || $institucion==10232 || $institucion==317) or ($_INSTIT==2090) or ($situacion_final == "Y")){
					 	   $promedio_nota = "&nbsp;"; 
					  }elseif(($_INSTIT==26094) or ($situacion_final == "Y")){
					  		$promedio_nota = "-"; 	
					  }else{	 
						   $promedio_nota = "EX";
					  }	
				}else{
				    $promedio_nota = "&nbsp;";
				}	
			}else{
				if($institucion==1672 || $institucion==769 || $institucion==5661){
					$promedio_nota = "-";
				}else{			
					$promedio_nota = "&nbsp;";
				}
			}	
		}
		
		
		
		//if($existe == 0){			
			if($cod_subsector!=13){?>
          <td align="center" bgcolor="#FFFFFF" class="detalle"><? if ($situacion_final <> "Y") echo $promedio_nota; elseif($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661) echo "---"; else echo "&nbsp;&nbsp;&nbsp;&nbsp;"; ?></td>
          <? }}//} ?>
          <td align="center" bgcolor="#FFFFFF" class="detalle"><? if ($situacion_final <> "Y") echo $promedio; elseif($_INSTIT==769 || $_INSTIT==5661) echo "---"; else echo "&nbsp;&nbsp;&nbsp;&nbsp;"; ?>&nbsp;</td>
     
	 
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
			$sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ramo = ".$id_ramo." and rut_alumno = ".$alumno." and id_curso = ".$curso;
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
			    if ($fSubsectores['bool_artis']==1){
				    $promedio_nota = "&nbsp;";
				}else{
				    $promedio_nota = "N/O";
				}
				//$promedio_nota = "EX"; // cambio solicitado por el coyancura
	        }	
		}
		  if($cod_subsector==13){ ?>
          <td align="center" bgcolor="#FFFFFF" class="detalle">
		        <? if ($situacion_final <> "Y"){
			         if ($_INSTIT==9566){
					   if($promedio_nota > 0){ 					 
							 $promedio_nota = Conceptual($promedio_nota , 1);					 
							 echo $promedio_nota;
						}else{
							 echo  $promedio_nota;
						}
						
					 }else{
					   /*  if ($institucion==9239){
						      echo "N/O";
						 }else{	*/
						      if (($institucion==1653 or $institucion==9239 or $institucion==12086) and (trim($promedio_nota)=="EX" or trim($promedio_nota)==0) or trim($promedio_nota)=="-"){
							       echo "N/O";
							  }else if($institucion==1756 AND trim($promedio_nota)=="EX"){
							  		echo "&nbsp;";
							  }else{
					               echo $promedio_nota."&nbsp;";
							  }	   
						 //}	  
					 
					 }			
				  }else{
				       if($_INSTIT==769 || $_INSTIT==5661){
						 echo "---";
					}else{
						echo "&nbsp;";
					}
			      } ?></td>
          <? }} ?>
		  <td align="center" bgcolor="#FFFFFF" class="detalle"><? if ($situacion_final <> "Y") echo $asistencia; elseif($_INSTIT==769 || $_INSTIT==1436 || $_INSTIT==5661) echo "---"; else echo " "; ?>&nbsp;</td>
          <td align="center" bgcolor="#FFFFFF" class="detalle"><? echo $situacion_final ?>&nbsp;</td>
          <td bgcolor="#FFFFFF" class="detalle" width="150"><? echo $observacion."&nbsp;"; ?></td>
        </tr>
        <?
		}
		
		 } ?>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="1021" align="left">	  <font face="Arial, Helvetica, sans-serif" size="-2">
	  Codigos :        Promovido= P       Reprobado =  R       Retirado =  Y					Masculino = 1   -   Femenino = 2 *******
	  Nota :   La asignatura de Religi&oacute;n no tiene incidencia en su promedio general de calificaciones ni en la situaci&oacute;n final del alumno.															
	  </font></td>
  </tr>
</table>	  
      <?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
      <table width="1000" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1030" align="left" valign="top">&nbsp;
              <table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#E9E9E9">
                <tr valign="top">
                  <td width="48" class="titulo" >COD</td>
                  <td width="236" class="titulo" >SUBSECTOR</td>
                  <td width="237" class="titulo" >NOMBRES Y APELLIDOS DEL PROFESOR </td>
                  <td width="75" class="titulo" >RUN</td>
                  <td width="136" class="titulo" >TITULADO / HABILITADO </td>
                  <td width="154" class="titulo"><? if($institucion==5661){ echo "OBSERVACIONES"; }else{ echo "FIRMA"; } ?></td>
                </tr>
                <?
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
		$sql_dicta = $sql_dicta . "where dicta.id_ramo = ".$id_ramo." ";
		$sql_dicta = $sql_dicta . "and dicta.rut_emp = empleado.rut_emp ";
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
			if ($nivel_temp==1){$titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);}
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
				if (@in_array($cod_subsector,$arreglo_temp) and $fDicta['fecha_resol']!=NULL){
					$titulo = "H / Res Nº ".$fDicta['nu_resol']." de ".Cfecha2($fDicta['fecha_resol']);
				}
				
			}	
			
		/// nuevo cï¿½digo para ver que la habilitaciï¿½n corresponde para el tipo de enseï¿½anza
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
				   /* if ($institucion==9827){
					    $titulo = "H";
					}else*/ if($institucion==5661){
						$titulo = "Aut/Hab Nº ".$fil_1['resolucion']." de ".Cfecha($fil_1['fecha']);
					/*}elseif($institucion==10232){
				        $titulo = "H / Res Nº ".$fil_1['resolucion']." de ".substr($fil_1['fecha'],0,4)."/V.";*/
					}else{
				        $titulo = "H / Res Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
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
			}
			
			 if ($institucion == 1593){
				 $titulo = "Titulado";
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
		
		if($institucion==2278 and ($fSubsectores['cod_subsector']==13  or $fSubsectores['cod_subsector']==568)){
					$obshabilitado = "H / Res Nº ".$fil_1['resolucion']." de ".Cfecha2($fil_1['fecha']);
					$titulo = "T";
		}
		
		if ($titulo==NULL){ $titulo = "Indeterminado"; }
		
?>
                <tr>
                  <td class="detalle"><? echo $fSubsectores['cod_subsector'] ?></td>
                  <td class="detalle"><? echo $fSubsectores['nombre'] ?></td>
                  <td class="detalle"><? echo strtoupper(trim($fDicta['ape_pat']." ".$fDicta['ape_mat']." ".$fDicta['nombre_emp'])) ?></td>
                  <td class="detalle"><? if ($fDicta['rut_emp']>0){ ?><? echo $fDicta['rut_emp']."-".$fDicta['dig_rut'] ?> <? } ?></td>
                  <td class="detalle"> 
				  <?
				  if ($institucion=="1653" and $fSubsectores['cod_subsector']=="13"){
				     echo "Autorizacion a no impartir religi&oacute;n, resoluci&oacute;n exenta nº 01899 del 08 de Junio 2009";
				  }else{	
				       if ($fDicta['rut_emp']=="14538552"  and 	$grado_curso!="5" and $grado_curso!="6"){
					   	   echo "T"; 				   
					   }else{  		  
				         	if(($_INSTIT==769 || $_INSTIT==9853 || $_INSTIT==1741 || $_INSTIT==1436 || $_INSTIT==5661) and $titulo=="T"){
								echo "Tit";
							}elseif(($_INSTIT==769 || $_INSTIT==9853  || $_INSTIT==1741 || $_INSTIT==1436)  and $titulo!="T"){
								echo "Hab";
							}else{  
					           echo $titulo;
							}
					   }	   
				  }	 
				  ?></td>
                  <td>&nbsp;</td>
                </tr>
                <? }?>
            </table>
              <br>
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
	
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
//------------------ TOTAL MATRICULA HOMBRES Ingresos entre el 1ï¿½ Mayo y 29 Noviembre
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-12-15' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and matricula.id_curso=" . $curso . "";
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
//------------------ TOTAL MATRICULA MUJERES Ingresos entre el 1ï¿½ Mayo y 29 Noviembre
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_ano = ".$ano." and matricula.fecha > '".$ano_escolar."-04-30' and matricula.fecha < '".$ano_escolar."-12-15' and id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and matricula.id_curso=" . $curso . " ";
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
// ALUMNOS retirados entre el 1ï¿½ de mayo y el 29 de noviembre - HOMBRES
//----------------------------------------------------------------
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 2 and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-12-15') ";
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
// ALUMNOS retirados entre el 1ï¿½ de mayo y el 29 de noviembre - MUJERES
//----------------------------------------------------------------
$sql="";
if ($_INSTIT==9071){
    $sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.id_ano = ".$ano." and matricula.id_curso = $curso and matricula.rut_alumno = alumno.rut_alumno and alumno.sexo = 1 and matricula.bool_ar = 1 and (matricula.fecha_retiro  > '".$ano_escolar."-04-30' and matricula.fecha_retiro  < '".$ano_escolar."-12-15') ";
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
/*if($corporacion==13){
	$fecha_mat = "01-12-".$ano_escolar;
}else{*/
	$fecha_mat = "12-01-".$ano_escolar;
//}
//$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '12-01-".($ano_escolar)."' and id_ano = ".$ano . " and matricula.bool_ar=0 and matricula.rut_alumno = alumno.rut_alumno" ;
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$fecha_mat."' and id_ano = ".$ano . " and matricula.bool_ar=0 and matricula.rut_alumno = alumno.rut_alumno" ;
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
/*if($corporacion==13){
	$fecha_mat = "01-12-".$ano_escolar;
}else{*/
	$fecha_mat = "12-01-".$ano_escolar;
//}
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$fecha_mat."' and id_ano =". $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 2 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
/*if($corporacion==13){
	$fecha_mat = "01-12-".$ano_escolar;
}else{*/
	$fecha_mat = "12-01-".$ano_escolar;
//}
$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.fecha < '".$fecha_mat."' and id_ano =" . $ano . " and alumno.rut_alumno = matricula.rut_alumno and alumno.sexo = 1 and (matricula.bool_ar=0)";
$resultado = pg_exec($conn,$sql);
$num_resultado = @pg_numrows($resultado);

$contador=0;

for ($i=0; $i < $num_resultado; $i++){
    $fila2 = @pg_fetch_array($resultado,$i);
	$rut_alumno = $fila2['rut_alumno'];
	$dig_rut    = $fila2['dig_rut'];
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or $institucion==11209 or $institucion==2163){
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
	
	if ($cod_region==5 or  $institucion==11209 or $institucion==2163){
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

?><table width="778" align="left" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" class="titulo">
               <tr>
                  <td colspan="3" bordercolor="#000000">RESULTADO GENERAL DEL CURSO</td>
                  <td width="927" bordercolor="#000000"></td>
                  <td width="4" bordercolor="#000000">&nbsp;</td>
                  <td width="1" colspan="3" rowspan="13" bordercolor="#000000" ></td>
                  </tr>
               <tr>
                 <td width="241" align="left" bordercolor="#000000">Matr&iacute;cula Final</td>
                 <td width="45" align="left" bordercolor="#000000"><?php echo $activos ?></td>
                 <td width="63" align="left" bordercolor="#000000">Alumnos</td>
                 <td width="927" rowspan="10" bordercolor="#000000" ><table width="586" border="0" align="center" bgcolor="#FFFFFF" class="titulo" >
                   <tr>
                     <td width="3">&nbsp;</td>
                     <td width="249">&nbsp;</td>
                     <td width="55">&nbsp;</td>
                     <td width="249">&nbsp;</td>
                     <td width="10">&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                    <?
					$sql_actas = "select * from curso where id_curso = '$curso'";
					$res_actas = @pg_Exec($conn, $sql_actas);
					$fila_actas = @pg_fetch_array($res_actas);
					$encargado_acta = trim($fila_actas['acta']);

					?>
                     <td>&nbsp;</td>
                     <td align="center"><? if($institucion!=1672) echo"<img src='../../empleado/firma_digital/$encargado_acta.jpg' width='200' height='50'>";?></td>
                     <td>&nbsp;</td>
                     <td align="center"><? if($institucion!=1672) echo "<img src='../../empleado/firma_digital/$rut_profesor.jpg' width='200' height='50'>";?></td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td align="center">
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
				?> 
                       <? if(trim($encargado) == ","){ ?>
                       <? }else{ ?>
                       <font face="Arial, Helvetica, sans-serif" size="1">
                         <?=$encargado?>
                       </font>
                       <? } 
				// FIN VEL
				?>
                       <br/>
                       <? if ((($grado_curso==1 or $grado_curso==2)and $ense==310) and $institucion==516){ 
				           echo "ENCARGADO CONFECCI&Oacute;N DEL ACTA <br> SRA. MYRIAM SEGURA";
					 }else{
					      if ((($grado_curso==3 or $grado_curso==4)and $ense==310) and $institucion==516){
						       echo "ENCARGADO CONFECCI&Oacute;N DEL ACTA <br> SRA. SONIA GUERRERO";
						  }else{
						       ?>
                       ENCARGADO CONFECCI&Oacute;N DEL ACTA
                       <?
						  }
					  }
					  ?>                       </td>
                     <td>&nbsp;</td>
                     <td align="center"><? echo strtoupper($Nombre_Profe);?><br>
                       PROFESOR JEFE </td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="3" align="center"><? if($institucion!=1672) echo "<img src='../../empleado/firma_digital/$encargado_acta.jpg' width='200' height='50'>";?></td>
                     <td>&nbsp;</td>
                     </tr>
                   <tr>
                     <td>&nbsp;</td>
                     <td colspan="3" align="center">
                       <?php 
				  
				 
				  
				  if ($institucion == 9566){
							echo "PAVEZ MENESES ROBERTO";
						} 
						
						if ($institucion == 24511){
							echo "MARCELO MEZA GOTOR";
						} 
						/*if ($institucion == 24907){
							echo "PEDRO DOMANCIC KRUGER";
						} */
						else {
 							 echo strtoupper($Nombre_Dir); }
							 
							
							 
					?>
                       <br>                       <? if ($institucion==9239 or $institucion==1436 || $institucion==24907){
					     echo "DIRECTOR";
					   }else{
					         if ($institucion==769){
							     echo strtoupper($Nombre_Rec);
								 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECTOR";
							 }else{
							     
					              if ($institucion==25478){
								       echo "RECTOR";
								  }else{
								       
					                        echo "JEFE ESTABLECIMIENTO";
									   		
								  }	 
						     }		 
					   }
					   if ($institucion == 14912){ 
				  echo "<br>Hno. Manuel Mart&iacute;n Chilla Cruz csv";
				  }
					   ?>                       </td>
                     <td>&nbsp;</td>
                     </tr>
                   
                 </table></td>
                 </tr>
               <tr>
                 <td bordercolor="#000000">&nbsp;Promovidos</td>
                 <td align="left" bordercolor="#000000"><? echo $aprobados ?></td>
                 <td bordercolor="#000000">Alumnos</td>
                 </tr>
               <tr>
                 <td bordercolor="#000000">&nbsp;Reprobados por Inasistencia</td>
                 <td align="left" bordercolor="#000000"><? echo $reprovados_hombre + $reprovados_mujer ?></td>
                 <td bordercolor="#000000">Alumnos</td>
                 </tr>
               <tr>
                 <td bordercolor="#000000">&nbsp;Reprobados por Rendimiento</td>
                 <td align="left" bordercolor="#000000"><? echo $reprovados_hombre1 + $reprovados_mujer1 ?></td>
                 <td bordercolor="#000000">Alumnos</td>
                 </tr>
               <tr>
                 <td bordercolor="#000000">&nbsp;Retirados durante el a&ntilde;o</td>
                 <td align="left" bordercolor="#000000"><?php echo $retirados ?></td>
                 <td bordercolor="#000000">Alumnos</td>
                 </tr>
               <tr>
                 <td valign="top" bordercolor="#000000">&nbsp;Total Reprobados</td>
                 <td align="left" valign="top" bordercolor="#000000"><? echo $reprovados_hombre + $reprovados_mujer + $reprovados_hombre1 + $reprovados_mujer1 ?></td>
                 <td valign="top" bordercolor="#000000">Alumnos</td>
                 </tr>
               <tr>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 </tr>
               <tr>
                 <td valign="top" bordercolor="#000000">Situaci&oacute;n Final:</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 </tr>
               <tr>
                 <td colspan="3" valign="top" bordercolor="#000000">P=Promovidos R=Reprobados Y=Retirados</td>
                 </tr>
               <tr>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 <td valign="top" bordercolor="#000000">&nbsp;</td>
                 </tr>
               <tr>
                 <td colspan="3" valign="top" bordercolor="#000000">Observaciones:</td>
                 <td width="927" bordercolor="#000000">&nbsp;</td>
                 </tr>
               <tr>
                 <td colspan="4" valign="top" bordercolor="#000000"><? 
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
				if($institucion==2278){
					echo "OBSERVACIONES :".$obshabilitado;
				}else{
		 		if($observaciones==""){?>		 			
	            	OBSERVACIONES:|______________________________________________________________________________________________________________________________________________
			<?	}else{ ?>
					OBSERVACIONES:&nbsp;<u>
					<?=$observaciones;?>
					</u>
			<? } 
			}
//FIN VEL			?>
		
	      <? } ?>	<? } ?>
	      <br>
	      <br></td>
                 </tr>
               </table>
              <!--<table width="778" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="171" bordercolor="#000000"><span class="titulo">RESULTADO GENERAL DEL CURSO </span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">M</span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">F</span></td>
                  <td align="center" bordercolor="#000000"><span class="titulo">TOTAL</span></td>
                  <td width="27">&nbsp;</td>
                  <td width="144">&nbsp;</td>
                  <td width="4">&nbsp;</td>
                  <td width="152">&nbsp;</td>
                  <td width="13">&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">MATRICULA:</span></td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td bordercolor="#000000">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Matr&igrave;cula 30 Abril (inicial)</span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_hombre  ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_mujer?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_inicial_hombre+$matricula_inicial_mujer ?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="detalle">Ingresos entre el 1º Mayo y <? if ($_INSTIT==9071){ ?> 30 Noviembre <? } else{ ?> 29 Noviembre  <? } ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_hombre ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_mujer ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $matricula_1_hombre +  $matricula_1_mujer?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  
            <td bordercolor="#000000"><span class="detalle">Retirados entre 1º Mayo y <? if ($_INSTIT==9071){ ?> 30 Noviembre <? } else{ ?> 29 Noviembre  <? } ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados1 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados2 ?></span></td>
                  <td align="center" bordercolor="#000000"><span class="detalle"><? echo $retirados1 + $retirados2 ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle"></span><span class="detalle">Matr&igrave;cula 30 Noviembre (final) </span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $matriculados ?></span></td>
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
					
					if ($fila_encargado['nombre_emp']!=NULL){				
					     $encargado = $fila_encargado['ape_pat']." ".$fila_encargado['ape_mat'].", ".$fila_encargado['nombre_emp'];		
					}else{
					     $encargado = "&nbsp;";
					}
					$observaciones = $fila_actas['observaciones'];?>
				
				
				  <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><u>___________________<br></u></font></td>
				 
				  <td>&nbsp;</td>
                  <td align="center"><font face="Arial, Helvetica, sans-serif" size="1"><u>___________________</u></font></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Promovidos</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $aprobados ?></span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="detalle"><font face="Arial, Helvetica, sans-serif" size="1">
                    <?=$encargado?>
                  <br>
                  ENCARGADO CONFECCI&Oacute;N DEL ACTA </font></span></td>
                  <td>&nbsp;</td>
                  <td align="center"><span class="detalle"><font face="Arial, Helvetica, sans-serif" size="1"><? echo strtoupper($Nombre_Profe);?><br>PROFESOR JEFE </font></span></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Reprobados por Inasistencia</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_mujer ?></span></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td bordercolor="#000000"><span class="detalle">Reprobados por Rendimiento</span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center">________________________</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="detalle">Total Reprobados </span></td>
                 <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_hombre1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_mujer + $reprovados_mujer1 ?></span></td>
                  <td bordercolor="#000000" align="center"><span class="detalle"><? echo $reprovados_hombre + $reprovados_mujer + $reprovados_hombre1 + $reprovados_mujer1 ?></span></td>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><span class="detalle"><font face="Arial, Helvetica, sans-serif" size="1">
				  <?php if ($institucion == 9566){
							echo "PAVEZ MENESES ROBERTO";
						} 
						if ($institucion == 24511){
							echo "MARCELO MEZA GOTOR";
						} 	
						if ($institucion == 24907){
							echo "PEDRO DOMANCIC KRUGER";
						} 
						else {
 							 echo strtoupper($Nombre_Dir); }
					?><br>
					<? if ($institucion==9239 or $institucion==1436 ){
					     echo "DIRECTOR";
					   }else{
					         if ($institucion==769){
							     echo strtoupper($Nombre_Rec);
								 echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECTOR";
							 }else{
							      if ($institucion==25478 || $institucion==24907){
								       echo "RECTOR";
								  }else{
								       if ($institucion==1436){
									   		echo "DIRECTORA";
									   }else{
					                        echo "JEFE ESTABLECIMIENTO";
									   }		
								  }	   
							}	 
					   }
					    if ($institucion == 14912){ 
				       echo "<br>Hno. Manuel Martï¿½n Chilla Cruz csv";
				       }
					   ?>
					</font>
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
            </table>--></td>
        </tr>
</table>
	<!--<table width="1000" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td align="left"><span class="detalle">
	<? if ((($grado_curso==4 or $grado_curso==3)and $ense==310) and $institucion==11106){ ?>
	    OBSERVACIONES: Visi&oacute;n Sistematica de la Organizaci&oacute;n, una herramienta de gesti&oacute;n, Resoluci&oacute;n Exenta 2688, 29/10/2002 MINEDUC IV REGION.
	
	
	<? }else{
	        if ((($grado_curso==4 or $grado_curso==3 or $grado_curso==1 or $grado_curso==2)and $ense==110) and $institucion==1756){ ?>
			    OBSERVACIONES: Idioma Extranjero (Ingles), Resoluci&oacute;n Exenta 3926 de 2005.
		 <?	}else{ 	
//VEL		 
			 if($institucion==2278){
					echo "OBSERVACIONES :".$obshabilitado;
				}else{
		 			if($observaciones==""){?>		 			
	            	OBSERVACIONES:|______________________________________________________________________________________________________________________________________________
			<?	}else{ ?>
					OBSERVACIONES:&nbsp;<u><?=$observaciones;?></u>
			<? } 
			} 
//FIN VEL			?>
	      <? } ?>
	<? } ?>
	
	
	</span></td>
  </tr>
  <tr>
<? if($observaciones==""){?>
    <td align="left"><span class="detalle">_______________________________________________________________________________________________________________________________________________________________</span></td>
<? } ?>  	
  </tr>
 
</table>-->
 <tr>
    <td align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ucwords(strtolower($comuna)).", ".$dia." de ".$mes." de ".$ano2 ?></font></td>
    </tr>  
      </table>
	  </div>
      <?
//echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

?>
<!--  Comentado tabla de subsectores.  motivo: paulina lo pidio explicacion : el MINEDUC no lo pide
<div align="center">
<font face="Arial, Helvetica, sans-serif"><strong>TABLA DE SUBSECTORES PARA <? echo $curso_pal." ".$tipo_ensenanza?></strong></font>
	<table width="600" border="1" cellspacing="1" cellpadding="3">
  <tr>
    <td align="center"><font face="Arial, Helvetica, sans-serif"><strong>Cï¿½digo Subsector</strong></font></td>
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

<font face="Arial, Helvetica, sans-serif">ESTA HOJA NO SE ADJUNTA AL ACTA IMPRESA POR AMBAS CARAS<br>ES SOLO UNA GUï¿½A PARA LOS USUARIOS</font>	
</div>
-->



<!-- FIN CUERPO DE LA PAGINA -->
</div>
</body>
</html>
<? pg_close($conn);?>
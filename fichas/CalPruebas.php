<?php require('../util/header.inc');
include ("Calendario/calendario.php");


?>
<?php 
	
	session_start();
	

		
		if($_ANO==""){
		 	$qry="SELECT * 
	FROM MATRICULA INNER JOIN ano_Escolar ON matricula.id_ano=ano_Escolar.id_ano
	WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." and situacion=1 AND bool_ar=0 ORDER BY ano_escolar.ID_ANO DESC";
	
	//die($sql);
	
	
			$result = @pg_Exec($conn,$qry);
			if (!$result){
				error('<b>ERROR :</b>No se puede acceder a la base de datos.4'.$qry);
			}elseif(pg_numrows($result)==0){
				
			}else{
				$fila = @pg_fetch_array($result,0);	
				$_ANO=$fila["id_ano"];
				session_register('_ANO');
				
				$_NANO=$fila["nro_ano"];
				session_register('_NANO');
	
				$_CURSO=$fila["id_curso"];
				session_register('_CURSO');
				
			};
		}
		
		else{
		
	$qry="SELECT * 
	FROM MATRICULA INNER JOIN ano_Escolar ON matricula.id_ano=ano_Escolar.id_ano
	WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." and situacion=1 AND bool_ar=0 and matricula.id_ano=".$_ANO." ORDER BY ano_escolar.ID_ANO DESC";
	
	//die($sql);
	
	
			$result = @pg_Exec($conn,$qry);
			if (!$result){
				error('<b>ERROR :</b>No se puede acceder a la base de datos.4'.$qry);
			}elseif(pg_numrows($result)==0){
				
			}else{
				$fila = @pg_fetch_array($result,0);	
				$_ANO=$fila["id_ano"];
				session_register('_ANO');
				
				$_NANO=$fila["nro_ano"];
				session_register('_NANO');
	
				$_CURSO=$fila["id_curso"];
				session_register('_CURSO');
				
			};
		
		
		}
		
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	

		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');
	/******* FIN MODIFICACION********************/


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =1;
	

	
	
	$sql ="SELECT bloqueo FROM alumno WHERE rut_alumno=".$alumno;
	$rs_bloqueo =pg_exec($conn,$sql);
	$bloqueo =pg_result($rs_bloqueo,0);
	if($bloqueo==1){
		echo "<script>alert('ALUMNO SE ENCUENTRA MOROSOS EN MENSUALIDAD, FAVOR ACERCARSE A ADMINISTRACION')</script>";	
		echo "<script>window.location='http://www.colegiointeractivo.com'</script>";
	}

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
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$sql_curso = "SELECT truncado_per,truncado_final,bool_psemestral, ensenanza,grado_curso FROM curso WHERE id_curso=".$curso;
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso = @pg_fetch_array($result_curso,0);
	$truncado_per = $fila_curso['truncado_per'];
	$truncado_final = $fila_curso['truncado_final'];
	$truncado_periodo = $fila_curso['bool_psemestral'];
	$ensenanza = $fila_curso['ensenanza'];
	$grado = $fila_curso['grado_curso'];
	
	//----------------------------------------------------------------------------
	// ALUMNO
	//----------------------------------------------------------------------------		
	$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	//echo $sql_alumno;
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$fila_alumno = @pg_fetch_array($result_alumno,0);
	$rut_alumno = strtoupper($fila_alumno['rut_alumno'] . " - " . $fila_alumno['dig_rut']);
	$nombre = ucwords(strtolower($fila_alumno['ape_pat']))." ".ucwords(strtolower($fila_alumno['ape_mat']))." ".ucwords(strtolower($fila_alumno['nombre_alu']));
	//----------------------------------------------------------------------------
	// A�O ESCOLAR
	//----------------------------------------------------------------------------	
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano = @pg_Exec($conn, $sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = 	$fila_ano['nro_ano'];
	//-----------------------------------------	

	//-----------------------------------------------------------
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<link rel="stylesheet" href="../admin/clases/jquery-ui-1.8.14.custom/development-bundle/themes/base/jquery.ui.all.css">
<script src="../admin/clases/jquery/jquery.js"></script>
<script language="JavaScript" src="Calendario/javascripts.js"></script>

<script>
function filtraFecha(){
	
	
	var funcion =1;
	var fecha = $("#filfecha").val();
	var parametros='funcion='+funcion+'&fecha='+fecha;
	
		$.ajax({
	  url:'funcficha.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#cal").html(data);
		
		 
		  }
	  })
	

}
</script>

    <style>
  div.ui-datepicker{
 font-size:12px;
}
  </style>
</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->							  
								  
								  
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="tableindex"><div align="center">CALENDARIO EVALUACIONES</div></td>
  </tr>
</table><br>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td class="textosimple" align="right"><div ><form name="form" id="form">Filtrar por fecha&nbsp;<input id="filfecha" type="text" name="filfecha" ><?php if($_PERFIL==15 || $_PERFIL==16){echo escribe_formulario_fecha_vacio("filfecha", "form", "", ''); }?> &nbsp;&nbsp;&nbsp;<input type="button" class="botonXX" value="Filtrar" onclick="filtraFecha()"></form></div></td>
  </tr>
</table><br>

<br>
<?php 
 $sql_ram="select p.*,s.nombre as asignatura,e.nombre_emp||' '||e.ape_pat as profesor
from cal_pruebas_new p inner join ramo r on r.id_ramo = p.id_ramo 
inner join subsector s on s.cod_subsector = r.cod_subsector
inner join dicta d on d.id_ramo = r.id_ramo
inner join empleado e on e.rut_emp = d.rut_emp 
where r.id_curso = $_CURSO and  p.fecha_inicio>='".$nro_ano."-".date("m-d")."' order by fecha_inicio asc";
$rs_ram = pg_exec($conn, $sql_ram);
?>
<div id="cal">
<table width="650" border="1" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse">
  
  <tr class="tableindex">
    <td align="center">Fecha</td>
    <td align="center">Hora</td>
    <td align="center">Asignatura</td>
    <td align="center">Docente</td>
    <td align="center">Contenido</td>
    <td align="center">Archivo</td>
    </tr>
 <?php  for($r=0;$r<pg_numrows($rs_ram);$r++){
	 $filar = pg_fetch_array($rs_ram,$r);
	 ?>
  <tr style="font-size:12px">
    <td align="center"><?php echo CambioFD($filar['fecha_inicio']) ?></td>
    <td align="center"><?php echo $filar['hora'] ?></td>
    <td align="center"><?php echo $filar['asignatura'] ?></td>
    <td align="center"><?php echo $filar['profesor'] ?></td>
    <td align="center"><?php echo utf8_decode($filar['descripcion']) ?></td>
    <td align="center">
    <?php if($filar['archivo']!=""){?>
    <a href="../admin/institucion/ano/curso/ramo/CalPruebasNew/files/<?php echo $filar['archivo'] ?>" target="_blank">
    <img src="../admin/clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/download.png" width="16" height="16"></a>
    <?php }?></td>
    </tr>
  <?php }?>
</table>
</div>
<br>

 <table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>
 <br>
 <table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="650">&nbsp;</td>
  </tr>
</table>
 		
</center>

								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>



	

   
	

</body>
</html>
<? pg_close($conn);?>
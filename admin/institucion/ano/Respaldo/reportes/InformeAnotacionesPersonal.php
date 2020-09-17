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
			if (form.cmb_empleado.value!=0){
				form.cmb_empleado.target="self";
				form.action = 'InformeAnotacionesPersonal.php?institucion=$institucion';
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
	$empleado		=$cmb_empleado;
//	$periodo		=$c_periodo;
	$_POSP = 4;
	$_bot = 8;
/*	if($periodo == "")
	{
		$periodo = $cmb_periodos;
	}*/
	
	//----------------------------------------------------------------------------
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	


	//------------------FECHAS DE PERIODOS -----------------------
/*	$sql="";
	if($periodo==0)
	{
		$sql_peri = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		for($i=0;$i<pg_numrows($result_peri);$i++)
		{
			if($i==0) //primer semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];					
			}
			if($i==1) //segundo semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
			if($i==3)//tercer semestre en caso q haya
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
		}	
	}else{
	
	$sql="SELECT fecha_inicio,fecha_termino FROM periodo WHERE id_periodo=".$periodo;
	$Rs_Periodo = @pg_exec($conn,$sql);
	$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
	$fecha_inicio=$fila_Periodo['fecha_inicio'];
	$fecha_termino=$fila_Periodo['fecha_termino'];
	}
	//-----------------------------------------------------------
*/
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			  <?
			  include("../../../../cabecera/menu_superior.php");
			  ?>
			  
                        <!-- FIN DE COPIA DE CABECERA -->
                    
					
					</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <!-- AQUI VA EL MEN{U LATERAL -->
						 <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						 
						 <!--  FIN MENU LATERAL -->
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								     <!-- COPIO LOS BOTONES PARA QUE NO ESTÉN SEPARADOS -->

									<?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
       					 <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  </td></tr> 
</table>
<? } ?>

<!-- FIN DE CONTENIDO DE BOTONES -->


           <!-- INSERTO CUERPO DE LA PÁGINA -->
		   

    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printAsistenciaPersonal.php?&c_empleado=<?=$empleado ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
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
<hr width="650" color=#003b85>
<br><br><br>	 
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
}

 if(($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

}//alumno ?>
<br>
<hr>
</center>
<? }?>
<!-- FIN CUERPO DE LA PAGINA -->


                  <!-- INSETO FORMULARIO DE BUSQUEDA -->
				  
				  <form method "post" action="">
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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

	<tr>
	  <td colspan="2" class="cuadro01"><br>
	  Personal
	  <br>
	    <select name="cmb_empleado" >
          <option value=0 selected>(Todo el Personal)</option>
          <?
		$sql="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
		$result= @pg_Exec($conn,$sql);
		$rut_existe[]="";
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);
			if (in_array($fila[rut_emp],$rut_existe)){}else{
			$rut_existe[]=$fila[rut_emp];?>
          <option value="<? echo $fila["rut_emp"]; ?>" <? if ($fila["rut_emp"]==$c_empleado){ echo "selected";}?>><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_emp"]));?></option>
          <? }
		} 
		?>
              </select>
	    <br></td>
	  </tr>
	<tr>
	  <td width="107" class="textosmediano">&nbsp;</td>
	  <td width="592"><input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','InformeAnotacionesPersonal.php?c_empleado='+cmb_empleado.options[cmb_empleado.selectedIndex].value+'&amp;cmb_empleado='+cmb_empleado.options[cmb_empleado.selectedIndex].value);return document.MM_returnValue" value="Buscar"></td>
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
		  <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
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
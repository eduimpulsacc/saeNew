<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	//if ($periodo==0)
		// exit;
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
	//------------------------
	// Periodo
	//------------------------
	$sql_periodo = "select * from periodo where id_periodo = ".$periodo;
	$result_periodo =@pg_Exec($conn,$sql_periodo);
	$fila_periodo = @pg_fetch_array($result_periodo,0);
	$periodo_pal = $fila_periodo['nombre_periodo'];
	$fecha_ini = $fila_periodo['fecha_inicio'];
	$fecha_ter = $fila_periodo['fecha_termino'];
	$dias_habiles = $fila_periodo['dias_habiles'];
	//------------------------
	
	//----------------------- AÑO ESCOLAR ---------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
				exit();
			}
			// trim($fila['nro_ano']);
		}
	}
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				form.action = 'InformeAsistenciaPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
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
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> 
      
	  					<?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  </td>
	</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>

<?
if ($curso != 0){
   ?>
   <table width="650" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td><div id="capa0">
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeAsistenciaPeriodo.php?c_curso=<?=$c_curso ?>&c_periodos=<?=$c_periodos ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
        </div>
      </div></td>
   </tr>
  </table>
  <?
}

	if ($curso == 0)
	{
		//$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		//$result_curso = @pg_Exec($conn, $sql_curso);
	}
	else
	{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	
	$cantidad_cursos = @pg_numrows($result_curso);
	for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
	{
		$fila_curso = @pg_fetch_array($result_curso,$i);
		$curso = $fila_curso['id_curso'];
		$Curso_pal = CursoPalabra($curso, 0, $conn);
		//----------------------------------------------------
		// DATOS PROFESOR JEFE
		//----------------------------------------------------
		$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql_profe = $sql_profe . "FROM (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
		$sql_profe = $sql_profe . "WHERE (((curso.id_curso)=".$curso.")); ";
		$result_profe = @pg_Exec($conn, $sql_profe);
		$fila_profe = @pg_fetch_array($result_profe ,0);
		$profesor = ucwords(strtoupper($fila_profe['nombre_emp'] . " " . $fila_profe['ape_pat'] . " " . $fila_profe['ape_mat']));

?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center"> 
		  	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
	  </td>
        </tr>
      </table>
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
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex">INFORME DE ASISTENCIA POR PERIODO</td>
    </tr>
  <tr>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
    </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="118"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></div></td>
    <td width="10"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td width="522"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a) Jefe </strong></font></div></td>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor?></font></div></td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21" align="center" class="tablatit2-1">N&ordm;</td>
    <td width="365" align="center" class="tablatit2-1">NOMBRE DEL ALUMNO</td>
    <td width="111" align="center" class="tablatit2-1">DIAS INASISTENTE</td>
    <td width="143" align="center" class="tablatit2-1">PORCENTAJE ASISTENCIA</td>
  </tr>
  <?
/*	$Fecha ="30-04-".trim($fila['nro_ano']);			
	$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno = $sql_alumno . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.") and (fecha<='" . $Fecha . "')) order by ape_pat, ape_mat; ";
	$result_alumno = @pg_exec($conn, $sql_alumno);
	$sql_alumno1 = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno1 = $sql_alumno1 . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno1 = $sql_alumno1 . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.") and (fecha>='" . $Fecha . "')) order by ape_pat, ape_mat; ";
	$result_alumno1 = @pg_exec($conn, $sql_alumno1);
	
	$cantidad_alumnos = @pg_numrows($result_alumno)+@pg_numrows($result_alumno1);
	for($k=0; $k<@pg_numrows($result_alumno); $k++){
		$fila_alumno[$k]=@pg_fetch_array($result_alumno,$k)	
	}
	*/
	/*	for($cont=0 ; $cont < $cantidad_alumnos ; $cont++)
	{
		//$fila_alumno = @pg_fetch_array($result_alumno,$cont);
		$rut_alumno = strtoupper($fila_alumno[$cont]['rut_alumno'] . " - " . $fila_alumno[$cont]['dig_rut']);
		$alumno = $fila_alumno[$cont]['rut_alumno'];
		$nombre_alumno = ucwords(strtolower($fila_alumno[$cont]['ape_pat'])) . " " . ucwords(strtolower($fila_alumno[$cont]['ape_mat'])). " " . ucwords(strtolower($fila_alumno[$cont]['nombre_alu']));
		$sql_asis = "select count(*) as cantidad from asistencia where rut_alumno = ".$alumno." and fecha >= '".$fila_periodo['fecha_inicio']."' and fecha <= '".$fila_periodo['fecha_termino']."'";
		$result_asis = @pg_Exec($conn, $sql_asis);
		$fila_asis = @pg_fetch_array($result_asis,0);
		$inasistencia = $fila_asis['cantidad'];	
		if ($dias_habiles>0)	
			$porcentaje = round((($dias_habiles-$inasistencia)*100)/$dias_habiles,2);
		else
			$porcentaje="100";
*/ 
	$sql_periodo = "select fecha_inicio, fecha_termino, dias_habiles from periodo where id_periodo = '$cmb_periodos'";
	$res_periodo = pg_Exec($conn, $sql_periodo);
	$fila_periodo = pg_fetch_array($res_periodo);
	$sql_alu = "select m.rut_alumno, a.nombre_alu, a.ape_pat, a.ape_mat from matricula m, alumno a where m.id_curso = '$cmb_curso' and m.rut_alumno = a.rut_alumno order by a.ape_pat, a.ape_mat, a.nombre_alu";
	$res_alu = pg_Exec($conn, $sql_alu);
	
	for($i=0; $i<@pg_numrows($res_alu); $i++)
	{
	$x = $i +1;
	$fila_alu = pg_fetch_array($res_alu,$i);
	$sql_asistencia = "select rut_alumno from asistencia where rut_alumno = '$fila_alu[rut_alumno]' and fecha >= '$fila_periodo[fecha_inicio]' and fecha <= '$fila_periodo[fecha_termino]'";
	$res_asistencia = @pg_Exec($sql_asistencia);
	$tot_asistencia = pg_numrows($res_asistencia);
	$sql_justifica = "select count(*) as cantidad from justifica_inasistencia where rut_alumno = '$fila_alu[rut_alumno]' and fecha >= '$fila_periodo[fecha_inicio]' and fecha <= '$fila_periodo[fecha_termino]'";
	$res_justifica = @pg_Exec($sql_justifica);
	$fila_justifica = @pg_fetch_array($res_justifica);
	$justifica = $fila_justifica['cantidad'];
	$justifica_tot =  $tot_asistencia - $justifica;
	$dias_habiles = $fila_periodo['dias_habiles'];
	if ($dias_habiles>0)	
			$porcentaje = round((($dias_habiles-$justifica_tot)*100)/$dias_habiles,2);

?>
  <tr>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $x;?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo trim($fila_alu['ape_pat'])." ".trim($fila_alu['ape_mat']).", ".trim($fila_alu['nombre_alu']);?></font></td>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $justifica_tot;?></font></td>
    <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje."%";?></font></td>
  </tr>
  <? }?>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <? if  (($cantidad_cursos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

} ?>

</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

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
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosimple">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
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
    <td width="61" class="textosimple">Periodo</td>
    <td width="219"><select name="cmb_periodos" class="ddlb_9_x">
			<option value=0 selected>(Seleccione Periodo)</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
	   <? } ?>
    </select></td>
    <td width="80"><div align="right">
      <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','InformeAsistenciaPeriodo.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
    </div></td>
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
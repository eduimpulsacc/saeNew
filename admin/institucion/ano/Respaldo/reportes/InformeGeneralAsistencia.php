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

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 8;
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------
	$curso			=$cmb_curso;
	$fechaini		= $fecha1;
	$fechafin		= $fecha2;	
	$dia1			=substr($fechaini,0,2);
	$mes1			=substr($fechaini,3,2);
	$ano1			=$ano_escolar;
	$dia2			=substr($fechafin,0,2);
	$mes2			=substr($fechafin,3,2);
	$ano2			=$ano_escolar;	
	if (empty($curso)){
	   // exit;
	}else{
	   
	if (!checkdate($mes1,$dia1,$ano1)) 
	{
		echo "FECHA INICIO INVALIDA <br>";
		exit;
	}	
	if (!checkdate($mes2,$dia2,$ano2)) 
	{
		echo "FECHA FINAL INVALIDA <br>"; 
		exit;
	}
	}
	if (empty($curso)){
	    $fecha1			= "";
	    $fecha2			= "";
	}else{	
	    $fecha3			= $fecha1;
	    $fecha4			= $fecha2;
	    $fecha1			= mktime(0,0,0,$mes1,$dia1,$ano1);
	    $fecha2			= mktime(0,0,0,$mes2,$dia2,$ano2);
	    $fecha_1		= $mes1."-".$dia1."-".$ano1;
	    $fecha_2		= $mes2."-".$dia2."-".$ano2;
		$fecha1			= $fecha3;
	    $fecha2			= $fecha4;
	}	
    
	
	if (empty($curso)){
	   // exit;
	}else{
	   
	//-----------------------------------------
	// Instituci�n
	//-----------------------------------------
	$sql_insti = "Select * from institucion where rdb = " . $institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];
	//-----------------------------------------
	// Curso
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//--------------------------------------------
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
	$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql = $sql . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql = $sql . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alumno = @pg_Exec($conn,$sql);
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$sql_habiles = "select sum(dias_habiles) as dias_habiles from periodo where id_ano = ".$ano;
	$result_habiles =@pg_Exec($conn,$sql_habiles);
	$fila_habiles = @pg_fetch_array($result_habiles,0);	
	$dias_habiles = $fila_habiles['dias_habiles'];
	$sw = 0;
	if ($dias_habiles > 0) $sw = 1;
	if ($sw = 0)
	{
		echo "DEBE INGRESAR LOS DIAS HABILES EN EL SECTOR DE PERIODOS";
		exit;
	}
	
	}
	//-----------------------------------------
    	
	
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
          <td width="90%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
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
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
         <?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  
	  
	  
	  
 </td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<?
if (empty($curso)){
  ## no hace nada
}else{
   ?>  

  <form action="" method="get">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div align="right">
	<div id="capa0">
      <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeGeneralAsistencia.php?cmb_curso=<?=$cmb_curso ?>&fecha1=<?=$fecha1 ?>&fecha2=<?=$fecha2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
	 </div>
    </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="125" align="center">
			<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c�digo para tomar la insignia

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
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono :<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="center" class="tableindex">INFORME DE ATRASOS E INASISTENCIAS</td>
  </tr>
  <tr>
	<? 
	$fecha_inicial = $dia1." ".$mes1." ".$ano1;
	$fecha_inicial = fecha_espanol($fecha_inicial);  
	$fecha_final = $dia2." ".$mes2." ".$ano2;
	$fecha_final = fecha_espanol($fecha_final);
	?> 
	                <td align="center"><strong><font size="1" face="verdana, arial, geneva, helvetica">Del&nbsp;<? echo  $fecha_inicial;?> 
                      hasta&nbsp;<? echo $fecha_final; ?></font></strong></td>
  </tr>
</table>
<br>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
                    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
            <td width="10" ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td width="514" ><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal; ?></font></td>
          </tr>
          <tr>
                    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a) 
                      Jefe</strong></font></td>
            <td ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td ><font size="1" face="arial, geneva, helvetica"><? echo $profe_jefe; ?></font></td>
          </tr>
        </table>
		<br>
		<table width="650" border="1" cellspacing="0" cellpadding="0">
  		  <tr bgcolor="#003b85">
			<td width="18" class="tablatit2-1"><div align="center">N�</div></td>
			<td width="277" class="tablatit2-1"><div align="center">Nombre del Alumno</div></td>
			<td width="114" class="tablatit2-1"><div align="center">Atrasos</div></td>
			<td width="114" class="tablatit2-1"><div align="center">Ausencias</div></td>
			<td width="115" class="tablatit2-1"><div align="center">%</div></td>
    	 </tr>
	<?	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
  	{
	  $fila = @pg_fetch_array($result_alumno,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  $rut_alumno = $fila['rut_alumno'];
	  ?>
	<tr>
    <td height="21" align="center">	<font size="1" face="arial, geneva, helvetica"><? echo $i+1;?></font></td>
    <td>							<font size="1" face="arial, geneva, helvetica"><? echo $nombre_alu;?></font></td>
    <td><div align="center">		<font size="1" face="arial, geneva, helvetica">
	<?
	$sql_atraso = "select count(*) as cantidad from anotacion where tipo = 2 and rut_alumno = ".$rut_alumno." and (fecha >='".$fecha_1."' and fecha <='".$fecha_2."')";
	$result_atraso =@pg_Exec($conn,$sql_atraso);
	$fila_atraso = @pg_fetch_array($result_atraso,0);	
	echo $fila_atraso['cantidad'];
	?>
	</font></div></td>
        <td><div align="center"><font size="1" face="arial, geneva, helvetica">
	<?
	$sql_asis = "select count(*) as cantidad from asistencia where ano = ".$ano." and rut_alumno = ".$rut_alumno." and (fecha >='".$fecha_1."' and fecha <='".$fecha_2."')";
	$result_asis =@pg_Exec($conn,$sql_asis);
	$fila_asis = @pg_fetch_array($result_asis,0);
	$dias_ausente = $fila_asis['cantidad'];
	
	$sql_justi = "select count(*) as cantidad from justifica_inasistencia where ano = ".$ano." and rut_alumno = ".$rut_alumno." and (fecha >='".$fecha_1."' and fecha <='".$fecha_2."')";
	$res_justi = pg_Exec($conn,$sql_justi);
	$fila_justi = pg_fetch_array($res_justi,0);
	$justifica = $fila_justi['cantidad'];
	
	$res_asis =	$dias_ausente - $justifica;
	echo $res_asis;
	?>
	</font></div></td>
    <td><div align="center"><font size="1" face="arial, geneva, helvetica">
	<?
	if ($dias_habiles>0)
	{
		$dias_asistidos = $dias_habiles - $res_asis;
		$procentaje = round(($dias_asistidos * 100)/$dias_habiles,2);
		echo $procentaje."%";
	}
	else
		echo "0%";
	{
	
	}

	?>
	</font></div></td>
  </tr>
  <? }?>
</table>		</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

</center>
</form>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

   <form action="InformeGeneralAsistencia.php" method="post">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>
<center>
<table width="686" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="686" height="43" cellpadding="0" cellspacing="0">
  <tr>
    <td width="865" class="tableindex">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27">
	<table width="684" height="46" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><font size="1" face="arial, geneva, helvetica">Curso</font></td>
    <td><font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso" class="ddlb_9_x">
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
				$fila = @pg_fetch_array($resultado_query_cue,$i); 
				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				if ($fila['id_curso'] == $cmb_curso){
				   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
				}else{
				   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		  } ?>		  
		  
      </select>
    </font></td>
    <td><font size="1" face="arial, geneva, helvetica">Fecha 1</font></td>
    <td><div align="left"><font size="1" face="arial, geneva, helvetica">
        <input name="fecha1" type="text" id="fecha1" size="4" maxlength="6" value="<?=$fecha1 ?>">
    </font></div></td>
    <td><font size="1" face="arial, geneva, helvetica">Fecha 2</font></td>
    <td><div align="left"><font size="1" face="arial, geneva, helvetica">
        <input name="fecha2" type="text" id="fecha2" size="4" maxlength="6" value="<?=$fecha2 ?>">
    </font></div></td>
    <td><div align="right">
      <input name="cb_ok" class="botonXX"  type="submit" value="Buscar">
</div></td>
  </tr>
  <tr>
    <td width="47">&nbsp;</td>
    <td width="337"><font size="1" face="arial, geneva, helvetica">
	  <div align="left">	  </div></font></td>
    <td width="47">&nbsp;</td>
    <td width="59">
	  <div align="left"><font size="1" face="arial, geneva, helvetica">	dd/mm</font></div></td>
    <td width="47">&nbsp;</td>
    <td width="64"><div align="left"><font size="1" face="arial, geneva, helvetica">      dd/mm</font></div></td>
    <td width="83">
          <div align="right">          </div></td></tr>
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

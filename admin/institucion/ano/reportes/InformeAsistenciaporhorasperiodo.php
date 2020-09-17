<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$periodo        = $cmb_periodo;
	
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
			}else{
			    // tomo el numero del año
				$nro_ano = $fila['nro_ano'];
			}			
		}
	}


   /// aqui transformo el mes en palabra
   if ($mes=="01"){
        $mes_pal="Enero";
   }else{
        if ($mes=="02"){
		    $mes_pal="Febrero";
		}else{
		     if ($mes=="03"){
			     $mes_pal="Marzo";
			 }else{
			      if ($mes=="04"){
				      $mes_pal="Abril";
				  }else{
				       if ($mes=="05"){
					       $mes_pal="Mayo";
					   }else{
					       if ($mes=="06"){
						       $mes_pal="Junio";
						   }else{
						        if ($mes=="07"){
								    $mes_pal="Julio";
								}else{
								     if ($mes=="08"){
									     $mes_pal="Agosto";
									 }else{
									     if ($mes=="09"){
										     $mes_pal="Septiembre";
										 }else{
										      if ($mes=="10"){
											      $mes_pal="Octubre";
											  }else{
											       if ($mes=="11"){
												       $mes_pal="Noviembre";
												   }else{
												        if ($mes=="12"){
														    $mes_pal="Diciembre";
														}
												   }
											  }
										 }
								     }
							    }
						   }
					   }
				  }
			 }
	    }
    }
	
$horas_semanales = 0;
for ($dia=0; $dia < 7; $dia++){	
	/// calculo cuantos horas tiene el alumno a la semana y luego en el mes
	$qry_horario = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $curso . " AND a.dia=" . $dia . " union (SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre_taller) AS nombre FROM horario a, taller c WHERE a.id_taller=c.id_taller AND c.rdb=" . $institucion ." AND a.dia=" . $dia . "AND a.id_curso=" . $curso . ") order by hora";
	$res_horario = @pg_exec($conn,$qry_horario);
	$num_horario = @pg_numrows($res_horario);
    $horas_semanales = $horas_semanales + $num_horario;
}
$total_horas_mes = $horas_semanales * 4;

/////////////////////////////////////////////////////////////////////////	
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
				form.action = 'InformeAsistenciaporhorasperiodo.php?institucion=$institucion';
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
								  
								 
<?
if ($periodo > 0){ ?>

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
          <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('printInformeAsistenciaporhorasperiodo.php?c_curso=<?=$curso ?>&c_periodo=<?=$periodo ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
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
    <td align="center" class="tableindex">INFORME MENSUAL DE ASISTENCIA POR HORAS DE CLASE</td>
    </tr>
	<?
	$sql_peri = "select * from periodo where id_periodo = '$periodo'";
	$res_peri = @pg_Exec($conn,$sql_peri);
	$num_peri = @pg_numrows($res_peri);
	$fil_peri = @pg_fetch_array($res_peri,0);
	$nombre_periodo = $fil_peri['nombre_periodo'];
	$fecha_inicio   = $fil_peri['fecha_inicio'];
	$fecha_termino  = $fil_peri['fecha_termino'];
	/// para anaul ///
	if ($periodo==1){	     
	    $fecha_inicio  = $nro_ano."-"."01"."-"."01";
		$fecha_termino = $nro_ano."-"."12"."-"."30";
		$nombre_periodo = "ANUAL";	
	}
	
	$aa_i = substr($fecha_inicio,0,4);
	$mm_i = substr($fecha_inicio,5,2);
	$dd_i = substr($fecha_inicio,8,2);
	
	$aa_t = substr($fecha_termino,0,4);
	$mm_t = substr($fecha_termino,5,2);
	$dd_t = substr($fecha_termino,8,2);
	
	//// para restar las dos fechas /////////
	
	$date1 = mktime(0,0,0,$mm_i,$dd_i,$aa_i);
	$date2 = mktime(0,0,0,$mm_t,$dd_t,$aa_t);
	$total_days = 0;
	while($date1 < $date2) {
	     $total_days++; $date1 += 86400;
	}
	//$total_days;
	$semanas = round($total_days / 7);
	$total_horas_periodo = ($semanas * $horas_semanales);
	
	?>
  <tr>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>PERIODO: <? echo $nombre_periodo; ?></strong></font></div></td>
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
<?

$partedefecha = "$nro_ano"."-"."$mes";

$sql_alu = "select m.rut_alumno, a.nombre_alu, a.ape_pat, a.ape_mat from matricula m, alumno a where m.id_curso = '$cmb_curso' and m.rut_alumno = a.rut_alumno order by a.ape_pat, a.ape_mat, a.nombre_alu";
$res_alu = @pg_Exec($conn, $sql_alu);
$num_alu = @pg_numrows($res_alu);


if ($_INSTIT==770){
    if(ereg("PRIMER", $nombre_periodo)){  /// busca Primer dentro del nombre del periodo, para ver que campo tomar de la tabla curso 
        $total_horas_periodo = $fila_curso['total_horas_1'];
		
    }
	if(ereg("SEGUNDO", $nombre_periodo)){  /// busca segundo dentro del nombre del periodo, para ver que campo tomar de la tabla curso 
        $total_horas_periodo = $fila_curso['total_horas_2'];
		
    }
	if(ereg("TERCER", $nombre_periodo)){  /// busca tercer dentro del nombre del periodo, para ver que campo tomar de la tabla curso 
        $total_horas_periodo = $fila_curso['total_horas_3'];
		
    }
	$total_horas_periodo1 = $fila_curso['total_horas_1'];
	$total_horas_periodo2 = $fila_curso['total_horas_2'];
	$total_horas_periodo3 = $fila_curso['total_horas_3'];
	
	$total_horas_anual = $total_horas_periodo1 + $total_horas_periodo2 + $total_horas_periodo3;
	
}

?>	
<table width="650" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="5%">N&ordm;</td>
    <td width="55%"> Alumno </td>
    <td width="10%">HRS.INAS.</td>
    <td width="10%">HRS.ASIS.</td>
    <td width="10%">% ASIST. </td>
  </tr>
  <?
  for($i=0; $i<$num_alu; $i++){
	     $x = $i +1;
	     $fila_alu = pg_fetch_array($res_alu,$i);
		 $rut_alumno = $fila_alu['rut_alumno'];
	     
		 /// aqui determino cuantas inacistencia ha tenido en el mes
		 $sql_inasis = "select * from inasistencia_asignatura where rut_alumno = '".trim($rut_alumno)."' and ano = '".$ano."' and fecha >= '$fecha_inicio' and fecha <= '$fecha_termino'";
		
		 $res_inasis = @pg_Exec($conn, $sql_inasis);
		 $num_inasis = @pg_numrows($res_inasis);
		 
		 if ($periodo==1){
		     $porcentaje = @round($num_inasis * 100 / $total_horas_anual);
			 $porcentaje = 100 - $porcentaje; 
			 
			 $asistidos  = $total_horas_anual - $num_inasis;
		 
		 }else{		 		 
			 $porcentaje = @round($num_inasis * 100 / $total_horas_periodo);
			 $porcentaje = 100 - $porcentaje; 
			 
			 $asistidos  = $total_horas_periodo - $num_inasis;
		 }	 
		 
		 ?>
		  <tr>
			<td><? echo $x;?></td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo trim($fila_alu['ape_pat'])." ".trim($fila_alu['ape_mat']).", ".trim($fila_alu['nombre_alu']);?></font></td>
			<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $num_inasis ?></font></div></td>
			<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><?=$asistidos ?></font></div></td>
			<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><? echo $porcentaje."%";?></font></div></td>
		  </tr>
		 <?	 
	}
	?>	  
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

<? } // fin if periodo > 0 ?>


<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="InformeAsistenciaporhorasperiodo.php?institucion=$institucion">
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
       </font></div></td>
       <!-- codigo para peridos -->
	   
	 
			
		<td  class="textosmediano"><span class="textosimple">Per&iacute;odo</span></td>
		<td  class="textosmediano">
		  <select name="cmb_periodo" class="ddlb_9_x">
			<option value=0 selected>(Seleccione Periodo)</option>
			<option value=1 selected>ANUAL</option>
			<?
			  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
				 $fila = @pg_fetch_array($result_peri,$i); 
				 if ($fila['id_periodo']==$cmb_periodos){
					echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
				 }else{
					echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
				 }					
			 }
			 ?>
		   </select>
		</td>
			
   
   <!-- fin celda para peridos -->  
   
   
    <td width="80">
	   <div align="right">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
       </div>
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

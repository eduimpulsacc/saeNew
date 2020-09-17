<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$periodo		=$c_periodo;
	$_POSP = 4;
	$_bot = 8;
	if($periodo == "")
	{
	 $periodo = $cmb_periodos;
	}

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
				form.action = 'InformeAnotaciones.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>	

<?	//----------------------------------------------------------------------------
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------------------------------------------------------------------------
	// AÑO ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	// Curso //
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------- PROFE JEFE
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------	
	//------------------FECHAS DE PERIODOS -----------------------
	$sql="";
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
	
	
	////////////// INICIO RESUMEN CURSO    /////////
    $sql_alumno2 = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
	$sql_alumno2 = $sql_alumno2 . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
	$sql_alumno2 = $sql_alumno2 . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
	
	$contadorcurso_positivas = 0;
	$contadorcurso_negativas = 0;
		
	$result_alumno2 = @pg_Exec($conn, $sql_alumno2);
	$cantidad_alumnos2 = @pg_numrows($result_alumno2);
	for($ii=0 ; $ii < @pg_numrows($result_alumno2) ; $ii++)	{
		$fila_alumno2 = @pg_fetch_array($result_alumno2,$ii);
		$alumno2 = $fila_alumno2['rut_alumno'];

		$sql_anota2 = "select * from anotacion ";
		$sql_anota2 = $sql_anota2 . "where rut_alumno = ".$alumno2." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')";
		$sql_anota2 = $sql_anota2 . "order by tipo desc, fecha ";
		$result_anota2 = @pg_Exec($conn, $sql_anota2);
		for($ee=0 ; $ee < @pg_numrows($result_anota2) ; $ee++)	{
			$fila_anota2 = @pg_fetch_array($result_anota2,$ee);
			if ($fila_anota2['tipo_conducta']==1){
				$tipo_conducta = "POSITIVA";
				$contadorcurso_positivas++;	
			}	
					
			
			if ($fila_anota2['tipo_conducta']==2){
				$tipo_conducta = "NEGATIVA";
				$contadorcurso_negativas++;
			}	
										
			if ($fila_anota2['tipo']== 1){
				$tipo = $tipo_conducta;
				$contadorcurso_positivas++;
			}else{
				if($fila_anota2['tipo']==2){
					$tipo = "ATRASO";
					$contadorcurso_negativas++;
				}else{
					 if($fila_anota2['tipo']==3){
						 $tipo = "INASISTENCIA";
						 $contadorcurso_negativas++;
					 }else{
						  if($fila_anota2['tipo']==4){
							  $tipo = "ENFERMERIA";
						  }else{
							   if($fila_anota2["codigo_tipo_anotacion"]!=""){
								   //			$tipo = "AVANZADO";
								   $cod_ta = $fila_anota2["codigo_tipo_anotacion"];
								   $q12 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
								   $r12 = @pg_Exec($conn,$q12);
								   $f1 = @pg_fetch_array($r12,0);
								   $codta   = $f1['codtipo'];
								   $tipo	= $f1['descripcion'];
								   $tipo2	= $f1['tipo'];
								   
								   if ($tipo2==1){
									   $contadorcurso_positivas++;
								   }
								   if ($tipo2==2){
									   $contadorcurso_negativas++;
								   }	   	   
								   
							   }
						  }
					 }
				 }	 	  	   	   
			}
	    }
	} 
 
  
  ////// FIN RESUMEN CURSO /////////  
	

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
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">


           <!-- INSERTO CUERPO DE LA PÁGINA -->
		   
<?
if ($curso != 0){
   ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	<tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td></tr></tablE>
     
      </div></td>
     </tr>
   </table>
   <?
}
?>   
<br>
<?
	if ($alumno > 0)
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.id_ano)=".$ano.")); ";
	}
	else
	{
		$sql_alumno = "SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.fecha_nac, alumno.sexo, alumno.nacionalidad, alumno.telefono, alumno.email, matricula.fecha, alumno.fecha_retiro, matricula.bool_baj, matricula.bool_bchs, matricula.bool_aoi, matricula.bool_rg, matricula.bool_ae, matricula.bool_i, matricula.bool_gd, matricula.bool_ar, matricula.bool_bchs, alumno.calle, alumno.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, alumno.depto, alumno.block, alumno.villa ";
		$sql_alumno = $sql_alumno . "FROM (((matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN region ON alumno.region = region.cod_reg) INNER JOIN provincia ON (alumno.ciudad = provincia.cor_pro) AND (alumno.region = provincia.cod_reg)) INNER JOIN comuna ON (alumno.comuna = comuna.cor_com) AND (alumno.ciudad = comuna.cor_pro) AND (alumno.region = comuna.cod_reg) ";
		$sql_alumno = $sql_alumno . "WHERE (((matricula.id_ano)=".$ano.") and ((matricula.id_curso)=".$curso.")) order by ape_pat, ape_mat; ";
	}	
	$result_alumno = @pg_Exec($conn, $sql_alumno);
	$cantidad_alumnos = @pg_numrows($result_alumno);
	
	$contadoralumno_positivas = 0;
	$contadoralumno_negativas = 0;
	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
	{
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$alumno = $fila_alumno['rut_alumno'];
		$nombre = ucwords(strtoupper($fila_alumno['ape_pat'])) . " " . ucwords(strtoupper($fila_alumno['ape_mat'])) . " " . ucwords(strtoupper($fila_alumno['nombre_alu']));
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
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

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
	
<? } ?>



<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE ATRASOS, ANOTACIONES E INASISTENCIAS</div></td>
    </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="159"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Nombre Alumno</strong></font></td>
          <td width="10"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td width="485"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $nombre?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Jefe</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profe_jefe?></font></td>
        </tr>
  </table>
	 <br>
<?

	$sql_anota = "select * from anotacion ";
	$sql_anota = $sql_anota . "where rut_alumno = ".$alumno." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."')";
	$sql_anota = $sql_anota . "order by tipo desc, fecha ";
	$result_anota = @pg_Exec($conn, $sql_anota);
	if (@pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA ANOTACIONES NI ATRASOS</strong></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		if ($fila_anota['tipo_conducta']==1){
			$tipo_conducta = "POSITIVA";
		    $contadoralumno_positivas++;	
		}	
					
			
		if ($fila_anota['tipo_conducta']==2){
			$tipo_conducta = "NEGATIVA";
			$contadoralumno_negativas++;
		}	
										
		if ($fila_anota['tipo']== 1){
			$tipo = $tipo_conducta;
			//$contadoralumno_positivas++;
		}else{
		    if($fila_anota['tipo']==2){
			    $tipo = "ATRASO";
				$contadoralumno_negativas++;
			}else{
			     if($fila_anota['tipo']==3){
			         $tipo = "INASISTENCIA";
					 $contadoralumno_negativas++;
		         }else{
				      if($fila_anota['tipo']==4){
			              $tipo = "ENFERMERIA";
		              }else{
					       if($fila_anota["codigo_tipo_anotacion"]!=""){
							   //			$tipo = "AVANZADO";
			                   $cod_ta = $fila_anota["codigo_tipo_anotacion"];
			                   $q1 = "select * from tipos_anotacion where id_tipo ='$cod_ta'";
			                   $r1 = @pg_Exec($conn,$q1);
			                   $f1 = @pg_fetch_array($r1,0);
			                   $codta  = $f1['codtipo'];
			                   $tipo	= $f1['descripcion'];
			                   $tipo2	= $f1['tipo'];
							   
							   if ($tipo2==1){
							       $contadoralumno_positivas++;
							   }
							   if ($tipo2==2){
							       $contadoralumno_negativas++;
							   }	   	   
							   
						   }
					  }
				 }
			 }	 	  	   	   
		} 

			
		$fecha = $fila_anota['fecha'];
		$rut_emp = $fila_anota['rut_emp'];
		$sql_emple = "select * from empleado where rut_emp = '$rut_emp'";
		$res_emple = pg_Exec($conn,$sql_emple);
		$fil_emple = pg_fetch_array($res_emple,0);		
		
		$profesor_res = strtoupper($fil_emple['ape_pat'] . " " . $fil_emple['ape_mat'] . " " . $fil_emple['nombre_emp']);
		if (trim($fila_anota['observacion'])=="")
			$observacion = "&nbsp;";
		else
			$observacion = ucfirst($fila_anota['observacion']);
		$hora = $fila_anota['hora'];
		
		
?>		 
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
 <? if($fila_anota['tipo']!=2){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fecha</strong></font></td>
    <td width="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td width="258"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
    <td width="77"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo</strong></font></td>
    <td width="9"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td width="143"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $tipo?></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Responsable </strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profesor_res?></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Hora</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $hora?></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Observaci&oacute;n</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
    <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $observacion?></font></td>
    </tr>
  <?	if($fila_anota["sigla"]!=""){	?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector Aprendisaje</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?
		// busco la sigla
		$sigla_aux = $fila_anota["sigla"];	
		$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$detalle_sigla = $f1['detalle'];
		echo $f1["sigla"];?> - <? echo $detalle_sigla; ?> 
		</font> 
	</td>
  </tr> 
 <?	}	
   if($fila_anota["codigo_tipo_anotacion"]!=""){?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Tipo de Anotación</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php
		$cod_ta = $fila_anota["codigo_tipo_anotacion"];
		$q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$codta       = $f1['codtipo'];
		$descripcion	= $f1['descripcion'];
		if($institucion==9566){
			echo $descripcion;
		}else{
			echo "$codta - $descripcion";
		}
?> 
		</font> 
	</td>
  </tr>  
  <? }	
  if($fila_anota["codigo_anotacion"]!=""){?>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Sub - Tipo</strong></font></td>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
	<td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?php 
		$codigo_anotacion = $fila_anota["codigo_anotacion"];
		$q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1,0);
		$detalle = $f1["detalle"];
		if($institucion==9566){
			echo $detalle;
		}else{
			echo "$codigo_anotacion - $detalle";
		}
		
		?>
		</font> 
	</td>
  </tr> 
  <?	}	?>  
	
</table>
<? }else{ ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Atraso el d&iacute;a </strong></font></td>
	<?	
		$fecha = $fecha;
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);
	?>
    <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha?></font></td>
  </tr>
</table>
<? } ?>
<? } ?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
	$sql_asis = "select * from asistencia where rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_inicio."' and fecha<='".$fecha_termino."') order by fecha";
	$result_asis = @pg_Exec($conn, $sql_asis);
	if (@pg_numrows($result_asis)==0) 
		echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><strong>NO REGISTRA INASISTENCIAS</strong></font><br>";
	for($cont=0 ; $cont < @pg_numrows($result_asis) ; $cont++)
	{
		$fila_asis = @pg_fetch_array($result_asis,$cont);
		$fecha = $fila_asis['fecha'];
		
	$sql_justifica = "select * from justifica_inasistencia where rut_alumno = '$alumno' and ano = '$ano' and fecha = '$fecha'";
	$res_justifica = @pg_Exec($conn,$sql_justifica);
	$fila_justifica = @pg_fetch_array($res_justifica,0);
	$justifica = $fila_justifica['fecha'];	
	 if($justifica == $fecha){
	 	$justificado = true;
	 }else{
	 	$justificado = false;
	 }
	 		
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);	
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="126"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Inasistencia el d&iacute;a </strong></font></td>
    <td width="524"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $fecha;?><strong><? if($justificado==true)echo "&nbsp;&nbsp;&nbsp;(Justificado)";?></strong></font></td>
  </tr>
</table>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
 </table>
<?
 }//asistencia
 
 
 //////  RESUMEN DE ANOTACIONES POSITIVAS Y NEGATIVAS
   
  if ($_INSTIT==12086){ 
   
  ?>
  <table width="650" border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC">
  <tr>
    <td align="center" colspan="2" height="35"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>RESUMEN DE ANOTACIONES </strong></font></td>
  </tr>
  <tr>
    <td width="50%" align="center" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Alumno </strong></font></td>
    <td width="50%" align="center" height="30"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
  </tr>
  <tr>
    <td ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Total anotaciones Positivas&nbsp;&nbsp;&nbsp;: <?=$contadoralumno_positivas; ?></strong></font></td>
    <td ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Total anotaciones Positivas&nbsp;&nbsp;&nbsp;: <?=$contadorcurso_positivas; ?></strong></font></td>
  </tr>
  <tr>
    <td ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Total anotaciones Negativas&nbsp;&nbsp;: <?=$contadoralumno_negativas; ?> </strong></font></td>
    <td ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Total anotaciones Negativas&nbsp;&nbsp;: <?=$contadorcurso_negativas; ?></strong></font></td>
  </tr>
  </table>
  <?
  
  }
    $contadoralumno_positivas = 0;
	$contadoralumno_negativas = 0;
 
 
 
 
 
 
 if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";

}//alumno ?>
<br>
</center>

</body>
</html>
<? pg_close($conn);?>
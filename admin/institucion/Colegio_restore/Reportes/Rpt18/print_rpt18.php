<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?
require('../../../../../util/header.inc');
//include"../Coneccion/conexion.php";
$ano		= $_ANO;
//$conn		= $conexion;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;
$_POSP = 5;
$_bot = 8;




	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);
	
	$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultORI =@pg_Exec($conn,$qryORI);
	$filaORI=@pg_fetch_array($resultORI);
	

	//$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$filaAno['id_ano']." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);



?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt18.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
 <STYLE>
  H1.SaltoDePagina {
     PAGE-BREAK-AFTER: always
  }
  </style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','../../botones/periodo_roll.gif','../../botones/feriados_roll.gif','../../botones/planes_roll.gif','../../botones/tipos_roll.gif','../../botones/cursos_roll.gif','../../botones/matricula_roll.gif','../../botones/informe_roll.gif','../../botones/actas_roll.gif','../../botones/generar_roll.gif')">

  <!-- INSERTO CODIGO SUPERIOR -->
     
 
  <? if ($_PERFIL!=16 ) {?>   
  <table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr> 
        <td>           
        <div id="capa0">
          <input 	name="cmdimprimiroriginal" type="button" class="botonXX" id="cmdimprimiroriginal" onClick="imprimir()" 	value="Imprimir">
        </div>        </td>
    </tr>
  </table>
   <? }?>


<script>
//document.getElementById("capa4").style.display='block';

function imprimir1() 
{
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	//document.getElementById("capa4").style.display='block';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	//document.getElementById("capa4").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
	//document.getElementById("capa4").style.display='block';
	//if
}
</script>
<table width="700" border="0" bordercolor="#FF0000" cellpadding="0" cellspacing="0" >     
  <?
 	if (empty($c_alumno))
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno and matricula.bool_ar = '0' order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	
	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);
	if($filaMatri['grado_curso']==1) $gr="pa";
	if($filaMatri['grado_curso']==2) $gr="sa";
	if($filaMatri['grado_curso']==3) $gr="ta";
	if($filaMatri['grado_curso']==4) $gr="cu";
	if($filaMatri['grado_curso']==5) $gr="qu";
	if($filaMatri['grado_curso']==6) $gr="sx";
	if($filaMatri['grado_curso']==7) $gr="sp";
	if($filaMatri['grado_curso']==8) $gr="oc";

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlAno="select * from ano_escolar where id_ano=".$_ANO;
	$resultAno=@pg_Exec($conn, $sqlAno);
	$filaAno=@pg_fetch_array($resultAno);
	$nro_ano = $filaAno['nro_ano'];
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);

	$titulo1 = $filaPlantilla['titulo_informe1'];
	$nuevo = $filaPlantilla['nuevo_sis'];	

?>  

<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br>";
			   
  }
?>
<tr>
<td>



<table width="650" border="0" align="left">
  <tr> 
    <td valign="top">
	
	   <table width="100%">
	     <tr>
		<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			if 	(!empty($fila_foto['insignia'])){ ?>
			
				  <td width="600">
				  
				  <table width="471" border="0" align="center">
					<tr> 
					  <td align="center"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
					  <?
					  if ($_INSTIT==770){
					     echo "INFORME DE CRECIMIENTO PERSONAL <BR>";
						 if ($filaMatri['ensenanza']==110){
						     echo "EDUCACION BASICA <br>";
						 }
						 if ($filaMatri['ensenanza']==310){
						     echo "EDUCACION MEDIA <br>";
						 } 	
						 
						 echo "AÑO ESCOLAR $nro_ano";
						  
						 
					  }else{ 				  
					  
					         echo $titulo1;
					   }
					   
					   ?>					   
						   </font></div></td>
					</tr>
				  </table>
				  
				  <?
				  if ($_INSTIT!=770){  ?>
					   <table width="471" border="0" align="center">
						<tr> 
						  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']."eee";?><br>
Año <?=$nro_ano;?></font></strong></td>
						</tr>
					  </table>
					  <table width="471" border="0" align="center">
						<tr valign="middle"> 
						  <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
							Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
							de fecha 
							<?php impF($filaInstit['fecha_resolucion'])?>
							Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
							</font></strong></td>
						</tr>
					  </table>
				<? } ?>	  
				 
				  </td>
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
		<? }else{?>
				<td width="100%">
				
				  <table width="100%" border="0" align="center">
					<tr> 
					  <td align="center" ><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">
					  <strong>
					   <?
					  if ($_INSTIT==770){
					     echo "INFORME DE CRECIMIENTO PERSONAL <BR>";
						 if ($filaMatri['ensenanza']==110){
						     echo "EDUCACION BASICA <br>";
						 }
						 if ($filaMatri['ensenanza']==310){
						     echo "EDUCACION MEDIA <br>";
						 } 	
						 
						 echo "AÑO ESCOLAR $nro_ano";
						  
						 
					  }else{ 	
					  
					  
					        echo $titulo1;
							
					   }	?></strong></font><font size="2"></font></div></td>
					</tr>
				  </table>
				  
				  <? if ($_INSTIT!=770){ ?>
				  
					  <table width="100%" border="0" align="center">
						<tr> 
						  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']?><br>
Año <?=$nro_ano;?></font></strong></td>
						</tr>
					  </table>
					  <table width="100%" border="0" align="center">
						<tr valign="middle"> 
						  <td width="30%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
							Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
							de fecha 
							<?php impF($filaInstit['fecha_resolucion'])?>
							Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
							</font></strong></td>
						</tr>
					  </table>
				 <? } ?>	  
			    </td>
	<? } ?>
	</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	   <tr>
		<td width="80%">
		
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
             <tr><td>&nbsp;</td></tr>
		     <tr> 
			  <td width="20%"><font size="1" face="Arial, Helvetica, sans-serif">Alumno(a)</font></td>
			  <td width="60%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
			  
			  <?
			  if ($_INSTIT!=770){ ?>
			      <td width="5%"><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></td>			  
			      <td width="20%" ><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
			      <td colspan="5">&nbsp;</td>
			<? } ?>	  
				  
			 </tr>
           </table>
	  
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr> 
			  <td width="20%"><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></td>
			  <td width="80%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo CursoPalabra($curso,1,$conn); ?></font></td>
			</tr>
		  </table>
	  <?php if($filaMatri['ensenanza']>310 and $_INSTIT!=770){?>
			  <table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr> 
				  <td width="20%"><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
				  <td width="80%">: <font size="1" face="Arial, Helvetica, sans-serif">
					<?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
										$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
										$filaEsp=@pg_fetch_array($resultEsp,0);
										echo $filaEsp['nombre_esp'];?></font></td>
				</tr>
			  </table>
	  <?php } ?>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="20%"><font size="1" face="Arial, Helvetica, sans-serif">Profesor Jefe</font></td>
          <td width="80%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
        </tr>
      </table>
	 </td>
	 <td width="20%" valign="top">
	  <!--<table>
	  	<tr>
			<td>
			<? if($institucion!=""){
			 	  echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='80' height='100' >";
				}else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
				}	?></td>
		 </tr>
	  </table>-->
	 </td>
	</tr>
</table>
      
	  
 
          <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		  
        <?php 
						echo "<tr><td><img src='../../../../../cortes/p.gif' width='10' height='1' border='0'></td>";
						$tot_periodos = pg_numrows($resultPeriodo);
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE")  $per="1 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE")  $per="3 <br> Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE")   $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE")  $per="2 Sem.";
							echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
						}
						
						echo "</tr>";

						$plantilla = $filaPlantilla['id_plantilla'];
						// Areas	
						if($nuevo==1){
							$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id";
						}else{
							$query_cat="SELECT * FROM informe_area WHERE id_plantilla='$plantilla'";
						}
						
							$result_cat=@pg_exec($conn,$query_cat);
							$num_cat=@pg_numrows($result_cat);
							$jjj = 1;
							
							for ($i=0;$i<$num_cat;$i++)	{	
								$row_cat=pg_fetch_array($result_cat);	?>  
								                               
									   <tr>
										<td colspan="4" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:11px">
										<?
										if ($_INSTIT==770){
										    
										    echo "$jjj".".- ";
											$jjj++;
											
									    } ?>		
										
										
										<? if($nuevo==1){
												echo $row_cat['glosa'];
										   }else{
												echo $row_cat['nombre'];
										   }?></font>
										 </td>                                   
									   </tr>
								 	   
<?            				    // Subareas
								if($nuevo==1){
									$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id] order by id";
								}else{
									$query_sub="SELECT * FROM informe_subarea WHERE id_area=".$row_cat['id_area'];
								}
							    $result_sub=pg_exec($conn,$query_sub);
							    $num_sub=pg_numrows($result_sub);?>
                              <? for ($j=0;$j<$num_sub;$j++){
								      $row_sub=pg_fetch_array($result_sub);	
									  
									   
								      if ($row_sub['glosa']!=1 and $row_sub['glosa']!=2 and $row_sub['glosa']!=3 and $row_sub['glosa']!=4 and $row_sub['glosa']!=5 and $row_sub['glosa']!=6){
									      
									  
									   ?> 
									  						  
									  
                                      <tr >
                                   	  <td colspan="1"><img src="../../../../../cortes/p.gif" width="10" height="10" border="0">
										<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">
										
										<?
										if($nuevo==1){
											echo $row_sub['glosa'];
										}else{
											echo $row_sub['nombre'];
										}?>
										</font>											
								       </td>		
									   									
									   <td width="1%" nowrap>
									   <img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
									   <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">
									   <? // Conceptos subareas
									   if($nuevo==1){
											$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[0]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
									   }
									   if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													
													echo $row_con[sigla];
												}
											}else{
													echo $row_respuesta[respuesta];
											}

									   }else{
									        
											echo "&nbsp;";
									   }
									   
									   ?>
											
										</font></td>
									    <td width="1%" nowrap>
									
									    <img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
									    <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">
										<? // $id_peri[0]; para 1er Semestre
										    if($nuevo==1){
		   									    $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[1]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";										   
												$result_respuesta=pg_exec($conn,$query_respuesta);
												$num_respuesta=pg_numrows($result_respuesta);
											}
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[sigla];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}else{
												echo "&nbsp;";
											}
											
																					
											
											
												?>
										</font></td>
									
									
								<? 	 
								
								
								
								     if($per=="3 Tr."){
								        
								     	?>
									    <td width="1%" nowrap><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
										<? // $id_peri[0]; para 1er Semestre
										   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[2]' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[nombre];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}?>	</td>
								<? }?>																		
								   </tr>
								   
								   <? } ?>
								   
								   
								   
								   
								   
<?	// Items
							if($nuevo==1){
								$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] order by id";
							}else{
								$query_item="SELECT * FROM informe_item WHERE id_subarea=".$row_sub['id_subarea'];													
							}
							$result_item=pg_exec($conn,$query_item);
							$num_item=pg_numrows($result_item);?>
                         <? for ($z=0;$z<$num_item;$z++){
								$row_item=pg_fetch_array($result_item);	
								$id_item = $row_item['id_item'];?>
                                <tr >
 	                            <td><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;
								<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">									
								<? echo $row_item['glosa'];?>
								</font>									
								</td>
				         	<?	if($nuevo==1){	?>
									<td width="1%" nowrap><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;
									<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">
									<? 	//Conceptos Items
									$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[0]' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
									$result_respuesta=pg_exec($conn,$query_respuesta);
									$num_respuesta=pg_numrows($result_respuesta);
									if($num_respuesta>0){
										$row_respuesta=pg_fetch_array($result_respuesta);
										if ($row_respuesta[concepto]==1){
											$query_con="select * from informe_concepto_eval where id_concepto='$row_respuesta[respuesta]'";
											$result_con=pg_exec($conn,$query_con);
											$num_con=pg_numrows($result_con);
											if ($num_con>0){
												$row_con=pg_fetch_array($result_con);
												if ($_INSTIT==770){												
													 echo "<font face='verdana' style='font-size:8px'>$row_con[sigla] </font>";
 												}else{												
													 echo "<font face='verdana' style='font-size:8px'>$row_con[nombre] </font>";
												}
											}
										}else{
											echo $row_respuesta[respuesta];
										}
									}									
									
									?>
									</font></td>
									<td width="1%" nowrap><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;
									<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">									
									<? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[1]' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
										$result_respuesta=pg_exec($conn,$query_respuesta);
										$num_respuesta=pg_numrows($result_respuesta);
										if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													if ($_INSTIT==770){												
													    echo "<font face='verdana' style='font-size:8px'>$row_con[sigla] </font>";
													}else{												
														echo $row_con[nombre];
													}
												}
											}else{
											echo $row_respuesta[respuesta];
											}
										}
									
									
									?>
									</font></td>
								<? 	 
								    
								
								     if(trim($per)=="3 Tr." or $_INSTIT==770){							  
									 
									 	?>
										<td width="1%" nowrap><img src="../../../../../cortes/p.gif" width="10" height="1" border="0">&nbsp;
										<font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10">
										<? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_peri[2]' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														if ($_INSTIT==770){												
													         echo "<font face='verdana' style='font-size:8px'>$row_con[sigla] </font>";
														}else{												
															 echo $row_con[nombre];
														}
													}
												}else{
												    echo $row_respuesta[respuesta];
												}
											}
										?></font></td>
					             <?	}									
							  }else{								
	//Primer Periodo								
									$sqlTraeEval="select * from informe_evaluacion where id_item='$id_item' and id_ano=".$ano." and id_periodo='$id_peri[0]' and rut_alumno='".$alumno."'";
									$resultEval=@pg_Exec($conn, $sqlTraeEval);
									$filaEval=@pg_fetch_array($resultEval,0);
									
									$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
									$resultConc=@pg_Exec($conn, $sqlTraeConc);
									$filaConc=@pg_fetch_array($resultConc,0);?>
								<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? if ($_INSTIT==770){ ?> <?=$filaConc['sigla'];?> <? }else{ ?> <?=$filaConc['sigla'];?> <? } ?></font></td>
<? 	//Segundo Periodo			
									$sqlTraeEval="select * from informe_evaluacion where id_item='$id_item' and id_ano=".$ano." and id_periodo='$id_peri[1]' and rut_alumno='".$alumno."'";
									$resultEval=@pg_Exec($conn, $sqlTraeEval);
									$filaEval=@pg_fetch_array($resultEval,0);
									
									$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
									$resultConc=@pg_Exec($conn, $sqlTraeConc);
									$filaConc=@pg_fetch_array($resultConc,0);?>
								<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? if ($_INSTIT==770){ ?> <?=$filaConc['sigla'];?> <? }else{ ?> <?=$filaConc['sigla'];?> <? } ?></font></td>																						
<?  //tercer Periodo			
								if($tot_periodos==3){
									$sqlTraeEval="select * from informe_evaluacion where id_item='$id_item' and id_ano=".$ano." and id_periodo='$id_peri[2]' and rut_alumno='".$alumno."'";
									$resultEval=@pg_Exec($conn, $sqlTraeEval);
									$filaEval=@pg_fetch_array($resultEval,0);
									
									$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
									$resultConc=@pg_Exec($conn, $sqlTraeConc);
									$filaConc=@pg_fetch_array($resultConc,0);?>
								    <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:7px"><img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? if ($_INSTIT==770){ ?> <?=$filaConc['sigla'];?> <? }else{ ?> <?=$filaConc['nombre'];?> <? } ?></font></td>																
							<?	 }
							  }	?>																		
								</tr>
<?							
							} //FIN AMBITO
							} //FIN NUCLEO							
							} // FIN DETALLES	
//} // FIN PERFIL == 0

//------------------------------------------- vel

?>
		
      </table>
	
		
		
		<?php
		 $sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
	     $resultObs=@pg_Exec($conn, $sqlTraeObs);
		 
		 for($countObs=0; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
			  $filaObs=@pg_fetch_array($resultObs, $countObs);
			  $sedestaca = $filaObs['sedestaca'];
		 }	  
		 ?>
		 <?php ?>								
			<?
			if ($_INSTIT!=770){ ?>							
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td width="20%" class="tabla04"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Se destaca en:</font></td>
					<td width="80%" class="tablatit2_1"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;<?=$sedestaca ?></font></td>
				 </tr>
			   </table>									
		  <? } ?>
		
		
		
		<!--/div-->
       <?
		if(($institucion!=24464)&&($institucion!=12086)&&($institucion!=12829)&&($institucion!=22380)&& ($institucion != 9035) && ($institucion!=9071) && ($institucion!=14703) &&($institucion!=516) && ($institucion!=25478) && ($institucion!=11203) && ($institucion!=770) && ($institucion!=14629) && ($institucion!=9566)){
			echo "<H1 class=SaltoDePagina></H1>";
		}
 ?>
		<!--div id="capa2"-->
       <? if ($_INSTIT!=516 and $_INSTIT!=770) { ?> 
		      <table width="100%" border="0" cellpadding="0" cellspacing="0" >
			  <tr> 
				<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;Observaciones:</font></td>
			  </tr>
		      </table>
			  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
				<?php //$sqlTraeObs="select * from informe_observaciones where id_periodo=".$id_periodo." and id_ano=".$filaMatri['id_ano']." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
							$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."' order by periodo.id_periodo";
							//exit;
							$resultObs=@pg_Exec($conn, $sqlTraeObs);
							?>
				  <?php 
				  for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
					  $filaObs=@pg_fetch_array($resultObs, $countObs);
						echo "<tr>";
						echo "<td width='20%'><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
						echo $filaObs['nombre_periodo'];
						echo "</td>";
						echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">";
						echo $filaObs['observaciones'];
						echo "&nbsp;</font></td>";
						echo "</tr>";
				  }
				 ?>
		  </table>
	  <? } ?> <!---aqui termina if de las observaciones para la institucion 516 --->
        <table width="100%" border="0" cellpadding="0" cellspacing="0">        
          <tr> 
            <td></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
           </tr>
           <tr>
             <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
              </font></td>
           </tr>
         </table>
	  <?
	  if ($_INSTIT==12829){  ?>
	      <br><br>
    <? } ?> 
	  <br><br>
      <table width="100%" border="0">
        <tr> 
          <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</strong></font></td>
         <? if ($institucion==24511) { ?>
		           <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo "Marcela Paz Cardemil Bañados"?>&nbsp;</strong></font></td>
        <? } else { ?>
		      <? if ($institucion==12829){ ?>
			         <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?>&nbsp;</strong></font></td>
			  
			  <? }else{ ?>
		             <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?>&nbsp;</strong></font></td>
		
		      <? } ?>
		<? } ?>
		</tr>
      </table>
	  
      <table width="100%" border="0">
        <tr align="center"> 
            <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR  JEFE</font></td>
          <? if ($institucion==24511) { ?>
			       <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTORA DE CICLO</font></td>
	      <? } else { ?>
		        <? if ($institucion==12829){ ?>
                         <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR (A)</font></td>
			    <? }else{
				       if ($institucion==9239){?>
				         <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTORA SUBROGANTE ESTABLECIMIENTO</font></td>				
				    <? }else{ ?>
				         <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">JEFE ESTABLECIMIENTO</font></td>
					<? } ?>	 
			    <? } ?>
		 <? } ?>		
        </tr>
      </table>
	  <!--
	  /// FECHA DEL INFORME //// -->
	  <? $fecha = date("d-m-Y");?>
	  <table width="650"  border="0" cellpadding="0" cellspacing="0">
          <tr> 
             <td >
			   <font size="1" face="Arial, Helvetica, sans-serif">
			   <?
			   if ($_INSTIT==770){
			      echo "OVALLE, ";
			   }
			   ?>		   
			   
			   <?php echo  fecha_espanol($fecha); ?> </font></td>
          </tr> 
       </table>
	   
	   
	  
	  	  
	  <?
	  if ($_INSTIT==12829){ ?>
	        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			    <tr>
					<td colspan="12"><strong><font size="1" face="Arial, Helvetica, sans-serif">ESCALA DE EVALUACI&Oacute;N:</font></strong></td>
				</tr>				
				<tr>
<?				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'] ;
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);	?>
					<td width="10" valign="top"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo $filaConc['sigla'];?></strong></font>: </td>
					<td align="left" valign="bottom"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $filaConc['nombre'];?></font></td>
					
<?				}	?>
				</tr>
	        </table>
	  
	  
   <? }else{ ?>	  
	  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr> 
			  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">ESCALA DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></td>
			</tr>
		  </table>
		  
		  <table width="100%" cellpadding="0" cellspacing="0" border="0">	
			<?php 
			
				$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultConc=@pg_Exec($conn, $sqlConc);
				for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					?>
					
					<tr>
					   <td align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:6"><? echo  $filaConc['nombre']; ?><? echo $filaConc['sigla']; ?> </font></td>
					   <td align=center><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:6">:</font></td>
					   <td align=left><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:6"><? echo $filaConc['glosa']; ?></font></td>
					</tr>
			 
			  <? }	?>
			
	        </table>
   <? } ?>  
	  
	  
    <? if ($cont_alumnos > 1){  ?>  
	        <H1 class="SaltoDePagina"></H1>
	<? } ?>  
	  </td>
  </tr>
  </table>
 

 
  </td>
  </tr>
 

<? 

}   /// for inicial de alumnos
?>
</table> 
</body>
</html>

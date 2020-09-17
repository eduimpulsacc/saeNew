<?
require('../../../../../util/header.inc');
$ano		= $_ANO;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;
$_POSP = 5;
$_bot = 8;

$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
$resultDIR =@pg_Exec($conn,$qryDIR);
$filaDIR=@pg_fetch_array($resultDIR);

$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
$resultPeriodo=@pg_exec($conn, $sqlPeriodo);


$sqlInstit="select nombre_instit, nu_resolucion, fecha_resolucion, rdb, dig_rdb, insignia from institucion where rdb=".$institucion;
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

</head>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt18_optimo.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
 
								  
 <!-- INSERTO CODIGO SUPERIOR -->
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always ; height:0;line-height:0
 }
</style>



<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
	<td>
	<? if ($_PERFIL!=16 AND $_PERFIL!=15 ) {?>
			<div id="capa0"> 
			  <TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD></TR></TABLE>
			</div> 
	<? }?>
	</td>
  </tr>
</table>



<?
 	if (empty($c_alumno)){
	   			
	    $sql_alu = "select alumno.rut_alumno from alumno where alumno.rut_alumno in (select rut_alumno from matricula where id_curso = '$curso') order by alumno.ape_pat, alumno.ape_mat";

		//$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	}else{
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	}	
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);
	
	
	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE  matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
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
	
	
	$sqlTraePlantilla="SELECT informe_plantilla.titulo_informe1, informe_plantilla.nuevo_sis, informe_plantilla.id_plantilla FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
			
	$sqlTraeCurso="SELECT curso.grado_curso, curso.letra_curso FROM curso WHERE id_curso=".$curso;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select tipo_ensenanza.nombre_tipo from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$curso;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);

	$titulo1 = $filaPlantilla['titulo_informe1'];
	$nuevo = $filaPlantilla['nuevo_sis'];
	
	// para determinar primer periódo
	$sql_peri = "select * from periodo where id_ano = '$_ANO' order by id_periodo";
	$res_peri = @pg_Exec($conn,$sql_peri);
	$fil_peri = @pg_fetch_array($res_peri);
	
	$id_periodo = $fil_peri['id_periodo'];
	
	
	
	
	// para ver que id_informe tiene este curso, institucion ///	
	
    for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$alumno = $fila_alu['rut_alumno'] ;	
		
		$sqlTraeAlumno="SELECT alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.dig_rut FROM alumno WHERE rut_alumno='".$alumno."'";
		$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
		$filaAlumno=@pg_fetch_array($resultAlumno,0);
		

      ?>

	  <table width="76%" border="0" align="center">
	   <tr> 
		<td valign="top">
		  <div id="capa1">
		  <table width="100%">
		   <tr>
		<?
			
			if 	(!empty($filaInstit['insignia']))
			{ ?>
				<td width="600">
				  <table width="471" border="0" align="center">
					<tr> 
					  <td align="center" class="tablatit2-1"><? echo $titulo1;?></td>
					</tr>
				  </table>
				  <table width="471" border="0" align="center">
					<tr> 
					  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']?></font></strong></td>
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
			</td>
			  <?
			  
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$filaInstit['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>
		
		<? }else{?>
				<td width="100%">
				  <table width="100%" border="0" align="center">
					<tr> 
					  <td align="center" bgcolor="#003b85"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
					  <strong><? echo $titulo1;?></strong></font><font size="2">&nbsp;</font></td>
					</tr>
				  </table>
				  <table width="100%" border="0" align="center">
					<tr> 
					  <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $filaInstit['nombre_instit']?></font></strong></td>
					</tr>
				  </table>
				  <table width="100%" border="0" align="center">
					<tr valign="middle"> 
					  <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
						Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
						de fecha 
						<?php impF($filaInstit['fecha_resolucion'])?>
						Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
						</font></strong></td>
					</tr>
				  </table>
				</td>
	     <? } ?>
	</tr>
</table>



          <table width="100%" border="0">
        <tr><td>&nbsp;</td></tr>
		<tr> 
          <td width="12%"><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></td>
          <td width="47%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
          <td width="5%"><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></td>
          <td width="36%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="12%"><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></td>
          <td width="88%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
        </tr>
      </table>
	  
	  <?php if($filaMatri['ensenanza']>310){?>
			  <table width="100%" border="0">
				<tr> 
				  <td width="12%"><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
					<td width="88%">: <font size="1" face="Arial, Helvetica, sans-serif">
					<?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
										$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
										$filaEsp=@pg_fetch_array($resultEsp,0);
										echo $filaEsp['nombre_esp'];?></font></td>
				</tr>
			  </table>
	  <?php } ?>         
          
      <table width="100%" border="0">
        <tr> 
          <td width="12%"><font size="1" face="Arial, Helvetica, sans-serif">Profesor 
            Jefe</font></td>
          <td width="88%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
        </tr>
      </table> 
	  
 
	  <table width="100%" border="1" cellpadding="0" cellspacing="0">
		 <tr>
		 <td>&nbsp;</td>
		 <td width="5%"> <font face='verdana' style='font-size:7px'>1 Tr. </font></td>
		 <td width="5%"> <font face='verdana' style='font-size:7px'>2 Tr. </font></td>
		 <td width="5%"> <font face='verdana' style='font-size:7px'>3 Tr. </font></td>
		 </tr>
		 
		 <!-- codigo que mustra  el informe -->
		 <?
		 // ciclo para mostrar las Areas //
		 $plantilla = $filaPlantilla['id_plantilla'];	
		 if($nuevo==1){
	          $query_cat = "select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id";
		 }else{
		      $query_cat="SELECT * FROM informe_area WHERE id_plantilla='$plantilla'";
		 }
		 
		 $result_cat =@pg_exec($conn,$query_cat);
		 $num_cat    =@pg_numrows($result_cat);
		 for ($i=0;$i<$num_cat;$i++){
		      $fil_cat    = @pg_fetch_array($result_cat,$i);
			  $glosa_cat = $fil_cat['glosa']; 
			  
			  ?>		 
			  <tr>
			   <td colspan="4"><img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><font face='verdana' style='font-size:11px'><?=$glosa_cat ?></font></td>
			   </tr>
			  <?
			  /// para subareas  ///
			  if($nuevo==1){
				   $query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$fil_cat[id] order by id";
			  }else{
				   $query_sub="SELECT * FROM informe_subarea WHERE id_area=".$row_cat['id_area'];
			  }
			  $result_sub=pg_exec($conn,$query_sub);
			  $num_sub=pg_numrows($result_sub);?>
           <? for ($j=0;$j<$num_sub;$j++){
			 	  $row_sub=pg_fetch_array($result_sub); 
				  ?>			   
			      <tr>
			        <td colspan="4">&nbsp;&nbsp;
					    <? 	if($nuevo==1){
								echo "<img src='../../../../../cortes/p.gif' width='1' height='1' border='0'><font face='verdana' style='font-size:9px'>$row_sub[glosa]</font>";
							}else{
								echo "<font face='verdana' style='font-size:9px'>$row_sub[nombre]</font>";
							} ?>					
					</td>
			      </tr>
				  <? // Conceptos subareas
					if($nuevo==1){
						$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] order by id";
					
					
					}
					$result_item=pg_exec($conn,$query_item);
					$num_item=pg_numrows($result_item);
                    for ($z=0;$z<$num_item;$z++){	
					    $row_item=pg_fetch_array($result_item);	
						$id_item = $row_item['id_item'];					
				        ?>				
					    <tr>
						  <td>&nbsp;&nbsp;&nbsp;&nbsp;<img src="../../../../../cortes/p.gif" width="1" height="1" border="0"><? echo "<font face='verdana' style='font-size:8px'>$row_item[glosa] </font>"; ?></td>
						  <td>
						  
						  <? 	//Evaluacion Items 1º trimestre
							$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$id_periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
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
											echo "<img src='../../../../../cortes/p.gif' width='20' height='1' border='0'><font face='verdana' style='font-size:8px'>$row_con[sigla] </font>";
										}else{
											echo "<font face='verdana' style='font-size:8px'>$row_con[nombre]</font>";													
										}
									}
								}else{
								echo $row_respuesta[respuesta];
								}
							}					
						 ?>
						 						  
						  </td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					    </tr>
						<?
				   }		
		      } ?>	
			  
			
	  <? } ?>	 
		 
		 <!-- fin codigo que muestra el informe -->
		 
		 <!-- escala de evaluacion -->
		<br><br><br>
      <table width="85%" border="0"  align="center">
        <tr> 
          <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?>&nbsp;</strong></font></td>
         <? if ($institucion==24511) { ?>
		  <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo "Marcela Paz Cardemil Bañados"?>&nbsp;</strong></font></td>
        <? } else { ?>
		 <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $filaDIR['nombre_emp']." ".$filaDIR['ape_pat']." ".$filaDIR['ape_mat']?>&nbsp;</strong></font></td>
		<? } ?>
		</tr>
        <tr align="center"> 
            <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFESOR(A)
              JEFE</font></td>
          <? if ($institucion==24511) { ?>
          <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">DIRECTORA DE CICLO</font></td>
	      <? } else { ?>
          <td width="55%">
		  <font size="1" face="Arial, Helvetica, sans-serif">
			  <? if ($institucion==770){ ?>
			         DIRECTOR  
			  
			  <? }else{ ?>
					 JEFE ESTABLECIMIENTO
			  
			  <? } ?>		  
		  </font></td>
		  <? } ?>
        </tr>
		<tr> 
		    <? if ($_INSTIT!=516){?><tr> <? $fecha = date("d-m-Y");?>
            <td align="left">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">Ovalle, <?php //setlocale ("LC_TIME", "es_ES"); 
			echo  fecha_espanol($fecha); ?></font> </td>
        <? } ?>
		</tr>
	  </table>
	  
	  
	  <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style='font-size:6px'>ESCALA 
            DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></div></td>
	  </tr>
	<?php 
		$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
		$resultConc=@pg_Exec($conn, $sqlConc);
		for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
			$filaConc=@pg_fetch_array($resultConc,$countConc);
			$nombre_concepto = $filaConc['nombre'];
			$glosa_concepto  = $filaConc['glosa'];
			?>  
			<tr>
			   <td><img src="../../../../../cortes/p.gif" width="20" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style='font-size:6px'><?=$nombre_concepto ?></font></td>
			   <td><img src="../../../../../cortes/p.gif" width="20" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style='font-size:6px'>: <?=$glosa_concepto ?></font></td>
			</tr>
			<?
		}
		
		
		if ($_INSTIT!=516){
			/// consulta para las observaciones				
			$sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_ano=".$filaMatri['id_ano']." and informe_observaciones.id_plantilla=".$filaPlantilla['id_plantilla']." and informe_observaciones.rut_alumno='".$alumno."'";
			$resultObs=@pg_Exec($conn, $sqlTraeObs);
		  
			for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
				$filaObs=@pg_fetch_array($resultObs, $countObs);
				$obs = $filaObs['observaciones'];
				
				?>
				<tr>
				   <td><img src="../../../../../cortes/p.gif" width="20" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style='font-size:6px'>Observaciones</font></td>
				   <td><img src="../../../../../cortes/p.gif" width="20" height="1" border="0"><font face="Verdana, Arial, Helvetica, sans-serif" style='font-size:6px'>: <?=$obs ?></font></td>
				</tr>
				<?
			}
			/// fin observaciones		
		}
		?>
					
       </table> 
		 
		 
		 
		 <!-- fin escala de evaluacion --> 
		 
		 
	  </table>		  
  </div>
  </td>
  </tr>
  </table>
  	 <?  echo "<H1 class=SaltoDePagina></H1>";	  ?>
           
<? } ?>	 

</body>
</html>

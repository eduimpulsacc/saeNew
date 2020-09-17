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

	//$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$filaAno['id_ano']." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$qryAnoEscolar = "select nro_ano from ano_escolar where id_ano = '$ano'";
	$resAnoEscolar = @pg_Exec($conn,$qryAnoEscolar);
	$filaAnoEscolar = @pg_fetch_array($resAnoEscolar);	

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
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 
</style>						  
<!-- INSERTO CODIGO SUPERIOR -->
<? if ($_PERFIL!=16 AND $_PERFIL!=15 ) {?>
		<div id="capa0" align="center"> 
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonXX" 
		id="cmdimprimiroriginal" 
	 	onClick="imprimir()"
	 	value="Imprimir"
		>
      	</div> 
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','../../botones/periodo_roll.gif','../../botones/feriados_roll.gif','../../botones/planes_roll.gif','../../botones/tipos_roll.gif','../../botones/cursos_roll.gif','../../botones/matricula_roll.gif','../../botones/informe_roll.gif','../../botones/actas_roll.gif','../../botones/generar_roll.gif')">
<?
 	if (empty($c_alumno)){
	   
	    $sql_alu = "select alumno.rut_alumno from alumno where alumno.rut_alumno in (select rut_alumno from matricula where id_curso = '$curso') order by alumno.ape_pat, alumno.ape_mat";
		//$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	}else{
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	}	
		
	$result_alu =@pg_Exec($conn,$sql_alu);
	$cont_alumnos = @pg_numrows($result_alu);
	
	 

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
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

	$sqlTraePlantilla="SELECT informe_plantilla.titulo_informe1, informe_plantilla.nuevo_sis, informe_plantilla.id_plantilla FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	$sqlTraeAlumno="SELECT alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.dig_rut FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
	
	$sqlTraeCurso="SELECT curso.grado_curso, curso.letra_curso FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select tipo_ensenanza.nombre_tipo from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);

	$titulo1 = $filaPlantilla['titulo_informe1'];
	$nuevo = $filaPlantilla['nuevo_sis'];	

?>
<form action="proceso_informe.php" method="post">
<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr> 
	  <td align="center" valign="top"><strong><font size="1" face="Arial, Helvetica, sans-serif">INFORME DE CRECIMIENTO PERSONAL<br>EDUCACION BASICA<BR>AÑO ESCOLAR <?php echo $filaAnoEscolar['nro_ano']; //echo $filaInstit['nombre_instit']?><br>
	    <br>
	  </font></strong></td>
   </tr>
  
   <tr>
	  <td width="80%">
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr> 
              <td width="15%"><font size="1" face="Arial, Helvetica, sans-serif">Alumno(a)</font></td>
              <td width="85%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
		    </tr>
        </table>
	  
         <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="15%"><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></td>
              <td width="85%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
            </tr>
        </table>
	  <?php if($filaMatri['ensenanza']>310){?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="15%"><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
            <td width="85%">: <font size="1" face="Arial, Helvetica, sans-serif">
			<?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];?></font></td>
        </tr>
      </table>
	  <?php } ?>
         
          
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="15%"><font size="1" face="Arial, Helvetica, sans-serif">Profesor Jefe</font></td>
          <td width="85%"><font size="1" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
        </tr>
      </table>
	  
  	  </td>
	</tr>

		  

        <?php 
						echo "<tr  ><td></td>";
						$tot_periodos = pg_numrows($resultPeriodo);
						for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
							$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
							$id_peri[$countP] = $filaPeriodo['id_periodo']; 						
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
							if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
							if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";
							echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$per."</font></td>";
	//						echo "<td align=\"center\"><font size=1 face=Arial, Helvetica, sans-serif>".$filaPeriodo['id_periodo']."</font></td>";
						}
						echo "</tr>";
						
						$plantilla = $filaPlantilla['id_plantilla'];
						
						
						$nuevos = array();
						
						for($n=0;$n<count($id_peri);$n++){
							
							if($n==0){
								
								
								$periodo = $id_peri[$n];
								$nombre = $ano."-".$periodo."-".$alumno."-".$plantilla;
								
									
							
								if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
									$archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");	    
									
								
									if ($archivo) {
										$linea=1;
										while (!feof($archivo)) {
											$cadena = fgets($archivo, 500);
											$temp = split("[\t]",$cadena);
											//print_r($temp);
											
											$cont_car= count($temp);
											
											
											if($cont_car == 1 && $temp[0] != ""){
												$nuevos[$linea]['dato'] = $temp[0];
												$nuevos[$linea]['tipo'] = 1;
												$linea++;
							
											}
											
											if($cont_car == 2){
												$nuevos[$linea]['dato'] = $temp[1];
												$nuevos[$linea]['tipo'] = 2;
												$linea++;
												
												
											}
											
											if($cont_car == 4){
												$nuevos[$linea]['dato']['item'] = $temp[2];
												$nuevos[$linea]['dato']['respuesta'][] = $temp[3];
												$nuevos[$linea]['tipo'] = 3;
												$linea++;												

											}
											
											
										}
									}
									fclose ($archivo);
								}

														
								
							}
							else{
								
								$periodo = $id_peri[$n];
								$nombre = $ano."-".$periodo."-".$alumno."-".$plantilla;
								
									
							
								if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
									$archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");	    
									
								
									if ($archivo) {
										$linea=1;
										while (!feof($archivo)) {
											$cadena = fgets($archivo, 500);
											$temp = split("[\t]",$cadena);
											//print_r($temp);
											
											$cont_car= count($temp);
											
											
											if($cont_car == 1 && $temp[0] != ""){
												$linea++;
							
											}
											
											if($cont_car == 2){

												$linea++;
												
											}
											
											if($cont_car == 4){
												$nuevos[$linea]['dato']['respuesta'][] = $temp[3];
												$linea++;
											}
											
											
										}
									}
									fclose ($archivo);
								}								
								
							}
							
								
						}
						//fin de para cada periodo
						//print_r($nuevos);
						
						
						
						for($y=0;$y<count($nuevos);$y++){
							
							if($nuevos[$y]['tipo'] == 1){
								echo "
					              <tr>
					                <td colspan=2  class=tabla04>".$nuevos[$y]['dato']."</td>
					              </tr>		";	
			
							}
							
							if($nuevos[$y]['tipo'] == 2){
								echo "
			                                  <tr class='tabla04'>
			                                    <td><img src='../../../../../cortes/p.gif' width=10 height=1 border=0>".$nuevos[$y]['dato']."</td>
												
			                                    <td width=1% nowrap>		</td>
			                                  </tr>  
			                                    ";
								
								
							}
							
							if($nuevos[$y]['tipo'] == 3){
								
								echo "				
			  						<tr class='tablatit2-1'>
			                        <td><img src='../../../../../cortes/p.gif' border=0 height=8 width=20>".$nuevos[$y]['dato']['item']."
			                        </td>			
								";	
								$respuesta_temp = $nuevos[$y]['dato']['respuesta'];
								for($t=0;$t<count($respuesta_temp);$t++){
									if($respuesta_temp[$t] == ""){
										echo "<td nowrap='nowrap' width='3%'>".$respuesta_temp[$t] ."</td>";
									}
									else{
										list($nombre_uno,$sigla) = split("#",$respuesta_temp[$t]);
										echo "<td nowrap='nowrap' width='3%'>".$nombre_uno."</td>";
									}
								}
								
											
								echo "</tr>";							
											

							}							
							
						}
						
						
						

		?>	
	
	
		  <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
		  <input name="alumno" type="hidden" value="<?php echo $alumno?>">
  </table>

       <?
		if(($institucion!=24464)&&($institucion!=12086)&&($institucion!=22380)&& ($institucion != 9035) && ($institucion!=9071) && ($institucion!=14703) &&($institucion!=516) && ($institucion!=25478)){
//			echo "<H1 class=SaltoDePagina></H1>";
		}
 ?>
		<!--div id="capa2"-->
        <table width="85%" border="0" align="center">
        <tr>
          <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
            <input type="hidden" name="fecha">
			<input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
			<input type="hidden" name="grado" value="<?php echo $grado ?>">
			<!--input type="hidden" name="periodo" value="<?php //echo $periodo ?>"-->
            </font></td>
        </tr>
      </table>
	  <br><br><br><br>
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
	    
      
 <? 
  if  (($cont_alumnos - $cont_paginas)<>1) 
	echo "<H1 class=SaltoDePagina></H1>";
	}
?>
</form>
</div>
								  
								

                          
                        
                   

</body>
</html>

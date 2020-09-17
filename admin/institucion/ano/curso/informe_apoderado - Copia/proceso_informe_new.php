<?php 
require('../../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
$institucion =$_INSTIT;
$ano		 =$_ANO;
$_POSP       = 5;
$_bot        = 5;
//$modificar= $_GET[modificar];
		/*if(session_is_registered('_PLANTILL')){
			session_unregister('_CURSO');
		};*/

	
if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";

	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$_CURSO;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	   if($tipoEns=="")
	      $tipoEns=$filaCurso['ensenanza'];


	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$tipoEns." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);	
	$numerodeplantillas = pg_numrows($resultPlantilla);	
	$id_plantilla = $filaPlantilla['id_plantilla'];	
//imprime_array($filaPlantilla);
	if ($filaPlantilla[nuevo_sis]==1){
//echo "hioola";


?>
	<script>
		window.location="muestraPlantilla_new.php?alumno=<? echo $alumno;?>&creada=1&grado=<? echo $grado;?>";
	</script>
	<? }else{
	//imprime_array($_GET);
//	imprime_array($filaPlantilla);
	}	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$tipoEns;
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$_CURSO;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$ii = 1;	
















			$fechaCreacion = date("d-m-Y H:i:s");

			
			$sql_del="delete from informe_evaluacion where id_periodo=".$periodo." and id_ano=".$ano." and id_plantilla=".$plantilla;
//			$res_del=@pg_exec($conn, $sql_del);
			
			
			//AQUI PROCESO PARA VER COMO VIENEN LOS COMBOBOX
			?>
			
			<!-- Aqui nuevo codigo -->
          <!--  <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
            <tr class="tablatit2-1">
            <td width="20%">&nbsp;&nbsp;ALUMNO&nbsp;&nbsp; </td>
            <td width="80%" valign="top">			
			    <div id="contEncCol">
                  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>			       
					<?
				    $sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				    $resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
				    $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					$variable = @pg_numrows($resultTraeArea);
					
										
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$id_area = $filaTraeArea['id_area'];
						
						$sqsubarea = "select * from informe_subarea where id_area = '$id_area'";
						$rssubarea = pg_Exec($conn,$sqsubarea);
						
						for ($consubarea=0; $consubarea<@pg_numrows($rssubarea); $consubarea++){
						     $filasubarea = @pg_fetch_array($rssubarea,$consubarea);
							 $id_subarea = $filasubarea['id_subarea'];
							 
							 $sqitem = "select * from informe_item where id_subarea = '$id_subarea'";
							 $rsitem = pg_Exec($conn,$sqitem);
							 
							 for ($conitem = 0; $conitem<@pg_numrows($rsitem); $conitem++){
							     $filaitem = @pg_fetch_array($rsitem,$conitem);
								 $id_item = $filaitem['id_item'];
								 $tipo    = $filaitem['tipo'];
																
								 ?>				  
				  
                                  <td width="50" align="center">&nbsp;<?=$conitem + 1 ?></td>
								  
								 <?
							 
							}						 
						}						
							
					}//fin for($countArea....			
				  ?> 			   
                  </tr>
                </table>
                </div>			
		   </td>
          </tr>
          <tr>
            <td width="300" valign="top" valing=top>
			<div id="contEncFil">
			    <?
				$q1 = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."' and id_curso = '".trim($_CURSO)."') order by ape_pat";
			    $r1 = pg_Exec($conn,$q1);
				$n1 = pg_numrows($r1);
				
				$i = 0;
				while ($i < $n1){ 
				    $f1 = pg_fetch_array($r1,$i);
				    $nombre = $f1['ape_pat'];
					$nombre.= $f1['ape_mat'];
					$nombre.= $f1['nombre_alu'];					
					?>
                    <table width="100%" border="1" height="60">
				      <tr>
				      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre ?> </font></td></tr>
			 	    </table>	
					<?
					$i++;
				}
				?>	
            </div>
			</td>
            <td valign="top"><div id="contenedor" onscroll="desplaza()">
              <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <!-- AQUI DESPLIEGO EL INFORME HACIA EL LADO -->
				 
				<?
				$q1 = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."' and id_curso = '".trim($_CURSO)."') order by ape_pat";
			    $r1 = pg_Exec($conn,$q1);
				$n1 = pg_numrows($r1);
				
				$i = 0;
				while ($i < $n1){ 
				    $f1 = pg_fetch_array($r1,$i);
				    $alumno = $f1['rut_alumno'];
					$nombre = $f1['ape_pat'];
					$nombre.= $f1['ape_mat'];
					$nombre.= $f1['nombre_alu'];					
					?>			  
				   <!-- <table border="0" bordercolor="#990000" height="60">
				    <tr>			  
				    <?
				    $sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				    $resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
				    $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					$variable = @pg_numrows($resultTraeArea);
					
									
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$id_area = $filaTraeArea['id_area'];
						
						$sqsubarea = "select * from informe_subarea where id_area = '$id_area'";
						$rssubarea = pg_Exec($conn,$sqsubarea);
						
						for ($consubarea=0; $consubarea<@pg_numrows($rssubarea); $consubarea++){
						     $filasubarea = @pg_fetch_array($rssubarea,$consubarea);
							 $id_subarea = $filasubarea['id_subarea'];
							 
							 $sqitem = "select * from informe_item where id_subarea = '$id_subarea'";
							 $rsitem = pg_Exec($conn,$sqitem);
							 
							 for ($conitem = 0; $conitem<@pg_numrows($rsitem); $conitem++){
							     $filaitem = @pg_fetch_array($rsitem,$conitem);
								 $id_item = $filaitem['id_item'];
								 $tipo    = $filaitem['tipo'];
																
								 ?>
								 <td width="50">
								
								 <?
								 if ($tipo==0){
								     // busco sus opciones de sigle
									 $sigla = "sigla".$ii;
									 $sigla = $$sigla;				 
													 
									if ($sigla==0){
									    // no inserto	
																	
									}else{
								     	 $sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, id_concepto, fecha_creacion, id_plantilla) values (".$id_item.", ".$periodo.", ".$ano.", '".$alumno."','".$sigla."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
									     $rssqlins = pg_Exec($conn,$sqlIns);
										
									}
									
									 	 
								 }
								 $ii++;
								 		 
								 ?>
								
								 </td>
							     <?
							 
							 }						 
						}						
							
					}//fin for($countArea....
			
				  ?>
				  </tr>
				  </table>			 
				 <?
					$i++;
				}
				?>			  
				  <!-- FIN DEL INFORME HACIA EL LADO -->
				  
			<!--	  </td>
                  </tr>
              </table>
            </div></td>
          
          </tr>
        </table>
      <!-- fin codigo -->	<?	
			
			
			
			
			
			
			
			
			
			
			
			
			
								
				   
											
								/*
								//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
								if($filaTraeItem['tipo']==0){
										if($modificar!=1){
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, id_concepto, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."','".$cmbConcepto[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
										}else{
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, id_concepto, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."','".$cmbConcepto[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
											//$sqlIns="update  informe_evaluacion set id_concepto='".$cmbConcepto[$countT]."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_item=".$filaTraeItem['id_item']." and id_periodo=".$periodo." and id_ano=".$ano." and rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
										}
											$resultIns=@pg_Exec($conn, $sqlIns);
								}
								 if($filaTraeItem['tipo']==2){
								 		if($modificar!=1){
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, text, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."', '".$text[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
										}else{
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, text, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."', '".$text[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
											//$sqlIns="update informe_evaluacion set text='".$text[$countT]."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_item=".$filaTraeItem['id_item']." and id_periodo=".$periodo." and id_ano=".$ano." and rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
										}
											$resultIns=@pg_Exec($conn, $sqlIns);
								}
								if($filaTraeItem['tipo']==1){
										if($modificar!=1){
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, radio, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."', '".$radio[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
										}else{
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, radio, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."', '".$radio[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
											//$sqlIns="update informe_evaluacion set radio='".$radio[$countT]."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_item=".$filaTraeItem['id_item']." and id_periodo=".$periodo." and id_ano=".$ano." and  rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
										}
											$resultIns=@pg_Exec($conn, $sqlIns);
								}
								//exit;
								*/		
		 
			
			echo "<script>window.location='muestraPlantilla_new.php?creada=1&tipoEns=".$tipoEns."&grado=".$grado."&alumno=".$alumno."&periodo=".$periodo."'</script>";
			
			exit();
			
			if($modificar!=1){
				$sqlInsObs="insert into informe_observaciones (id_periodo, id_ano, id_plantilla, rut_alumno, glosa, fecha_creacion) values(".$periodo.", ".$ano.", ".$plantilla.", '".$alumno."', '".$txtObs."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
			}else{
				$sqlInsObs="update informe_observaciones set glosa='".$txtObs."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_periodo=".$periodo." and id_ano=".$ano." and id_plantilla=".$plantilla." and rut_alumno='".$alumno."'";
			}
			$resultObs=@pg_Exec($conn, $sqlInsObs);
//			 exit;
			echo "<script>window.location='muestraPlantilla.php?creada=1&tipoEns=".$tipoEns."&grado=".$grado."&alumno=".$alumno."&periodo=".$periodo."'</script>";
?>



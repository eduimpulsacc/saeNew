<?php require('../../../../../util/header.inc'); 

if($tipo_hoja!=1){
$ano	=$_ANO;
}else{
/*************VARIABLES PARA HOJA DE VIDA******************/
$ano=$_GET['ano'];
$curso=$_GET['curso'];
$alumno=$_GET['alumno'];
/*****************************/
}
			$fechaCreacion = date("d-m-Y H:i:s");

			if($modificar==1){
//				$sql_del="delete from informe_evaluacion where id_periodo=".$periodo." and id_ano=".$ano." and rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
				$res_del=@pg_exec($conn, $sql_del);
			}
			$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
			$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
			//trae areas
			$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$plantilla;
			$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
			for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
				$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
				//echo "<tr><td><font size=2 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
          //		echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
				
					//trae subareas para cada area y las imprime
					$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
					$resultTraeSubarea=pg_Exec($conn, $sqlTraeSubarea);
					for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
						$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
						//echo "<tr><td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td>";
   						//echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
          					//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
							$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']."order by id_item";
							$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
							for($countItem=0 ; $countItem<@pg_numrows($resultTraeItem) ; $countItem++){
								$countT++;
								$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
								//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
								if($filaTraeItem['tipo']==0){
										if($modificar!=1){
// estaba sin comentario
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, id_concepto, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."','".$cmbConcepto[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
											$resultIns=@pg_Exec($conn, $sqlIns);

											if(!$resultIns){											
												$sqlIns="update  informe_evaluacion set id_concepto='".$cmbConcepto[$countT]."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_item=".$filaTraeItem['id_item']." and id_periodo=".$periodo." and id_ano=".$ano." and rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
												$resultIns=@pg_Exec($conn, $sqlIns);
											}
										}else{
											$sqlIns="insert into informe_evaluacion (id_item, id_periodo, id_ano, rut_alumno, id_concepto, fecha_creacion, id_plantilla) values (".$filaTraeItem['id_item'].", ".$periodo.", ".$ano.", '".$alumno."','".$cmbConcepto[$countT]."', to_date('" .$fechaCreacion. "','DD MM YYYY'), ".$plantilla.")";
											$resultIns=@pg_Exec($conn, $sqlIns);											

											if(!$resultIns){											
												$sqlIns="update  informe_evaluacion set id_concepto='".$cmbConcepto[$countT]."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_item=".$filaTraeItem['id_item']." and id_periodo=".$periodo." and id_ano=".$ano." and rut_alumno='".$alumno."' and id_plantilla=".$plantilla;
												$resultIns=@pg_Exec($conn, $sqlIns);
											}
										}
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
									
									
							}//fin for($countItem....
					}//fin for($countSubarea....
			}//fin for($countArea....
			
			if($modificar!=1){
				$sqlInsObs="insert into informe_observaciones (id_periodo, id_ano, id_plantilla, rut_alumno, glosa, fecha_creacion) values(".$periodo.", ".$ano.", ".$plantilla.", '".$alumno."', '".$txtObs."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
			}else{
			    //// consulta si existe
				$sql_obs = "select * from informe_observaciones where id_plantilla = '$plantilla' and id_periodo = '$periodo'and rut_alumno = '$alumno'";
				$res_obs = @pg_Exec($conn, $sql_obs);
				$num_obs = @pg_numrows($res_obs);
				if ($num_obs==0){
				      /// inserto
					  $sqlInsObs="insert into informe_observaciones (id_periodo, id_ano, id_plantilla, rut_alumno, glosa, fecha_creacion) values(".$periodo.", ".$ano.", ".$plantilla.", '".$alumno."', '".$txtObs."', to_date('" .$fechaCreacion. "','DD MM YYYY'))";
				}else{
				      /// actualizo				
				      $sqlInsObs="update informe_observaciones set glosa='".$txtObs."', fecha_creacion=to_date('" .$fechaCreacion. "','DD MM YYYY') where id_periodo=".$periodo." and id_ano=".$ano." and id_plantilla=".$plantilla." and rut_alumno='".$alumno."'";
			    } 
			}
			$resultObs=@pg_Exec($conn, $sqlInsObs);
//			 exit;
			
			
			if($tipo_hoja!=1){
			echo "<script>window.location='muestraPlantilla.php?creada=1&tipoEns=".$tipoEns."&grado=".$grado."&alumno=".$alumno."&periodo=".$periodo."'</script>";
			}else{
			echo "<script>window.location='muestraPlantilla.php?creada=1&tipoEns=".$tipoEns."&grado=".$grado."&c_alumno=".$alumno."&periodo=".$periodo."&c_ano=".$ano."&c_curso=".$curso."&tipo_hoja=".$tipo_hoja."'</script>";
			}
?>



<?

require('../../../../../util/header.inc');
$institucion = $_GET['rbd'];

if(!empty($institucion)){

			
			echo "INICIO: $institucion <br> ";
			
			
			$query_val="select id_plantilla from informe_plantilla where rdb='$institucion'  and nuevo_sis = 1";
			$result_val=pg_exec($conn,$query_val);
			$num=pg_numrows($result_val);
			
			
			
			//Para cada Plantilla
			for ($i=0;$i<$num;$i++){
				$row_val=pg_fetch_array($result_val);
				$id_plantilla = $row_val['id_plantilla'];
				
				
				$query_alum="select distinct(rut_alumno) from informe_evaluacion2 where id_plantilla='$id_plantilla'";
				$result_alum=pg_exec($conn,$query_alum);
				$num_alum=pg_numrows($result_alum);
				
				echo "<br>NUM alumnos: $num_alum<br>";
				
				//Para cada alumno
				for ($j=0;$j<$num_alum;$j++){
					$row_alum=pg_fetch_array($result_alum);
					$rut_alumno = $row_alum['rut_alumno'];
					
					//echo "<h1>$rut_alumno</h1>";
						
						
						$query_datos="select distinct(id_periodo),id_ano from informe_evaluacion2 where rut_alumno=$rut_alumno";
						$result_datos=pg_exec($conn,$query_datos);
						$num_datos=pg_numrows($result_datos);
						//echo "$num_datos<br>";
						
						//Para cada periodo
						for ($oo=0;$oo<$num_datos;$oo++){
							$row_datos=pg_fetch_array($result_datos);
							
							//print_r($row_datos);
							$id_periodo = $row_datos['id_periodo'];
							$id_ano = $row_datos['id_ano'];
							
							
							//echo "$id_periodo<br>";
							
							
							$query_total="select * from informe_evaluacion2 where rut_alumno=$rut_alumno AND id_periodo = $id_periodo AND id_plantilla = $id_plantilla AND id_ano = $id_ano order by id_informe_area_item";
							$result_total=pg_exec($conn,$query_total);
							$num_total=pg_numrows($result_total);
			
							//Total
							$total = array();
							for ($k=0;$k<$num_total;$k++){	
								
								//print_r($row_total);	
								$row_total=pg_fetch_array($result_total);
								if ($row_total['concepto']==1){
									$concepto=1;
								}
								else{
									$concepto=0;
								}
								
								//GUARDAMOS A ARCHIVO
								$id_item = $row_total['id_informe_area_item'];
								$id_respuesta = $row_total['respuesta'];
								
								$respuesta_texto = "";
								$sigla_texto = "";
								
								if($concepto == 1){
									$query_uno=" select nombre,sigla from informe_concepto_eval  where id_concepto ='$id_respuesta'";
									$result_uno=pg_exec($conn,$query_uno);
									$row_uno=pg_fetch_array($result_uno);
									$respuesta_texto = $row_uno['nombre'];
									$sigla_texto = $row_uno['sigla'];
								}
								
								
								
								$query_dos=" select id_padre, glosa  from informe_area_item  where id ='$id_item'";
								$result_dos=pg_exec($conn,$query_dos);
								$row_dos=pg_fetch_array($result_dos);			
								$id_padre_sub = $row_dos['id_padre'];
								$nombre_item = $row_dos['glosa'];
								
								//echo "$id_plantilla $id_item $id_padre_sub<br>";
								
								if(!empty($id_padre_sub)){
											
										$query_tres=" select id_padre,glosa  from informe_area_item  where id ='$id_padre_sub'";
										$result_tres=pg_exec($conn,$query_tres);
										$row_tres=pg_fetch_array($result_tres);			
										$id_padre_cat = $row_tres['id_padre'];
										$nombre_sub = $row_tres['glosa'];
										
										
										$query_cua=" select glosa  from informe_area_item  where id ='$id_padre_cat'";
										$result_cua=pg_exec($conn,$query_cua);
										$row_cua=pg_fetch_array($result_cua);			
										$nombre_cat = $row_cua['glosa'];			
										
										
										$total[$k]['id_cat'] = $id_padre_cat;
										$total[$k]['glosa_cat'] = $nombre_cat;
										$total[$k]['id_sub'] = $id_padre_sub;
										$total[$k]['glosa_sub'] = $nombre_sub;
										$total[$k]['id_item'] = $id_item;
										$total[$k]['glosa_item'] = $nombre_item;
										//$total[$k]['respuesta'] = $respuesta_texto;	
										
										
										if($respuesta_texto == ""){
											$total[$k]['respuesta'] = $respuesta_texto;	
										}
										else{
											$total[$k]['respuesta'] = $respuesta_texto."#".$sigla_texto;	
										}														
								
								}
									
							}
							
							
							
							//print_r($total);
							
							$nuevos = array();
							$cont = 0;
							
							for($p=0;$p<count($total);$p++){
								if($p == 0){
									$nuevos[$cont]['id'] = $total[$p]['id_cat'];
									$nuevos[$cont]['glosa_cat'] = $total[$p]['glosa_cat'];
									$cont++;
								}
								else{
									$bandera = 0;
									for($x=0;$x<count($nuevos);$x++){
										if($nuevos[$x]['id'] == $total[$p]['id_cat']){
											$bandera = 1;
										}
									}
									if($bandera == 0){
										$nuevos[$cont]['id'] = $total[$p]['id_cat'];
										$nuevos[$cont]['glosa_cat'] = $total[$p]['glosa_cat'];
										$cont++;				
									}	
								}	
							}
							
							//print_r($nuevos);
							
							
							for($x=0;$x<count($nuevos);$x++){
								
								for($q=0;$q<count($total);$q++){
								
									if($nuevos[$x]['id'] == $total[$q]['id_cat']){
										
										if($q==0){								
											$nuevos[$x]['sub'][] = array('id' => $total[$q]['id_sub'], 'glosa' => $total[$q]['glosa_sub']);
											
										}
										else{
											$bandera = 0;
											for($y=0;$y<count($nuevos);$y++){
												
												for($h=0;$h<count($nuevos[$y]['sub']);$h++){
													if($nuevos[$y]['sub'][$h]['id'] == $total[$q]['id_sub']){
														$bandera = 1;
													}
													
												}
												
											}
											
											if($bandera == 0){
												$nuevos[$x]['sub'][] = array('id' => $total[$q]['id_sub'], 'glosa' => $total[$q]['glosa_sub']);
												
											}
											
										}
										
										
										
									}
										
								}
								
							}
							
							
							
							for($x=0;$x<count($nuevos);$x++){
								
								$temp = $nuevos[$x]['sub'];
								$conta = count($temp);
								
								for($r=0;$r<$conta;$r++){
									//print_r($temp[$r]);
									
									$temp_id_sub = $temp[$r]['id'];
									
									for($q=0;$q<count($total);$q++){
										
										if($total[$q]['id_sub'] == $temp_id_sub){
											
											$nuevos[$x]['sub'][$r]['item'][] = array('glosa_item' => $total[$q]['glosa_item'], 'respuesta' =>$total[$q]['respuesta']  );
										}
									}
									
									
								}
								
								
							}
										/*$total[$i]['glosa_item'] = $nombre_texto;
									$total[$i]['respuesta'] = $respuesta_texto;*/
							
							
							//print_r($nuevos);
							
							//print_r($total);
							
							$nombre = $id_ano."-".$id_periodo."-".$rut_alumno."-".$id_plantilla;
							//echo "$nombre<br>";
							
							$archivo=fopen("archivos/".$nombre.".txt" , "w");
							if ($archivo) {
								
								for($x=0;$x<count($nuevos);$x++){
									
									$glosa_cat = $nuevos[$x]['glosa_cat']."\n";
									fputs ($archivo, $glosa_cat);
									
									$temp = $nuevos[$x]['sub'];
									
									for($r=0;$r<count($temp);$r++){
										
										$glosa_sub = "\t".$temp[$r]['glosa']."\n";
										fputs ($archivo, $glosa_sub);
										
										$temp2 = $temp[$r]['item'];
										
										//print_r($temp2);
										
										for($n=0;$n<count($temp2);$n++){
											$glosa_item = "\t\t".$temp2[$n]['glosa_item']."\t".$temp2[$n]['respuesta']."\n";
											fputs ($archivo, $glosa_item);
										}
										
									}
									
								}
								
								
							}
							fclose ($archivo); 				
							
							
							
							
							//print_r($total);
							
							
						}
					
				}
				
				
			}
			
			
			echo "<br>FIN: $institucion <br> ";
			
}

else{
	
	echo "Ingrese el RBD<br>";
}


?>
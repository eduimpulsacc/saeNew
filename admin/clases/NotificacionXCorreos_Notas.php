<? $time_start = microtime(true);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();
		 	
$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");

 /**************************************************************************/

	$sql = "SELECT   ncc.rbd,ncc.tipo_ensenanza,ncc.id_notifica_correo_configuracion,ncc.notifica_notas,ncc.nro_notas,ncc.nota_deficiente,ncc.id_ano	
	 FROM notifica_correo_configuracion ncc  WHERE ncc.notifica_notas = 1";
		
	$resul = @pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 1");
		
	  if(pg_numrows($resul)>0){
		  
		//Cargo Clase para Armar Excel
	    require_once("Crea_Excel.php");
		    
		  for ($i1=0; $i1 < pg_num_rows($resul); $i1++) { 
			  		
 		 $fila = pg_fetch_array($resul,$i1);
	
	    $idconfiguracion = $fila['id_notifica_correo_configuracion'];
         
         $notifica_notas = $fila['notifica_notas']; 
		 
		 $nro_notas= $fila['nro_notas']; 
		 
		 $nota_deficiente = $fila['nota_deficiente']; 
		 
         $rbd = $fila['rbd']; 
		 
		 $id_ano_configuracion = $fila['id_ano'];
		 
		 $tipo_ensenanza = $fila['tipo_ensenanza'];
		
		 $sql = "SELECT * FROM ano_escolar WHERE id_ano = $id_ano_configuracion";
	    $ano_result = pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 2");
	    $fila_ano_result  = pg_fetch_array( $ano_result ,0);
	    $nro_ano = $fila_ano_result['nro_ano'];
	   		   		
		$excel	=	 new ExcelWriter("Ficheros_Exel/Reporte_Notas$rbd-$tipo_ensenanza.xls");
	    if($excel==false) {  echo $excel->error;  }
  		    
	    //Array con Campos del Excel		   "Docentes",
	    
	    $myArr=array(  "Ruts Alumnos","Nombres Alumnos","Cursos","Periodos","Subsectores","Notas1","Notas2","Notas3",
	    "Notas4","Notas5","Notas6","Notas7","Notas8" ,"Notas9","Notas10","Notas11","Notas12","Notas13","Notas14","Notas15"
	    ,"Notas16","Notas17","Notas18","Notas19" );
		
		$excel->writeLine($myArr);

	         if($notifica_notas == 1 ){
	  			
	  		     $sql_notas = "SELECT
CAST(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as nombre_profesorjefe,
cu.grado_curso,cu.letra_curso,cu.ensenanza,CAST(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso_completo,
subsec.nombre as nombre_subsector,subsec.cod_subsector,CAST(proramo.ape_pat || ' ' || proramo.ape_mat || ' ' || proramo.nombre_emp as varchar) as nombre_profesor_dicta, 
proramo.rut_emp,nota.rut_alumno,CAST(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_dv_alumno,
CAST(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno,
nota.id_ramo,nota.id_periodo,per.nombre_periodo,nota.nota1,nota.nota2,nota.nota3,nota.nota4,nota.nota5,
nota.nota6,nota.nota7,nota.nota8,nota.nota9,nota.nota10,nota.nota11,nota.nota12,nota.nota13,nota.nota14,nota.nota15,nota.nota16,nota.nota17,nota.nota18,nota.nota19,nota.nota20,nota.promedio,
nota.notaap
FROM matricula as ma
INNER JOIN alumno alu on alu.rut_alumno = ma.rut_alumno
INNER JOIN curso cu ON cu.id_curso = ma.id_curso AND cu.ensenanza = $tipo_ensenanza
LEFT OUTER JOIN supervisa supe ON supe.id_curso = cu.id_curso 
LEFT OUTER JOIN empleado projefe ON projefe.rut_emp = supe.rut_emp
INNER JOIN ramo ram ON ram.id_curso = cu.id_curso
INNER JOIN subsector subsec ON subsec.cod_subsector = ram.cod_subsector
LEFT OUTER JOIN dicta di ON di.id_ramo = ram.id_ramo
LEFT OUTER JOIN empleado proramo ON proramo.rut_emp = di.rut_emp 
INNER JOIN ano_escolar anes ON anes.id_ano = ma.id_ano
INNER JOIN periodo per ON per.id_ano = anes.id_ano
INNER JOIN notas$nro_ano as  nota ON nota.id_periodo = per.id_periodo AND nota.id_ramo = ram.id_ramo AND nota.rut_alumno = ma.rut_alumno 
AND (( cast(nota.nota1 as integer) <= $nota_deficiente AND cast(nota.nota1 as integer) <> 0 ) 
or ( cast(nota.nota2 as integer) <= $nota_deficiente AND cast(nota.nota2 as integer) <> 0 ) 
or ( cast(nota.nota3 as integer) <= $nota_deficiente AND cast(nota.nota3 as integer) <> 0) 
or ( cast(nota.nota4 as integer) <= $nota_deficiente AND cast(nota.nota4 as integer) <> 0) 
or ( cast(nota.nota5 as integer) <= $nota_deficiente AND cast(nota.nota5 as integer) <> 0) 
or ( cast(nota.nota6 as integer) <= $nota_deficiente AND cast(nota.nota6 as integer) <> 0) 
or ( cast(nota.nota7 as integer) <= $nota_deficiente AND cast(nota.nota7 as integer) <> 0) 
or ( cast(nota.nota8 as integer) <= $nota_deficiente AND cast(nota.nota8 as integer) <> 0) 
or ( cast(nota.nota9 as integer) <= $nota_deficiente AND cast(nota.nota9 as integer) <> 0) 
or ( cast(nota.nota10 as integer) <= $nota_deficiente AND cast(nota.nota10 as integer) <> 0) 
or ( cast(nota.nota11 as integer) <= $nota_deficiente AND cast(nota.nota11 as integer) <> 0) 
or ( cast(nota.nota12 as integer) <= $nota_deficiente AND cast(nota.nota12 as integer) <> 0) 
or ( cast(nota.nota13 as integer) <= $nota_deficiente AND cast(nota.nota13 as integer) <> 0) 
or ( cast(nota.nota14 as integer) <= $nota_deficiente AND cast(nota.nota14 as integer) <> 0) 
or ( cast(nota.nota15 as integer) <= $nota_deficiente AND cast(nota.nota15 as integer) <> 0) 
or ( cast(nota.nota16 as integer) <= $nota_deficiente AND cast(nota.nota16 as integer) <> 0) 
or ( cast(nota.nota17 as integer) <= $nota_deficiente AND cast(nota.nota17 as integer) <> 0) 
or ( cast(nota.nota18 as integer) <= $nota_deficiente AND cast(nota.nota18 as integer) <> 0) 
or ( cast(nota.nota19 as integer) <= $nota_deficiente AND cast(nota.nota19 as integer) <> 0) 
or ( cast(nota.nota20 as integer) <= $nota_deficiente AND cast(nota.nota20 as integer) <> 0)  )
WHERE  ma.rdb = $rbd AND ma.id_ano = $id_ano_configuracion
ORDER BY ma.rdb,cu.ensenanza,cu.grado_curso,cu.id_curso,ma.rut_alumno,nota.id_periodo";
 
 /*
  echo "<pre>";
 echo $sql_notas;
 echo "</pre>";*/
   

$resul_2 = @pg_Exec($conn, $sql_notas) or die ( pg_last_error($conn)."INICIO 3");



		
								  	 if(pg_numrows($resul_2)>0){
								  	
									  for ($i11=0; $i11 < pg_numrows($resul_2); $i11++) {
									  		    	
									  		    $fila_2 = pg_fetch_array( $resul_2 ,$i11);
									  		    
									  		    
									  		    			 $notas1 = "";
													    	 $notas2 = "";
													    	 $notas3 = "";
													    	 $notas4 = "";
													    	 $notas5 = "";
													    	 $notas6 = "";
													    	 $notas7 = "";
													    	 $notas8 = "";
													    	 $notas9 = "";
													    	 $notas10 = "";
													    	 $notas11 = "";
													    	 $notas12 = "";
													    	 $notas13 = "";
													    	 $notas14 = "";
													    	 $notas15 = "";
													    	 $notas16 = "";
													    	 $notas17 = "";
													    	 $notas18 = "";
													    	 $notas19  = "";
													    	 
                                                          
                                                          $notas = "";
									  		              for ($e=1; $e <= 20 ; $e++) {
									  		              	
                                                                 	$nota  = $fila_2['nota'.$e];
                                                            
															     	 if(  ( $nota <= $nota_deficiente )  and  ($nota <> 0 ) ){
                                                                 	 	
                                                                 	 			${'notas'.$e} =  $nota;
                                                                 	          
																	 			}
                                                            
															              }
									  		                  			
			  		                  				        // Ordeno Registros $fila_2['nombre_profesor_dicta'],
													    	 $myArr  = array(  $fila_2['rut_dv_alumno'],
													    	 $fila_2['nombre_alumno'],
													    	 $fila_2['curso_completo'],
													    	 $fila_2['nombre_periodo'],
													    	 $fila_2['nombre_subsector'],
													    	trim( $notas1),
													    	trim($notas2),
													    	trim($notas3),
													    	trim($notas4),
													    	trim($notas5),
													    	trim($notas6),
													    	trim($notas7),
													    	trim($notas8),
													    	trim($notas9),
													    	trim($notas10),
													    	trim($notas11),
													    	trim($notas12),
													    	trim($notas13),
													    	trim($notas14),
													    	trim($notas15),
													    	trim($notas16),
													    	trim($notas17),
													    	trim($notas18),
													    	trim($notas19)  );
												            
												               echo "<pre>";
													         	print_r($myArr )."<br/>";
													        	echo "</pre>";
													         
															$excel->writeLine($myArr);   //Guardo en Excel 
									  	
									              } 
									              
									       }  // FIN RECORRER ALUMNOS 
								
								
								/*ENVIO POR CORREO*/
					        	require_once("mail/class.phpmailer.php");
							
					        	echo "<br/>(Inicio Envio de Correo)<br/>";
			
								$mail = new phpmailer();
			  	    
						  	    $mail->IsSMTP();
								$mail->PluginDir = "mail/";
							    $mail->Mailer = "smtp";
								$mail->Host = "mail.colegiointeractivo.com";
							    $mail->SMTPAuth = true;
								$mail->SMTPSecure = "ssl";
								$mail->Username = "mansajeria@colegiointeractivo.com"; 
							    $mail->Password = "300600";
								$mail->From = "mensajeria@colegiointeractivo.com";
							    $mail->FromName = "Servidor Colegio Interactivo";
								$mail->Timeout=30;
								$mail->AddAttachment("Ficheros_Exel/Reporte_Notas$rbd-$tipo_ensenanza.xls");
								$mail->AddAddress("pcardenas@colegiointeractivo.com,
								bvargas@colegiointeractivo.com,erojas@colegiointeractivo.com,pcgaray@gmail.com"); 
								$mail->Subject = "Informe Semanal de Notas";
								$mail->Body=" <strong>Informe Semanal Notas.</strong>.";
								$exito = $mail->Send();
								$mail->IsMail();  
							    $intentos=1; 
						    
								while ((!$exito) && ($intentos < 5)) {
									sleep(5);
										$exito = $mail->Send();
										$intentos=$intentos+1;	
									  }
								
						         if(!$exito){
									echo "Correo No Enviado <br/>"; // No guardo correctamente
								 }else{
									echo "Correo Enviado <br/>" ; // guardo correctamente 
								   } 
						        
								 $mail->ClearAddresses();
						         $mail->ClearAttachments();
								
														
	  	
	          } // fin if notifica notas 
		     	
		
		} // fin for principal recorre todas las instituciones con configuracion
		
		
	  }


/*******************************************************************************************************/
 
function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

echo "<br/><br/>";

echo 'Memoria Ram Utilizada :'.convert(memory_get_usage(true)); 

echo "<br/><br/>";
			
$time_end = microtime(true);
$time = $time_end - $time_start;

echo "Tiempo de Ejecucion :  $time segundos\n";

?>


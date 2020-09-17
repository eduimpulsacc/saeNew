<? 
$time_start = microtime(true);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();

//phpinfo();
//return;

/*$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexi?n Corporacion.");	*/
/*correo_notificacion_notas($curso,$ano,$id_ramo,$periodo,$conn,$usuario,1);*/

//correo_notificacion_inasistencia (9699,576,$conn);
//$alumno=20678722;$ano=576;$usuario=1;$id_ramo=444 ;
//correo_notificacion_anotacion($alumno,$ano,$conn,$usuario,2,$id_ramo);
		 	
$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");

 /**************************************************************************/
$Total_Negativas=0;
$cuenta_sinnegativas=0;

 $sql = "SELECT ncc.rbd,ncc.tipo_ensenanza,ncc.id_notifica_correo_configuracion,ncc.notifica_anotaciones,ncc.nro_anotaciones,ncc.id_ano	
			   FROM notifica_correo_configuracion ncc 
			   WHERE ncc.notifica_anotaciones = 1";
		
	  $resul = @pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 1");
		
	  if(pg_numrows($resul)>0){
      	  
	  	//Cargo Clase para Armar Excel
	    require_once("Crea_Excel.php");
			  
		// RECORRE LAS INSTITUCIONES QUE CUMPLEN CON LA CONDICION 	
		for ($i1=0; $i1 < pg_numrows($resul); $i1++) { 
		
		$fila = pg_fetch_array($resul,$i1);
		   
		echo "<br/><br/>Numero de Institucion = ".$i1."<br/>";
	
	    $idconfiguracion = $fila['id_notifica_correo_configuracion'];
        $notificacion_anotaciones = $fila['notifica_anotaciones']; 
        $rbd = $fila['rbd']; 
		$nro_anotaciones = $fila['nro_anotaciones'];
		$id_ano_configuracion = $fila['id_ano'];
		 $tipo_ensenanza = $fila['tipo_ensenanza'];
		
		$excel	=	 new ExcelWriter("Ficheros_Exel/Reporte_Anotaciones$rbd-$tipo_ensenanza.xls");
	    if($excel==false) {  echo $excel->error;  }
  		    
	    //Array con Campos del Excel		   
	    $myArr=array(  "Rut","Nombre_Alumno","Curso","Docente","Detalle","Fecha"  );
		$excel->writeLine($myArr);


	  if( $notificacion_anotaciones == 1 ){
		     	
	  // Entra solo si esta activa la opcion de enviar por anotaciones 
		
	echo  $qsql = "SELECT ma.rut_alumno FROM matricula as ma 
	                   INNER JOIN curso ON curso.id_curso = ma.id_curso AND curso.ensenanza = $tipo_ensenanza
						WHERE ma.rdb = $rbd  and ma.bool_ar = 0 and ma.id_ano = $id_ano_configuracion  ";

						
	   $rsql = pg_Exec($conn,$qsql) or die ( pg_last_error($conn)."INICIO 2");
	   
	   $sql = "SELECT * FROM ano_escolar WHERE id_ano = $id_ano_configuracion";
	   $ano_result = pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 3");
	   
	   $fila_ano_result  = pg_fetch_array( $ano_result ,0);
	   
		$cantidad_alumnos = pg_numrows($rsql);
				 
	    // _ INICIO DE CICLO RECORRE TODOS LOS ALUMNOS DEL COLEGIO.
	   for ($i2=0; $i2 < pg_numrows($rsql); $i2++) { 
		   
	       $fsql = pg_fetch_array($rsql,$i2);
		   
	   	   // OBTENGO SI ALUMNOS CUMPLEN CON LA CONDICION
					
             $q1 = "SELECT sum(tvz.num_anotaciones_negativas) as totalnegativas 
			 FROM (select count(aa1.id_anotacion) as num_anotaciones_negativas  
			 FROM anotacion aa1
			 inner join tipos_anotacion tii on tii.id_tipo = aa1.codigo_tipo_anotacion
			 WHERE  
			 aa1.rut_alumno = ".$fsql['rut_alumno']." 
			 AND 
			 tii.tipo = 2
			 AND 
			 EXTRACT(year from  aa1.fecha) = ".$fila_ano_result['nro_ano']."
			 UNION
			 select count(aa1.id_anotacion) as num_anotaciones_negativas  
			 FROM anotacion aa1
			 WHERE  
			 aa1.rut_alumno = ".$fsql['rut_alumno']."  
			 AND 
			 aa1.tipo_conducta = 2
			 and EXTRACT(year from  aa1.fecha) = ".$fila_ano_result['nro_ano']." ) as tvz";
			 
			 $r = @pg_Exec($conn,$q1) or die ( pg_last_error($conn));
			 $f = pg_fetch_array($r,0);
		     $totalnegativas  = $f['totalnegativas'];
       
       if( $nro_anotaciones <= $totalnegativas ){   // si se cumple la condicion   
			 
	       // OBTENGO TODAS LAS ANOTACIONES ._
	        
	        $Total_Negativas++;
	        
	      $q2 = "SELECT aa1.id_anotacion, aa1.tipo_conducta as tipo_1,
					   aa1.observacion as detalle_1, tii.tipo as tipo_2,
					   de.detalle as detalle_2, aa1.fecha , 
					   CAST(emp.ape_pat || ' ' || emp.ape_mat || ' ' || emp.nombre_emp as varchar ) as nombre_empleado, 
					   CAST(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_alumno, 
					   CAST(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno, 
					   CAST( cu.grado_curso || ' ' || cu.letra_curso as varchar ) as curso_letra, current_date as fecha_actual, 
					   CAST(apo.rut_apo || '-' || apo.dig_rut as varchar) as rut_apoderado, 
					   CAST(apo.ape_pat || ' ' || apo.ape_mat || ' ' || apo.nombre_apo as varchar) as nombre_apoderado,
					   CAST(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as nombre_profesorjefe ,
					   cu.id_curso,cu.ensenanza,tienza.nombre_tipo
					   FROM anotacion aa1 
					   INNER JOIN empleado emp ON emp.rut_emp = aa1.rut_emp 
					   INNER JOIN alumno alu ON alu.rut_alumno = aa1.rut_alumno 
					   LEFT OUTER JOIN tiene2 tie ON tie.rut_alumno = alu.rut_alumno  and responsable = 1
					   LEFT OUTER JOIN apoderado apo ON apo.rut_apo = tie.rut_apo 
					   INNER JOIN matricula matri ON matri.rut_alumno = alu.rut_alumno AND EXTRACT(year from matri.fecha) = ".$fila_ano_result['nro_ano']."
					   INNER JOIN curso cu ON cu.id_curso = matri.id_curso 
					   INNER JOIN tipo_ensenanza tienza ON tienza.cod_tipo = cu.ensenanza 
					   INNER JOIN supervisa supe ON supe.id_curso = cu.id_curso 
					   INNER JOIN empleado projefe ON projefe.rut_emp = supe.rut_emp 
					   LEFT OUTER JOIN tipos_anotacion tii ON tii.id_tipo = aa1.codigo_tipo_anotacion 
					   LEFT OUTER JOIN detalle_anotaciones de ON de.codigo = aa1.codigo_anotacion 
					   WHERE aa1.rut_alumno = ".$fsql['rut_alumno']."
					   AND CASE WHEN aa1.tipo_conducta IS NOT NULL THEN aa1.tipo_conducta = 2 
					   WHEN tii.tipo IS NOT NULL THEN tii.tipo = 2 
					   END AND EXTRACT(year from aa1.fecha) = ".$fila_ano_result['nro_ano']."  ORDER BY tipo_conducta,fecha DESC";
      
        $result2 = @pg_Exec($conn,$q2) or die ( pg_last_error($conn));
	        
	        
          // Inicio Ciclo para recorrer Registros.
		  for($i3=0;$i3< pg_numrows($result2);$i3++){
		  					 
		  $fila_11 = pg_fetch_array($result2,$i3);
								
				 if($fila_11['tipo_1']==2){
					$detalle = $fila_11['detalle_1'];
				 }elseif($fila_11['tipo_2']==2){
				    $detalle = $fila_11['detalle_2'];
				  }
		              
		        //$nombre_tipo = htmlentities($fila_11['nombre_tipo'],ENT_QUOTES,'UTF-8');
		        		        	 
		        // Ordeno Registros
		    	 $myArr  = array( $fila_11['rut_alumno'],
		    	 $fila_11['nombre_alumno'],
		    	 $fila_11['curso_letra'],
		    	 $fila_11['nombre_empleado'],
		    	 $detalle,
		    	 $fila_11['fecha'] );
	            
	           		/*echo "<pre>";
		         	print_r($myArr )."<br/>";
		        	echo "</pre>";*/
		         
				$excel->writeLine($myArr);   //Guardo en Excel 
   
				  }

			   }else{
			   	
				$cuenta_sinnegativas++;
				
			   }
      
	           }  // Fin de Ciclo Recorre Alumnos del Colegio
      	  
            $excel->close();    
			
			//echo "_ZIP=UNO_";
			
/*
			$zip  =  new ZipArchive();
			$filename = "Ficheros_Exel/Reporte_Anotaciones$rbd-$tipo_ensenanza.zip";
				if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
					 $zip->addFile("Ficheros_Exel/Reporte_Anotaciones$rbd-$tipo_ensenanza.xls");
					 $zip->close();
					 	echo 'Creado '.$filename;
				   }else {
						$zip->close();
				        echo 'Error creando '.$filename;
					}
*/
             
		   //echo "_ZIP=DOS_";
				
			$sql = "SELECT e.email FROM notifica_correo_empleados nce 
			INNER JOIN empleado e ON e.rut_emp = nce.rut_empleado
			WHERE nce.id_notifica_correo_configuracion = $idconfiguracion";
			$rs_nce = @pg_exec($conn,$sql) or die ( "Error Correo 1");
			
		 	if (@pg_numrows($rs_nce)!=0){
			for($i=0;$i<@pg_numrows($rs_nce);$i++){
			    $fila_nce = @pg_fetch_array($rs_nce,$i);
						$destinatario .= trim($fila_nce['email']).",";
				 	   }
					}
		   $destinatario = substr($destinatario,0,-1);	
			
 
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
						$mail->AddAttachment("Ficheros_Exel/Reporte_Anotaciones$rbd-$tipo_ensenanza.xls");
					    
						$mail->AddAddress($destinatario); 
						$mail->Subject = "Informe Semanal de Anotaciones";
						$mail->AltBody = "Hola,\neste correo ha sido enviado desde PHP usando PHPMailer.";
						$mail->Body="Hola,<br>Informe Semanal Anotaciones. <strong>pcardenas.</strong>.";
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

				echo  'Cantidad Alumnos = '.$cantidad_alumnos.'<br>';
				echo 	'Cuenta Sin Negativas = '.$cuenta_sinnegativas.'<br>';
	            echo  'Total Negativas = '.$Total_Negativas.'<br>';
	           
	           $cuenta_sinnegativas=0;
			   $Total_Negativas=0;
			   
				echo "<br/>Final<br/>";
                          
               /*FIN*/
                
            }  //FIN si se cumple la condición	 
      
      }  // CICLO si hay configuracion activa
				
  }  // IF si existen registros 


/***************************************************************************************************************************************************************************/

 
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


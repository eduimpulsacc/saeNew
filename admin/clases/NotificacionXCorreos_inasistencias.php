<? 
$time_start = microtime(true);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();
		 	
$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");

 /**************************************************************************/

 	  $sql = "SELECT  ncc.id_notifica_correo_configuracion, ncc.rbd,ncc.tipo_ensenanza, ncc.cargo, ncc.notifica_asistencia, ncc.dias_asistencia, ncc.periodo_notificacion, ncc.id_ano	
	  FROM notifica_correo_configuracion  as ncc 
	  WHERE ncc.notifica_asistencia = 1";
		
	  $resul = @pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 1");
		
	  if(pg_num_rows($resul)>0){
      	  
	  	//Cargo Clase para Armar Excel
	    require_once("Crea_Excel.php");
			  
		// RECORRE LAS INSTITUCIONES QUE CUMPLEN CON LA CONDICION 	
		for ($i1=0; $i1 < pg_numrows($resul); $i1++) { 
		
		$fila = pg_fetch_array($resul,$i1);
		   
		echo "<br/><br/>Numero de Institucion = ".$i1."<br/>";
	
	    $idconfiguracion = $fila['id_notifica_correo_configuracion'];
        
        $rbd = $fila['rbd']; 
		
	   $notifica_asistencia = $fila['notifica_asistencia'];
		
	    $dias_asistencia = $fila['dias_asistencia'];
		
		$periodo_notificacion = $fila['periodo_notificacion'];
		
		$id_ano_configuracion = $fila['id_ano'];
		
		 $tipo_ensenanza = $fila['tipo_ensenanza'];
	

	   /*INICIO ARCHIVO EXCEL*/	
		$excel	=	 new ExcelWriter("Ficheros_Exel/Reporte_Inasistencia$rbd-$tipo_ensenanza.xls");
	    if($excel==false) {  echo $excel->error;  }
  		    
	    //Array con Campos del Excel		   
	    $myArr=array(  "Curso","Profesorjefe","Rut","Nombre", "Cantidad dias" );
		$excel->writeLine($myArr);


	  if( $notifica_asistencia  == 1 ){
		     	
	  // Entra solo si esta activa la opcion de enviar por asistencia

	  // OBTENGO EL CURSO COMPLETO
		    $q_curso = "SELECT 
			ma.nro_lista, 
			CAST(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_completo, 
			alu.rut_alumno,
			CAST(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_completo,
			CAST(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso_completo,
			CAST(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as nombre_profesorjefe,
			CURRENT_DATE as fecha_actual,ma.id_curso,ma.id_ano
			FROM matricula as ma 
			INNER JOIN alumno as alu ON alu.rut_alumno = ma.rut_alumno
			INNER JOIN curso as cu ON cu.id_curso = ma.id_curso AND cu.ensenanza = $tipo_ensenanza
			INNER JOIN supervisa as supe ON supe.id_curso = cu.id_curso 
			INNER JOIN empleado as projefe ON projefe.rut_emp = supe.rut_emp
			WHERE 
			ma.rdb = $rbd
			AND ma.bool_ar = 0 
			AND ma.id_ano = $id_ano_configuracion
			ORDER BY 5";
						
		$r_curso = pg_Exec($conn,$q_curso) or die ( pg_last_error($conn));
   
		if (pg_num_rows($r_curso)!=0){ // if 1
		
					for($x1=0;$x1<=@pg_numrows($r_curso);$x1++){ // for 1 RECORRO EL CURSO Y COMPRUEBA INASISTENCIAS
					
						$f_curso = pg_fetch_array($r_curso,$x1);
						
						 $rut_dv_alumno = $f_curso['rut_completo'];
						 $nombre_alumno = $f_curso['nombre_completo'];
						 $rut = $f_curso['rut_alumno'];
						 $nombre_curso = $f_curso['curso_completo'];
						 $nombre_profesorjefe = $f_curso['nombre_profesorjefe'];
						 $fecha_actual = $f_curso['fecha_actual'];
						$id_curso = $f_curso['id_curso'];
						 $id_ano = $f_curso['id_ano'];
 
						// INICIO CADENAS CON DISTINTAS QUERYS
						$qr0 = "SELECT count(asis.rut_alumno)as numero_dias_inasistencia ";
						
						$qr1 = "SELECT asis.rut_alumno,asis.ano,asis.id_curso,asis.fecha ";
						
						$qr2 = "FROM asistencia AS asis 
						WHERE 
						asis.id_curso =  $id_curso  
						AND
						asis.ano = $id_ano
						AND
						asis.rut_alumno = $rut ";
						
						//Solo los registros que sean iguales al dia de la semana
						$q3 = "AND
						EXTRACT(WEEK FROM asis.fecha) = EXTRACT(WEEK FROM CURRENT_DATE)";
						
						//Dia cuento los registros inasistencia en la quincena
						$q4 = "AND
						CASE WHEN EXTRACT(DAY FROM CURRENT_DATE)>15 THEN
						EXTRACT(DAY FROM asis.fecha)<15 ELSE
						EXTRACT(DAY FROM asis.fecha)>15 END 
						AND
						EXTRACT(MONTH FROM asis.fecha) = EXTRACT(MONTH FROM CURRENT_DATE)";
						
						//Solo los registros que pertenescan al mes actual
						$q5 = " AND
						EXTRACT(MONTH FROM asis.fecha) = EXTRACT(MONTH FROM CURRENT_DATE)";
						
						/////////////////////////////////////////////////////
						
							// armo primera query
							$sql = $qr0.$qr2;
							
							switch($periodo_notificacion){ 
							// segun sea la configuracion se agrega la validacion
							case 1:
								$sql .= $q3;
								$det_periodo="Inasistenacias dentro de la semana";
								break;
							case 2:
								$sql .= $q4;
								$det_periodo="Inasistencias dentro de la quincena";
								break;
							case 3:
								$sql .= $q5;
								$det_periodo="Inasistencias dentro del mes";
								break;
							 }
						
						$r_inasistencia_alumnos = @pg_Exec($conn,$sql);
						
						echo '<br>Registros de Inasistencia : '.pg_num_rows($r_inasistencia_alumnos);
						
						if (@pg_num_rows($r_inasistencia_alumnos)!=0){  // encuentra registros inasistencia alumnos
							
							$f_inasistencia_alumnos = pg_fetch_array($r_inasistencia_alumnos,0);
						
						   	echo '<br>Dias de Alumno = '. $numero_dias_inasistencia = $f_inasistencia_alumnos['numero_dias_inasistencia'];
						
							if( $numero_dias_inasistencia >= $dias_asistencia ){ 
							//sino no se muestra alumno
															
						    $myArr  = array( $nombre_curso, $nombre_profesorjefe, $rut_dv_alumno, $nombre_alumno,$numero_dias_inasistencia);
								
								   	       echo "<pre>";
								         	print_r($myArr )."<br/>";
								        	echo "</pre>";
								         
										$excel->writeLine($myArr);   //Guardo en Excel 
				
								} // no se muestra alumno
					 
					  } // fin encuentra registros inasistencia alumnos
					 
					 } // for 1
		 
		} // if 1
      	  
            $excel->close();    
				
			$sql = "SELECT e.email FROM notifica_correo_empleados nce 
			INNER JOIN empleado e ON e.rut_emp = nce.rut_empleado
			WHERE nce.id_notifica_correo_configuracion = $idconfiguracion";
			//$rs_nce = @pg_exec($conn,$sql) or die ( "Error Correo 1");
			
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
						$mail->AddAttachment("Ficheros_Exel/Reporte_Inasistencia$rbd-$tipo_ensenanza.xls");
					    
$mail->AddAddress($destinatario); 
						$mail->Subject = "Informe Semanal de Inasistencia";
						$mail->AltBody = "Hola,\neste correo ha sido enviado desde PHP usando PHPMailer.";
						$mail->Body="Hola,<br>Informe Semanal Inasistencia. <strong>pcardenas.</strong>.";
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


<? 
$time_start = microtime(true);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();
		 	
$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");

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
			//$rs_nce = @pg_exec($conn,$sql) or die ( "Error Correo 1");
			
			 /* 	if (@pg_numrows($rs_nce)!=0){
			for($i=0;$i<@pg_numrows($rs_nce);$i++){
			    $fila_nce = @pg_fetch_array($rs_nce,$i);
						$destinatario .= trim($fila_nce['email']).",";
				 	   }
					}
		   $destinatario = substr($destinatario,0,-1);		*/	
			
 
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
					    $mail->AddAddress("pcardenas@colegiointeractivo.com,bvargas@colegiointeractivo.com,erojas@colegiointeractivo.com,pcgaray@gmail.com"); 
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




function correo_notificacion_notas($curso,$ano,$id_ramo,$periodo,$conn,$usuario,$guardo) {

$qsql_parametros = "SELECT ncc.id_notifica_correo_configuracion, 
ncc.rbd, ncc.tipo_ensenanza, 
ncc.cargo, ncc.notifica_notas, 
ncc.nro_notas, ncc.nota_deficiente, 
ncc.notifica_anotaciones,ncc.nro_anotaciones, 
ncc.notifica_asistencia, ncc.dias_asistencia, 
ncc.periodo_notificacion, 
anes.nro_ano
FROM matricula as ma 
INNER JOIN curso cu ON cu.id_curso = ma.id_curso 
INNER JOIN ano_escolar anes ON anes.id_ano = ma.id_ano
INNER JOIN notifica_correo_configuracion ncc ON 
ncc.rbd = ma.rdb AND ncc.tipo_ensenanza = cu.ensenanza 
WHERE ma.id_curso = $curso AND ncc.notifica_notas = 1
AND ma.id_ano = $ano LIMIT 1";
   
	   //echo "<pre>".$qsql_parametros."</pre>";
	   
	   $rsql_parametros = @pg_Exec($conn,$qsql_parametros) or die ( "Error Notas 1" );
	   $n0 = @pg_numrows($rsql_parametros);
	   $fsql_parametros = pg_fetch_array($rsql_parametros,0);
       
	   $idconfiguracion = $fsql_parametros['id_notifica_correo_configuracion'];
	   $nro_ano = $fsql_parametros['nro_ano'];
       $nro_notas_malas = $fsql_parametros['nro_notas'];
       $nota_deficiente = $fsql_parametros['nota_deficiente'];
	   $rbd = $fsql_parametros['rbd'];

// guardo la informacion de alumnos con el ramo y notas 
$informacionXramo = array();

$sql0 = "SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, 
proramo.rut_emp,
cast(proramo.ape_pat || ' ' || proramo.ape_mat || ' ' || proramo.nombre_emp as varchar) as nombre_profesor 
FROM subsector 
INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector
left outer join dicta di on di.id_ramo = ramo.id_ramo
left outer join empleado proramo on proramo.rut_emp = di.rut_emp
WHERE ramo.id_curso= $curso AND ramo.id_ramo = $id_ramo order by ramo.id_orden  ";
$rs_ramos = @pg_exec($conn,$sql0) or die  ( "Error Notas 2" );

 
 if (@pg_numrows($rs_ramos)!=0){  // recorro los ramos uno a uno y busco las notas malas 

    $cantiad_de_ramos = @pg_numrows($rs_ramos);
	 
    for($i1=0;$i1<@pg_numrows($rs_ramos);$i1++){	//ciclo ramos 		
	
	$fila_ramos = pg_fetch_array($rs_ramos,$i1);
	
	$cant_mayor = 0;
	
	$informacionXramo[$i1]['sub_sector-'.$i1]= $fila_ramos['nombre'];
	$informacionXramo[$i1]['profe_ramo-'.$i1]= $fila_ramos['nombre_profesor'];
		
	$sql_notas = "SELECT 
	n.rut_alumno,n.id_ramo,n.id_periodo,
	n.nota1,n.nota2,n.nota3,n.nota4,n.nota5,
	n.nota6,n.nota7,n.nota8,n.nota9,n.nota10,
	n.nota11,n.nota12,n.nota13,n.nota14,n.nota15,
	n.nota16,n.nota17,n.nota18,n.nota19,n.nota20,
	n.promedio,n.notaap,
	cast(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_dv_alumno,
	cast(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno,
	cast(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso_completo,
	cast(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as 
	nombre_profesorjefe 
	FROM notas$nro_ano n 
	inner join matricula ma on ma.rut_alumno = n.rut_alumno and ma.id_curso = $curso 
	inner join alumno alu on alu.rut_alumno = ma.rut_alumno
	inner join curso cu on cu.id_curso = ma.id_curso
	left outer join  supervisa supe on supe.id_curso = cu.id_curso 
    left outer join empleado projefe on projefe.rut_emp = supe.rut_emp
	WHERE n.id_ramo = $id_ramo AND n.id_periodo = $periodo ";
	
	//echo "<pre>".$sql_notas."</pre>";
		
	$rs_notas = @pg_exec($conn,$sql_notas) or die  ( "Error Notas 3" );
		
			if (@pg_numrows($rs_notas)!=0){ // recorro las notas segun el id de ramo
			
				$cantidad_de_alumnos = @pg_numrows($rs_notas);
				
				for($i2=0;$i2<=@pg_numrows($rs_notas);$i2++){ 
				// ciclo recorro todos los alumnos y sus notas de este ramo
				    					
				$fila_notas = pg_fetch_array($rs_notas,$i2); 
				
				$informacionXramo[$i1]['curso_completo-'.$i2] = $fila_notas['curso_completo'];
				$informacionXramo[$i1]['profesorjefe-'.$i2] = $fila_notas['nombre_profesorjefe'];
				
				$informacionXramo[$i1]['rut_dv_alumno'.'-'.$i2] = $fila_notas['rut_dv_alumno'];
				$informacionXramo[$i1]['nombre_alumno'.'-'.$i2] = trim($fila_notas['nombre_alumno']);
								
				$cont_notas_malas = 0;
				$x=0;
				
				for($i3=1;$i3<=21;$i3++){ // ciclo recorre notas del alumno
				
									 
				if( $fila_notas['nota'.$i3] < $nota_deficiente && $fila_notas['nota'.$i3] <> 0 ){
					
					$cont_notas_malas++;
					$x++;
				    $informacionXramo[$i1]['notas_malas-'.$i2] = 1;
					$informacionXramo[$i1]['cant_malas-'.$i2] = $cont_notas_malas;
					$informacionXramo[$i1]['not'.$x.'-'.$i2] = $fila_notas['nota'.$i3];  
							   
					 }
						 
				} // fin  ciclo recorre notas del alumno
						 
				if($cont_notas_malas==0){
				
				$informacionXramo[$i1]['notas_malas-'.$i2] = 0;
				$informacionXramo[$i1]['cant_malas-'.$i2] = 0;
				
				}
				
				if($cant_mayor <= $cont_notas_malas) $cant_mayor = $cont_notas_malas;
								
				} // fin ciclo recorro
			
			
			}  //fin recorro notas  
	 
	    $informacionXramo[$i1]['cant_mayor_notas-'.$i1]= $cant_mayor;
		$informacionXramo[$i1]['cantidad_de_alumnos_x_ramo-'.$i1] = $cantidad_de_alumnos;

		
	   } // ciclo ramos
   
   
   } // fin // recorro los ramos
   
//============================================================

/*echo "<pre>";
print_r($informacionXramo);
echo "</pre>";*/

$fecha_actual=date("d/m/Y");

// mensaje
$mensaje = '<html>
			<head>
			<title>Notificacion por Notas</title>
			</head>
			<body>
			<h2>Listado de Alumnos con '.$nro_notas_malas.' o m?s Notas Insuficientes</h2>
			<h3><p>Fecha  :  '.$fecha_actual.'</p>
			<p>Curso  :  '.$informacionXramo[0]['curso_completo-0'].'</p>
			<p>Profesor Jefe  :  '.$informacionXramo[0]['profesorjefe-0'].'</p></h3>';
			
for($x1=0;$x1<=$cantiad_de_ramos;$x1++){ // 1

$cantidad_de_alumnos = $informacionXramo[$x1]['cantidad_de_alumnos_x_ramo-'.$x1];
$cant_mayor_notas = $informacionXramo[$x1]['cant_mayor_notas-'.$x1];
$sub_sector = $informacionXramo[$x1]['sub_sector-'.$x1];
$profe_ramo = $informacionXramo[$x1]['profe_ramo-'.$x1];

if ( $cantidad_de_alumnos>0 && $cant_mayor_notas>=$nro_notas_malas ){
			
$mensaje .= '<br><table border="0">
			<tr align="left">
			<th>Sub-sector:</th>
			<th>'.$sub_sector.'</th>
			</tr>
			<tr align="left">
			<th>Profesor:</th>
			<th>'.$profe_ramo.'</th>
			</tr>
			</table>';

$mensaje .= '<table border="1">
			<tr>
			<th>Rut</th>
			<th>Nombre</th>
			<th colspan="'.$cant_mayor_notas.'" >Notas</th>
			</tr>';

	
				for($x2=0;$x2<=$cantidad_de_alumnos;$x2++){ // 2
				
				 $notas_malas = $informacionXramo[$x1]['notas_malas-'.$x2];
				 $cant_malas  = $informacionXramo[$x1]['cant_malas-'.$x2];
				 
						if( $notas_malas == 1 && $cant_malas >= $nro_notas_malas ){ 
						//sino no se muestra alumno
						
						$rut_dv_alumno = $informacionXramo[$x1]['rut_dv_alumno'.'-'.$x2];
						$nombre_alumno = $informacionXramo[$x1]['nombre_alumno'.'-'.$x2];
										
						$mensaje .= '<tr>
									 <td>'.$rut_dv_alumno.'</td>
									 <td>'.$nombre_alumno.'</td>';
						
						for($x3=1;$x3<=$cant_mayor_notas;$x3++){ // 3
						 $mensaje .= '<td>'.$informacionXramo[$x1]['not'.$x3.'-'.$x2].'</td>'; 
						  } //3
						
						$mensaje .= '</tr>';
						
						  } // no se muestra alumno
				
					} // 2
		
          } 			 
				 
    $mensaje .= '</table>';


   } //1
 
 
$mensaje .= '</body>
			 </html>';
		

//echo $mensaje;

$asunto="Notificacion Alumnos Cumple Condici?n de Notas Deficientes";

envio_correo_notificacion($asunto,$mensaje,$idconfiguracion,$conn,$rbd,$ano,$curso,$usuario,$guardo,$id_ramo);
						  
  } // FIN FUNCION CORREO NOTAS
  
  
 
 
?>


<?
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
require('../../../../../util/header.inc');
//print_r($_POST);

	
    $institucion	=$_INSTIT;
	
	$institucion = $_POST['institucion'];
	
    $ano = $_POST['ano'];
	
    $cmbANO = $_POST['cmbANO'];
	  
    $curso = $_POST['curso'];

	$alumno = $_POST['alumno'];
	$guardar = $_POST['guardar'];
	
	$nombrebase = pg_dbname($conn);
	
	$usuario        =$_USUARIO;
    $id_ramo		=$_RAMO;
    
    $codigo2 = $_POST['codigo2'];
	
    $sigla = $_POST['sigla'];
	
	if ($_POST['tipo_responsable'] != ""){
	$tipo_responsable = $_POST['tipo_responsable'];
	}else{ $tipo_responsable = 0; }
		
	$periodo = $_POST['periodo'];
	$fecha = $_POST['fecha'];
	
	$ramo  = (isset($_POST['ramo']))?$_POST['ramo']:0;
	
	
	//13/06/2013
	
	/*$separaFecha = explode('-',$fecha);
	$dia = $separaFecha[0];
	$mes = $separaFecha[1];
	$ano = $separaFecha[2];*/
	
	
	
	
	/*if($nombrebase=="coi_antofagasta"){ 
		   $fecha = fEs2En233($fecha); 
		}
		
		if($nombrebase=="coi_final"){
		   $fecha = fEs2En($fecha); 
		} 
		*/
		/*if($nombrebase=="coi_final_vina"){
		   $fecha = fEs2En($fecha); 
		}*/
		
		/*if($nombrebase=="coi_final1"){
		   $fecha = $fecha; 
		}*/
		
		//if(pg_dbname()=='coi_final'){
		$separa_fecha = explode('/',$fecha);
		$fecha =$separa_fecha[2].'-'.$separa_fecha[1].'-'.$separa_fecha[0];	
		//}
		
		/*if(pg_dbname()=='coi_corporaciones'){
		$separa_fecha = explode('/',$fecha);
		$fecha =$separa_fecha[1].'/'.$separa_fecha[0].'/'.$separa_fecha[2];	
		}*/
		
			
		
	
	$observacion = utf8_decode($_POST['observacion']);
	$tipo_anotacion = $_POST['tipo_anotacion'];
    $detalle_anotacion = $_POST['detalle_anotacion'];
	
	if ($_POST['hora'] != ""){
	$hora = $_POST['hora'];
	}else{ $hora = "00:00"; } 
	
	if($_POST['tipo_conducta'] != ""){	
	$tipo_conducta = $_POST['tipo_conducta']; 
	}else{ $tipo_conducta = 0;	}

	if($_POST['rut_emp'] != ""){	
	$rut_emp = $_POST['usuarioactual2']; 
	}else{ $rut_emp = "NULL";	}
	
	$hh = str_replace(":","",$hora);
	$jou = ($hh<=1400)?1:2;
	
	
  
 
	
switch ($guardar) {

    case 1:  	

    // buscar codigos y luego grabara
   $q1 = "select id_sigla from sigla_subsectoraprendisaje 
	where sigla = '$sigla' and rdb = $institucion";
	
	$r1 = pg_Exec($conn,$q1);
	$n1 = pg_numrows($r1);
	
		if ($n1==0){
		    
			echo "La Sigla Ingresada no es Correcta";
			exit;
		 
		 }else{
					
			  $f1 = pg_fetch_array($r1,0);
			  $sigla  = $f1['id_sigla'];
		  													
		  // busco el codigo								
		  $q2 = "select * from detalle_anotaciones
				 inner join tipos_anotacion ON tipos_anotacion.id_tipo = detalle_anotaciones.id_tipo
				 where 
				 detalle_anotaciones.codigo = '$codigo2' and
				 tipos_anotacion.rdb = $institucion";
					
				$r2 = pg_Exec($conn,$q2);
				$n2 = pg_numrows($r2);
													
					if ($n2 == 0){	
						
						echo "El Codigo de Anotacion no es Correcto";
						exit;
								
					}else{
												
					  $f2 = pg_fetch_array($r2,0);
					  $detalle_anotacion = $codigo2;
					  $tipo_anotacion  = $f2['id_tipo'];
									
							// inserto el registro con los datos tomados
							$qry="INSERT INTO ANOTACION 
							(FECHA,OBSERVACION,RUT_ALUMNO,RUT_EMP,id_periodo, 		
								  sigla,codigo_tipo_anotacion,codigo_anotacion,rdb,tipo,tipo_conducta)";
						 
							$qry .="VALUES ('$fecha','$observacion','$alumno',			  
								   '$tipo_responsable','$periodo','$sigla', 
								   '$tipo_anotacion','$detalle_anotacion','$institucion','1',$tipo_conducta)";
										
							$result =pg_Exec($conn,$qry);
						  
									  if (!$result) {
  
											echo "Error al acceder a la BD.(33)";
											exit;
										
									   }else{
											 
											echo 1; // guardo correctamente.
										
										}
					 }
								
			   }
				
		  						
										
	break;


case 2:
    $qry="INSERT INTO ANOTACION (FECHA, OBSERVACION, RUT_ALUMNO, RUT_EMP, id_periodo,sigla, 
	codigo_tipo_anotacion,codigo_anotacion,rdb,tipo,tipo_conducta) VALUES ('$fecha','".trim($observacion)."','$alumno',
	'$tipo_responsable','$periodo','$sigla','$tipo_anotacion',   
	'$detalle_anotacion','$institucion','1',$tipo_conducta)";
	
    $result = @pg_Exec($conn,$qry) or die (pg_last_error($conn));
			
	if (!$result) {
		echo "Error al acceder a la BD.(333)<br>".$qry;
		exit;
		}else{
		  echo 1;
		  }

   break;


case 3:

if($institucion==1599){
 $qry0="select max(id_anotacion) from anotacion";
 $result0 =@pg_Exec($conn,$qry0);
 $id_anotacion=intval(pg_result($result0,0))+1;	
 
 
 
 $qry="INSERT INTO ANOTACION 
(ID_ANOTACION,TIPO,FECHA,OBSERVACION,HORA,RUT_ALUMNO,RUT_EMP,ID_PERIODO,TIPO_CONDUCTA,rdb,jornada,id_ramo) VALUES(".$id_anotacion.",".$tipo_anotacion.",'".$fecha."','".$observacion."','".$hora."',".$alumno.",
	".$tipo_responsable.",".$periodo.",".$tipo_conducta.",".$institucion.",".$jou.",".$ramo.")";
 
}
else{
$qry0="select max(id_anotacion) from anotacion";
 $result0 =@pg_Exec($conn,$qry0);
 $id_anotacion=intval(pg_result($result0,0))+1;		
	
 $qry="INSERT INTO ANOTACION 
(ID_ANOTACION,TIPO,FECHA,OBSERVACION,HORA,RUT_ALUMNO,RUT_EMP,ID_PERIODO,TIPO_CONDUCTA,rdb,jornada,id_ramo) VALUES(".$id_anotacion.",".$tipo_anotacion.",'".$fecha."','".$observacion."','".$hora."',".$alumno.",".$tipo_responsable.",".$periodo.",".$tipo_conducta.",".$institucion.",".$jou.",".$ramo.")";
}
		//echo $qry;
		
		 $result =@pg_Exec($conn,$qry);
		 
		 if (!$result) {
		   echo "Error al acceder a la BD. 3 ".$qry."";
		   $evento = 0;
		   exit;
		 }else{ 
		   echo 1;
		   $evento = 2;

		 } 
		 
   break;

   
   } // fin switch
   
   

 	
	if($institucion==14703){/*
 		
 	   $sql = "SELECT * FROM ano_escolar WHERE id_ano = ".$ano."";
	   $ano_result = pg_Exec($conn,$sql) or die ( pg_last_error($conn)."INICIO 3");
	   $fila_ano_result  = pg_fetch_array( $ano_result ,0);
	   $nro_ano =  $fila_ano_result['nro_ano'];

      $sql = "SELECT aa1.id_anotacion,aa1.tipo_conducta as tipo_1,
 	    aa1.observacion as detalle_1,tii.tipo as tipo_2,de.detalle as detalle_2,aa1.fecha ,
		CAST(emp.ape_pat || ' ' || emp.ape_mat || ' ' || emp.nombre_emp as varchar ) as nombre_empleado,
		CAST(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_alumno,
		CAST(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno,
		CAST(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso,
		current_date as fecha_actual,    
		CAST(apo.rut_apo || '-' || apo.dig_rut as varchar) as rut_apoderado,
		CAST(apo.ape_pat || ' ' || apo.ape_mat || ' ' || apo.nombre_apo as varchar) as  nombre_apoderado,
		apo.email as mail_apo, 
		CAST(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as 
		nombre_profesorjefe
		,cu.id_curso
		FROM anotacion aa1
		INNER JOIN empleado emp on emp.rut_emp = aa1.rut_emp
		INNER JOIN alumno alu on alu.rut_alumno = aa1.rut_alumno 
		LEFT OUTER JOIN tiene2 tie on tie.rut_alumno = alu.rut_alumno 
		LEFT OUTER JOIN apoderado apo on apo.rut_apo = tie.rut_apo
		INNER JOIN matricula matri on matri.rut_alumno = alu.rut_alumno and EXTRACT(year from matri.fecha) = 
		$nro_ano
		INNER JOIN curso cu on cu.id_curso = matri.id_curso
		INNER JOIN  supervisa supe on supe.id_curso = cu.id_curso 
		INNER JOIN  empleado projefe on projefe.rut_emp = supe.rut_emp
		LEFT OUTER JOIN tipos_anotacion tii on cast(tii.id_tipo as integer) = cast(aa1.codigo_tipo_anotacion as integer)
		LEFT OUTER JOIN detalle_anotaciones de on de.codigo = aa1.codigo_anotacion
		WHERE 
		aa1.rdb = ".$institucion." 
		AND  
		EXTRACT(year from aa1.fecha) = $nro_ano 
		AND
		aa1.id_periodo = ".$periodo."
		AND
		aa1.rut_alumno = ".$alumno."
		ORDER BY aa1.fecha DESC limit 1";	
         
		 if($_PERFIL==0){
			 
			// echo"sql->".$sql;
			 }
		 
		 
        $r2 = @pg_Exec($conn,$sql) or die("Error 1".$sql);
		
	    $f11 = pg_fetch_array($r2,0);
	    $mail_apo = trim($f11['mail_apo']);  
		//  if(!$f11['mail_apo']!=""||$f11['mail_apo']!=NULL){
		    
			// Mensaje
			$mensaje = '<html>
						<head>
						<title>Anotacion del Dia</title>
						</head>
						<body>
						<h2>Listado de Anotaciones </h2>
						<p><strong>Rut Alumno :</strong>'.$f11['rut_alumno'].'</p>
						<p><strong>Nombre Alumno :</strong>'.$f11['nombre_alumno'].'</p>
						<p><strong>Curso : </strong>'.$f11['curso'].'</p>
						<p><strong>Profesor Jefe : </strong>'.$f11['nombre_profesorjefe'].'</p>
						<p><strong>Fecha Actual :</strong>'.$f11['fecha_actual'].'</p>
						<table border="1" width="100%" >
						<tr bgcolor="#FFFF00" >
						<th>Detalle Anotacion </th>
						<th>Profesor Responsable </th>
						<th>Fecha</th>
						</tr>';
						
						
								
						if($f11['tipo_1']==1){
						   $detalle = $f11['detalle_1'];
						}elseif($f11['tipo_2']==2){
						   $detalle = $f11['detalle_2'];
							}
								 
		   $mensaje .= '<tr>
						<td width="400">'.$detalle.'</td>
						<td>'.$f11['nombre_empleado'].'</td>
						<td>'.$f11['fecha'].'</td>
						</tr>';
			   
			$mensaje .= '</table>
			              </body>
			              </html>'; 

 
			 
			
			
			
			
 	//ENVIO POR CORREO
 	 		// echo $mail_apo;
    require_once("../../../../clases/mail/class.phpmailer.php");
	require_once("../../../../clases/mail/class.smtp.php");
	
	
	
	$mail = new PHPMailer();
	$mail->SetLanguage( 'es', '../../../../clases/mail/language/' );
   
    $mail->IsSMTP();
	$mail->Mailer = "smtp";
	$mail->SMTPSecure = "ssl";
	$mail->Helo = "www.colegiointeractivo.com";
	$mail->SMTPAuth = true;
	$mail->Host = "mail.colegiointeractivo.com";
	$mail->Port = 25;
	
	$mail->Username = "mensajeria@colegiointeractivo.com"; // SMTP username
	$mail->Password = "300600"; // SMTP password
	$mail->From = "mansajeria@colegiointeractivo.com";
	$mail->FromName = "Servidor Colegio Interactivo";
	$mail->Timeout=60;

    $mail->AddAddress(trim($mail_apo)); 
	$mail->Subject = "Informe de Anotaciones";
	$mail->AltBody = $mensaje;
	$mail->Body = $mensaje;
	
	$exito = $mail->Send();
	$mail->IsMail();    
	$intentos=1; 
						
		while ((!$exito) && ($intentos < 5)) {
				sleep(5);
				$exito = $mail->Send();
				$intentos=$intentos+1;	
			  }
						
				         if(!$exito){
							   echo "Correo No Enviado".$mail->ErrorInfo; 
						 }else{
							 echo  "Envio de Correo Correcto"; 
						   } 
				        
						$mail->ClearAddresses($email);
				         $mail->ClearAttachments();
	
		
	
	
	
              
             // }    

           
		   
		   */ }
              
               	
 		   
if($institucion==12086){
 //correo_notificacion_anotacion($alumno,$ano,$conn,$usuario,$evento,11);
  }
//REGISTRO DE HISTORIAL DE NAVEGACION
 //registrarnavegacion($_USUARIO,'ANOTACIONES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$curso ,$connection);

/******************/
 
/*if ($oculto=="1"){
	for ($iii=0; $iii < 10; $iii++){
	  $txtFechadesde       = $_POST["txtFechadesde".$iii];
	  $cmb_periodos        = $_POST['cmb_periodos'.$iii];
	  $sigla_subsector     = $_POST['sigla_subsector'.$iii];
	  $tipo_responsable    = $_POST['tipo_responsable'.$iii];
	  $tipo_anotacion      = $_POST['tipo_anotacion'.$iii];
	  $detalle_anotaciones = $_POST['detalle_anotaciones'.$iii];
	  $observaciones       = $_POST['observaciones'.$iii];	
		if ($detalle_anotaciones!="0"){
				$qry="INSERT INTO ANOTACION1 		
				(FECHA,OBSERVACION,RUT_ALUMNO,RUT_EMP,id_periodo,sigla,    
				codigo_tipo_anotacion, codigo_anotacion, rdb) VALUES ('".$txtFechadesde."',
				'".trim($observaciones)."','".trim($rut)."','".trim($tipo_responsable)."','" .
				$cmb_periodos."',
				'".$sigla_subsector."','".$tipo_anotacion."','".$detalle_anotaciones."', '".$institucion
				."')";
					 $result =pg_Exec($conn,$qry);
				   }	  
		} // FIN FOR						
		} /// fin ingreso masivo	
if ($elimina==1){  
	$sql="delete from anotacion1 where id_anotacion=".$anotacion;
	$result =@pg_Exec($conn,$sql);
	if (!$result) {
	  error('<b> ERROR :</b>Error al acceder a la BD. (6)</B>'.$qry);
	  exit;
	  }
	}
*/	
  
  ?> 

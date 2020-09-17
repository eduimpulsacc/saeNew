<?
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); 
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");
require('../../../../../util/header.inc');
//include("../../../../clases/notificacionXcorreo.php");
//include("../../../../clases/funcion_registro_navegacion.php");

    $institucion	=$_INSTIT;
	$institucion = $_POST['institucion'];
    $ano = $_POST['ano'];
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
	}else{ $tipo_responsable = "NULL"; }
		
	$periodo = $_POST['periodo'];
	$fecha = $_POST['fecha'];
	
	if($nombrebase=="coi_antofagasta"){ 
		   $fecha = fEs2En233($fecha); 
		}
		
		if($nombrebase=="coi_final"){
		   $fecha = fEs2En222($fecha); 
		} 
		
		if($nombrebase=="coi_final_vina"){
		   $fecha = fEs2En22445($fecha); 
		} 
	//echo $fecha;
	
	$observacion = $_POST['observacion'];
	$tipo_anotacion = $_POST['tipo_anotacion'];
    $detalle_anotacion = $_POST['detalle_anotacion'];
	
	if ($_POST['horaatraso'] != ""){
	$hora = $_POST['horaatraso'];
	}else{ $hora = "NULL"; } 
	
	if($_POST['tipo_conducta'] != ""){	
	$tipo_conducta = $_POST['tipo_conducta']; 
	}else{ $tipo_conducta = "NULL";	}


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
								  sigla,codigo_tipo_anotacion,codigo_anotacion,rdb)";
						 
							$qry .="VALUES ('$fecha','$observacion','$alumno',			  
								   '$tipo_responsable','$periodo','$sigla', 
								   '$tipo_anotacion','$detalle_anotacion','$institucion')";
										
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
	codigo_tipo_anotacion,codigo_anotacion,rdb) VALUES ('$fecha','$observacion','$alumno',
	'$tipo_responsable','$periodo','$sigla','$tipo_anotacion',   
	'$detalle_anotacion','$institucion')";
	
    $result = @pg_Exec($conn,$qry);
			
	if (!$result) {
		echo "Error al acceder a la BD.(333)<br>".$qry;
		exit;
		}else{
		  echo 1;
		  }

   break;


case 3:
	
$qry="INSERT INTO ANOTACION 
(TIPO,FECHA,OBSERVACION,HORA,RUT_ALUMNO,RUT_EMP,ID_PERIODO,TIPO_CONDUCTA,rdb)	VALUES(".$tipo_anotacion.",'".$fecha."','".$observacion."',".$hora.",'".$alumno."',
	'".$tipo_responsable."',".$periodo.",".$tipo_conducta.",'".$institucion."')";
		 $result =@pg_Exec($conn,$qry);
		 
		 if (!$result) {
		   echo "Error al acceder a la BD. (".$qry.")";
		   $evento = 0;
		   exit;
		 }else{ 
		   echo 1;
		   $evento = 2;

		 } 
		 
   break;

   
   } // fin switch



 	
 	if($institucion==12086){

 	 		/*ENVIO POR CORREO*/
 	 		   
        				require_once("../../../../clases/mail/class.phpmailer.php");
			
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

					    $mail->AddAddress("pcardenas@colegiointeractivo.com,bvargas@colegiointeractivo.com,erojas@colegiointeractivo.com,pcgaray@gmail.com"); 

						$mail->Subject = "Informe de Anotaciones";
												
						$mail->AltBody = $mensaje;
						$mail->Body= $mensaje;
												
						$exito = $mail->Send();
						$mail->IsMail();  
					    $intentos=1; 
						
						while ((!$exito) && ($intentos < 5)) {
							sleep(5);
								$exito = $mail->Send();
								$intentos=$intentos+1;	
							  }
						
				         if(!$exito){
							echo "Correo No Enviado <br/>"; 
						 }else{
							 // Envio de Correo Correcto 
						   } 
				        
						 $mail->ClearAddresses();
				         $mail->ClearAttachments();
                          
               /*FIN*/
              
            
            }
              
               	
 		   
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
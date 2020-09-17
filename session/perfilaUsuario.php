<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
 
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">

<div id = "estado_email"></div>
<script>


function checkemail(mail)
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.email1.value))
  {
    return (true)
  }
    return (false)
}
    


  function emailState(id_usuario,estado_email){
      var parametros="funcion=1&id="+id_usuario+"&estado_email="+estado_email;
      //alert(parametros);

      $.ajax({
        url:'estadoEmail/estadoEmail.php',
        data:parametros,
        type:'POST',
        success:function(data){
          $("#estado_email").html(data);
          $( "#estado_email" ).dialog(
          {
     closeOnEscape: false,
     modal:true,
     resizable: false,
    height: 450,
      width: 850,
    
      buttons: {
           "Guardar": function(){
            var var1 = $('#email1').val();
            var var2 = $('#email2').val();
            if(var1 !== var2) {
            alert("Los correos no son iguales");
                             }
            else if (var1.length == 0 || var2.length == 0 ) {
            alert("Debe completar los campos");
                                      }
                                      
            else if(!checkemail(var1) || !checkemail(var2)) {
                                      
            alert("Debe ingresar un email valido");
            }
                                      else {
                                      alert("Se le ha enviado un link para confirmar su email. No olvide revisar su carpeta spam")
                                      sendMail(id_usuario,var1);
                                      //mandar el correo
                                      //actualizar los estado
                                      
                                      window.location = 'listarPerfiles.php';
                                      
                                       $(this).dialog("close");
                    }
          
                                      
        },
        "Cerrar": function(){
          $(this).dialog("close");
                                      
        }
                                      
      }
    }
          ).css("font-size", "12px");
            }
        })
   
  }
function sendMail(id_usuario, email) {
    
    //Get the unique user ID of the user that has just registered.

//Create a "unique" token.
//$token = bin2hex(openssl_random_pseudo_bytes(16));

//Construct the URL.
//$url = "http://34.194.110.89/sae3.0/session/verify.php?t=$token&user=$userId";

//Build the HTML for the link.
//$link = '<a href="' . $url . '">' . $url . '</a>';

//Send the email containing the $link above.
    
//    $rs_getbdd = $ob_mail->getBaseDatos($connection);
//
//        for($i=0; $i<pg_numrows($rs_getbdd); $i++) {
//
//            $filabdd = pg_fetch_array($rs_getbdd,$i);
//            $name = $filabdd["dbname"];
//             $host = $filabdd["host"];
//             $port = $filabdd["port"];
//             $user = $filabdd["user"];
//             $password = $filabdd["password"];
//
//            $conn=pg_connect("dbname=$name host=$host port=$port user=$user password=$password");
//
//            if(!$conn){
//                echo "Error de conexion $name.\n";
//            }
//            else {
//     //$rs_guarda = $ob_reporte->guardaRepo($conn,$nombre_reporte,$ruta_reporte,$estado,$destacado,$apoderado,$ubicacion,$max,$descripcion_reporte,$url_impresion);
//    // if($rs_guarda){
//        // echo "\nguardo en ".$name ;}
//
//                $query= "SELECT id_base from usuario where id = "$id_usuario.;
//
//            }
//
        //}
    var parametros="funcion=2&id="+id_usuario+"&email="+email;
    $.ajax({
          url:'estadoEmail/estadoEmail.php',
          data:parametros,
          type:'POST',
          success:function(data){
        
           
           if(data == 0) {
           alert("No se actualizaron los datos");
           emailState(id_usuario,0);
           }
           else if(data == 1) {
           emailState(id_usuario,1);
           

           }
           

              }
          })
     
    }
    
    
    
    

  </script>
<? session_start();

	$nombreusuario=$_NOMBREUSUARIO;
   $usuario = $_USUARIO;
	

	
   function error($error) {
	 echo "<html><title>ERROR</title></head>";
	 echo "<body><center>";
	 echo $error;
	 echo "</center></body></html>";
	}
	
	$conn=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j");
	
	if (!$conn){
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
	  exit;
	}
	
    /*VEL*/
/************************ ELIMINACION DE CODIGO 22-06-2013**********************/
/*	$sql = "select * from cliente_prueba where rut_emp = $nombreusuario";
	$result = @pg_Exec($conn,$sql);	

    if(@pg_numrows($result)==1){
		$fila_prueba = @pg_fetch_array($result,0);
		if($fila_prueba['rut_emp'] == $nombreusuario){	
			$fecha_act = date("Y"."-"."m"."-"."d");
			if(($fila_prueba['primer_ingreso'] > $fecha_act) OR ($fila_prueba['ultimo_ingreso'] < $fecha_act)){ ?>
				<script>alert("El Periodo de Validez ha Caducado")</script>
				<script>window.location = 'http://www.colegiointeractivo.com/'</script>							
			<? }else{
				$hora = date("H:i:s");
				$sql2 = "UPDATE cliente_prueba SET ultima_coneccion = '$fecha_act', hora = '$hora' WHERE rut_emp = '$nombreusuario'";
				$result2 = @pg_Exec($conn,$sql2);				
			}
		}	
	}*/
/***********************************************************************/
	/*FIN-VEL*/		

	$_POSP=0;
	session_register('_POSP');
	
	$_MDINAMICO=0;
	session_register('_MDINAMICO');
   
	if ($_USUARIO==1){// SI ID_USUARIO=1,36 (ADMINISTRADOR GRAL COE)
		
		$_PERFIL=0;
		session_register('_PERFIL');
		
		$_ID_BASE=1;
		session_register('_ID_BASE');
		
		//Nombre de quien inici� la session
		$_USUARIOENSESION="Administrador General COI";
		session_register('_USUARIOENSESION');
		
		$_URLBASE="../admin/institucion/listarInstituciones.php?modo=ini&pag=1";
		session_register('_URLBASE');
		
		echo "<HTML><HEAD><script>
		window.location = '../index.php?modo=ini&pag=1'</script></HEAD><BODY></BODY></HTML>";
		
		}

	$num_result = 0;

	$qry="SELECT 
	usuario.id_usuario, 
	perfil.url, 
	accede.rdb, 
	accede.id_perfil, 
	accede.estado,
	accede.id_base,  
	institucion.clienteid,
	institucion.convenioid,
	institucion.token,
    usuario.estado_email  
	FROM usuario INNER JOIN accede ON usuario.id_usuario = accede.id_usuario 
	INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil 
	INNER JOIN institucion ON institucion.rdb=accede.rdb
	WHERE usuario.nombre_usuario = '".$nombreusuario."' AND accede.estado=1";
	
	
	
	$result = pg_Exec($conn,$qry) or die ("Error".pg_last_error($conn));

	$num_result = pg_num_rows($result);


	if (!$result){

		error('<b>ERROR :</b>No se puede acceder a la base de datos.1');

	}else{
		
		if(pg_num_rows($result)==1){//UN SOLO PERFIL HABILITADO

			$fila = @pg_fetch_array($result,0);	 

			if (!$fila){

				error('<B> ERROR :</b>Error al acceder a la BD. 3</B>');

			}else{

				$_INSTIT=$fila["rdb"];
				session_register('_INSTIT');
				//require('../util/header.inc');

				$_URLBASE=$fila["url"];
				session_register('_URLBASE');

				$_ID_BASE=$fila["id_base"];
				session_register('_ID_BASE');
				
				$_PERFIL=$fila["id_perfil"];
				session_register('_PERFIL');
				//$pid = pg_get_pid($conn);
				
				$_CLIENTEID = $fila['clienteid'];
				session_register('_CLIENTEID');
				
				$_CONVENIOID = $fila['convenioid'];
				session_register('_CONVENIOID');
				
				$_TOKEN = $fila['token'];
				session_register('_TOKEN');
				
				$estado_email2 = $fila["estado_email"];
				
				$_FRMMODO="mostrar";
				



				if($_PERFIL==16){ //ALUMNO
				
					/*//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					$qry="SELECT * FROM DATO_USUARIO WHERE RUT_USUARIO=".$nombreusuario;
					//$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$nombreusuario;
					$result = @pg_Exec($conn,$qry);

					if(!$result){
						
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
						
					}else{
					
						$fila = pg_fetch_array($result,0);	
					
						$_ALUMNO=$fila["rut_alumno"];
						session_register('_ALUMNO');
						
						//Nombre de quien inici� la session
						$nombrealumno = $fila['nombre_alu'];
						$nombrealumno.= $fila['ape_pat'];
						$nombrealumno.= $fila['ape_mat']; 
						
		                $_USUARIOENSESION=$nombrealumno;
		                session_register('_USUARIOENSESION');
					};

	
				 $qry="SELECT m.id_ano,m.id_curso 
				 FROM matricula as m 
				 INNER JOIN ano_escolar as a on m.id_ano=a.id_ano 
				 WHERE RDB=".$_INSTIT." 
				 AND RUT_ALUMNO=".$_ALUMNO." 
				 ORDER BY a.nro_ano DESC LIMIT 1";
				 $result = @pg_Exec($conn,$qry) or die(pg_last_error($conn));
					
					if (!$result){
						
						error('<b>ERROR :</b>No se puede acceder a la base de datos.4');
					
					}else{
					
						$fila_mat = pg_fetch_array($result,0);	
						$_ANO=$fila_mat["id_ano"];
						session_register('_ANO');

						$_CURSO=$fila_mat["id_curso"];
						session_register('_CURSO');
					
					};
					
					$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);	
					 
					$_TIPOREGIMEN=$fila["tipo_regimen"];
					session_register('_TIPOREGIMEN');
					
					if ($_INSTIT==25478 || $_INSTIT==24977){ 
						
						echo "<HTML><HEAD><script>
						window.location = '../fichas/fichaAlumno.php'
						</script></HEAD><BODY></BODY></HTML>";
						
						exit;
						
					}else{ 
					    
						echo "<HTML><HEAD><script>window.location = 
						'../index.php?institucion=$_INSTIT'</script>
						</HEAD><BODY></BODY></HTML>";
						
						exit;
						
					} */
						//$_ALUMNO=$fila["nombre_usuario"];
			$_ALUMNO=$_NOMBREUSUARIO;
			session_register('_ALUMNO');
		//};
		//SELECCIONA EL ULTIMO AÑO EN QUE ESTA MATRICULADO
		/*$qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO='".$_ALUMNO."' ORDER BY ID_ANO DESC";
		$result = @pg_Exec($conn,$qry);
		if (!$result){
			error('<b>ERROR :</b>No se puede acceder a la base de datos.4'.$qry);
		}else{
			$fila = @pg_fetch_array($result,0);	
			$_ANO=$fila["id_ano"];
			session_register('_ANO');

			$_CURSO=$fila["id_curso"];
			session_register('_CURSO');
			
		};
		if($_NOMBREUSUARIO==19327400) {
			echo pg_dbname($conn);
			exit;
		}*/
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	
		
		//ver si tengo acceso a biblioteca
		
		
		if($fila['biblioteca']==13){
			$_BBL=$fila["biblioteca"];
			session_register('_BBL');
		}
		if($fila['edugestor']==14){
			$_EDUG=$fila["edugestor"];
			session_register('_EDUG');
		}	


		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');
		if($_INSTIT==14804){
			echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
		}else{
			echo "<HTML><HEAD><script>window.location = '../fichas/fichaAlumno.php'</script></HEAD><BODY></BODY></HTML>";
		}
		exit;

				};//FIN PERFIL ALUMNO



				if($_PERFIL==15){	//APODERADO 
				
					//DETERMINAR EL APODERADO.
					$qry="SELECT * FROM dato_usuario WHERE rut_usuario=".trim($nombreusuario);
					//$qry="SELECT * FROM APODERADO WHERE RUT_APO=".trim($nombreusuario);
					$result = @pg_Exec($conn,$qry) or die("SELECT FALLO:".$qry);
					
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.34');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_APODERADO=$fila["rut_apo"];
						session_register('_APODERADO');
						
				 
						//Nombre de quien inici� la session
						$nombreapoderado = $fila["nombre_apo"];
						$nombreapoderado.= $fila["ape_pat"];
						$nombreapoderado.= $fila["ape_mat"];
		                $_USUARIOENSESION=$nombreapoderado;
		                session_register('_USUARIOENSESION');
					};
					// PASAR A LISTAR LOS ALUMNOS DE LOS QUE ES APODERADO
			
			/*echo "<HTML><HEAD><script>window.location = 'listarPupilos.php'</script></HEAD><BODY></BODY></HTML>";*/
			
			if($estado_email2==2) {
               echo "<HTML><HEAD><script>window.location = 'listarPupilos.php'</script></HEAD><BODY></BODY></HTML>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }
			
			
			exit;
					
			};//FIN PERFIL APODERADO


				
			if($_PERFIL==34){	//RECAUDACION
					
			$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
					
				$rs_ano = @pg_exec($conn,$sql);
				$_ANO=@pg_result($rs_ano,0);
					
				session_register('_ANO');
					
				$_INSTIT;
				$_PERFIL;
					
				$_IPDB = pg_host($conn);
				$_DBNAME = pg_dbname($conn);
					
				session_register('_IPDB');
				session_register('_DBNAME');
					
				/*echo "<script>window.location = '../reca/index.php'</script>";*/
				
				if($estado_email2==2) {
               echo  "<script>window.location = '../reca/index.php'</script>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }
					
				exit;
					
			 }; //Reca
			 
			 
			 if($_PERFIL==56){	//remuneraciones
					
			$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
					
				$rs_ano = @pg_exec($conn,$sql);
				$_ANO=@pg_result($rs_ano,0);
					
				session_register('_ANO');
					
				$_INSTIT;
				$_PERFIL;
					
				$_IPDB = pg_host($conn);
				$_DBNAME = pg_dbname($conn);
					
				session_register('_IPDB');
				session_register('_DBNAME');
					
				/*echo "<script>window.location = '../sueldos/index.php'</script>";*/
				
				if($estado_email2==2) {
              echo "<script>window.location = '../sueldos/index.php'</script>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }
					
				exit;
					
			 }; //remuneraciones
            
			
			// EVALUACION DOCENTE
			if($_PERFIL==40 or $_PERFIL==41 or $_PERFIL==42 or $_PERFIL==43 or $_PERFIL==45){

				$_SESSION['_IPDB'] = pg_host($conn);
				$_SESSION['_DBNAME'] = pg_dbname($conn);
				
		  /*  echo "<HTML><HEAD><script>window.location = '../evados/index.php'</script></HEAD>	<BODY></BODY></HTML>";*/
		  
		  if($estado_email2==2) {
            echo "<HTML><HEAD><script>window.location = '../evados/index.php'</script></HEAD>	<BODY></BODY></HTML>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }
		
			exit;
				
				
			}; // EVADOS
			
			if($_PERFIL==47){
				echo  "llego";
				exit;	
			}
			
			
			if($_PERFIL==26){
				$sql="SELECT num_corp FROM corp_instit WHERE rdb=".$_INSTTI;
				$rs_corporacion = pg_exec($conn,$sql);
				$fila = pg_fetch_array($rs_corporacion,0);
				$_CORPORACION = $fila['num_corp'];
						
				session_register('_CORPORACION');
				
			/*	echo "<script>window.location = 'seteaUsuario.php?institucion=".$_INSTIT."&perfil=".$_PERFIL."&caso=1&id_base=".$_ID_BASE."'</script>";*/
			
			 if($estado_email2==2) {
           echo "<script>window.location = 'seteaUsuario.php?institucion=".$_INSTIT."&perfil=".$_PERFIL."&caso=1&id_base=".$_ID_BASE."'</script>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }

			}
			
			
				
			$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
			$result = @pg_Exec($conn,$qry);

					
			if (!$result){
		
				error('<b>ERROR :</b>No se puede acceder a la base de datos.9');
					
			}else{
					
						$fila = @pg_fetch_array($result,0);	
						
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						
						if (!$result){
					    
						  //error('<b>ERROR: No pude acceder a la base de datos 10</b>');
						
						}else{
						   
						   $fila = @pg_fetch_array($result,0);
						   
						   $nombrecompleto = $fila["nombre_emp"];
						   $nombrecompleto.= $fila["ape_pat"];
						   $nombrecompleto.= $fila["ape_mat"];
						   $_USUARIOENSESION=$nombrecompleto;
		                   session_register('_USUARIOENSESION');
						};
				    
					
					};
		
		
		if($_PERFIL==0){
		echo "<script>window.location = '../index.php'</script>";
		}else{
		
		if($estado_email2==2) {
               echo "<script>window.location = '../index.php'</script>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }	
		}

		exit;
	
			
				
	}
			
			
		}else{//MAS DE UN PERFIL
		      
			
			$fila = @pg_fetch_array($result,0);	

			if (!$fila){

				error('<B> ERROR :</b>Error al acceder a la BD. 4</B>');

			}else{
				  
			  
			  	$_INSTIT=$fila["rdb"];
				session_register('_INSTIT');
				//require('../util/header.inc');

				$_URLBASE=$fila["url"];
				session_register('_URLBASE');

				$_ID_BASE=$fila["id_base"];
				session_register('_ID_BASE');
				
				$_PERFIL=$fila["id_perfil"];
				session_register('_PERFIL');
				//$pid = pg_get_pid($conn);
				
				$estado_email = $fila["estado_email"];
				
				$_FRMMODO="mostrar";
				
			  // SESSION PARA OCULTAR EL MENU SUPERIOR
			  $_OCULTAMENUSUPERIOR=1;
			  session_register('_OCULTAMENUSUPERIOR');
		        // NUEVO CODIGO INGRESADO
				
					$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$_USUARIO;
					$result = @pg_Exec($conn,$qry);

					
					if (!$result){
						
						error('<b>ERROR :</b>No se puede acceder a la base de datos.14');
					
					}else{
						
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						 $estado_email2 = $fila["estado_email"];
							
						## buscamos el nombre en la tabla instituci�n
						$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$_USUARIO;
						$result = @pg_Exec($conn,$qry);
						
						if (!$result){
							
						    error('<b>ERROR: No pude acceder a la base de datos 15</b>');
							
					    }else{
						    
							$fila = @pg_fetch_array($result,0);
						    
							
							
							$rdbaux = $fila["rdb"];
				            
						    $_SESSION['_INSTIT']=$fila["rdb"]; // IDENTIFICAMOS A QUE RDB PERTENECE
							
							$ip_users = $_SERVER[REMOTE_ADDR];
							
						 	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".trim($_EMPLEADO);
							
							//$result = @pg_Exec($conn,$qry);
							
							if (!$result){
						       error('<b>ERROR: No pude acceder a la base de datos 16</b>');
					        }else{
							
							   $fila = @pg_fetch_array($result,0);
							   $nombrecompleto = $fila["nombre_emp"];
							   $nombrecompleto.= $fila["ape_pat"];
							   $nombrecompleto.= $fila["ape_mat"];
													
						       $_USUARIOENSESION=$nombrecompleto;
		                       session_register('_USUARIOENSESION');
							   
							};
					    };
					}	
				
				
				/*if($_EMPLEADO==17189248){
					echo "estado->".$estado_email2;
					 echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
					}
				else{
				echo "<script>window.location = 'listarPerfiles.php'</script>";
				}
				exit;*/
				if($estado_email2==2) {
                echo "<script>window.location = 'listarPerfiles.php'</script>";

                //exit;
                }
                
                else {
                    echo "<script>emailState('".$_USUARIO."',".$estado_email2.")</script>";
                }
				
				
			}
		}
		
	}

pg_close($conn);
pg_close($connection);
?>
<div id = "estado_email"></div>


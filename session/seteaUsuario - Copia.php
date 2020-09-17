<?php
   session_start();



   function error($error) {
	 echo "<html><title>ERROR</title></head>";
	 echo "<body><center>";
	 echo $error;
	 echo "</center></body></html>";
	}
	
	$conn=@pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j");
	//$conn=pg_connect("dbname=coi_usuario host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die(pg_last_error($conn));
	
	if (!$conn){
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.(10)');
	  exit;
	}
	
	//se cambia la el valor por si esta conectando a un 
	// colegio de otra base.
	$_SESSION['_ID_BASE'] = $_GET['id_base'];

	$_SESSION['_PERFIL'] = $_GET['perfil'];
			 
    $_SESSION['_INSTIT']=$_GET['institucion'];
	
	$_SESSION['VERIFICASESSION'] = $_GET['institucion'];	 	
	
	$num_corp = $_GET['corp'];
	
	$usuario	=$_USUARIO;


	//$_INSTIT= base64_decode($institucion);
	//session_register('_INSTIT');
 	//$_VERIFICASESSION = base64_decode($institucion);
	//session_register ('_VERIFICASESSION');
	//$_PERFIL = base64_decode($perfil);
	
	//return;


	
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT;
	$result = @pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	
	$_TIPOREGIMEN=$fila["tipo_regimen"];
	session_register('_TIPOREGIMEN');

	$qry="SELECT * FROM PERFIL WHERE ID_PERFIL=".$_PERFIL;
	$result = @pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$_URLBASE=$fila["url"];
	session_register('_URLBASE');



	if($_PERFIL==26){	
	//Sostenedor Corporativo
		 
		 $qry_corp = "select distinct(corp_instit.num_corp), corporacion.nombre_corp from accede, corp_instit, corporacion, usuario where usuario.nombre_usuario='".$_NOMBREUSUARIO."'
	
	and accede.rdb = corp_instit.rdb 
	and corp_instit.num_corp = corporacion.num_corp 
	and accede.id_usuario=usuario.id_usuario";
			
			
			$res_corp = @pg_Exec($conn,$qry_corp) or die("select fallosss :".$qry_corp);
			
			$fila_corp = @pg_fetch_array($res_corp,0);
			
			$_CORPORACION = $fila_corp['num_corp'];	
			session_register('_CORPORACION');
			
			$corpx = $fila_corp['num_corp'];
					
			$_NOMCORP = $fila_corp['nombre_corp'];
			session_register('_NOMCORP');
			
			$_USUARIOENSESION="Sostenedor Corporativo";
			session_register('_USUARIOENSESION');
			
			$_FRMMODO="mostrar";
			session_register('_FRMMODO');
			
			$_MDINAMICO = 1;
			//echo $_MDINAMICO;
	
	//return;
	
	echo "<HTML><HEAD><script>window.location = '../admin/corporacion/seteaCorporacion.php'</script></HEAD><BODY></BODY></HTML>";
	exit;
	
		};//FIN PERFIL
		
	
	
if($_PERFIL==44){	
//Sostenedor Corporativo
		 
	$qry_corp = "SELECT
	usuario.id_usuario,usuario.nombre_usuario,
	perfil.id_perfil,perfil.nombre_perfil,
	accede.estado,institucion.rdb,nacional.id_nacional,
	nacional.nombre as nombre_nacional
	FROM usuario
	INNER JOIN accede ON accede.id_usuario = usuario.id_usuario and accede.estado=1  
	INNER JOIN perfil ON perfil.id_perfil = accede.id_perfil and perfil.id_perfil = ".$_GET['perfil']."
	LEFT JOIN institucion ON accede.rdb = institucion.rdb 
	LEFT OUTER JOIN corp_instit ON corp_instit.rdb = accede.rdb
	LEFT OUTER JOIN nacional_corp on nacional_corp.num_corp = corp_instit.num_corp
	LEFT OUTER JOIN nacional on nacional.id_nacional = nacional_corp.id_nacional
	WHERE usuario.nombre_usuario = '".$_NOMBREUSUARIO."' ";
			$res_corp = @pg_Exec($conn,$qry_corp) or die("select fallo :".$qry_corp);
			$fila_corp = @pg_fetch_array($res_corp,0);
			
			$_CORPORACION = $fila_corp['id_nacional'];	
			session_register('_CORPORACION');
			
			$corpx = $fila_corp['id_nacional'];
					
			$_NOMCORP = $fila_corp['nombre_nacional'];
			session_register('_NOMCORP');
			
			$_USUARIOENSESION="Sostenedor Nacional";
			session_register('_USUARIOENSESION');
			
			$_FRMMODO="mostrar";
			session_register('_FRMMODO');
			
			$_MDINAMICO = 1;
			//echo $_MDINAMICO;
	//return;
echo "<HTML><HEAD><script>window.location = '../admin/nacional/seteaNacional.php'</script></HEAD><BODY></BODY></HTML>";
exit;
	
		};//FIN PERFIL


		
		
				
	if($_PERFIL==16){	//ALUMNO
		//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.

		/*$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
		$result = @pg_Exec($conn,$qry);

		if (!$result){
			error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 31'.$qry);
		}else{
			$fila = @pg_fetch_array($result,0);	*/
			//$_ALUMNO=$fila["nombre_usuario"];
			$_ALUMNO=$_NOMBREUSUARIO;
			session_register('_ALUMNO');
		//};
		//SELECCIONA EL ULTIMO A�O EN QUE ESTA MATRICULADO
		 $qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO='".$_ALUMNO."' ORDER BY ID_ANO DESC";
		
	
		$result = @pg_Exec($conn,$qry);
		if (!$result){
			//error('<b>ERROR :</b>No se puede acceder a la base de datos.4'.$qry);
		}else{
			$fila = @pg_fetch_array($result,0);	
			$_ANO=$fila["id_ano"];
			session_register('_ANO');

			$_CURSO=$fila["id_curso"];
			session_register('_CURSO');
			
		};
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	

		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');

		echo "<HTML><HEAD><script>window.location = '../fichas/fichaAlumno.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL ALUMNO

	
				if($_PERFIL==23){	//ADMiNISTRACION INTERNA
				    //Nombre de quien inici� la session
		            $_USUARIOENSESION="Administraci�n Interna";
		            session_register('_USUARIOENSESION');
				   
				   
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../fichas/administracion/index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				if($_PERFIL==24){	//DESARROLLO
				    //Nombre de quien inici� la session
		            $_USUARIOENSESION="Desarrollo";
		            session_register('_USUARIOENSESION');
					 					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
				echo "<HTML><HEAD><script>window.location = '../solicitud2/index5.php'</script></HEAD><BODY></BODY></HTML>";
					
					//echo "<HTML><HEAD><script>window.location = '../fichas/desarrollo/index.php'<//script></HEAD><BODY></BODY></HTML>"; LO QUE HABIA ANTES
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==16){	//ALUMNO
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$nombreusuario;
					$result = @pg_Exec($conn,$qry);
                     
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 90');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_ALUMNO=$fila["rut_alumno"];
						session_register('_ALUMNO');
						
						//Nombre de quien inici� la session
						$nombrealumno = $fila['nombre_alu'];
						$nombrealumno.= $fila['ape_pat'];
						$nombrealumno.= $fila['ape_mat']; 
						
		                $_USUARIOENSESION=$nombrealumno;
		                session_register('_USUARIOENSESION');
						
						
					};
					//SELECCIONA EL ULTIMO A�O EN QUE ESTA MATRICULADO
//					$qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." ORDER BY ID_ANO DESC";
					$qry="SELECT * FROM matricula as m INNER JOIN ano_escolar as a on m.id_ano=a.id_ano WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." ORDER BY a.nro_ano DESC";
					$result = @pg_Exec($conn,$qry);
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 111');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_ANO=$fila["id_ano"];
						session_register('_ANO');

						$_CURSO=$fila["id_curso"];
						session_register('_CURSO');
					};
					$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);	
					 
					$_TIPOREGIMEN=$fila["tipo_regimen"];
					session_register('_TIPOREGIMEN');
					
					if ($_INSTIT==24977 || $_INSTIT==25478){ 
						echo "<HTML><HEAD><script>window.location = '../fichas/fichaAlumno.php'</script></HEAD><BODY></BODY></HTML>";
						exit;
					} else { 
					    echo "<HTML><HEAD><script>window.location = '../index.php?institucion=$_INSTIT'</script></HEAD><BODY></BODY></HTML>";
						exit;
					
						/*echo "<HTML><HEAD><script>window.location = '../fichas/alumno/index.php?institucion=$_INSTIT'</script></HEAD><BODY></BODY></HTML>";
						exit;*/
						
					} 
				};//FIN PERFIL ALUMNO

				if($_PERFIL==15){	//APODERADO
					//DETERMINAR EL APODERADO.
					
					$qry="SELECT * FROM APODERADO WHERE RUT_APO='".trim($_NOMBREUSUARIO)."'";
					$result = @pg_Exec($conn,$qry);

					
					if (!$result){
						error('<br>');
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
					
					echo "<HTML><HEAD><script>window.location = 'listarPupilos.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
					
					
				};//FIN PERFIL APODERADO

			/*	if($_PERFIL==10){	//CENTRO DE PADRES
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
					//Nombre de quien inici� la session
		            $_USUARIOENSESION="Centro de Padres";
		            session_register('_USUARIOENSESION');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroPadres.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//*FIN PERFIL 

				if($_PERFIL==11){	//CENTRO DE ALUMNOS
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
					$_USUARIOENSESION="Centro de Alumnos";
		            session_register('_USUARIOENSESION');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroAlumnos.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==12){	//WEB SCOUT
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
					$_USUARIOENSESION="Web Scout";
		            session_register('_USUARIOENSESION');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/webScout.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==13){	//CENTRO PASTORAL
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
					$_USUARIOENSESION="Centro Pastoral";
		            session_register('_USUARIOENSESION');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroPastoral.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==18){	//EXALUMNOS
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					
					$_USUARIOENSESION="Ex-alumnos";
		            session_register('_USUARIOENSESION');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/exalumnos.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
*/
				if($_PERFIL==17 || $_PERFIL==8){	//DOCENTE
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					
					$qry_corp = "select distinct(corp_instit.num_corp), corporacion.nombre_corp from accede, corp_instit, corporacion, usuario where usuario.nombre_usuario='".$_NOMBREUSUARIO."'  and accede.rdb = corp_instit.rdb and corp_instit.num_corp = corporacion.num_corp and accede.id_usuario=usuario.id_usuario";
					$res_corp = @pg_Exec($conn,$qry_corp);
					$fila_corp = @pg_fetch_array($res_corp);
					$_CORPORACION = $fila_corp['num_corp'];	
					session_register('_CORPORACION');
					
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					$result = @pg_Exec($conn,$qry);

					if (!$result){

						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 221');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						## busco el nombre en la tabla empleado
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						$fila = @pg_fetch_array($result,0);
						$nombreprofesor = $fila["nombre_emp"];
						$nombreprofesor.= $fila["ape_pat"];
						$nombreprofesor.= $fila["ape_mat"];
																								
						$_USUARIOENSESION=$nombreprofesor;
		                session_register('_USUARIOENSESION');
								
					};
					
					$fecha = date('Y-m-d');
						
				$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						
						//$res_existe = @pg_Exec($conn,$sql_existe);
						
						//$arr= pg_fetch_array ($res_existe);	
				
				
										
						
						//if (@pg_num_rows($res_existe) == 0) {
						
						
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);

					/*echo "<HTML><HEAD><script>window.location = 'perfilDocente.php3'</script></HEAD><BODY></BODY></HTML>";*/
			/*		echo "<HTML><HEAD><script>window.location = '../fichas/docente/index.html'</script></HEAD><BODY></BODY></HTML>";*/
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				
				if($_PERFIL==28){	//AYUDANTE COMUNICACIONES
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					$result = @pg_Exec($conn,$qry);

					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 221');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						## busco el nombre en la tabla empleado
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						$fila = @pg_fetch_array($result,0);
						$nombreprofesor = $fila["nombre_emp"];
						$nombreprofesor.= $fila["ape_pat"];
						$nombreprofesor.= $fila["ape_mat"];
																								
						$_USUARIOENSESION=$nombreprofesor;
		                session_register('_USUARIOENSESION');
								
					};
					};//FIN PERFIL 
				
				
				if($_PERFIL==49){	//ASISENTE SOCIAL
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					$result = @pg_Exec($conn,$qry);

					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 221');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						## busco el nombre en la tabla empleado
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						$fila = @pg_fetch_array($result,0);
						$nombreprofesor = $fila["nombre_emp"];
						$nombreprofesor.= $fila["ape_pat"];
						$nombreprofesor.= $fila["ape_mat"];
																								
						$_USUARIOENSESION=$nombreprofesor;
		                session_register('_USUARIOENSESION');
								
					};
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==31){	//SECRETARIA
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					$result = @pg_Exec($conn,$qry);

					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 221');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						## busco el nombre en la tabla empleado
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						$fila = @pg_fetch_array($result,0);
						$nombreprofesor = $fila["nombre_emp"];
						$nombreprofesor.= $fila["ape_pat"];
						$nombreprofesor.= $fila["ape_mat"];
																								
						$_USUARIOENSESION=$nombreprofesor;
		                session_register('_USUARIOENSESION');
								
					};
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==32){	//INSPECTOR DE PATIO
					//DETERMINAR EL ALUMNO, A�O ESCOLAR Y CURSO.
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					$result = @pg_Exec($conn,$qry);

					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 221');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
						
						## busco el nombre en la tabla empleado
						$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_EMPLEADO;
						$result = @pg_Exec($conn,$qry);
						$fila = @pg_fetch_array($result,0);
						$nombreprofesor = $fila["nombre_emp"];
						$nombreprofesor.= $fila["ape_pat"];
						$nombreprofesor.= $fila["ape_mat"];
																								
						$_USUARIOENSESION=$nombreprofesor;
		                session_register('_USUARIOENSESION');
								
					};
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				
				
				

 if(($_PERFIL==2) or ($_PERFIL==23) or ($_PERFIL==24) or ($_PERFIL==25) or ($_PERFIL==26) or ($_PERFIL==30)){	  

 //DIRECTOR ACADEMICO
 ## busco el nombre en la tabla empleado
 $qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$_NOMBREUSUARIO;
 $result = @pg_Exec($conn,$qry);
 $fila = @pg_fetch_array($result,0);
 /*echo pg_dbname($conn);
   exit;*/
   																								
   $_USUARIOENSESION=$fila["nombre_emp"];
   session_register('_USUARIOENSESION');	
						
   $_EMPLEADO=$nombreusuario;
   session_register('_EMPLEADO');		
   $fecha = date('Y-m-d');
   
   $sql_existe = "SELECT * FROM estadistica 
   WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
	
						//$res_existe = @pg_Exec($conn,$sql_existe);
						
						//$arr= pg_fetch_array ($res_existe);	
						
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					
					
					/*echo "<HTML><HEAD><script>window.location = 'seteaAcademico.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";*/
					
					//return;
					
                    echo "<script>window.location = '../index.php'</script>";
					exit;
				};//FIN PERFIL 





				if($_PERFIL==14){	//ADMINISTRADOR WEB COLEGIO, PSICOPEDAGOGO
					//$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					
					
					$qry="SELECT * FROM USUARIO WHERE  nombre_usuario='".$_NOMBREUSUARIO."'";
					
					//return;
					
					$result = @pg_Exec($conn,$qry);
					
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 267');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');

						## buscamos el nombre en la tabla instituci�n
						$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$usuario;
						$result = @pg_Exec($conn,$qry);
						if (!$result){
						    error('<b>ERROR: No pude acceder a la base de datos. linea 498</b>');
					    }else{
						    $fila = @pg_fetch_array($result,0);
						    $rdbaux = $fila["rdb"];
							
							## buscamos el nombre en la tabla intituci�n
							$qry="SELECT * FROM INSTITUCION WHERE RDB=".$rdbaux;
							$result = @pg_Exec($conn,$qry);
							
							$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".trim($_EMPLEADO);
							$result = @pg_Exec($conn,$qry);
							
							if (!$result){
						       //error('<b>ERROR: No pude acceder a la base de datos.linea 511</b>');
					        }else{
							   $fila = @pg_fetch_array($result,0);
							   $nombrecompleto = $fila["nombre_emp"];
							   $nombrecompleto.= $fila["ape_pat"];
							   $nombrecompleto.= $fila["ape_mat"];
						       					
						       $_USUARIOENSESION=$nombrecompleto;
		                       session_register('_USUARIOENSESION');
							};
					    };
					};//FIN PERFIL 
					
					
					
					
					
					if(($_PERFIL==1) or ($_PERFIL==2) or ($_PERFIL==6) or ($_PERFIL==8) or ($_PERFIL==9) or ($_PERFIL==14) or ($_PERFIL==17) or ($_PERFIL==19) or ($_PERFIL==20) or ($_PERFIL==21) or ($_PERFIL==22) or ($_PERFIL==25) or ($_PERFIL==26) or ($_PERFIL==27) or ($_PERFIL==28)){	

						$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						//echo $sql_estad;
						//return;
						@pg_Exec($conn,$sql_estad);
						/*
						
						$_USUARIOENSESION=$fila["nombre_usuario"];
		                session_register('_USUARIOENSESION');	*/	   
					};
					echo "<script>window.location = '../index.php'</script>";
					exit;
				
				}
				
				if($_PERFIL==27){	//ADMINISTRATIVO WEB
					$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$result = @pg_Exec($conn,$qry);
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3 Linea 267');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
												
										
						## buscamos el nombre en la tabla instituci�n
						$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$usuario;
						$result = @pg_Exec($conn,$qry);
						if (!$result){
						    error('<b>ERROR: No pude acceder a la base de datos</b>');
					    }else{
						    $fila = @pg_fetch_array($result,0);
						    $rdbaux = $fila["rdb"];
							
							## buscamos el nombre en la tabla intituci�n
							$qry="SELECT * FROM INSTITUCION WHERE RDB=".$rdbaux;
							$result = @pg_Exec($conn,$qry);
							
							$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".trim($_EMPLEADO);
							$result = @pg_Exec($conn,$qry);
							
							if (!$result){
						       error('<b>ERROR: No pude acceder a la base de datos</b>');
					        }else{
							   $fila = @pg_fetch_array($result,0);
							   $nombrecompleto = $fila["nombre_emp"];
							   $nombrecompleto.= $fila["ape_pat"];
							   $nombrecompleto.= $fila["ape_mat"];
						       					
						       $_USUARIOENSESION=$nombrecompleto;
		                       session_register('_USUARIOENSESION');
							};
					    };
						$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL."  and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
						/*
						
						$_USUARIOENSESION=$fila["nombre_usuario"];
		                session_register('_USUARIOENSESION');	*/	   
					};
					echo "<script>window.location = '../index.php'</script>";
					
					exit;
					
				};//FIN PERFIL 			
				
				

			
				if($_PERFIL==1){	//DIRECTOR GENERAL
				    ## busco el nombre en la tabla empleado
					$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$usuario;
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
																								
					$_USUARIOENSESION=$fila["nombre_emp"];
		            session_register('_USUARIOENSESION');	
						
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					
					echo "<script>window.location = '../index.php'</script>";
				   ##  CAMBIOS REALIZADOS  echo "<script>window.location = '../menu/index.php3'	
					exit;
				};//FIN PERFIL 
				
				
				if($_PERFIL==51){	//SOPORTE TELEFONICO
				    ## busco el nombre en la tabla empleado
					/*$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$usuario;
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
																								
					$_USUARIOENSESION=$fila["nombre_emp"];
		            session_register('_USUARIOENSESION');	
						
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);*/
					
					echo "<script>window.location = '../soporte_fono/index.php'</script>";
				   ##  CAMBIOS REALIZADOS  echo "<script>window.location = '../menu/index.php3'	
					exit;
				};//FIN PERFIL 

				if($_PERFIL==6){	//ENFERMERIA
				    $qry="SELECT e.rut_emp, nombre_emp, ape_pat, ape_mat FROM usuario u, EMPLEADO e 
						WHERE u.id_usuario=".trim($usuario)."
						and e.RUT_EMP=u.nombre_usuario";
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
					$nombreusuario = $fila['rut_emp'];

					$_USUARIOENSESION=$fila["nombre_emp"];
					$_USUARIOENSESION .=$fila["ape_pat"];
					$_USUARIOENSESION .=$fila["ape_mat"];
	                session_register('_USUARIOENSESION');
				    $fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
				
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==29){	//DAE
				    $qry="SELECT e.rut_emp, nombre_emp, ape_pat, ape_mat FROM usuario u, EMPLEADO e 
						WHERE u.id_usuario=".trim($usuario)."
						and e.RUT_EMP=u.nombre_usuario";
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
					$nombreusuario = $fila['rut_emp'];

					$_USUARIOENSESION=$fila["nombre_emp"];
					$_USUARIOENSESION .=$fila["ape_pat"];
					$_USUARIOENSESION .=$fila["ape_mat"];
	                session_register('_USUARIOENSESION');
				    $fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
				
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==19 or $_PERFIL==22 or $_PERFIL==33 or $_PERFIL==35){	//INSPECTORR  , PSICOPEDAGOGO
				    $_USUARIOENSESION="Inspector";
		            session_register('_USUARIOENSESION');
					
					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>"; 
				/*	echo "<HTML><HEAD><script>window.location = '../admin/institucion/ano/listarAno.php3'</script></HEAD><BODY></BODY></HTML>"; */
					/*echo "<HTML><HEAD><script>window.location = '../fichas/inspector/index.php'</script></HEAD><BODY></BODY></HTML>";*/
					exit;
				};//FIN PERFIL 

				if($_PERFIL==20){	//ORIENTADOR
					$qry="SELECT e.rut_emp, nombre_emp, ape_pat, ape_mat FROM EMPLEADO e 
						WHERE e.RUT_EMP=$_NOMBREUSUARIO";

					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
					$nombreusuario = $fila['rut_emp'];

					$_USUARIOENSESION=$fila["nombre_emp"];
	                session_register('_USUARIOENSESION');	
						
					$_EMPLEADO=$nombreusuario;
					session_register('_EMPLEADO');		
					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);

					$_MENU=4;
					session_register('_MENU');
					
					$_CATEGORIA=2;
					session_register('_CATEGORIA');
					
					/*echo "<HTML><HEAD><script>window.location = '../fichas/orientador/index.php'</script></HEAD><BODY></BODY></HTML>";*/
					echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>"; 
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==21){	//PSICOLOGO
					$qry="SELECT e.rut_emp, nombre_emp, ape_pat, ape_mat FROM usuario u, EMPLEADO e 
						WHERE u.id_usuario=".trim($usuario)."
						and e.RUT_EMP=u.nombre_usuario";
					$result = @pg_Exec($conn,$qry);
					$fila = @pg_fetch_array($result,0);
					$nombreusuario = $fila['rut_emp'];

					$_USUARIOENSESION=$fila["nombre_emp"];
	                session_register('_USUARIOENSESION');	
						
					$_EMPLEADO=$nombreusuario;
					session_register('_EMPLEADO');		
					
					$_MENU =$menu;
						session_register('_MENU');
					$_CATEGORIA=$categoria;
						session_register('_CATEGORIA');
					$_ITEM =$item;
						session_register('_ITEM');
					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					$fecha = date('Y-m-d');
						$sql_existe = "SELECT * FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." and fecha = '$fecha' order by fecha ASC";
						$res_existe = @pg_Exec($conn,$sql_existe);
						$arr= pg_fetch_array ($res_existe);	
						//if (@pg_num_rows($res_existe) == 0) {
						if ($arr["fecha"] != $fecha) {	
							$sql_datos = "SELECT id_usuario, id_perfil, rdb FROM accede WHERE id_usuario=".$usuario." AND id_perfil = ".$_PERFIL;
							$res_datos = @pg_Exec($conn,$sql_datos);
							$arr_datos = @pg_fetch_array($res_datos);
							$sql_estad = "INSERT INTO estadistica (id_usuario, rdb, perfil, cant_conex,fecha) VALUES (".$arr_datos['id_usuario'].", ".$arr_datos['rdb'].", ".$arr_datos['id_perfil'].", 1,'".$fecha."')";
						} else {
							$sql_numero = "SELECT cant_conex FROM estadistica WHERE id_usuario = ".$usuario." AND perfil = ".$_PERFIL." AND fecha='".$fecha."'";
							$res_numero = @pg_Exec($conn,$sql_numero);
							$arr_numero = pg_fetch_array($res_numero);
							$entradas = $arr_numero['cant_conex']+1;
							$sql_estad = "UPDATE estadistica SET cant_conex = ".$entradas.", fecha='".$fecha."' WHERE id_usuario = ".$usuario;
						}
						@pg_Exec($conn,$sql_estad);
					$_MENU=4;
					session_register('_MENU');
					
					$_CATEGORIA=2;
					session_register('_CATEGORIA');
					echo "<HTML><HEAD><script>window.location = '../fichas/psicologo/index.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				if($_PERFIL==23){	//ADMiNISTRACION INTERNA
				    $_USUARIOENSESION="Administrador Interna";
		            session_register('_USUARIOENSESION');
					
					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../fichas/administracion/main.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				if($_PERFIL==24){	//DESARROLLO
				    $_USUARIOENSESION="Desarrollo - Perfil 24";
		            session_register('_USUARIOENSESION');
					
					
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../fichas/desarrollo/main.php'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
				
				if($_PERFIL==34){	//RECAUDACION
	
					//echo $_INSTIT;
					//echo $_PERFIL;
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
				
					echo "<HTML>
					<HEAD>
					<script>window.location = '../reca/index.php'</script>
					</HEAD>
					<BODY>
					</BODY>
					</HTML>";
					exit;
					
					};//FIN PERFIL 
					
					
			if($_PERFIL==40){	// EVALUACION DOCENTE

				$_IPDB = pg_host($conn);
				$_SESSION['_IPDB']=$_IPDB;
				
				$_DBNAME = pg_dbname($conn);
				$_SESSION['_DBNAME']=$_DBNAME;
			   
				echo "<HTML>
				<HEAD>
				<script>window.location = '../evados/index.php'</script>
				</HEAD>
				<BODY>
				</BODY>
				</HTML>";
				exit;
			
			};//FIN PERFIL 

			
			
			if($_PERFIL==41){	// EVALUACION DOCENTE

			/*	$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql);
				$_ANO=@pg_result($rs_ano,0);
				$_SESSION['_ANO'] = $_ANO; */
				
				$_IPDB = pg_host($conn);
				$_SESSION['_IPDB'] = $_IPDB;
				$_DBNAME = pg_dbname($conn);
				$_SESSION['_DBNAME'] = $_DBNAME;
		         
                //return;  				 
				 
				echo "<HTML>
				<HEAD>
				<script>window.location = '../evados/index.php'</script>
				</HEAD>
				<BODY>
				</BODY>
				</HTML>";
			
			};//FIN PERFIL 
			
			
			
			if($_PERFIL==42){	// EVALUACION DOCENTE

			/*	$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql);
				$_ANO=@pg_result($rs_ano,0);
				session_register('_ANO'); */

				$_IPDB = pg_host($conn);
				session_register('_IPDB');
				$_DBNAME = pg_dbname($conn);
				session_register('_DBNAME');
		
				echo "<HTML>
				<HEAD>
				<script>window.location = '../evados/index.php'</script>
				</HEAD>
				<BODY>
				</BODY>
				</HTML>";
				exit;
			
			};//FIN PERFIL 
			
			
			if($_PERFIL==43){	// EVALUACION DOCENTE

			/* 	$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql);
				$_ANO=@pg_result($rs_ano,0);
				session_register('_ANO'); */

				$_IPDB = pg_host($conn);
				session_register('_IPDB');
				$_DBNAME = pg_dbname($conn);
				session_register('_DBNAME');
		
				echo "<HTML>
				<HEAD>
				<script>window.location = '../evados/index.php'</script>
				</HEAD>
				<BODY>
				</BODY>
				</HTML>";
				exit;
			
			};//FIN PERFIL 
			
			
					  function quenacionalsoy($instit,$conn){
								
			            $sql = "SELECT
								nacional.id_nacional
								FROM nacional,nacional_corp,corporacion,corp_instit
								WHERE 
								nacional.id_nacional=nacional_corp.id_nacional AND
								nacional_corp.num_corp = corporacion.num_corp AND
								corporacion.num_corp = corp_instit.num_corp AND 
								corp_instit.rdb = $instit ; ";
							$rs = pg_exec($conn,$sql) or die(pg_last_error($conn));
							$id_nacional = @pg_result($rs,0);

							
							return  $id_nacional;
										
				     }
					 
			
			if($_PERFIL==45){	// EVALUACION DOCENTE
			
			   	$respuesta = quenacionalsoy($_INSTIT,$conn);
			   
		/*		$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql);
				
				$_ANO=@pg_result($rs_ano,0); */
				
				$_SESSION['_ANO'] = $_ANO;
				
				$_IPDB = pg_host($conn);
				$_SESSION['_IPDB'] = $_IPDB;
				$_DBNAME = pg_dbname($conn);
				$_SESSION['_DBNAME'] = $_DBNAME;
				
				//if($_NOMBREUSUARIO==9526014)return ;
		
		       	if($respuesta==1){
				  header('Location: ../evados/index.php');
			   	}else{
				  header('Location: ../evados_sae/index.php');
				}
			
			};//FIN PERFIL 
			
			if($_PERFIL==48){	// ADMINISTRADOR PME
			
			  // 	$respuesta = quenacionalsoy($_INSTIT,$conn);
			   
		/*		$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql);
				
				$_ANO=@pg_result($rs_ano,0); */
				
				$_SESSION['_ANO'] = $_ANO;
				
				$_IPDB = pg_host($conn);
				$_SESSION['_IPDB'] = $_IPDB;
				$_DBNAME = pg_dbname($conn);
				$_SESSION['_DBNAME'] = $_DBNAME;
				
				//if($_NOMBREUSUARIO==9526014)return ;
		
		       	
				  header('Location: ../PME/index.php');
				
			
			};//FIN PERFIL 
			
	
				if($_PERFIL==46){	// SISTEMA CEDE
			   
			    $sql = "SELECT * FROM institucion WHERE rdb=".$_INSTIT."  AND cede=7 ";
			    $rs_instit = @pg_exec($conn,$sql);
			    
				if(pg_num_rows($rs_instit)!=0){
					
			/*	$sql ="SELECT id_ano FROM ano_Escolar WHERE id_institucion=".$_INSTIT." AND situacion=1";
				$rs_ano = @pg_exec($conn,$sql); */
				
				if(pg_num_rows($rs_instit)!=0){
					
				$_ANO=@pg_result($rs_ano,0);
				$_SESSION['_ANO'] = $_ANO;
				
				}else{
					
					echo "<center><h1>No Existe A�o Iniciado</h1></center>";
					return;
					
					}
				
				$_IPDB = pg_host($conn);
				$_SESSION['_IPDB'] = $_IPDB;
				$_DBNAME = pg_dbname($conn);
				$_SESSION['_DBNAME'] = $_DBNAME;
				$_SESSION['_ID_BASE'] = $_GET['id_base'];
				
				header('Location: ../cede/index.php');
			   
			   }else{
				   
				   echo "<center><h1>Faltan Permisos de Acceso</h1></center>";
				   return;
				   
				   }
			   
			   
			};//FIN PERFIL 	
			
			
		if($_PERFIL==47){	// PERFIL FINANCIERO
		
			/*	$qry_corp = "select distinct(corp_instit.num_corp), corporacion.nombre_corp from accede, corp_instit, corporacion, usuario where usuario.nombre_usuario='".$_NOMBREUSUARIO."'
	
	and accede.rdb = corp_instit.rdb 
	and corp_instit.num_corp = corporacion.num_corp 
	and accede.id_usuario=usuario.id_usuario and id_perfil=".$perfil."";
			
			
			$res_corp = @pg_Exec($conn,$qry_corp) or die("select fallosss :".$qry_corp);
			
			$fila_corp = @pg_fetch_array($res_corp,0);
			
			$_CORPORACION = $fila_corp['num_corp'];	
			session_register('_CORPORACION');
			
			$corpx = $fila_corp['num_corp'];
					
			$_NOMCORP = $fila_corp['nombre_corp'];
			session_register('_NOMCORP');
			
			$_USUARIOENSESION="Sostenedor Corporativo";
			session_register('_USUARIOENSESION');*/
			
			$_FRMMODO="mostrar";
			session_register('_FRMMODO');
			
			$sql ="SELECT id_nacional FROM nacional_corp nc INNER JOIN corp_instit ci ON nc.num_corp=ci.num_corp WHERE rdb=".$_INSTIT;
			$rs_nacional = pg_exec($conn,$sql);
			
			
			$_ID_NACIONAL=pg_result($rs_nacional,0);	
			session_register('_ID_NACIONAL');
			
			$_MDINAMICO = 1;

	echo  "<HTML><HEAD><script>window.location = '../admin/financiero/listar_institucion.php'</script></HEAD><BODY></BODY></HTML>";
	
			   
			};//FIN PERFIL 				
			

?>
<? pg_close($conn); ?>
<?php
	require('../util/header.inc');

$nombreusuario=$_NOMBREUSUARIO;


	if (($_USUARIO==1)||($_USUARIO==36)){// SI ID_USUARIO=1,36 (ADMINISTRADOR GRAL COE)
		$_PERFIL=0;
		session_register('_PERFIL');

		$_URLBASE="../admin/institucion/listarInstituciones.php3?modo=ini&pag=1";
		session_register('_URLBASE');
		echo "<HTML><HEAD><script>window.location = '../menu/index.php3'</script></HEAD><BODY></BODY></HTML>";
		exit;
		}
	
	//El permiso de acceso que tiene el usuario esta dado por el perfil que le corresponde.
	$usuario	= $_USUARIO;

	//ACCESOS HABILITADOS PARA EL USUARIO
	$qry="SELECT usuario.id_usuario, perfil.url, accede.rdb, accede.id_perfil FROM (usuario INNER JOIN accede ON usuario.id_usuario = accede.id_usuario) INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil WHERE (((usuario.id_usuario)=".$usuario.") AND ((accede.estado)=1))";

	$result = @pg_Exec($conn,$qry);

	if (!$result){
		error('<b>ERROR :</b>No se puede acceder a la base de datos.1');
	}else{
		if(pg_numrows($result)==1){//UN SOLO PERFIL HABILITADO
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. 2</B>');
			}else{
				$_INSTIT=$fila["rdb"];
				session_register('_INSTIT');

				$_URLBASE=$fila["url"];
				session_register('_URLBASE');

				$_PERFIL=$fila["id_perfil"];
				session_register('_PERFIL');

				if($_PERFIL==16){	//ALUMNO
					//DETERMINAR EL ALUMNO, AÑO ESCOLAR Y CURSO.
					$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$nombreusuario;
					$result = @pg_Exec($conn,$qry);
                     
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_ALUMNO=$fila["rut_alumno"];
						session_register('_ALUMNO');
					};
					//SELECCIONA EL ULTIMO AÑO EN QUE ESTA MATRICULADO
					$qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO=".$_ALUMNO." ORDER BY ID_ANO DESC";
					$result = @pg_Exec($conn,$qry);
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
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
					echo "<HTML><HEAD><script>window.location = '../fichas/fichaAlumno.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL ALUMNO

				if($_PERFIL==15){	//APODERADO
					//DETERMINAR EL APODERADO.
					$qry="SELECT * FROM APODERADO WHERE RUT_APO='".$nombreusuario."'";
					$result = @pg_Exec($conn,$qry);
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_APODERADO=$fila["rut_apo"];
						session_register('_APODERADO');
					};
					// PASAR A LISTAR LOS ALUMNOS DE LOS QUE ES APODERADO
					echo "<HTML><HEAD><script>window.location = 'listarPupilos.php3?apo=".$_APODERADO."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL APODERADO

				if($_PERFIL==10){	//CENTRO DE PADRES
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroPadres.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==11){	//CENTRO DE ALUMNOS
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroAlumnos.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==12){	//WEB SCOUT
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/webScout.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==13){	//CENTRO PASTORAL
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/centroPastoral.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==18){	//EXALUMNOS
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = '../admin/institucion/exalumnos.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==17){	//DOCENTE
					//DETERMINAR EL ALUMNO, AÑO ESCOLAR Y CURSO.
					$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
				
					$result = @pg_Exec($conn,$qry);

					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
					};
					echo "<HTML><HEAD><script>window.location = 'perfilDocente.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==7){	//BIBLIOTECA
					echo "<HTML><HEAD><script>window.location = 'seteaBiblioteca.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==2){	//DIRECTOR ACADEMICO
					echo "<HTML><HEAD><script>window.location = 'seteaAcademico.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==4){	//REPRESENTANTE LEGAL
					echo "<HTML><HEAD><script>window.location = 'seteaAcademico.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
			
				if($_PERFIL==14){	//ADMINISTRADOR WEB COLEGIO
					$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
					$result = @pg_Exec($conn,$qry);
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.3');
					}else{
						$fila = @pg_fetch_array($result,0);	
						$_EMPLEADO=$fila["nombre_usuario"];
						session_register('_EMPLEADO');
					};
					echo "<script>window.location = '../menu/index.php3'</script>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==3){	//DIRECTOR FINANCIERO
					echo "<HTML><HEAD><script>window.location = 'seteaAcademico.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
			
				if($_PERFIL==5){	//CONTADOR
					echo "<HTML><HEAD><script>window.location = 'seteaAcademico.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
			
				if($_PERFIL==1){	//DIRECTOR GENERAL
					echo "<script>window.location = '../menu/index.php3'</script>";
					exit;
				};//FIN PERFIL 

				if($_PERFIL==6){	//ENFERMERIA
					$_FRMMODO="mostrar";
					session_register('_FRMMODO');
					echo "<HTML><HEAD><script>window.location = 'listarAno.php3'</script></HEAD><BODY></BODY></HTML>";
					exit;
				};//FIN PERFIL 
			}
		}else{// MAS DE UN PERFIL
				echo "<script>window.location = 'listarPerfiles.php3'</script>";
				exit;
		}
	}
?>
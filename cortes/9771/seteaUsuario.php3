<?php
	require('../util/header.inc');

	$_INSTIT=$institucion;
	session_register('_INSTIT');

	$_PERFIL=$perfil;
	session_register('_PERFIL');

	$usuario	=$_USUARIO;

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

	if($_PERFIL==16){	//ALUMNO
		//DETERMINAR EL ALUMNO, AÑO ESCOLAR Y CURSO.
		$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
		$result = @pg_Exec($conn,$qry);

		if (!$result){
			error('<b>ERROR :</b>No se puede acceder a la base de datos.3'.$qry);
		}else{
			$fila = @pg_fetch_array($result,0);	
			$_ALUMNO=$fila["nombre_usuario"];
			session_register('_ALUMNO');
		};
		//SELECCIONA EL ULTIMO AÑO EN QUE ESTA MATRICULADO
		$qry="SELECT * FROM MATRICULA WHERE RDB=".$_INSTIT." AND RUT_ALUMNO='".$_ALUMNO."' ORDER BY ID_ANO DESC";
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
		$qryU="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
		$resultU = @pg_Exec($conn,$qryU);
		$filaU = @pg_fetch_array($resultU,0);	
		$qry="SELECT * FROM APODERADO WHERE RUT_APO=".$filaU['nombre_usuario'];
		$result = @pg_Exec($conn,$qry);
		if (!$result){
			error('<b>ERROR :</b>No se puede acceder a la base de datos.5'.$qry);
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
			error('<b>ERROR :</b>No se puede acceder a la base de datos.6');
		}else{
			$fila = @pg_fetch_array($result,0);	
			$_EMPLEADO=$fila["nombre_usuario"];
			session_register('_EMPLEADO');
		};

		echo "<HTML><HEAD><script>window.location = '../fichas/docente/index.html'</script></HEAD><BODY></BODY></HTML>";
		/*echo "<HTML><HEAD><script>window.location = '../menu/docente/index.html'</script></HEAD><BODY></BODY></HTML>";*/
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
		echo "<script>window.location = '../menu/index.php3'</script>";
		exit;
	};//FIN PERFIL 

	if($_PERFIL==3){	//DIRECTOR FINANCIERO
		echo "<HTML><HEAD><script>window.location = '../menu/index.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 

	if($_PERFIL==5){	//CONTADOR
		echo "<HTML><HEAD><script>window.location = '../menu/index.php3?institucion=".$_INSTIT."'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 

	if($_PERFIL==1){	//DIRECTOR GENERAL
		echo "<script>window.location = '../menu/index.php3'</script>";
		exit;
	};//FIN PERFIL 

	if($_PERFIL==6){	//ENFERMERIA
		$_FRMMODO="mostrar";
		session_register('_FRMMODO');
		echo "<HTML><HEAD><script>window.location = '../fichas/enfermeria/index.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 
	if($_PERFIL==19){	//INSPECTOR
		echo "<HTML><HEAD><script>window.location = '../fichas/inspector/index.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 
	if($_PERFIL==20){	//ORIENTADOR
		echo "<HTML><HEAD><script>window.location = '../fichas/orientador/index.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 
	if($_PERFIL==21){	//PSICOLOGO
		echo "<HTML><HEAD><script>window.location = '../fichas/psicologo/index.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 
	if($_PERFIL==22){	//PSICOPEDAGOGO
		echo "<HTML><HEAD><script>window.location = '../fichas/psicopedagogo/index.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	};//FIN PERFIL 
?>
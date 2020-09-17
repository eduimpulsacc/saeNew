


<?php
	require('../util/header.inc');


	$_ANO=$ano;
	session_register('_ANO');
	
	$_CURSO=$curso;
	session_register('_CURSO');

	$_INSTIT=$institucion;
	session_register('_INSTIT');

	$_ALUMNO=$alumno;
	session_register('_ALUMNO');

		
/*	$_APODERADO=$apo;
	session_register('_APODERADO');*/

	$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result = @pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);
	
	$qryA="SELECT tipo_regimen FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT." AND ID_ANO=".$ano;
	$resultA = @pg_Exec($conn,$qryA);
	$filaA = @pg_fetch_array($resultA,0);	

	$_TIPOREGIMEN=$filaA["tipo_regimen"];
	session_register('_TIPOREGIMEN');	

	if ($_INSTIT==24977 || $_INSTIT==25478 || $_INSTIT==770 || $_INSTIT==9276 ){ 
		echo "<HTML><HEAD><script>window.location = '../fichas/fichaAlumno.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
	} else { 

		echo "<HTML><HEAD><script>window.location = '../index.php?institucion='</script></HEAD><BODY></BODY></HTML>";
		
		/*echo "<HTML><HEAD><script>window.location = '../fichas/apoderado/main.php3'</script></HEAD><BODY></BODY></HTML>";*/
		/*echo "<HTML><HEAD><script>window.location = '../fichas/apoderado/index.php?institucion=$_INSTIT'</script></HEAD><BODY></BODY></HTML>";*/
		exit;
	}
?>
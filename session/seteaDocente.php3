<?php
	require('../util/header.inc');

	$_TIPODOCENTE=$caso;
	session_register('_TIPODOCENTE');
	
	$_CODSUBECTOR = $cod_subsector;
	session_register('_CODSUBECTOR');

	if($caso==1){	//PROFESOR JEFE
		$_ANO=$ano;
		session_register('_ANO');
		
		$_INSTIT=$institucion;
		session_register('_INSTIT');
		
		$_CURSO = $curso;
		session_register('_CURSO');
		
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila	= @pg_fetch_array($result,0);	

		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');
		
		if ($swa==0){
		    $_SWA=0;
		    session_register('_SWA');
		}
		
		if ($ta==0){
		    $_TA=0;
		    session_register('_TA');
		}

		$_MENU =$menu;
		    session_register('_MENU');
		$_CATEGORIA=$categoria;
		    session_register('_CATEGORIA');
		
		echo "<HTML><HEAD><script>window.location = '../admin/institucion/ano/curso/seteaCurso.php3?caso=1&curso=".$curso."&from=1&ano=".$ano."&institucion=".$institucion."'</script></HEAD><BODY></BODY></HTML>";
		exit;
	}

	if($caso==2){	//PROFESOR SUBSECTOR
		$_INSTIT=$institucion;
		session_register('_INSTIT');

		$_ANO=$ano;
		session_register('_ANO');
		
		$_CURSO=$curso;
		session_register('_CURSO');
		
		$_MENU =$menu;
		    session_register('_MENU');
		$_CATEGORIA=$categoria;
		    session_register('_CATEGORIA');
		$_ITEM =$item;
			session_register('_ITEM');
		

		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
		$result = @pg_Exec($conn,$qry);
		$fila	= @pg_fetch_array($result,0);	

		$_TIPOREGIMEN=$fila["tipo_regimen"];
		session_register('_TIPOREGIMEN');
		
		if ($swa==1){
		    $_SWA=1;
		    session_register('_SWA');
		}	

		if ($ta==1){
		    $_TA=1;
		    session_register('_TA');
		}	
		
		
		echo "<HTML><HEAD><script>window.location = '../admin/institucion/ano/curso/ramo/seteaRamo.php3?caso=1&ramo=".$ramo."&from=1'</script></HEAD><BODY></BODY></HTML>";
		exit;
	}
?>
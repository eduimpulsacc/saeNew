<?php 
	require('../../../util/header.inc');
	session_unregister('_CURSO');			//LIBERA EL CURSO
	session_unregister('_MATRICULA');		//LIBERA EL MATRICULA
	session_unregister('_PERIODO');			//LIBERA EL PERIODO
	
	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};

	if($_ANO!=""){
	    pg_close($conn);
		echo "<script>window.location = 'ano_escolar.php'</script>";
	}else{
		 if($_INSTIT!=""){
		      pg_close($conn);
			  echo "<script>window.location = 'listarAno.php'</script>";
		 }else{
		      pg_close($conn);
			  echo "<script>window.location = '../menuInstitucion.php3'</script>";
		 }	  
	}
?>
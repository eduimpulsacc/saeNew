<?php 

	require('../../../../../util/header.inc');

	$pag="alumno.php";

    
	if($caso==1){//MOSTRAR ALUMNO
	    if ($sw == 1){
		   // lo mandamos a una pagina de confirmacion para borrar al alumno retirado
		   
		   $pag="retiro_alumno.php";
		}   
	

		$_ALUMNO	=	$alumno;

		if(!session_is_registered('_ALUMNO')){

			session_register('_ALUMNO');

		};
		
		   



		$_FRMMODO	=	"mostrar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	};

	if($caso==2){//INGRESAR ALUMNO

		if(session_is_registered('_ALUMNO')){

			session_unregister('_ALUMNO');

		};

		$_FRMMODO	=	"ingresar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	};

	if($caso==3){//MODIFICAR ALUMNO

		$_FRMMODO	=	"modificar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	};



	if($caso==4){//MOSTRAR ALUMNO VOLVIENDO DE ANOTACION O APODERADO

		session_unregister('_ANOTACION');		//LIBERA LA ANOTACION

		session_unregister('_APODERADO');		//LIBERA EL APODERADO



		$_FRMMODO	=	"mostrar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	};

	if($caso==5){//MOSTRAR ALUMNO

		$_FRMMODO	=	"mostrar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	};



	if($_url==1){//IR A EVALUACION

		$_FRMMODO	=	"ingresar";

		if(!session_is_registered('_FRMMODO')){

			session_register('_FRMMODO');

		};

	$_ALUMNO	=	$alumno;

	$pag="eva/evaluando.php?caso=2";

	};





	echo "<script>window.location = '".$pag."' </script>";

?>
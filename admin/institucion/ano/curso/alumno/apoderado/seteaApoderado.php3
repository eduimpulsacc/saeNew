<?php 
	require('../../../../../../util/header.inc');
	
//	$pag="apoderado.php3";

    $pag="../alumno.php3?pesta=2";

	if($caso==1){//MOSTRAR APODERADO
	    $_APODERADO	=	$apoderado;
		if(!session_is_registered('_APODERADO')){
			session_register('_APODERADO');
		};
        
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	
	if($caso==2){//INGRESAR APODERADO
		if(session_is_registered('_APODERADO')){
			session_unregister('_APODERADO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if ($pesta == 2){
		   $pag="../alumno.php3?pesta=2";
		}   
		
	};
	
	
	if($caso==01){//Buscador RUT
		
	   $q2 = "select * from apoderado where rut_apo = '".trim($apoderado)."'";
	   $r2 = @pg_Exec($conn,$q2);
	   $n2 = @pg_numrows($r2);
	   
	   if($n2!=0){
		   
		$f2 = @pg_fetch_array($r2);
		
			if($f2!=0){
				   
				//$_FRMMODO	=	"modificar";
				if(!session_is_registered('_FRMMODO')){
					session_register('_FRMMODO');
				};
				
				$_APODERADO	= $apoderado;
				if(!session_is_registered('_APODERADO')){
					session_register('_APODERADO');
				};			
				
			  };
		   
		   };
		   
		   //echo $_SESSION['_FRMMODO'];
		   //echo $_SESSION['_APODERADO'];
		   
		   //return;
		
	  };
     
	
	
	  if($caso==3){//MODIFICAR ALUMNO
		
	   		
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		$_APODERADO	= $apoderado;
		if(!session_is_registered('_APODERADO')){
			session_register('_APODERADO');
		};
		
	  }; 
	 
	
	if($caso==5){//MOSTRAR APODERADO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		$_APODERADO	=	$apoderado;
		if(!session_is_registered('_APODERADO')){
			session_register('_APODERADO');
		};	
		$_PESTA =2;
		if(!session_is_registered('_PESTA')){
			session_register('_PESTA');
		};	
		
		$pag="procesoApoderado.php3";
	};
	
	
	
    pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";
	
	
	
?>
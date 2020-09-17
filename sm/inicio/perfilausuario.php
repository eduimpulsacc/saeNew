<script language="javascript" src="../lib/modernizr.js"></script>
<?php
session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

require_once('../php-local-browscap.php');
$navegador=get_browser_local(); 

include("conectar_institucion.php");

function error($error) {
		echo "<html><title>ERROR</title></head>";
		echo "<body><center>";
		echo $error;
		echo "</center></body></html>";
	}
				
	if($_PERFIL==16){	//ALUMNO
	//DETERMINAR EL ALUMNO, AÑO ESCOLAR Y CURSO.
					
	
	 $qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$_NOMBREUSUARIO;
	$result = @pg_Exec($conn,$qry);
	if (!$result){
		error('<b>ERROR :</b>No se puede acceder a la base de datos.4');
	  }else{
		$fila = pg_fetch_array($result,0);	
		 $_SESSION['_ALUMNO']=$fila["rut_alumno"];
		//Nombre de quien inició la session
		$nombrealumno = $fila['nombre_alu'];
		$nombrealumno.= $fila['ape_pat'];
		$nombrealumno.= $fila['ape_mat']; 
		$_SESSION['_USUARIOENSESION']=$nombrealumno;
		
		
	 };
	
                 //SELECCIONA EL ULTIMO AÑO EN QUE ESTA MATRICULADO
				 $qry="SELECT m.id_ano,m.id_curso FROM matricula as m 
				 INNER JOIN ano_escolar as a on m.id_ano=a.id_ano WHERE RDB='".$_INSTIT."' AND 		
				 RUT_ALUMNO='".$_ALUMNO."' ORDER BY a.nro_ano DESC LIMIT 1";
				// die($qry);
				 $result = pg_Exec($conn,$qry);
					if (!$result){
					//	error('<b>ERROR :</b>No se puede acceder');
					}else{
						$fila_mat = pg_fetch_array($result,0);	
						$_SESSION['_ANO']=$fila_mat["id_ano"];
						$_SESSION['_CURSO']=$fila_mat["id_curso"];
					};
				
	};//FIN PERFIL ALUMNO

 
 
    	if($_PERFIL==15){	//APODERADO 
				
					//DETERMINAR EL APODERADO.
					$qry="SELECT * FROM APODERADO WHERE RUT_APO=".trim($_NOMBREUSUARIO);
					$result = @pg_Exec($conn,$qry) or die( pg_last_error($conn) );
					
					if (!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.34');
					}else{
					
						$fila = @pg_fetch_array($result,0);	
						$_SESSION['_APODERADO']=$fila["rut_apo"];
				 
						//Nombre de quien inició la session
						$nombreapoderado = $fila["nombre_apo"];
						$nombreapoderado.= $fila["ape_pat"];
						$nombreapoderado.= $fila["ape_mat"];
		            
					    $_SESSION['_USUARIOENSESION']=$nombreapoderado;
					
					};
					
	// PASAR A LISTAR LOS ALUMNOS DE LOS QUE ES APODERADO				
	?>
    
	
	<?
		//exit;
	} //FIN PERFIL APODERADO
?><script>
		if (Modernizr.canvas){
			 window.location = '../mobilehtml5/listarpupilos.php'
		}else{
			 window.location = '../mobilexhtmlmp/listarpupilos.php'
		} 
	</script>
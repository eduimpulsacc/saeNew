<?
session_start();
require "../../class/Coneccion.class.php";
$obj_conn = new DBManager($_IPDB,$_DBNAME);
	
	    $sql = "SELECT * FROM evados.eva_plantilla evpa WHERE evpa.id_plantilla = 33;";
		$regis0 = pg_Exec( $obj_conn->conectar(),$sql ) or die( "Error bd Select 1" );
		
		  if($regis0){
			$fila = pg_fetch_array($regis0,0);
			$nombre_plantilla = $fila['nombre'];
			$id_plantilla = $fila['id_plantilla'];
			
		  }else{
		   echo "No Encontrado";
		  }
		
		$table = "<table border=1 style='border-collapse:collapse'  id='vistaprevia' width='100%' >
		<tr><th colspan='4' >".$nombre_plantilla."</th></tr>";
		
		$sql = "SELECT distinct epe.id_area,epn.id_plantilla,epe.nombre 
FROM evados.eva_plantilla_area  epe
INNER JOIN evados.eva_plantilla_nacional epn ON epe.id_area=epn.id_area
WHERE epn.id_plantilla = ".$id_plantilla.";";
		$regis1 = pg_Exec( $obj_conn->conectar(),$sql ) or die( "Error bd Select 2" );
		
		  if($regis1){
			 
			  for($e=0;$e<pg_numrows($regis1);$e++){
			  
				$fila = pg_fetch_array($regis1,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $fila['id_plantilla'];
				
				$table .= "<tr><td colspan='1' width='3%' >&nbsp;>&nbsp;</td><td><strong>".$nombre_area."</strong></td></tr>";
			  
				 $sql = "SELECT distinct epn.id_plantilla,epn.id_area,eps.id_subarea,eps.nombre 
FROM evados.eva_plantilla_subarea as eps
INNER JOIN evados.eva_plantilla_nacional epn ON epn.id_area = ".$id_area." AND eps.id_subarea=epn.id_subarea
WHERE epn.id_plantilla = ".$id_plantilla.";";
				 
				 $regis2 = pg_Exec( $obj_conn->conectar(),$sql ) or die( "Error bd Select 3" );
		
				  if($regis2){
					
				  for($t=0;$t<pg_numrows($regis2);$t++){
					  
				  $fila = pg_fetch_array($regis2,$t);
				  $nombre_subarea = $fila['nombre'];
				  $id_subarea = $fila['id_subarea'];
				  
				  $table .= "<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre_subarea.
				  "&nbsp;&nbsp;&nbsp;</td></tr>";
				  
					$sql = "SELECT epn.id_plantilla,epn.id_area,epn.id_subarea,epi.id_item,epi.nombre
FROM evados.eva_plantilla_item epi
INNER JOIN evados.eva_plantilla_nacional epn ON  epn.id_area =".$id_area."  and epn.id_subarea = ".$id_subarea."  and epn.id_item = epi.id_item
WHERE epn.id_plantilla = ".$id_plantilla.";";
	
	                 $regis3 = pg_Exec( $obj_conn->conectar(),$sql ) or die( "Error bd Select 4" );
				   
				     for($q=0;$q<pg_numrows($regis3);$q++){ 
					 
					     $fila = pg_fetch_array($regis3,$q);
				         $nombre_item = $fila['nombre'];
						 
						  $table .= "<tr><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre_item."&nbsp;&nbsp;&nbsp;</td></tr>";
					 
					 } // for 3
					   
				  } // for 2
				  
				  }else{
				  
				  echo "No Encontrado";
				  
				  } 
			  
			 } // for 1 
			 
		  }else{
		   echo "No Encontrado";
		  }
		
		echo $table .= "</table>";
        
		//return $table;
	
	 
	 
	 ?>
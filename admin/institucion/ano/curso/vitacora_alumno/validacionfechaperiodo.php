<? //require('conecta.php');
require('../../../../../util/header.inc');

//$idperiodo=2419; 
//$fechaingresada='03/03/2010';
//idperiodo=1200&fechaingresada=03/19/2008
//idperiodo=2235&fechaingresada=03/03/2010
//idperiodo=2235&fechaingresada=03/16/2010
	
$nombrebase = pg_dbname($conn);
	
$idperiodo = $_REQUEST['idperiodo'];
$fechaingresada = $_REQUEST['fechaingresada'];


 $sql = "SELECT per.id_periodo,per.nombre_periodo,per.fecha_inicio,per.fecha_termino 
             FROM periodo per WHERE per.id_periodo = $idperiodo AND ";
	
		
		if($nombrebase=="coi_antofagasta"){ 
		   $fechaingresada = fEs2En233($fechaingresada); 
		}
		
		if($nombrebase=="coi_final"){
		   $fechaingresada = fEs2En222($fechaingresada); 
		} 
		
		if($nombrebase=="coi_final_vina"){
		   $fechaingresada = fEs2En22445($fechaingresada); 
		} 

		/*if($nombrebase=="coi_corporaciones"){
		   $fechaingresada = nocreado($fechaingresada); 
		} */
		
 $sql .= "'$fechaingresada' BETWEEN per.fecha_inicio AND per.fecha_termino";

$result =@pg_Exec($conn,$sql);
  
  if (!$result) {
    
	 echo 0;  
      
  }else{ 
     
		 $num_reg = pg_numrows($result);
		 if ($num_reg != ""){
			 echo 1; // confirmado aceptado
		 }else{
			echo 3;
		 }
		  
		 
  }
  
?>

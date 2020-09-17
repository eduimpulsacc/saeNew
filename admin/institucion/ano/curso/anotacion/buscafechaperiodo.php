<?
require('../../../../../util/header.inc');

$idperiodo = $_REQUEST['idperiodo']; 

$sql = "SELECT per.id_periodo,per.nombre_periodo,per.fecha_inicio,per.fecha_termino 
        FROM periodo per WHERE per.id_periodo = $idperiodo";
      
  //echo $sql;
	  
  $result =@pg_Exec($conn,$sql);
  $fila = @pg_fetch_array($result,0);

  if (!$result) {
			
	echo "Error al conectar con la BD";
	exit;
		 
  }else{ 
		 
	
	if ($fila['fecha_inicio'] != ""){
	
	$fecha_inicio =  $fila['fecha_inicio'];
	
	}else{
	
	$fecha_inicio = "Ingresar Fecha Inicio";
	
	 }
	 
	if ($fila['fecha_termino'] != ""){
	
	$fecha_termino = $fila['fecha_termino'];
	
	}else{
	
	$fecha_termino = "Ingresar Fecha Termino";
	
	 }
	
	
	$separa_fecha_inicio = explode('-',$fecha_inicio);
    $fecha_inicio = $separa_fecha_inicio[2].'-'.$separa_fecha_inicio[1].'-'.$separa_fecha_inicio[0];
	
	$separa_fecha_termino = explode('-',$fecha_termino);
    $fecha_termino = $separa_fecha_termino[2].'-'.$separa_fecha_termino[1].'-'.$separa_fecha_termino[0];
	
echo "<span class='Estilo1'>Fechas Periodo Inicio:$fecha_inicio y Termino:$fecha_termino</span>";	

echo '<input  id="fecha_inicio" type="hidden" value="'.$fecha_inicio.'" />';

echo '<input  id="fecha_termino" type="hidden" value="'.$fecha_termino.'" />'; 
         
     } 

?>

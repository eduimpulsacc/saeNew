<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"cmbANO"=>"cmbANO_1",
"cmbCURSO"=>"cmbCURSO_2",
"cmbALUMNO"=>"cmbALUMNO_3"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	//echo $listadoSelects[$selectDestino];
	//echo "<br>".$selectDestino;
	if(isset($listadoSelects[$selectDestino])){
		
		return true;
	}else{
		
		return false;
	}
}

function validaOpcion($opcionSeleccionada)
{
	//echo $opcionSeleccionada;
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)){
		return true;
	}else{
		return false;
	}
}

$selectDestino=$_GET["select"]; 
$opcionSeleccionada=$_GET["opcion"];



if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{

	
	$tabla=$listadoSelects[$selectDestino];
	require('../../../../../util/header.inc');
	//require('../../../../../util/funciones.php');
	
	if($tabla=="cmbALUMNO_3"){
		
		$cad="";
	if($_INSTIT==25478){
		$cad="and matricula.bool_ar=0";
		}
			
	 $sql ="select alumno.rut_alumno as opcion1, ape_pat || ' ' || ape_mat || ' ' || nombre_alu as opcion2 from alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno WHERE id_curso='$opcionSeleccionada' $cad  ORDER BY ape_pat ASC";
	
		
	
	}elseif($tabla=="cmbCURSO_2"){
		
		$cad="";
	if($_INSTIT==25478){
		$cad="and matricula.bool_ar=0";
		}
	
	  $sql = "SELECT id_curso as opcion1, curso.ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE id_ano='$opcionSeleccionada'  ORDER BY ensenanza, grado_curso ASC";
	
		$sw=1;
	
	}
     
	 //echo $sql;
     //echo pg_dbname($conn);
	$consulta = pg_exec($conn,$sql);
    //echo "contador".@pg_num_rows($consulta);
    // Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	for($i=0;$i<@pg_num_rows($consulta);$i++){
		$fila = @pg_fetch_array($consulta,$i);
		if($sw==1){
			$dato = CursoPalabra($fila['opcion1'],1,$conn);
		}else{
			$dato = $fila['opcion2'];
		}
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$dato=htmlentities($dato);
		// Imprimo las opciones del select
		echo "<option value='".$fila['opcion1']."'>".$dato."</option>";
	}			
	echo "</select>";
}
?>
<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"cmbANO"=>"cmbANO_1",
"cmbSUBSECTOR"=>"cmbSUBSECTOR_2",
"cmbNIVEL"=>"cmbNIVEL_3",
"cmbSUBSECTOR_1"=>"cmbSUBSECTOR_4",
"cmb_ensenanza"=>"cmb_ensenanza_5",
"cmb_grado"=>"cmb_grado_6",


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
$extra=$_GET["extra"];



if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{

	
	$tabla=$listadoSelects[$selectDestino];
	require('../../clases/OpenConnect.php');
	require('../../../util/funciones.php');

 

	if($tabla=="cmbSUBSECTOR_2"){
			$qry="SELECT id_ano FROM ano_escolar WHERE nro_ano = ".$opcionSeleccionada." and id_institucion IN (select rdb from";
			$qry.=" corp_instit WHERE num_corp=".$_CORPORACION.")";
			  $result =@pg_exec($conn,$qry);
			  
			  for($i=0;$i<@pg_numrows($result);$i++){
			  	$fila_ano = @pg_fetch_array($result,$i);
					if($i!=pg_numrows($result)-1){
						$anos = $anos.$fila_ano['id_ano'].",";
					}else{
						$anos = $anos.$fila_ano['id_ano'];
					}
			  	}
			  
			$sql ="SELECT cod_subsector as opcion1, nombre as opcion2 FROM subsector WHERE cod_subsector IN (SELECT DISTINCT";
			$sql.=" ramo.cod_subsector FROM ramo INNER JOIN curso ON (ramo.id_curso=curso.id_curso) WHERE curso.id_ano IN ($anos))";
			$sql.=" ORDER BY nombre ASC";
					
			$sw = 1;
	}
	
	
	
	if($tabla=="cmbSUBSECTOR_4"){
	
			$qry="SELECT id_ano FROM ano_escolar WHERE nro_ano = ".$extra." and id_institucion IN (select rdb from corp_instit WHERE";
			$qry.=" num_corp=".$_CORPORACION.")";
			  $result =@pg_exec($conn,$qry);
			  
			  for($i=0;$i<@pg_numrows($result);$i++){
			  	$fila_ano = @pg_fetch_array($result,$i);
					if($i!=pg_numrows($result)-1){
						$anos = $anos.$fila_ano['id_ano'].",";
					}else{
						$anos = $anos.$fila_ano['id_ano'];
					}
			  	}
			  
			  $sql ="SELECT cod_subsector as opcion1, nombre as opcion2 FROM subsector WHERE cod_subsector IN (SELECT DISTINCT";
			  $sql.=" ramo.cod_subsector FROM ramo INNER JOIN curso ON (ramo.id_curso=curso.id_curso) WHERE curso.id_ano IN ($anos) ";
			  $sql.="AND curso.id_nivel=".$opcionSeleccionada.") ORDER BY nombre ASC";
			  
			  $sw = 1;
	}
	
	
	if($tabla=="cmb_grado_6"){
		$ensenanza = $opcionSeleccionada;
	}

		
		$consulta = pg_exec($conn,$sql);
		//echo "contador".@pg_numrows($consulta);

	
	
	// Comienzo a imprimir el select
	echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaContenido(this.id)'>";
	echo "<option value='0'>Elige</option>";
	
	if($ensenanza!=NULL){
	
		if($ensenanza==110){ 
				echo "<option value='4'>Cuarto grado</option>";
				echo "<option value='8'>Ocatavo grado</option>";
			}else{
				echo "<option value='2'>Segundo grado</option>";
		}

	}else{
	
	for($i=0;$i<@pg_numrows($consulta);$i++){
		$fila = @pg_fetch_array($consulta,$i);
			$dato = $fila['opcion2'];
		// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
		$dato=htmlentities($dato);
		// Imprimo las opciones del select
		if($sw==1){
			echo "<option value='".$fila['opcion1']."'>"."(".$fila['opcion1'].") ".substr($dato,0,30)."</option>";
		}else{
			echo "<option value='".$fila['opcion1']."'>".$dato."</option>";
			}
		}	
	}		
	echo "</select>";
}
?>
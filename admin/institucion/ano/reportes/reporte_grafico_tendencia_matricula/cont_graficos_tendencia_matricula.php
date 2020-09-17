<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_graficos_tendencia_matricula.php";

$obj_TendenciaMatricula = new TendenciaMatricula($conn);
$funcion = $_POST['funcion'];

	
	if($funcion == 1){
		   $rdb=$_POST['rdb'];	
		  $result = $obj_TendenciaMatricula->carga_tipo_ense($rdb);
		  if($result){
		$select = "<select name='select_tipo_ense' id='select_tipo_ense' onchange='nombre_tipo(this.value)'>
		<option value='0' select='select'>(Todos)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$cod_tipo = $fila['cod_tipo'];
			$nombre_tipo = $fila['nombre_tipo'];
			
			$select .= "<option value='".$cod_tipo."'>".$cod_tipo.'-'.$nombre_tipo."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
 

?>
<?
//header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
include_once("class_AsistenciaGeneroCursoAnual.php");

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_CartaFelAlumno = new BuscadorReporte ($conn);
$funcion = $_POST['funcion'];


if($funcion == 1){
			
		   $id_ano=$_POST['id_ano'];	
		  $result = $obj_CartaFelAlumno->carga_cursos($id_ano,$_CURSO,$_PERFIL,$_INSTIT,$_NOMBREUSUARIO);
		  if($result){
		$select = "<select name='select_cursos' id='select_cursos' onchange='carga_ramos(this.value)'>
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			$select .= "<option value='".$fila['id_curso']."' >".$Curso_pal."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}

?>
<?
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "mod_ciclos.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_Ciclos = new Ciclos($conn);
$funcion = $_POST['funcion'];



	if($funcion == ciclo){
		  $ano=$_POST['ano'];	
		  $result = $obj_Ciclos->carga_ciclos($ano);
		  if($result){
				$select = "<select name='cmbCICLO' id='cmbCICLO' onChange='carga_curso(this.value)'>
				<option value='0' select='select' >(Selecccionar)</option>";
				for($i=0;$i<pg_numrows($result);$i++){
					$fila=pg_fetch_array($result,$i);
					$select .= "<option value='".$fila['id_ciclo']."' >".$fila['nomb_ciclo']."</option>";
				 }  // for 2 
				 $select .= "</select>"; 
				 echo $select;
		 }else{
				 echo 0;			
		 }
	}


	
	if($funcion == 1){
		  $id_ciclo=$_POST['id_ciclo'];	
		  $result = $obj_Ciclos->carga_cursos($id_ciclo);
		  if($result){
			$select = "<select name='cmbCURSO' id='cmbCURSO' onChange='carga_ramos(this.value)'>
			<option value='0' select='select' >(Selecccionar)</option>";
				
			for($i=0;$i<pg_numrows($result);$i++){
				$fila=pg_fetch_array($result,$i);
				$select .= "<option value='".$fila['id_curso']."'>".$fila['nom_curso']."</option>";
			 }  // for 2 
			 $select .= "</select>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
	}
	
	if($funcion==carga_ramos){
			$id_curso=$_POST['id_curso'];
		  $result = $obj_Ciclos->carga_ramo($id_curso);
		  if($result){
		$select = "<select name='select_ramos' id='select_ramos' onChange='carga_alumnos(this.value)' >
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
			$select .= "<option value='".$fila['cod_subsector']."'>".$fila['nombre']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
				}else{ 
				   echo 0;
		}	
	}
	
	
	
if($funcion==lista_alumnos){
			$id_curso=$_POST['id_curso'];
			$ano=$_POST['ano'];
			$id_ramo=$_POST['id_ramo'];
			
		$result = $obj_Ciclos->carga_lista_alumnos($id_curso,$ano);
		if($result){
		$select = "<select name='select_alumnos' id='select_alumnos' >
		<option value='0' select='select' >(Selecccionar)</option>";
				
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['rut_alumno']."'>".$fila['ape_pat'].' '.$fila['nombre_alu']."</option>";
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
		 }else{ 
 echo 0;
		}	
	
			
	}	
if($funcion=="carga_periodo"){
	$ano =$_POST['id_ano'];
	
	$result = $obj_Ciclos->carga_periodo($id_ano);
	if($result){
		$select ="<select name='cmbPERIODO'	id='cmbPERIODO'>
		<option value='0' select='select' >(Selecccionar)</option>";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
		
		$select .= "<option value='".$fila['id_periodo']."'>".$fila['nombre_periodo']."</option>";
		 }  
		 $select .= "</select>"; 
		 echo $select;
	}else{ 
		 echo 0;	
	}
}
	
	
	
	
	/*if($funcion == 2){
		 $id_entrevista = $_POST['id_entrevista'];
		$result = $obj_Entrevista_Prof->Busca_Entrevista_Profesionales($id_entrevista);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_entrevista" type="hidden" value="'.$fila['id_entrevista'].'" />';
				echo '<input id="_obser" type="hidden" value="'.$fila['obs'].'" />';
				echo '<input id="_fecha" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_id_prof" type="hidden" value="'.$fila['id_prof'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }*/
 

?>
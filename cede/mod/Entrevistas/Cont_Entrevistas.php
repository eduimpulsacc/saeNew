<? header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "Mod_Entrevistas.php";

$obj_Plantillas = new Plantillas($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];
//print_r($_POST);

/*****************ADMINISTRA ENSANANZA*****************************/  
	  if($funcion==1){
	   $result = $obj_Plantillas->carga_ensenanzas($_INSTIT);
		if($result){
		$select = "<label>".htmlentities("Seleccionar Enseñanza",ENT_QUOTES,'UTF-8')." &nbsp;:&nbsp; <select name='selectbloque' id='selectbloque' onchange='cargarselect(this.value,2)'>
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['cod_tipo']."'>Cod Resol.".trim($fila['cod_tipo'])."&nbsp;=&nbsp;".
			ucwords(strtolower(htmlentities(trim($fila['nombre_tipo']))))."</option>";
		 }  // for 2 
		 $select .= "</select></label>"; 
		 echo $select;
		 }else{
		 echo 0;			
		 }
     } // fin funcion 7
	 
/**************************************************************/


/************ADMINSITRA PLANTILLA****************************/
  if($funcion==2){
		$id_bloque = $_POST['id_bloque'];
		$rdb=$_POST['rdb'];
		$result = $obj_Plantillas->cargaplantillas($id_bloque,$_NACIONAL,$tipo,$rdb);
		if($result){
		   $select = '<label>Seleccionar Plantilla &nbsp;:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="selectplantilla" id="selectplantilla" onchange="cargarselect(this.value,3)" >';
		   $select .= "<option value=0 select='select' >Selecccionar</option>";
		  for($e=0;$e<pg_numrows($result);$e++){
		        $fila = pg_fetch_array($result,$e);
 	            $select .= " <option value='".$fila['id_plantilla']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."&nbsp;-&nbsp;".$fila['persona']."</option>";
			 }  // for 1
			$select .=  " </select></label>";
			echo $select;
			}else{ 
			   echo 0; 
			}
	 } // fin funcion 9
/**************************************************************/	 



if($funcion==3){
	
		//echo"<pre>";	
		//var_dump($_POST);
		//echo"</pre>";
		 $rdb=$_POST['rdb']; 	
		 $id_plantilla=$_POST['id_plantilla'];
	 $result = $obj_Plantillas->Plantilla($id_plantilla,$tipo,$rdb);
	
}



	if($_POST['tableevaluacion']==1){  

        for($e=1;$e<=count($_POST['conceptos']);$e++){
			
			if($_POST['conceptos'][$e]!=0){	
			
			$datos = explode(",",$_POST['ids_pauta'][$e]);
			$id_concepto =  $_POST['conceptos'][$e];
			
			if( $_ANO_CEDE == ""  )	$_ANO_CEDE='NULL';
			if( $_RUT_ALUMNO =="" )		$_RUT_ALUMNO='NULL';
			if(	$_RUT_APODERADO=="" )	$_RUT_APODERADO='NULL';
			if(	$_NOMBREUSUARIO == "" )	$_NOMBREUSUARIO='NULL';

			$result = $obj_Plantillas->insert_entrevista($datos,$id_concepto,$_ANO_CEDE,$_RUT_ALUMNO,$_RUT_APODERADO,$_NOMBREUSUARIO);
			
			if($result) echo 1;
				else echo 0;
			
		   /*$result = $obj_Pautaeva->fechaevaluacion($_ANO,$datos[5],$datos[4]);
		   if(!$result) echo "Error";*/	
		   
		    }
			
		}
			
      } 



?>
<? header( 'Content-type: text/html; charset=iso-8859-1' ); session_start();
require "../../Class/Coneccion.php";

class Plantillas {
	   

		public $Conec;

	
		//Constructor 
		public function __construct($ip,$bd){
			$this->Conec = new DBManager($ip,$bd);
		 } 
		 
      
	  public function carga_ensenanzas($int){
	  	
	  /*$sql = "SELECT TE.nombre_tipo,TE.cod_tipo,TEI.cod_decreto  FROM tipo_ense_inst AS TEI 
	  INNER JOIN tipo_ensenanza AS TE ON TEI.cod_tipo=TE.cod_tipo 
	  WHERE TEI.rdb=$int and TEI.estado <> 2 order by 2 ";*/
	  
	  $sql = "SELECT TE.nombre_tipo,TE.cod_tipo
					FROM tipo_ense_inst AS TEI 
					INNER JOIN tipo_ensenanza AS TE ON TEI.cod_tipo=TE.cod_tipo 
					WHERE TEI.rdb=$int  and TEI.estado <> 2 
					GROUP BY 1,2 order by 2 ";
	  
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
	  
	  if($regis){ return $regis; }else{ return false; }
	  
	  } 
	  
	  
	  
	  //**************PLANTILLAS********************************// 
	  public function cargaplantillas($id_bloque,$id_nacional,$tipo,$rdb){
	  $sql = "SELECT  id_plantilla,rdb,ensenanza,fecha_creacion,
	  nombre,primera,segunda,tercera,cuarta,quinta,sexta,septima,octava,estado,tipo_plantilla,persona
	  FROM cede.plantilla_apo WHERE tipo_plantilla= '".$tipo."' and rdb=".$rdb." ;";
	  $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
	  if($regis){ return $regis; }else{ return false; }} 
	  
     
	  
		
	public function Plantilla($id_plantilla,$tipo,$rdb){
	
	  echo $sql = "SELECT  * FROM cede.plantilla_apo WHERE id_plantilla = ".$id_plantilla." and rdb=".$rdb."";
	  $regis0 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
		
		  if($regis0){
			$fila = pg_fetch_array($regis0,0);
			$nombre_plantilla = $fila['nombre'];
			$id_plantilla = $fila['id_plantilla'];
			
		  }else{
		   echo "No Encontrado";
		  }
		
	$table = "<form id='entrevista_patoc' name='entrevista_patoc' onsubmit='return false;'  >
	<input type='hidden' name='tableevaluacion' id='tableevaluacion'  value='1'/>
	<table border=1 style='border-collapse:collapse'  id='vistaprevia' width='100%'>
	<tr class='color_fondo' ><th colspan='4' >".$nombre_plantilla."</th></tr>";
	
	 $sql2 = "SELECT  * FROM cede.plantilla_apo pla
					INNER JOIN cede.plantilla_apo_area plaa ON plaa.id_plantilla = pla.id_plantilla
					WHERE  pla.id_plantilla = ".$id_plantilla." and rdb=".$rdb."";
	$regis1 = pg_Exec( $this->Conec->conectar(),$sql2 ) or die( "Error bd Select 2".$sql2 );
		
	if($regis1){
			 
	for($e=0;$e<pg_numrows($regis1);$e++){
			  
	$fila = pg_fetch_array($regis1,$e);
	$nombre_area = $fila['nombre'];
	$id_area = $fila['id_area'];
	$id_plantilla = $fila['id_plantilla'];
				
				
	$table .= "<tr><td colspan='1' >&nbsp;>&nbsp;</td><td><strong>".$nombre_area."</strong></td></tr>";
			  
				 $sql = "SELECT * FROM cede.plantilla_apo_area plaa
								INNER JOIN cede.plantilla_apo_item plai ON plai.id_area = plaa.id_area AND plai.id_plantilla = 
								plaa.id_plantilla
								WHERE plaa.id_area = ".$id_area.";";

				 $regis2 = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
		
				  if($regis2){
					
				  for($t=0;$t<pg_numrows($regis2);$t++){
					  
				  $fila = pg_fetch_array($regis2,$t);
				  $nombre = $fila['nombre'];
				  $id_item = $fila['id_item'];
				  
				  $table .= "<tr><td>&nbsp;&nbsp;</td><td>
				  <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;>&nbsp;".$nombre."&nbsp;&nbsp;&nbsp;</strong></td>";
					   
				/*FOR DE CONCEPTOS DE PLANTILLA */
				
				$table .= '<td width="25%">';
				
				$sql_2 = "SELECT    id_concepto, id_plantilla, glosa, nombre,  sigla FROM 
  				cede.plantilla_apo_concepto as pac  WHERE  pac.id_plantilla = $id_plantilla  ORDER BY 1 ;";
   				    
   				    $regis4 = pg_Exec( $this->Conec->conectar(),$sql_2 ) or die( "Error bd Select 5 :".$sql_2 );
   				    
					$cont_select++; 

					for($a=0;$a<pg_numrows($regis4);$a++){
						
						$fila = pg_fetch_array($regis4,$a);								
					   $table .=  '<label><input type="radio" name="conceptos['.$cont_select.']" value="'.$fila['id_concepto'].'" id="conceptos['.$cont_select.']">'.$fila['sigla'].'</label>';
					
						 } // for 4			

					$table .=  '<input type="radio" name="conceptos['.$cont_select.']" value="0" id="conceptos['.$cont_select.']" checked="checked"  style="visibility:hidden;" >';
					
					$table .= '<input type="hidden" id="ids_pauta['.$cont_select.']" name="ids_pauta['.$cont_select.']"  value=" '.$id_plantilla.','.$id_area.','. $id_item.' " /></td></tr>';
				    
				    $table .= "</td></tr>";   

				    	} // for 2
				    				  
				  }else{
					
				  echo "No Encontrado";
				  
				  } 
			 } // for 1 
		  }else{
		   echo "No Encontrado";
		  }
		  
		echo $table .= '</table><input type="submit"  value="Guardar" onclick="publico_entrevista()"  style="margin :10px; margin-left : 800px;" />
		<input type="reset"  value="Reset"  style="margin :10px; margin-left : 800px;" /></fom>';
		
		//return $table;
	 } // fun metodo vista previa
	 

	 	 
	 public function insert_entrevista($datos,$id_conce,$ano,$_rut_alumno,$_rut_apoderado,$_nombreusuario){
        
		$id_plantilla = $datos[0];
		$id_area = $datos[1];
		$id_item = $datos[2];
			
		$sql = "INSERT INTO 
				    cede.plantilla_apo_evaluacion(id_plantilla,id_area,id_item,id_ano,rut_alumno,rut_apo,rut_emp,fecha,id_concepto) 
					VALUES ($id_plantilla,$id_area,$id_item,$ano,$_rut_alumno,$_rut_apoderado,$_nombreusuario,DEFAULT,$id_conce);";
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select" );
	    
		if($regis){ return true; }else{ return false; }		
		
	    }

	
	 /* public function fechaevaluacion($a,$b,$c){
			$sql_update = "UPDATE evados.eva_relacion_evaluacion SET fecha_evaluacion = CURRENT_DATE
			WHERE id_ano = ".$a." AND rut_evaluado = ".$b." AND rut_evaluador = ".$c.";";
			$regis = pg_Exec($this->Conec->conectar(),$sql_update) or die( "Error:".$sql_update );
					if($regis){ return true; }else{ return false; }	
    		 }*/

    		 		 
 } // FIN CLASS 

?>
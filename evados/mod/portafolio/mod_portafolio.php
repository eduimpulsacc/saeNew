<?
require "../../class/Coneccion.class.php";

class portafolio {
       
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		
		$this->Conec = new DBManager($ip,$bd);
		
	 } 
       

	public function insertaportafolio($_rut_evaluado,$_id_ano,$_id_documento,$_nombre_archivo,$_tipo_archivo){ 
		
	$sql_insert = "INSERT INTO evados.eva_portafolio(rut_evaluado,id_ano,id_documento,nombre_archivo,tipo_archivo) 
VALUES ( ".$_rut_evaluado.",".$_id_ano.",".$_id_documento.",'".$_nombre_archivo."','".$_tipo_archivo."');";

	$regis = pg_Exec( $this->Conec->conectar(),$sql_insert ) or die( "Error bd insert 1" );
			if($regis){
				   return true;
			}else{
				  return false;
			}
	}


    public function cargaportafolios($_rut_evaluador,$_id_ano){
		
		$sql = "SELECT rut_evaluado,id_ano,id_documento,nombre_archivo,tipo_archivo,eva_tipo_doc.nombre as tipo_doc FROM evados.eva_portafolio 
INNER JOIN evados.eva_tipo_doc ON eva_tipo_doc.id_tipo = eva_portafolio.id_documento
WHERE rut_evaluado = $_rut_evaluador AND id_ano = $_id_ano";

		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			
	   if($regis){

		$table = '<table id="flex3" style="display:none">
		      <thead>
		       <tr >
			     <th width="260" >Nombre Archivo</th>
				 <th width="160" >Tipo Documento</th>
				 <th width="60" >Eliminar</th>
			   </tr>
			   </thead>
			   <tbody>';
	
	for($e=0;$e<pg_numrows($regis);$e++){
			  
		$fila = pg_fetch_array($regis,$e);

		$check1 ='<img src="../../img/PNG-48/Delete.png" width="22" height="22" border="0" onclick=eliminar_archivo('.$fila['rut_evaluado'].','.$fila['id_ano'].',"'.$fila['nombre_archivo'].'") />';
		  
		    $table .= "<tr>
			     <td><a href='?archivo=".$fila['nombre_archivo']."' >".$fila['nombre_archivo']."</a></td>
				 <td>".$fila['tipo_doc']."</td>
				 <td>".$check1."</td>
				 </tr>";
		  
		  }  
     
		$table .= "<tbody></table><br>";
	  
		$table .= "<script>cargatabla();</script>";
	
		    echo  $table;
		
		}else{
		
		    return false;
		
		}
		
   }



	public function cargatipodocumentos($nacional){
	
	$sql = "SELECT id_tipo,nombre,rdb FROM evados.eva_tipo_doc 
	WHERE nacional = $nacional order by 1 desc;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 1" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
	 } 
    
	
	public function cargacargos(){
				
	$sql = "SELECT * FROM cargos ORDER BY nombre_cargo ASC;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
	
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
				 
	 } 
		 
		 
	
		public function buscarevaluados($id_cargo){ //Busca Evaluados por Cargo 
			
		$sql = "SELECT ca.nombre_cargo,
					em.nombre_emp,em.ape_pat,em.ape_mat,
					evaeva.rut_evaluado
					FROM cargos ca 
					INNER JOIN trabaja tra on tra.cargo = ca.id_cargo
					INNER JOIN empleado em on em.rut_emp = tra.rut_emp
					INNER JOIN evados.eva_evaluado evaeva on evaeva.rut_evaluado = em.rut_emp
					WHERE ca.id_cargo = ".$id_cargo."order by 2 ";
										
				   $regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
					
					if($regis){
						return $regis;
					}else{
						return false;
					}
		
	    
			}
				 
		 

	public function eliminarbloques($id_bloque){
			
	$sql = "DELETE FROM evados.eva_bloque WHERE id_bloque = $id_bloque ;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Delete 1" );
		if($regis){
		   return true;
		}else{
 		   return false;
		}
   } 


	public function modificarbloques($id_bloque,$nombre_bloque,$porcentaje_bloque){
			
   $sql = "UPDATE  evados.eva_bloque SET nombre = '".trim($nombre_bloque)."' ,porcentaje = $porcentaje_bloque  WHERE  id_bloque =   $id_bloque ;";

	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Update 1" );
	
		if($regis){
			   return true;
		}else{
			  return false;
				}
	} 
		
		
	
	public function buscarbloque($id_bloque){
			
	$sql = "SELECT id_bloque,nombre,porcentaje 
	FROM evados.eva_bloque  WHERE id_bloque= $id_bloque;";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd  Select 2" );
	
		if($regis){
			   return $regis;
		}else{
			  return false;
				}
	} 
		


			 
} // FIN FUNCION


?>

 
<?php 
session_start();

class informeApo{
	
	
public function nuevoInforme($conn,$institucion,$activa,$nombre_informe,$tipo_ense,$descripcion,$titulo,$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,$fecha){
		
		
		 $sql="insert into plantilla_apo (rbd,activa,nombre_informe,tipo_ense,descripcion,titulo,grado1,grado2,grado3,grado4,grado5,grado6,grado7,grado8,grado9,grado10,grado11,grado12,grado13,grado14,grado15,fecha) values ($institucion,$activa,'$nombre_informe',$tipo_ense,'$descripcion','$titulo',$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,'$fecha')";
			$result = pg_exec($conn,$sql) or die("ERROR:".$sql);
			
		
		return $result;
		}
	
	
public function ultimo($conn,$institucion){
					
			 $sqlTraeId="select max (id_plantilla) as id_plantilla from plantilla_apo where rbd=".$institucion;
			$result=pg_exec($conn, $sqlTraeId);
		return $result;
	}
	
	
public function getDatoPlantilla($conn,$id_plantilla){
	
	 $sql="select * from plantilla_apo where id_plantilla=".$id_plantilla." and activo=1" ;
			$result=pg_exec($conn, $sql);
		return $result;
	
}	

public function ing_concepto($conn,$id_plantilla,$nombre,$sigla,$glosa){
	
	 //busco max id plantilla
	 $sqlTraeId="select max (orden) as id_plantilla from plantilla_apo_concepto where id_plantilla=".$id_plantilla." and activo=1";
	 $rs_orden=pg_exec($conn, $sqlTraeId);
	$orden = intval(pg_result($rs_orden,0))+1;
	
	 $sql="insert into plantilla_apo_concepto(id_plantilla,nombre,sigla,glosa,orden) values($id_plantilla,'$nombre','$sigla','$glosa',$orden)";
	$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}
	
	public function updateConcepto($conn,$id_concepto,$nombre,$sigla,$glosa,$orden){
		$sql="update plantilla_apo_concepto set nombre='$nombre',sigla='$sigla',glosa='$glosa',orden=$orden where id_concepto=$id_concepto ";
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	}
	
	public function deleteConcepto($conn,$id_concepto){
		 $sql="update plantilla_apo_concepto set activo=0 where id_concepto=".$id_concepto;
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	}
	
	
	
	
	public function addItem($conn,$id_plantilla,$id_item,$nombre,$activo){
		
}
	
}//fin clase

?>
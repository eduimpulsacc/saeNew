<?php 

class Requerimiento{
	public function contruct(){
		
	}
	
	public function Asignacion($conn){
		$sql="SELECT * FROM solicitud.personal_soporte";	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Tipo($conn){
		$sql="SELECT * FROM solicitud.tipo";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function BuscaColegio($conn,$rdb){
		$sql="SELECT rdb, nombre_instit FROM institucion WHERE rdb=".$rdb;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Estado($conn){
		$sql="SELECT * FROM solicitud.estado";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function GuardaSolicitud($conn,$rdb,$colegio,$fecha,$solicitante,$obs,$sistema,$medio){
		$sql="INSERT INTO solicitud.solicitud (rdb,nombre_instit,fecha,rut_solicitante,observaciones,estado, rut_asignado, id_tipo,id_sistema,id_medio) VALUES(".$rdb.",'".utf8_decode($colegio)."','now()',".$solicitante.",'".utf8_decode($obs)."',1,0,1,".$sistema.",".$medio.")";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function ListadoSolicitudes($conn,$perfil,$rut,$rdb,$solicitante,$colegio,$tipo){
		$sql=" SELECT s.id_solicitud,s.rdb, s.nombre_instit, ps.nombre,s.fecha,e.nombre as nom_estado, t.nombre as nom_tipo, s.estado 
 FROM solicitud.solicitud s INNER JOIN solicitud.personal_soporte ps ON s.rut_solicitante=ps.rut_soporte
 INNER JOIN solicitud.estado e ON e.id_estado=s.estado INNER JOIN solicitud.tipo t ON t.id_tipo=s.id_tipo WHERE id_solicitud<>0";
 		if($perfil==63){
			$sql.=" AND rut_asignado=".$rut." OR rut_solicitante=".$rut;	
		}
		if($rdb!=0){
			$sql.=" AND rdb=".$rdb."";	
		}
		if($solicitante!=0){
			$sql.=" AND rut_solicitante=".$solicitante."";
		}
		if($colegio!=0){
			$sql.=" AND rdb=".$rdb;	
		}
		if($tipo!=0){
			$sql.=" AND id_tipo=".$tipo;	
		}
		$sql.=" ORDER BY t.id_tipo, id_solicitud ASC";
 		$result = pg_exec($conn,$sql);
		
		return $result;
 	
	}
	
	public function Solicitud($conn,$id){
		$sql=" SELECT s.*,s.rdb, s.nombre_instit, ps.nombre,s.fecha,t.nombre as nom, s.observaciones, sis.nombre as sistema,
 m.nombre as medio  
 FROM solicitud.solicitud s 
 INNER JOIN solicitud.personal_soporte ps ON s.rut_solicitante=ps.rut_soporte 
 INNER JOIN solicitud.tipo t ON t.id_tipo=s.id_tipo 
INNER JOIN sistemas sis ON sis.id_sistema=s.id_sistema
INNER JOIN solicitud.medio m ON m.id_medio=s.id_medio
 WHERE id_solicitud=".$id;
 		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function AsignaSolicitud($conn,$id,$estado,$rut,$tipo){
		$sql="UPDATE solicitud.solicitud SET estado=".$estado.", rut_asignado=".$rut.", id_tipo=".$tipo." WHERE id_solicitud=".$id;
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function PersonalAsignado($conn,$rut){
		$sql="SELECT nombre FROM solicitud.personal_soporte WHERE rut_soporte=".$rut;
		$result = pg_exec($conn,$sql);
		
		return $result;		
	}
	
	public function AgregaObs($conn,$id,$rut,$estado,$tipo,$obs){
		$sql="INSERT INTO solicitud.observaciones (id_solicitud,fecha,rut_soporte,id_estado,id_tipo,obs) VALUES (".$id.",'now()',".$rut.",".$estado.",".$tipo.",'".utf8_decode($obs)."')";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Observaciones($conn,$id){
		$sql="SELECT fecha, obs, ps.nombre, case when (id_estado=1) then 'APROBADO' else 'RECHAZADO' END AS estado 				   			  FROM solicitud.observaciones o 
			  INNER JOIN solicitud.personal_soporte ps ON o.rut_soporte=ps.rut_soporte
			  WHERE o.id_solicitud=".$id."
			  ORDER BY id_obs";
		$result = pg_exec($conn,$sql);
		
		return $result;		
	}
	
	public function CantidadSolicitudes($conn){
		$sql="SELECT count(s.*) as cantidad, t.nombre, t.id_tipo
			  FROM solicitud.solicitud s RIGHT JOIN solicitud.tipo t ON s.id_tipo=t.id_tipo
			  GROUP BY 2,3
			  ORDER BY t.id_tipo asc";
		$result = pg_exec($conn,$sql);
				
		return $result;
	}
	
	public function guardaArchivos($conn,$id,$nombre){
		$sql="INSERT INTO solicitud.archivo (id_solicitud, nombre_archivo) VALUES (".$id.",'".$nombre."')";
		$result = pg_exec($conn,$sql);
				
		return $result;
	}
	
	public function BuscaArchivos($conn,$id){
		$sql="SELECT * FROM solicitud.archivo WHERE id_solicitud=".$id;
		$result = pg_exec($conn,$sql);
				
		return $result;	
	}
	
	public function ListadoColegio($conn){
		$sql="SELECT rdb, nombre_instit FROM institucion WHERE institucion.estado_colegio=1 ORDER BY nombre_instit ASC	";
		$result = pg_exec($conn,$sql);
				
		return $result;	
	}
	
	public function EliminaSolicitud($conn,$id){
		$sql="DELETE FROM solicitud.solicitud WHERE id_solicitud=".$id;
		$result = pg_exec($conn,$sql);
				
		return $result;		
	}
	
	public function Sistemas($conn){
		$sql="SELECT * FROM sistemas";
		$result = pg_exec($conn,$sql);
				
		return $result;		
	}
	
	public function Medio($conn){
		$sql="SELECT * FROM solicitud.medio";
		$result = pg_exec($conn,$sql);
				
		return $result;		
	}
	
	
}
?>
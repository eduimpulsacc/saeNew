<?
class Reporte{
	public function construct(){
		
	}
	
	public function ListadoReportes($conn,$perfil,$rdb){
		$sql="SELECT pr.id_reporte,r.nombre,r.id_reporte as nro_reporte 
				FROM planificacion.reportes r
				LEFT JOIN planificacion.perfil_reporte pr ON r.id_reporte=pr.id_reporte AND rdb=".$rdb." AND pr.id_perfil=".$perfil."
				ORDER BY nombre ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
	
	}
	
	public function AgregarReporte($conn,$perfil,$rdb,$reporte){
		$sql="INSERT INTO planificacion.perfil_reporte (id_perfil,rdb,id_reporte) VALUES(".$perfil.",".$rdb.",".$reporte.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function EliminaReporte($conn,$perfil,$rdb,$reporte){
		$sql="DELETE FROM planificacion.perfil_reporte WHERE rdb=".$rdb." AND id_perfil=".$perfil." AND id_reporte=".$reporte;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
}
?>

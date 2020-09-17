<?php  
require("../../util/header.php");
class Ano{
	public function construct(){
		
	}
	
	 public function traeAnos($conn,$rdb){
	  $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$rdb." ORDER BY NRO_ANO";
	
	$reg = @pg_Exec($conn,$qry)or die("f1".$qry);
		
		return $reg;
	}	
	
	public function anoParte($conn,$rdb){
	 $sql="select * from ano_escolar where id_institucion=".$rdb." and situacion=1";
	$reg = @pg_Exec($conn,$sql)or die("f2".$sql);
		
		return $reg;
	}
	
	public function anoUltimo($conn,$rdb){
	  $sql="select * from ano_escolar where id_institucion=".$rdb." order by nro_ano desc limit 1";
	$reg = @pg_Exec($conn,$sql)or die("f".$sql);
		
		return $reg;
	}
	
	
	function ActualizaRegistro($conn,$ano){
	$fecha = date("Y-m-d");
	$sql="SELECT id_prestamo,fecha_devolucion,fecha_entrega,estado_prestamo FROM biblio.prestamo WHERE id_ano=".$ano." AND estado_prestamo=1";
	$result = pg_exec($conn,$sql) or die("Error en SQL -->".$sql);	
	
	for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
		
		if($fecha>$fila['fecha_devolucion'] && strlen($fila['fecha_entrega'])==0 && $fila['estado_prestamo']==1){
			$sql="UPDATE biblio.prestamo SET estado_prestamo=3 WHERE id_prestamo=".$fila['id_prestamo'];
			$rs_prestamo = pg_exec($conn,$sql);		
		}else{
			//echo "<br>i-->".$i." fecha-->".$fecha."  fecha_dev-->".$fila['fecha_devolucion'];
		}
			
	}
}
	
}//fin clase?>
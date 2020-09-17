<?php 

class Agenda{
	public function contruct(){
		
	}
	
	public function Listado($conn,$ano){
		$sql="select * from diario_mural where id_ano = $ano order by fecha_publi,id_diario desc";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
}
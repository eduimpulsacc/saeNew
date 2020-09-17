<?php
 class Escala{
	public function contruct(){
		
	} 
	
public function getEnsenanza($conn,$ano){
	
		$sql="select DISTINCT(c.ensenanza),te.nombre_tipo
from curso c 
inner join tipo_ensenanza te on te.cod_tipo = c.ensenanza
where id_ano = $ano and ensenanza >10 order by ensenanza" ;
		$result = pg_exec($conn,$sql);
		return $result; 
	
}

public function nroAno($conn,$ano){
 $sql="select nro_ano from ano_escolar where id_ano=$ano";
$result=pg_exec($conn,$sql);
$nano = pg_result($result,0);
return $nano;

}

public function tablaGrupo($conn,$rdb,$ano,$ensenanza){
		   $sql="select * from escala_porcentaje where rdb = $rdb and id_ano = $ano and ensenanza=$ensenanza order by orden";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
function getOrdenGrupo($conn,$ano,$ensenanza){
		 $sql="select max(orden) from escala_porcentaje  where id_ano=$ano and ensenanza=$ensenanza  ";
		$result=pg_exec($conn,$sql);
		return $result;
 }	
 
 function getMaxMaximo($conn,$ano,$ensenanza){
		 $sql="select max(maximo) from escala_porcentaje  where id_ano=$ano and ensenanza=$ensenanza";
		$result=pg_exec($conn,$sql);
		return $result;
 }	
 
public function guardaGrupo($conn,$rdb,$ano,$minimo,$maximo,$concepto,$ensenanza,$orden){
		
	   $sql="insert into escala_porcentaje(rdb,id_ano,minimo,maximo,concepto,ensenanza,orden) values($rdb,$ano,$minimo,$maximo,'$concepto',$ensenanza,$orden)";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}	
	
public function tablaGrupoDet($conn,$grupo){
	 	$sql="select * from escala_porcentaje where id=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function borraGrupo($conn,$grupo){
		  $sql="delete from escala_porcentaje where id=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}

public function actualizaGrupo($conn,$id_grupo,$minimo,$maximo,$concepto,$orden){
		
		   $sql="update  escala_porcentaje set minimo=$minimo,maximo=$maximo, concepto='$concepto',orden=$orden where id=$id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}
	
 }//fin clase?>
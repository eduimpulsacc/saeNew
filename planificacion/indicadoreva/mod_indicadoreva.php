<? 
 
 
class IndicadorEva{
	public function contructor(){
			
	}
	
	
function Ensenanza($conn,$institucion){
		  $sql = " SELECT * FROM tipo_ensenanza WHERE cod_tipo IN (SELECT cod_tipo FROM tipo_ense_inst WHERE ";
		$sql.= " rdb = ".$institucion." AND cod_tipo > 9 ";
		
		$sql.="	ORDER BY cod_tipo ASC) ORDER BY cod_tipo ASC";
		
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}	
	
	
public function tipoEnse($conn){
	 $sql="select * from tipo_ensenanza order by cod_tipo asc";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	}	
	
public function gradosense($conn,$tipoense){

 $sql="select grado from tipo_ense_eval WHERE cod_tipo = $tipoense order by grado";
$result = pg_exec($conn,$sql);
	return $result;
}	


public function listaRamoINS($conn,$tipo,$ano,$grado){
		$sql ="select distinct(s.cod_subsector),s.nombre
	from subsector s
	inner join ramo r on r.cod_subsector = s.cod_subsector
	inner join curso c on c.id_curso = r.id_curso
	where c.id_ano=$ano and c.ensenanza=$tipo and c.grado_curso=$grado
	order by s.cod_subsector;";
	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
	public function listaRamoADM($conn,$tipo,$grado){
		  $sql ="SELECT * FROM planificacion.asignatura where tipo_ensenaza=$tipo and grado_curso=$grado order by cod_subsector;";
		 	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
	public function listaTipoObj($conn){
	  $sql ="SELECT * FROM planificacion.tipo_objetivo order by id_objetivo;";
		 	$result = pg_exec($conn,$sql);	
			
		return $result;
	}
	
public function BuscarEje($conn,$cod_subsector,$tipo,$rdb){
		
	 $sql="SELECT * FROM planificacion.ejes WHERE cod_subsector=".$cod_subsector." AND tipo=".$tipo."  and rdb in(0,$rdb) ORDER BY texto ASC";
	$result = pg_exec($conn,$sql);
	
	return $result;
		
}	

	public function listaObj($conn,$tipo,$eje,$grado,$ense){
		
		 $sql="SELECT * FROM planificacion.obj_hab WHERE tipo=".$tipo." AND id_eje=".$eje." and tipo_ense=$ense and grado=$grado ORDER BY codigo ASC";
		$result = pg_exec($conn,$sql);	
		
		return $result;
	}
	
public function guardaInd($conn,$eje,$obj,$rdb,$txt,$base,$uni){
	
	if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
	

 $sql="insert into planificacion.indicador_evaluacion (id_eje,id_obj,rdb,texto,id_ubase) values($eje,$obj,$rdb,'".utf8_decode($txt)."',$uni)";

$result = pg_exec($conn,$sql);
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);

return $result;

}	

public function listado($conn,$eje,$obj,$rdb,$uni){
 $sql="select * from planificacion.indicador_evaluacion where id_eje = $eje and id_obj = $obj  and rdb in (0,$rdb) order by id_indicador";
$result = pg_exec($conn,$sql);	
		
		return $result;
}

public function borraInd($conn,$id,$base){
	if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");

	}
	
//borra indicadores de evaluacion incolucrados
$sqld1="delete from planificacion.indeva_unidad_ano where id_indicador=$id  ";
$di1 = pg_exec($conn,$sqld1);
$di1 = pg_exec($conn2,$sqld1);
$di1 = pg_exec($conn3,$sqld1);

 $sqld2="delete from planificacion.plani_anual_new_indicador where id_indicador=$id  ";
$di2 = pg_exec($conn,$sqld2);
$di2 = pg_exec($conn2,$sqld2);
$di2 = pg_exec($conn3,$sqld2);

 $sqld3="delete from planificacion.plani_semanal_ind where id_indicador=$id  ";
$di3 = pg_exec($conn,$sqld3);
$di3 = pg_exec($conn2,$sqld3);
$di3 = pg_exec($conn3,$sqld3);

 $sqld3="delete from planificacion.indeva_clase where id_indicador=$id  ";
$di3 = pg_exec($conn,$sqld3);
$di3 = pg_exec($conn2,$sqld3);
$di3 = pg_exec($conn3,$sqld3);

 $sqld3="delete from planificacion.indeva_unidad where id_indicador=$id  ";
$di3 = pg_exec($conn,$sqld3);
$di3 = pg_exec($conn2,$sqld3);
$di3 = pg_exec($conn3,$sqld3);

 $sqld3="delete from planificacion.indeva_unidad_ano where id_indicador=$id  ";
$di3 = pg_exec($conn,$sqld3);
$di3 = pg_exec($conn2,$sqld3);
$di3 = pg_exec($conn3,$sqld3);


 $sql="delete from planificacion.indicador_evaluacion where id_indicador=$id ";

$result = pg_exec($conn,$sql);
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);

return $result;	

}


function numUni($conn){
		  $sql = " SELECT * FROM planificacion.unidad_base ";
			
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}	
	
function copiaInd($conn,$id_eje,$id_obj,$rdb,$texto,$unidad,$base){
	
	
	if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
	
	
	   $sql="insert into planificacion.indicador_evaluacion (id_eje,id_obj,rdb,texto,id_ubase) values($id_eje,$id_obj,$rdb,'$texto',$unidad)";
	$result = pg_exec($conn,$sql);
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);

return $result;	
}

function buscaPlani($conn,$id){
 $sql="select * from planificacion.indicador_evaluacion where id_indicador=$id";
$result=pg_exec($conn,$sql);
return $result;
}

function modtxtPlani($conn,$id,$texto,$base){
	
	if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}
	
 $sql="update planificacion.indicador_evaluacion set texto='$texto' where id_indicador=$id";
	$result = pg_exec($conn,$sql);
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);
return $result;
}
}//fin clase
?>
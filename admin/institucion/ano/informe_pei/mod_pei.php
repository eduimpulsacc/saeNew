<?php 
class Pei {

public function guardaPlantilla($conn,$rdb,$area,$nombre){
$sql="insert into pei_plantilla(rdb,nombre,activa,area,fecha_creacion) values($rdb,'$nombre',1,$area,now())";
$result = pg_exec($conn,$sql);
return $result;	

}

public function ulPlantilla($conn,$rdb){
 $sql="select * from pei_plantilla where rdb=$rdb order by id_plantilla desc limit 1";
$result = pg_exec($conn,$sql);
return $result;	

}

public function traeconc($conn,$plantilla){
 $sql="SELECT * FROM pei_concepto where id_plantilla='$plantilla' order by id_concepto";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaConcepto($conn,$plantilla,$glosa,$nombre,$sigla){
 $sql="insert into pei_concepto (id_plantilla,glosa,nombre,sigla) values($plantilla,'$glosa','$nombre','$sigla')";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaArea($conn,$rdb,$area){
$sql="insert into pei_area_evaluacion (nombre,rdb) values('$area',$rdb)";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeArea($conn,$rdb){
$sql="select * from pei_area_evaluacion where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cambiaEstado($conn,$estado,$plantilla){
 $sql="update pei_plantilla set activa=$estado where id_plantilla=$plantilla";
$result = pg_exec($conn,$sql);
return $result;	
}

public function traePlantilla($conn,$plantilla){
$sql="SELECT * FROM pei_plantilla where id_plantilla='$plantilla'";	
$result = pg_exec($conn,$sql);
return $result;	
	
}
public function ensePlantilla($conn,$plantilla){
echo $sql="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=$plantilla";
$result = pg_exec($conn,$sql);
return $result;	
}

public function areaPlantilla($conn,$area){
 $sql="SELECT * FROM pei_area_evaluacion where id_area='$area'";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function nivel1Plantilla($conn,$plantilla,$area){
$sql="SELECT * FROM pei_area_item where id_plantilla=$plantilla and id_padre=0 order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function subareaPlantilla($conn,$plantilla,$area){
 $sql="SELECT * FROM pei_area_item where id_plantilla=$plantilla and id_padre<>0 and id_padre=$area order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function ItemPlantilla($conn,$plantilla,$subarea){
  $sql="SELECT * FROM pei_area_item where id_plantilla=$plantilla and id_padre<>0 and id_padre=$subarea order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function plantillasTodo($conn,$institucion){
$sql="SELECT * FROM pei_plantilla where rdb=".$institucion." order by fecha_creacion asc";	
$result = pg_exec($conn,$sql);
return $result;	
}


public function tengoEvas($conn,$plantilla){
 $sql="select count(*) from pei_evaluacion where id_plantilla = $plantilla";
$result = pg_exec($conn,$sql);
return $result;	
}

public function qplantilla($conn,$plantilla){
	$sql="delete from pei_area_item where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);
	
	$sql="delete from pei_concepto where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);
	
	$sql="delete from pei_plantilla where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);


	return $result;	
}

public function borraEstado($conn,$plantilla){
	$sql="update pei_area_item set con_concepto=0 where id_plantilla=$plantilla";
	$result = pg_exec($conn,$sql);
	return $result;		
}



public function cambiaEstadoItem($conn,$plantilla,$item){
	$sql="update pei_area_item set con_concepto=1 where id_plantilla=$plantilla and id_item=$item";
	$result = pg_exec($conn,$sql);
	return $result;		
}

public function borraSalto($conn,$plantilla){
	$sql="update pei_area_item set salto_pagina=0 where id_plantilla=$plantilla";
	$result = pg_exec($conn,$sql);
	return $result;		
}



public function poneSalto($conn,$plantilla,$item){
	$sql="update pei_area_item set salto_pagina=1 where id_plantilla=$plantilla and id_item=$item";
	$result = pg_exec($conn,$sql);
	return $result;		
}

public function cuentaEvaluacionEconcepto($conn,$concepto){
$sql="select count(*) from pei_evaluacion where respuesta=$concepto";
$result = pg_exec($conn,$sql);
	return $result;	
}

public function qcon($conn,$conc){
$sql="delete from pei_concepto where id_concepto = $conc";
	$result = pg_exec($conn,$sql);	
}

public function updateConcUno($conn,$id_concepto,$nombre,$sigla,$glosa){
echo $sql="update pei_concepto set nombre='$nombre',sigla='$sigla',glosa='$glosa' where id_concepto=$id_concepto";
$result = pg_exec($conn,$sql);
}

}//fin clase


?>
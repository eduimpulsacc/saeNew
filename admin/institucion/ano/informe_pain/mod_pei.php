<?php 
class Pain {

public function guardaPlantilla($conn,$rdb,$tipo_ensenanza,$txtNombrePla,$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,$textopln){
 $sql="insert into pain_plantilla(rdb,tipo_ensenanza,nombre,activa,fecha_creacion,pa,sa,ta,cu,qu,sx,sp,oc,nv,dc,un,duo,tre,cat,quince,diezseis,metas) values($rdb,$tipo_ensenanza,'$txtNombrePla',1,now(),$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,'$textopln')";
$result = pg_exec($conn,$sql);
return $result;	

}

public function ulPlantilla($conn,$rdb){
 $sql="select * from pain_plantilla where rdb=$rdb order by id_plantilla desc limit 1";
$result = pg_exec($conn,$sql);
return $result;	

}

public function traeconc($conn,$plantilla){
$sql="SELECT * FROM pain_concepto where id_plantilla='$plantilla' order by id_concepto";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaConcepto($conn,$plantilla,$glosa,$nombre,$sigla){
 $sql="insert into pain_concepto (id_plantilla,glosa,nombre,sigla) values($plantilla,'$glosa','$nombre','$sigla')";
$result = pg_exec($conn,$sql);
return $result;	
}

public function guardaArea($conn,$rdb,$area){
$sql="insert into pain_area_evaluacion (nombre,rdb) values('$area',$rdb)";
$result = pg_exec($conn,$sql);
return $result;
}

public function traeArea($conn,$rdb){
$sql="select * from pain_area_evaluacion where rdb=$rdb";
$result = pg_exec($conn,$sql);
return $result;	
}

public function cambiaEstado($conn,$estado,$plantilla){
 $sql="update pain_plantilla set activa=$estado where id_plantilla=$plantilla";
$result = pg_exec($conn,$sql);
return $result;	
}

public function plantillasTodo($conn,$institucion){
$sql="SELECT * FROM pain_plantilla where rdb=".$institucion." order by fecha_creacion asc";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function traePlantilla($conn,$plantilla){
$sql="SELECT * FROM pain_plantilla where id_plantilla='$plantilla'";	
$result = pg_exec($conn,$sql);
return $result;	
	
}

public function ensePlantilla($conn,$plantilla){
	 $sql="select nombre_tipo from tipo_ensenanza inner join pain_plantilla on tipo_ensenanza.cod_tipo=pain_plantilla.tipo_ensenanza where pain_plantilla.id_plantilla=".$plantilla;
	$result = pg_exec($conn,$sql);
return $result;	
}

public function tengoEvas($conn,$plantilla){
 $sql="select count(*) from pain_evaluacion where id_plantilla = $plantilla";
$result = pg_exec($conn,$sql);
return $result;	
}

public function qplantilla($conn,$plantilla){
	$sql="delete from pain_area_item where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);
	
	$sql="delete from pain_concepto where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);
	
	$sql="delete from pain_plantilla where id_plantilla = $plantilla";
	$result = pg_exec($conn,$sql);


	return $result;	
}

public function nivel1Plantilla($conn,$plantilla,$area){
$sql="SELECT * FROM pain_area_item where id_plantilla=$plantilla and id_padre=0 order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function subareaPlantilla($conn,$plantilla,$area){
 $sql="SELECT * FROM pain_area_item where id_plantilla=$plantilla and id_padre<>0 and id_padre=$area order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function ItemPlantilla($conn,$plantilla,$subarea){
  $sql="SELECT * FROM pain_area_item where id_plantilla=$plantilla and id_padre<>0 and id_padre=$subarea order by id_item";	
$result = pg_exec($conn,$sql);
return $result;	
}

public function borraEstado($conn,$plantilla){
	$sql="update pain_area_item set con_concepto=0 where id_plantilla=$plantilla";
	$result = pg_exec($conn,$sql);
	return $result;		
}



public function cambiaEstadoItem($conn,$plantilla,$item){
	$sql="update pain_area_item set con_concepto=1 where id_plantilla=$plantilla and id_item=$item";
	$result = pg_exec($conn,$sql);
	return $result;		
}

public function borraSalto($conn,$plantilla){
	$sql="update pain_area_item set salto_pagina=0 where id_plantilla=$plantilla";
	$result = pg_exec($conn,$sql);
	return $result;		
}



public function poneSalto($conn,$plantilla,$item){
	$sql="update pain_area_item set salto_pagina=1 where id_plantilla=$plantilla and id_item=$item";
	$result = pg_exec($conn,$sql);
	return $result;		
}

public function cuentaEvaluacionEconcepto($conn,$concepto){
$sql="select count(*) from pain_evaluacion where respuesta=$concepto";
$result = pg_exec($conn,$sql);
	return $result;	
}

public function qcon($conn,$conc){
$sql="delete from pain_concepto where id_concepto = $conc";
	$result = pg_exec($conn,$sql);	
}

public function updateConcUno($conn,$id_concepto,$nombre,$sigla,$glosa){
echo $sql="update pain_concepto set nombre='$nombre',sigla='$sigla',glosa='$glosa' where id_concepto=$id_concepto";
$result = pg_exec($conn,$sql);
}



}//fin clase


?>
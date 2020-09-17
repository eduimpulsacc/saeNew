<?php 
session_start();

class informeApo{
	
	
public function nuevoInforme($conn,$institucion,$activa,$nombre_informe,$tipo_ense,$desc,$titulo,$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,$fecha,$cmbPlantilla){
		
		
		 $sql="insert into plantilla_apo (rbd,activa,nombre_informe,tipo_ense,descripcion,titulo,grado1,grado2,grado3,grado4,grado5,grado6,grado7,grado8,grado9,grado10,grado11,grado12,grado13,grado14,grado15,fecha,tipo_plantilla) values ($institucion,$activa,'$nombre_informe',$tipo_ense,'$descripcion','$titulo',$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,'$fecha',$cmbPlantilla)";
			$result = pg_exec($conn,$sql) or die("ERROR:".$sql);
			
		
		return $result;
		}
	
	
public function ultimo($conn,$institucion){
					
			 $sqlTraeId="select max (id_plantilla) as id_plantilla from plantilla_apo where rbd=".$institucion;
			$result=pg_exec($conn, $sqlTraeId);
		return $result;
	}
	
	
public function getDatoPlantilla($conn,$id_plantilla){
	
	  $sql="select * from plantilla_apo where id_plantilla=".$id_plantilla." and activa=1" ;
			$result=pg_exec($conn, $sql);
		return $result;
	
}	

public function ing_item($conn,$id_plantilla,$id_area,$nombre){
	
	
	 $sql="insert into plantilla_apo_item(id_plantilla,id_area,nombre,activo,id_padre) values($id_plantilla,$id_area,'$nombre',1,0)";
	$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}
	
	

	
	
	
	public function ActualizaItem($conn,$nombre,$id_item){
		$sql="update plantilla_apo_item set nombre='$nombre' where id_item=$id_item";
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
		
}


	public function updatePlantilla($conn,$id_plantilla,$nombre_informe,$tipo_ense,$descripcion,$titulo,$grado1,$grado2,$grado3,$grado4,$grado5,$grado6,$grado7,$grado8,$grado9,$grado10,$grado11,$grado12,$grado13,$grado14,$grado15,$cmbPlantilla){
		  $sql="update plantilla_apo set nombre_informe='".utf8_decode($nombre_informe)."',tipo_ense=$tipo_ense,descripcion='".utf8_decode($descripcion)."',titulo='".utf8_decode($titulo)."' ,grado1=$grado1,grado2=$grado2,grado3=$grado3,grado4=$grado4,grado5=$grado5,grado6=$grado6,grado7=$grado7,grado8=$grado8,grado9=$grado9,grado10=$grado10,grado11=$grado11,grado12=$grado12,grado13=$grado13,grado14=$grado14,grado15=$grado15,tipo_plantilla=$cmbPlantilla where id_plantilla=$id_plantilla ";
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	}
	
	
	
	public function Ensenanza($conn,$tipo_ense){
		$sql = " SELECT * FROM tipo_ensenanza WHERE  cod_tipo=".$tipo_ense."";
		
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	public function nuevaArea($conn,$plantilla,$area)
	 {
		 $sql="insert into plantilla_apo_area(id_plantilla,nombre) values($plantilla,'$area')";
	$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}
		
public function getAreas($conn,$plantilla){
	
	   $sql="select * from plantilla_apo_area where id_plantilla=".$plantilla ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

public function getConcepto($conn,$plantilla,$area){
	
	   $sql="select * from plantilla_apo_item where id_plantilla=".$plantilla ." and id_area=$area and activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}

public function elimina_item($conn,$item){
$sql="update plantilla_apo_item set activo=0 where id_item=$item";
$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}	

public function IngresoConcepto($conn,$id_plantilla,$nombre,$sigla,$glosa){
$sql="insert into plantilla_apo_concepto(id_plantilla,nombre,sigla,glosa,activo) values ($id_plantilla,'$nombre','$sigla','$glosa',1)";
$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}

public function ListaConcepto($conn,$plantilla,$area){
	
	    $sql="select * from plantilla_apo_concepto where id_plantilla=".$plantilla ." and  activo=1" ;
			$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	
}


public function modificaConcepto($conn,$id_concepto,$nombre,$sigla,$glosa){
		$sql="update plantilla_apo_concepto set nombre='$nombre',sigla='$sigla',glosa='$glosa' where id_concepto=$id_concepto ";
		$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
	}

public function eliminaConcepto($conn,$concepto){
$sql="update plantilla_apo_concepto set activo=0 where id_concepto=$concepto";
$result=pg_exec($conn, $sql) or die("error".$sql);
		return $result;
}	


public function institucion ($conn,$institucion){
$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result=pg_exec($conn, $sql_ins) or die("error".$sql_ins);
		return $result;

}

public function delPlantilla($conn,$id_plantilla,$estado){
	$est=($estado==0)?1:0;
	
	$sql1="update plantilla_apo set activa=$est where id_plantilla=$id_plantilla";
$result=pg_exec($conn, $sql1) or die("error".$sql1);

/*$sql2="update plantilla_apo_concepto set activo=0 where id_plantilla=$id_plantilla";
$result=pg_exec($conn, $sql2) or die("error".$sql2);
$sql3="update plantilla_apo_item set activo=0 where id_plantilla=$id_plantilla";
$result=pg_exec($conn, $sql3) or die("error".$sql3);*/
		return $result;
	
}
	
}//fin clase

?>
<?php
require('../../../../util/header.inc');
 class Duplica{
	public function construct(){
		
	}
	
 public function traeMax($conn,$rdb){
	  $qry="SELECT max(id_plantilla) FROM informe_plantilla ";
	
	$reg = @pg_Exec($conn,$qry)or die("f".$qry);
		
		return $reg;
	}	
	
		
		
		public function traePlantilla($conn,$plantilla){
	  $qry="SELECT * FROM informe_plantilla where id_plantilla = $plantilla ";
	
	$reg = @pg_Exec($conn,$qry)or die("f".$qry);
		
		return $reg;
	}	
	
	
	
	public function traeAreaPlantilla($conn,$plantilla){
	  $qry="SELECT * FROM informe_area where id_plantilla = $plantilla ";
	
	$reg = @pg_Exec($conn,$qry)or die("f".$qry);
		
		return $reg;
	}	
	
	public function traeItemPlantilla($conn,$area){
	  $qry="SELECT * FROM informe_area_item where id_area = $area ";
	
	$reg = @pg_Exec($conn,$qry)or die("f".$qry);
		
		return $reg;
	}	
		
		
	public function ense($conn,$ins){
		$qry="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$ins."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		
		$reg = @pg_Exec($conn,$qry)or die("f".$qry);
		
		return $reg;
	
	}
	
	public function guardaPlantilla($conn,$max,$plantilla,$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,$tipo_ensenanza,$nombre,$activa,$orientacion,$titulo_informe1,$titulo_informe2,$nuevo_sis,$tipo,$rdb,$diecisiete,$dieciocho,$diecinueve,$veinte,$veintiuno,$veintidos,$veintitres,$veinticuatro,$veinticinco){
	 $sql="insert into informe_plantilla (id_plantilla,pa,sa,ta,cu,qu,sx,sp,oc,nv,dc,un,duo,tre,cat,quince,diezseis,tipo_ensenanza,nombre,fecha_creacion,activa,orientacion,titulo_informe1,titulo_informe2,nuevo_sis,tipo,rdb,diecisiete,dieciocho,diecinueve,veinte,veintiuno,veintidos,veintitres,veinticuatro,veinticinco) values($max,$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,$tipo_ensenanza,'$nombre','".date("Y-m-d")."',$activa,$orientacion,'$titulo_informe1','titulo_informe2',$nuevo_sis,$tipo,$rdb,$diecisiete,$dieciocho,$diecinueve,$veinte,$veintiuno,$veintidos,$veintitres,$veinticuatro,$veinticinco)";	
	$reg = @pg_Exec($conn,$sql) or die("f".$sql);
	$reg = 1;
//return $reg;



if($reg){
	
	$sql_sec="SELECT max(id_plantilla) from informe_plantilla";
		$rs_secuencial = pg_exec($conn,$sql_sec);
		 $id_plantilla_new = pg_result($rs_secuencial,0);
	
	
	 $sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$plantilla." ORDER BY id ASC";
	 $rs_todo = pg_exec($conn,$sql);
	
		 $sql_concepto="INSERT INTO informe_concepto_eval (id_plantilla,glosa,nombre,fecha_creacion,sigla,nota,orden,tipo_eval) (SELECT $id_plantilla_new,glosa,nombre,now(),sigla,nota,orden,tipo_eval FROM informe_concepto_eval WHERE id_plantilla=".$plantilla.")";
	$rs_concepto = pg_exec($conn,$sql_concepto) or die(pg_last_error($conn));
	
	//informe area item
	
   $sql2="select * from informe_area_item where id_plantilla=$plantilla and id_padre=0";
   $reg2 = @pg_Exec($conn,$sql2)or die("f".$sql2);
   
   
   $sql="SELECT max(id) FROM informe_area_item";
	$rs_max = pg_exec($conn,$sql);
	$id_max= pg_result($rs_max,0);
	
	$id_padre=0;
	for($j=0; $j < pg_numrows($rs_todo); $j++){
		$fila_todo = pg_fetch_array($rs_todo,$j);
		$id_max = $id_max + 1;	
		
		if($fila_todo['id_padre']==0){
			$id_padre=0;	
		}else if($fila_todo['id_padre']==$id_padre_anterior){
			//$id_padre=$id_max -1;
		}else if($fila_todo['id_padre']==$id_padre_inicial){
			$id_padre=$id_max_inicial;
		}else{ 
			$id_padre=$id_max -1;		
		}
		
		if($fila_todo['con_concepto']>=1){
			$concepto=$fila_todo['con_concepto'];			
		}else{
			$concepto="NULL";	
		}
		
		//echo "<br>".
		$sql="INSERT INTO informe_area_item (id,id_plantilla,id_padre,glosa,con_concepto,tipo_txt,salto_pagina) VALUES(".$id_max.",".$id_plantilla_new.",".$id_padre.",'".$fila_todo['glosa']."',".$concepto.",NULL,NULL)";
		$rs_insert = pg_exec($conn,$sql);
		
		$id_padre_anterior = $fila_todo['id_padre'];
		if($j==0){
			
			$id_padre=$id_max;	
			$id_max_inicial = $id_max;
			$id_padre_inicial=$fila_todo['id'];	
			
		}
	}
   
/*
for($i=0;$i<pg_numrows($reg2);$i++){
	$sql3="select max(id) from informe_area_item";
	$reg3 = @pg_Exec($conn,$sql3)or die("f".$sql3);
	$maxid = pg_result($reg3,0)+1;
	
	$fila_ae = pg_fetch_array($reg2,$i);
	$id_padre =$fila_ae['id_padre'];
	$glosa =trim($fila_ae['glosa']);
	$con_concepto =(intval($fila_ae['con_concepto'])!=0)?$fila_ae['con_concepto']:'null';
	$tipo_txt =(intval($fila_ae['tipo_txt'])!=0)?$fila_ae['tipo_txt']:'null';
	$salto_pagina =(intval($fila_ae['salto_pagina'])!=0)?$fila_ae['salto_pagina']:'null';
	$orden =(intval($fila_ae['orden'])!=0)?$fila_ae['orden']:'null';
	  $sql4 = "insert into informe_area_item values($maxid,$max,$id_padre,'$glosa',$con_concepto,$tipo_txt,$salto_pagina,$orden)";
	$reg4 = @pg_Exec($conn,$sql4)or die("f".$sql4);
}

		//informe_concepto_eval
		 $sql5="select * from informe_concepto_eval where id_plantilla=$plantilla";
		$reg5 = @pg_Exec($conn,$sql5)or die("f".$sql5);
		for($j=0;$j<pg_numrows($reg5);$j++){
			$fila_ic = pg_fetch_array($reg5,$j);
			$glosa =trim($fila_ic['glosa']);
			$nombre =trim($fila_ic['nombre']);
			$fecha_creacion =date("Y-m-d");
			$sigla =trim($fila_ic['sigla']);
			$nota =(intval($fila_ic['nota'])!=0)?$fila_ic['nota']:'null';
			$orden =(intval($fila_ic['orden'])!=0)?$fila_ic['orden']:'null';
			$tipo_eval =(intval($fila_ic['tipo_eval'])!=0)?$fila_ic['tipo_eval']:'null';
		 	 $sql6 = "insert into informe_concepto_eval (id_plantilla,glosa,nombre,fecha_creacion,sigla,nota,orden,tipo_eval) values($max,'$glosa','$nombre','$fecha_creacion','$sigla',$nota,$orden,$tipo_eval)";
			$reg6 = @pg_Exec($conn,$sql6)or die("f".$sql6);
		}		

	*/
	}
	return $reg;
}
	
}//fin clase
?>
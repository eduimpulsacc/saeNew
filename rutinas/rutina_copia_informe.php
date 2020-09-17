<?
$origen = 1478;
$destino = 2008; 
$id_base =4; 
$ensenanza=110;            

if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }

           
                  
        
//echo "<br>".
$sql="SELECT * FROM informe_plantilla WHERE rdb=$origen and tipo_ensenanza=$ensenanza AND ACTIVA=1 ORDER BY id_plantilla ASC";
$rs_plantilla = pg_exec($conn,$sql) or die(pg_last_error($sql));

for($i=0;$i<pg_numrows($rs_plantilla);$i++){
	$fila =pg_fetch_array($rs_plantilla,$i);
	
	//echo "<br>".
	 $sql="INSERT INTO informe_plantilla (rdb,nombre,tipo_ensenanza,fecha_creacion,pa,sa,ta,cu,qu,sx,sp,oc,nv,dc,un,duo,tre,cat,quince,diezseis,activa,titulo_informe1, titulo_informe2,nuevo_sis,tipo) VALUES (".$destino.",'".$fila['nombre']."',".$fila['tipo_ensenanza'].",'NOW()',".intval($fila['pa']).",".intval($fila['sa']).",".intval($fila['ta']).",".intval($fila['cu']).",".intval($fila['qu']).",".intval($fila['sx']).",".intval($fila['sp']).",".intval($fila['oc']).",".intval($fila['nv']).",".intval($fila['dc']).",".intval($fila['un']).",".intval($fila['duo']).",".intval($fila['tre']).",".intval($fila['cat']).",".intval($fila['quince']).",".intval($fila['diezseis']).",1,'".$fila['titulo_informe1']."','".$fila['titulo_informe2']."',1,".intval($fila['tipo']).")";
	$rs_plantilla_new = pg_exec($conn,$sql) or die(pg_last_error($conn));
		
				
		$sql_sec="SELECT max(id_plantilla) from informe_plantilla";
		$rs_secuencial = pg_exec($conn,$sql_sec);
		 $id_plantilla_new = pg_result($rs_secuencial,0);
		
		 $sql_concepto="INSERT INTO informe_concepto_eval (id_plantilla,glosa,nombre,fecha_creacion,sigla,nota,orden,tipo_eval) (SELECT $id_plantilla_new,glosa,nombre,now(),sigla,nota,orden,tipo_eval FROM informe_concepto_eval WHERE id_plantilla=".$fila['id_plantilla'].")";
	$rs_concepto = pg_exec($conn,$sql_concepto) or die(pg_last_error($conn));
	
	
	 $sql="SELECT * FROM informe_area_item WHERE id_plantilla=".$fila['id_plantilla']." ORDER BY id ASC";
	$rs_todo = pg_exec($conn,$sql);
	
	
	
	/*$sql="SELECT id_plantilla FROM informe_plantilla WHERE rdb=".$rdb." AND tipo_ensenanza=10 AND cu=".$fila['cu']." AND qu=".$fila['qu']." AND fecha_creacion='NOW()'"; 
	$rs_plantilla_new = pg_exec($conn,$sql);
	$id_plantilla_new = pg_result($rs_plantilla_new,0);*/
	
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
	
	
	
	
	
	
		

	
}


//echo "FIN PROCESO CURSO";

?>
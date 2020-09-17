<?php 
$id_base =3;

 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

	 
  if($id_base==3){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }
	
	$sql_del = "delete from perfil_menu_alu_apo where id_perfil=16";
	$rs_del = pg_exec($conn,$sql_del);
	
	$sql_ins = "select rdb from institucion order by rdb";
	$rs = pg_exec($conn,$sql_ins);
	
	 $sql_menu="SELECT * FROM menu_alu_apo where id_menu not in(17,18)";
	$rs_menu = pg_exec($conn,$sql_menu);
	
	
	for($i=0;$i<pg_numrows($rs);$i++){
		$fila_ins=pg_fetch_array($rs,$i);
		$rdb = $fila_ins['rdb'];
		for($j=0;$j<pg_numrows($rs_menu);$j++){
		$fila_menu = pg_fetch_array($rs_menu,$j);
		
			//insert apoderado
			echo "<br>".$sql_insapo="insert into perfil_menu_alu_apo values (".$fila_ins['rdb'].",16,".$fila_menu['id_menu'].")";
			pg_exec($conn,$sql_insapo);
			/*echo "<br>".$sql_insalu="insert into perfil_menu_alu_apo values (".$fila_ins['rdb'].",16,".$fila_menu['id_menu'].")";
			pg_exec($conn,$sql_insalu);*/
		}
	}

?>
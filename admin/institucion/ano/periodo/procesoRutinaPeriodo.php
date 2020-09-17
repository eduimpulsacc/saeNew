<? 

$nro_ano =date("Y");

for($i=1;$i<4;$i++){
	if($i==1){
		$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
	}
	elseif($i==2){
		$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
	}else if($i==3){
		$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Coorporacion.");       
	}
    
	$sql="SELECT id_ano FROM ano_escolar WHERE nro_ano=".$nro_ano;
	$rs_ano = pg_exec($conn,$sql);
	$id_ano = pg_result($rs_ano,0);
	
	$sql="SELECT * FROM periodo WHERE id_ano=".$id_ano." AND ";
	
}

 

?>
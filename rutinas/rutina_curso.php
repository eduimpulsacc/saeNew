<?

$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


$sql  ="SELECT id_curso,grado_curso,ensenanza,cod_decreto FROM curso WHERE ensenanza in(110,310) ORDER BY ensenanza ASC ";
$rs_curso =@pg_exec($conn,$sql);

for($i=0; $i < @pg_numrows($rs_curso); $i++){
	$fila = @pg_fetch_array($rs_curso,$i);
	if($fila['ensenanza']==110){
		if(($fila['grado_curso']==1 || $fila['grado_curso']==2) ){
			$sql = "UPDATE curso SET nivel_grado='NB1' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif(($fila['grado_curso']==3 || $fila['grado_curso']==4) ){
			$sql = "UPDATE curso SET nivel_grado='NB2' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==5){
			$sql = "UPDATE curso SET nivel_grado='NB3' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==6){
			$sql = "UPDATE curso SET nivel_grado='NB4' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==7){
			$sql = "UPDATE curso SET nivel_grado='NB5' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==8){
			$sql = "UPDATE curso SET nivel_grado='NB6' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}
	}elseif($fila['ensenanza']==310){
		if($fila['grado_curso']==1){
			echo "<br>".$sql = "UPDATE curso SET nivel_grado='NM I' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==2 ){
			echo "<br>".$sql = "UPDATE curso SET nivel_grado='NM II' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==3){
			echo "<br>".$sql = "UPDATE curso SET nivel_grado='NM III' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}elseif($fila['grado_curso']==4){
			echo "<br>".$sql = "UPDATE curso SET nivel_grado='NM IV' WHERE id_curso=".$fila['id_curso'];
			$rs_nivel = @pg_exec($conn,$sql);
		}
	}	
	
}

echo "FIN PROCESO CURSO";

?>
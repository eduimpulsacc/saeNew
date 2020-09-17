<?

$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

//$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

$conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

$ano=1633;
$numa = 2016;

$sql="SELECT * FROM feriado WHERE id_ano=".$ano;
$result = pg_exec($conn,$sql);

$sql="SELECT id_ano FROM ano_escolar ae INNER JOIN institucion i ON ae.id_institucion=i.rdb WHERE nro_ano=$numa";
$rs_rdb = pg_exec($conn2,$sql);


for($j=0;$j<pg_numrows($rs_rdb);$j++){
	$fils = pg_fetch_array($rs_rdb,$j);
	for($i=0;$i<pg_numrows($result);$i++){
		$fila = pg_fetch_array($result,$i);
		
		echo "<br>".$sql="SELECT nombre_periodo FROM periodo WHERE id_periodo=".$fila['id_periodo'];
		$rs_nombre = pg_exec($conn,$sql);
		$nombre_periodo = pg_result($rs_nombre,0);
		
		echo "<br>".$sql="SELECT id_periodo FROM periodo WHERE nombre_periodo='".$nombre_periodo."' AND id_ano=".$fils['id_ano'];
		$rs_periodo = pg_exec($conn2,$sql);
		$periodo = pg_result($rs_periodo,0);
		
		if($fils['id_ano']!=$ano)
		{
			echo "<br>".$sql="INSERT INTO feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) VALUES (".$fils['id_ano'].",'".$fila['fecha_inicio']."','".$fila['fecha_fin']."','".$fila['descripcion']."','".$fila['bool_fer']."',".$periodo.")";
			@$rs_insert = pg_exec($conn2,$sql);
		}
	}
}
echo "<br>FIN PROCESO CURSO";

?>
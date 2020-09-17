<? $conn=@pg_connect("dbname=coi_final host=200.2.201.19 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


echo $sql = "select * from matricula2008 where rut_alumno not in(select rut_alumno from matricula where id_ano in(select id_ano from ano_escolar where nro_ano=2008))";
$rs_matricula = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_matricula);$i){
	$fils = pg_fetch_array($rs_matricula,$i);
	
	$sql = "SELECT * FROM matricula2008 WHERE rut_alumno=".$fils['rut_alumno']." AND rdb=".$fils['rdb']." AND id_ano=".$fils['id_ano']." AND id_curso=".$fils['id_curso'];
	$rs_existe = pg_exec($conn,$sql);
	
	if(pg_numrows($rs_existe)==0){
		$sql = "INSERT INTO (rut_alumno,rdb,id_ano,id_curso, fecha, num_mat, bool_baj,bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, fecha_retiro, nro_lista, bool_ed, bool_num, bool_cpadre, bool_otros, bool_seg, total_notas, suma_pond, pond_demre, alum_prio, ben_cedae, ben_hpv, ben_puente, ben_pie) VALUES ('".$fils['rut_alumno']."','".$fils['rdb']."','".$fils['id_ano']."','".$fils['id_curso']."','".$fils['fecha']."','".$fils['num_mat']."','".$fils['bool_baj']."','".$fils['bool_bchs']."','".$fils['bool_aoi']."','".$fils['bool_rg']."','".$fils['bool_ae']."','".$fils['bool_i']."','".$fils['bool_gd']."','".$fils['bool_ar']."','".$fils['fecha_retiro']."','".$fils['nro_lista']."','".$fils['bool_ed']."','".$fils['bool_num']."','".$fils['bool_cpadre']."','".$fils['bool_otros']."','".$fils['bool_seg']."','".$fils['total_notas']."','".$fils['suma_pond']."','".$fils['pond_demre']."','".$fils['alum_prio']."','".$fils['ben_cedae']."','".$fils['ben_hpv']."','".$fils['ben_puente']."','".$fils['ben_pie']."')";
		$result = pg_exec($conn,$sql);
		
	}
}

echo "fin proceso Matricula";
?>
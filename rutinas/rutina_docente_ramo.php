<? 
$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

$ano=2017;
$ano1=2018;

$sql="SELECT id_curso, grado_curso, letra_curso, ensenanza FROM curso WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=19921 AND nro_ano=".$ano.")";
$rs_curso2013 = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_curso2013);$i++){
	$fila_c = pg_fetch_array($rs_curso2013,$i);
	
	echo "<br>".$sql="SELECT ramo.id_ramo, rut_emp, cod_subsector FROM ramo INNER JOIN dicta ON ramo.id_ramo=dicta.id_ramo WHERE id_curso=".$fila_c['id_curso'];
	$rs_ramo = pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_ramo);$j++){
		$fila = pg_fetch_array($rs_ramo,$j);
		
		echo "<br>".$sql="INSERT INTO dicta(id_ramo,rut_emp) (SELECT id_ramo,".$fila['rut_emp']." FROM ramo r INNER JOIN curso c ON r.id_curso=c.id_curso WHERE cod_subsector=".$fila['cod_subsector']." and ensenanza=".$fila_c['ensenanza']." and grado_curso=".$fila_c['grado_curso']."  and letra_curso='".$fila_c['letra_curso']."' AND id_ano in (Select id_ano from ano_escolar where id_institucion=19921 AND nro_ano=$ano1))";
		$rs_dicta = pg_exec($conn,$sql);
	}
	
	
}
																									
echo "FIN PROCESO";

?>

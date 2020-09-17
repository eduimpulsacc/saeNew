<? $conn=@pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$sql ="select curso.id_curso from curso where curso.id_ano in 
(select an.id_ano from ano_escolar an where an.id_institucion in 
(select cop.rdb from corp_instit cop where cop.num_corp 
in (select co.num_corp from nacional_corp co where co.id_nacional=1)) and an.nro_ano=2012) and curso.ensenanza > 110";
$result = pg_Exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	echo "Id_curso--->".$id_curso = trim($fila['id_curso']);

	
	echo"<br>".$qry="INSERT INTO ramo
	     (id_curso,cod_subsector, modo_eval,sub_obli,bool_ip) 
        VALUES 
	     (".$id_curso.",50614,1,1,0);";
	//$result_2 =@pg_Exec($conn,$qry)or die("Fallo Insert".$qry);
	
	
}
 
echo "DATOS GUARDADOS CON EXITO!!";

?>
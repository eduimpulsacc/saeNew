<? $conn=@pg_connect("dbname=coe_traspaso host=200.2.201.33 port=1550 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

echo $sql  ="SELECT * FROM temporal_dav ";
$result =@pg_Exec($conn,$sql);

for($i=0;$i<@pg_numrows($result);$i++){
	$fils = @pg_fetch_array($result,$i);

	echo "<br>".$sql = "SELECT * FROM alumno WHERE rut_alumno=".$fils['campo1'];
	$rs_alum = @pg_exec($conn,$sql);

	if(@pg_numrows($rs_alum)==0){
		$sql ="INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,fecha_nac) ";
		echo "<br>".$sql.=" VALUES (".$fils['campo1'].",'".$fils['campo2']."','".$fils['campo5']."','".$fils['campo3']."','".$fils['campo4']."',".$fils['campo6'].",to_date('".$fils['campo7']."','DD MM YYYY'))";
		$rs_alumno = pg_exec($conn,$sql);
	}


}


echo "FIN PROCESO DE ALUMNOS";

?>
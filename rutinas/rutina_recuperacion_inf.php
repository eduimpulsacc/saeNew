<? 

$conn=pg_connect("dbname=coi_corp20062019 host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

$conn2=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

$sql  ="select * from informe_evaluacion2 ie where ie.id_informe_area_item in (83541,83540,83539,83538,83537) 
and respuesta='X'";
$rs_informe =@pg_Exec($conn,$sql);

for($i=0;$i<@pg_numrows($rs_informe);$i++){
	$fils = @pg_fetch_array($rs_informe,$i);

	echo "<br>".$sql = "UPDATE informe_evaluacion2 SET respuesta='".$fils['respuesta']."' WHERE id=".$fils['id']."";
	$rs_empleado = @pg_exec($conn2,$sql);

}


echo "FIN PROCESO DE EMPLEADO / USUARIO ";

?>
<?
$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");

$sql = "select * from informe_evaluacion2 where id_plantilla = '1120' order by rut_alumno, id";
$res = pg_Exec($conn, $sql);
$num = pg_numrows($res);

echo "num: $num  <br>";

for ($i = 0; $i < $num; $i++){
    $fil = pg_fetch_array($res,$i);
	
	$id_ano       = $fil['id_ano'];
	$id_periodo   = $fil['id_periodo'];
	$id_curso     = $fil['id_curso'];
	$id_plantilla = $fil['id_plantilla'];
	$id_informe_area_item    = $fil['id_informe_area_item'];
	$respuesta    = $fil['respuesta'];
	$concepto     = $fil['concepto'];
	$fecha        = $fil['fecha'];
	$rut_alumno   = $fil['rut_alumno'];
	$tipo_txt     = $fil['tipo_txt'];
	
	$dd = substr($fecha,0,2);
	$mm = substr($fecha,3,2);
	$aa = substr($fecha,6,4);
	
	
	///////  traspasar
	
    /// consultar si existe
	echo $sqlx = "select * from item_evaluados_2008 where id_ano = '".trim($id_ano)."' and id_periodo = '".trim($id_periodo)."' and id_curso = '".trim($id_curso)."' and id_plantilla = '".trim($id_plantilla)."' and id_informe_area_item = '".trim($id_informe_area_item)."' and rut_alumno = '".trim($rut_alumno)."'";
	$resx = pg_Exec($conn, $sqlx);
    $numx = pg_numrows($resx);

	echo "<br><br>";
	
	echo "numx: $numx <br>";
	if ($numx==0){
	     echo "inserto..... <br>";
	     // inserto por primera vez
		 $sql3 = "insert into item_evaluados_2008 (id_ano, id_periodo, id_curso, id_plantilla, id_informe_area_item, fecha, rut_alumno, respuesta1) values ('$id_ano','$id_periodo','$id_curso','$id_plantilla','$id_informe_area_item','$fecha','$rut_alumno','$concepto')";
		 $res3 = pg_Exec($conn,$sql3);
		 $n=2;
	}else{
	     echo "actualizo... <br>";
	     /// actualizo en las demás respuestas
		 echo $sql4 = "update item_evaluados_2008 set respuesta$n = '$concepto' where id_ano = '$id_ano' and id_periodo = '$id_periodo' and  id_curso = '$id_curso' and id_plantilla = '$id_plantilla' and  id_informe_area_item = '$id_informe_area_item' and rut_alumno = '$rut_alumno'";
		 $res4 = pg_Exec($conn,$sql4);
		 $n++;		 
	}			
	
}
echo "fin carga de informe_personalidad plantilla = '1120'";

?>
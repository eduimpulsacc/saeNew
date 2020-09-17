<? 


//base de datos coifinal
$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//if($conn)echo "conecte viña"; 
 
//exit;
$nro_ano = 2014;   
$rbd = 2090;

//año academico 
$sql_anio ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano = pg_exec($conn,$sql_anio);
$fila_ano = pg_fetch_array($rs_ano,0);
 $idano_acad = $fila_ano['id_ano'];
		
//voy a buscar la matricula
$sql_mat ="select rut_alumno,id_curso from matricula where id_ano = $idano_acad order by rut_alumno";
$rs_mat = pg_exec($conn,$sql_mat);

//form alumnos
for($a=0;$a<pg_numrows($rs_mat);$a++){
$fila_mat = pg_fetch_array($rs_mat,$a);
$rut = $fila_mat['rut_alumno'];
$curso = $fila_mat['id_curso'];

//voy a buscar la promocion = 
$sqlpro = "select rut_alumno from promocion where id_curso=$curso and rut_alumno=$rut";
$rs_pro = pg_exec($conn,$sqlpro);
$cont = pg_numrows($rs_pro);
echo $sqlpro."->".$cont."<br>";

//si no encuentro, se borra
if($cont==0){

echo "------";
echo "<br>";
echo $sql_borra = "delete from matricula where id_curso=$curso and rut_alumno=$rut";
//$rs_borra = pg_exec($conn,$sql_borra);
echo "<br>";
echo "------";
echo "<br>";
}

}



?>

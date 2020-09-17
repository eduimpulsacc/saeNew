<? 
//base de datos antigua
/*$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final")*/;

$conn=pg_connect("dbname=coe_traspaso host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error 
de conexion Coi_final");
//if($conn)echo "conecte final";

//base de datos coifinal
$conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//if($conn2)echo "conecte viña"; 
 
//exit;


//
$nro_ano = 2006;   
$rbd = 1190; 
 
//año academico 
$sql_anio ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano = pg_exec($conn,$sql_anio);
$fila_ano = pg_fetch_array($rs_ano,0);
$idano_acad = $fila_ano['id_ano'];


//año academico_coifinal
$sql_anio_coifinal ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano_coifinal = pg_exec($conn2,$sql_anio_coifinal);
$fila_ano_coifinal = pg_fetch_array($rs_ano_coifinal,0);
$idano_acad_coifinal = $fila_ano_coifinal['id_ano'];



//cursos
$sql_cursos = "select * from curso where id_ano = $idano_acad order by id_curso asc;";
$rs_cursos = pg_exec($conn,$sql_cursos);
for($i=0;$i<pg_numrows($rs_cursos);$i++){
$fila_cursos=pg_fetch_array($rs_cursos,$i);
$id_curso = $fila_cursos['id_curso'];
$ensenanza = $fila_cursos['ensenanza'];
$grado_curso = $fila_cursos['grado_curso'];
$letra_curso = $fila_cursos['letra_curso'];


//curso coi final

$sql_cursos_coifinal = "select * from curso where ensenanza = $ensenanza and grado_curso=$grado_curso and letra_curso='$letra_curso' and id_ano= $idano_acad_coifinal order by id_curso asc;";
$rs_cursos_coifinal = pg_exec($conn2,$sql_cursos_coifinal);
$fila_cursos_coifinal=pg_fetch_array($rs_cursos_coifinal,0);
$id_curso_coifinal = $fila_cursos_coifinal['id_curso'];
$ensenanza_coifinal = $fila_cursos_coifinal['ensenanza'];
$grado_curso_coifinal = $fila_cursos_coifinal['grado_curso'];
$letra_curso_coifinal = $fila_cursos_coifinal['letra_curso'];


//ramo zapallar
$sql_ramos = "select * from ramo where id_curso = $id_curso order by id_ramo asc;";
$rs_ramos = pg_exec($conn,$sql_ramos);
for($j=0;$j<pg_numrows($rs_ramos);$j++){
	$fila_ramos=pg_fetch_array($rs_ramos,$j);
	$id_ramo = $fila_ramos['id_ramo'];
	$cod_subsector = $fila_ramos['cod_subsector'];
			
			
		//ramo coi final
		$sql_ramos_coifinal = "select * from ramo where id_curso =$id_curso_coifinal and cod_subsector = $cod_subsector order by id_ramo asc;";
		$rs_ramos_coifinal = pg_exec($conn2,$sql_ramos_coifinal);
		$fila_ramos_coifinal=pg_fetch_array($rs_ramos_coifinal,0);
		$id_ramo_coifinal = $fila_ramos_coifinal['id_ramo'];
		$cod_subsector_coifinal = $fila_ramos_coifinal['cod_subsector'];

		//periodos zapallar
		$sql_periodo = "select * from periodo where id_ano = $idano_acad order by id_periodo asc;";
		$rs_periodo = pg_exec($conn,$sql_periodo);
		
		for($k=0;$k<pg_numrows($rs_periodo);$k++){
		$fila_periodo=pg_fetch_array($rs_periodo,$k);
		$id_periodo = $fila_periodo['id_periodo'];
		
		//periodo coi final
		$sql_periodo_coifinal = "select * from periodo where id_ano = $idano_acad_coifinal order by id_periodo asc;";
		$rs_periodo_coifinal = pg_exec($conn2,$sql_periodo_coifinal);
		$fila_periodo_coifinal= pg_fetch_array($rs_periodo_coifinal,$k);
		$periodo_coifinal=$fila_periodo_coifinal['id_periodo'];
		
		//notas
			$sql_notas ="select * from notas$nro_ano where id_ramo=$id_ramo and id_periodo=$id_periodo order by rut_alumno asc";
			$rs_notas = pg_exec($conn,$sql_notas);
			for($l=0;$l<pg_numrows($rs_notas);$l++){
			$fila_notas=pg_fetch_array($rs_notas,$l);
			 
			
			
				
					$rut_alumno = $fila_notas['rut_alumno'];
					$id_ramo = $fila_notas['id_ramo'];
					$nota1 = $fila_notas['nota1'];
					$nota2 = $fila_notas['nota2'];
					$nota3 = $fila_notas['nota3'];
					$nota4 = $fila_notas['nota4'];
					$nota5 = $fila_notas['nota5'];
					$nota6 = $fila_notas['nota6'];
					$nota7 = $fila_notas['nota7'];
					$nota8 = $fila_notas['nota8'];
					$nota9 = $fila_notas['nota9'];
					$nota10 = $fila_notas['nota10'];
					$nota11 = $fila_notas['nota11'];
					$nota12 = $fila_notas['nota12'];
					$nota13 = $fila_notas['nota13'];
					$nota14 = $fila_notas['nota14'];
					$nota15 = $fila_notas['nota15'];
					$nota16 = $fila_notas['nota16'];
					$nota17 = $fila_notas['nota17'];
					$nota18 = $fila_notas['nota18'];
					$nota19 = $fila_notas['nota19'];
					$nota120 = $fila_notas['nota20'];
					$promedio = $fila_notas['promedio'];
					
					
					$sql= "select * from notas$nro_ano  where rut_alumno=$rut_alumno and id_ramo = $id_ramo_coifinal and id_periodo=$periodo_coifinal";
					$rs_notas2= pg_exec($conn2,$sql);
					
					if(pg_numrows($rs_notas2)==0){
					
						echo "<br>".$sql="INSERT INTO notas$nro_ano (rut_alumno,id_ramo,id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16, nota17, nota18, nota19, nota20, promedio)
							   VALUES ($rut_alumno,$id_ramo_coifinal,$periodo_coifinal,'$nota1','$nota2','$nota3', '$nota4', '$nota5','$nota6','$nota7', '$nota8', '$nota9','$nota10','$nota11','$nota12','$nota13','$nota14', '$nota15', '$nota16', '$nota17','$nota18', '$nota19', '$nota20', '$promedio'    )";
						$rs_insert =pg_exec($conn2,$sql);
					}else{
					
					echo $sql_upnotas ="update notas$nro_ano set 
					nota1 = '$nota1', 
					nota2 = '$nota2', 
					nota3 = '$nota3',
					nota4 = '$nota4',
					nota5 = '$nota5',
					nota6 = '$nota6', 
					nota7 = '$nota7', 
					nota8 = '$nota8', 
					nota9 = '$nota9', 
					nota10 = '$nota10', 
					nota11 = '$nota11', 
					nota12 = '$nota12', 
					nota13 = '$nota13', 
					nota14 = '$nota14', 
					nota15 = '$nota15', 
					nota16 = '$nota16', 
					nota17 = '$nota17', 
					nota18 = '$nota18', 
					nota19 = '$nota19', 
					nota20 = '$nota20', 
					promedio='$promedio' where rut_alumno=$rut_alumno and id_ramo = $id_ramo_coifinal and id_periodo=$periodo_coifinal;";
					echo "<br>";
					$rs_upnotas = pg_exec($conn2,$sql_upnotas);
					
						
					}
					
				}//fin notas zapallar
			
	
		
		}//fin periodo zapallar

			
}//fin ramos zapallar

		
	
		

}//fin rutina
?>

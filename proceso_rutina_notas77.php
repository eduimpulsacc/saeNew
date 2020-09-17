<? 


if($_POST[rbd] != "" && $_POST[periodo] != "" && $_POST[ramo] != ""  ){  // INICO

$cone = pg_connect("dbname=coi_antofagasta host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") 
or die ("No pude conectar a la base de datos destino");

$sql ="SELECT 
inst.nombre_instit,aesco.nro_ano,
cur.grado_curso,cur.letra_curso,
per.id_periodo,ra.id_ramo,
subsec.nombre,n.rut_alumno,n.nota1,
n.nota2,n.nota3,n.nota4,n.nota5,n.nota6,n.nota7,n.nota8,
n.nota9,n.nota10,n.nota11,n.nota12,n.nota13,n.nota14,n.nota15,
n.nota16,n.nota17,n.nota18,n.nota19,n.nota20,n.promedio
FROM institucion inst
INNER JOIN ano_escolar aesco ON  aesco.id_institucion = inst.rdb
INNER JOIN periodo  per ON per.id_ano = aesco.id_ano AND per.id_periodo =".$_POST[periodo]."
INNER JOIN curso cur on cur.id_ano = per.id_ano
INNER JOIN ramo ra ON ra.id_curso = cur.id_curso AND ra.id_ramo = ".$_POST[ramo]."
INNER JOIN subsector subsec on subsec.cod_subsector = ra.cod_subsector
INNER JOIN notas2010 n on n.id_ramo = ra.id_ramo AND n.id_periodo = per.id_periodo AND n.id_ramo = ra.id_ramo
WHERE inst.rdb=".$_POST[rbd]."";

$rs_origen = @pg_exec($cone,$sql);

if(pg_numrows($rs_origen)){
$conix=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
echo '<Table border="1" align="center" style="border-collapse:collapse" >';

}else{ echo "NO Existen Registro";}


	for($i=0;$i<@pg_numrows($rs_origen);$i++){ // CICLO
	
	$z++;
	$fila = @pg_fetch_array($rs_origen,$i);
	
	  $sql = "SELECT n.* FROM notas2010 n WHERE n.rut_alumno =".trim($fila['rut_alumno'])." 
	          AND n.id_periodo =".trim($fila['id_periodo'])." AND n.id_ramo =".trim($fila['id_ramo'])."";
	  $rs = @pg_exec($conix,$sql);
	  
	  echo "<tr nowrap='nowrap' ><td>".$z."_Ok</td><td>".$sql."</td></tr>";
	  	 
			if( pg_numrows($rs) ){ // INICIO 2
						
								
				$sql ="UPDATE notas2010 SET 
				nota1='".trim($fila['nota1'])."',nota2='".trim($fila['nota2'])."',nota3='".trim($fila['nota3'])."',nota4='".trim($fila['nota4'])."',
				nota5='".trim($fila['nota5'])."',nota6='".trim($fila['nota6'])."',nota7='".trim($fila['nota7'])."',nota8='".trim($fila['nota8'])."',
				nota9='".trim($fila['nota9'])."',nota10='".trim($fila['nota10'])."',nota11='".trim($fila['nota11'])."',
				nota12='".trim($fila['nota12'])."',
				nota13='".trim($fila['nota13'])."',nota14='".trim($fila['nota14'])."',nota15='".trim($fila['nota15'])."',
				nota16='".trim($fila['nota16'])."',
				nota17='".trim($fila['nota17'])."',nota18='".trim($fila['nota18'])."',nota19='".trim($fila['nota19'])."',
				nota20='".trim($fila['nota20'])."',
				promedio='".trim($fila['promedio'])."'
				WHERE id_periodo=".trim($fila['id_periodo'])." AND rut_alumno=".trim($fila['rut_alumno'])." AND id_ramo=".trim($fila['id_ramo'])."";
				
				$rs_destino = @pg_exec($conix,$sql) or die("UPDATE FALLO :".$sql);
				
				echo "<tr nowrap='nowrap' ><td>".$z."_Ok</td><td>".$sql."</td></tr>";
				
			
			}else{
			
				$sql = "INSERT INTO notas2010 (RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA1, NOTA2,NOTA3, NOTA4, NOTA5, 
				NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11,NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17,NOTA18, NOTA19, NOTA20,PROMEDIO) 
				VALUES (".trim($fila['rut_alumno']).",".trim($fila['id_ramo']).",".trim($fila['id_periodo']).",'".trim($fila['nota1'])."',
				'".trim($fila['nota2'])."','".trim($fila['nota3'])."','".trim($fila['nota4'])."','".trim($fila['nota5'])."',
				'".trim($fila['nota6'])."','".trim($fila['nota7'])."','".trim($fila['nota8'])."','".trim($fila['nota9'])."',
				'".trim($fila['nota10'])."','".trim($fila['nota11'])."','".trim($fila['nota12'])."','".trim($fila['nota13'])."',
				'".trim($fila['nota14'])."','".trim($fila['nota15'])."','".trim($fila['nota16'])."','".trim($fila['nota17'])."',
				'".trim($fila['nota18'])."','".trim($fila['nota19'])."','".trim($fila['nota20'])."','".trim($fila['promedio'])."')";
				
				$rs_destino = @pg_exec($conix,$sql) or die("INSERT FALLO :".$sql);
								  
				echo "<tr nowrap='nowrap' ><td>".$z."_Ok</td><td>".$sql."</td></tr>";
				 
			
			} // FIN 2

	 

   } //CICLO	 

echo '</table>'; 	 
	  
} // FIN	  

?>
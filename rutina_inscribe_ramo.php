<? 
//$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");       
     
          
  
$sql ="SELECT curso.id_curso, id_ramo FROM curso INNER JOIN ramo ON curso.id_curso=ramo.id_curso WHERE id_ano=1443  ORDER BY id_curso ASC";          
$rs_curso = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);                      
  
for($x=0;$x<@pg_numrows($rs_curso);$x++){          
	$fils = @pg_fetch_array($rs_curso,$x);                                
	  
	$sql ="SELECT distinct rut_alumno FROM matricula WHERE id_curso=".$fils['id_curso']."";              
	$rs_matricula = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);                     
	 
	for($i=0;$i<@pg_numrows($rs_matricula);$i++){               
		$fila = @pg_fetch_array($rs_matricula,$i);          
		    
		echo "<br>".$sql1 ="SELECT * FROM tiene2017  WHERE rut_alumno=".$fila['rut_alumno']." and id_ramo=".$fils['id_ramo']." and id_curso=".$fils['id_curso']."";
		$result = @pg_exec($conn,$sql1);    
		if(@pg_numrows($result)==0){      
			echo "<br>".$sql ="INSERT INTO tiene2017(rut_alumno,id_ramo,id_curso) VALUES(".$fila['rut_alumno'].",".$fils['id_ramo'].",".$fils['id_curso'].")"; 
			$rs_tiene = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);            
		}else{
			echo "<br> no inscribe-->".$sql;      
		}
	} 
}	
?>








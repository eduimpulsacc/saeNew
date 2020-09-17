<?
	$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
	
	
	 $qry_1 = "select * from curso where id_ano=1206";
	 $res_1 = @pg_Exec($conn,$qry_1);
     $num_1 = @pg_numrows($res_1);

	for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);

	$id_ano	 = 1257;
    $id_curso = $fil_1['id_curso'];
	$grado_curso   = $fil_1['grado_curso'];
	
    $letra_curso       = $fil_1['letra_curso'];
	$ensenanza       = $fil_1['ensenanza'];
	
	
	/*if($grado_curso==1){
		$grado_curso_nuevo=2;
		}
	if($grado_curso==2){
		$grado_curso_nuevo=3;
		}	
	if($grado_curso==3){
		$grado_curso_nuevo=4;
		}		
	if($grado_curso==4){
		continue;
		}		*/
	
	  "<br>".$sql_prom="select * from promocion where situacion_final in (1,2) and id_curso=".$id_curso;
	$res_prom = @pg_Exec($conn,$sql_prom);
    $num_prom = @pg_numrows($res_prom);
	for($j=0; $j<$num_prom; $j++){
		
		$fila_prom=@pg_fetch_array($res_prom,$j);
		
		$id_curso_prom =$fila_prom['id_curso'];
		$rut_alumno_prom =$fila_prom['rut_alumno'];
		$rdb=$fila_prom['rdb'];
	    $situacion_final=$fila_prom['situacion_final'];
		
		
		 if($situacion_final==2 and $grado_curso <= 4){
			$grado_curso_nuevo=$grado_curso;
			 "<br>"."sit_final_sin cuartos-->".$situacion_final.' - '.$grado_curso_nuevo.' - '.$letra_curso.' - '.$ensenanza;
			}
			
			if($grado_curso==1 and $situacion_final==1){
		        $grado_curso_nuevo=$grado_curso+2;
	        }elseif($grado_curso==3 and $situacion_final==1){
				$grado_curso_nuevo=$grado_curso+1;
			}
			
			if($grado_curso_nuevo==3){
				$ensenanza=663;
				}
		
	 "<br>".$sql_curso="select * from curso where id_ano=1257 and grado_curso=".$grado_curso_nuevo." and letra_curso='".$letra_curso."' and ensenanza=".$ensenanza; 
	  
	  $res_curso2 = @pg_Exec($conn,$sql_curso);
      $num_curso2 = @pg_numrows($res_curso2);
		
		for($x=0; $x<$num_curso2; $x++){
		$fila_curso2=@pg_fetch_array($res_curso2,$x);
		  "<br>"."id_curso-->".$id_curso2 =$fila_curso2['id_curso'];
		 "<br>"."rut_alumno->".$rut_alumno_prom;
		 "<br>"."rdb->".$rdb;
		 "<br>"."id_ano->".$id_ano;
		 $bool_ar=0;
		 $fecha_mat="01/01/2013";
		
	
		echo"--->"."<br>".$sql="INSERT INTO matricula (rdb,rut_alumno,id_ano,id_curso,bool_ar,fecha) VALUES(".$rdb.",".$rut_alumno_prom.",".$id_ano.",".$id_curso2.",".$bool_ar.",'".$fecha_mat."')";
		$rs_matricula = @pg_exec($conn,$sql) or die(pg_last_error($conn));
		$contador++;
		
		}
		  $contador;
		
	}
	
}	
 echo"<br><br>ok...alumnos insertados..." .$contador." "; 	

?>
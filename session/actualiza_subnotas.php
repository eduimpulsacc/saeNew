<?
// Rutina para actualizar subsectores
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
//$conn=@pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");

// tomar año de trabajo
$institucion = '1747';
$nro_ano     = '2008';
$id_ano      = '836';
$id_periodo1 = '1730';
$id_periodo2 = '1731';


$qry_0 = "select * from temporal_dav";
$res_0 = pg_Exec($conn,$qry_0);
$num_0 = pg_numrows($res_0);

$cont_ramos_insertados = 0;

for ($k=0; $k < $num_0; $k++){
     $fil_0 = pg_fetch_array($res_0,$k);
	 
	 $rdb           = $fil_0['campo1'];
	 $ensenanza     = $fil_0['campo2'];
	 $grado_curso   = $fil_0['campo3'];
	 $letra_curso   = $fil_0['campo4'];
	 $rut_alumno    = $fil_0['campo5'];
	 $cod_subsector = $fil_0['campo6'];	 
	 $promedio      = $fil_0['campo7'];
	 
	 
	 /// rescatar el id_curso	 
	 $sql_cur = "select id_curso from curso where id_ano = '".trim($id_ano)."' and ensenanza = '".trim($ensenanza)."' and grado_curso = '".trim($grado_curso)."' and letra_curso = '".trim($letra_curso)."'";
	 $res_cur = pg_Exec($conn,$sql_cur);
	 $fil_cur = pg_fetch_array($res_cur);
	 $id_curso = $fil_cur['id_curso'];	 
	 
	 
	 /// comprobar si existe el subsector leido		  	  
	 $qry_1 = "select id_ramo from ramo where id_curso = '".trim($id_curso)."' and cod_subsector = '".trim($cod_subsector)."'";
     $res_1 = pg_Exec($conn,$qry_1);
     $num_1 = @pg_numrows($res_1);
	 
	 
	 if ($num_1==0){
	      // subsector no existe se debe crear en RAMO
		  
		  if ($cod_subsector==13){		  
			    $qry_2 = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES ('".trim($id_curso)."',1,'".trim($cod_subsector)."',2,1,1,0,2,0,0,1,1,2,0,0,0,0)";
		   
		   }else{
		        $qry_2 = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES ('".trim($id_curso)."',1,'".trim($cod_subsector)."',1,1,1,0,2,0,0,1,1,2,0,0,0,0)";				   	   
		   
		   }		   
		   $res_2 = pg_Exec($conn,$qry_2);
		   
		   echo "inserté nuevo ramo en curso: $id_curso subsector  $cod_subsector   <br>";
		   
		   $cont_ramos_insertados++;
		   
		   /// tomar el id_ramo creado
		   $qry="SELECT MAX(ID_RAMO) AS ramo, max(id_orden)+1 as orden FROM RAMO WHERE ID_CURSO=".$id_curso;
		   $result =@pg_Exec($conn,$qry);
		   $fila = @pg_fetch_array($result,0);	
		   $newID = trim($fila['ramo']);
		   
		   /// consultar si existe en la tabla tiene
		   $sql_3 = "select * from tiene$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$newID'";
		   $res_3 = @pg_Exec($conn, $sql_3);
		   $num_3 = @pg_numrows($res_3);
		   
		   if ($num_3==0){
		       /// no existe, hay que insertar el ramo
			   $sql_4 = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values ('$rut_alumno','$newID','$id_curso')";
			   $res_4 = @pg_Exec($conn, $sql_4);
		   }else{
		       
			   /// consultar si existe nota en algún periodo
			   $sql_5 = "select * from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$newID' and id_periodo = '$id_periodo1'";
			   $res_5 = @pg_Exec($conn, $sql_5);
			   $num_5 = @pg_numrows($res_5);
			   if ($num_5==0){
			        //// inserto en notas para ambos periodos
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$newID','$id_periodo1','$promedio','$promedio')";
					$res_6 = @pg_Exec($conn, $sql_6);
					
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$newID','$id_periodo2','$promedio','$promedio')";
					$res_6 = @pg_Exec($conn, $sql_6);
					
			   }else{
			   
			         /// existe en notas no insertamos
			   
			   }
		   }    
	 }else{	 
	       // subsector existe se debe comprobar si hay notas para el
		   $fil_1 = @pg_fetch_array($res_1,0);
		   $id_ramo = $fil_1['id_ramo'];
		   
		   
		   /// consultar si existe en la tabla tiene
		   $sql_3 = "select * from tiene$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo'";
		   $res_3 = @pg_Exec($conn, $sql_3);
		   $num_3 = @pg_numrows($res_3);
		   
		   if ($num_3==0){
		       /// no existe, hay que insertar el ramo
			   $sql_4 = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values ('$rut_alumno','$id_ramo','$id_curso')";
			   $res_4 = pg_Exec($conn, $sql_4);
			   
			   
			    /// consultar si existe nota en algún periodo
			   $sql_5 = "select * from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo' and id_periodo = '$id_periodo1'";
			   $res_5 = @pg_Exec($conn, $sql_5);
			   $num_5 = @pg_numrows($res_5);
			   
			   if ($num_5==0){
			        //// inserto en notas para ambos periodos
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$id_ramo','$id_periodo1','$promedio','$promedio')";
					$res_6 = pg_Exec($conn, $sql_6);
					
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$id_ramo','$id_periodo2','$promedio','$promedio')";
					$res_6 = pg_Exec($conn, $sql_6);
					
							
			   }else{
			   
			         /// existe en notas no insertamos
			   
			   }
			   
			   
		    }else{
		       
			   /// consultar si existe nota en algún periodo
			   $sql_5 = "select * from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo' and id_periodo = '$id_periodo1'";
			   $res_5 = @pg_Exec($conn, $sql_5);
			   $num_5 = @pg_numrows($res_5);
			   if ($num_5==0){
			        //// inserto en notas para ambos periodos
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$id_ramo','$id_periodo1','$promedio','$promedio')";
					$res_6 = pg_Exec($conn, $sql_6);
					
					$sql_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('$rut_alumno','$id_ramo','$id_periodo2','$promedio','$promedio')";
					$res_6 = pg_Exec($conn, $sql_6);	
					
							
			   }else{
			        
			       if ($cod_subsector==13){						
						$sql_6 = "update notas$nro_ano set nota1 = '$promedio', promedio = '$promedio' where rut_alumno = '$rut_alumno'  and id_periodo = '$id_periodo1'  and id_ramo = '$id_ramo'";
						$res_6 = pg_Exec($conn, $sql_6);
												
						
						$sql_7 = "update notas$nro_ano set nota1 = '$promedio', promedio = '$promedio' where rut_alumno = '$rut_alumno'  and id_periodo = '$id_periodo2'  and id_ramo = '$id_ramo'";
						$res_7 = pg_Exec($conn, $sql_7);			   
						 /// existe en notas no insertamos
					 
					} 
			   
			   }
		   } 	 
	 } 	  
	  
}   

echo "ramos actualizados............";


?>

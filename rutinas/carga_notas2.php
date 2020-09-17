<?
// Rutina para varias cosas
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destinoooo");
//$conn=@pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");

$salto = $salto + 360;


// tomar el abierto
$institucion = '1502';
$nro_ano     = '2007';
$id_ano      = '843';

$qry_0 = "select * from temporal_dav";
$res_0 = pg_Exec($conn,$qry_0);
$num_0 = pg_numrows($res_0);


// rescatar los periodos
$qry_15 = "select * from periodo where id_ano = '$id_ano'";
$res_15 = @pg_Exec($conn,$qry_15);
$num_15 = @pg_numrows($res_15);

if ($num_15 == 2){
  $fil_15 = @pg_fetch_array($res_15,0);
  $id_periodo1 = $fil_15['id_periodo'];
  
  $fil_15 = @pg_fetch_array($res_15,1);
  $id_periodo2 = $fil_15['id_periodo'];
}else{
  echo "Error, fatal 1 <br>";
  exit();
}	


for ($k=$k; $k < $num_0; $k++){
     $fil_0 = pg_fetch_array($res_0,$k);
	 
	 $rdb           = $fil_0['campo1'];
	 $ensenanza     = $fil_0['campo2'];
	 $grado         = $fil_0['campo3'];
	 $letra         = $fil_0['campo4'];
	 $rut_alumno    = $fil_0['campo5'];
	 $cod_subsector = $fil_0['campo6'];
	 $promedio      = $fil_0['campo7'];
	 		 
	 // consulto el id_curso
	 $sql_curso = "select id_curso from curso where id_ano = '$id_ano' and ensenanza = '$ensenanza' and grado_curso = '$grado' and letra_curso = '$letra'";	 	
	 $res_curso = pg_Exec($conn,$sql_curso);
	 $fil_curso = pg_fetch_array($res_curso,0);
	 $id_curso = $fil_curso['id_curso'];
	 
	 /// conuslto el ramo
	 $sql_ramo = "select id_ramo from ramo where id_curso = '".trim($id_curso)."' and cod_subsector = '".trim($cod_subsector)."'";
	 $res_ramo = pg_Exec($conn, $sql_ramo);
	 $fil_ramo = pg_fetch_array($res_ramo,0);
	 $id_ramo = $fil_ramo['id_ramo'];
	 	    
	   /// consultar si existe en tiene					   
	   $qry_7 = "select * from tiene$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_curso = '".trim($id_curso)."'";
	   $res_7 = @pg_Exec($conn,$qry_7);
	   $num_7 = @pg_numrows($res_7);				   
			   
	   if ($num_7 > 0){   /// existe
			/// consultar si existe en notas para Primer Semestre
			$qry_8 = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($id_periodo1)."'";
			$res_8 = @pg_Exec($conn,$qry_8);
			$num_8 = @pg_numrows($res_8);
	
			if ($num_8==0){
				  /// insertar en PRIMER SEMESTRE
				  $qry_9 = "insert into notas$nro_ano (rut_alumnno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo1)."','".trim($promedio)."','".trim($promedio)."')"; 
				  $res_9 = @pg_Exec($conn,$qry_9);							  
			}
	
	
			/// consultar si existe en notas 2004 para Segundo Semestre
			$qry_8 = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($id_periodo2)."'";
			$res_8 = @pg_Exec($conn,$qry_8);
			$num_8 = @pg_numrows($res_8);
	
			if ($num_8==0){					  
				  // insertar en SEGUNDO SEMESTRE
				  $qry_99 = "insert into notas$nro_ano (rut_alumnno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo2)."','".trim($promedio)."','".trim($promedio)."')"; 
				  $res_99 = @pg_Exec($conn,$qry_99);		  
			}
	
	
	   }else{  /// no existe
			
			// insertar en tiene2004
			$qry_10 = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_curso)."')";
			$res_10 = pg_Exec($conn,$qry_10);				
	
			/// insertar en notas2004, Primer Semestre
			$qry_11 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo1)."','".trim($promedio)."','".trim($promedio)."')"; 
			$res_11 = pg_Exec($conn,$qry_11);				
	
			/// insertar en notas2004, Segundo Semestre
			$qry_111 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo2)."','".trim($promedio)."','".trim($promedio)."')"; 
			$res_111 = pg_Exec($conn,$qry_111);
	   }
	   
	   if ($k > $salto){
	       $porc_av = $porc_av + 2; 
		    
		   echo "Porcentaje de Avance.... $porc_av %";
		   
		   echo "<script>window.location='carga_notas2.php?salto=$salto&k=$k&porc_av=$porc_av'</script>";
		   exit();
	   }			
}
  
echo "Fin carga de notas, $institucion, ano: $nro_ano  ok <br>"; 	
?>

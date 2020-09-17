<?
// Rutina para varias cosas
$conn=@pg_connect("dbname=coe_traspaso host=200.2.201.33 port=1550 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
//$conn=@pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");

// tomar el abierto
$institucion = '8411';
$nro_ano     = '2005';
$id_ano      = '581';
$id_periodo1 = '1211';
$id_periodo2 = '1212';


$qry_0 = "select * from temporal_dav";
$res_0 = pg_Exec($conn,$qry_0);
$num_0 = pg_numrows($res_0);

for ($k=0; $k < $num_0; $k++){
     $fil_0 = pg_fetch_array($res_0,$k);
	 
	 $rdb           = $fil_0['campo1'];
	 $ensenanza     = $fil_0['campo2'];
	 $grado_curso   = $fil_0['campo3'];
	 $letra_curso   = $fil_0['campo4'];
	 $cod_subsector = $fil_0['campo5'];
	 $rut_alumno    = $fil_0['campo6'];
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
		    
		   $qry_2 = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL) VALUES ('".trim($id_curso)."',1,'".trim($cod_subsector)."',1,1,1,0,2,0,0,1,1,2,0,0,0,0)";
		   $res_2 = pg_Exec($conn,$qry_2);
		   
		   /// rescato el id_ramo creado
		   $qry_3 = "select id_ramo from ramo where id_curso = '".trim($id_curso)."' order by id_ramo Desc limit 1";
		   $res_3 = pg_Exec($conn,$qry_3);
		   $fil_3 = pg_fetch_array($res_3);
		   $id_ramo = $fil_3['id_ramo']; 
		   
		   echo "Inserté ramo que no existía: $id_ramo <br>";
		   
		   /// insertar registro en tiene2004
		   $qry_4 = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_curso)."')";
		   $res_4 = @pg_Exec($conn,$qry_4);
		   
		   
		   
		   /// inserto en notas2004 para primser semestre
		   $qry_5 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo1)."','".trim($promedio)."','".trim($promedio)."')";
		   $res_5 = @pg_Exec($conn,$qry_5);
		   
		   		   
		   /// inserto en notas2004 para segundo semestre
		   $qry_6 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo2)."','".trim($promedio)."','".trim($promedio)."')";
		   $res_6 = @pg_Exec($conn,$qry_6);
		   
		   //// nex registro
	 		  
	 }else{
	       /// obtener il id_ramo
		   $fil_1 = @pg_fetch_array($res_1);
		   $id_ramo = $fil_1['id_ramo'];
		   
		   /// consultar si existe en tiene2004
		   $qry_7 = "select * from tiene$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_curso = '".trim($id_curso)."'";
		   $res_7 = @pg_Exec($conn,$qry_7);
		   $num_7 = @pg_numrows($res_7);
		   
		   if ($num_7 > 0){   /// existe
		        /// consultar si existe en notas 2004 para Primer Semestre
				$qry_8 = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($id_periodo1)."'";
				$res_8 = @pg_Exec($conn,$qry_8);
				$num_8 = @pg_numrows($res_8);
				
				if ($num_8==0){
				      /// no existe
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
				$res_10 = @pg_Exec($conn,$qry_10);
				
				
				/// insertar en notas2004, Primer Semestre
				$qry_11 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo1)."','".trim($promedio)."','".trim($promedio)."')"; 
				$res_11 = @pg_Exec($conn,$qry_11);
				
				
				/// insertar en notas2004, Segundo Semestre
				$qry_111 = "insert into notas$nro_ano (rut_alumno, id_ramo, id_periodo, nota1, promedio) values ('".trim($rut_alumno)."','".trim($id_ramo)."','".trim($id_periodo2)."','".trim($promedio)."','".trim($promedio)."')"; 
				$res_111 = @pg_Exec($conn,$qry_111);
		   }	 
	  }	  
	  echo "ciclo for >>  $k de $num_0 <br>";
}   
  
echo "<br> ok rutina 8, para institucion 8411"; 	
?>

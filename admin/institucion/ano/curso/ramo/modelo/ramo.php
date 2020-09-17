<?


function datos_institucion($institucion,$conn){
    $sql = "select * from institucion where rdb = '$institucion'";
	$res = pg_Exec($conn, $sql);
	$num = pg_numrows($res);
	if ($num>0){
		$fil = pg_fetch_array($res,0);		
	}else{	
	    $fil = 0;
	}	
	return $fil;	

}  

function datos_ano_escolar($id_ano, $conn){
   $sql = "select * from ano_escolar where id_ano = '$id_ano'";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   if ($num>0){
       $fil = pg_fetch_array($res,0);
   }else{
       $fil = 0;
   }
   return $fil;
}   

function datos_subsector($id_ramo, $conn){
   $sql = "select * from subsector where cod_subsector in (select cod_subsector from ramo where id_ramo = '$id_ramo')";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   if ($num>0){
      $fil = pg_fetch_array($res,0);
   }else{
      $fil = 0;
   }
   return $fil;	  	  
}

function datos_ramo($id_ramo, $conn){
   $sql = "select * from ramo where id_ramo = '$id_ramo'";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   if ($num>0){
      $fil = pg_fetch_array($res,0);
   }else{
      $fil = 0;
   }
   return $fil;	  	  
}
function datos_docente($id_ramo, $conn){
   $sql = "select nombre_emp, ape_pat, ape_mat, rut_emp from empleado where rut_emp in (select rut_emp from dicta where id_ramo = '$id_ramo')";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   if ($num>0){
      $fil = pg_fetch_array($res,0);
   }else{
      $fil = 0;
   }
   return $fil;	  	  
}

function datos_ayudante($id_ramo, $conn){
   $sql = "select nombre_emp, ape_pat, ape_mat, rut_emp from empleado where rut_emp in (select rut_emp from ayuda where id_ramo = '$id_ramo')";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   if ($num>0){
      $fil = pg_fetch_array($res,0);
   }else{
      $fil = 0;
   }
   return $fil;	  	  
}

function datos_examen_semestral($id_ramo, $conn){
   $sql = "SELECT * FROM examen_semestral WHERE id_ramo='$id_ramo'";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   $examenes = array();
   for ($i=0; $i < $num; $i++){
       $fila = pg_fetch_array($res,$i);
       $examenes[] = $fila;
   }
   return $examenes;	 	  
}	   	   

function datos_all_docentes($institucion, $conn){
   $sql = "SELECT nombre_emp, ape_pat, ape_mat, rut_emp FROM empleado WHERE rut_emp in (select rut_emp from trabaja where rdb = '$institucion') order by ape_pat, ape_mat, nombre_emp";
   $res = pg_Exec($conn, $sql);
   $num = pg_numrows($res);
   $docentes = array();
   for ($i=0; $i < $num; $i++){
       $fila = pg_fetch_array($res,$i);
       $docentes[] = $fila;
   }
   return $docentes;	 	  
}

function actualiza_por_ramo($datos, $id_ramo, $conn){
    $sub_obli   = $datos['sub_obli'];
	$bool_ip    = $datos['bool_ip'];
	$bool_sar   = $datos['bool_sar'];
	$bool_artis = $datos['bool_artis'];
	$modo_eval  = $datos['modo_eval'];
	$truncado   = $datos['truncado'];
	$tipo_aproximacion  = $datos['tipo_aproximacion'];
	$rut_docente    = $datos['rut_docente'];
	$rut_ayudante   = $datos['rut_ayudante'];
	$elim_ayu       = $datos['elim_ayu'];
	$con_examen     = $datos['con_examen'];
	$prueba_nivel   = $datos['prueba_nivel'];
	$porc_examen    = $datos['porc_examen'];
	$bool_ap        = $datos['bool_ap'];
	
	
	$sql = "UPDATE ramo set sub_obli = '$sub_obli', bool_ip='$bool_ip', bool_sar='$bool_sar', bool_artis='$bool_artis', modo_eval='$modo_eval', truncado='$truncado', tipo_aproximacion = '$tipo_aproximacion', conex = '$con_examen', prueba_nivel = '$prueba_nivel', porc_examen = '$porc_examen'   where id_ramo = '$id_ramo'";
	$res = pg_Exec($conn, $sql);
	
	if ($rut_docente>0){
		$sql_bus1 = "SELECT rut_emp from dicta where rut_emp = '$rut_docente'";
		$res_bus1 = @pg_Exec($conn, $sql_bus1);
		$num_bus1 = @pg_numrows($res_bus1);
		if ($num_bus1>0){
		   // actualizar
		   $sql_doc = "UPDATE dicta set rut_emp = '$rut_docente' where id_ramo = '$id_ramo'";
		   $res_doc = @pg_Exec($conn, $sql_doc);
		}else{
			// ingresar
			$sql_doc = "INSERT into dicta (rut_emp, id_ramo) values ('$rut_docente','$id_ramo')";
			$res_doc = @pg_Exec($conn, $sql_doc);
		}
	}		   
	
	if ($rut_ayudante>0){
	   $sql_bus2 = "SELECT rut_emp from ayuda where rut_emp = '$rut_ayudante'";
	   $res_bus2 = @pg_Exec($conn, $sql_bus2);
	   $num_bus2 = @pg_numrows($res_bus2);
	   if ($num_bus2>0){
	        // actualizar
			$sql_ayu = "UPDATE ayuda set rut_emp = '$rut_ayudante' where id_ramo = '$id_ramo'";
	        $res_ayu = @pg_Exec($conn, $sql_ayu);
	   }else{
	        // insertar
			$sql_ayu = "INSERT into ayuda (rut_emp, id_ramo) values ('$rut_ayudante', '$id_ramo')";
			$res_ayu = @pg_Exec($conn, $sql_ayu);
	   }
    }	
	
	if ($elim_ayu==1){
	    $sql_elim_ayu = "DELETE from ayuda where id_ramo = '$id_ramo' and rut_emp = '$rut_ayudante'";
		$res_elim_ayu = @pg_Exec($conn, $sql_elim_ayu);
	}   			
	
	if ($res){
	   $ok = 0;
	   return $ok;
	}else{
	   $ok = 1;
	   return $ok;
	}    
	
	
}	   	   
?>
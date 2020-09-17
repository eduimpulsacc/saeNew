<?php require('../../../../../util/header.inc');

 	$frmModo		= $_FRMMODO;
	$ano			= $_ANO;
	$institucion	= $_INSTIT;
	$curso			= $_CURSO;
	$ramo			= $_RAMO;
	$plan			= $_PLAN;
		
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];

if ($frmModo=="modificar") {
	     for ($i = 0; $i < $des; $i++ ) { 
		 	if (${"alu".$i}){
				$qryA="SELECT rut_alumno, id_ramo, id_curso FROM tiene$nro_ano  WHERE ((rut_alumno=".trim(${"rut_alu".$i}).") AND (id_ramo=".$_RAMO.") AND (id_curso=".$curso.")) ";
				$resultA =@pg_Exec($conn,$qryA);
				
				if(pg_numrows($resultA)==0){
					$qryT="INSERT INTO tiene$nro_ano (RUT_ALUMNO, ID_RAMO, ID_CURSO) VALUES  (".trim(${"rut_alu".$i}).", ".trim($_RAMO).", ".trim($curso).")";
					$resultT =@pg_Exec($conn, $qryT);
				}
				
				if ($todos_sub==1){   /// ademas inscribir en todos los subsectores
				     $sql = "select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano' and id_curso = '".trim($curso)."')";
					 $res_sql = pg_Exec($conn, $sql);
					 $num_sql = @pg_numrows($res_sql);
					 
					 for ($j=0; $j < $num_sql; $j++){
						  $fil_sql = @pg_fetch_array($res_sql,$j);
						  $id_ramo = $fil_sql['id_ramo'];
						  
						  /// ver que no exista
						  $qryA="SELECT rut_alumno, id_ramo, id_curso FROM tiene$nro_ano  WHERE ((rut_alumno=".trim(${"rut_alu".$i}).") AND (id_ramo=".$id_ramo.") AND (id_curso=".$curso.")) ";
				          $resultA =pg_Exec($conn,$qryA);
						  
						  if(pg_numrows($resultA)==0){
								$qryT="INSERT INTO tiene$nro_ano (RUT_ALUMNO, ID_RAMO, ID_CURSO) VALUES  (".trim(${"rut_alu".$i}).", ".trim($id_ramo).", ".trim($curso).")";
								$resultT =pg_Exec($conn, $qryT);
						  }
						  						  
					 }	  
					 		
				}				
			}
		}

		for ($i = 0; $i <$ins; $i++ ) { 
				if (${"alum".$i}){	 
					$qryA="DELETE  FROM tiene$nro_ano  WHERE ((rut_alumno=".trim(${"rut_alum".$i}).") AND (id_ramo=".$_RAMO.")AND (id_curso=".$curso.")) ";
					$resultA =@pg_Exec($conn,$qryA);
				}
		}	
		
		
		echo "<script>window.location = 'seteaRamoInscribir.php?caso=1&ramo=".$_RAMO."&plan=".$_PLAN."'</script>";
}
?>

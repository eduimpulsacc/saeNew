<? 	require('../../../util/header.inc');


		 
	$id_ano=$_ANO;
	
	$sql="select * from ano_escolar where id_ano=$id_ano";
	$result1=pg_Exec($conn,$sql);
	$fila_ano_actual = @pg_fetch_array($result1,0);
	
	$ano_anterior = $fila_ano_actual['nro_ano']-1;
	
	$sql ="select * from ano_escolar where nro_ano=$ano_anterior and id_institucion = ".$_INSTIT."";
	$result1 = @pg_Exec($conn,$sql);
	$fila_ano_anterior = @pg_fetch_array($result1,0);	
		 
	 

	//Cursos Año Anterior
/*echo "<br>".*/$sql = "SELECT  curso.id_curso,dicta.rut_emp,ramo.id_ramo,subsector.cod_subsector,
	curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.bool_jor,
    curso.truncado_per,curso.truncado_final,curso.truncado_sf,curso.simce,
    curso.acta,curso.observaciones,curso.val_sub,curso.cap_curso 
	FROM curso 
	INNER JOIN ramo on ramo.id_curso = curso.id_curso
	INNER JOIN subsector on subsector.cod_subsector = ramo.cod_subsector
	INNER JOIN dicta on dicta.id_ramo = ramo.id_ramo
	WHERE curso.id_ano = ".$fila_ano_anterior['id_ano']."; ";
	
	
	try{	 
		   $result2 = @pg_Exec($conn,$sql) or die (pg_last_error($conn)."2".$sql);	
		} catch (Exception $e) {
		  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		 }


for($s=0;$s<pg_num_rows($result2);$s++){

 $fila_cursos_anteriores = @pg_fetch_array($result2,$s);			
//****************************************************************

//Cursos Año Actual.
/*echo "<br>".*/$sql = "SELECT curso.id_curso,dicta.rut_emp,ramo.id_ramo,subsector.cod_subsector 
FROM curso 
INNER JOIN ramo on ramo.id_curso = curso.id_curso
INNER JOIN subsector on subsector.cod_subsector = ramo.cod_subsector
LEFT JOIN dicta on dicta.id_ramo = ramo.id_ramo
WHERE 
curso.letra_curso = '".$fila_cursos_anteriores['letra_curso']."' AND 
curso.grado_curso= ".$fila_cursos_anteriores['grado_curso']."AND 
curso.ensenanza= ".$fila_cursos_anteriores['ensenanza']." AND 
curso.id_ano =   ".$fila_ano_actual['id_ano']." AND 
subsector.cod_subsector = ".$fila_cursos_anteriores['cod_subsector']."; ";
       $result3 = pg_Exec($conn,$sql) or die (pg_last_error($conn)."3");
	   $fila_curso_nuevo = pg_fetch_array($result3,0);		 
	   
	   if(pg_numrows($result3)==0){
		   continue;
		   }
//	echo "-->".$fila_curso_nuevo["id_curso"];	

	/****************************PASA CONFIGURACION DE CURSO*******************************/
	
	 
	/*echo "<br>".*/  $qryJ="UPDATE CURSO SET BOOL_JOR='".$fila_cursos_anteriores['bool_jor']."', 
	             truncado_per = '".$fila_cursos_anteriores['truncado_per']."', 
	             truncado_final = '".$fila_cursos_anteriores['truncado_final']."',
				 truncado_sf = '".$fila_cursos_anteriores['truncado_sf']."',
				 simce = '".$fila_cursos_anteriores['simce']."', 
	             acta = '".$fila_cursos_anteriores['acta']."',
				 observaciones = '".$fila_cursos_anteriores['observaciones']."',
				 val_sub = '".$fila_cursos_anteriores['val_sub']."', 
	             cap_curso = '".$fila_cursos_anteriores['cap_curso']."' 
				 WHERE ID_CURSO=".$fila_curso_nuevo['id_curso'];
	   
	    $resultJ =@pg_Exec($conn,$qryJ);
	
	 
	 
	 /************************AQUI TERMINA LA WEA*****************************/

	 
/*echo "<br>".*/  $sql = "SELECT * FROM dicta  WHERE rut_emp=".$fila_cursos_anteriores['rut_emp']." 
AND id_ramo=".$fila_curso_nuevo['id_ramo'].";";
try{	 
        $result4 = pg_Exec($conn,$sql) or die (pg_last_error($conn)."4".$sql);
		
		if(pg_num_rows($result4)==0){
			
/*echo "<br>".*/ $sql = "INSERT INTO dicta( rut_emp,id_ramo ) 
VALUES ( ".$fila_cursos_anteriores['rut_emp'].",".$fila_curso_nuevo['id_ramo']." );";
$result5 = pg_Exec($conn,$sql);

	 }
    
	} catch (Exception $e) {
	  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	 }
	 
	 
//****************************************************************
/*echo "<br>".*/ $sql = "SELECT * FROM supervisa WHERE id_curso = ".$fila_cursos_anteriores['id_curso']."; ";
try{	 
       $result6 = @pg_Exec($conn,$sql) or die (pg_last_error($conn)."6");
	    $fila_supervisa_anterior = @pg_fetch_array($result6,0);		 
    } catch (Exception $e) {
	  echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	 }

/*echo "<br>".*/ $sql = "SELECT * FROM supervisa 
WHERE rut_emp = ".$fila_supervisa_anterior['rut_emp']." AND id_curso = ".$fila_curso_nuevo['id_curso']."; ";

try{	 
        $result7 = pg_Exec($conn,$sql);
		
		//if(pg_num_rows($result7)==0){
		    
		/*echo "<br>".*/	$sql = "INSERT INTO supervisa (  rut_emp,id_curso ) 
            VALUES ( ".$fila_supervisa_anterior['rut_emp'].",".$fila_curso_nuevo['id_curso'].");";
             $result8 = pg_Exec($conn,$sql);
			         
		// }
		 
    } catch (Exception $e) {
	    	
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
	 
	 }
	 
 }

 
 pg_close($conn);
 
 echo "<script>window.location = 'listarAno.php3'</script>"; 
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MIgracion de Profesores al Siguiente Año</title>
</head>
<body>

</body>
</html>
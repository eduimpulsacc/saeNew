<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 
	$usuario		=$_USUARIO;
	
	
	
	$hora 			=date("H:i");
	//if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corporacion =@pg_exec($conn,$sql);
		$corporacion=@pg_result($rs_corporacion,0);
	/*}else{
		$corporacion=$_CORPORACION;
	}*/
	if($corporacion==13){
		$fecha =date('d-m-Y');
	}else{
		$fecha	=date('m-d-Y');
	}
	if($_NOMBREUSUARIO==8776002){
		print_r($_POST);
		exit;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<?
$contador=0;
for ($i=0;$i<$contalum;$i++)
{

	$sql_existe = "select count(*) as cantidad from promocion where rut_alumno = '".$rut_alumno[$i]."' and id_curso = ".$curso;
	$result_existe =@pg_Exec($conn,$sql_existe ) or die (pg_last_error($conn));
	$fila_existe = @pg_fetch_array($result_existe,0);	
	$cantidad = $fila_existe['cantidad'];
	
/*	if ($_PERFIL==0){
	     echo "sql_e: $sql_existe <br><br>";	
		 return;
	}
	*/
	
	$situacion = $situacion_final[$i];
	$alumno = $rut_alumno[$i];
	$nota_final = ${"campo_".$alumno};

	$cont_ramo = ${"cont_ramos".$i};
	for($j=0;$j<$cont_ramo;$j++){
		$ramo = $id_ramo[$contador];
		
		$prom_sub = ${"prom_sub".$contador};
		
		$sql = "SELECT * FROM promedio_sub_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." AND rut_alumno = '".$rut_alumno[$i]."' ";
		$rs_existe = pg_exec($conn,$sql) or die (pg_last_error($conn));
		
		if(pg_numrows($rs_existe)!=0){
			$qry = "UPDATE promedio_sub_alumno SET promedio='".$prom_sub."' WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." AND rut_alumno = '".$rut_alumno[$i]."'";
			$result_promedio = @pg_exec($conn,$qry) or die (pg_last_error($conn));
			
		}else{
			$sql = "INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo, rut_alumno,promedio) VALUES (".$institucion.",".$ano.",".$curso.",".$ramo.",".$rut_alumno[$i].",'".$prom_sub."')";
			$rs_promedio = @pg_exec($conn,$sql) or die (pg_last_error($conn));
		}
		$contador++;
	
	}
	
	
	//if($_PERFIL==0) exit;
	
	if ($cantidad==0){
				
		$sql_insert = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final, observacion,usuario,fecha_prom,hora_prom) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rut_alumno[$i]) . "'," . intval(Trim($nota_final))  . "," . intval(Trim($asistencia[$i])) . "," . $situacion . ",'".$observacion[$i]."','".$usuario."',CURRENT_DATE,'".$hora."')";
		
		
		/*if ($_PERFIL==0 and $rut_alumno[$i]==22087344){
		    echo "Entro 1 <br>".$sql_insert;
			exit;
			
		}
			*/
		
		$result_insert =@pg_Exec($conn,$sql_insert) or die (pg_last_error($conn)."Error : ".$sql_insert );
		
		
	}else{
		
			/*	$sql_insert = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final, observacion,usuario,fecha_prom,hora_prom) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rut_alumno[$i]) . "'," . intval(Trim($nota_final))  . "," . intval(Trim($asistencia[$i])) . "," . $situacion . ",'".$observacion[$i]."','".$usuario."',CURRENT_DATE,'".$hora."')";
		$result_insert =@pg_Exec($conn,$sql_insert) or die (pg_last_error($conn)."Error : ".$sql_insert );*/

		
		$sql_update = "UPDATE promocion SET promedio=" . intval(Trim($nota_final)) . ", asistencia=" . intval(Trim($asistencia[$i])) . ", situacion_final=" . $situacion . ", observacion = '".$observacion[$i]."', usuario='".$usuario."',fecha_prom=CURRENT_DATE, hora_prom='".$hora."' WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rut_alumno[$i])."'";	
		$result_insert =pg_Exec($conn,$sql_update) or die (pg_last_error($conn)."Error : ".$sql_update );	
	    
		/*if ($_PERFIL==0){
		    echo "Entro 2 <br>
			      Sql: $sql_update <br><br>";
				  
				  return;
		}*/
		
	
	}
}

if($_PERFIL===1){
	return;
}else{
	echo "<script>window.location = 'Reprobados.php'</script>";
}



?>
</body>
</html>

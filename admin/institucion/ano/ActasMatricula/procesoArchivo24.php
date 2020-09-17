<?php require('../../../../util/header.inc');?>
<?php 
    //// FUNCION QUE VALIDA EL RUT   ///////
	function validar_dav ($alumno,$dig_rut){	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;		 
		 }				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 }  
		 
		 if ($dig==$dig_rut){
			  $ok=1;  
		 }else{
			  $ok=0;
		 }	
		 return $ok;
		       	 
	}
    //// fin funcion que valida el rut /////



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	
	$sql = "select nro_ano from ano_escolar where id_ano = ".$ano;
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$ano_escolar = trim(pg_result($resultado_query, 0, 0));
	$fecha1 		= $ano_escolar."-04-30"; 		
	
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, curso.id_curso, curso.cod_decreto, curso.bool_jor ";
	$sql = $sql . "FROM institucion, ((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso;";

	$resultado_query1	= pg_exec($conn,$sql);
	$total_filas1		= pg_numrows($resultado_query1);
	
	
	if($num<$total_filas1){
		$ls_string 	= "";
		$salto 		= "\n"; 	 
		$ls_espacio	= chr(9);
		
		//--------------------------------------------------------------------------
		// Respuesta directa de la consulta
		//--------------------------------------------------------------------------
		$Rdb 			= trim(pg_result($resultado_query1, $num, 0));
		$DigRdb 		= trim(pg_result($resultado_query1, $num, 1));
		$TipoEnseñanza	= trim(pg_result($resultado_query1, $num, 2));
		$Grado			= trim(pg_result($resultado_query1, $num, 3));
		$Letra			= trim(pg_result($resultado_query1, $num, 4));
		$AnoEscolar		= trim(pg_result($resultado_query1, $num, 5));
		$RutProfe		= trim(pg_result($resultado_query1, $num, 6));
		$DigProfe		= trim(pg_result($resultado_query1, $num, 7));
		$ApePatProfe	= trim(pg_result($resultado_query1, $num, 8));
		$ApeMatProfe	= trim(pg_result($resultado_query1, $num, 9));
		$NombresProfe	= trim(pg_result($resultado_query1, $num, 10));
		$idCurso		= trim(pg_result($resultado_query1, $num, 11));		 
		$codDecreto		= trim(pg_result($resultado_query1, $num, 12));
		$Jornada		= trim(pg_result($resultado_query1, $num, 13));		 		
		$TipoCurso = 0;
		//------------------------------------------------------------------------
		// Alumnos hombres del curso
		//------------------------------------------------------------------------		
		$sql = "SELECT alumno.rut_alumno, alumno.dig_rut ";
		$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql = $sql . "WHERE (((matricula.id_curso)=".$idCurso.") AND ((alumno.sexo)=2)) and ";
		$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ;";
		
		$resultado_query	= pg_exec($conn,$sql);
		$total_filas		= pg_numrows($resultado_query);
		
		$contador=0;

		for ($i=0; $i < $total_filas; $i++){
			$fila2 = @pg_fetch_array($resultado_query,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_alumno,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
			}
		}	
		
		
		$AlumnosHombres = $contador;
		//$AlumnosHombres = trim(pg_result($resultado_query, 0, 0));
		
		//------------------------------------------------------------------------				
		// Alumnas muejres del curso
		//------------------------------------------------------------------------				
		$sql = "SELECT alumno.rut_alumno, alumno.dig_rut ";
		$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql = $sql . "WHERE (((matricula.id_curso)=".$idCurso.") AND ((alumno.sexo)=1)) and ";
		$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ;";
		
		$resultado_query	= pg_exec($conn,$sql);
		$total_filas		= pg_numrows($resultado_query);
		$contador=0;

		for ($i=0; $i < $total_filas; $i++){
			$fila2 = @pg_fetch_array($resultado_query,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_alumno,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
			}
		}	
		
		$AlumnosMujeres = $contador;
		//$AlumnosMujeres = trim(pg_result($resultado_query, 0, 0));
		
		//------------------------------------------------------------------------				
		// Alumnos hombres de origen indigena
		//------------------------------------------------------------------------				
		$sql = "SELECT Count(*) AS Cantidad ";
		$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql = $sql . "WHERE (((matricula.id_curso)=".$idCurso.") AND ((alumno.sexo)=2) AND ((matricula.bool_i)=1)) and ";
		$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ;";

		$resultado_query	= pg_exec($conn,$sql);
		$total_filas		= pg_numrows($resultado_query);
		$AlumnosHombresIndi = trim(pg_result($resultado_query, 0, 0));
		
		//------------------------------------------------------------------------				
		// Alumnas mujeres de origen indigena
		//------------------------------------------------------------------------				
		$sql = "SELECT Count(*) AS Cantidad  ";
		$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql = $sql . "WHERE (((matricula.id_curso)=".$idCurso.") AND ((alumno.sexo)=1) AND ((matricula.bool_i)=1)) and ";
		$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ;";
		
		$resultado_query	= pg_exec($conn,$sql);
		$total_filas		= pg_numrows($resultado_query);
		$AlumnosMujeresIndi = trim(pg_result($resultado_query, 0, 0));
			
		
		//------------------------------------------------------------------------				
		// Alumnas Embarazadas
		//------------------------------------------------------------------------				
		$sql = "SELECT alumno.rut_alumno, alumno.dig_rut ";
		$sql = $sql . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql = $sql . "WHERE (((matricula.id_curso)=".$idCurso.") AND ((alumno.sexo)=1) AND ((matricula.bool_ae)=1)) and ";
		$sql = $sql . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) ;";

		$resultado_query	= pg_exec($conn,$sql);
		$total_filas		= pg_numrows($resultado_query);
		$contador=0;

		for ($i=0; $i < $total_filas; $i++){
			$fila2 = @pg_fetch_array($resultado_query,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			$ok = validar_dav($rut_alumno,$dig_rut);		
			   
			if ($ok==1){
				$contador++;
			}
		}
		
		$AlumnasEmbara = $contador;
		//$AlumnasEmbara = trim(pg_result($resultado_query, 0, 0));
			
			
			
			
		$sql_curso = "SELECT id_curso FROM institucion, ((curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano)) WHERE (((institucion.rdb)=" . $institucion . ") AND ((curso.id_ano)=" . $ano .")) ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso";
		$Rs_curso = @pg_exec($conn,$sql_curso);
		for($x=0;$x<@pg_numrows($Rs_curso);$x++){
			$fils = @pg_fetch_array($Rs_curso,$x);
			$sql_profe ="SELECT * FROM supervisa WHERE id_curso=". $fils['id_curso'];
			$Rs_profe = @pg_exec($conn,$sql_profe);
			if(@pg_numrows($Rs_profe)==0)
				$Id_Curso=$fils['id_curso'];
		}
		
		if ($Jornada==0){
			echo "<center><font face='Arial Narrow' size='2'><b>FALTA ASIGNAR JORNADA AL CURSO:" . CursoPalabra($idCurso, 0, $conn)." </b></font></center>";
			exit;
		}elseif($Id_Curso!=""){
			echo "<center><font face='Arial Narrow' size='2'><b>FALTA ASIGNAR PROFESOR EN EL CURSO:" . CursoPalabra($Id_Curso, 0, $conn)."</b></font></center>";
			exit;
		}
		$sql = "INSERT INTO archivo24 (nro, rbd, dig_rbd, tipo_ensenanza, grado, letra, ano_escolar, jornada, tipo_curso, nro_hombres, nro_mujeres, nro_hombre_indig, nro_mujer_indig, nro_mujer_emb, rut_profe, dig_profe, apepat_profe, apemat_profe, nombre_profe) VALUES (";
		$sql = $sql. "24, $Rdb , $DigRdb , $TipoEnseñanza, $Grado, '$Letra', $AnoEscolar, $Jornada, $TipoCurso, $AlumnosHombres, ";
		$sql = $sql. " $AlumnosMujeres, $AlumnosHombresIndi, $AlumnosMujeresIndi, $AlumnasEmbara, '$RutProfe', '$DigProfe', '$ApePatProfe', '$ApeMatProfe', '$NombresProfe')";
		$Rs_Archivo = @pg_exec($conn,$sql);
		if (!$Rs_Archivo) {
			echo "<B> ERROR :</b>Error al acceder a la BD. (1).'$sql.'</B>";
			exit;
		}

	}else{
		?>		<script>window.location='Archivo24_txt.php?'</script><?
}
	
pg_close($conn);







?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<input name="indice" type="hidden" value="<? echo $num+1; ?>">
<?
		$num = $num +1;
		$porcentaje = round(($num*100)/$total_filas1,2);
		echo("<br><center><table><tr><td><b><font face='Arial Narrow' size='2'> Porcentaje del proceso completado: $porcentaje %</font></b></td></tr></table></center><br>");?>
		<script> setTimeout("window.location='procesoArchivo24.php?num=<? echo $num; ?>'");</script>
</body>
</html>
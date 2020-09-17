<?php require('../../../../util/header.inc');?>
<?php 

///// consultar si la institucion es de viña del mar
	$sql_vina = "select institucion.region from institucion where rdb = '$_INSTIT'";
	$res_vina = pg_Exec($conn,$sql_vina);
	$fil_reg  = pg_fetch_array($res_vina,0);
	$region   = $fil_reg['region'];	

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
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------		
	$sql = "select curso.id_curso, institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano ";
	$sql = $sql . "from curso, institucion, ano_escolar ";
	$sql = $sql . "where curso.id_ano = ".$ano." and curso.ensenanza > 109 and institucion.rdb = ".$institucion." and ano_escolar.id_ano = ".$ano." ";
	$sql = $sql . "order by curso.ensenanza, curso.grado_curso, curso.letra_curso ";  

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	if ($pagina< $total_filas){
		$fila = @pg_fetch_array($resultado_query,$pagina);
		$rdb = $fila['rdb'];
		$dig_rdb = $fila['dig_rdb'];
		$ensenanza = $fila['ensenanza'];
		$grado = $fila['grado_curso'];
		$letra = $fila['letra_curso'];
		$nro_ano = $fila['nro_ano'];
		$curso = $fila['id_curso'];
		//----------------------------------------------------------------
		// ALUMNOS MATRICULADOS AL 30 DE ABRIL
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno   and  matricula.fecha < '05-01-".$nro_ano."' and id_ano = ".$ano;
		$resultado = pg_exec($conn,$sql);
		
		$num_resultado = @pg_numrows($resultado);

		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
			
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				}
			}	   
			if ($ok==1){
				$contador++;
			}
		}

		$matricula_1 = $contador;
		//----------------------------------------------------------------
		// ALUMNOS MATRICULADOS AL 30 DE NOVIEMBRE
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where id_curso = ".$curso." and matricula.rut_alumno = alumno.rut_alumno and matricula.fecha < '12-01-".$nro_ano."' and matricula.bool_ar=0 and id_ano = ".$ano;
		$resultado = pg_exec($conn,$sql);
		
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				}
			}	    
			if ($ok==1){
				$contador++;
			}
		}
		
		$matriculados = $contador;	
		//----------------------------------------------------------------
		// ALUMNOS APROBADOS
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and promocion.rut_alumno = alumno.rut_alumno  and  promocion.situacion_final = 1";
		$resultado = pg_exec($conn,$sql);
		
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				} 
			}	   
			if ($ok==1){
				$contador++;
			}
		}
		
		$aprobados = $contador;
		//----------------------------------------------------------------
		// ALUMNOS REPROBADOS POR INASISTENCIA
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and  promocion.rut_alumno = alumno.rut_alumno and promocion.situacion_final = 2 and tipo_reprova = 2";
		$resultado = pg_exec($conn,$sql);
		
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				}  
			}	  
			if ($ok==1){
				$contador++;
			}
		}		
		$rep_inasistencia = $contador;
		//----------------------------------------------------------------		
		// ALUMNOS REPROBADOS POR RENDIMIENTO
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from promocion, alumno where promocion.id_curso = ".$curso." and  promocion.rut_alumno = alumno.rut_alumno and promocion.situacion_final = 2 and tipo_reprova = 1";
		$resultado = pg_exec($conn,$sql);
		
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				} 
			}	   
			if ($ok==1){
				$contador++;
			}
		}
		
		$rep_rendimiento = $contador;
		//----------------------------------------------------------------			
		// ALUMNOS ingresados entre el 1º de mayo y el 29 de noviembre
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.rut_alumno = alumno.rut_alumno and id_curso = ".$curso." and (fecha > '04-30-".$nro_ano."' and fecha < '11-30-".$nro_ano."')";
		$resultado = pg_exec($conn,$sql);
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				} 
			}	   
			if ($ok==1){
				$contador++;
			}
		}
		
		
		$ingresados = $contador;
		//----------------------------------------------------------------				
		// ALUMNOS retirados entre el 1º de mayo y el 29 de noviembre
		//----------------------------------------------------------------
		$sql = "select alumno.rut_alumno, alumno.dig_rut from matricula, alumno where matricula.rut_alumno = alumno.rut_alumno and id_curso = ".$curso." and matricula.bool_ar = 1 and (matricula.fecha_retiro > '04-30-".$nro_ano."' and matricula.fecha_retiro < '11-30-".$nro_ano."')";
		$resultado = pg_exec($conn,$sql);
		$num_resultado = @pg_numrows($resultado);
		$contador=0;		
		for ($i=0; $i < $num_resultado; $i++){
			$fila2 = @pg_fetch_array($resultado,$i);
			$rut_alumno = $fila2['rut_alumno'];
			$dig_rut    = $fila2['dig_rut'];
			
			if ($region==5 or $institucion==11209 or $institucion==2163){
			    /// no entra a validar rut
			    $ok = 1;			  
			}else{
				$ok = validar_dav($rut_alumno,$dig_rut);		
				if ($dig_rut==NULL){
				   $ok = 0;
				} 
			}	   
			if ($ok==1){
				$contador++;
			}
		}
		
		$retirados = $contador;
		//----------------------------------------------------------------				
		//  DIRECTOR
		//----------------------------------------------------------------
		if ($institucion !=769){$sql = "select empleado.* from empleado, trabaja where trabaja.rdb = ".$institucion." and empleado.rut_emp = trabaja.rut_emp and trabaja.cargo = 1 ";
		}else
		{
		$sql = "select empleado.* from empleado, trabaja where trabaja.rdb = ".$institucion." and empleado.rut_emp = trabaja.rut_emp and trabaja.cargo ='23' ";
		}
		
		$resultado = pg_exec($conn,$sql);
		$fila2 = @pg_fetch_array($resultado,0);
		$encargado = strtoupper(trim($fila2['nombre_emp']) . " " . trim($fila2['ape_pat']) . " " . trim($fila2['ape_mat']));
		
		//ENCARGADO REAL DEL ACTA CODIGO INGRESADO EL 04-01-2008 POR CRODRIGUEZ
		
		$sql_encargado = "select  rut_emp, nombre_emp, ape_pat, ape_mat from empleado where rut_emp in (select acta from curso where acta = empleado.rut_emp and id_curso=".$curso." )";
		$resultado_encargado = pg_exec($conn,$sql_encargado);
		$fila_enca = pg_fetch_array($resultado_encargado,0);
		$encargado_real = strtoupper(trim($fila_enca['nombre_emp']) . " " . trim($fila_enca['ape_pat']) . " " . trim($fila_enca['ape_mat']));
		
	
		
		//----------------------------------------------------------------	
		// Profesor Jefe
		//----------------------------------------------------------------
		$sql = "select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado, supervisa where supervisa.id_curso = ".$curso." and supervisa.rut_emp = empleado.rut_emp";
		$resultado = pg_exec($conn,$sql);
		$fila2 = @pg_fetch_array($resultado,0);
		$profe_jefe = strtoupper(trim($fila2['nombre_emp']) . " " . trim($fila2['ape_pat']) . " " . trim($fila2['ape_mat']));
		//----------------------------------------------------------------
		$director = $encargado;		
		//----------------------------------------------------------------
		if ($institucion == 9566 ){ 	
			$encargado= "MENESES PAVÉZ ROBERTO";	
		}	
		//----------------------------------------------------------------
		$sqlInsert = "insert into archivo07 (rdb, dig_rdb, ensenanza, grado, letra, ano, indicador1, indicador2, indicador3, indicador4, indicador5, indicador6, indicador7, encargado, fecha_acta, director, profe) ";
		$sqlInsert = $sqlInsert . "values ($rdb, $dig_rdb, $ensenanza, $grado, '$letra', $nro_ano, $matricula_1, $matriculados, $aprobados, $rep_inasistencia, $rep_rendimiento, $ingresados, $retirados, ";
		$sqlInsert = $sqlInsert . "'$encargado_real', '".date("Y/m/d")."', '$director', '$profe_jefe') ";
		$result_insert =@pg_Exec($conn,$sqlInsert);		
	} else {
	      pg_close($conn);				  
		?>		<script>window.location='Archivo07.php?'</script><?
	}
	?>
	<input name="indice" type="hidden" value="<? echo $pagina+1; ?>">
	<?
	$pagina = $pagina+1;
	$porcentaje = round(($pagina*100)/$total_filas,2);
	echo("<br><center><table><tr><td><b><font face='Arial Narrow' size='2'> Porcentaje del proceso completado: $porcentaje %</font></b></td></tr></table></center><br>");
	?>
	<script> setTimeout("window.location='procesoArchivo07.php?pagina=<? echo $pagina; ?>'");</script>


		

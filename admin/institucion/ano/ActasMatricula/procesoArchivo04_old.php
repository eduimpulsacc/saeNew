<?php require('../../../../util/header.inc');?>
<?php 


   ///// consultar si la institucion es de viña del mar
	$sql_vina = "select * from corp_instit where num_corp = '1' and rdb = '$_INSTIT'";
	$res_vina = pg_Exec($conn,$sql_vina);
	$num_vina = pg_numrows($res_vina);	
	
	

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




	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$con			=0;
	//-----------
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------	
	//-----------
	$sql = "select * from curso where id_ano = $ano and ensenanza > 109";

	$rsCurso = pg_exec($conn,$sql);
	$total_filas= pg_numrows($rsCurso);		
	
	if ($num< $total_filas){
			//--
			$fCurso = @pg_fetch_array($rsCurso,$num);	
			$curso = $fCurso['id_curso'];
		//-----------
			$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.id_curso, curso.truncado_per, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, matricula.rut_alumno, alumno.dig_rut, curso.cod_decreto, curso.cod_eval ";
			$sql = $sql . "FROM institucion INNER JOIN ano_escolar ON institucion.rdb = ano_escolar.id_institucion, (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
			$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") and matricula.id_ano = ".$ano.") and curso.ensenanza > 109 and curso.id_curso = $curso and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or ((matricula.bool_ar isnull) or (matricula.bool_ar=0)))";
			$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, matricula.rut_alumno;";  

			$resultado_query= pg_exec($conn,$sql);
			$ls_string = "&nbsp;";
			$salto = "\n"; 	 
			$ls_espacio= chr(9);
			//-------
			$fila 		= @pg_fetch_array($resultado_query,0);
			//--
			for ($yy=0; $yy < pg_numrows($resultado_query); $yy++)
			{
				//--
				$fila_curso = @pg_fetch_array($resultado_query,$yy);			
				//-------
				$curso 		= $fila_curso['id_curso']		;
				$alumno 	= $fila_curso['rut_alumno']	;
				$dig_rut 	= $fila_curso['dig_rut']		;
				$cod_decreto= $fila_curso['cod_decreto']	;
				if ($cod_decreto==5451996) $cod_decreto = 6252003;
				if ($cod_decreto==5521997) $cod_decreto = 6252003;				
				$cod_eval 	= $fila_curso['cod_eval']		;
				$ensenanza 	= $fila_curso['ensenanza']	;
				$rdb 		= $fila_curso['rdb']			;
				$dig_rdb 	= $fila_curso['dig_rdb']		;
				$nro_ano 	= $fila_curso['nro_ano']		;
				$letra 		= trim($fila_curso['letra_curso'])	;
				$grado 		= $fila_curso['grado_curso']	;
				//--
				$sql_subsector 		= "select * from subsector_ramo where id_curso = $curso and (bool_ip = 1 or cod_subsector = 13)";
				$result_subsector	= @pg_exec($conn,$sql_subsector);		
				if (!result_subsector) exit;
			
				//--
				for ($i=0; $i < pg_numrows($result_subsector); $i++)
				{
					//--
					$fila_subsector	= @pg_fetch_array($result_subsector,$i);
					$subsector 		= $fila_subsector['cod_subsector'];
					$ramo 			= $fila_subsector['id_ramo'];
					$examen 		= $fila_subsector['conex'];
					$modo_eval 		= $fila_subsector['modo_eval'];
					if ($fila_curso['truncado_per']>0) $truncado_per = 1; else $truncado_per = 0;
					//--
					$sql_eximido 	= "SELECT count(*) as cantidad	FROM tiene$ano_escolar ";
					$sql_eximido 	= $sql_eximido . "WHERE (((tiene$ano_escolar.rut_alumno)='".$alumno."') AND ((tiene$ano_escolar.id_ramo)=".$ramo.") AND ((tiene$ano_escolar.id_curso)=".$curso.")); ";
					$result_eximido = pg_exec($conn,$sql_eximido);		
					$fila_eximido 	= @pg_fetch_array($result_eximido,0);
					//--
					if ($fila_eximido['cantidad']==0)
					{
						$promedio1 = ""		;
						$promedio2 = ""		;
						$promedio3 = "EX"	;
					}
					else
					{
						$prom 		= 0;
						$cont_prom 	= 0;
						if ($examen==2) // sin exámen
						{
							if ($modo_eval==1)
							{
								$sql_notas = "SELECT notas$nro_ano.promedio FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$ramo."));";
								$result_notas = pg_exec($conn,$sql_notas);
								for ($e=0; $e < pg_numrows($result_notas); $e++)
								{
									$fila_notas = @pg_fetch_array($result_notas,$e);
									$prom = $prom  + $fila_notas['promedio'];
									
									if ($fila_notas['promedio']!=NULL){ 
									$cont_prom = $cont_prom + 1;
								
									
									}
									
									
								}
								if ($prom>0)
									$promedio1 = substr(Promediar($prom,$cont_prom,$truncado_per),0,1).".".substr(Promediar($prom,$cont_prom,$truncado_per),1,1);									
								else
									$promedio1 = "";
															
								$promedio2 = "";
								$promedio3 = "";
							}
							else
							{
								$sql_notas = "SELECT notas$nro_ano.promedio FROM notas$nro_ano WHERE (((notas$nro_ano.rut_alumno)='".$alumno."') AND ((notas$nro_ano.id_ramo)=".$ramo."));";
								$result_notas = pg_exec($conn,$sql_notas);
								for ($e=0; $e < pg_numrows($result_notas); $e++)
								{
									$fila_notas = @pg_fetch_array($result_notas,$e);
									if (trim($fila_notas['promedio'])<>"0")
									{
										$prom = $prom  + Conceptual($fila_notas['promedio'],2);
										$cont_prom = $cont_prom + 1;
									}
								}
								$promedio1 = "";
								if ($prom>0)
									$promedio2 = Conceptual(round($prom / $cont_prom,0),1);
								else
									$promedio2 = "";
								$promedio3 = "";				
							}
						}
						else // con exámen
						{
							$sql_promedio = "SELECT nota_final FROM situacion_final ";
							$sql_promedio = $sql_promedio . "WHERE rut_alumno='".$alumno."' AND id_ramo=".$ramo;
							$result_notas = pg_exec($conn,$sql_promedio);
							$fila_notas = @pg_fetch_array($result_notas,0);
							$promedio1 = substr($fila_notas['nota_final'],0,1).".".substr($fila_notas['nota_final'],1,1);
							$promedio2 = "";
							$promedio3 = "";	
														
						}		
					}
					
					
					if ($num_vina > 0){
					   /// no entra a validar rut
					   $ok = 1;			  
					}else{
							/// validar rut  ///
						/// validar rut  ///
						$ok = validar_dav($alumno,$dig_rut);		
						if ($dig_rut==NULL){
						   $ok = 0;
						}
				    }		
									   
					if ($ok==1){ 
					$sql_insert = "insert into archivo04 (nro, rdb, dig_rdb, ensenanza, grado, letra, nro_ano, alumno, dig_rut, cod_decreto, cod_eval, subsector, promedio1, promedio2, promedio3) values (";
					$sql_insert = $sql_insert . "4, $rdb, $dig_rdb, $ensenanza, $grado, '$letra', $nro_ano, '$alumno', '$dig_rut', $cod_decreto, $cod_decreto, $subsector, '$promedio1', '$promedio2', '$promedio3')";
					$rs = pg_exec($conn,$sql_insert);
					
					}
					
			  }
	  }		  
	} else {
	    pg_close($conn);	
		?>
	 	<script>window.location='Archivo04_txt.php?'</script><?
    }
?>
					
					
					
					<?
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<input name="indice" type="hidden" value="<? echo $num+1; ?>">
<?
		$num = $num +1;
		$porcentaje = round(($num*100)/$total_filas,2);
		
		echo("<br><center><table><tr><td><b><font face='Arial Narrow' size='2'> Porcentaje del proceso completado: $porcentaje %</font></b></td></tr></table></center><br>");?>
		<script> 
		
		setTimeout("window.location='procesoArchivo04.php?num=<? echo $num; ?>'",1);
		
		/*setTimeout("window.location='procesoArchivo04.php?num=<? echo $num; ?>'");*/
        
        
        </script>
</body>
</html>

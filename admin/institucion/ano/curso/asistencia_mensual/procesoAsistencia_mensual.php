<?php 	require('../../../../../util/header.inc');

$curso = $_CURSO;
$ano = $_ANO; 
	
	$qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0);
	$nro_ano=$fila0['nro_ano'];

//	$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat asc";
	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista  ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
	$result	= @pg_Exec($conn,$qry);
	if (!$result){
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$qry);
		}
	$X=0;
	$total_alumnos = @pg_numrows($result);	
	
	for($i=0; $i<pg_numrows($result); $i++){
		$X++;
		$filaAlu	= @pg_fetch_array($result,$i);
		$alu		= $filaAlu['rut_alumno'];		
		for ($z=1 ; $z<=31 ; $z++){
				$dia=$z;
				$vv1="a_".$X."_".$z;				
					if($_POST[$vv1]=="on"){					
						if ($dia < 10){
						 	$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
						}else{
							$fecha=($dia."-".$cmbMes."-".$nro_ano);
						}
						echo $qry2="select * from asistencia_mensual where rut_alumno ='".$alu."' and id_curso=".$curso." and fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							$result2 =pg_Exec($conn,$qry2);
							if (@pg_numrows($result2)!=0){
								$fila=@pg_fetch_array($result2,0);
								$qry7="UPDATE asistencia SET fecha=to_date ('".$fecha."' , 'DD MM YYYY') WHERE RUT_ALUMNO='".$alu."' AND ID_CURSO='".$curso."' AND fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							}else{
								$qry7="INSERT INTO asistencia (RUT_ALUMNO, ID_curso, ano, fecha) VALUES ('".$alu."','".$curso."',".$ano.",to_date('".$fecha."' , 'DD MM YYYY'))";
							}
							$result7 =@pg_Exec($conn,$qry7);
							if (!$result7){
								error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry7);
							}						
					}else{
						if ($_POST[$vv1]==""){
							if ($dia < 10){
							 	$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
							}else{
								$fecha=($dia."-".$cmbMes."-".$nro_ano);
							}
						echo $qry4="select * from asistencia_mensual where rut_alumno ='".$alu."' and id_curso=".$curso." and fecha=to_date ('".$fecha."' , 'DD MM YYYY')";
							$result4 =pg_Exec($conn,$qry4);
								if (@pg_numrows($result4)>0){
									$qry3="delete from asistencia_mensual where rut_alumno='".$alu."' and id_curso=".$curso." and fecha =to_date ('".$fecha."' , 'DD MM YYYY')";
									$result3 =pg_Exec($conn,$qry3);
										if (!$result3){
											error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry3);
										}
								}//numrows
						}//if ($a[$X][$z]=="")
					}//ELSE
	    }//for ($z=1 ; $z<=31 ; $z++)
   }
		
	   // nuevo codigo para agregar informacion a la tabla asistencia_instituciones	
		// aqui entra con cualqueir perfil
		//if (($_PERFIL==0) OR ($_INSTIT == 9566) OR ($_INSTIT == 1450)){	
		    			
			 /*echo "Rdb: $_INSTIT <br>";
		     echo "Id_curso: $curso <br>";
		     echo "Tipo_esenanza: $ensenanza<br>";
		     echo "Id_Periodo: nn <br>";
		     echo "Id_ano: $_ANO <br>";
		     echo "Mes: $cmbMes<br>";
		     echo "Porcentaje: nn <br>";*/			 
			 		 			 
			 for ($z=1 ; $z<=31 ; $z++){
			    $X=1;
				$acomulo = 0;	
				$dia = $z;	
				if ($dia < 10){
					$fecha=("0".$dia."-".$cmbMes."-".$nro_ano);
					$fecha2=($nro_ano."-".$cmbMes."-"."0".$dia);
				}else{
					$fecha=($dia."-".$cmbMes."-".$nro_ano);
					$fecha2=($nro_ano."-".$cmbMes."-".$dia);
				}	
				/// aqui calculo en que periodo estoy segun la fecha
				
				$periodo_pn = 0;			
			    $qryM="select * from periodo where id_ano='".trim($_ANO)."' and fecha_inicio <= '$fecha2' and fecha_termino >= '$fecha2'"; 
			    $resultM    = pg_Exec($conn,$qryM);
			    $filaM      = @pg_fetch_array($resultM,0);
				$periodo_pn = $filaM['id_periodo'];	
				if ($periodo_pn==NULL){
				   $periodo_pn = 0;
				}   		
				
					
				for ($ii=1; $ii<=$total_alumnos; $ii++){
				    $vv1="a_".$X."_".$z;
				    if($_POST[$vv1]=="on"){
					   $acomulo++;
					}					
					$X++;
				}
				
				/// Aqui debo hacer el insert en la tabla
				$asistencia = $total_alumnos - $acomulo;
				$porcentajedia = round((($asistencia * 100) / $total_alumnos),2);
				
				/// consulto si ya existe registro para esta fecha
				$qry_ai = "select * from asistencia_instituciones where rdb = '".trim($_INSTIT)."' and id_curso = '".trim($curso)."' and id_ano = '".trim($_ANO)."' and fecha = to_date ('".$fecha."' , 'DD MM YYYY')";
				$res_ai = @pg_Exec($conn,$qry_ai);
				
				if (pg_numrows($res_ai)==0){
				    // inserto
					$qry_insertar = "insert into asistencia_instituciones (rdb,id_curso,tipo_ensenanza,id_periodo,id_ano,mes,asistencia,ausentes,matricula,porcentaje,fecha)
					values ('".trim($_INSTIT)."','".trim($curso)."','".trim($ensenanza)."','".trim($periodo_pn)."','".trim($_ANO)."','".trim($cmbMes)."','".trim($asistencia)."','".trim($acomulo)."','".trim($total_alumnos)."','".trim($porcentajedia)."',to_date('".$fecha."' , 'DD MM YYYY'))";
					
									
					$res_insertar = pg_Exec($conn,$qry_insertar);
					
				}else{
				    // actualizo
					$qry_act = "update asistencia_instituciones set rdb = '".trim($_INSTIT)."', id_curso = '".trim($curso)."', tipo_ensenanza = '".trim($ensenanza)."', id_periodo = '".trim($periodo_pn)."', id_ano = '".trim($_ANO)."', mes = '".trim($cmbMes)."', asistencia = '".trim($asistencia)."', ausentes = '".trim($acomulo)."', matricula = '".trim($total_alumnos)."', porcentaje = '".trim($porcentajedia)."', fecha=to_date ('".$fecha."' , 'DD MM YYYY') where rdb = '".trim($_INSTIT)."' and id_curso = '".trim($curso)."' and id_ano = '".trim($_ANO)."' and fecha = to_date ('".$fecha."' , 'DD MM YYYY')";
					$res_act = pg_Exec($conn,$qry_act);			
								
				}				
				
				/*echo "Periodo : $periodo_pn <br>";
				echo "Asistencia dia $z : $asistencia <br>";
				echo "Ausentes dia $z : $acomulo <br>";
				echo "Matricula dia $z : $total_alumnos <br>";
				echo "Fecha   : $fecha <br>";
				echo "Porcentaje dia $z : $porcentajedia<br><br><br>";*/	
				
			 }			 
			 //exit();	 
		//}
	
?>		
<script>window.location ="seteaAsistencia_mensual.php?caso=2"</script>












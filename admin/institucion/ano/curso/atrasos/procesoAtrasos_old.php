<?php
require('../../../../../util/header.inc');

	if($_INSTIT==11209 ){
		
//		
		}
		//var_dump($_POST);
		//$on =$_POST['on'];
		//$separa = explode('_',$on);
		
		//echo"rut->".$separa['1'];
		
	
		
		
$curso = $_CURSO;
$ano = $_ANO;
$institucion =$_INSTIT;

	 $qry_user = "select nombre_usuario from usuario where ID_USUARIO = '$_USUARIO'";
	$res_user = pg_Exec($conn,$qry_user);
	$fila_user = pg_fetch_array($res_user);
	//$usuario = trim($fila_user['nombre_usuario']);
	$usuario = $_NOMBREUSUARIO;
	 $qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0); 
	$nro_ano=$fila0['nro_ano'];
	
//Nombres de los alumnos
	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND matricula.rdb='".$institucion."' AND ((matricula.bool_ar=0)or(matricula.bool_ar is null))) ";
 	$qry = $qry . "ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
	
	//echo "<br>".$qry;
	
	$res = pg_Exec($conn,$qry);
	
	
	
	for($i=0;$i<pg_numrows($res);$i++)
	{
	//$ar_at = "";
	$fila_alu = pg_fetch_array($res,$i);
	$rut_alumno = $fila_alu['rut_alumno'];
	$fechaMin = $nro_ano."-".$cmbMes."-"."01";
	$fechaMax = $nro_ano."-".$cmbMes."-".$diaFinal;
	/*echo "<br>". */
	
	
	$qry_fecha = "delete from anotacion where rut_alumno = '$rut_alumno' and tipo = 2 and fecha <= '$fechaMax' and fecha >= '$fechaMin' and jornada=".$jornada; //Selecciono todos los dias del mes actual
	$res_fecha = pg_Exec($conn,$qry_fecha)or die("fallox");
	
		for($x=1;$x<=$diaFinal;$x++)
		{	
			$alu = "alu_".$i."_".$x;
			if($x<10)$d="0".$x; else $d=$x;
			if($_POST[$alu]=="on")
			{
		
				$fila_alu['nombre_alu']."".$fila_alu['ape_pat']."".$fila_alu['ape_mat']."".$fila_alu['rut_alumno']."<br>";					
					//if($x<10)$d="0".$x; else $d=$x;
					//$fecha = " ".$nro_ano."-".$cmbMes."-".$d;
					
					
					/*if(pg_dbname($conn)=="coi_corporaciones" || pg_dbname($conn)=="coi_final" ){
						//$fecha = " ".$cmbMes."-".$d."-".$nro_ano;
						$fecha = " ".$cmbMes."-".$d."-".$nro_ano;
					}else
					if(pg_dbname($conn)=="coi_antofagasta"){
						//$fecha = " ".$d."-".$cmbMes."-".$nro_ano;
						$fecha = " ".$nro_ano."-".$cmbMes."-".$d;
					}
					elseif (pg_dbname($conn)=="coi_final_vina")
					{					      
						$fecha = " ".$nro_ano."-".$cmbMes."-".$d;
					}
					
					else{
						//$fecha = " ".$cmbMes."-".$d."-".$nro_ano;
						$fecha = " ".$d."-".$cmbMes."-".$nro_ano;
					}*/
					
					 $fecha =$nro_ano."-".$cmbMes."-".$d;
					
					
					
					//$nro_ano;  //A�O!!!
					//$cmbMes;  // MES!!!
					
					
					
					$qry_max = "select max(id_anotacion) from anotacion";
					$res_max = pg_Exec($conn,$qry_max);
					$fila_max = pg_fetch_array($res_max);
					$id_max = $fila_max['max']+1;
					
					
				     $qry_periodo = "select id_periodo from periodo where id_ano = $ano and fecha_inicio <= '$fecha' and fecha_termino >= '$fecha'";
					$res_periodo = pg_Exec($conn, $qry_periodo)or die("F1");
					$fila_periodo = pg_fetch_array($res_periodo,0);
				    $periodo = $fila_periodo['id_periodo'];
					if($periodo!=""){
					if($usuario=='admin'){
					
					  $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,id_periodo,jornada) values ('$id_max',2,'$fecha','Atrasado','$rut_alumno','$periodo','$jornada')";
					}else{
					 $qry_add = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,rut_emp,id_periodo,jornada) values ('$id_max',2,'$fecha','Atrasado','$rut_alumno','$usuario','$periodo','$jornada')";	
					}
					
						//if($_PERFIL==0){echo $qry_add;}
						$res_add = pg_Exec($conn,$qry_add)or die("f".$qry_add);
					}					
			}else{
				
			   $fecha2 =$nro_ano."-".$cmbMes."-".$d;
			 $sql_delfecha = "delete from justifica_atraso where rut_alumno = $rut_alumno and fecha='$fecha2'";
			$res_jus = pg_Exec($conn,$sql_delfecha)or die("f".$sql_delfecha);
			}
			//echo $qry_add;
			
				
		}
		//echo $ar_at = substr($ar_at,-1);
		
	}

pg_close($conn);
pg_close($connection);
	//var_dump($ar_at);
	//if($_INSTIT==11209){
	//	}else{
	 
	echo "<script>window.location = 'seteaAtrasos.php?caso=2'</script>";	
		//}
?>
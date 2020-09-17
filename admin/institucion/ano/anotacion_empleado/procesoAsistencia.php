<?php
require('../../../../util/header.inc');
//$curso = $_CURSO;
$ano = $_ANO;
$institucion = $_INSTIT;

	$qry_user = "select nombre_usuario from usuario where ID_USUARIO = '$_USUARIO'";
	$res_user = pg_Exec($qry_user);
	$fila_user = pg_fetch_array($res_user);
	$usuario = trim($fila_user['nombre_usuario']);
	
	$qry0="select nro_ano from ano_escolar where id_ano=".$ano;
	$result0=@pg_Exec($conn,$qry0);
	$fila0	= @pg_fetch_array($result0,0);
	$nro_ano=$fila0['nro_ano'];
	
//Nombres del personal
	 $qry="SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp asc ";
	$res = pg_Exec($qry);
	$rut_existe[]="";
	$t=0;
	
	for($i=0;$i<pg_numrows($res);$i++)
	{
		$t++;
	$fila = pg_fetch_array($res,$i);	
	if(in_array($fila[rut_emp],$rut_existe)){}
	else{
	$rut_existe[]=$fila[rut_emp]; 
	$rut_alumno = $fila['rut_emp'];
	$fechaMin = $nro_ano."-".$cmbMes."-"."01";
	$fechaMax = $nro_ano."-".$cmbMes."-".$diaFinal;
	
	 $qry_fecha = "delete from anotacion_empleado where rut_emp = '$rut_alumno' and tipo = 2 and fecha <= '$fechaMax' and fecha >= '$fechaMin'"; //Selecciono todos los dias del mes actual
	$res_fecha = pg_Exec($qry_fecha);
	
		for($x=1;$x<=$diaFinal;$x++)
		{	
		$X++;
		
			$alu = "alu_".$t."_".$x;
			if($_POST[$alu]=="on")
	/*	$alu = "a".$i."_".$x;
			if($_POST[$a]=="on")*/
			{
				
				
//echo				$fila_alu['nombre_alu']."".$fila_alu['ape_pat']."".$fila_alu['ape_mat']."".$fila_alu['rut_alumno']."<br>";					
					if($x<10)$d="0".$x; else $d=$x;
					$fecha = " ".$nro_ano."-".$cmbMes."-".$d;
					//echo $fecha;
					$nro_ano;  //AÑO!!!
					$cmbMes;  // MES!!!
					
					 $qry_max = "select max(id_anotacion) from anotacion_empleado";
					$res_max = pg_Exec($qry_max);
					$fila_max = pg_fetch_array($res_max);
					$id_max = $fila_max['max']+1;
					
					$qry_periodo = "select id_periodo from periodo where id_ano = $ano and fecha_inicio <= '$fecha' and fecha_termino >= '$fecha'";
					$res_periodo = pg_Exec($conn, $qry_periodo);
					$fila_periodo = pg_fetch_array($res_periodo);
					$periodo = $fila_periodo['id_periodo'];
					if($periodo!=""){

							$qry_add = "insert into anotacion_empleado(id_anotacion,tipo,fecha,rut_emp,id_periodo,rdb) values ('$id_max',2,'$fecha','$rut_alumno','$periodo','$institucion')";
					
						$res_add = pg_Exec($qry_add);
					}					
			}
		}
	}
	}
pg_close($conn);	
echo "<script>window.location = 'seteaAsistencia.php?caso=2'</script>";	

?>
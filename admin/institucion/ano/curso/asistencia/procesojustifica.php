<?php 	require('../../../../../util/header.inc');

$curso = $_CURSO;
$ano = $_ANO;


				if ($cmbMes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if(($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if($cmbMes==1){ 
						$diaFinal=31; 
						$mes="01";
					}
					if($cmbMes==2){ 
						$mes="02";
					}
					if($cmbMes==3){ 
						$diaFinal=31; 
						$mes="03";
					}
					if($cmbMes==4){ 
						$diaFinal=30; 
						$mes="04";
					}
					if($cmbMes==5){ 
						$diaFinal=31; 
						$mes="05";
					}
					if($cmbMes==6){ 
						$diaFinal=30; 
						$mes="06";
					}
					if($cmbMes==7){ 
						$diaFinal=31; 
						$mes="07";
					}
					if($cmbMes==8){ 
						$diaFinal=31; 
						$mes="08";
					}
					if($cmbMes==9){ 
						$diaFinal=30; 
						$mes="09";
					}
					if($cmbMes==10){ 
						$diaFinal=31; 
						$mes="10";
					}
					if($cmbMes==11){ 
						$diaFinal=30; 
						$mes="11";
					}
					if($cmbMes==12){ 
						$diaFinal=31; 
						$mes="12";
					}
					//FIN AJUSTA
				}
					
	 //Nombres de todos los alumnos				
	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ";
	$qry = $qry . "ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$res = pg_Exec($conn, $qry);
	$tot_alum = pg_numrows($res);
//Inasistencias por alumno
	$qry_ano = "select * from ANO_ESCOLAR where id_ano = '$_ANO'";
	$res_ano = pg_Exec($conn, $qry_ano);
	$fila_ano = pg_fetch_array($res_ano);
	$fila_ano['nro_ano'];
	
	$_CURSO;	
	
	$fecha_ini = $fila_ano['nro_ano']."-".$mes."-"."01";
	$fecha_fin = $fila_ano['nro_ano']."-".$mes."-".$diaFinal;
		
	
	$qry1 = "DELETE FROM justifica_inasistencia WHERE ano = '$ano' AND id_curso = '$curso' AND fecha >= '$fecha_ini' AND fecha <= '$fecha_fin'";
	$res1 = pg_Exec($qry1);

		
for($x=0;$x < $tot_alum; $x++){
	$alumnos = pg_fetch_array($res);
	$rut_alumno = $alumnos['rut_alumno'];
	
	
		
	//$qry2 = "SELECT * FROM asistencia WHERE id_curso = '".trim($_CURSO)."' AND rut_alumno = '".trim($rut_alumno)."' AND ano = '".trim($ano)."' AND fecha >= '".trim($fecha_ini)."' AND fecha <= '".trim($fecha_fin)."' ORDER BY rut_alumno";
	$qry2 = "SELECT * FROM asistencia WHERE id_curso = $_CURSO AND rut_alumno = '$rut_alumno' AND ano = '$ano' AND fecha >= '$fecha_ini' AND fecha <= '$fecha_fin' ORDER BY rut_alumno";

	$res2 = @pg_Exec($qry2);
	
	$num2 = @pg_numrows($res2);
	if(@pg_numrows($res2)!=0){
		for($z=0;$z<pg_numrows($res2);$z++){
			$fila_inasistencia = pg_fetch_array($res2,$z);
			$fech_inasist = $fila_inasistencia['fecha'];
			$separa = explode("-",$fech_inasist);
			$justifica = $rut_alumno."_".$separa[2];
			
			if($_POST[$justifica]=="on"){
				$sql = " insert into justifica_inasistencia (rut_alumno, ano, id_curso, fecha) values ('$rut_alumno','$ano','$curso','$fech_inasist')";
				$res_sql = pg_Exec($sql);
			}
		}	
	}
}

$_FRMMODO = "mostrar";?>
<script language="javascript">window.location="justifica_inasistencia.php?cmbMes=<?=$mes?>"</script>			
	
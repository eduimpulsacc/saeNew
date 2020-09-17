<?php require('../../../../../util/header.inc');?>
<?php
	

$institucion	=$_INSTIT; 


$mes = $_GET['mes'];

$getCurso = $_GET['curso'];

$getAno = $_GET['ano'];


$fecha=getdate();
$diaActual=$fecha["mday"];

				if ($mes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if(($mes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if($mes==01){ 
						$diaFinal=31; 
						$mesDate="01";
					}
					if($mes==02){ 
						$mesDate="02";
					}
					if($mes==03){ 
						$diaFinal=31; 
						$mesDate="03";
					}
					if($mes==04){ 
						$diaFinal=30; 
						$mesDate="04";
					}
					if($mes==05){ 
						$diaFinal=31; 
						$mesDate="05";
					}
					if($mes==06){ 
						$diaFinal=30; 
						$mesDate="06";
					}
					if($mes==07){ 
						$diaFinal=31; 
						$mesDate="07";
					}
					if($mes==08){ 
						$diaFinal=31; 
						$mesDate="08";
					}
					if($mes==09){ 
						$diaFinal=30; 
						$mesDate="09";
					}
					if($mes==10){ 
						$diaFinal=31; 
						$mesDate="10";
					}
					if($mes==11){ 
						$diaFinal=30; 
						$mesDate="11";
					}
					if($mes==12){ 
						$diaFinal=31; 
						$mesDate="12";
					}
					//FIN AJUSTA
				}


	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$getCurso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ";
	$qry = $qry . "ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$res_alu = pg_Exec($conn, $qry);
	$tot_alum = pg_numrows($res_alu);


	$qry_ano = "select * from ANO_ESCOLAR where id_ano = '$getAno'";
	$res_ano = pg_Exec($conn, $qry_ano);
	$fila_ano = pg_fetch_array($res_ano);
	$fila_ano['nro_ano'];

	
	$fecha_ini = $fila_ano['nro_ano']."-".$mesDate."-"."01";
	$fecha_fin = $fila_ano['nro_ano']."-".$mesDate."-".$diaFinal;



if ($mes == 01) {
	$mes = 'Enero';
}else if ($mes == 02) {
	$mes = 'Febrero';
}else if ($mes == 03) {
	$mes = 'Marzo';
}else if ($mes == 04) {
	$mes = 'Abril';
}else if ($mes == 05) {
	$mes = 'Mayo';
}else if ($mes == 06) {
	$mes = 'Junio';
}else if ($mes == 07) {
	$mes = 'Julio';
}else if ($mes == 08) {
	$mes = 'Agosto';
}else if ($mes == 09) {
	$mes = 'Septiembre';
}else if ($mes == 10) {
	$mes = 'Octubre';
}else if ($mes == 11) {
	$mes = 'Noviembre';
}else if ($mes == 12) {
	$mes = 'Diciembre';
}

$curso = CursoPalabra($getCurso, 1, $conn);
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>JUSTIFICAR INASISTENCIA</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="window.print(); ">
	<style type="text/css">
	.tableIndex{
		FONT-WEIGHT: bold;
    	FONT-SIZE: 12px;
    	COLOR: #ffffff;
    	TEXT-INDENT: 5px;
    	BACKGROUND-REPEAT: repeat-x;
    	FONT-FAMILY: Geneva, Arial, Helvetica, sans-serif;
    	HEIGHT: 39px;
    	BACKGROUND-COLOR: #414458;
    	TEXT-ALIGN: center;
    	TEXT-DECORATION: none;
	}
		
	</style>
	<table width="90%" align="center">
		<tr>
			<td class="tableIndex" width="100%">JUSTIFICAR INASISTENCIA</td>
		</tr>
	</table>
	<table width="90%" align="center">
		<tr>
			<td width="80%">
				<table width="50%">
					<tr>
						<td width="5%">
							Curso:
						</td>
						<td>
							<?php echo $curso ?>
						</td>
					</tr>
					<tr>
						<td width="5%">
							Mes: 
						</td>
						<td>
							<?php echo $mes ?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td align="center" width="5%">
							<img src="vb.gif">				
						</td>
						<td>
							<span>Justificados</span>
						</td>
					</tr>
					<tr>
						<td align="center" width="5%">
							<img src="b_drop.png">
						</td>
						<td>
							<span>No justificados</span>
						</td>
					</tr>
					<tr>
						<td align="center" bgcolor="#cccccc" width="5%">
							N&deg;
						</td>
						<td>
							<span>D&iacute;a de la inasistencia</span>
						</td>
					</tr>
				</table>
			</td>
			<td width="20%" valign="top">
		<?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' width='80' height='80' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }

		}?>

			</td>
		</tr>
	</table>
	<table>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>
	<table border="1" width="90%" align="center">
<?php  

	$msj = false;

  

	for($xa=0; $xa < $tot_alum; $xa++){
		$alumnos = pg_fetch_array($res_alu);
		$rut_alumno = $alumnos['rut_alumno'];
		 

		$qry2 = "SELECT * FROM asistencia WHERE id_curso = $getCurso AND rut_alumno = '$rut_alumno' AND ano = '$getAno' AND fecha >= '$fecha_ini' AND fecha <= '$fecha_fin' ORDER BY rut_alumno";
		$res2 = @pg_Exec($qry2);		
		if(@pg_numrows($res2)!=0){
		$msj = true; ?>
			<tr>			
				<td><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?> <?=$rut_alumno ?></td>
<?php			for($z=0;$z<pg_numrows($res2);$z++){
				$fila_inasistencia = pg_fetch_array($res2,$z);
				$fech_inasist = $fila_inasistencia['fecha'];
				$separa = explode("-",$fech_inasist);

				$qry3 = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = '$rut_alumno' AND ano = '$getAno' AND id_curso = $getCurso AND fecha = '$fech_inasist'";
				$res3 = pg_Exec($qry3);
				 pg_numrows($res3);
				?>
					<td align="center" width="40"><?=$separa[2]?><br>
						<?php if(pg_numrows($res3)==0){?>
							<img src="b_drop.png">
						<?php }else{?>
							<img src="vb.gif">
						<?php }?>						
					</td>
			
		<?php 		
			} ?>
			</tr>
<?php		}
	}	?>		
</table>
<table>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
</table>
<? if($msj==false){?>
<br><br><br><br>
	<DIV align="center" style="FONT-WEIGHT: bold;
    FONT-SIZE: 11px;
    COLOR: #999999;
    FONT-STYLE: normal;
    FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif;
    TEXT-DECORATION: none;">NO SE REGISTRAN INASISTENCIAS</DIV>
<? } ?>
</body>
</html>
<?php 	require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;

	$fecha=getdate();
	$diaActual=$fecha["mday"];	
	
	//AQUI TOMO LOS PRIMEROS DATOS
	$q1="SELECT * FROM INSTITUCION WHERE RDB = '$_INSTIT'";
	$r1 =pg_Exec($conn,$q1);
	$n1 = pg_numrows($r1);
	
	if ($n1 == 0){
	   //echo "no hay elementos encontrados";
	}else{
	   $f1 = pg_fetch_array($r1,0);
	}
	
	
	
	
	$q2="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$r2 =pg_Exec($conn,$q2);
	
	if (!$r2) {
		error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
	}else{
		if (pg_numrows($r2)!=0){
			$f2 = pg_fetch_array($r2,0);
			if (!$f2){
				error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				exit();
		    }
			$nroAno=trim($f2['nro_ano']);
		}
	}
	
	
	
	$q3="SELECT * FROM CURSO WHERE ID_CURSO=".$curso;
	$r3 =@pg_Exec($conn,$q3);
	if (!$r3) {
		error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
	}else{
		if (pg_numrows($r3)!=0){
			$f3 = @pg_fetch_array($r3,0);	
			if (!$f3){
				error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
				exit();
			}
			$q4="select nombre_tipo from tipo_ensenanza where cod_tipo=".$f3[ensenanza];
			$r4 =@pg_Exec($conn,$q4);
			if (!$r4) {
				error('<B> ERROR :</b>Error al acceder a la BD. (53)</B>');
			}else{
				if (pg_numrows($r4)!=0){
					$f4 = @pg_fetch_array($r4,0);	
					if (!$f4){
					    error('<B> ERROR :</b>Error al acceder a la BD. (54)</B>');
						exit();
					}
				}
			}
			
		}
		$nombrecurso =$f3['grado_curso'];
		$nombrecurso.="-";
		$nombrecurso.=$f3['letra_curso'];
		$nombrecurso.="  ";
		$nombrecurso.=$f4['nombre_tipo'];
	}
	
$dia = substr($fechac,0,2);
$mes = substr($fechac,3,2);
$fechaa = $nroAno."-".$mes."-".$dia;


  $sql_inasig = "select rut_alumno, id_ramo, hora from inasistencia_asignatura where id_curso = '$curso' and fecha = '$fechaa' and ano = '$ano'";
  $res_inasig = @pg_Exec($sql_inasig);
  $num_inasig = @pg_num_rows($res_inasig);
	for($y=0;$y<$num_inasig;$y++)
	{
		$fila_inasig = pg_fetch_array($res_inasig, $y);
		$sql_inasis = "delete from inasistencia_asignatura where ano = '".trim($ano)."' and fecha = '".trim($fechaa)."' and rut_alumno = '$fila_inasig[rut_alumno]' and id_ramo ='$fila_inasig[id_ramo]' and hora='$fila_inasig[hora]'";
		$res_inasis = pg_Exec($conn, $sql_inasis);	 	
	}	   
	
for($i=0; $i<=$cont_fin; $i++)
{	  

	if($datos[$i]!="")	
	{		

		$separa = explode("_", $datos[$i]);
		$rut_alumno = $separa[0];
		$id_ramo = $separa[1];
		$horaini = $separa[2];	


		$q8 = "insert into inasistencia_asignatura (rut_alumno, ano, id_curso, fecha, id_ramo, hora)
		values ('$rut_alumno','$ano','$curso','$fechaa','$id_ramo','$horaini')";
		$r8 = pg_Exec($conn,$q8);	
	}
}

?>
<script language="javascript">
	alert("Los datos se ingresaron exitosamente")
	window.location="inasistencia.php";	
</script>
<?
/*
$sql_inasis = "delete from inasistencia_asignatura where ano = '".trim($ano)."' and fecha = '".trim($fechaa)."'" ;
$res_inasis = pg_Exec($conn, $sql_inasis);

	
}	
		
for($i=0; $i<=$cont_fin; $i++)
{	  

	if($datos[$i]!="")
	{
		$datos[$i];		
		
						
		$separa = explode("_", $datos[$i]);
		$rut_alumno = $separa[0];
		$id_ramo = $separa[1];
		$horaini = $separa[2];
		
		// aqui muestro loq ue se ha insertado
		if ($_PERFIL==0){
//		    echo "rut_alumno = $rut_alumno <br>";
//			echo "id_ano = $id_ano <br>";
//			echo "horaini = $horaini <br>";
//			echo "id_curso = $id_curso <br>";
//			echo "fechaa = $fechaa <br>";
//			echo "id_ramo = $id_ramo <br><br><br>";
		}
					
		
//		$sql_inasis = "select * from inasistencia_asignatura where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo' and ano = '$ano' and fecha = '$fechaa' and hora = '$horaini'";
//		$res_inasis = pg_Exec($conn, $sql_inasis);


//		if(pg_numrows($res_inasis)=="")		
	//	{
			// ACA INGRESO LA INFORMACION EN LA TABLA.
			$q8 = "insert into inasistencia_asignatura (rut_alumno, ano, id_curso, fecha, id_ramo, hora)
			values ('$rut_alumno','$ano','$curso','$fechaa','$id_ramo','$horaini')";
			$r8 = pg_Exec($conn,$q8);
	//	}else{
	//		echo "se encunetra";
	//	}
	} 
}




*/
?>

	
	


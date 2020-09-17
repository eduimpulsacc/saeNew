<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if($tipo_hoja!=1){
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	}else{
	/****************VARIABLES PARA HOJA DE VIDA****************/
	$ano			=$_GET['c_ano'];
	$alumno			=$_GET['c_alumno'];
	$c_curso		=$_GET['c_curso'];
	/**********************************/
	}
	$idFicha		=$_FICHAM;
	$_POSP          = 5;
	
	
	if (isset($eli) and $eli>0){
	    if ($eli==1){
		   $sql_2 = "delete from psico_avance where id_avance = '$id' and rut_alumno = '$alumno'";
		   $res_2 = @pg_Exec($conn, $sql_2);		   
		}
		if ($eli==2){
		   $sql_1 = "delete from psico_comple where id_comple = '$id' and rut_alumno = '$alumno'";
		   $res_1 = @pg_Exec($conn, $sql_1);
		}
		if ($eli==3){
		   $sql_3 = "delete from psico_asistencia where id_asistencia = '$id' and rut_alumno = '$alumno'";
		   $res_3 = @pg_Exec($conn, $sql_3);
		}
		if ($eli==4){
		   $sql_4 = "delete from psico_citacion where id_citacion = '$id' and rut_alumno = '$alumno'";
		   $res_4 = @pg_Exec($conn, $sql_4);
		}
		
		echo "<script>window.location='fichaPsicopedagogica.php'</script>";
		exit();
		
	}	
	
	
	
	
	
	$proceso = $_POST['proceso'];
	$fecha_ini_part   = $_POST['fecha_ini_part'];
	$fecha_fin_part   = $_POST['fecha_fin_part'];
	$horario_clase    = $_POST['horario_clases'];
	
	$fecha_avance     = $_POST['fecha_avance'];
	$com_avance       = $_POST['com_avance'];
	
	$fecha_comp       = $_POST['fecha_comp'];
	$com_comp         = $_POST['com_comp'];
	
	
	$fecha_asistencia = $_POST['fecha_asistencia'];
	$asiste           = $_POST['asiste'];
	$com_asis         = $_POST['com_asis'];
	
	
	$fecha_apo        = $_POST['fecha_apo'];
	$asiste_apo       = $_POST['asiste_apo'];
	$com_apo          = $_POST['com_apo'];
	
	// actualizamos los valores en Alumno
	if ($fecha_ini_part!=NULL){
	    $dd = substr($fecha_ini_part,0,2);
		$mm = substr($fecha_ini_part,3,2);
		$aa = substr($fecha_ini_part,6,4);
		$fecha_ini_part = "$aa-$mm-$dd";
		
	    $sql_up_alu = "update alumno set psico_inicio = '$fecha_ini_part' where rut_alumno = '$_ALUMNO'";
		$res_up_alu = @pg_Exec($conn, $sql_up_alu);
	}
	
	if ($fecha_ini_part==NULL){
	    $sql_up_alu = "update alumno set psico_inicio = null where rut_alumno = '$_ALUMNO'";
		$res_up_alu = @pg_Exec($conn, $sql_up_alu);
	}
	
	
	
	if ($fecha_fin_part!=NULL){
	    $dd = substr($fecha_fin_part,0,2);
		$mm = substr($fecha_fin_part,3,2);
		$aa = substr($fecha_fin_part,6,4);
		$fecha_fin_part = "$aa-$mm-$dd";
		
	    $sql_up_alu2 = "update alumno set psico_fin = '$fecha_fin_part' where rut_alumno = '$_ALUMNO'";
		$res_up_alu2 = @pg_Exec($conn, $sql_up_alu2);
	}
	
	if ($fecha_fin_part==NULL){
	    $sql_up_alu2 = "update alumno set psico_fin = null where rut_alumno = '$_ALUMNO'";
		$res_up_alu2 = @pg_Exec($conn, $sql_up_alu2);
	}
	
	
	
	$sql_up_alu3 = "update alumno set psico_proceso = '$proceso', psico_horario = '$horario_clase' where rut_alumno = '$_ALUMNO'";
	$res_up_alu3 = @pg_Exec($conn, $sql_up_alu3);
	
	
	
	if ($fecha_avance!=NULL and $com_avance!=NULL){
	    // graba en tabla psico_avance
		$dd = substr($fecha_avance,0,2);
		$mm = substr($fecha_avance,3,2);
		$aa = substr($fecha_avance,6,4);
		$fecha_avance = "$aa-$mm-$dd";
		
	    $sql_ava = "insert into psico_avance (fecha, comentario, rut_alumno) values ('$fecha_avance','$com_avance','$_ALUMNO')";
		$res_ava = @pg_Exec($conn, $sql_ava);
	}
	
	if ($fecha_comp!=NULL and $com_comp!=NULL){
	    // graba en tabla psico_avance
		$dd = substr($fecha_comp,0,2);
		$mm = substr($fecha_comp,3,2);
		$aa = substr($fecha_comp,6,4);
		$fecha_comp = "$aa-$mm-$dd";
		
	    $sql_comp = "insert into psico_comple (fecha, comentario, rut_alumno) values ('$fecha_comp','$com_comp','$_ALUMNO')";
		$res_comp = @pg_Exec($conn, $sql_comp);
		
		$file_name     = $_FILES['file']['name'];
		$file_size     = $_FILES['file']['size'];
		$file_tmp_name = $_FILES['file']['tmp_name'];
		
		if ($file_size>0){
		    // ingresar archivo
			if (copy($file_tmp_name,"../files/".$file_name)){
			    // actualizo
				$sql_index = "select id_comple from psico_comple order by id_comple desc limit 1";
				$res_index = @pg_Exec($conn, $sql_index);
				$fil_index = @pg_fetch_array($res_index,0);
				$id_comple = $fil_index['id_comple'];
				
				$sql_up = "update psico_comple set file = '$file_name' where id_comple = '$id_comple'";
			}
		 }		
	}
	
	if ($fecha_asistencia!=NULL and $com_asis!=NULL){
	    // graba en tabla psico_avance
		$dd = substr($fecha_asistencia,0,2);
		$mm = substr($fecha_asistencia,3,2);
		$aa = substr($fecha_asistencia,6,4);
		$fecha_asistencia = "$aa-$mm-$dd";
		
	    $sql_asis = "insert into psico_asistencia (fecha, comentario, rut_alumno, asiste) values ('$fecha_asistencia','$com_asis','$_ALUMNO','$asiste')";
		$res_asis = @pg_Exec($conn, $sql_asis);
	}
	
	if ($fecha_apo!=NULL and $com_apo!=NULL){
	    // graba en tabla psico_avance
		$dd = substr($fecha_apo,0,2);
		$mm = substr($fecha_apo,3,2);
		$aa = substr($fecha_apo,6,4);
		$fecha_apo = "$aa-$mm-$dd";
		
	    $sql_apo = "insert into psico_citacion (fecha, comentario, rut_alumno, asiste) values ('$fecha_apo','$com_apo','$_ALUMNO','$asiste_apo')";
		$res_apo = @pg_Exec($conn, $sql_apo);
	}	
	
	echo "<script>window.location='fichaPsicopedagogica.php'</script>";
		
	
?>

<?php require('../../../util/header.inc');?>
<?php
   $nu_resol=trim($_GET['nu_resol']);
   $fecha_resol=trim($_GET['fecha_resol']);
   $titulo1=trim($_GET['titulo1']);
   $institucion1=trim($_GET['institucion1']);
   $campo_ano1=trim($_GET['campo_ano1']);
   $titulo2=trim($_GET['titulo2']);
   $institucion2=trim($_GET['institucion2']);
   $campo_ano2=trim($_GET['campo_ano2']);
   $titulo3=trim($_GET['titulo3']);
   $institucion3=trim($_GET['institucion3']);
   $campo_ano3=trim($_GET['campo_ano3']);
   $postitulo1=trim($_GET['postitulo1']);
   $postitulo2=trim($_GET['postitulo2']);
   $posgrado1=trim($_GET['posgrado1']);
   $posgrado2=trim($_GET['posgrado2']);
   $curso1=trim($_GET['curso1']);
   $campo_ano_curso1=trim($_GET['campo_ano_curso1']);
   $horas1=trim($_GET['horas1']);
   $curso2=trim($_GET['curso2']);
   $campo_ano_curso2=trim($_GET['campo_ano_curso2']);
   $horas2=trim($_GET['horas2']);
   $curso3=trim($_GET['curso3']);
   $campo_ano_curso3=trim($_GET['campo_ano_curso3']);
   $horas3=trim($_GET['horas3']);
   $curso4=trim($_GET['curso4']);
   $campo_ano_curso4=trim($_GET['campo_ano_curso4']);
   $horas4=trim($_GET['horas4']);
   $resumen_est=trim($_GET['resumen_est']);
   $check1=trim($_GET['check1']);
   $check2=trim($_GET['check2']);
   $check3=trim($_GET['check3']);
   
   if ($fecha_resol!=NULL){
       $dd = substr($fecha_resol,0,2);
	   $mm = substr($fecha_resol,3,2);
	   $aa = substr($fecha_resol,6,4);
	   $fecha_resol="$mm-$dd-$aa";
   }   
      
   $rut_emp = "12555333";
   
   if ($nu_resol!=NULL){
       $sql = "update empleado set nu_resol = '$nu_resol' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);
   }
   if ($fecha_resol!=NULL){
       $sql = "update empleado set  fecha_resol = '$fecha_resol' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);
   }	   
   if ($check1==1){
       $sql = "update empleado set  habilitado = '1' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);
   }else{
       $sql = "update empleado set  habilitado = '0' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);   
   }
   if ($check2==1){
       $sql = "update empleado set  titulado = '1' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);
   }else{
       $sql = "update empleado set  titulado = '0' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);   
   }
   if ($check3==1){
       $sql = "update empleado set  tit_otras = '1' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);
   }else{
       $sql = "update empleado set  tit_otras = '0' where rut_emp = '".trim($rut_emp)."'";
       $res = pg_Exec($conn, $sql);   
   }  
   
   ////// seleccionamos el máximo id_estudios en la tabla empleado_estudios  ////
   $sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='12555333' AND tipo=1";
   $res_orden_tit = @pg_exec($conn, $sql_orden_tit);
   $fila_orden_tit = @pg_fetch_array($res_orden_tit, 0);
   $new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
	
	// antes de insertar tomo al maximo valor de id_estudios
	$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
	$r6 = @pg_Exec($conn,$q6); 
	$f6 = @pg_fetch_array($r6,0);
	$id_estudio_new = $f6['id_estudio'];
	$id_estudio_new++;
	
   
    //// insertar en tabla Empleado estudios
    //// TITULO tipo (1)
	if ($titulo1!=NULL and $institucion1!=NULL and $campo_ano1!=NULL){
		$sql = "insert into empleado_estudios (id_estudio, rut_empleado, nombre, institucion, ano, tipo, orden)
		values ('$id_estudio_new','12555333','$titulo1','$institucion1','$campo_ano1','1','$new_orden_tit')";
		$res = @pg_Exec($conn, $sql);
	    $id_estudio_new++;
	    $new_orden_tit++;
	}
	if ($titulo2!=NULL and $institucion2!=NULL and $campo_ano2!=NULL){
		$sql = "insert into empleado_estudios (id_estudio, rut_empleado, nombre, institucion, ano, tipo, orden)
		values ('$id_estudio_new','12555333','$titulo2','$institucion2','$campo_ano2','1','$new_orden_tit')";
		$res = @pg_Exec($conn, $sql);
	    $id_estudio_new++;
	    $new_orden_tit++;
	}
	if ($titulo3!=NULL and $institucion3!=NULL and $campo_ano3!=NULL){
		$sql = "insert into empleado_estudios (id_estudio, rut_empleado, nombre, institucion, ano, tipo, orden)
		values ('$id_estudio_new','12555333','$titulo3','$institucion3','$campo_ano3','1','$new_orden_tit')";
		$res = @pg_Exec($conn, $sql);
	    $id_estudio_new++;
	    $new_orden_tit++;
	}
	
	//// POSTITULO   tipo (2)
	$sql_orden_postit = "SELECT MAX(orden) AS orden_postit FROM empleado_estudios WHERE rut_empleado='12555333' AND tipo=2";
	$res_orden_postit = pg_exec($conn, $sql_orden_postit);
	$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
	$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;	
	
	if ($postitulo1!=NULL){	
		$sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden)
		values ('$id_estudio_new','12555333','$postitulo1','2','$new_orden_postit')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_postit++;
	}
	
	if ($postitulo2!=NULL){
	    $sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden)
	    values ('$id_estudio_new','12555333','$postitulo2','2','$new_orden_postit')";
	    $res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
	}
	
	//// POSGRADO tipo(3)
	$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='12555333' AND tipo=3";
	$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
	$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
	$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;
	
	if ($posgrado1!=NULL){
	    $sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden)
		values ('$id_estudio_new','12555333','$posgrado1','3','$new_orden_posgra')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_posgra++;
	}
	if ($posgrado2!=NULL){
	    $sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden)
		values ('$id_estudio_new','12555333','$posgrado2','3','$new_orden_posgra')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_posgra++;
	}
	
	//// CURSO tipo(4)
	$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='12555333' AND tipo=4";
	$res_orden_cu = pg_exec($conn, $sql_orden_cu);
	$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
	$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
	
	if ($curso1!=NULL and $campo_ano_curso1!=NULL and $horas1!=NULL){
		$sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden)
		values ('$id_estudio_new','12555333','$curso1','$campo_ano_curso1','$horas1','4','$new_orden_cu')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_cu++;
	}
	if ($curso2!=NULL and $campo_ano_curso2!=NULL and $horas2!=NULL){
		$sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden)
		values ('$id_estudio_new','12555333','$curso2','$campo_ano_curso2','$horas2','4','$new_orden_cu')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_cu++;
	}
	if ($curso3!=NULL and $campo_ano_curso3!=NULL and $horas3!=NULL){
		$sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden)
		values ('$id_estudio_new','12555333','$curso3','$campo_ano_curso3','$horas3','4','$new_orden_cu')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_cu++;
	}
	if ($curso4!=NULL and $campo_ano_curso4!=NULL and $horas4!=NULL){
		$sql = "insert into empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden)
		values ('$id_estudio_new','12555333','$curso4','$campo_ano_curso4','$horas4','4','$new_orden_cu')";
		$res = @pg_Exec($conn, $sql);
		$id_estudio_new++;
		$new_orden_cu++;
	}
	
	//// RESUMEN ESTUDIOS
	if ($resumen_est!=NULL){
	    $sql="UPDATE empleado SET estudios ='".$resumen_est."'  WHERE rut_emp='12555333'";
	    $res = @pg_Exec($conn,$sql);
	}
	
	
?>
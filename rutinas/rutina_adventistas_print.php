<?php 
function envia_mes($mes){
		
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		return ($t_mes);			
	  
	  }

function finmes($mes,$ano){
if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}elseif(($ano%4)==0){
		$dia=29;
	}else{
		$dia==28;
	}
	return $dia;
}	

//dias habiles por rango fijo, sin feriados
function hbl($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
		
		// $fechainicio.".....".$fechafin;;
		
        $fechainicio = strtotime($fechainicio." 00:00:00");
	 $fechafin = strtotime($fechafin." 23:59:59");
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
      //echo  count($diashabiles);
        return count($diashabiles);
}




if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	 }
	//exit;
	  $sql_a = "select * from ano_escolar where id_institucion=$cmbINSTITUCION and id_ano=$cmbANO";
	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	$nano = pg_result($rs_ano,1);
	//	var_dump($_POST);
	
	$sql_eva="select ins.rdb,ins.nombre_instit,
		rel.id_cargo_evaluador,
		rel.rut_evaluador,
		rel.id_cargo_evaluado,
		rel.rut_evaluado,
		ar.nombre dimension,
		suba.nombre funcion,
		itm.nombre indicador,
		conc.categoria respuesta
		from institucion ins
		inner join evados.eva_ano_escolar an on an.id_institucion = ins.rdb
		inner join evados.eva_periodos_evaluacion pe on pe.id_anio = an.id_ano
		inner join evados.eva_plantilla_evaluacion rel on rel.ip_periodo = pe.id_periodo
		inner join evados.eva_plantilla_area ar on ar.id_area = rel.id_area
		inner join evados.eva_plantilla_subarea suba on suba.id_subarea = rel.id_subarea
		inner join evados.eva_plantilla_item itm on itm.id_item = rel.id_item
		inner join evados.eva_concepto conc on conc.id_concepto = rel.id_concepto
		where pe.id_anio = $cmbANO
		order by rel.rut_evaluador,rel.rut_evaluado,ar.nombre,suba.nombre";
		$rs_eva = pg_exec($conn,$sql_eva);
	
	
 header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Evaluacion_".$nano."_".$cmbINSTITUCION.".xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
  

	
?>
<table width="100%" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>RDB</td>
    <td>INSTITUCION</td>
    <td>CARGO EVALUADOR</td>
    <td>RUT EVALUADOR</td>
    <td>NOMBRE EVALUADOR</td>
    <td>CARGO EVALUADO</td>
    <td>RUT EVALUADO</td>
    <td>NOMBRE EVALUADO</td>
    <td>DIMENSION</td>
    <td>FUNCION</td>
    <td>INDICADOR</td>
    <td>RESPUESTA</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_eva);$i++){
	  	$fila = pg_fetch_array($rs_eva,$i);
		?>
  <tr class="tableindex">
    <td><?=$fila['rdb'];?></td>
    <td><?=$fila['nombre_instit'];?></td>
    <td><?php $sql_cevr = "select nombre_cargo from cargos where id_cargo=".$fila['id_cargo_evaluador'];
		$rs_cevr = pg_exec($conn,$sql_cevr);
		echo strtoupper(pg_result($rs_cevr,0));
	?></td>
    <td><?=$fila['rut_evaluador'];?>-<?php 
	
	 if($fila['id_cargo_evaluador']==101){
	$sql_revr = "select dig_rut,ape_pat||' '||ape_mat||' '||nombre_apo nombre from apoderado where rut_apo=".$fila['rut_evaluador'];	 
	}
	elseif($fila['id_cargo_evaluador']==100){
	$sql_revr = "select dig_rut,ape_pat||' '||ape_mat||' '||nombre_alu from alumno where rut_alumno=".$fila['rut_evaluador'];	 
	}
	else{
	$sql_revr = "select dig_rut,ape_pat||' '||ape_mat||' '||nombre_emp from empleado where rut_emp=".$fila['rut_evaluador'];	 
	}
		$rs_revr = pg_exec($conn,$sql_revr);
		echo strtoupper(pg_result($rs_revr,0));
	?></td>
    <td><?php echo  strtoupper(pg_result($rs_revr,1)); ?></td>
    <td><?php $sql_cevl = "select nombre_cargo from cargos where id_cargo=".$fila['id_cargo_evaluado'];
		$rs_cevl = pg_exec($conn,$sql_cevl);
		echo strtoupper(pg_result($rs_cevl,0));
	?></td>
    <td><?=$fila['rut_evaluado'];?>-<?php   $sql_revl = "select dig_rut,ape_pat||' '||ape_mat||' '||nombre_emp nombre from empleado where rut_emp=".$fila['rut_evaluado'];
	$rs_cevl = pg_exec($conn,$sql_revl);
		echo strtoupper(pg_result($rs_cevl,0));
	 ?></td>
    <td><?php echo  strtoupper(pg_result($rs_cevl,1)); ?></td>
    <td><?=$fila['dimension'];?></td>
    <td><?=$fila['funcion'];?></td>
    <td><?=$fila['indicador'];?></td>
    <td><?=$fila['respuesta'];?></td>
  </tr>
  <?php }?>
  </table>

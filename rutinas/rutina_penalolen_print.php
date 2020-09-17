<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//exit;
?>
<?php 
 header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
  


if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }
	//exit;
	  $sql_a = "select * from ano_escolar where id_institucion=$cmbINSTITUCION and id_ano=$cmbANO";
	$rs_ano = pg_exec($conn,$sql_a);
	$id_ano = pg_result($rs_ano,0);
	$nano = pg_result($rs_ano,1);
	//	var_dump($_POST);
	
	 $mm = ($cmbMES<10)?"0".$cmbMES:$cmbMES;
	$diaf = finmes($mm,$nano);
	$parte = ($cmbMES==3)?"05":"01";
	$fechainicio="$nano-".$mm."-".$parte;
	$fechafin=$nano."-".$mm."-".$diaf;
	
	 $sql="SELECT i.rdb,a.rut_alumno, dig_rut, nombre_alu, ape_pat ||' '|| ape_mat as apellidos, fecha_nac,
		 case when (a.sexo=2) then 'Masculino' else 'Femenino' end as genero,a.calle ||' '|| a.nro as direccion, a.telefono, 
		 celular, i.nombre_instit, c.grado_curso, c.letra_curso, te.nombre_tipo ,c.ensenanza,c.id_curso,
		case when (bool_ar=0) THEN 'Vigente' else 'Retirado' end as estado_matricula, m.fecha_retiro,c.fecha_inicio,c.fecha_termino,m.bool_ar,m.fecha
		FROM alumno a 
		INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno 
		INNER JOIN institucion i ON i.rdb=m.rdb
		LEFT JOIN curso c ON c.id_curso=m.id_curso
		INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
		WHERE m.id_ano=".$cmbANO."
		ORDER BY c.ensenanza, c.grado_curso, c.letra_curso, a.ape_pat, a.ape_mat ASC";
	$rs_matricula = pg_exec($conn,$sql);
	
	 
//dias habiles por rango fijo, sin feriados


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


 
	 
 //	switch 
	$mm = ($cmbMES<10)?"0".$cmbMES:$cmbMES;
	$diaf = finmes($mm,$nano);
	$parte = ($cmbMES==3)?"04":"01";
	$fechainicio="$parte-".$mm."-".$nano;
	$fechafin=$diaf."-".$mm."-".$nano;
 	
	/*$sql="select sum((fecha_fin - fecha_inicio) + 1) as dia_feriado from feriado where id_ano=".$cmbANO." and date_part('month',fecha_inicio)=".$cmbMES;
	$rs_feriado = pg_exec($conn,$sql);
	$dias_feriado = pg_result($rs_feriado,0);
	$dias_habiles = hbl($fechainicio,$fechafin) - $dias_feriado;*/
	//$dias_habiles = hbl($fechainicio,$fechafin);


?>
<table width="100%" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>RDB</td>
    <td>RUT</td>
    <td>DIGITO</td>
    <td>NOMBRES</td>
    <td>APELLIDOS</td>
    <td>GENERO</td>
    <td>DIRECCION</td>
    <td>TELEFONO</td>
    <td>CELULAR</td>
    <td>COLEGIO</td>
    <td>NIVEL</td>
    <td>CURSO</td>
    <td>LETRA</td>
    <td>DIAS<br />
    HABILES</td>
    <td>DIAS<br />
    ASISTENCIA</td>
    <td>DIAS <br />
      INASISTENCIA</td>
    <td>MATRICULA</td>
    <td>MES DE RETIRO</td>
    <td>FECHA DE RETIRO</td>
    <td>PROMEDIO</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_matricula);$i++){
	  	$fila = pg_fetch_array($rs_matricula,$i);
		
		$fett = explode("-",$fila['fecha_termino']);
		$fitt = explode("-",$fila['fecha_inicio']);
		
		$mm = ($cmbMES<10)?"0".$cmbMES:$cmbMES;
		
		$diai = ($fitt[1]==$mm)?$fitt[2]:"01";
		
		$diaf = finmes($mm,$nano,$fett[2]);
		
		$parte = ($cmbMES==3)?"05":"01";
	$fechainicio="$nano-".$mm."-".$parte;
	$fechafin=$nano."-".$mm."-".$diaf;
		
		$nombre_mes="";
		
		
		  $corte_r="";
		 	 $corte_a="";
		 
		
		 if($fila['bool_ar']==1){
		  $df = explode("-",$fila['fecha_retiro']); 
		  $corte_r= " and date_part('day',fecha_fin) <=".$df[2];
		  $corte_a = " AND date_part('day',fecha)<=".$df[2]; 
		  $fechafin = $fila['fecha_retiro'];
		  
		  $mes = $df[1];
		  
			switch($mes){
				case 01:
					$nombre_mes ="ENERO";
					break;
				case 02:
					$nombre_mes ="FEBRERO";
					break;	
				case 03:
					$nombre_mes ="MARZO";
					break;
				case 04:
					$nombre_mes ="ABRIL";
					break;
				case 05:
					$nombre_mes ="MAYO";
					break;
				case 06:
					$nombre_mes ="JUNIO";
					break;
				case 07:
					$nombre_mes ="JULIO";
					break;
				case 08:
					$nombre_mes ="AGOSTO";
					break;
				case 09:
					$nombre_mes ="SEPTIEMBRE";
					break;
				case 10:
					$nombre_mes ="OCTUBRE";
					break;
				case 11:
					$nombre_mes ="NOVIEMBRE";
					break;
				case 12:
					$nombre_mes ="DICIEMBRE";
					break;
				default :
					$nombre_mes=" ";
			}
		
		  
		  
		  
		 }
		 else{
			$df = explode("-",$fila['fecha']);
			if($df[1]==$mm && ($df[2]!="01" && $df[2]!=$diaf) ){
			 $corte_a = " AND date_part('day',fecha)>=".$df[2]; 
			 $corte_r= " and date_part('day',fecha_inicio) >=".$df[2];
			 $fechainicio = $fila['fecha'];
			}
			else{
			
			 // $fechainicio = $fechainicio="$nano-".$mm."-".$$diaf;
			
			}
		 
		 }
		 
		  
		 
		 
		 
		 
		 
		 
		   $sql="select sum((feriado.fecha_fin - feriado.fecha_inicio) + 1) as dia_feriado 
from feriado inner join feriado_curso
 on feriado_curso.id_feriado = feriado.id_feriado 
	 where id_ano=".$cmbANO." and  feriado_curso.id_curso =".$fila['id_curso']." and date_part('month',fecha_inicio)=".$cmbMES." $corte_r ";
	$rs_feriado = pg_exec($conn,$sql);
	$dias_feriado = pg_result($rs_feriado,0);
	$dias_habiles = hbl($fechainicio,$fechafin) - $dias_feriado;
	//exit;
		
	 	  $sql="SELECT count(*) FROM asistencia WHERE ano=".$cmbANO." AND rut_alumno=".$fila['rut_alumno']." AND date_part('year',fecha)=".$nano." AND date_part('month',fecha)=".$mm ." $corte_a";
		 // echo $sql."<br>";
		$rs_inasistencia = pg_exec($conn,$sql);
		$inasistencia = pg_result($rs_inasistencia,0);
		$dias_asistencia = $dias_habiles - $inasistencia;
		
		if($fila['ensenanza']>10){
		
		 //echo "<br>". 
		 //$sql="select avg(cast(promedio as integer)) from notas".$nano." where rut_alumno=".$fila['rut_alumno'];
		 $sql="select avg(cast(promedio as integer)) from notas".$nano." 
inner join ramo on ramo.id_ramo = notas".$nano.".id_ramo
where rut_alumno=".$fila['rut_alumno']." and bool_pgeneral=1";
		$rs_notas = pg_exec($conn,$sql);
		$promedio = pg_result($rs_notas,0);
		$promedio = round($promedio);
		}else{
			$promedio="-";
			}
		
	?>
  <tr class="textosimple" <?php if($cmbMES>11 && $fila['ensenanza']>=310 && $fila['grado_curso']==4){?>style="display:none"<?php }?>>
    <td><?=$fila['rdb'];?></td>
    <td><?=$fila['rut_alumno'];?></td>
    <td><?=$fila['dig_rut'];?></td>
    <td><?=$fila['nombre_alu'];?></td>
    <td><?=$fila['apellidos'];?></td>
    <td><?=$fila['genero'];?></td>
    <td><?=$fila['direccion'];?></td>
    <td><?=$fila['telefono'];?></td>
    <td><?=$fila['celular'];?></td>
    <td><?=$fila['nombre_instit'];?></td>
    <td><?=$fila['nombre_tipo'];?></td>
    <td><?=$fila['grado_curso'];?></td>
    <td><?=$fila['letra_curso'];?></td>
    <td><?=$dias_habiles;?></td>
    <td><?=$dias_asistencia;?></td>
    <td><?=$inasistencia;?></td>
    <td><?=$fila['estado_matricula'];?></td>
    <td><?=$nombre_mes;?></td>
    <td><?=$fila['fecha_retiro'];?></td>
    <td><?=$promedio;?></td>
  </tr>
  <? $mes=0;
  } ?>
</table>
</form>
</head></html>
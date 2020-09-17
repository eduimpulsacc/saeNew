<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 


//base de datos antigua
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");

//if($conn)echo "conecte final";

//base de datos coifinal
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//if($conn2)echo "conecte viña"; 
  
//exit;



//
$nro_ano = 2014;     
$rbd = 1598;
$activa = 1; 


//armo array activas
$array_plantilla = array();

//id año zapallar
$sql_anio ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano = pg_exec($conn,$sql_anio) or die ("error 1:".$sql_anio);
$fila_ano = pg_fetch_array($rs_ano,0);
$idano_acad = $fila_ano['id_ano'];
$array_plantilla['anio_didier'][0]=$idano_acad ;

//id_año coefinal

$sql_anio_coifinal ="select * from ano_escolar where id_institucion= $rbd and nro_ano =$nro_ano;";
$rs_ano_coifinal = pg_exec($conn2,$sql_anio_coifinal) or die ("error 1:".$sql_anio_coifinal);
$fila_ano_coifinal = pg_fetch_array($rs_ano_coifinal,0);
$idano_acad_coifinal = $fila_ano_coifinal['id_ano'];
$array_plantilla['anio_coi'][0]=$idano_acad_coifinal ;


//periodos didier
		$sql_periodo = "select * from periodo where id_ano = $idano_acad order by id_periodo asc;";
		$rs_periodo = pg_exec($conn,$sql_periodo) or die ("error 3:".$sql_periodo);
		
		for($k=0;$k<pg_numrows($rs_periodo);$k++){
		$fila_periodo=pg_fetch_array($rs_periodo,$k);
		$id_periodo = $fila_periodo['id_periodo'];
		$id_ano = $fila_periodo['id_ano'];
		
		
		//periodo coi final
		 $sql_periodo_coifinal = "select * from periodo where id_ano = $idano_acad_coifinal order by id_periodo asc;";
		$rs_periodo_coifinal = pg_exec($conn2,$sql_periodo_coifinal)  or die ("error 4:".$sql_periodo_coifinal);
		
			$fila_periodo_coifinal=pg_fetch_array($rs_periodo_coifinal,$k);
			$id_periodo_coifinal = $fila_periodo_coifinal['id_periodo'];
			//montar array periodo
			$array_plantilla['periodo'][$k]=$fila_periodo['id_periodo'].",". $fila_periodo_coifinal['id_periodo'];	
       
	   
}




/*
*/
//plantillas didier
$sql_plan ="select * from informe_plantilla where activa =1 and rdb=$rbd order by id_plantilla";
$rs_plan = pg_exec($conn,$sql_plan) or die ("error 5:".$sql_plan);
for($l=0;$l<pg_numrows($rs_plan);$l++){
		$fila_plan=pg_fetch_array($rs_plan,$l);
		 $id_plantilla = $fila_plan['id_plantilla'];
		 $array_plantilla['anio_didier']['plantilla_didier'][$l]= $id_plantilla;
		 
		 //plantilla coi
		 $sql_plan_coi ="select * from informe_plantilla where activa =1 and rdb=$rbd";
 		 $rs_plan_coi = pg_exec($conn2,$sql_plan_coi) or die ("error 6:".$sql_plan_coi);
		 $fila_plan_coi=pg_fetch_array($rs_plan_coi,$l);
		 $id_plantilla_coi = $fila_plan_coi['id_plantilla'];
		 
		 $array_plantilla['plantillas'][$l]= $id_plantilla.",". $id_plantilla_coi;	
		 
		 
		 
		 
		 //informe area item didier
	 $sql_iai = "select * from informe_area_item where id_plantilla=  $id_plantilla order by id";
		 $rs_iai = pg_exec($conn,$sql_iai) or die ("error 7:".$sql_iai);
		  for($n=0;$n<pg_numrows($rs_iai);$n++){
			$fila_iai=pg_fetch_array($rs_iai,$n);
			 $id_iai = $fila_iai['id'];
			
			 $array_plantilla['area_didier'][]= $id_iai;
		
			}
		 
		 	
			 //informe area item coi
		  $sql_iai_coi = "select * from informe_area_item where id_plantilla= $id_plantilla_coi order by id";
		// echo "<br>";
		 $rs_iai_coi = pg_exec($conn2,$sql_iai_coi) or die ("error 8:".$sql_iai_coi);
		  for($o=0;$o<pg_numrows($rs_iai_coi);$o++){
			$fila_iai_coi=pg_fetch_array($rs_iai_coi,$o);
			$id_iai_coi = ",".$fila_iai_coi['id'];

			$array_plantilla['area_coi'][]= $id_iai_coi;
			
		  }
		  
		  
		  //concepto_eval didier
		    $sql_ice = "select * from informe_concepto_eval where id_plantilla=  $id_plantilla order by id_concepto";
		 $rs_ice = pg_exec($conn,$sql_ice) or die ("error 9:".$sql_ice);
		  for($p=0;$p<pg_numrows($rs_ice);$p++){
			$fila_ice=pg_fetch_array($rs_ice,$p);
			 $id_ice = $fila_ice['id_concepto'];
			
			 $array_plantilla['concepto_didier'][]= $id_ice;
		
			}
			
			
			 //concepto_eval coi
		    $sql_ice_coi = "select * from informe_concepto_eval where id_plantilla=  $id_plantilla_coi order by id_concepto";
		 $rs_ice_coi = pg_exec($conn2,$sql_ice_coi) or die ("error 10:".$sql_ice_coi);
		  for($q=0;$q<pg_numrows($rs_ice_coi);$q++){
			$fila_ice_coi=pg_fetch_array($rs_ice_coi,$q);
			 $id_ice_coi = $fila_ice_coi['id_concepto'];
			
			 $array_plantilla['concepto_coi'][]= $id_ice_coi;
		
			}
		
		
		
}

	
	for($c=0;$c<count($array_plantilla['area_didier']);$c++){
	 $array_plantilla['areas'][]= $array_plantilla['area_didier'][$c].$array_plantilla['area_coi'][$c];
	}
	
	for($f=0;$f<count($array_plantilla['concepto_didier']);$f++){
	 $array_plantilla['conceptos'][]= $array_plantilla['concepto_didier'][$f].",".$array_plantilla['concepto_coi'][$f];
	}
	



$qry_alu_didier ="select * from informe_evaluacion2 where id_ano =$idano_acad and id_plantilla in(".implode(",",$array_plantilla['anio_didier']['plantilla_didier']).") order by id";
$res_alu_didier = pg_exec($conn,$qry_alu_didier) or die ("error 11:".$qry_alu_didier);

echo $qry_alu_didier_obs ="select * from informe_observaciones where id_ano =$idano_acad and id_plantilla in(".implode(",",$array_plantilla['anio_didier']['plantilla_didier']).") order by id_ano,id_periodo,id_plantilla,rut_alumno";
$res_alu_didier_obs = pg_exec($conn,$qry_alu_didier_obs) or die ("error 11:".$qry_alu_didier_obs);

for($aa=0;$aa<pg_num_rows($res_alu_didier);$aa++){
	
$fil_inf = pg_fetch_array($res_alu_didier,$aa);
$fil_id = $fil_inf['id'];
$fil_conf = $fil_inf['concepto'];
$fil_rut = $fil_inf['rut_alumno'];
$fil_fecha = $fil_inf['fecha'];
$fil_curso = $fil_inf['id_curso'];
$fil_periodo = $fil_inf['id_periodo'];
$fil_plantilla = $fil_inf['id_plantilla'];
$fil_area = $fil_inf['id_informe_area_item'];
$fil_conceptos = $fil_inf['respuesta'];

//cursos
 $qry_curso = "select grado_curso,letra_curso,ensenanza from curso where id_curso=$fil_curso";
$res_cur_didier = pg_exec($conn,$qry_curso);
$fil_cur_didier = pg_fetch_array($res_cur_didier,0);
$fil_grado = $fil_cur_didier['grado_curso'];
$fil_letra = $fil_cur_didier['letra_curso'];
$fil_ense = $fil_cur_didier['ensenanza'];

//curso coi
$cur_coi = "select id_curso from curso where id_ano=$idano_acad_coifinal and grado_curso=".$fil_grado." and letra_curso='".$fil_letra."' and ensenanza=".$fil_ense ;
$res_cur_coi = pg_exec($conn2,$cur_coi);
$fil_cur_coi = pg_fetch_array($res_cur_coi,0);
$fil_curso_coi = $fil_cur_coi['id_curso'];

//periodo

foreach($array_plantilla['periodo'] as $d_periodo){
$a_periodo = explode(",",$d_periodo);
if($fil_periodo==$a_periodo[0])
{$per = $a_periodo[1];}
}


//plantillas

foreach($array_plantilla['plantillas'] as $d_plantillas){
$a_plantillas = explode(",",$d_plantillas);
if($fil_plantilla==$a_plantillas[0])
{$plan = $a_plantillas[1];}
}


//area_item

foreach($array_plantilla['areas'] as $d_areas){
$a_areas = explode(",",$d_areas);
if($fil_area==$a_areas[0])
{$area = $a_areas[1];}
}
	
	
//conceptos

foreach($array_plantilla['conceptos'] as $d_conceptos){
$a_conceptos = explode(",",$d_conceptos);
if($fil_conceptos==$a_conceptos[0])
{$respuesta = $a_conceptos[1];}
}
	
/*$qry_insert="insert into informe_evaluacion2 (id_ano,concepto,rut_alumno,fecha,id_curso,id_periodo,id_plantilla,id_informe_area_item,respuesta) values($idano_acad_coifinal,$fil_conf,$fil_rut,'$fil_fecha',$fil_curso_coi,$per,$plan,$area,$respuesta)";
$res_insert = pg_exec($conn2,$qry_insert);*/

//echo "<br>";	
}

for($ee=0;$ee<pg_num_rows($res_alu_didier_obs);$ee++){
	$fil_obs = pg_fetch_array($res_alu_didier_obs,$ee);

$fil_periodo=$fil_obs['id_periodo'];
$fil_ano=$fil_obs['id_ano'];
$fil_plantilla=$fil_obs['id_plantilla'];
$fil_rut=$fil_obs['rut_alumno'];
$fil_glosa=$fil_obs['glosa'];
$fil_fecha=$fil_obs['fecha_creacion'];
$fil_observciones=$fil_obs['observaciones'];
$fil_destaca=$fil_obs['sedestaca'];

foreach($array_plantilla['periodo'] as $d_periodo){
$a_periodo = explode(",",$d_periodo);
if($fil_periodo==$a_periodo[0])
{$per = $a_periodo[1];}
}

foreach($array_plantilla['plantillas'] as $d_plantillas){
$a_plantillas = explode(",",$d_plantillas);
if($fil_plantilla==$a_plantillas[0])
{$plan = $a_plantillas[1];}
}

echo "<br>".$qry_insert_obs = "insert into informe_observaciones values ($per,$idano_acad_coifinal,$plan,$fil_rut,'$fil_glosa','$fil_fecha','$fil_observciones','$fil_destaca' )";
$res_insert_obs = pg_exec($conn2,$qry_insert_obs);
}


/*echo "<pre>";
var_dump($array_plantilla);
echo "</pre>";*/

?>

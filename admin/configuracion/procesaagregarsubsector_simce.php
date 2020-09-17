<?   require "../../util/header.php";
	//include('../clases/class_Reporte.php');


$puntos 		= $_GET['puntos'];
$rut_alumno 	= $_GET['rut_alumno'];
$ano2 			= $_GET['ano'];
$id_sub_sim 	= $_GET['id_sub_sim'];
$institucion 	= $_GET['rdb'];
$curso 			= $_GET['curso'];


if($tipo==1){
		
	//-------------INGRESO DE SUBSECTORES A EVALUAR--------------------//
	$sql="INSERT INTO simce_conf_2009 (id_ano,cod_subsector,grado,ensenanza,rdb) VALUES ";
	$sql.="(".$ano.",".$cmb_subsector.",".$cmb_grado.",".$cmb_ensenanza.",".$rdb.")";
	$result = @pg_exec($conn,$sql) or die ("Insert falló: " .$sql);?>
	
	<script language="javascript">window.location="prueba_simce_psu.php"</script>

<? }

if($tipo==2){

	//-------------ELIMINAR SUBSECTORES QUE YA NO SE VAN A EVALUAR------//
	$sql="DELETE FROM simce_conf_2009 WHERE id_ano=".$ano." and cod_subsector=".$cod_subsector." and ";
	$sql.="grado=".$grado." and ensenanza=".$ensenanza." and rdb=".$rdb." and id_sub_sim=".$id_sub_sim."";
	
	$result = @pg_exec($conn,$sql) or die ("Delete falló: " .$sql);?>
	
	<script language="javascript">window.location="prueba_simce_psu.php"</script>

<? }



if(!isset($caso)){

	$sql_sel = "SELECT * FROM simce_notas_2009 WHERE id_sub_sim=".$id_sub_sim." and rut_alumno=".$rut_alumno."";
	$res = @pg_exec($conn,$sql_sel) or die ("Select falló: " .$sql_sel);
	$alumno_puntaje = pg_fetch_array($res,0);
	
	
	if(pg_numrows($res)==0){

		//----------------------------INSERTA PUNTAJES OBTENIDOS POR ALUMNOS------------------//
		$sql_puntos="INSERT INTO simce_notas_2009 (id_ano,id_sub_sim,rut_alumno,id_curso,nota) VALUES ";
		$sql_puntos.="(".$ano2.",".$id_sub_sim.",".$rut_alumno.",".$curso.",".$puntos.")";
		$result = @pg_exec($conn,$sql_puntos) or die ("Insert falló: " .$sql_puntos);

	}else{
		//---------------------------ACTUALIZA PUNTAJES OBTENIDOS POR ALUMNOS------------------//
		$sql_puntos="UPDATE simce_notas_2009 SET nota=".$puntos." WHERE rut_alumno=".$rut_alumno." and id_curso=".$curso."";
		$sql_puntos.="AND id_sub_sim=".$id_sub_sim."";
		$result = @pg_exec($conn,$sql_puntos) or die ("Update falló: " .$sql_puntos);
	
	}

		$sql_sel_puntos = "SELECT * FROM simce_notas_2009 WHERE id_sub_sim=0 and rut_alumno=".$rut_alumno."";
		$res_sel = @pg_exec($conn,$sql_sel_puntos) or die ("Select falló: " .$sql_sel_puntos);
		$alumno_puntos = pg_fetch_array($res_sel,0);
	
	
	if($res_sel!=NULL){
	
	//----------------------INSERTA PROMEDIOS DE LOS PUNTAJES POR ALUMNO--------------------//	
	
		if($alumno_puntos['nota']!=0){
		
			$sql_sel_final = "SELECT * FROM simce_final_2009 WHERE rut_alumno=".$rut_alumno."";
			$res_sel_final = @pg_exec($conn,$sql_sel_final) or die ("Select falló: " .$sql_sel_final);
			$alumno_final = pg_fetch_array($res_sel_final,0);
			
			if(pg_numrows($res_sel_final)==0){
			
			$sql_final="INSERT INTO simce_final_2009 (id_ano,rut_alumno,id_curso,puntaje_final) VALUES ";
			$sql_final.="(".$ano2.",".$rut_alumno.",".$alumno_puntos['id_curso'].",".$alumno_puntos['nota'].")";
			$result = @pg_exec($conn,$sql_final) or die ("Insert falló: " .$sql_final);
			
			$sql_borrar="DELETE FROM simce_notas_2009 WHERE id_sub_sim=0 and rut_alumno=".$rut_alumno."";
			$result = @pg_exec($conn,$sql_borrar) or die ("Delete falló: " .$sql_borrar);
			
				}else{
	//---------------------ACTUALIZA PROMEDIOS DE LOS PUNTAJES POR ALUMNO-----------------------//
	
			$sql_final="UPDATE simce_final_2009 SET puntaje_final=".$alumno_puntos['nota']." WHERE rut_alumno=".$rut_alumno."";
			$sql_final.=" AND id_curso=".$alumno_puntos['id_curso']." AND id_ano=".$ano2."";
			$result = @pg_exec($conn,$sql_final) or die ("Update falló: " .$sql_final);
			
			$sql_borrar="DELETE FROM simce_notas_2009 WHERE id_sub_sim=0 and rut_alumno=".$rut_alumno."";
			$result = @pg_exec($conn,$sql_borrar) or die ("Delete falló: " .$sql_borrar);
					}
	
			}
		}
	
	

	$sql_puntos_curso = "SELECT * FROM simce_notas_2009 WHERE id_sub_sim=9999 and rut_alumno=0";
	$res_puntos_curso = @pg_exec($conn,$sql_puntos_curso) or die ("Select falló: " .$sql_puntos_curso);
	$curso_puntos = pg_fetch_array($res_puntos_curso,0);
	
	if($res_puntos_curso!=NULL){
	
		$sql_prom_curso = "SELECT * FROM simce_inst_2009 WHERE id_curso=".$curso." and rdb=".$institucion."";
		$res_prom_curso = @pg_exec($conn,$sql_prom_curso) or die ("Select falló: " .$sql_prom_curso);
		$curso_prom = pg_fetch_array($res_prom_curso,0);
		
		if(pg_numrows($res_prom_curso)==0){
		
			//---------------------INSERTA PROMEDIO DEL PUNTAJE OBTENIDO POR EL CURSO--------------------//
			$sql_final_curso="INSERT INTO simce_inst_2009 (id_ano,rdb,id_curso,puntaje) VALUES ";
			$sql_final_curso.="(".$ano2.",".$institucion.",".$curso_puntos['id_curso'].",".$curso_puntos['nota'].")";
			$result = @pg_exec($conn,$sql_final_curso) or die ("Insert falló: " .$sql_final_curso);
			 
			$sql_borrar2="DELETE FROM simce_notas_2009 WHERE id_sub_sim=9999";
			$result_borrar = @pg_exec($conn,$sql_borrar2) or die ("Delete falló: " .$sql_borrar2);
		
		}else{
			//------------------ACTUALIZA PROMEDIO DEL PUNTAJE OBTENIDO POR EL CURSO-----------------//
			$sql_final_curso="UPDATE simce_inst_2009 SET puntaje=".$curso_puntos['nota']." WHERE";
			$sql_final_curso.=" id_curso=".$curso." and rdb=".$institucion."";
			$result = @pg_exec($conn,$sql_final_curso) or die ("Update falló: " .$sql_final_curso);
			
			$sql_borrar2="DELETE FROM simce_notas_2009 WHERE id_sub_sim=9999";
			$result_borrar = @pg_exec($conn,$sql_borrar2) or die ("Delete falló: " .$sql_borrar2);
		
		}
	}
}

?>


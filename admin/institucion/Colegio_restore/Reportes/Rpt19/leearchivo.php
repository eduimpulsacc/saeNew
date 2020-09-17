<?php 
require('../../../../../util/header.inc');

	$c_alumno	= $cmb_alumno;
	$ano		= $_ANO;
	$curso		= $c_curso;
	$alumno		= $c_alumno;
	$institucion= $_INSTIT;
	$periodo	= $periodo;

	$fecha = strftime("%d %m %Y");
	$_POSP = 5;
	$_bot = 8;
	if ($cmb_ano){
		$ano=$cmb_ano;
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){ 
			session_register('_ANO');
		}
		$curso=0;	
	}
		
	
		
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		}
	
	

		$sqlMatri="select * from curso where id_curso=$curso";
		$resultMatri=@pg_exec($conn,$sqlMatri);
		$filaMatri=@pg_fetch_array($resultMatri,0);

		if($filaMatri['grado_curso']==1) $gr="pa";
		if($filaMatri['grado_curso']==2) $gr="sa";
		if($filaMatri['grado_curso']==3) $gr="ta";
		if($filaMatri['grado_curso']==4) $gr="cu";
		if($filaMatri['grado_curso']==5) $gr="qu";
		if($filaMatri['grado_curso']==6) $gr="sx";
		if($filaMatri['grado_curso']==7) $gr="sp";
		if($filaMatri['grado_curso']==8) $gr="oc";
	
		$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
		$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
		$filaPlantilla=@pg_fetch_array($resultPlantilla);
		$plantilla=$filaPlantilla[id_plantilla];
		$nuevo_sis=$filaPlantilla[nuevo_sis];
		
				
		$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultDIR =@pg_Exec($conn,$qryDIR);
		$filaDIR=@pg_fetch_array($resultDIR);
	
		$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultORI =@pg_Exec($conn,$qryORI);
		$filaORI=@pg_fetch_array($resultORI);
	
		$sqlPeriodo="select nombre_periodo from periodo where id_periodo=".$periodo;
		$resultPeriodo=@pg_exec($conn, $sqlPeriodo);
		$filaPer=@pg_fetch_array($resultPeriodo,0);		
	
		
		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);
			
		$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
		$resultEmp =@pg_Exec($conn,$qryEmp);
		$filaEmp=@pg_fetch_array($resultEmp);
		
		$sql_ano="select nro_ano from ano_escolar where id_ano=".$_ANO;
		$res_ano =@pg_Exec($conn,$sql_ano);
		$filaAno=@pg_fetch_array($res_ano);
	
?>

<?       

	$sql_alu = "select * from matricula, alumno where id_curso = '$curso' and matricula.bool_ar = '0' and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";	
	
	$result_alu =pg_Exec($conn,$sql_alu);
	$cont_alumnos = pg_numrows($result_alu);

    
	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++){	    
	
		$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
		$alumno = $fila_alu['rut_alumno'] ;
		
		$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
		$resultMatri=@pg_exec($conn,$sqlMatri);
		$filaMatri=@pg_fetch_array($resultMatri,0);
	
		$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
		$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
		$filaAlumno=@pg_fetch_array($resultAlumno,0);
		
		$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
		$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
		$filaCurso=@pg_fetch_array($resultCurso);
		
		$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
		$resultEns=@pg_Exec($conn, $sqlEns);
		$filaEns=@pg_fetch_array($resultEns);
		
		$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
		$resultProfe=@pg_Exec($conn, $sqlProfe);
		$filaProfe=@pg_fetch_array($resultProfe);
		
		$titulo2 = $filaPlantilla['titulo_informe2'];

		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia
		?>
            <?							

			if($periodo != 0){
				
				$nombre = $ano."-".$periodo."-".$alumno."-".$plantilla;
				//echo "<h1>$nombre</h1>";				
				
			
				if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
					$archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");	    
					
					if ($_PERFIL==0){
					    echo $nombre;
				    }
					if ($archivo) {
						while (!feof($archivo)) {
							$cadena = fgets($archivo, 50000);
							$temp = split("[\t]",$cadena);
							//print_r($temp);
							$cont_car= count($temp);								
						}				
					}
				}
					fclose ($archivo);
			}
				
				
}
			

?>					
<? pg_close($conn); ?>
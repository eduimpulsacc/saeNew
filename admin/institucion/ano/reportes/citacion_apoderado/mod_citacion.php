<? 
session_start();

class Citacion{
	
	
	public function ano($conn,$rdb){
		$sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$rdb." ORDER BY nro_ano ASC";
		$result = pg_exec($conn,$sql) or die("ERROR");
		
		return $result;
	}
	
	public function curso($conn,$ano){
		 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_ano=".$ano." ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function cursoUno($conn,$curso){
		 $sql="SELECT id_curso,grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_curso=".$curso." ORDER BY ensenanza,curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Apoderado($conn,$curso){
		 $sql = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '".$curso."') and responsable=1) ORDER BY ape_pat ASC";  
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function asunto($conn,$rdb){
		$sql = "select * from citacion_asunto where rdb='".$rdb."'  ORDER BY asunto ASC";  
		$result = pg_exec($conn,$sql);
		return $result;
			
	}
	
	public function ListadoCitacion($conn,$ano,$curso,$rut,$asunto){
	    $sql="select a.id_asistencia, c.id_citacion, c.fecha, 
				c.hora, c.id_asunto, a.estado, a.rut_apo,a.id_curso,
				asu.asunto, (em.ape_pat||' '||em.ape_mat||', '||em.nombre_emp) as atendido,
				(ap.ape_pat||' '||ap.ape_mat||', '||ap.nombre_apo) as nom_apo
				from citacion c 
				inner join citacion_asistencia a on c.id_citacion=a.id_citacion 
				left join citacion_asunto asu on asu.id_asunto = c.id_asunto
				left join empleado em on em.rut_emp = a.atendido
				left join apoderado ap on ap.rut_apo = a.rut_apo
				where 
				 c.id_ano = $ano";
				
				if($curso!=0){
				$sql.=" and  a.id_curso = $curso";	
					}
				
				if($rut!=0){
				$sql.=" and a.rut_apo= $rut";	
					}
					
				if($asunto!=0){
				$sql.=" and c.id_asunto =$asunto";	
					}
					
				$sql.=" ORDER BY c.fecha,a.id_asistencia ASC";
				
				//echo $sql;
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function Guardar($conn,$ano,$curso,$apoderado,$fecha,$hora,$asunto,$mensaje,$emp,$tipo){//Guardar($conn,$ano,$curso,$alumno,$fecha,$ingreso,$egreso,$consulta,$destino,$proced,$obs,$patologia){
		
		$d=substr($fecha,0,2);
		$m=substr($fecha,3,2);
		$a=substr($fecha,6,4);
		$fecha = $m."-".$d."-".$a;
		
		$sql="insert into citacion(fecha,hora,motivo,tipo,id_ano,id_asunto) values('$fecha','$hora','$mensaje',$tipo,$ano,$asunto)";
		$result = pg_exec($conn,$sql) or die($sql);
		
		//echo $sql."<br>";
		
		
		//ultimo mensaje
		$sql_ul="select id_citacion from citacion where id_ano=$ano order by id_citacion desc limit 1";
		$result_ul = pg_exec($conn,$sql_ul) or die($sql_ul);
		$id_ul = pg_result($result_ul,0);
		//echo $sql_ul."<br>";
		
		//inserto el id de la citacion
		$sql_dat="insert into citacion_asistencia (id_citacion,id_curso,rut_apo,atendido,estado) values($id_ul,$curso,$apoderado,$emp,0)";
		$result_dat = pg_exec($conn,$sql_dat) or die($sql_dat);
		//echo $sql_dat."<br>";
	
		
		return $result_dat;
			
	}
	
	
	public function GuardarUno($conn,$ano,$curso,$apoderado,$fecha,$hora,$asunto,$mensaje,$emp,$tipo){//Guardar($conn,$ano,$curso,$alumno,$fecha,$ingreso,$egreso,$consulta,$destino,$proced,$obs,$patologia){
		
		$d=substr($fecha,0,2);
		$m=substr($fecha,3,2);
		$a=substr($fecha,6,4);
		$fecha = $m."-".$d."-".$a;
		
		$sql="insert into citacion(fecha,hora,motivo,tipo,id_ano,id_asunto) values('$fecha','$hora','$mensaje',$tipo,$ano,$asunto)";
		$result = pg_exec($conn,$sql) or die($sql);
		
		//echo $sql."<br>";
		return $result;
			
	}
	
	
	public function guardaCitacion($conn,$ano,$curso,$apoderado,$emp){
		
		//ultimo mensaje
		$sql_ul="select id_citacion from citacion where id_ano=$ano order by id_citacion desc limit 1";
		$result_ul = pg_exec($conn,$sql_ul) or die($sql_ul);
		$id_ul = pg_result($result_ul,0);
		//echo $sql_ul."<br>";
		
		//inserto el id de la citacion
		$sql_dat="insert into citacion_asistencia (id_citacion,id_curso,rut_apo,atendido,estado) values($id_ul,$curso,$apoderado,$emp,0)";
		$result_dat = pg_exec($conn,$sql_dat) or die($sql_dat);
		//echo $sql_dat."<br>";
	
		
		return $result_dat;
	}
	
	public function elimina($conn,$id){
		$sql="DELETE FROM citacion_asistencia WHERE id_asistencia=".$id;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
				
	}
	
	public function Mostrar($conn,$id){
		
		 $sql="select a.id_asistencia, c.id_citacion, c.fecha, 
				c.hora, c.id_asunto, a.estado, a.rut_apo,a.id_curso,c.motivo, a.atendido as rutatendido,
				asu.asunto, (em.ape_pat||' '||em.ape_mat||', '||em.nombre_emp) as atendido,
				(ap.ape_pat||' '||ap.ape_mat||', '||ap.nombre_apo) as nom_apo
				from citacion c 
				inner join citacion_asistencia a on c.id_citacion=a.id_citacion 
				left join citacion_asunto asu on asu.id_asunto = c.id_asunto
				left join empleado em on em.rut_emp = a.atendido
				left join apoderado ap on ap.rut_apo = a.rut_apo
				where a.id_asistencia=$id";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;	
	}
	
	public function Modifica($conn,$ano,$fecha,$hora,$asunto,$mensaje,$emp,$id){
		
		//datos citacion
		 $sql="update citacion set fecha='$fecha',hora='$hora',id_asunto=$asunto,motivo='$mensaje' where id_citacion=$id";
		$result1 = pg_exec($conn,$sql) or die($sql);
		
		 $sql2="update citacion_asistencia set atendido=$emp where id_citacion=$id";
			
		$result = pg_exec($conn,$sql2) or die($sql2);
		
		return $result;
	}
	

	
	public function AgregaAsunto($conn,$rdb,$nombre){
		$sql="INSERT INTO citacion_asunto (asunto,rdb) VALUES('".$nombre."',".$rdb.")";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;	
	}
	
	public function empleado($conn,$rdb,$rut=0){
		$sql = "SELECT distinct (empleado.rut_emp), empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, empleado.calle, empleado.nro, ";
		$sql.= "empleado.telefono, empleado.email, empleado.fecha_nacimiento,comuna.nom_com FROM (empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN ";
		$sql.= "institucion ON trabaja.rdb = institucion.rdb INNER JOIN comuna ON (empleado.region=comuna.cod_reg AND empleado.ciudad=comuna.cor_pro AND empleado.comuna=comuna.cor_com) ";
		$sql.= "WHERE institucion.rdb=".$rdb." ";
		
		if($rut!=0){
		$sql.= "and empleado.rut_emp=$rut ";
		}
		
		$sql.= "ORDER BY ape_pat, ape_mat, nombre_emp asc, trabaja.cargo";
		//echo $sql;
		$result = @pg_exec($conn,$sql);
		return $result;
	}
	
	public function cambiaEstado($conn,$id,$estado){
	$sql="update citacion_asistencia set estado=$estado where id_asistencia = $id";
	$result = pg_exec($conn,$sql) or die($sql);
		return $result;
	}
	
	
}
<? 
session_start();

class Enfermeria{
	
	
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
	
	public function alumno($conn,$curso){
		$sql="SELECT ape_pat ||' '|| ape_mat ||' '|| nombre_alu as nombre, a.rut_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." ORDER BY nombre ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function ListadoAtencion($conn,$ano,$curso,$rut){
		$sql="SELECT * FROM enfermeria WHERE id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$rut." ORDER BY fecha ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function Guardar($conn,$ano,$curso,$alumno,$fecha,$ingreso,$egreso,$consulta,$destino,$proced,$obs,$patologia,$motivo){
		
		/*$d=substr($fecha,0,2);
		$m=substr($fecha,3,2);
		$a=substr($fecha,6,4);
		$fecha = $m."-".$d."-".$a;*/
		
			$sql="INSERT INTO enfermeria (id_ano,id_curso,rut_alumno,fecha,hora_ingreso,hora_egreso,motivo_consulta,observaciones,procedimiento,destino,patologia,desc_motivo) VALUES(".$ano.",".$curso.",".$alumno.",'".$fecha."','".$ingreso."','".$egreso."','".utf8_decode($consulta)."','".utf8_decode($obs)."','".utf8_decode($proced)."','".utf8_decode($destino)."',".$patologia.",'".utf8_decode($motivo)."')";
		$result = pg_exec($conn,$sql) or die("no guarde:".$sql);
		
		return $result;
			
	}
	
	public function elimina($conn,$id){
		$sql="DELETE FROM enfermeria WHERE id_enfermeria=".$id;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
				
	}
	
	public function Mostrar($conn,$id){
		  $sql="select a.nombre_alu ||' '|| a.ape_pat ||' '|| a.ape_mat as nombre, c.grado_curso ||'-'|| c.letra_curso ||' '|| te.nombre_tipo as curso, e.*, ep.nombre as patol
		FROM enfermeria e 
		INNER JOIN alumno a ON e.rut_alumno=a.rut_alumno
		INNER JOIN curso c ON e.id_curso=c.id_curso
		INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
		INNER JOIN enfermeria_patologia ep ON ep.id_patologia=e.patologia
		WHERE id_enfermeria=".$id;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;	
	}
	
	public function Modifica($conn,$ano,$curso,$alumno,$fecha,$ingreso,$egreso,$consulta,$destino,$proced,$obs,$id,$patologia,$motivo){
		  $sql="UPDATE enfermeria SET fecha='".$fecha."',hora_ingreso='".$ingreso."',hora_egreso='".$egreso."',motivo_consulta='".utf8_decode($consulta)."',destino='".utf8_decode($destino)."',procedimiento='".utf8_decode($proced)."',observaciones='".utf8_decode($obs)."', patologia=$patologia,desc_motivo='".utf8_decode($motivo)."' WHERE id_enfermeria=".$id;
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
	}
	
	public function Patologia($conn,$rdb){
		$sql="SELECT id_patologia, nombre FROM enfermeria_patologia WHERE rdb=".$rdb." order by nombre";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;
		
	}
	
	public function AgregaPatologia($conn,$rdb,$nombre){
		$sql="INSERT INTO enfermeria_patologia (nombre,rdb) VALUES('".utf8_decode($nombre)."',".$rdb.")";
		$result = pg_exec($conn,$sql) or die($sql);
		
		return $result;	
	}
	
	public function ultimoEnfermeria($conn,$ano,$alumno){
	 $sql="select * from enfermeria where id_ano=$ano and rut_alumno = $alumno order by id_enfermeria desc limit 1"
	;
		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;	
	}
	
	public function cambiaEstado($conn,$id){
	 $sql="update enfermeria set visto =1 where id_enfermeria = $id";
	;
		$result = pg_exec($conn,$sql) or die("no pase por ultimo:".$sql);
		
		return $result;	
	}
	
}
<?

class Sms{
	
	public function Sms(){
		
	}
	
	public function Ano($conn,$ano){
		$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		$nro_ano = pg_result($result,0);
				
		return $nro_ano;
	}
	
	public function Curso($conn,$ano){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza, grado_curso, letra_curso ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function Alumno($conn,$curso,$ano){
		$sql="SELECT a.rut_alumno, a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." AND id_ano=".$ano." ";
		if($alumno!=0){
			$sql.=" a.rut_alumno=".$alumno;			
		}
		$sql.=" ORDER BY nombre_alumno ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}	
	
	public function BuscaApoderado($conn,$curso,$alumno,$ano){
		$sql="SELECT DISTINCT apo.rut_apo, apo.nombre_apo ||' '||apo.ape_pat as nombre_apoderado, celular FROM apoderado apo INNER JOIN tiene2 t ON t.rut_apo=apo.rut_apo  INNER JOIN matricula m ON m.rut_alumno=t.rut_alumno WHERE m.id_ano=".$ano."  ";
		
		if($curso!=0){
			$sql.=" AND id_curso=".$curso." ";
		}
		if($alumno!=0){
			$sql.=" AND m.rut_alumno=".$alumno;
		}
		$sql.="	ORDER BY nombre_apoderado ASC ";
		$result = pg_exec($conn,$sql);
		
		return $result;
			
	}
	
	public function AgregarMotivo($conn,$motivo,$rdb){
	 $sql="INSERT INTO sms_motivo (nombre,rdb) VALUES ('".$motivo."',".$rdb.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Motivo($conn,$rdb){
		$sql="SELECT id_motivo,nombre FROM sms_motivo WHERE rdb=".$rdb;	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Listado($conn,$curso,$alumno,$apoderado,$ano,$motivo){
		$sql="SELECT s.*, al.nombre_alu ||' '|| al.ape_pat as nombre_alumno, a.nombre_apo ||' '|| a.ape_pat as nombre_apoderado, sm.nombre as nombre_motivo
		FROM sms s 
		LEFT JOIN alumno al ON al.rut_alumno=s.rut_alumno
		INNER JOIN apoderado a ON a.rut_apo=s.rut_apo 
		INNER JOIN sms_motivo sm ON sm.id_motivo=s.id_motivo
		WHERE s.id_ano=".$ano;
		
		if($curso!=0){
			$sql.=" AND id_curso=".$curso;
		}
		if($alumno!=0){
			$sql.=" AND s.rut_alumno=".$alumno;
		}
		if($apoderado!=0){
			$sql.=" AND s.rut_apo=".$apoderado;
		}
		if($motivo!=0){
			$sql.=" AND s.id_motivo=".$motivo;	
		}
		$sql.=" ORDER BY fecha_envio ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}

	public function GuardaSMS($conn,$ano,$curso,$alumno,$apoderado,$mensaje,$fono,$rdb,$motivo){
	 	$sql="INSERT INTO sms (nro_telefono, rdb, rut_alumno, rut_apo, mensaje, fecha_envio, id_ano, id_curso, id_motivo) VALUES ('".trim($fono)."', ".$rdb.", ".$alumno.", ".$apoderado.", '".$mensaje."',now(), ".$ano.", ".$curso.", ".$motivo.")";
		$result = pg_exec($conn,$sql);
		
		$sql_sec=" SELECT currval('sms_id_sms_seq')";
		$rs_secuencial = pg_exec($conn,$sql_sec);
		$id_sms = pg_result($rs_secuencial,0);
		
		return $id_sms;
	}
	
	public function ModificaSMS($conn,$id,$codigo,$estado){
		$sql="UPDATE sms SET clave='".$codigo."', estado=".$estado." WHERE id_sms=".$id;	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function ModificaEstado($conn,$id,$fecha,$estado){
		$sql="UPDATE sms SET fecha_recepcion='".$fecha."', estado=".$estado." WHERE id_sms=".$id;	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function VistaPrevia($conn,$id){
		$sql="SELECT s.*, a.nombre_alu ||' '|| a.ape_pat as nombre_alumno, apo.nombre_apo ||' '|| apo.ape_pat as nombre_apoderado,m.nombre, ae.nro_ano
		FROM sms s 
		INNER JOIN alumno a ON a.rut_alumno=s.rut_alumno
		INNER JOIN apoderado apo ON apo.rut_apo=s.rut_apo
		INNER JOIN sms_motivo m ON m.id_motivo=s.id_motivo
		INNER JOIN ano_escolar ae ON ae.id_ano=s.id_ano
		WHERE id_sms=".$id;
		$result = pg_exec($conn,$sql);
		
		return $result;
 	
	}
	
	public function Recepcion($conn,$id,$codigo){
	  $sql="UPDATE sms SET fecha_recepcion='".$codigo."' WHERE id_sms=".$id;	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function Estadistica($conn,$rut,$ano,$mes){
		$sql="select count(*) AS cantidad from sms where id_ano=".$ano." and rut_alumno=".$rut."
				union
			  Select count(*) AS cantidad from sms where id_ano=".$ano." and rut_alumno=".$rut." and date_part('month',fecha_envio)=".$mes;
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}
	
	public function tengoSMS($connection,$rdb){
	  $sql="select sms from institucion where rdb=$rdb";
	$result = pg_exec($connection,$sql);
		
		return $result;
	}
	
	
	public function saldoSMS($conn,$rdb){
	$sql="select * from sms_config where rdb=$rdb and estado=1";
	$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function cuentaMAT($conn,$ano){
	$sql="select count(*) from matricula where id_ano=$ano and bool_ar=0";
	$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function caducaBolsa($conn,$idr){
	echo $sql="update sms_config set estado=0 where id_config = $idr";
	$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function descuentaSms($conn,$rdb){
		$sql="update sms_config set saldo = saldo-1 where rdb=$rdb and estado=1;";
		$result = pg_exec($conn,$sql);
		
		return $result;
	
	}
	
}


?>
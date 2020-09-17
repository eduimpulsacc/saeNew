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
		$sql="SELECT a.rut_alumno, a.ape_pat ||' '|| a.ape_mat ||' '|| a.nombre_alu as nombre_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." AND id_ano=".$ano." and m.bool_ar=0 ";
		if($alumno!=0){
			$sql.=" a.rut_alumno=".$alumno;			
		}
		$sql.=" ORDER BY nombre_alumno ASC";
		$result = pg_exec($conn,$sql);
		
		return $result;
	}	
	
	public function BuscaApoderado($conn,$curso,$alumno,$ano){
		$sql="SELECT DISTINCT apo.rut_apo, apo.nombre_apo ||' '||apo.ape_pat as nombre_apoderado, celular FROM apoderado apo INNER JOIN tiene2 t ON t.rut_apo=apo.rut_apo  INNER JOIN matricula m ON m.rut_alumno=t.rut_alumno WHERE m.id_ano=".$ano." and m.bool_ar=0 ";
		
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
		$sql="SELECT s.*, case when (s.rut_alumno<>0) then al.nombre_alu ||' '|| al.ape_pat 
else ' ' end as nombre_alumnos, a.nombre_apo ||' '|| a.ape_pat as nombre_apoderado, sm.nombre as nombre_motivo
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
		$sql.=" ORDER BY fecha_envio DESC";
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}

	public function GuardaSMS($conn,$ano,$curso,$alumno,$apoderado,$mensaje,$fono,$rdb,$motivo){
	 	echo $sql="INSERT INTO sms (nro_telefono, rdb, rut_alumno, rut_apo, mensaje, fecha_envio, id_ano, id_curso, id_motivo,tipo_usuario,estado,tipo_mensaje) VALUES ('".trim($fono)."', ".$rdb.", ".$alumno.", ".$apoderado.", '".$mensaje."',now(), ".$ano.", ".$curso.", ".$motivo.",2,1,1)";
		$result = pg_exec($conn,$sql);
		
		$sql_sec=" SELECT currval('sms_id_sms_seq')";
		$rs_secuencial = pg_exec($conn,$sql_sec);
		$id_sms = pg_result($rs_secuencial,0);
		
		return $id_sms;
	}
	
	
	public function GuardaSMS2($conn,$ano,$curso,$alumno,$apoderado,$mensaje,$fono,$rdb,$motivo,$tipo){
	 	$sql="INSERT INTO sms (nro_telefono, rdb, rut_alumno, rut_apo, mensaje, fecha_envio, id_ano, id_curso, id_motivo,tipo_usuario,estado,tipo_mensaje) VALUES ('".trim($fono)."', ".$rdb.", 0, ".$apoderado.", '".$mensaje."',now(), ".$ano.", 0 ,".$motivo.",$tipo,1,1)";
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
		 $sql="
		UPDATE sms SET fecha_recepcion='".$fecha."', estado=".$estado." WHERE id_sms=".$id;	
		$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function VistaPrevia($conn,$id,$via){
		if($via==1){
			$tabla = "sms";
			$campo = "id_sms";
			$sql="SELECT s.*, a.nombre_alu ||' '|| a.ape_pat as nombre_alumno, apo.nombre_apo ||' '|| apo.ape_pat as nombre_apoderado,m.nombre, ae.nro_ano
		FROM $tabla s 
		left JOIN alumno a ON a.rut_alumno=s.rut_alumno
		left JOIN apoderado apo ON apo.rut_apo=s.rut_apo
		left JOIN sms_motivo m ON m.id_motivo=s.id_motivo
		left JOIN ano_escolar ae ON ae.id_ano=s.id_ano
		WHERE $campo=".$id;
		}
		else{
			$tabla = "sms_comu";
			$campo = "id_comu";
			$sql=" SELECT s.*, a.nombre_alu ||' '|| a.ape_pat as nombre_alumno, 
 apo.nombre_apo ||' '|| apo.ape_pat as nombre_apoderado,m.nombre, ae.nro_ano 
 FROM $tabla s left JOIN alumno a ON a.rut_alumno=s.rut_destino 
 LEFT JOIN tiene2 t on t.rut_alumno = s.rut_destino 
 left JOIN apoderado apo ON apo.rut_apo=t.rut_apo 
 left JOIN sms_motivo m ON m.id_motivo=s.id_motivo
 left JOIN ano_escolar ae ON ae.id_ano=s.id_ano WHERE id_comu=$campo";
		}
		
		
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
	
	public function tengoComu($connection,$rdb){
	  $sql="select comunicapp from institucion where rdb=$rdb";
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
	 $sql="update sms_config set estado=0 where id_config = $idr";
	$result = pg_exec($conn,$sql);
		
		return $result;
	}
	
	public function descuentaSms($conn,$rdb){
		$sql="update sms_config set saldo = saldo-1 where rdb=$rdb and estado=1;";
		$result = pg_exec($conn,$sql);
		
		return $result;
	
	}
	
public function Grupos($conn,$rdb){
	$sql="select * from grupos where rdb=$rdb";
	$result = pg_exec($conn,$sql);
		
		return $result;	
	
}	
	
	//function destinatario grupo
	public function ArmaGrupo($conn,$grupo){
		
	   $sql="select al.rut_alumno rint,al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu nombre_int ,1 as tipo,al.celular 
from alumno al where al.rut_alumno in (select rut_integrante from relacion_grupo where id_grupo=$grupo)
union select ap.rut_apo rint,ap.ape_pat||' '||ap.ape_mat||' '||ap.nombre_apo nombre_int,2 as tipo,ap.celular
 from apoderado ap where ap.rut_apo in (select rut_integrante from relacion_grupo where id_grupo=$grupo)
 union select em.rut_emp rint,em.ape_pat||' '||em.ape_mat||' '||em.nombre_emp nombre_int,3 as tipo,em.celular
 from empleado em where em.rut_emp in (select rut_integrante from relacion_grupo where id_grupo=$grupo)

";
$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	public function ArmaGrupo2($conn,$grupo,$ano){
$sql="select al.rut_alumno rint,al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu nombre_int ,
1 as tipo,al.celular from alumno al INNER JOIN matricula m ON m.rut_alumno=al. rut_alumno AND id_ano=$ano and m.bool_ar=0
where al.rut_alumno in (select rut_integrante from relacion_grupo where id_grupo=$grupo) 
union 
select ap.rut_apo rint,ap.ape_pat||' '||ap.ape_mat||' '||ap.nombre_apo nombre_int,
2 as tipo,ap.celular 
from apoderado ap 
INNER JOIN tiene2 t ON ap.rut_apo=t.rut_apo 
INNER JOIN matricula m ON m.rut_alumno=t.rut_alumno
AND bool_ar=0 and id_ano=$ano
where ap.rut_apo in (select rut_integrante 
from relacion_grupo where id_grupo=$grupo)
union
select em.rut_emp rint,em.ape_pat||' '||em.ape_mat||' '||em.nombre_emp nombre_int,
3 as tipo,em.celular from empleado em INNER JOIN trabaja t ON t.rut_emp=em.rut_emp where em.rut_emp in (select rut_integrante from relacion_grupo 
 where id_grupo=$grupo)";
$result = pg_exec($conn,$sql);
		
		return $result;	
	}
	
	
public function filtroSMS($conn,$asunto,$fecha){
	 $sql="select * from sms where cast(fecha_envio as date) ='$fecha' and id_motivo=$asunto
	";
	$result = pg_exec($conn,$sql);
	
	return $result;	
	}
	

public function listaPlantilla($conn,$rbd){
	$sql="SELECT * FROM sms_plantilla WHERE rbd=".$rbd." order by id_plantilla";	
		$result = pg_exec($conn,$sql);
		
		return $result;
}

public function AgregarPlantilla($conn,$titulo,$mensaje,$rbd){
   $sql="INSERT INTO sms_plantilla (titulo,texto,rbd) VALUES ('".$titulo."','".$mensaje."',".$rbd.")";
		$result = pg_exec($conn,$sql);
		
		return $result;
}

public function cargaPlantilla($conn,$id){
 $sql="SELECT * FROM sms_plantilla WHERE id_plantilla=".$id;	
		$result = pg_exec($conn,$sql);
		
		return $result;

}

public function CargoEmpleado($conn,$usuario,$rdb){
$sql="select t.cargo,c.nombre_cargo 
from trabaja t inner join cargos c on c.id_cargo = t.cargo 
where t.rut_emp = $usuario and t.rdb=$rdb order by identificador asc limit 1";
$result = pg_exec($conn,$sql);
		
		return $result;

}

public function guardaMensajeCom($conn,$token,$rbd,$curso,$destinatario,$user,$fecha,$hora,$modo,$user_type,$texto,$tipomensaje,$motivo,$ano){
 $sql="insert into sms_comu(token,rdb,id_curso,rut_destino,rut_origen,fecha,hora,modo,tipo_usuario,mensaje,tipo_mensaje,estado,id_motivo,id_ano) values ('$token',$rbd,$curso,$destinatario,$user,'$fecha','$hora','$modo',$user_type,'$texto',$tipomensaje,0,$motivo,$ano)";
$result = pg_exec($conn,$sql) or die("no->".$sql);
return $result;
}

public function alumnosAct($conn,$ano){
	   $sql="select rut_alumno,id_curso from matricula where id_ano=$ano and bool_ar=0 order by id_curso";
	$result = pg_exec($conn,$sql);
		
		return $result;
	}


	public function ListadoNew($conn,$ano,$motivo,$desde="",$hasta="",$tabla,$fec,$via,$modulo){
		$cad="";
		
		if($desde!="" && $hasta !=""){
			$bfecha =($via==1)?"fecha_envio":"fecha";
			$cad=" and $bfecha between '$desde' and '$hasta'";
		}
		
		if($modulo!=0){
		$mod  = " and tipo_mensaje=$modulo";
		}

		if($via==1){
		
		
		$sql="SELECT s.*, case when (s.rut_alumno<>0) then al.nombre_alu ||' '|| al.ape_pat 
else ' ' end as nombre_alumnos, a.nombre_apo ||' '|| a.ape_pat as nombre_apoderado, sm.nombre as nombre_motivo
		FROM $tabla s 
		LEFT JOIN alumno al ON al.rut_alumno=s.rut_alumno
		INNER JOIN apoderado a ON a.rut_apo=s.rut_apo 
		INNER JOIN sms_motivo sm ON sm.id_motivo=s.id_motivo
		WHERE s.id_ano=".$ano." $cad $mod";
		
		if($motivo!=0){
			$sql.=" AND s.id_motivo=".$motivo;	
		}
		}

		if($via==2){
			$sql="SELECT s.*,  al.nombre_alu ||' '|| al.ape_pat nombre_alumno, a.nombre_apo ||' '|| a.ape_pat as nombre_apoderado, sm.nombre as nombre_motivo
			FROM $tabla s 
			INNER JOIN alumno al ON al.rut_alumno=s.rut_destino
			LEFT JOIN tiene2 t on t.rut_alumno = al.rut_alumno 
			LEFT JOIN apoderado a on a.rut_apo = t.rut_apo 
			INNER JOIN sms_motivo sm ON sm.id_motivo=s.id_motivo
			where s.id_ano=".$ano." $cad $mod ";
		}
		
		
		$sql.=" ORDER BY $fec DESC";
		//echo $sql;
		
		$result = pg_exec($conn,$sql);
		
		return $result;
		
	}

public function buscaCursoAlu($conn,$ali,$ano){
echo $sql="select id_curso from matricula where id_ano = $ano and rut_alumno = $ali and bool_ar=0";
$result = pg_exec($conn,$sql);
		
		return $result;
	
}

}//fin clase


?>
<?
session_start();
class Vitacora {
private $conect;       


//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	
	
       
	public function insertarantec($a,$b,$c,$d,$e,$f,$g,$h){ 
	$sql = "INSERT INTO vitacora_alumno(rut_alumno,id_ano,id_periodo,fecha,observacion,tipo,rdb,id_curso)
	VALUES ($a,$b,$c,'$d','$e',$f,$g,$h)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
        
public function actualizarantec($periodo,$fecha,$obser,$id_vitacora){
		
		
		$sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
		
		public function cargaantec($rut_alumno,$rdb,$curso){
		  $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.observacion,va.tipo,
			va.rdb,per.nombre_periodo,aes.nro_ano,tipo_ensenanza.nombre_tipo,
			curso.grado_curso, curso.letra_curso
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE  rdb=$rdb AND rut_alumno = $rut_alumno AND tipo=1 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardoc" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}

public function buscarante($id_vitacora){

$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.observacion,va.tipo,
			va.rdb,per.nombre_periodo,aes.nro_ano,tipo_ensenanza.nombre_tipo,
			curso.grado_curso, curso.letra_curso
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
WHERE  tipo=1 AND id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardoc" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}		
		
		
		
	public function EliminaAnte($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 	
		
		
		
		public function insertarDae($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
 $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,concepto,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,$d,'$e',$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 1".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
	
	public function cargaDae($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,
emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat 
as nombre_empleado, per.nombre_periodo,aes.nro_ano,conv.nombre,
curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo 
FROM vitacora_alumno va 
inner join periodo per on va.id_periodo=per.id_periodo
inner join conceptos_vitacora conv on va.concepto=conv.id_conceptos_vitacora
inner join empleado emp on va.rut_emp=emp.rut_emp
inner join ano_escolar aes on va.id_ano=aes.id_ano 
inner join curso on va.id_curso= curso.id_curso
inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
WHERE  va.rdb=$rdb AND rut_alumno = $rut_alumno and va.tipo=4 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		
		public function buscaDae($id_vitacora){
			
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,va.observacion,va.concepto,va.rut_emp,
    emp.nombre_emp ||'  '||  emp.ape_pat ||' '||  emp.ape_mat as nombre_empleado,
    per.nombre_periodo,aes.nro_ano,conv.nombre
FROM vitacora_alumno va
inner join periodo per on va.id_periodo=per.id_periodo
inner join conceptos_vitacora conv on va.concepto=conv.id_conceptos_vitacora 
inner join empleado emp on va.rut_emp=emp.rut_emp
inner join ano_escolar aes on  va.id_ano=aes.id_ano
WHERE  va.tipo=4 AND id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardoc" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		
		public function actualizarDae($periodo,$fecha,$concepto,$docente,$obser,$id_vitacora){
		 $sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',  concepto='$concepto', rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
	public function EliminaDae($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 			
		
		
		
		public function insertarApo($a,$b,$c,$d,$e,$f,$g,$h,$i,$J,$k){ 
  $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,profesional,rut_apo,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,$d,$e,'$f',$g,$h,$i,$J,$k)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert EntApo".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
		public function cargaApo($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, apo.nombre_apo ||' '|| apo.ape_mat ||' '|| apo.ape_pat
			as nombre_apoderado, cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo 
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			inner join apoderado apo on va.rut_apo= apo.rut_apo 
			left join empleado emp on va.rut_emp=emp.rut_emp
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE  va.rdb=$rdb AND rut_alumno = $rut_alumno and va.tipo=5 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardoc" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		public function buscaApo($id_vitacora){
			
		$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,va.observacion,per.nombre_periodo,va.rut_emp,
			emp.nombre_emp ||'  '||  emp.ape_pat ||' '||  emp.ape_mat as nombre_empleado,
			aes.nro_ano,
			apo.nombre_apo ||'  '|| apo.ape_mat  ||' '|| apo.ape_pat as nombre_apoderado,apo.rut_apo,
			cvi.id_conceptos_vitacora,cvi.nombre
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo
			inner join apoderado apo on va.rut_apo= apo.rut_apo
			left join empleado emp on va.rut_emp=emp.rut_emp
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on  va.id_ano=aes.id_ano
			WHERE  va.tipo=5 and id_vitacora=$id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarEntApo" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		
	public function actualizarApo($periodo,$fecha,$evaluador,$rutApo,$docente,$obser,$id_vitacora){
		$sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha', profesional=$evaluador,  rut_apo=$rutApo, rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}	
		
	public function EliminaApo($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 				
		
		
	public function insertarAlum($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
  $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,profesional,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,'$d','$e',$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert 11".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}	
		
		
		public function cargaAlum($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso, 
			tipo_ensenanza.nombre_tipo
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano 
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE va.rdb=$rdb AND rut_alumno = $rut_alumno and va.tipo=6 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarAlum" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		
		public function buscaAlum($id_vitacora){
			
		$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,va.rut_emp,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on 
			va.id_ano=aes.id_ano WHERE va.tipo=6 and id_vitacora=$id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarEntApo" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
		
		public function actualizarAlum($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora){
		 $sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',profesional=$evaluador, rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}	
		
		
		public function EliminaAlum($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			 				
		
		
		public function insertarDerInt($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
  $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,profesional,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,'$d','$e',$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert DerInt".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}	
		
		
		public function cargaDerInt($rut_alumno,$rdb){
		  $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo
			left join empleado emp on va.rut_emp=emp.rut_emp
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE va.rdb=$rdb AND rut_alumno=$rut_alumno and va.tipo=7 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarDerInt" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
		
		
		public function buscaDerInt($id_vitacora){
			
		$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,va.rut_emp,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on 
			va.id_ano=aes.id_ano WHERE va.tipo=7 and id_vitacora=$id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarDerInt" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
		
		public function actualizarDerInt($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora){
		 $sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',profesional=$evaluador, rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
		public function EliminaDerInt($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}			
		
		
		public function insertarDerExt($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
  $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,profesional,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,'$d','$e',$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert DerInt".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
		public function cargaDerExt($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on va.id_ano=aes.id_ano 
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE  va.rdb=$rdb AND rut_alumno=$rut_alumno and va.tipo=8 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarDerExt" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
		
		
		public function buscaDerExt($id_vitacora){
			
		$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,va.rut_emp,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on 
			va.id_ano=aes.id_ano WHERE va.tipo=8 and id_vitacora=$id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarDerExt" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
			
		public function actualizarDerExt($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora){
		 $sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',profesional=$evaluador, rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
			public function EliminaDerExt($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}
		
		
		
		public function insertarAcTom($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
  $sql = "INSERT INTO vitacora_alumno(id_periodo,fecha,profesional,rut_emp,observacion,id_ano,rut_alumno,tipo,rdb,id_curso)
	VALUES ($a,'$b',$c,'$d','$e',$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert DerInt".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
		public function cargaAcTom($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo 
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE  va.rdb=$rdb AND rut_alumno=$rut_alumno and va.tipo=9 order by 1 ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarAcTom" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
	
		
		public function buscaAcTom($id_vitacora){
			
		$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,va.rut_emp,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on 
			va.id_ano=aes.id_ano WHERE va.tipo=9 and id_vitacora=$id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarAcTom" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		
		}
		
		
			public function actualizarAcTom($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora){
		 $sql = "UPDATE vitacora_alumno SET id_periodo = $periodo, fecha = '$fecha',profesional=$evaluador, rut_emp= $docente, observacion='$obser' WHERE id_vitacora =  $id_vitacora ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		
			public function EliminaAcTom($id_vitacora){
			$sql="DELETE FROM vitacora_alumno WHERE id_vitacora =  $id_vitacora;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}
		
		
		public function insertarDestaca($a,$b,$c,$d,$e,$f,$g,$h,$i,$j){ 
    $sql = "INSERT INTO vitacora_destaca(id_periodo,fecha,destaca_1,destaca_2,destaca_3,destaca_4,id_ano,rut_alumno,rdb,id_curso)
	VALUES ($a,'$b',$c,$d,$e,$f,$g,$h,$i,$j)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert Destaca".$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		public function cargaDestaca($rut_alumno,$rdb){
		 $sql = "SELECT va.id_vitacora_destaca,va.id_periodo,va.fecha, curso.grado_curso,
			curso.letra_curso,tipo_ensenanza.nombre_tipo, 
			case when (va.destaca_1<>0) then 
			(select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_1)
			else '-' END as destaca1, case when (va.destaca_2<>0) then
			(select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_2) else '-' END as destaca2,
			case when (va.destaca_3<>0) then
			(select nombre from conceptos_vitacora
			where id_conceptos_vitacora=va.destaca_3)
			else '-' END as destaca3, case when (va.destaca_4<>0) 
			then (select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_4)
			else '-' END as destaca4, va.destaca_1,va.destaca_2, va.destaca_3,
			va.destaca_4,va.rdb, per.nombre_periodo, aes.nro_ano 
			FROM vitacora_destaca va left join conceptos_vitacora cv
			on va.destaca_1=cv.id_conceptos_vitacora
			inner join periodo per on va.id_periodo=per.id_periodo 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE va.rdb=$rdb and rut_alumno=$rut_alumno order by 1;";

		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarAcTom" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
		
		
		public function buscaDestaca($id_vitacora_destaca){
			
		$sql = "SELECT va.id_vitacora_destaca,va.id_periodo,va.fecha,
		case when (va.destaca_1<>0) then (select nombre from conceptos_vitacora where id_conceptos_vitacora=va.destaca_1)  else '-' END as destaca1,
		case when (va.destaca_2<>0) then (select nombre from conceptos_vitacora where id_conceptos_vitacora=va.destaca_2) else '-' END as destaca2,
		case when (va.destaca_3<>0) then (select nombre from conceptos_vitacora where id_conceptos_vitacora=va.destaca_3) else '-' END as destaca3,
		case when (va.destaca_4<>0) then (select nombre from conceptos_vitacora where id_conceptos_vitacora=va.destaca_4) else '-' END as destaca4,
		va.destaca_1,va.destaca_2,
		va.destaca_3,va.destaca_4,va.rdb, per.nombre_periodo,
		aes.nro_ano, cv.id_conceptos_vitacora
		FROM vitacora_destaca va
		left join conceptos_vitacora cv on va.destaca_1=cv.id_conceptos_vitacora
		inner join periodo per on va.id_periodo=per.id_periodo 
		inner join ano_escolar aes on 
		va.id_ano=aes.id_ano WHERE id_vitacora_destaca=$id_vitacora_destaca;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarDestaca" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
		
			public function actualizarDestaca($periodo,$fecha,$destaca1,$destaca2,$destaca3,$destaca4,$id_vitacora_destaca){
		 $sql = "UPDATE vitacora_destaca SET id_periodo = $periodo, fecha = '$fecha',destaca_1=$destaca1, destaca_2= $destaca2, destaca_3=$destaca3,destaca_4=$destaca4 WHERE id_vitacora_destaca =  $id_vitacora_destaca ;";
		$regis = pg_Exec( $this->conect,$sql);
			if($regis){
				   return true;
			}else{
				  return false;
			}
		
		}
		
		public function EliminaDestaca($id_vitacora_destaca){
			$sql="DELETE FROM vitacora_destaca WHERE id_vitacora_destaca =  $id_vitacora_destaca;";
			$result = pg_Exec( $this->conect,$sql ) or die( "Delete fallo:" );
			if($result){
				   return $result;
			}else{
				  return false;
			}
		}
	
	public function cargaRendimiento($rut_alumno,$rdb,$periodo,$nro_ano){
	 $sql = "select ramo.id_ramo,subsector.nombre, notas$nro_ano.promedio
from tiene$nro_ano 
inner join ramo on tiene$nro_ano.id_ramo=ramo.id_ramo
inner join subsector on ramo.cod_subsector=subsector.cod_subsector
left join notas$nro_ano on tiene$nro_ano.id_ramo=notas$nro_ano.id_ramo and tiene$nro_ano.rut_alumno
=notas$nro_ano.rut_alumno and notas$nro_ano.id_periodo=".$periodo."
where tiene$nro_ano.rut_alumno=".$rut_alumno;

		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarRendimiento" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
	
		
		public function buscaNotas($rut_alumno,$rdb,$periodo,$nro_ano,$id_ramo){
		 $sql = "SELECT notas$nro_ano.nota1, notas$nro_ano.nota2, notas$nro_ano.nota3, notas$nro_ano.nota4, notas$nro_ano.nota5, notas$nro_ano.nota6, notas$nro_ano.nota7, notas$nro_ano.nota8, notas$nro_ano.nota9, notas$nro_ano.nota10, notas$nro_ano.nota11, notas$nro_ano.nota12, notas$nro_ano.nota13, notas$nro_ano.nota14, notas$nro_ano.nota15, notas$nro_ano.nota16, notas$nro_ano.nota17,notas$nro_ano.nota18, notas$nro_ano.nota19, notas$nro_ano.nota20, notas$nro_ano.promedio,notas$nro_ano.id_ramo,sub.nombre 
			FROM notas$nro_ano
			INNER join ramo r on notas$nro_ano.id_ramo=r.id_ramo
            inner join subsector sub on r.cod_subsector= sub.cod_subsector
			
			WHERE (((notas$nro_ano.rut_alumno)='".$rut_alumno."') AND ((notas$nro_ano.id_ramo)=".$id_ramo.") AND             ((notas$nro_ano.id_periodo)=".$periodo.")); ";

		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarRendimiento" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}	
		
		
		
	public function insertarRendimento($periodo,$fecha,$ano,$rutalumno,$observacion,$id_ramo,$rdb,$nota,$id_vitacora_nota,$curso){ 
	
	$query1 = "SELECT id_ramo 
		FROM detalle_vitacora_nota dvn
		inner join vitacora_nota vn on dvn.id_vitacora_nota=vn.id_vitacora_nota 
		WHERE id_ramo = $id_ramo and id_periodo=$periodo AND vn.id_ano=$ano and vn.rdb=$rdb
		and vn.rut_alumno=$rutalumno";
	$regis1 = pg_Exec($this->conect,$query1) or die( "Error bd Select id_vitacora_nota".$query1);
		if(pg_num_rows($regis1)>0){
			return false;
			}
			
   $sql = "INSERT INTO vitacora_nota(id_periodo,fecha,id_ano,rut_alumno,rdb)
	VALUES ($periodo,'$fecha',$ano,$rutalumno,$rdb)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis = pg_Exec($this->conect,$sql) or die( "Error bd insert rendimiento".$sql);
			
			
		 $sql2="SELECT vnot.id_vitacora_nota FROM vitacora_nota as vnot ORDER BY vnot.id_vitacora_nota DESC LIMIT 1;";	
		$regis2 = pg_Exec($this->conect,$sql2) or die( "Error bd Select id_vitacora_nota".$sql2);
		$filanota = pg_fetch_array($regis2,0);
		$idql=$filanota['id_vitacora_nota'];
		
		
		
		 $sql3 = "INSERT INTO detalle_vitacora_nota(id_vitacora_nota,id_ramo,nota,observacion,id_curso)
	VALUES (".$filanota['id_vitacora_nota'].",$id_ramo,$nota,'$observacion',$curso)";
		//$sql = "INSERT INTO vitacora_alumnos ( nombre,rdb) VALUES ( '$nombre',$rdb );";
		$regis3 = pg_Exec($this->conect,$sql3) or die( "Error bd insert 2".$sql3);
			if($regis3){
				   return true;
			}else{
				  return false;
			}
		}
		
		
public function cargatablaRendimiento($rut_alumno,$rdb,$periodo,$nro_ano){
			
	 $sql = "select DISTINCT aes.nro_ano,vn.id_periodo,vn.rdb,vn.rut_alumno,
per.nombre_periodo, vn.id_ano,curso.grado_curso, curso.letra_curso, 
tipo_ensenanza.nombre_tipo
from vitacora_nota vn
inner join detalle_vitacora_nota as detvit on vn.id_vitacora_nota = detvit.id_vitacora_nota
inner join periodo per on vn.id_periodo=per.id_periodo
inner join ano_escolar aes on vn.id_ano=aes.id_ano
inner join curso on detvit.id_curso=curso.id_curso
inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
		where vn.rdb=$rdb and vn.id_periodo=$periodo 
		and vn.rut_alumno=$rut_alumno order by aes.nro_ano DESC;";
     $regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select Rendimiento");
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		
		}
		
		
		public function cargadatosRendimiento($rut_alumno,$rdb,$periodo,$nro_ano){
			
	 $sql = "select subsector.nombre,dvn.observacion,vn.fecha
from detalle_vitacora_nota dvn
inner join ramo on dvn.id_ramo=ramo.id_ramo
inner join subsector on ramo.cod_subsector=subsector.cod_subsector
inner join vitacora_nota vn on dvn.id_vitacora_nota=vn.id_vitacora_nota
where vn.id_ano=$nro_ano and 
vn.rdb=$rdb and vn.id_periodo=$periodo and vn.rut_alumno=$rut_alumno;";
     $regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select  datos Rendimiento");
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		
		}
		
		
	public function dialogAnte($id_vitacora){

$sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.observacion,va.tipo,
			va.rdb,per.nombre_periodo,aes.nro_ano,tipo_ensenanza.nombre_tipo,
			curso.grado_curso, curso.letra_curso
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
WHERE  tipo=1 AND id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardoc".$sql );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}			
		
		
	public function dialogDestaca($id_vitacora_destaca){
		 $sql = "SELECT va.id_vitacora_destaca,va.id_periodo,va.fecha, curso.grado_curso,
			curso.letra_curso,tipo_ensenanza.nombre_tipo,
			case when (va.destaca_1<>0) then 
			(select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_1)
			else '-' END as destaca1, case when (va.destaca_2<>0) then
			(select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_2) else '-' END as destaca2,
			case when (va.destaca_3<>0) then
			(select nombre from conceptos_vitacora
			where id_conceptos_vitacora=va.destaca_3)
			else '-' END as destaca3, case when (va.destaca_4<>0) 
			then (select nombre from conceptos_vitacora 
			where id_conceptos_vitacora=va.destaca_4)
			else '-' END as destaca4, va.destaca_1,va.destaca_2, va.destaca_3,
			va.destaca_4,va.rdb, per.nombre_periodo, aes.nro_ano 
			FROM vitacora_destaca va left join conceptos_vitacora cv
			on va.destaca_1=cv.id_conceptos_vitacora
			inner join periodo per on va.id_periodo=per.id_periodo 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
			WHERE id_vitacora_destaca=$id_vitacora_destaca;";

		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscarAcTom" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
		}		
		
		
		public function dialogDae($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,va.observacion,
emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat 
as nombre_empleado, per.nombre_periodo,aes.nro_ano,conv.nombre,
curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo 
FROM vitacora_alumno va 
inner join periodo per on va.id_periodo=per.id_periodo
inner join conceptos_vitacora conv on va.concepto=conv.id_conceptos_vitacora
inner join empleado emp on va.rut_emp=emp.rut_emp
inner join ano_escolar aes on va.id_ano=aes.id_ano 
inner join curso on va.id_curso= curso.id_curso
inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
WHERE  va.tipo=4 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}	
		
		
		
	public function dialogApo($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, apo.nombre_apo ||' '|| apo.ape_mat ||' '|| apo.ape_pat
			as nombre_apoderado, cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo,va.observacion
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			inner join apoderado apo on va.rut_apo= apo.rut_apo 
			left join empleado emp on va.rut_emp=emp.rut_emp
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
            WHERE  va.tipo=5 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}		
		
		
		public function dialogAlum($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso, 
			tipo_ensenanza.nombre_tipo
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano 
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
            WHERE  va.tipo=6 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae" );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}		
		
		public function dialogDerInt($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo
			FROM vitacora_alumno va
			inner join periodo per on va.id_periodo=per.id_periodo
			left join empleado emp on va.rut_emp=emp.rut_emp
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora 
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
            WHERE  va.tipo=7 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae".$sql );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}		
		
		
		
		public function dialogDerExt($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo,
emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo
FROM vitacora_alumno va 
inner join periodo per on va.id_periodo=per.id_periodo 
left join empleado emp on va.rut_emp=emp.rut_emp 
inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
inner join ano_escolar aes on va.id_ano=aes.id_ano 
inner join curso on va.id_curso=curso.id_curso
inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
            WHERE  va.tipo=8 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae".$sql );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
		
		public function dialogAcTom($id_vitacora){
		 $sql = "SELECT va.id_vitacora,va.id_periodo,va.fecha,va.tipo,per.nombre_periodo, 
			emp.nombre_emp ||' '|| emp.ape_pat ||' '|| emp.ape_mat as nombre_empleado,
			aes.nro_ano, va.observacion,cvi.id_conceptos_vitacora,cvi.nombre,
			curso.grado_curso, curso.letra_curso,tipo_ensenanza.nombre_tipo 
			FROM vitacora_alumno va 
			inner join periodo per on va.id_periodo=per.id_periodo 
			left join empleado emp on va.rut_emp=emp.rut_emp 
			inner join conceptos_vitacora cvi on va.profesional=cvi.id_conceptos_vitacora
			inner join ano_escolar aes on va.id_ano=aes.id_ano
			inner join curso on va.id_curso=curso.id_curso
			inner join tipo_ensenanza on curso.ensenanza=tipo_ensenanza.cod_tipo
            WHERE  va.tipo=9 AND va.id_vitacora = $id_vitacora ;";
		$regis = pg_Exec($this->conect,$sql ) or die( "Error bd Select buscardae".$sql );
			if($regis){
				   return $regis;
			}else{
				  return false;
			}
			
		
		}
		
		
	 public function ingreso_apoderado($rut_apo,$dig_rut,$nombre_apo,$ape_pat,$ape_mat,$telefono,$email,$rut_alumno){
		 
	$sql = "INSERT INTO apoderado(rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,telefono,email) 
	VALUES ($rut_apo,'$dig_rut','$nombre_apo','$ape_pat','$ape_mat','$telefono','$email');";
	$reg=pg_Exec($this->conect,$sql)or die("Fallo Insert Apo".$sql);
	
	$sqlt ="INSERT INTO TIENE2 (rut_apo,rut_alumno,responsable,sostenedor)  VALUES
		   (".$rut_apo.",".$rut_alumno.",1,0);";
	 $regt=pg_Exec($this->conect,$sqlt)or die("Fallo Insertt Tiene2".$sqlt);
		 if($regt){
		 return 0;
		 }else{
		 return 1;
		 } 
     }					
	 
	 
	 public function cargaSelectApo($rutusuario){

	$sql ="select apo.nombre_apo,apo.ape_pat,apo.ape_mat,apo.rut_apo,apo.id_usuario
		   from apoderado apo
           inner join tiene2 t on apo.rut_apo = t.rut_apo
           where t.rut_alumno=$rutusuario;";
	$regis=pg_Exec($this->conect,$sql)or die("Fallo Insertt Tiene2".$sql);	   
	 
		 if($regis){
				   return $regis;
			}else{
				  return false;
			}
     }					
	 
		
			 
} // FIN FUNCION


?>

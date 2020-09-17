<? 
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require('../../../../util/header.inc');



class SubirArchivo {
	private $conect;       

//constructor 
public function __construct($con){ 
		
	$this->conect = $con;	
       
    }
	
	
public function get_tipo_archivos_publicos($rdb,$id_ano)
	{
	 $sql="select * from tipo_archivos_publicos where rdb=$rdb and id_ano=$id_ano";
	 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}

public function add_tipo($rdb,$id_ano,$tipo)
{
	$sql="insert into tipo_archivos_publicos (rdb,id_ano,tipo_archivo) values ($rdb,$id_ano,'$tipo')";
	$regis = pg_Exec($this->conect,$sql)or die("fx ".$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}	
	
	
	public function InsertaArchivo($rdb,$_ANO,$txtFECHA,$txt_observacion,$nombre_archivo,$estado,$vista_al,$tipo,$vista_apo)
	{
		  $sql="insert into public.archivos_publicos
		(
		rdb,
		id_ano,
		fecha,
		observacion,
		nombre_archivo,
		estado,
		vista_al,
		id_tipo,
		vista_apo
		) 
		VALUES
		($rdb,$_ANO,'$txtFECHA','$txt_observacion','$nombre_archivo',$estado,$vista_al,$tipo,$vista_apo)";
		
		
		
		$regis = pg_Exec($this->conect,$sql)or die("fx ".$sql);		
		if($regis){
		return $regis;
		}else{
		return false;
	 }
	}
	
	 /*public function carga_empleados($rdb){
		
	 $sql="SELECT distinct empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat 
	 FROM empleado INNER  JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp INNER JOIN institucion ON trabaja.rdb = institucion.rdb 
	 WHERE institucion.rdb=".$rdb." order by ape_pat, ape_mat, nombre_emp asc"; 
   $regis = pg_Exec($this->conect,$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function modifica_min($rut_emp,$fecha,$minutos){
		
		$sql="update atraso_minutosemp set minutos_atraso=".$minutos." where rut_empleado=".$rut_emp." and fecha_atraso='".$fecha."'";
		
			$regis = pg_Exec($this->conect,$sql);		
		 if($regis){
				   return true;
			}else{
				 return false;
		}
		
	}
	
	*/
	
	public function get_archivos_publicos($rdb,$id_ano)
	{
	  $sql="select * from archivos_publicos where rdb=$rdb and id_ano=$id_ano";
	 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}

	public function elimina_min($ida){
		
		$sql="delete from archivos_publicos where id_archivo=".$ida;
		
			$regis = pg_Exec($this->conect,$sql) or die( "Error bd 2".$sql);		
		 if($regis){
				   return true;
			}else{
				 return false;
		}
	}
	
	public function get_archivos_publicos_uno($archivo)
	{
	   $sql="select * from archivos_publicos where id_archivo=$archivo";
	 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}
	
	
public function getCursos($ano){
$sql="select id_curso from curso where id_ano=$ano order by ensenanza, grado_curso,letra_curso";
 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
} 

public function gArchivoCurso($archivo,$curso){
	  $sql="insert into archivos_publicos_vista values($archivo,$curso)";
	 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}


public function ultimoArchivo($rbd,$ano){
 $sql="select id_archivo from archivos_publicos where rdb=$rbd and id_ano=$ano order by id_archivo desc limit 1";
 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
}

public function delArchivoCurso($archivo){
	$sql="delete from archivos_publicos_vista where id_archivo=$archivo";
	 $regis = pg_Exec($this->conect,$sql);		
	 if($regis){
	  return $regis;
	 }else{
	  return false;
	 }
	}
}
?>
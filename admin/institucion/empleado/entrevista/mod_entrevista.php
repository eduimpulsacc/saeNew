<?php 
session_start();
require('../../../../util/header.inc');

class  Entrevista{
	
	private $conect;       

//constructor 
public function __construct($con){ 
      $this->conect = $con;  
    }
	
	public function traeAno($rbd){
	 $sql="select * from ano_escolar where id_institucion=$rbd order by nro_ano asc";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 0 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
	public function traeDocente($rbd){
	  $sql="select * from empleado inner join trabaja on trabaja.rut_emp=empleado.rut_emp and trabaja.cargo=5 AND trabaja.rdb=$rbd order by ape_pat,ape_mat,nombre_emp asc";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
	public function traeDirectivo($rbd){
	  $sql="select * from empleado inner join trabaja on trabaja.rut_emp=empleado.rut_emp and trabaja.cargo in(1,2,6,7,11,13,14,23,35,36,37,38) AND trabaja.rdb=$rbd order by ape_pat,ape_mat,nombre_emp asc";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	public function traeEmpleado($rut){
	  $sql="select * from empleado where rut_emp=$rut";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
		
	
	public function traeEntrevista($ano,$rut){
	$sql="select * from entrevista_docente where entrevistado=$rut and id_ano=$ano";	
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
		
	}
	
	public function traeAsunto($rdb){
	  $sql="select * from entrevista_docente_asunto where rdb=$rdb";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
	public function traeAsuntoDetalle($id){
	  $sql="select * from entrevista_docente_asunto where id_asunto=$id";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
	public function guardaAsunto($asunto,$rdb){
	  $sql="insert into entrevista_docente_asunto (asunto,rdb) values('".utf8_decode($asunto)."',$rdb)";	
		
	$result=pg_Exec($this->conect,$sql)or die("Fallo guarda asunto ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
	
	}
	
	public function guardaEntrevista($id_ano,$entrevistado,$entrevistador,$fecha,$observaciones,$asunto,$acuerdos,$compromisos){
		 $sql="insert into entrevista_docente(id_ano,entrevistado,entrevistador,fecha,observaciones,asunto,acuerdos,compromisos) values($id_ano,$entrevistado,$entrevistador,'".CambioFE($fecha)."','".utf8_decode($observaciones)."',$asunto,'$acuerdos','$compromisos')";
		
		$result=pg_Exec($this->conect,$sql)or die("Fallo guarda asunto ".$sql);
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
		
		}	
		
		
		public function borraEntrevista($id){
		 $sql="delete from entrevista_docente where id_entrevista=$id";
		
		$result=pg_Exec($this->conect,$sql)or die("Fallo guarda asunto ".$sql);
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
		
		}	
		
		
		
		public function traeEntrevistaDetalle($id){
	$sql="select * from entrevista_docente where id_entrevista=$id";	
	$result=pg_Exec($this->conect,$sql)or die("Fallo 1 ".$sql);
		
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
		
	}
	
	
	public function actualizaEntrevista($id_ano,$entrevistado,$entrevistador,$fecha,$observaciones,$asunto,$id_entrevista,$acuerdos,$compromisos){
		  $sql="update entrevista_docente set id_ano = $id_ano,entrevistado=$entrevistado,entrevistador=$entrevistador,fecha='".CambioFE($fecha)."',observaciones='".utf8_decode($observaciones)."',asunto=$asunto,acuerdos='$acuerdos',compromisos='$compromisos' where id_entrevista=$id_entrevista";
		
		$result=pg_Exec($this->conect,$sql)or die("Fallo guarda asunto ".$sql);
		if(!$result)
		{
			return false;	
		}else{
		
			return $result;
		}
		
		}	
		
	
}//fin clase
?>
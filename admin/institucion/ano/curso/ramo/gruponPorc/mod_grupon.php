<?php 
class Grupon{
	
	public function contructor(){
			
	}
	
	public function tablaCurso($conn,$curso,$ramo,$periodo){
		  $sql="select * from grupo_nota_ramo_porcentaje where id_curso=$curso and id_ramo=$ramo and id_periodo=$periodo order by id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	public function nombreSubsector($conn,$ramo){
	 $sql="select s.nombre from subsector s inner join ramo r on r.cod_subsector= s.cod_subsector where id_ramo = $ramo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	public function guardaGrupo($conn,$id_ano,$id_curso,$id_ramo,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,$leccionario,$orden,$periodo){
		
		$sql="insert into grupo_nota_ramo_porcentaje(id_ano,id_curso,id_ramo,porcentaje,nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11,nota12,nota13,nota14,nota15,nota16,nota17,nota18,nota19,nota20,nombre,orden,id_periodo) values($id_ano,$id_curso,$id_ramo,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,'$leccionario',$orden,$periodo)";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}
	
	public function tablaGrupo($conn,$grupo){
		$sql="select * from grupo_nota_ramo_porcentaje where id_grupo=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}
	
	public function actualizaGrupo($conn,$id_grupo,$porcentaje,$nota1,$nota2,$nota3,$nota4,$nota5,$nota6,$nota7,$nota8,$nota9,$nota10,$nota11,$nota12,$nota13,$nota14,$nota15,$nota16,$nota17,$nota18,$nota19,$nota20,$leccionario,$orden){
		
		 $sql="update  grupo_nota_ramo_porcentaje set porcentaje=$porcentaje,nota1=$nota1,nota2=$nota2,nota3=$nota3,nota4=$nota4,nota5=$nota5,nota6=$nota6,nota7=$nota7,nota8=$nota8,nota9=$nota9,nota10=$nota10,nota11=$nota11,nota12=$nota12,nota13=$nota13,nota14=$nota14,nota15=$nota15,nota16=$nota16,nota17=$nota17,nota18=$nota18,nota19=$nota19,nota20=$nota20, nombre='$leccionario',copied_from=0,orden=$orden where id_grupo=$id_grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	
	}

public function borraGrupo($conn,$grupo){
		  $sql="delete from grupo_nota_ramo_porcentaje where id_grupo=$grupo";
		$result=pg_exec($conn,$sql);
		return $result;
	}


public function veMarca($conn,$periodo,$ramo,$posicion,$grupo=""){
	 if(strlen($grupo)>0){
		$cad="AND id_grupo!=$grupo ";
		}
	
	   $sql="
select nota$posicion from grupo_nota_ramo_porcentaje where id_ramo=$ramo $cad and id_periodo=$periodo order by nota$posicion desc limit 1";
$result = pg_exec($conn,$sql);
//if($_PERFIL==0)echo $sql;
	return $result;	
	}
	
public function cambiaEstado($conn,$ramo){
	 $sql="update grupo_nota_ramo_porcentaje set copied_from =0 where id_ramo=$ramo";
	$result = pg_exec($conn,$sql);
//if($_PERFIL==0)echo $sql; 
	return $result;	
	}
	
 function getOrdenGrupo($conn,$ramo,$periodo){
		   $sql="select max(orden) from grupo_nota_ramo_porcentaje where id_ramo=$ramo and id_periodo=$periodo";
		$result=pg_exec($conn,$sql);
		return $result;
 }
}//fin clase

?>
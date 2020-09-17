<? 
session_start();

require "../../../class/Coneccion.class.php";
	   
class Motor{

 public $Conec;

//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 

	public function Bloque(){
		$sql ="SELECT id_bloque, nombre FROM evados.eva_bloque ";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Anos($rdb){
	 	$sql="SELECT id_ano,nro_ano FROM evados.eva_ano_escolar WHERE id_institucion=".$rdb." ORDER BY nro_ano ASC";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Anos_all($corp){
		  $sql="select i.nro_ano from evados.eva_ano_escolar i
			INNER JOIN public.corp_instit ci
			ON i.id_institucion=ci.rdb 
			WHERE num_corp in (".$corp.")
			group by i.nro_ano
			order by i.nro_ano;";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function periodo($ano){
		$sql="SELECT id_periodo,nombre_periodo FROM evados.eva_periodo WHERE id_ano=".$ano." order by id_periodo";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	public function Pauta($nacional){
	$sql ="SELECT id_plantilla, id_nacional, id_bloque, nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional;
	$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
	
		return $result;
	}
	public function Pauta_Cargo($cargo){
		$sql ="SELECT id_plantilla, id_nacional, id_bloque, nombre FROM evados.eva_plantilla WHERE id_bloque=".$cargo;
		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Pauta_Cargo_Empleado($cargo,$rut,$ano){
		/*if($cargo==5){
			$sql ="SELECT * FROM supervisa WHERE rut_emp=".$rut." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$ano.")";
			$rs_supervisa = pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
			if(pg_numrows($rs_supervisa)!=0){
				$cargo=102;	
			}
		}*/
		$sql ="SELECT id_plantilla, id_nacional, id_bloque, nombre FROM evados.eva_plantilla WHERE id_bloque=".$cargo;
		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	public function Pautas_Institucion($ano,$periodo){
		$sql="SELECT DISTINCT ep.id_plantilla, ep.nombre, ep.id_bloque
			  FROM evados.eva_cierre_evaluado_final ecef INNER JOIN evados.eva_plantilla ep ON ecef.id_plantilla=ep.id_plantilla
			  WHERE id_ano=".$ano." and id_periodo=".$periodo;
		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;	  
	}
	public function Pauta_empleado($rut,$ano){
		$sql ="SELECT * FROM supervisa WHERE rut_emp=".$rut;
		
		$result = pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;	
	}
	
	public function Dimension($plantilla,$nacional){
		  $sql ="SELECT distinct epa.id_area, nombre FROM evados.eva_plantilla_area epa INNER JOIN evados.eva_plantilla_nacional epn ON epa.id_area=epn.id_area AND epn.id_plantilla=".$plantilla." WHERE id_nacional=".$nacional;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Funcion($nacional,$area){
		 $sql ="SELECT DISTINCT eps.id_subarea, nombre FROM evados.eva_plantilla_subarea eps INNER JOIN evados.eva_plantilla_nacional epn ON eps.id_subarea=epn.id_subarea AND epn.id_area=".$area." WHERE id_nacional=".$nacional;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Indicador($nacional,$area,$funcion){
		 $sql ="SELECT  epi.id_item, nombre FROM evados.eva_plantilla_item epi INNER JOIN evados.eva_plantilla_nacional epn 
			   ON epi.id_item=epn.id_item AND id_area=".$area." AND id_subarea=".$funcion." WHERE id_nacional=".$nacional;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Evaluados($ano,$cargo){
		$sql="SELECT emp.rut_emp ||'-'|| emp.dig_rut as rut,emp.nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado 
				emp INNER JOIN evados.eva_evaluado eva ON emp.rut_emp=eva.rut_evaluado WHERE id_ano=".$ano." AND id_cargo=".$cargo;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Pauta_individual($bloque,$nacional){
		
		if($bloque){
		 $sql ="select evpa.id_plantilla,evpa.nombre from evados.eva_plantilla evpa where evpa.id_bloque=".$bloque;
		}else{
		$sql ="SELECT id_plantilla, id_nacional, id_bloque, nombre FROM evados.eva_plantilla WHERE id_nacional=".$nacional;	
		}
		 
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
	
		return $result;
	}
	
	public function Funcion_individual($nacional,$area,$plantilla){
		 $sql ="SELECT DISTINCT eps.id_subarea, nombre FROM evados.eva_plantilla_subarea eps INNER JOIN evados.eva_plantilla_nacional epn ON eps.id_subarea=epn.id_subarea AND epn.id_area=".$area." WHERE id_nacional=".$nacional."
		and epn.id_plantilla=".$plantilla;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function Indicador_individual($nacional,$area,$funcion,$plantilla){
		 $sql ="SELECT  epi.id_item, nombre FROM evados.eva_plantilla_item epi INNER JOIN evados.eva_plantilla_nacional epn 
			   ON epi.id_item=epn.id_item AND id_area=".$area." AND id_subarea=".$funcion." WHERE id_nacional=".$nacional." and epn.id_plantilla=".$plantilla;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	
	public function busca_institucion($num_corp,$nro_ano){
		$sql ="select DISTINCT an.id_ano,an.nro_ano,cop.rdb,cop.num_corp, ins.nombre_instit 
		from corp_instit as cop 
		inner join institucion ins on cop.rdb=ins.rdb 
		inner join evados.eva_ano_escolar an on cop.rdb=an.id_institucion
		where cop.num_corp=".$num_corp." and an.nro_ano=".$nro_ano;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function busca_institucion_all($num_corp,$nro_ano){
		$num_corp = str_replace("__",",",$num_corp);
		 $sql ="select DISTINCT an.id_ano,an.nro_ano,cop.rdb,cop.num_corp, ins.nombre_instit 
		from corp_instit as cop 
		inner join institucion ins on cop.rdb=ins.rdb 
		inner join evados.eva_ano_escolar an on cop.rdb=an.id_institucion
		where cop.num_corp in (".$num_corp.") and an.nro_ano=".$nro_ano;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	public function busca_institucion2($num_corp){
		$sql ="SELECT i.rdb,nombre_instit FROM institucion i INNER JOIN corp_instit ci ON i.rdb=ci.rdb WHERE num_corp=".$num_corp;
		$result =pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
	}
	
	
	public function busca_cargo($inst){
		
		if($inst!=0){
			$sql ="select DISTINCT eva.id_cargo,car.nombre_cargo 
			from evados.eva_evaluado eva 
			inner join cargos car on eva.id_cargo = car.id_cargo
			where tipocargo=1 and eva.id_ano=".$inst."  ORDER BY 2 ASC";
		}else{
			$sql ="select DISTINCT eva.id_cargo,car.nombre_cargo 
			from evados.eva_evaluado eva 
			inner join cargos car on eva.id_cargo = car.id_cargo
			where cargo_evados=1 ORDER BY 2 ASC";	
		}
		
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		return $result;
	}
	
	public function carga_cargos($cargo){
		$sql="SELECT id_cargo,nombre_cargo FROM cargos WHERE id_cargo=".$cargo;
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		return $result;
	}	
	
	
	
	public function busca_evaluado($id_cargo,$num_corp,$id_ano_ins){ 
		if($id_ano_ins!=0){
		   $sql ="SELECT DISTINCT eva.id_cargo,emp.rut_emp as rut,emp.nombre_emp ||' '|| 
		ape_pat ||' '|| ape_mat as nombre FROM empleado 
		emp INNER JOIN evados.eva_evaluado eva ON emp.rut_emp=eva.rut_evaluado 
		INNER JOIN evados.eva_relacion_evaluacion evr on emp.rut_emp=evr.rut_evaluado
		WHERE eva.id_ano=".$id_ano_ins." and eva.id_cargo=".$id_cargo." AND evr.fecha_evaluacion IS NOT NULL";
		}else{
  $sql ="SELECT  DISTINCT eva.id_cargo,emp.rut_emp ||'-'|| emp.dig_rut as rut,emp.nombre_emp ||' '|| 
ape_pat ||' '|| ape_mat as nombre
FROM empleado emp INNER JOIN evados.eva_evaluado eva ON emp.rut_emp=eva.rut_evaluado 
INNER JOIN  trabaja tra ON tra.rut_emp=emp.rut_emp
INNER JOIN corp_instit cp ON tra.rdb=cp.rdb
INNER JOIN evados.eva_relacion_evaluacion evr on emp.rut_emp=evr.rut_evaluado
WHERE  cp.num_corp=".$num_corp." AND eva.id_cargo=".$id_cargo." AND evr.fecha_evaluacion IS NOT NULL";	
		}
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
	
		return $result;
		
	}
	
	public function busca_periodo($ano){
		$sql ="SELECT id_periodo,nombre_periodo FROM evados.eva_periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
		$result = @pg_exec($this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;	
	}
		
	 
	 
public function verifica_intitut($id_ano){
	 $sql ="SELECT DISTINCT *
	FROM evados.eva_relacion_evaluacion evr 
	WHERE evr.id_ano=".$id_ano."  AND evr.fecha_evaluacion IS NOT NULL";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
		
	}
	
	
	public function verifica_corpo($num_corp,$nro_ano){
	 $sql ="SELECT DISTINCT *
	FROM evados.eva_relacion_evaluacion evr 
	WHERE  evr.fecha_evaluacion IS NOT NULL AND evr.id_ano in(   
select an.id_ano from corporacion as cor 
inner join corp_instit coi on cor.num_corp=coi.num_corp
inner join evados.eva_ano_escolar an on coi.rdb=an.id_institucion and an.nro_ano=".$nro_ano."
where cor.num_corp =".$num_corp.")";
		$result =pg_exec( $this->Conec->conectar(),$sql) or die ("Select falló : ".$sql);
		
		return $result;
		
	}
	
	public function carga_empleado($cargo,$rdb,$ano,$periodo){
		//$sql ="SELECT empleado.rut_emp, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rdb=".$rdb." AND cargo=".$cargo." ORDER BY nombre ASC";
		 $sql="  select e.rut_emp, nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre from empleado e INNER JOIN evados.eva_evaluado ee ON e.rut_emp=ee.rut_evaluado
  WHERE id_ano=".$ano." and ee.id_periodo=".$periodo." AND  ee.id_cargo=".$cargo."  ORDER BY nombre ASC";
		$rs_empleado = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		
		return $rs_empleado;
	}
	
	public function carga_empleado_pauta($cargo,$pauta,$ano,$periodo){
		$sql="SELECT e.rut_emp,e.nombre_emp ||' '|| e.ape_pat ||' '|| e.ape_mat as nombre 
				FROM empleado e 
				INNER JOIN evados.eva_cierre_evaluado_final evef ON evef.rut_evaluado=e.rut_emp
				WHERE evef.id_ano=".$ano." AND evef.id_periodo=".$periodo." and evef.id_plantilla=".$pauta;
		$rs_empleado = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		
		return $rs_empleado;	
	}
	
	public function corporacion($rbd)
	{
		$sql="select num_corp from corp_instit where rdb=$rbd";
		$rs_corp = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		return $rs_corp;	
	}
	
	public function misiones()
	{
		$sql="select * from nacional_corp na
			  inner join corporacion c on na.num_corp=c.num_corp
			  where na.id_nacional=1;";	
		$rs_mis = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		return $rs_mis;		  
	}
	
	public function InstitucionNacional($nacional){
		$sql="SELECT DISTINCT i.rdb,i.nombre_instit
				FROM institucion i 
				INNER JOIN corp_instit ci ON ci.rdb=i.rdb
				INNER JOIN nacional_corp nc ON ci.num_corp=nc.num_corp
				WHERE id_nacional=".$nacional;
		$result = pg_exec($this->Conec->conectar(),$sql) or die(pg_last_error($this->Conec->conectar()));
		
		return $result;
	}
	
}


<?php class Credencial{
	
	public function Credencial(){
		
	}
	
	public function Ano($conn,$ano){
		$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$result = pg_exec($conn,$sql);
		$nro_ano = pg_result($result,0);
				
		return $nro_ano;
	}
	
	public function lcursos($conn,$ano){
		$sql="SELECT id_curso idc FROM curso WHERE id_ano=".$ano."order by ensenanza,grado_curso,letra_curso";
		$result = pg_exec($conn,$sql);		
		return $result;
	}
	
	public function lcargo($conn,$institucion){
	$sql="select distinct(c.id_cargo) as idc,c.nombre_cargo
from cargos c
inner join trabaja t on t.cargo = c.id_cargo
where t.rdb=$institucion order by c.nombre_cargo"	;
	$result = pg_exec($conn,$sql);		
	return $result;
	}
	
	public function nomemp($conn,$rdb,$cargo){
	$cad="";
	if($cargo!=0)
	{
		$cad=" and t.cargo = $cargo";
	}
	
	$sql="select DISTINCT(emp.rut_emp) rut,upper(emp.ape_pat||' '||emp.ape_mat||' '||emp.nombre_emp) as nombre,dig_rut
from empleado emp
inner join trabaja t on t.rut_emp = emp.rut_emp
where t.rdb=$rdb 
$cad 
order by 2";
$result = pg_exec($conn,$sql);		
	return $result;
	}
	
	public function nomapo($conn,$curso){
	   $sql="select DISTINCT(apo.rut_apo) rut,upper(apo.ape_pat||' '||apo.ape_mat||' '||apo.nombre_apo) as nombre,dig_rut
from apoderado apo
inner join tiene2 t on t.rut_apo = apo.rut_apo
where t.rut_alumno in (select rut_alumno from matricula where id_curso =$curso and bool_ar=0)
order by 2
";
$result = pg_exec($conn,$sql);		
	return $result;
	}
	
	public function nomalu($conn,$curso){
		 $sql="select DISTINCT(alu.rut_alumno) rut,upper(alu.ape_pat||' '||alu.ape_mat||' '||alu.nombre_alu) as nombre,dig_rut 
from alumno alu
where alu.rut_alumno in (select rut_alumno from matricula where id_curso =$curso and bool_ar=0)
order by 2";
		$result = pg_exec($conn,$sql);		
		return $result;
	
	}
	
	public function dato1($conn,$tipo,$tabla,$rut){
	  $sql="select rut_$tipo as rut,upper(ape_pat||' '||ape_mat||' '||nombre_$tipo) as nombre,dig_rut from $tabla where rut_$tipo=$rut";
	$result = pg_exec($conn,$sql);		
		return $result;
	}
	
	public function dato1alumno($conn,$rut){
	   $sql="select rut_alumno as rut,upper(ape_pat||' '||ape_mat||' '||nombre_alu) as nombre,dig_rut from alumno where rut_alumno=$rut";
	$result = pg_exec($conn,$sql);		
		return $result;
	}
	
	public function datoColegio($conn,$rdb){
		$sql="select upper(ins.nombre_instit) nombreins,upper(ins.calle||' '||ins.nro) dirins,c.nom_com,ins.rdb
from institucion ins
inner join comuna c on c.cod_reg = ins.region and c.cor_pro = ins.ciudad and c.cor_com = ins.comuna
where ins.rdb = $rdb";
$result = pg_exec($conn,$sql);		
		return $result;
		}
		
	public function cargo1($conn,$rut,$rdb){
	  $sql="select upper(c.nombre_cargo) from cargos c
inner join trabaja t on t.cargo = c.id_cargo
where rut_emp='$rut' and rdb='$rdb'
 order by identificador limit 1";
	$result = pg_exec($conn,$sql);		
		return $result;
	
	}
	
}//fin clase
?>
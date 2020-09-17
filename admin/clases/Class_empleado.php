<? require('OpenConnect.php');

class Empleado{

	function institucion($conn){
		$sql="SELECT * FROM INSTITUCION WHERE RDB=".$this->institucion;
		$rs_instit = @pg_exec($conn,$sql);
		return $rs_instit;
	
	}
	
	function trabaja($conn){
		$sql ="select * from (supervisa inner join trabaja on supervisa.rut_emp=trabaja.rut_emp) ";
		$sql.=" where trabaja.rdb=".$this->institucion." and supervisa.rut_emp='".$this->empleado."'";
		$resV = @pg_exec($conn,$sql);
		return $resV;
		
	}
	
	function sub_trabaja($conn){
		$sql="select * from (curso inner join ano_escolar on curso.id_ano=ano_escolar.id_ano) ";
		$sql.="where ano_escolar.id_institucion=".$this->institucion." and curso.id_curso=".$this->id_curso;
		$resVV = pg_exec($conn,$sql);
		return $resVV;
	
	}
	
	function trabaja1($conn){
		$sql="SELECT trabaja.fecha_ingreso, trabaja.fecha_retiro, trabaja.cargo, empleado.*, empleado.rut_emp, empleado.foto FROM ";
		$sql.="(empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb ";
		$sql.="WHERE (((trabaja.rdb)=".$this->institucion.") AND ((empleado.rut_emp)=".$this->empleado."))";
		$resp = pg_exec($conn,$sql);
		return $resp;
	
	}
	
	function usuario($conn){
		$sql="select id_usuario from usuario where nombre_usuario=".$this->empleado;
		$res = pg_exec($conn,$sql);
		return $res;
	}
	
	function perfil($conn){
		$sql="select id_perfil from accede where id_usuario=".$this->id_usuario;
		$resp = pg_exec($conn,$sql);
		return $resp;
	}
	
	function titulo($conn){
		$sql="select * from tipo_titulo order by codigo";
		$resp = pg_exec($conn,$sql);
		return $resp;
	}
	
	function plan($conn){
		$sql="select plan2.rdb,plan2.cod_decreto from plan_inst as plan,plan_estudio as plan2 ";
		$sql.="where plan.rdb='".$this->institucion."' and plan.cod_decreto=plan2.cod_decreto Group by plan2.rdb,plan2.cod_decreto"; 
		$resp = pg_exec($conn,$sql);
		return $resp;
	}
	
	function postitulo($conn){
		$sql="SELECT * FROM empleado_estudios WHERE rut_empleado='".$this->empleado."' AND tipo=".$this->tipo." order by orden"; 
 		$resp = @pg_exec($conn,$sql);
		return $resp;
	}
	
	function trabaja_cv($conn){
		$sql="select * from trabaja  where rut_emp='".$this->empleado."' and rdb='".$this->institucion."' order by identificador";
		$resp = @pg_exec($conn,$sql);
		return $resp;
	}
	
	function usuario_cv($conn){
		$sql="SELECT usuario.id_usuario, usuario.nombre_usuario, accede.estado, accede.rdb, ";
		$sql.=" perfil.id_perfil, perfil.nombre_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil ";
		$sql.=" = perfil.id_perfil) INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario WHERE ";
		$sql.=" (((usuario.id_usuario)=".$this->id_usuario.") AND ((accede.rdb)=".$this->institucion.")) ORDER BY NOMBRE_PERFIL ASC;";
		$resp = @pg_exec($conn,$sql);
		return $resp;
	}
	
	function grupos($conn){
		$sql= "select * from grupos where rdb = '".$this->institucion."' order by nombre";
		$resp = pg_exec($conn,$sql);
		return $resp;
	}
	
	function grupos_2($conn){
		$sql="select * from relacion_grupo where id_grupo = ".$this->id_grupo." and rut_integrante = '".$this->empleado."'";
		$resp= pg_exec($conn,$sql);
		return $resp;
	}
	
	function grupos_3($conn){
		$sql= "select * from grupos, relacion_grupo where grupos.id_grupo = relacion_grupo.id_grupo ";
		$sql.="and relacion_grupo.rut_integrante = '".$this->empleado."' and grupos.rdb = '".$this->institucion."'";
		$resp = pg_exec($conn,$sql);
		return $resp;
	}
}


?>
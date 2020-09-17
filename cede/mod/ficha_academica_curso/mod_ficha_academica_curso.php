<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start(); 
require "../../Class/Membrete.php";

class FichaAcademica_curso {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
  public function ano_academico($id_instit){

   $sql_ins = "SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$id_instit." ORDER BY NRO_ANO";
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".   $sql_ins);
   
  if($result_ins){
				   return $result_ins;
			}else{
				 return false;
		}
 }
	
	public function carga_configuracion($id_ano){
		 $sql="select * from cede.configuracion_notas where id_ano=".$id_ano; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select conf" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	 public function carga_curso($id_nivel,$ano){
		
	 $sql="select * from cede.niveles nv 
			inner join curso c on nv.tipo_ense=c.ensenanza
			where nv.id_nivel=$id_nivel and id_ano=$ano and grado_curso in  
			( 
			select 1 as x from cede.niveles  
			where id_nivel=$id_nivel and pr=1
			union all
			select 2 as x  from cede.niveles 
			where id_nivel=$id_nivel and sg=1
			union all
			select 3 as x from cede.niveles  
			where id_nivel=$id_nivel and tr=1
			union all
			select 4 as x  from cede.niveles 
			where id_nivel=$id_nivel and cu=1
			union all
			select 5 as x from cede.niveles  
			where id_nivel=$id_nivel and qu=1
			union all
			select 6 as x  from cede.niveles 
			where id_nivel=$id_nivel and sx=1
			union all
			select 7 as x from cede.niveles  
			where id_nivel=$id_nivel and sp=1
			union all
			select 8 as x  from cede.niveles 
			where id_nivel=$id_nivel and oc=1
			)"; 
		
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 3" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
		public function carga_ramo($id_curso,$ano){
			
			 $sql="select * from ramo 
						inner join subsector on subsector.cod_subsector=ramo.cod_subsector
						inner join cede.configuracion_notas cn on cn.cod_subsector=ramo.cod_subsector
						WHERE ramo.id_curso=".$id_curso." AND id_ano=".$ano;
			
			$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
			 if($regis){
					   return $regis;
				}else{
					 return false;
			}
		}
	
	public function carga_ano_acad($ano_academ){
		
		$sql="SELECT * FROM ANO_ESCOLAR where ANO_ESCOLAR.id_ano=".$ano_academ; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function InsertaFichaAcademica($rdb,$ano,$id_periodo,$nota_inicial,$nota_final,$chk_promedio,$id_nivel,$id_ramo,$nombre_conf){ 
	
	 $sql_insert = "INSERT INTO cede.configuracion_notas(rdb,id_ano,id_periodo,
	 nota_inicial,nota_final,promedio,id_nivel,cod_subsector,nombre_conf) 
      VALUES (".$rdb.",".$ano.",".$id_periodo.",".$nota_inicial.",".$nota_final.",
	  ".$chk_promedio.",".$id_nivel.",".$id_ramo.",'".$nombre_conf."');";

	$regis = pg_Exec( $this->Conec->conectar(),$sql_insert ) or die( "Error bd insert 1" );
		if($regis){
			   return true;
		}else{
			  return false;
		}
	}
	
	public function tabla_ficha_acad_curso($rdb,$id_ramo,$notas,$promedio,$nro_ano,$id_periodo,$promedio_final){
		
		
	if($promedio_final==1){
		
		 /*$sql="select DISTINCT nt.promedio as prom, 

al.rut_alumno ||'-'|| al.dig_rut as rut, 
al.nombre_alu ||' '|| al.ape_pat ||' '|| al.ape_mat as nombre, 

CASE WHEN nt.promedio::INTEGER BETWEEN nl_1.nota_minima and nl_1.nota_maxima 
THEN nl_1.id_nivel 
WHEN nt.promedio::INTEGER BETWEEN nl_2.nota_minima and nl_2.nota_maxima 
THEN nl_2.id_nivel END as nivel 
from tiene$nro_ano as ti inner join alumno al on al.rut_alumno=ti.rut_alumno 
inner join matricula m on m.rut_alumno = al.rut_alumno 
inner join cede.nivel_logro nl_1 on nl_1.rdb = m.rdb and nl_1.id_nivel = 1 
inner join cede.nivel_logro nl_2 on nl_2.rdb = m.rdb and nl_2.id_nivel = 2 
inner join notas$nro_ano nt on ti.id_ramo=nt.id_ramo and id_periodo=".$id_periodo." and al.rut_alumno=nt.rut_alumno 
where ti.id_ramo=".$id_ramo." AND nt.promedio<>' '
ORDER BY nombre ASC";*/
		$sql="select DISTINCT nt.promedio as prom, 
al.rut_alumno ||'-'|| al.dig_rut as rut, al.ape_pat ||' '|| al.ape_mat ||' '||
al.nombre_alu   as nombre, 
concepto, nl_1.nota_minima, nl_1.nota_maxima, id
from tiene$nro_ano as ti inner join alumno al on al.rut_alumno=ti.rut_alumno 
inner join matricula m on m.rut_alumno = al.rut_alumno 
inner join cede.nivel_logro nl_1 on nl_1.rdb = m.rdb and nl_1.id_nivel in(1,2)
inner join notas$nro_ano nt on ti.id_ramo=nt.id_ramo and id_periodo=".$id_periodo." and al.rut_alumno=nt.rut_alumno 
where ti.id_ramo=".$id_ramo." AND nt.promedio<>' ' and CAST(nt.promedio as INTEGER) BETWEEN nl_1.nota_minima and
nl_1.nota_maxima
ORDER BY nombre ASC	";
//echo "1-->".$sql;
	}else{	
		
 /*$sql="select DISTINCT $notas,$promedio as prom,
al.rut_alumno ||'-'|| al.dig_rut as rut, al.nombre_alu ||' '|| al.ape_pat ||' '|| al.ape_mat as   nombre,
nl_1.nota_minima as nota_minima1,  nl_1.nota_maxima as nota_maxima1,
nl_2.nota_minima as nota_minima2,nl_2.nota_maxima as nota_maxima2,
--nl_3.nota_minima as nota_minima3,nl_3.nota_maxima as nota_maxima3,
CASE 
WHEN 
$promedio BETWEEN nl_1.nota_minima and nl_1.nota_maxima
THEN nl_1.id_nivel 
WHEN 
$promedio BETWEEN nl_2.nota_minima and nl_2.nota_maxima
THEN nl_2.id_nivel END as nivel
from tiene$nro_ano as ti
inner join alumno al on al.rut_alumno=ti.rut_alumno 
inner join matricula m on m.rut_alumno = al.rut_alumno
inner join cede.nivel_logro nl_1 on nl_1.rdb = m.rdb and nl_1.id_nivel = 1
inner join cede.nivel_logro nl_2 on nl_2.rdb = m.rdb and nl_2.id_nivel = 2
inner join notas$nro_ano nt on ti.id_ramo=nt.id_ramo and id_periodo=".$id_periodo." and al.rut_alumno=nt.rut_alumno
where ti.id_ramo=".$id_ramo." AND nt.promedio<>' '
ORDER BY nombre ASC";*/
$sql="  select DISTINCT nt.nota1,nt.nota2,nt.nota3,nt.nota4,nt.nota5,(cast(nt.nota1 as integer)+cast(nt.nota2 as integer)+cast(nt.nota3 as integer)
  +cast(nt.nota4 as integer)+cast(nt.nota5 as integer))/5 as prom, 
  al.rut_alumno ||'-'|| al.dig_rut as rut, al.nombre_alu ||' '|| al.ape_pat ||' '|| al.ape_mat as nombre, 
  nl_1.nota_minima as nota_minima1, nl_1.nota_maxima as nota_maxima1, concepto
  from tiene2014 as ti 
  inner join alumno al on al.rut_alumno=ti.rut_alumno 
  inner join matricula m on m.rut_alumno = al.rut_alumno 
  inner join cede.nivel_logro nl_1 on nl_1.rdb = m.rdb and nl_1.id_nivel in(1,2) 
  inner join notas2014 nt on ti.id_ramo=nt.id_ramo and id_periodo=".$id_periodo." and al.rut_alumno=nt.rut_alumno 
  where ti.id_ramo=".$id_ramo." AND nt.promedio<>' ' AND  ((cast(nt.nota1 as integer)+cast(nt.nota2 as integer)+cast(nt.nota3 as integer)
  +cast(nt.nota4 as integer)+cast(nt.nota5 as integer))/5) BETWEEN nl_1.nota_minima and
nl_1.nota_maxima
  ORDER BY nombre ASC ";
//echo "2-->".$sql;
	}

		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	
	public function Logro ($prom,$rdb){
		$sql="SELECT id,concepto FROM cede.nivel_logro WHERE rdb=".$rdb." AND nota_minima <= ".$prom." AND nota_maxima >=".$prom;
		$result = pg_Exec($this->Conec->conectar(),$sql);
		$promedio = pg_result($result,0).",".pg_result($result,1);
		return $promedio;
	}
	
	
	 
}
?>
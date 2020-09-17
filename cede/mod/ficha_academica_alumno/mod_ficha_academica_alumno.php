<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start(); 
require "../../Class/Membrete.php";

class FichaAcademica_alumno {
	   
	public $Conec;
	
	//constructor 
	public function __construct($ip,$bd){
		$this->Conec = new DBManager($ip,$bd);
	 } 
	 
  public function carga_ficha_alumno($id_ano,$rut_alumno){

   $sql_ins = "select ne.*,al.nombre_alu ||' '|| al.ape_pat ||' '|| al.ape_mat as nombre_alu,
   al.rut_alumno,al.dig_rut,ae.nro_ano,cn.nombre_conf,cn.nota_inicial,cn.nota_final,cn.id_nivel
   from cede.notas_evaluacion as ne
inner join alumno al on ne.rut_alumno=al.rut_alumno
inner join ano_escolar ae on ne.id_ano=ae.id_ano
inner join cede.configuracion_notas cn on ne.id_conf=cn.id_conf
where ne.rut_alumno=".$rut_alumno." and ne.id_ano=".$id_ano;
   $result = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".   $sql_ins);
   
  if($result){
				return $result;
			}else{
				 return false;
		}
 }
	
	public function carga_subsector($id_ramo){
		$sql="SELECT RAMO.cod_subsector,SUBSECTOR.nombre
		FROM RAMO 
		INNER JOIN SUBSECTOR ON RAMO.cod_subsector=SUBSECTOR.cod_subsector
		WHERE RAMO.id_ramo=".$id_ramo; 
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select conf" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
	public function tabla_ficha_acad_alumno($id_conf,$id_periodo,$id_ramo,$rut_alumno,$notas,$nro_ano){
		
		$sql="select ne.*, $notas 
		from cede.notas_evaluacion ne
		inner join cede.configuracion_notas cn on ne.id_conf=cn.id_conf
		inner join notas$nro_ano nt on ne.id_periodo=nt.id_periodo and nt.rut_alumno=ne.rut_alumno

        where ne.id_conf=$id_conf and nt.rut_alumno=$rut_alumno and nt.id_ramo=$id_ramo and nt.id_periodo=$id_periodo"; 

		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function tabla_mapa_conceptual($id_curso,$cod_subsector,$id_ano,$id_nivel){
		
		$sql="select mp.*,su.cod_subsector,mf.nombre as nombre_funcion,nv.nombre as nombre_nivel
		from cede.mpa mp
		inner join subsector su on mp.cod_subsector=su.cod_subsector
		inner join cede.mpa_funcion mf on mp.id_funcion=mf.id_funcion
		inner join cede.niveles nv on mp.id_nivel=nv.id_nivel
		where mp.cod_subsector=$cod_subsector and mp.id_nivel=$id_nivel"; 

		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	public function Niveles($id){
		$sql="SELECT concepto FROM cede.nivel_logro nl WHERE id=".$id;
		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd Select 2" );
		$concepto = pg_result($regis,0);
		if($concepto){
		   return $concepto;
		}else{
		   return false;
		}
	}
	 
}
?>
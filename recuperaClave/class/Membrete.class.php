<? 
session_start();
require "Coneccion.class.php";

class Membrete {


public $Conect;

//constructor 
public function Membrete($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 
  
 function institucion($inst){
	
	 	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro,   region.nom_reg, provincia.nom_pro, region,ciudad,comuna,comuna.nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, fecha_resolucion,numero_inst FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON  (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb=".$inst;
		
$result_ins =pg_exec($this->Conec->conectar(),$sql_ins) or die ("Select falló: ".$sql_ins);
return  pg_fetch_array($result_ins,0);	

	}

	
	function curso($conn){
		$sql ="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.ensenanza,
		tipo_ensenanza.nombre_tipo, curso.truncado_per FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$this->curso."))";
		//$sql.="";
		$result = @pg_exec($this->Conec->conectar(),$sql) or die ("Select fallo: ".$sql);
		$fila = @pg_fetch_array($result,0);
		$this->cod_decreto =$fila['cod_decreto'];
		$this->grado_curso =$fila['grado_curso'];
		$this->letra_curso =$fila['letra_curso'];
		$this->ensenanza   =$fila['nombre_tipo'];
		$this->cod_ensenanza  =$fila['ensenanza'];
		return;
	}
	
	
	function periodo($conn){
		$sql = "select * from periodo where id_ano = ".$this->ano."  AND id_periodo=".$this->periodo." order by fecha_inicio";
		$result_peri = pg_exec($this->Conec->conectar(),$sql) or die ("Select falló:".$sql);
		$fila = pg_fetch_array($result_peri,0);
		$this->nombre_periodo = $fila['nombre_periodo'];
		$this->result = $result_peri;
		return;
	}
	
	function nivel($conn){
		$sql = "Select ni.nombre from niveles as ni where ni.id_nivel=".$this->idnivel;
	    $result_nivel = @pg_exec($this->Conec->conectar(),$sql) or die ("Select fallo: ".$sql);
	    $fila_nivel = @pg_fetch_array($result_nivel,0);
	    $this->nombre_nivel = $fila_nivel['nombre'];
	    return;		
	  }
	
function anoescolar($inst){
		$sql = "select * from ano_escolar aes where aes.id_institucion = ".$inst." and aes.situacion = 1";
		$regis = @pg_Exec($this->Conec->conectar(),$sql) or die( pg_last_error($conn) );
		return pg_fetch_array($regis,0);
	 }
			

public function estilosae($a){ 
 
 	if($a==""){
		$this->ESTILO="../estilos/estilos.css";
		$this->IMAGEN_IZQUIERDA="../cortes/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/fomdo_02.jpg";		
		$this->corte1="../cortes/fin_linea01.jpg";
		$this->corte2="../cortes/fondo_linea01.jpg";
		$this->corte3="../cortes/fondo_linea01.jpg";
		$this->corte4="../cortes/linea02.jpg";
	}else{
		$this->ESTILO="../cortes/".$a."/estilos.css";
		$this->IMAGEN_IZQUIERDA="../cortes/".$a."/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/".$a."/fomdo_02.jpg";
		$this->corte1="../cortes/".$a."/fin_linea01.jpg";
		$this->corte2="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte3="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte4="../cortes/".$a."/linea02.jpg";
	  }
  return;
  }
	
	
	 public function carga_anos($rdb){
		
	 $sql="select * from ano_escolar an where an.id_institucion=$rdb order by an.nro_ano desc"; 
   $regis = pg_Exec($this->Conec->conectar(),$sql) or die( "Error bd insert 1".$sql);		
		 if($regis){
				   return $regis;
			}else{
				 return false;
		}
	}
	
	
 } // Fin Class

?>
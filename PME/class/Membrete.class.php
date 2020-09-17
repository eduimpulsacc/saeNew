<?  
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require("Coneccion.class.php");
class Membrete{

public $Conec;

//Constructor 
public function __construct($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
 } 

  
public function institucion($inst){

$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro,   region.nom_reg, provincia.nom_pro, region,ciudad,comuna,comuna.nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, fecha_resolucion,numero_inst FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON  (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb=".$inst." ";
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
   return  pg_fetch_array($result_ins,0);	
		
 }

	
/*public function curso($conn){
		$sql ="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.ensenanza,
		tipo_ensenanza.nombre_tipo, curso.truncado_per FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$this->curso."))";

		$result = pg_exec($this->conn,$sql) or die ("Select fallo: ".$sql);
		$fila = pg_fetch_array($result,0);
		$this->cod_decreto =$fila['cod_decreto'];
		$this->grado_curso =$fila['grado_curso'];
		$this->letra_curso =$fila['letra_curso'];
		$this->ensenanza   =$fila['nombre_tipo'];
		$this->cod_ensenanza  =$fila['ensenanza'];
		return;
	}*/
	
	
/*public function periodo($conn){
		$sql = "SELECT * from periodo where id_ano = ".$this->ano."  AND id_periodo=".$this->periodo." order by fecha_inicio";
		$result_peri = pg_exec($this->conn,$sql) or die ("Select falló:".$sql);
		$fila = pg_fetch_array($result_peri,0);
		$this->nombre_periodo = $fila['nombre_periodo'];
		$this->result = $result_peri;
		return;
	}*/
	
/*public function nivel($conn){
		$sql = "SELECT ni.nombre from niveles as ni where ni.id_nivel=".$this->idnivel;
	    $result_nivel = pg_exec($this->conn,$sql) or die ("Select fallo: ".$sql);
	    $fila_nivel = pg_fetch_array($result_nivel,0);
	    $this->nombre_nivel = $fila_nivel['nombre'];
	    return;		
	  }*/
	
public function anoescolar($inst){

$sql = "SELECT * from ano_escolar aes where aes.id_institucion = ".$inst." and aes.situacion = 1";

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd E#e#ee#" );
return pg_fetch_array($regis,0);

 }
 
  public function AnoEscolarSeteado($_NRO_ANO_){

  $sql = "SELECT * from pme.proyecto_ano  where nro_ano = ".$_NRO_ANO_."";

 $regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1" );

  return @pg_fetch_array($regis,0);

 } 



public function cargamenulateral($p,$i){

$sql = "SELECT e.id_menu,a.nombre as menu,a.url as url_menu, c.nombre as categoria,c.url as url_categoria
from pme.perfil_menu as e
INNER JOIN pme.menu as a ON e.id_menu=a.id_menu
LEFT JOIN  pme.menu_categoria c ON e.id_menu = c.id_menu AND e.id_categoria = c.id_categoria
WHERE id_perfil=$p AND rdb=$i order by a.orden,c.orden ASC;";


		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Sql Menu--> ".$sql );
			 
		$menu = '<ul class="navegador">';
		$a=0;
		for($i=0;$i<=pg_numrows($regis);$i++){
			 
	    $fila0 = pg_fetch_array($regis,$i);
			 
		if(trim($fila0['menu'])){
		
		$menu .= '<li><a href="#" class="desplegable" title="'.trim($fila0['menu']).'" onclick=enviapag("'.trim($fila0['url_menu']).'") >'.trim($fila0['menu']).'</a>';
			
			$menu .= '<ul class="subnavegador">';
			
			 for($e=0;$e<=pg_numrows($regis);$e++){
				
				$fila1 = pg_fetch_array($regis,$e);
					
				if( trim($fila0['id_menu']) == trim($fila1['id_menu']) ){
				
				$a++;
				
				if($fila1['categoria']){
				
				$menu .= '<li><a href="#" title="'.trim($fila1['categoria']).'" onclick=enviapag("'.trim($fila1['url_categoria']).'") >'.trim($fila1['categoria']).'</a></li>';
				
					}
                
				 }

			   };
			   
			   $i = $a-1;
			
		$menu .= '</ul>
				 </li>';
		      };
		  };
		
		$menu .= '</ul>';
		
		echo $menu;
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
		$this->corte5="../../cortes/pme.jpg";
	}else{
		$this->ESTILO="../cortes/".$a."/estilos.css";
		$this->IMAGEN_IZQUIERDA="../cortes/".$a."/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/".$a."/fomdo_02.jpg";
		$this->corte1="../cortes/".$a."/fin_linea01.jpg";
		$this->corte2="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte3="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte4="../cortes/".$a."/linea02.jpg";
		$this->corte5="../cortes/pme.jpg";
	  }

	  	//$this->IMAGEN_IZQUIERDA="../cortes/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/fomdo_02.jpg";	
		
  return;
  
  }
  
  
 
  
	public function corporacion($rdb){
		$sql="select num_corp
                from corp_instit 
                WHERE rdb =".$rdb;
        $result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select fall�111 : ".$sql);
		$num_corp= pg_result($result,0);
		return $num_corp;
	}
	
 } // Fin Class

?>

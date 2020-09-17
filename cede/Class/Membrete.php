<?  
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require_once("Coneccion.php");
	 
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

/* public function ano_academico($inst){

   $sql_ins = "SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$inst." ORDER BY NRO_ANO";
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
   
 return $result_ins;	
   
 }*/
	
	
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
	
public function anoescolar($_INSTIT){

 $sql = "SELECT * from ano_escolar aes where aes.id_institucion = ".$_INSTIT." and aes.situacion = 1";

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd E#e#ee#" );
return pg_fetch_array($regis,0);
 }
 
 public function AnoEscolarSeteado($_ANO_CEDE){

  $sql = "SELECT * from ano_escolar aes where aes.id_ano = ".$_ANO_CEDE;

 $regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1" );

  return @pg_fetch_array($regis,0);

 }
 
	public function Usuario_Sesion($_NOMBREUSUARIO){
		
	 $sql="select emp.nombre_emp || ' ' || emp.ape_pat || ' ' || emp.ape_mat as nombre_usuario, 
emp.rut_emp || '-' || emp.dig_rut as rut_empleado 
from usuario us 
inner join empleado emp on cast(us.nombre_usuario as integer)=emp.rut_emp 
where us.nombre_usuario='".$_NOMBREUSUARIO."' ";
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 2".$sql );
	 return pg_fetch_array($regis,0);
	 }
 
 
 public function datos_alumno($id_ano,$rut_alumno){
	 $sql=" select a.nombre_alu || ' ' || a.ape_pat || ' ' || a.ape_mat as nombre_alumno,
	a.rut_alumno,a.dig_rut,m.id_ano,m.id_curso  
	from alumno a
	inner join matricula m on a.rut_alumno=m.rut_alumno
	inner join curso c on m.id_curso=c.id_curso
	where a.rut_alumno=$rut_alumno and m.id_ano=$id_ano";
	 
	$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 3" );
    return pg_fetch_array($regis,0);
	 } 
	 
	 
	public function datos_apoderado($rut_alumno){
		
	 $sql2="SELECT ap.rut_apo,ap.dig_rut,ap.nombre_apo || ' ' || ap.ape_pat || ' ' || ap.ape_mat 
	as nombre_apoderado
	from apoderado ap
	inner join tiene2 ti on ap.rut_apo =ti.rut_apo
	where ti.rut_alumno=".$rut_alumno." LIMIT 1";
	
		$regis2 = @pg_Exec( $this->Conec->conectar(),$sql2 );
        return @pg_fetch_array($regis2,0);
		} 



public function cargamenulateral($p,$i){

$sql = "SELECT e.id_menu,a.nombre as menu,a.url as url_menu, c.nombre as categoria,c.url as url_categoria
from evados.eva_perfil_menu as e
INNER JOIN evados.eva_menu as a ON e.id_menu=a.id_menu
LEFT JOIN  evados.eva_categoria c ON e.id_menu = c.id_menu AND e.id_categoria = c.id_categoria
WHERE id_perfil=$p AND rdb=$i order by 1;";


		$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error Sql Menu--> ".$sql );
			 
		$menu = '<ul class="navegador">';
		$a=0;
		for($i=0;$i<=pg_numrows($regis);$i++){
			 
	    $fila0 = pg_fetch_array($regis,$i);
			 
		if(trim($fila0['menu'])){
		
		$menu .= '<li><a href="#" class="desplegable" title="'.trim($fila0['menu']).'" onclick=enviapag("'.trim($fila0['url_menu']).'") >'.utf8_decode(trim($fila0['menu'])).'</a>';
			
			$menu .= '<ul class="subnavegador">';
			
			 for($e=0;$e<=pg_numrows($regis);$e++){
				
				$fila1 = pg_fetch_array($regis,$e);
					
				if( trim($fila0['id_menu']) == trim($fila1['id_menu']) ){
				
				$a++;
				
				if($fila1['categoria']){
				
				$menu .= '<li><a href="#" title="'.trim($fila1['categoria']).'" onclick=enviapag("'.trim($fila1['url_categoria']).'") >'.utf8_decode(trim($fila1['categoria'])).'</a></li>';
				
					}
                
				 }

			   };
			   

			   $i = $a-1;
			
		$menu .= '</ul>
				 </li>';
		      };
		  };
		
		$menu .= '</ul>';
		
		echo  $menu;
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
		$this->corte5="../cortes/foto_top.jpg";
		
	}else{
		$this->ESTILO="../cortes/".$a."/estilos.css";
		$this->IMAGEN_IZQUIERDA="../cortes/".$a."/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/".$a."/fomdo_02.jpg";
		$this->corte1="../cortes/".$a."/fin_linea01.jpg";
		$this->corte2="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte3="../cortes/".$a."/fondo_linea01.jpg";
		$this->corte4="../cortes/".$a."/linea02.jpg";
		$this->corte5="../cortes/".$a."/foto_top.jpg";
		$this->insignia="<img src='../tmp/".$a."insignia'>";
		
	  }
	  	//$this->IMAGEN_IZQUIERDA="../cortes/fondo_01.jpg";
		$this->IMAGEN_DERECHA="../cortes/fomdo_02.jpg";	
		
  return;
  
  }

	
	function CursoPalabra($id_curso,$tipo)
{
$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto 
FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
WHERE (((curso.id_curso)=".$id_curso."));";

$result_curso = pg_Exec( $this->Conec->conectar(),$sql_curso ) or die( "Error Sql Menu--> ".$sql_curso );

$fila_curso = @pg_fetch_array($result_curso,0);	

if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

}else if ( ($fila_curso['grado_curso']==1) and (($fila_curso['cod_decreto']==121987) or ($fila_curso['cod_decreto']==1521989)) ){

$Curso_pal0 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "PRIMER CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));				
$Curso_pal3 = "PC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ( ($fila_curso['grado_curso']==1) and ($fila_curso['cod_decreto']==1000)){

$Curso_pal0 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "SALA CUNA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ( ($fila_curso['grado_curso']==2) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

$Curso_pal0 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal2 =  "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));

}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==121987) ){

$Curso_pal0 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "SEGUNDO CICLO - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "SC - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ( ($fila_curso['grado_curso']==2) and ($fila_curso['cod_decreto']==1000)){

$Curso_pal0 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "NIVEL MEDIO MENOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "NMME - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if (($fila_curso['grado_curso']==3) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==461987)) ){

$Curso_pal0 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   
$Curso_pal1 =  "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		
$Curso_pal2 =  "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   
$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   		

}else if ( ($fila_curso['grado_curso']==4) and (($fila_curso['cod_decreto']==771982) or ($fila_curso['cod_decreto']==771982)) ){

$Curso_pal0 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   
$Curso_pal1 =  "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));	   		
$Curso_pal2 =  "CUARTO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   
$Curso_pal3 = "CN - ". ucwords(strtoupper($fila_curso["letra_curso"]));	   			

}else if ( ($fila_curso['grado_curso']==3) and ($fila_curso['cod_decreto']==1000)){

$Curso_pal0 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "NIVEL MEDIO MAYOR - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "NMMA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal4 =  "PLAY GROUP - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

}else if ( ($fila_curso['grado_curso']==4) and ($fila_curso['cod_decreto']==1000)){

$Curso_pal0 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "TRANSICIÓN 1er NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));
$Curso_pal3 = "T1N - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal4 =  "PRE KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

}else if ( ($fila_curso['grado_curso']==5) and ($fila_curso['cod_decreto']==1000)){

$Curso_pal0 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 =  "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 =  "TRANSICIÓN 2do NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "T2N - ". ucwords(strtoupper($fila_curso["letra_curso"]));	
$Curso_pal4 =  "KINDER - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));			

}else if ( ($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 ) and ($fila_curso['cod_decreto']==771982)){

$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));						

}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==771982)){

$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								

}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8 )) and ($fila_curso['cod_decreto']==771982)){

$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));								

}else if ( (($fila_curso['grado_curso']>0) and ($fila_curso['grado_curso']<5 )) and ($fila_curso['cod_decreto']==461987)){

$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if ( (($fila_curso['grado_curso']==5) or ($fila_curso['grado_curso']==6 )) and ($fila_curso['cod_decreto']==461987)){

$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if ( (($fila_curso['grado_curso']==1)) and ($fila_curso['cod_decreto']==2392004)){

$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));			

}else if ( (($fila_curso['grado_curso']==2)) and ($fila_curso['cod_decreto']==5842007)){

$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==5842007)){

$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ((($fila_curso['grado_curso']==4)) and ($fila_curso['cod_decreto']==5842007)){

$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal2 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		

}else if ( (($fila_curso['grado_curso']==7) or ($fila_curso['grado_curso']==8)) and ($fila_curso['cod_decreto']==461987)){

$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if ( (($fila_curso['grado_curso']==4)) and ($fila_curso['cod_decreto']==2392004)){

$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "TN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "TERCER NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "TN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if ( (($fila_curso['grado_curso']==3)) and ($fila_curso['cod_decreto']==2392004)){

$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "SN- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "SEGUNDO NIVEL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SN - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==4 and $fila_curso['cod_decreto']==891990){
$Curso_pal0 = "ESTIMULACION TEMPRANA - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));

$Curso_pal1 = "ET- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "ESTIMULACION TEMPRANA - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "ET - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==5 and $fila_curso['cod_decreto']==891990){

$Curso_pal0 = "PRE-BASICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRE-BASICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PB - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==6 and $fila_curso['cod_decreto']==891990){

$Curso_pal0 = "ADULTO JOVEN - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "AJ- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "ADULTO JOVEN - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "AJ - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==1 and $fila_curso['cod_decreto']==2562009){

$Curso_pal0 = "PRIMER CICLO BASICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PCB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER CICLO BASICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PCB - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==1 and $fila_curso['cod_decreto']==343602){

$Curso_pal0 = "ADULTO JOVEN 1 - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "AJ1- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "ADULTO JOVEN 1 - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "AJ1 - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==1 and $fila_curso['cod_decreto']==871990){

$Curso_pal0 = "PRIMER CICLO PRE-BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo'

]));

$Curso_pal1 = "PCPB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER CICLO PRE-BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PCPB - ". ucwords(strtoupper($fila_curso["letra_curso"]));												

}else if($fila_curso['grado_curso']==3 and $fila_curso['cod_decreto']==871990){

$Curso_pal0 = "PRIMER CICLO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "PCB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "PRIMER CICLO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "PCB - ". ucwords(strtoupper($fila_curso["letra_curso"]));

}else if($fila_curso['grado_curso']==4 and $fila_curso['cod_decreto']==871990){

$Curso_pal0 = "SEGUNDO CICLO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "SCB- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "SEGUNDO CICLO BÁSICO - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "SCB - ". ucwords(strtoupper($fila_curso["letra_curso"]));	

}else if($fila_curso['grado_curso']==5 and $fila_curso['cod_decreto']==871990){

$Curso_pal0 = "CICLO LABORAL - ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));
$Curso_pal1 = "CL- ". ucwords(strtoupper($fila_curso["letra_curso"]. $fila_curso['nombre_tipo']));		
$Curso_pal0 = "CICLO LABORAL - ". ucwords(strtoupper($fila_curso["letra_curso"]));		
$Curso_pal3 = "CL - ". ucwords(strtoupper($fila_curso["letra_curso"]));

}else{

$Curso_pal0 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 
$Curso_pal1 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 		
$Curso_pal2 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 		
$Curso_pal3 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"])); 	
$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . " - " . $fila_curso["letra_curso"]. $fila_curso['nombre_tipo'])); 
//$Curso_pal4 =  ucwords(strtoupper($fila_curso["grado_curso"] . "º AÑO DE " . $fila_curso['nombre_tipo']));
$Curso_pal5 =  ucwords(strtoupper("AÑO DE ".$fila_curso['nombre_tipo'])); 		

}

if ($tipo == 0) return $Curso_pal0;
if ($tipo == 1) return $Curso_pal1;
if ($tipo == 2) return $Curso_pal2;
if ($tipo == 3) return $Curso_pal3;				
if ($tipo == 4) return $Curso_pal4;				
if ($tipo == 5) return $Curso_pal5;				

}
	
	
	
 } // Fin Class

?>

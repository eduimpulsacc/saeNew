<?  
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require_once("Coneccion.php");
	 
class Reporte{

public $Conec;

//Constructor 



public function __construct($ip,$bd){
	$this->Conec = new DBManager($ip,$bd);
	
 } 
 
public function ProfesorJefe($curso){
	$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado e INNER JOIN supervisa s ON e.rut_emp=s.rut_emp WHERE id_curso=".$curso;
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
	$nombre = pg_result($result,0);
	return $nombre;
	
	
		
}


public function Empleado($rut_emp){
	$sql="SELECT nombre_emp ||' '|| ape_pat ||' '|| ape_mat as nombre FROM empleado WHERE rut_emp=".$rut_emp;
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
	$nombre_emp = pg_result($result,0);
	return $nombre_emp;
		
}

public function nombreAlumno($rut_alu){
	 $sql="select ape_pat ||' '|| ape_mat ||' '|| nombre_alu as nombre_alumno FROM alumno where rut_alumno =".$rut_alu;
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
	$nombre_alu = pg_result($result,0);
	return $nombre_alu;
		
}

public function nombreApo($rut_apo){
	 $sql="select ape_pat ||' '|| ape_mat ||' '|| nombre_apo as nombre_apos FROM apoderado where rut_apo =".$rut_apo;
	$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
	$nombre_apos = pg_result($result,0);
	return $nombre_apos;
		
}



public function institucion($inst){

$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro,   region.nom_reg, provincia.nom_pro, region,ciudad,comuna,comuna.nom_com, institucion.telefono,institucion.fax,dig_rdb, email,letra_inst,area_geo, dependencia, nu_resolucion, fecha_resolucion,numero_inst FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON  (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna  ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) WHERE institucion.rdb=".$inst." ";
   $result_ins = pg_exec( $this->Conec->conectar(),$sql_ins ) or die ("Select falló : ".$sql_ins);
   return  pg_fetch_array($result_ins,0);	
		
 }


	
public function anoescolar($_INSTIT){

 $sql = "SELECT * from ano_escolar aes where aes.id_institucion = ".$_INSTIT." and aes.situacion = 1";

$regis = pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd E#e#ee#" );
return pg_fetch_array($regis,0);
 }
 
 
 public function periodo($ano){

 $sql = "SELECT * from periodo  where id_ano=$ano";
$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
 }
 
 public function AnoEscolarSeteado($_ANO_CEDE){

  $sql = "SELECT * from ano_escolar aes where aes.id_ano = ".$_ANO_CEDE;

 $regis = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1" );

  return @pg_fetch_array($regis,0);

 }
 
public function AlumnoCurso($curso){
	$sql="SELECT a.rut_alumno, ape_pat ||' '|| ape_mat ||' '|| nombre_alu as nombre_alumno FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_curso=".$curso." ORDER BY 2 ASC";
	$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
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

	public function Anotaciones($ano,$rut,$tipo){
		$sql=" select count(*) from anotacion a  INNER JOIN periodo p ON a.id_periodo=p.id_periodo WHERE p.id_ano=".$ano." AND a.rut_alumno=".$rut." and tipo=1 and tipo_conducta=".$tipo;	
		$result = @pg_Exec( $this->Conec->conectar(),$sql );
		return $result;
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
	
	function TraeDescBeca($ano){
	$sql="select * from becas_conf where id_ano=".$ano;
	$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
	
	}
	
	function TraeBecasES($ano,$rut){
	$sql="select bool_baj,bool_bchs,bool_mun,bool_fci,bool_cpadre,bool_seg,ben_pie,ben_sep,ben_puente,bool_otros from matricula where id_ano=".$ano." and rut_alumno=".$rut."" ;
	$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
	
	}
	
	function TraeBecasINS($ano,$rut,$beca){
	 $sql="select * from becas_benef where id_ano=".$ano." and rut_alumno=".$rut." and id_beca =$beca" ;
	$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
	
	}
	
	function TraeSumBecasINS($ano,$beca,$curso){
	 $sql="
	select count(*) as suma_beca 
from becas_benef, matricula
where becas_benef.rut_alumno = matricula.rut_alumno 
and matricula.id_ano=$ano and id_beca =$beca
and matricula.id_curso= $curso
	" ;
	$result = @pg_Exec( $this->Conec->conectar(),$sql ) or die( "Error bd 1".$sql );
	return $result; 
	
	}
	
	function conteo_entrevistas($ano,$alumno,$tipo){
	 $sql = "select count(*) as conteo from entrevista where id_ano=".$ano." and rut_alumno=".$alumno." and tipo_entrevista=".$tipo;
		$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	function conteo_entrevistas_todas($ano,$alumno){
	 $sql = "select count(*) as conteo from entrevista where id_ano=".$ano." and rut_alumno=".$alumno;
		$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		$detalle = pg_result($result,0);
		return $detalle;
	}
	
	
	function getAtrasos($ano,$alumno){
		$sql="select * from anotacion
inner join periodo on anotacion.id_periodo = periodo.id_periodo
where periodo.id_ano = ".$ano."
and anotacion.rut_alumno=".$alumno."
and anotacion.tipo =2";
$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	function getAnotaciones($ano,$alumno){
	$sql="SELECT a.*, 
b.nombre_emp || CAST(' ' as varchar) || ape_pat || CAST(' ' as varchar) || ape_mat as nombre 
FROM anotacion a 
INNER JOIN empleado b ON a.rut_emp=b.rut_emp
inner join periodo on periodo.id_periodo = a.id_periodo 
WHERE rut_alumno=".$alumno."
and tipo<>2
and periodo.id_ano=".$ano." 
ORDER BY a.id_anotacion asc, fecha ";
$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
		
	}
	
	function getAsistencia($ano,$alumno,$curso){
		$sql="select * from asistencia
where ano = ".$ano."
and rut_alumno=".$alumno."
and id_curso=".$curso;
$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
		
	}
	
	
	public function SiglaSubsector($sigla){
 	$sql="SELECT detalle from sigla_subsectoraprendisaje where id_sigla=".$sigla;
$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
	$detalle = pg_result($result,0);
	return $detalle;
}

function TipoAnotacion($institucion,$tipo){
		 $sql = "SELECT descripcion FROM tipos_anotacion WHERE rdb = '".$institucion."' ";
		$sql.=" AND id_tipo=".$tipo." ";
		$result = pg_exec( $this->Conec->conectar(),$sql )/* or die ("Select falló : ".$sql)*/;
		$descripcion = pg_result($result,0);
	    return $descripcion;
	}
	
function idTipoAnotacion($institucion,$tipo){
		 $sql = "SELECT id_tipo FROM tipos_anotacion WHERE rdb = '".$institucion."' ";
		$sql.=" AND id_tipo=".$tipo." ";
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
		$id_tipo = pg_result($result,0);
	    return $id_tipo;
	}
	
	function codigoAnotacion($institucion,$tipo){
		  $sql = "SELECT codtipo FROM tipos_anotacion WHERE rdb = '".$institucion."' ";
		$sql.=" AND id_tipo=".$tipo." ";
		//echo $sql;
		$result = pg_exec( $this->Conec->conectar(),$sql )/* or die ("Select falló : ".$sql)*/;
		$codtipo = pg_result($result,0);
	    return $codtipo;
	}
	
	
	function DetalleAnotaciones($tipo,$codigo){
		$sql = "SELECT detalle FROM detalle_anotaciones WHERE id_tipo ='".$codigo."' ";
		$sql.=" AND codigo = '".$tipo."' ";
		
		$sql.=" ORDER BY id_anotacion ASC";
		//echo $sql;
		$result = pg_exec( $this->Conec->conectar(),$sql ) /*or die ("Select falló : ".$sql)*/;
		$descripcion = pg_result($result,0);
	    return $descripcion;
	}
	
	
	function TotalPeriodo($ano){
	$sql = "SELECT * FROM periodo WHERE id_ano = ".$ano." order by id_periodo,fecha_inicio";
		
$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	
	function RamoAlumno($nro_ano,$curso,$alumno){
  	  $sql = "SELECT distinct ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.bool_ip,subsector.nombre_ingles, ramo.cod_subsector, ramo.bool_ip,ramo.id_orden,ramo.bool_artis, ramo.coef2 ";
	  $sql.= "FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
	 /* if($this->subsector==0){
	  	$sql.= " and (ramo.cod_subsector < 50000 or ramo.cod_subsector=50600 or ramo.cod_subsector=50629 )";
	  }*/
	  $sql.= " ) INNER JOIN ";
	  $sql.= "tiene$nro_ano ON (ramo.id_curso = tiene$nro_ano.id_curso) AND (ramo.id_ramo = tiene$nro_ano.id_ramo) ";
	  $sql.= "WHERE (((ramo.id_curso)=".$curso.") AND tiene$nro_ano.rut_alumno=".$alumno." ) and ramo.bool_ip=1 order by ramo.id_orden; ";
	// echo $sql;
	 $result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
  }
	
	
	 
	function PromediosPeriodo($nro_ano,$periodo,$ramo,$alumno){
		$sql="select promedio from notas$nro_ano where id_periodo= $periodo and id_ramo=$ramo and rut_alumno=$alumno";
		
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
		$promedio = pg_result($result,0);
	    return $promedio;
		
	}
	
	function LogroNota($nota,$ano){
		 $sql="select concepto from cede.nivel_logro where nota_minima<=$nota and nota_maxima>=$nota and id_ano=$ano";
		
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
		$concepto = pg_result($result,0);
	    return $concepto;
		
	}
	
	
	function PromedioSubFinal($rut,$ramo){
		  $sql = "SELECT promedio FROM promedio_sub_alumno WHERE  id_ramo=".$ramo." AND rut_alumno=".$rut;
		
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
		$promedio = pg_result($result,0);
	    return $promedio;
	}
	
	function PromedioAnoFinal($rut,$ano,$curso){
		  $sql = "SELECT promedio FROM promocion WHERE  id_ano=".$ano." AND rut_alumno=".$rut." and id_curso =".$curso;
		
		$result = pg_exec( $this->Conec->conectar(),$sql ) or die ("Select falló : ".$sql);
		$promedio = pg_result($result,0);
	    return $promedio;
	}

	function Curso($curso){
 	$sql = "SELECT * FROM curso WHERE id_curso = ".$curso;
		
$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	
	
function Conceptual($nota, $tipo)

{

	//$tipo = 1 --- $nota viene con valor numérico devuelve conceptual

	//$tipo = 2 --- $nota viene con valor conceptual devuelve numérico

	$nota_res=0;

	$concepto="";		

	if ($tipo == 1)

	{

		if ($nota >= 60 and $nota<=70)

			$concepto = "MB";

		if ($nota >= 50 and $nota<=59)

			$concepto = "B";

		if ($nota >= 40 and $nota<=49)

			$concepto = "S";

		if ($nota >= 0 and $nota<=39)

			$concepto = "I";
		
		if($nota==0)
		
			$concepto = "-";

		

		return $concepto ;

	}

	else

	{

		if (trim($nota) == "MB")

			$nota_res = 65;

		if (trim($nota) == "B")

			$nota_res = 55;			

		if (trim($nota) == "S")

			$nota_res = 45;

		if (trim($nota) == "I")

			$nota_res = 35;						

		

		return $nota_res;

		

	}

	

	

}	



public function evaluacionApo($ano,$evaluacion,$entrevistado){
	 $sql = "select distinct(rut),titulo,plantilla_apo.id_plantilla,plantilla_apo.descripcion from plantilla_apo
inner join plantilla_apo_evaluacion
on plantilla_apo.id_plantilla = plantilla_apo_evaluacion.id_plantilla
where  plantilla_apo_evaluacion.id_ano=$ano and plantilla_apo.id_plantilla=$evaluacion and plantilla_apo_evaluacion.rut=$entrevistado";

//echo $sql;
	$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	}
	
	
public function getAreas($plantilla){
	
	    $sql="select * from plantilla_apo_area where id_plantilla=".$plantilla ;
			$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	
}

public function getConceptoApo($plantilla,$area){
	
	    $sql="select * from plantilla_apo_item where id_plantilla=".$plantilla." and id_area=$area and activo=1" ;
			$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	
}

public function selEvaluacionPeriodo($entrevistado,$ano,$periodo){
	  $sql ="select * from plantilla_apo_evaluacion av
where av.rut=$entrevistado and  av.id_ano=$ano and av.id_periodo=$periodo";
	$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	
}
	
public	function selItemEvaluacionApo($evaluacion,$area,$item,$ano,$periodo){
 $sql ="select ev.id_evaluacion,ev.id_concepto,iv.nombre from plantilla_apo_evaluacion_item ev
inner join plantilla_apo_evaluacion av
on av.id_evaluacion=ev.id_evaluacion
inner join plantilla_apo_concepto iv
on iv.id_concepto = ev.id_concepto
where ev.id_evaluacion=$evaluacion and id_area=$area and id_item=$item
and av.id_ano=$ano and av.id_periodo=$periodo";
	$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;

}
	
	
	public function ListaConceptoApo($plantilla){
	
	    $sql="select * from plantilla_apo_concepto where id_plantilla=".$plantilla ." and  activo=1" ;
			$result = @pg_exec($this->Conec->conectar(),$sql) or die ("SELECT FALLÓ:".$sql);
		return $result;
	
}
 } // Fin Class

?>

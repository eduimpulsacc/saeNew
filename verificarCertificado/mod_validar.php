<?php  

$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_usuario");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	



	 
function CambioFD($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla sin año
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
	 
//funciones para validar
function buscaCertificado($connection,$codigo){
$sql="select * from codigo_verificacion where codigo='".trim($codigo)."'";

$result= pg_exec($connection,$sql);
return $result;

}

function datoAlumno($id_base,$rut,$id_ano,$id_curso){
if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }	

	
 $sql="
select al.nombre_alu ||' '||al.ape_pat||' '||al.ape_mat nombre,
case 
WHEN (c.ensenanza=10 and c.grado_curso=4) THEN 'PRE KINDER' 
WHEN (c.ensenanza=10 and c.grado_curso=5) THEN 'KINDER'
ELSE cast(c.grado_curso as varchar)
END ||'-'|| c.letra_curso||' '||en.nombre_tipo dcurso,
upper(ins.nombre_instit) as colegio
from alumno al 
inner join matricula m on m.rut_alumno = al.rut_alumno 
inner join curso c on c.id_curso = m.id_curso 
inner join tipo_ensenanza en on en.cod_tipo = c.ensenanza
inner join ano_escolar an on an.id_ano = c.id_ano
inner join institucion ins on ins.rdb = an.id_institucion
where al.rut_alumno=$rut
and m.id_ano = $id_ano and m.id_curso = $id_curso
 ";
$result= pg_exec($conn,$sql);
return $result;
	
}

function infoCertificado($id_base,$tipo){
	
if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	
	 }	

	
 $sql="select upper(nombre) from item_reporte where id_item=$tipo";
$result= pg_exec($conn,$sql);
return $result;
	
}
	 
	?>
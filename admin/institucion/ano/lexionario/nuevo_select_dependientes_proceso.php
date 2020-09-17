
<?php
require('../../../../util/header.inc');


//print_r($_POST);

$funcion= $_POST['funcion'];


if($funcion==11)
{
	
	if($_PERFIL!=17){

  echo "<select name='cmb_curso' id='cmb_curso' onChange='cargaRamos(this.value)'>";
  echo "<option value='0'>Elige</option>";
	  
    $sql="select * from curso where id_ano=".$id_ano." ";
	$sql = $sql."ORDER BY  curso.ensenanza, curso.grado_curso, curso.letra_curso ASC";
	
	$rs_curso= pg_exec($conn, $sql) or die ("select fallo:".$sql);	
	
	for($j=0; $j< pg_numrows($rs_curso); $j++){
	$fila_2= pg_fetch_array($rs_curso,$j);
	$Curso_pal = CursoPalabra($fila_2['id_curso'], 1, $conn);
	echo "<option value='".$fila_2['id_curso']."'>".$Curso_pal."</option>";
	
  }
		
  
}else{
	
	$sql_sup="select c.id_curso from supervisa s 
INNER JOIN curso c ON s.id_curso=c.id_curso 
WHERE s.rut_emp=$rut_emp and id_ano=$id_ano
UNION
select c.id_curso from dicta d 
INNER JOIN ramo r ON d.id_ramo=r.id_ramo 
INNER JOIN curso c ON c.id_curso=r.id_curso 
WHERE rut_emp=$rut_emp AND id_ano=$id_ano";
 
  $rs_sup= pg_exec($conn, $sql_sup) or die ("select fallo:".$sql_sup);
  if(pg_numrows($rs_sup)!=0){		
  echo "<select name='cmb_curso' id='cmb_curso' onChange='cargaRamos(this.value)'>";
  echo "<option value='0'>Elige</option>";
  for($i=0; $i< pg_numrows($rs_sup); $i++){
	  $fila= pg_fetch_array($rs_sup,$i);
	  
     $sql="select id_curso from curso where id_ano=".$id_ano." and id_curso=".$fila['id_curso']." ";
	 $sql = $sql."ORDER BY  curso.ensenanza, curso.grado_curso, curso.letra_curso ASC";
	 $rs_curso= pg_exec($conn, $sql) or die ("select fallo:".$sql);	
	
	for($j=0; $j< pg_numrows($rs_curso); $j++){
	$fila_2= pg_fetch_array($rs_curso,$j);
	$Curso_pal = CursoPalabra($fila_2['id_curso'], 1, $conn);
	echo "<option value='".$fila_2['id_curso']."'>".$Curso_pal."</option>";
	}  
	
  }
  
 }/*else{
	 
	 echo "aqui";
	 
	  
  echo "<select name='cmb_curso' id='cmb_curso' onChange='cargaRamoSolo(this.value)'>";
  echo "<option value='0'>Elige</option>";
  for($i=0; $i< pg_numrows($rs_sup); $i++){
	  $fila= pg_fetch_array($rs_sup,$i);
	  
    $sql="select id_curso from curso where id_ano=".$id_ano." ";
	$sql = $sql."ORDER BY  curso.ensenanza, curso.grado_curso, curso.letra_curso ASC";
	$rs_curso= pg_exec($conn, $sql) or die ("select fallo:".$sql);	
	
	for($j=0; $j< pg_numrows($rs_curso); $j++){
	$fila_2= pg_fetch_array($rs_curso,$j);
	$Curso_pal = CursoPalabra($fila_2['id_curso'], 1, $conn);
	echo "<option value='".$fila_2['id_curso']."'>".$Curso_pal."</option>";
	}  
   }
  }*/	
	
	
	}
}



if($funcion==12)
{
/*	select c.id_curso from dicta d 
INNER JOIN ramo r ON d.id_ramo=r.id_ramo 
INNER JOIN curso c ON c.id_curso=r.id_curso 
WHERE rut_emp=$rut_emp AND id_ano=$id_ano
	*/
	
	  $sql="select r.id_ramo,sub.nombre from ramo r
	      inner join subsector sub on sub.cod_subsector=r.cod_subsector
          inner join curso c on c.id_curso=r.id_curso
          inner join dicta d on d.id_ramo=r.id_ramo and d.rut_emp=$rut_emp
		  where r.id_curso=$id_curso"; 
	    $rs_ramo=pg_exec($conn,$sql) or die ("select fallo:".$sql);	

	//if(pg_numrows($rs_ramo)!=0){
	if($_PERFIL!=14 && $_PERFIL!=58){
		
    echo "<select name='cmb_ramo' id='cmb_ramo' onChange='cargadatos(0)'>";
	echo "<option value='0'>Elige</option>";
	for ($i=0; $i< pg_numrows($rs_ramo);$i++)
	{
	  	
	$fila=pg_fetch_array($rs_ramo,$i);
		
	// Imprimo las opciones del select
	echo "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
	}			
	echo "</select>";		
	
	}
	
	
	else{

	  $sql="select distinct id_ramo, ramo.cod_subsector, subsector.nombre
	from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
	where id_curso=$id_curso ";
	$rs_ramo=pg_exec($conn,$sql) or die ("select fallo:".$sql);
	
	// Comienzo a imprimir el select
	echo "<select name='cmb_ramo' id='cmb_ramo' onChange='cargadatos(0)'>";
	echo "<option value='0'>Elige</option>";
	for ($i=0; $i< pg_numrows($rs_ramo);$i++)
	{
	$fila=pg_fetch_array($rs_ramo,$i);
	// Imprimo las opciones del select
	echo "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
	}			
	echo "</select>";
  }
}

if($funcion==13)
{

	$sql="select distinct id_ramo, ramo.cod_subsector, subsector.nombre
from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
where id_ramo=$id_ramo ";
           
	
	$rs_ramo=pg_exec($conn,$sql) or die ("select fallo:".$sql);		
		
	// Comienzo a imprimir el select
	echo "<select name='cmb_curso' id='cmb_curso' onChange='cargadatos(0)'>";
	echo "<option value='0'>Elige</option>";
	for ($i=0; $i< pg_numrows($rs_ramo);$i++)
	{
	  	
	$fila=pg_fetch_array($rs_ramo,$i);
		
	// Imprimo las opciones del select
	echo "<option value='".$fila['id_ramo']."'>".$fila['nombre']."</option>";
	}			
	echo "</select>";
	
}
?>
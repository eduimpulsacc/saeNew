<? require('util/header.inc');

/////////////////////////////////////////////
///MOVER CURSOS DE ENSEÑANZA BASICA MEDIA///  
///////////////////////////////////////////

$qsql = "SELECT matri.rut_alumno,matri.id_ano,matri.id_curso,anes.nro_ano,
matri.nro_lista,cu.grado_curso,cu.letra_curso,cu.nivel_grado,cu.id_nivel,
cu.ensenanza FROM matricula as matri
inner join ano_escolar as anes on anes.id_ano = matri.id_ano
inner join curso as cu on (cu.id_ano = anes.id_ano) and (cu.id_curso = matri.id_curso) 
and (cu.ensenanza = 110 or cu.ensenanza = 310 or cu.ensenanza = 10 )
where matri.rdb = 9796 and matri.id_ano = 1060 order by 5,3 ";
  
$rsql = @pg_Exec($conn,$qsql) or die ( "Error 1" );
$n0 = @pg_numrows($rsql);

$noejecuta=0;
		  		   
for($i=0;$i<@pg_numrows($rsql);$i++){  
						 
$f111 = pg_fetch_array($rsql,$i);

$nuevo_id_ano = 1133;

$ensenanza = trim($f111['ensenanza']);


if($f111['ensenanza']==10){

if($f111['grado_curso']==4){ $numero_grado = $f111['grado_curso'] + 1; }
if($f111['grado_curso']==5){ $numero_grado = 1; 
$ensenanza = 110; }

}			 


if($f111['ensenanza']==110){

	if($f111['grado_curso']==8){
	  $numero_grado = 1;
	  $ensenanza = 310;
	}else{
	  $numero_grado = $f111['grado_curso'] + 1;
	}

}			 


if($f111['ensenanza']==310){

	if($f111['grado_curso']==1){ $numero_grado = $f111['grado_curso'] + 1; }
	if($f111['grado_curso']==2){ $numero_grado = $f111['grado_curso'] + 1; }
	if($f111['grado_curso']==3){ $numero_grado = $f111['grado_curso'] + 1; }
	if($f111['grado_curso']==4){ $noejecuta = 1; }

}			 


if($noejecuta!=1){

//echo "<pre><br>".

$qsql4 = "SELECT curso.id_curso,curso.cod_decreto,curso.grado_curso, 
		  curso.letra_curso,curso.acta,curso.bool_jor,tipo_ensenanza.nombre_tipo,cod_tipo 
		  FROM tipo_ensenanza 
		  INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON 
		  tipo_ensenanza.cod_tipo = curso.ensenanza 
		  WHERE ano_escolar.id_ano= ".trim($nuevo_id_ano)." 
		  AND curso.grado_curso = ".trim($numero_grado)." 
		  AND curso.letra_curso = '".trim($f111['letra_curso'])."'
		  AND tipo_ensenanza.cod_tipo = ".$ensenanza."
		  order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc";
//echo "</pre>";					  

		  $rsql4 = @pg_Exec($conn,$qsql4) or die ( "Error 2");
          $n4 = @pg_numrows($rsql4);
          $f444 = pg_fetch_array($rsql4,0); 
			 
$sql3 = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_ar)VALUES(".$f111['rut_alumno'].",9796,".$nuevo_id_ano.",".$f444['id_curso'].",'2011-03-03',0)";
        
		$rsql3 = @pg_Exec($conn,$sql3) or die ( "Error 3<br><pre>".$qsql4."</pre><br>".$sql3 );
  
 }

}	// fin de for	

echo $i;


?>
<?php
/*require_once('nusoap-0.9.5/lib/nusoap.php');
$param = "<?xml version="1.0" encoding="UTF-8"?>
<EntradaSemillaServicios  xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://wwwfs.mineduc.cl/Archivos/Schemas/ EntradaSemillaServicios.xsd ">
<ClienteId>3</ClienteId>
<ConvenioId>4</ConvenioId>
<ConvenioToken>TESTSIGE</ConvenioToken></EntradaSemillaServicios>*/
//phpinfo();

/*$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");
*/


//MOVER CURSOS DE ENZAÑANZA ADULTA 

$sql = "SELECT 
curso.id_curso, 
curso.cod_decreto, 
curso.grado_curso, 
curso.letra_curso, 
curso.acta, 
curso.bool_jor, 
tipo_ensenanza.nombre_tipo, 
cod_tipo 
FROM tipo_ensenanza 
INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON 
tipo_ensenanza.cod_tipo = curso.ensenanza 
WHERE (((ano_escolar.id_ano)=1161)) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc ";

$rsql1 = @pg_Exec($conn,$sql) or die ( pg_last_error($conn));
	  
$n0 = @pg_numrows($rsql1);

$table1 = "<table width='100%' border='1'>";		   

$table1 .= "<tr>
			<td>id_curso&nbsp;</td>
			<td>cod_decreto&nbsp;</td>
			<td>grado_curso&nbsp;</td>
			<td>letra_curso&nbsp;</td>
			<td>acta&nbsp;</td>
			<td>bool_jor&nbsp;</td>
			<td>nombre_tipo&nbsp;</td>
		  </tr>";
		  		   
for($i=0;$i<@pg_numrows($rsql1);$i++){
						 
$f112 = pg_fetch_array($rsql1,$i);

$table1 .= "<tr>
			<td>".$f112['id_curso']."&nbsp;</td>
			<td>".$f112['cod_decreto']."&nbsp;</td>
			<td>".$f112['grado_curso']."&nbsp;</td>
			<td>".$f112['letra_curso']."&nbsp;</td>
			<td>".$f112['acta']."&nbsp;</td>
			<td>".$f112['bool_jor']."&nbsp;</td>
			<td>".$f112['nombre_tipo']."&nbsp;</td>
		  </tr>";
    }			

$table1 .= "</table>";

echo $table1."<br>";

////////////////////////////////////////////

$qsql = "select 
matri.rut_alumno,
matri.id_ano,
matri.id_curso,
anes.nro_ano,
matri.nro_lista,
cu.grado_curso,
cu.letra_curso,
cu.nivel_grado,
cu.id_nivel,
cu.ensenanza
from matricula as matri  
left outer join ano_escolar as anes on anes.id_ano = matri.id_ano
inner join curso as cu on (cu.id_ano = anes.id_ano) and (cu.id_curso = matri.id_curso) and (cu.ensenanza = 663)
where matri.rdb = 283 and EXTRACT(year from matri.fecha) = 2010 order by 5,3 ";
  
$rsql = @pg_Exec($conn,$qsql) or die ( pg_last_error($conn));
$n0 = @pg_numrows($rsql);


$table = "<table width='100%' border='1'>";		   

$table .= "<tr>
            <td>situacion_final&nbsp;</td>
			<td>matriculado&nbsp;</td>  
			<td>rut_alumno&nbsp;</td>
			<td>id_ano&nbsp;</td>
			<td>id_curso&nbsp;</td>
			<td>nro_ano&nbsp;</td>
			<td>grado_curso&nbsp;</td>
			<td>letra_curso&nbsp;</td>
			<td>nivel_grado&nbsp;</td>
			<td>id_nivel&nbsp;</td>
			<td>ensenanza&nbsp;</td>
		  </tr>";
		  		   
for($i=0;$i<@pg_numrows($rsql);$i++){ // recorro alumnos y compruevo su situacion final
						 
$f111 = pg_fetch_array($rsql,$i);

$qsql2 = "select  
promo.situacion_final
from promocion as promo  where 
promo.rdb = 283
and promo.id_ano = ".$f111['id_ano']."  
and promo.id_curso = ".$f111['id_curso']."
and promo.rut_alumno = ".$f111['rut_alumno']." ";

$rsql2 = @pg_Exec($conn,$qsql2) or die ( pg_last_error($conn));
$n2 = @pg_numrows($rsql2);

$nuevo_id_ano = 1161; 
$f222 = pg_fetch_array($rsql2,0);

$situacion_final = $f222['situacion_final'];


switch ($situacion_final) {

         case "1": // matricula con id_curso
		 
             $matriculado = 1;
			 
			 if( $f111['grado_curso']==1 ){
			  
			   $numero_grado = $f111['grado_curso']+2;
			 
			 }elseif($f111['grado_curso']==3){
			 
			   $numero_grado = $f111['grado_curso']+1;			   
			 
			 }
			 
			
		    if( $f111['grado_curso'] != 4 ){	 
			 
			 $qsql4 = "SELECT curso.id_curso,curso.cod_decreto,curso.grado_curso, 
					  curso.letra_curso,curso.acta,curso.bool_jor,tipo_ensenanza.nombre_tipo,cod_tipo 
					  FROM tipo_ensenanza 
					  INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON 
					  tipo_ensenanza.cod_tipo = curso.ensenanza 
					  WHERE ano_escolar.id_ano=1161 
					  AND curso.grado_curso = ".$numero_grado." 
					  AND curso.letra_curso = '".$f111['letra_curso']."'
					  AND tipo_ensenanza.cod_tipo = 663
					  order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc";
					  
			 $rsql4 = @pg_Exec($conn,$qsql4) or die ( pg_last_error($conn));
             $n4 = @pg_numrows($rsql4);
             $f444 = pg_fetch_array($rsql4,0); 
			 
			 
			 $sql3 = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_ar)
			 VALUES(".$f111['rut_alumno'].",283,".$nuevo_id_ano.",".$f444['id_curso'].",'2011-03-03',0)";
			 //$rsql3 = @pg_Exec($conn,$sql3) or die ( pg_last_error($conn));
               
			 }
			 
			 
			 break;
			 
			 
         case "2": // matricula sin id_curso
		 
              $matriculado = 2;

			  $sql3 = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_ar)
              VALUES(".$f111['rut_alumno'].",283,".$nuevo_id_ano.",0,'2011-03-03',0)";
              //$rsql3 = @pg_Exec($conn,$sql3) or die ( pg_last_error($conn));
			  
              break;
         
		 default: // no se genera matricula
		 
             $matriculado = 3;
     
	 
	 }


$table .= "<tr>
            <td>".$situacion_final."&nbsp;</td>
			<td>".$matriculado."&nbsp;</td>
			<td>".$f111['rut_alumno']."&nbsp;</td>
			<td>".$f111['id_ano']."&nbsp;</td>
			<td>".$f111['id_curso']."&nbsp;</td>
			<td>".$f111['nro_ano']."&nbsp;</td>
			<td>".$f111['grado_curso']."&nbsp;</td>
			<td>".$f111['letra_curso']."&nbsp;</td>
			<td>".$f111['nivel_grado']."&nbsp;</td>
			<td>".$f111['id_nivel']."&nbsp;</td>
			<td>".$f111['ensenanza']."&nbsp;</td>
		  </tr>";

}	// fin de for	

	

$table .= "</table>";


echo $table;
echo "ccc";

?>

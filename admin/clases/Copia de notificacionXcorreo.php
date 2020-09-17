<? 

//la pagina expira en una fecha pasada
header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); 
//ultima actualizacion ahora cuando la cargamos
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
//no guardar en CACHE
header ("Cache-Control: no-cache, must-revalidate"); 
header ("Pragma: no-cache");

/*$ano = 1184;  // ano 2011 activo
$periodo = 2373;  // primer semestre 
$curso = 20857; // curso del año 
$id_ramo = 323203; // ramo que pertenece a este curso
$usuario = 14620;
$alumno = 18878823; // alumno del curso */
//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
/*$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	*/
/*correo_notificacion_notas($curso,$ano,$id_ramo,$periodo,$conn,$usuario,1);*/
//correo_notificacion_anotacion($alumno,$ano,$conn,$usuario,1,$id_ramo);
/*correo_notificacion_inasistencia (9699,576,$conn);*/


function correo_notificacion_anotacion($rut,$ano,$conn,$usuario,$guardo,$id_ramo) {

$qsql = "SELECT ncc.id_notifica_correo_configuracion, 
		 ncc.rbd, ncc.tipo_ensenanza, 
		 ncc.cargo, ncc.notifica_notas, 
		 ncc.nro_notas, ncc.nota_deficiente, 
		 ncc.notifica_anotaciones, ncc.nro_anotaciones, 
		 ncc.notifica_asistencia, ncc.dias_asistencia, 
		 ncc.periodo_notificacion, 
		 anes.nro_ano,ma.id_ano
		 FROM matricula as ma 
		 INNER JOIN curso cu ON cu.id_curso = ma.id_curso 
		 INNER JOIN ano_escolar anes ON anes.id_ano = ma.id_ano
		 INNER JOIN notifica_correo_configuracion ncc ON ncc.rbd = ma.rdb 
		 AND ncc.tipo_ensenanza = cu.ensenanza 
		 WHERE ma.rut_alumno = $rut
		 AND ma.id_ano = $ano";
	   
		   $rsql = @pg_Exec($conn,$qsql) or die ( pg_last_error($conn));
		   $n0 = @pg_numrows($rsql);
		   $fsql = pg_fetch_array($rsql,0);
		   
		   $idconfiguracion = $fsql['id_notifica_correo_configuracion'];
		   $rbd = $fsql['rbd'];
		   $id_ano = $fsql['id_ano'];
		   $notificacion_anotaciones = $fsql['notifica_anotaciones']; 
   
	   
	   if( $fsql['notifica_anotaciones'] == 1 ){ 
	   // entra solo si esta activa la opcion de enviar por anotaciones 
	   
	   	   
       $q1 = "SELECT sum(tvz.num_anotaciones_negativas) as totalnegativas 
			 FROM (select count(aa1.id_anotacion) as num_anotaciones_negativas  from anotacion1 aa1
			 inner join tipos_anotacion tii on tii.id_tipo = aa1.codigo_tipo_anotacion
			 where 
			 aa1.rut_alumno = $rut 
			 and tii.tipo = 2
			 and EXTRACT(year from  aa1.fecha) = ".$fsql['nro_ano']."
			 UNION
			 select count(aa1.id_anotacion) as num_anotaciones_negativas  from anotacion1 aa1
			 where 
			 aa1.rut_alumno = $rut 
			 AND aa1.tipo_conducta = 2
			 and EXTRACT(year from  aa1.fecha) = ".$fsql['nro_ano']." ) as tvz";
			  
			   $r = @pg_Exec($conn,$q1) or die ( pg_last_error($conn));
			   $n = @pg_numrows($r);
			   $f = pg_fetch_array($r,0);
			   
		       $totalnegativas  = $f['totalnegativas'];
	   	
       
       if( $fsql['nro_anotaciones'] <= $totalnegativas ){ // si se cumple la condición	   
	   
	   	    //$q2 = "select * from notificacioncorreoanotaciones($rut,".$fsql['nro_ano'].")"; 
			
$q2 = "SELECT 
aa1.id_anotacion,
aa1.tipo_conducta as tipo_1,
aa1.observacion as detalle_1,
tii.tipo as tipo_2,
de.detalle as detalle_2,
aa1.fecha ,
cast(emp.ape_pat || ' ' || emp.ape_mat || ' ' || emp.nombre_emp as varchar ) as nombre_empleado,
cast(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_alumno,
cast(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno,
cast(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso,
current_date as fecha_actual,    
cast(apo.rut_apo || '-' || apo.dig_rut as varchar) as rut_apoderado,
cast(apo.ape_pat || ' ' || apo.ape_mat || ' ' || apo.nombre_apo as varchar) as  nombre_apoderado,
cast(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as nombre_profesorjefe
,cu.id_curso
FROM anotacion1 aa1
inner join empleado emp on emp.rut_emp = aa1.rut_emp
inner join alumno alu on alu.rut_alumno = aa1.rut_alumno 
left outer join tiene2 tie on tie.rut_alumno = alu.rut_alumno 
left outer join apoderado apo on apo.rut_apo = tie.rut_apo
inner join matricula matri on matri.rut_alumno = alu.rut_alumno 
and EXTRACT(year from matri.fecha) = ".$fsql['nro_ano']."
inner join curso cu on cu.id_curso = matri.id_curso
inner join  supervisa supe on supe.id_curso = cu.id_curso 
inner join  empleado projefe on projefe.rut_emp = supe.rut_emp
left outer join tipos_anotacion tii on tii.id_tipo = aa1.codigo_tipo_anotacion
left outer join detalle_anotaciones de on de.codigo = aa1.codigo_anotacion
WHERE 
aa1.rut_alumno = $rut
AND 
CASE WHEN aa1.tipo_conducta IS NOT NULL THEN aa1.tipo_conducta = 2 
     WHEN tii.tipo IS NOT NULL THEN tii.tipo = 2 
     END
AND EXTRACT(year from aa1.fecha) = ".$fsql['nro_ano']." 
ORDER BY  tipo_conducta,fecha desc";
						   
	        $r2 = @pg_Exec($conn,$q2) or die ( pg_last_error($conn));
	        $f11 = pg_fetch_array($r2,0);
		    
			$asunto="Notificacion Alumnos Cumple Condición de Anotaciónes";
			
			// mensaje
			$mensaje = '<html>
						<head>
						<title>Notificacion Alumno Cumple Condici&oacute;n de Anotaci&oacute;nes</title>
						</head>
						<body>
						<h2>Listado de Anotaciones </h2>
						<h3><p>Rut Alumno:'.$f11['rut_alumno'].'</p>
						<p>Nombre Alumno:'.$f11['nombre_alumno'].'</p>
						<p>Rut Apoderado:'.$f11['rut_apoderado'].'</p>
						<p>Nombre Apoderado:'.$f11['nombre_apoderado'].'</p>
						<p>Curso:'.$f11['curso'].'</p>
						<p>Profesor Jefe : '.$f11['nombre_profesorjefe'].'</p>
						<p>Fecha Actual:'.$f11['fecha_actual'].'</p><h3>
						<table border="1" width="100%" >
						<tr>
						<th>#</th>
						<th>Detalle Anotacion </th>
						<th>Profesor Responsable </th>
						<th>Fecha</th>
						</tr>';
			 
							 $cont=1;
							 
							 for($i=0;$i<@pg_numrows($r2);$i++){
							 
								$f111 = pg_fetch_array($r2,$i);
								
								if($f111['tipo_1']==2){
								   $detalle = $f111['detalle_1'];
								}elseif($f111['tipo_2']==2){
								   $detalle = $f111['detalle_2'];
								}
								 
								$mensaje .= '<tr>
											  <td>'.$cont.'</td>
											  <td width="400">'.$detalle.'</td>
											  <td>'.$f111['nombre_empleado'].'</td>
											  <td>'.$f111['fecha'].'</td>
											  </tr>';
								 
								$cont++;
							    }
			   
			$mensaje .= '</table>
			              </body>
			              </html>';
						  
						  
           //echo $mensaje;
		   
envio_correo_notificacion($asunto,$mensaje,$idconfiguracion,$conn,$rbd,$id_ano,$f11['id_curso'],$usuario,$guardo,$id_ramo);

		   
	       } //FIN si se cumple la condición	
	   
	   
	    } // FIN // entra solo si esta 
	    



 } // FIN FUNCION



function correo_notificacion_notas($curso,$ano,$id_ramo,$periodo,$conn,$usuario,$guardo) {

$qsql_parametros = "SELECT ncc.id_notifica_correo_configuracion, 
ncc.rbd, ncc.tipo_ensenanza, 
ncc.cargo, ncc.notifica_notas, 
ncc.nro_notas, ncc.nota_deficiente, 
ncc.notifica_anotaciones,ncc.nro_anotaciones, 
ncc.notifica_asistencia, ncc.dias_asistencia, 
ncc.periodo_notificacion, 
anes.nro_ano
FROM matricula as ma 
INNER JOIN curso cu ON cu.id_curso = ma.id_curso 
INNER JOIN ano_escolar anes ON anes.id_ano = ma.id_ano
INNER JOIN notifica_correo_configuracion ncc ON 
ncc.rbd = ma.rdb AND ncc.tipo_ensenanza = cu.ensenanza 
WHERE ma.id_curso = $curso
AND ma.id_ano = $ano LIMIT 1";
   
	   //echo "<pre>".$qsql_parametros."</pre>";
	   
	   $rsql_parametros = @pg_Exec($conn,$qsql_parametros) or die ( "Error Notas 1" );
	   $n0 = @pg_numrows($rsql_parametros);
	   $fsql_parametros = pg_fetch_array($rsql_parametros,0);
       
	   $idconfiguracion = $fsql_parametros['id_notifica_correo_configuracion'];
	   $nro_ano = $fsql_parametros['nro_ano'];
       $nro_notas_malas = $fsql_parametros['nro_notas'];
       $nota_deficiente = $fsql_parametros['nota_deficiente'];
	   $rbd = $fsql_parametros['rbd'];

// guardo la informacion de alumnos con el ramo y notas 
$informacionXramo = array();

$sql0 = "SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, 
proramo.rut_emp,
cast(proramo.ape_pat || ' ' || proramo.ape_mat || ' ' || proramo.nombre_emp as varchar) as nombre_profesor 
FROM subsector 
INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector
left outer join dicta di on di.id_ramo = ramo.id_ramo
left outer join empleado proramo on proramo.rut_emp = di.rut_emp
WHERE ramo.id_curso= $curso AND ramo.id_ramo = $id_ramo order by ramo.id_orden  ";
$rs_ramos = @pg_exec($conn,$sql0) or die  ( "Error Notas 2" );

 
 if (@pg_numrows($rs_ramos)!=0){  // recorro los ramos uno a uno y busco las notas malas 

    $cantiad_de_ramos = @pg_numrows($rs_ramos);
	 
    for($i1=0;$i1<@pg_numrows($rs_ramos);$i1++){	//ciclo ramos 		
	
	$fila_ramos = pg_fetch_array($rs_ramos,$i1);
	
	$cant_mayor = 0;
	
	$informacionXramo[$i1]['sub_sector-'.$i1]= $fila_ramos['nombre'];
	$informacionXramo[$i1]['profe_ramo-'.$i1]= $fila_ramos['nombre_profesor'];
		
	$sql_notas = "SELECT 
	n.rut_alumno,n.id_ramo,n.id_periodo,
	n.nota1,n.nota2,n.nota3,n.nota4,n.nota5,
	n.nota6,n.nota7,n.nota8,n.nota9,n.nota10,
	n.nota11,n.nota12,n.nota13,n.nota14,n.nota15,
	n.nota16,n.nota17,n.nota18,n.nota19,n.nota20,
	n.promedio,n.notaap,
	cast(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_dv_alumno,
	cast(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_alumno,
	cast(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso_completo,
	cast(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as 
	nombre_profesorjefe 
	FROM notas$nro_ano n 
	inner join matricula ma on ma.rut_alumno = n.rut_alumno and ma.id_curso = $curso 
	inner join alumno alu on alu.rut_alumno = ma.rut_alumno
	inner join curso cu on cu.id_curso = ma.id_curso
	left outer join  supervisa supe on supe.id_curso = cu.id_curso 
    left outer join empleado projefe on projefe.rut_emp = supe.rut_emp
	WHERE n.id_ramo = $id_ramo AND n.id_periodo = $periodo ";
	
	//echo "<pre>".$sql_notas."</pre>";
		
	$rs_notas = @pg_exec($conn,$sql_notas) or die  ( "Error Notas 3" );
		
			if (@pg_numrows($rs_notas)!=0){ // recorro las notas segun el id de ramo
			
				$cantidad_de_alumnos = @pg_numrows($rs_notas);
				
				for($i2=0;$i2<=@pg_numrows($rs_notas);$i2++){ 
				// ciclo recorro todos los alumnos y sus notas de este ramo
				    					
				$fila_notas = pg_fetch_array($rs_notas,$i2); 
				
				$informacionXramo[$i1]['curso_completo-'.$i2] = $fila_notas['curso_completo'];
				$informacionXramo[$i1]['profesorjefe-'.$i2] = $fila_notas['nombre_profesorjefe'];
				
				$informacionXramo[$i1]['rut_dv_alumno'.'-'.$i2] = $fila_notas['rut_dv_alumno'];
				$informacionXramo[$i1]['nombre_alumno'.'-'.$i2] = trim($fila_notas['nombre_alumno']);
								
				$cont_notas_malas = 0;
				$x=0;
				
				for($i3=1;$i3<=21;$i3++){ // ciclo recorre notas del alumno
				
									 
				if( $fila_notas['nota'.$i3] < $nota_deficiente && $fila_notas['nota'.$i3] <> 0 ){
					
					$cont_notas_malas++;
					$x++;
				    $informacionXramo[$i1]['notas_malas-'.$i2] = 1;
					$informacionXramo[$i1]['cant_malas-'.$i2] = $cont_notas_malas;
					$informacionXramo[$i1]['not'.$x.'-'.$i2] = $fila_notas['nota'.$i3];  
							   
					 }
						 
				} // fin  ciclo recorre notas del alumno
						 
				if($cont_notas_malas==0){
				
				$informacionXramo[$i1]['notas_malas-'.$i2] = 0;
				$informacionXramo[$i1]['cant_malas-'.$i2] = 0;
				
				}
				
				if($cant_mayor <= $cont_notas_malas) $cant_mayor = $cont_notas_malas;
								
				} // fin ciclo recorro
			
			
			}  //fin recorro notas  
	 
	    $informacionXramo[$i1]['cant_mayor_notas-'.$i1]= $cant_mayor;
		$informacionXramo[$i1]['cantidad_de_alumnos_x_ramo-'.$i1] = $cantidad_de_alumnos;

		
	   } // ciclo ramos
   
   
   } // fin // recorro los ramos
   
//============================================================

/*echo "<pre>";
print_r($informacionXramo);
echo "</pre>";*/

$fecha_actual=date("d/m/Y");

// mensaje
$mensaje = '<html>
			<head>
			<title>Notificacion por Notas</title>
			</head>
			<body>
			<h2>Listado de Alumnos con '.$nro_notas_malas.' o más Notas Insuficientes</h2>
			<h3><p>Fecha  :  '.$fecha_actual.'</p>
			<p>Curso  :  '.$informacionXramo[0]['curso_completo-0'].'</p>
			<p>Profesor Jefe  :  '.$informacionXramo[0]['profesorjefe-0'].'</p></h3>';
			
for($x1=0;$x1<=$cantiad_de_ramos;$x1++){ // 1

$cantidad_de_alumnos = $informacionXramo[$x1]['cantidad_de_alumnos_x_ramo-'.$x1];
$cant_mayor_notas = $informacionXramo[$x1]['cant_mayor_notas-'.$x1];
$sub_sector = $informacionXramo[$x1]['sub_sector-'.$x1];
$profe_ramo = $informacionXramo[$x1]['profe_ramo-'.$x1];

if ( $cantidad_de_alumnos>0 && $cant_mayor_notas>=$nro_notas_malas ){
			
$mensaje .= '<br><table border="0">
			<tr align="left">
			<th>Sub-sector:</th>
			<th>'.$sub_sector.'</th>
			</tr>
			<tr align="left">
			<th>Profesor:</th>
			<th>'.$profe_ramo.'</th>
			</tr>
			</table>';

$mensaje .= '<table border="1">
			<tr>
			<th>Rut</th>
			<th>Nombre</th>
			<th colspan="'.$cant_mayor_notas.'" >Notas</th>
			</tr>';

	
				for($x2=0;$x2<=$cantidad_de_alumnos;$x2++){ // 2
				
				 $notas_malas = $informacionXramo[$x1]['notas_malas-'.$x2];
				 $cant_malas  = $informacionXramo[$x1]['cant_malas-'.$x2];
				 
						if( $notas_malas == 1 && $cant_malas >= $nro_notas_malas ){ 
						//sino no se muestra alumno
						
						$rut_dv_alumno = $informacionXramo[$x1]['rut_dv_alumno'.'-'.$x2];
						$nombre_alumno = $informacionXramo[$x1]['nombre_alumno'.'-'.$x2];
										
						$mensaje .= '<tr>
									 <td>'.$rut_dv_alumno.'</td>
									 <td>'.$nombre_alumno.'</td>';
						
						for($x3=1;$x3<=$cant_mayor_notas;$x3++){ // 3
						 $mensaje .= '<td>'.$informacionXramo[$x1]['not'.$x3.'-'.$x2].'</td>'; 
						  } //3
						
						$mensaje .= '</tr>';
						
						  } // no se muestra alumno
				
					} // 2
		
          } 			 
				 
    $mensaje .= '</table>';


   } //1
 
 
$mensaje .= '</body>
			 </html>';
		

echo $mensaje;

$asunto="Notificacion Alumnos Cumple Condición de Notas Deficientes";

envio_correo_notificacion($asunto,$mensaje,$idconfiguracion,$conn,$rbd,$ano,$curso,$usuario,$guardo,$id_ramo);
						  
  } // FIN FUNCION CORREO NOTAS






//////////////////////////////////////////////////////////////////////////

function correo_notificacion_inasistencia ($idcurso,$idano,$conn,$usuario,$guardo) { 
//INICIO INASISTENCIA

$qsql_parametros = "SELECT ncc.id_notifica_correo_configuracion, 
ncc.rbd, ncc.tipo_ensenanza, 
ncc.cargo, ncc.notifica_notas, 
ncc.nro_notas, ncc.nota_deficiente, 
ncc.notifica_anotaciones,ncc.nro_anotaciones, 
ncc.notifica_asistencia, ncc.dias_asistencia, 
ncc.periodo_notificacion, 
anes.nro_ano
FROM matricula as ma 
INNER JOIN curso cu ON cu.id_curso = ma.id_curso 
INNER JOIN ano_escolar anes ON anes.id_ano = ma.id_ano
INNER JOIN notifica_correo_configuracion ncc ON ncc.rbd = ma.rdb AND ncc.tipo_ensenanza = cu.ensenanza 
WHERE ma.id_curso = $idcurso
AND ma.id_ano = $idano LIMIT 1";
	   
	   $rsql_parametros = @pg_Exec($conn,$qsql_parametros) or die ( "Error 34");
	   $n0 = @pg_numrows($rsql_parametros);
	   $fsql_parametros = pg_fetch_array($rsql_parametros,0);
       
	   $idconfiguracion = $fsql_parametros['id_notifica_correo_configuracion'];
	   $nro_año = $fsql_parametros['nro_ano'];
	   $rbd = $fsql_parametros['rbd'];
	   
       $notifica_asistencia = $fsql_parametros['notifica_asistencia'];
       $dias_asistencia = $fsql_parametros['dias_asistencia'];
	   $periodo_notificacion = $fsql_parametros['periodo_notificacion'];
	   //"1"=Semanal,"2"=Quinsenal,"3"=Mensual

if ($notifica_asistencia == 1){ // solamente si tiene creada esta configuracion 

// OBTENGO EL CURSO COMPLETO
$q_curso = "SELECT 
matr.nro_lista, 
cast(alu.ape_pat || ' ' || alu.ape_mat || ' ' || alu.nombre_alu as varchar) as nombre_completo, 
alu.rut_alumno,
cast(alu.rut_alumno || '-' || alu.dig_rut as varchar) as rut_completo,
cast(cu.grado_curso || '-' || cu.letra_curso as varchar) as curso_completo,
cast(projefe.ape_pat || ' ' || projefe.ape_mat || ' ' || projefe.nombre_emp as varchar) as 
nombre_profesorjefe,CURRENT_DATE as fecha_actual  
FROM alumno alu
INNER JOIN matricula matr ON  matr.rut_alumno = alu.rut_alumno AND matr.id_curso=$idcurso AND matr.bool_ar=0
inner join curso cu on cu.id_curso = matr.id_curso
inner join supervisa supe on supe.id_curso = cu.id_curso 
inner join empleado projefe on projefe.rut_emp = supe.rut_emp
ORDER BY 1,2";

$r_curso = @pg_Exec($conn,$q_curso) or die ( pg_last_error($conn));

if (@pg_numrows($r_curso)!=0){ // if 1

for($x1=0;$x1<=@pg_numrows($r_curso);$x1++){ // for 1 RECORRO EL CURSO Y COMPRUEBA INASISTENCIAS

$f_curso = pg_fetch_array($r_curso,$x1);

 $rut_dv_alumno = $f_curso['rut_completo'];
 $nombre_alumno = $f_curso['nombre_completo'];
 $rut = $f_curso['rut_alumno'];

// INICIO CADENAS CON DISTINTAS QUERYS
$qr0 = "SELECT count(asis.rut_alumno)as numero_dias_inasistencia ";

$qr1 = "SELECT asis.rut_alumno,asis.ano,asis.id_curso,asis.fecha ";

$qr2 = "FROM asistencia AS asis 
WHERE 
asis.id_curso = $idcurso 
AND
asis.ano = $idano
AND
asis.rut_alumno = $rut ";

//Solo los registros que sean iguales al dia de la semana
$q3 = "AND
EXTRACT(WEEK FROM asis.fecha) = EXTRACT(WEEK FROM CURRENT_DATE)";

//Dia cuento los registros inasistencia en la quincena
$q4 = "AND
CASE WHEN EXTRACT(DAY FROM CURRENT_DATE)>15 THEN
EXTRACT(DAY FROM asis.fecha)<15 ELSE
EXTRACT(DAY FROM asis.fecha)>15 END 
AND
EXTRACT(MONTH FROM asis.fecha) = EXTRACT(MONTH FROM CURRENT_DATE)";

//Solo los registros que pertenescan al mes actual
$q5 = " AND
EXTRACT(MONTH FROM asis.fecha) = EXTRACT(MONTH FROM CURRENT_DATE)";

/////////////////////////////////////////////////////

	// armo primera query
	$sql = $qr0.$qr2;
	
	switch($periodo_notificacion){ 
	// segun sea la configuracion se agrega la validacion
	case 1:
		$sql .= $q3;
		$det_periodo="Inasistenacias dentro de la semana";
		break;
	case 2:
		$sql .= $q4;
		$det_periodo="Inasistencias dentro de la quincena";
		break;
	case 3:
		$sql .= $q5;
		$det_periodo="Inasistencias dentro del mes";
		break;
	 }

//echo "<br>".$sql;

$r_inasistencia_alumnos = @pg_Exec($conn,$sql);

if (@pg_numrows($r_inasistencia_alumnos)!=0){  // encuentra registros inasistencia alumnos
	
	$f_inasistencia_alumnos = pg_fetch_array($r_inasistencia_alumnos,0);

    $numero_dias_inasistencia = $f_inasistencia_alumnos['numero_dias_inasistencia'];

	if( $numero_dias_inasistencia >= $dias_asistencia ){ 
	//sino no se muestra alumno
		
	$listado_alumnos .= '<tr align="center" >
						 <td align="left" >'.$rut_dv_alumno.'</td>
						 <td align="left" >'.$nombre_alumno.'</td>
						 <td>'.$numero_dias_inasistencia.'</td>
						 </tr>';			
		
		} // no se muestra alumno
 
 } // fin encuentra registros inasistencia alumnos
 
 
 } // for 1
 
 
} // if 1


$f_datos = pg_fetch_array($r_curso,0);
 
 $nombre_curso = $f_datos['curso_completo'];
 $nombre_profesorjefe = $f_datos['nombre_profesorjefe'];
 $fecha_actual = $f_datos['fecha_actual'];
 

 $mensaje = '<br>
            <table border="0">
			<tr align="left">
			<th><h2>Curso : '.$nombre_curso.'</h2></th>
			</tr>
			<tr align="left">
			<th><h2>Profesor Jefe : </h2></th>
			<th><h2>'.$nombre_profesorjefe.'</h2></th>
			</tr>
			<tr align="left">
			<th><h2>Fecha Actual : </h2></th>
			<th><h2>'.$fecha_actual.'</h2></th>
			</tr>
			<tr align="left">
			<th><h2>Periodo : </h2></th>
			<th><h2>'.trim($det_periodo).'</h2></th>
			</tr>
			</table>
            <table border="1">
			<tr align="left" >
			<th colspan="3" >Listado de Alumnos que cumplen '.$dias_asistencia.' o más dias inasistencia</th>
			</tr>
			<tr align="left" >
			<th>Rut</th>
			<th>Nombre</th>
			<th>Cant Dias</th>
			</tr>';

$mensaje .= $listado_alumnos.'</table>';
			
//echo $mensaje;

$asunto="Notificacion Alumnos Cumple Condición de inasistencias";

envio_correo_notificacion($asunto,$mensaje,$idconfiguracion,$conn,$rbd,$idano,$idcurso,$usuario,$guardo,0);


}


} // FIN FUNCION INASISTENCIA 



function envio_correo_notificacion($asunto,$mensaje,$idconfiguracion,$conn,$rbd,$idano,$idcurso,$usuario,$guardo,$id_ramo) { //INICIO


    $destinatario="";
	
	$sql = "SELECT 
			e.email
			FROM notifica_correo_empleados nce 
			INNER JOIN empleado e ON e.rut_emp = nce.rut_empleado
			WHERE nce.id_notifica_correo_configuracion = $idconfiguracion
			UNION
			SELECT projefe.email FROM matricula matri 
			INNER JOIN curso cu ON cu.id_curso = matri.id_curso
			INNER JOIN supervisa supe ON supe.id_curso = cu.id_curso 
			INNER JOIN empleado projefe ON projefe.rut_emp = supe.rut_emp
			WHERE matri.id_curso = $idcurso and ma.id_ano = $id_ano";			 
			
			
			
			$rs_nce = @pg_exec($conn,$sql) or die ( "Error Correo 1");
			
		if (@pg_numrows($rs_nce)!=0){
				  
			for($i=0;$i<@pg_numrows($rs_nce);$i++){
			    $fila_nce = @pg_fetch_array($rs_nce,$i);
						$destinatario .= trim($fila_nce['email']).",";
				 	   }
		}
	    
		    $destinatario = substr($destinatario,0,-1);		
			
						
			// Para enviar correo HTML, la cabecera Content-type debe definirse
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
			if(mail($destinatario,$asunto,$mensaje,$cabeceras)){
			   
			   //echo 0; // guardo correctamente
			   
			 $log = "INSERT INTO log_notificacion_correoenvi_datosguardados 
					  (id_reg,id_usuario,rbd,id_ano,fecha_actual,env_correo,guardo_dato,id_ramo)
					   VALUES (DEFAULT,$usuario,$rbd,$idano,DEFAULT,1,$guardo,$id_ramo)"; 
			           $rs_log = pg_exec($conn,$log) or die ( "Error Correo 2" ); 
			
			}else{
			   
			    //echo 1; // No guardo correctamente
			   
			    $log = "INSERT INTO log_notificacion_correoenvi_datosguardados 
					  (id_reg,id_usuario,rbd,id_ano,fecha_actual,env_correo,guardo_dato,id_ramo)
					   VALUES (DEFAULT,$usuario,$rbd,$idano,DEFAULT,0,$guardo,$idramo)"; 
					   $rs_log = pg_exec($conn,$log) or die ( "Error Correo 3" );
			
			 }
	
 } // FIN
 
 
//pg_close($conn);

?>



<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	


	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	

//----------------------------- INSTITUCÓN --------------------------------------
$fichero = fopen("Actas/inst".$institucion."", "w+"); 

$sql = "SELECT * FROM institucion WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dig_rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_instit']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['calle']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['nro']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['depto']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['block']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['villa']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['region']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ciudad']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['comuna']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['telefono']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['fax']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['email']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['tipo_instit']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['tipo_educ']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['tipo_regimen']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['idioma']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['sexo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['metodo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['formacion']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['nu_resolucion']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['numero_inst']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['fecha_resolucion']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['letra_inst']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['dependencia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['area_geo']) . " $ls_espacio";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 
//-----------------------AÑO ESCOLAR -------------------------------------
$fichero = fopen("Actas/ano".$institucion."", "w+"); 

$sql = "SELECT * FROM ano_escolar WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_inicio']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_termino']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['situacion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_institucion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ano_anterior']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['tipo_regimen']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//--------------------------PERIODO --------------------------------------------

$fichero = fopen("Actas/periodo".$institucion."", "w+"); 

$sql = "SELECT * FROM periodo WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_periodo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_periodo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_inicio']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_termino']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['mostrar_notas']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dias_habiles']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------FERIADOS-----------------------------------------


$fichero = fopen("Actas/feriado".$institucion."", "w+"); 

$sql = "SELECT * FROM feriado WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_feriado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_inicio']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_fin']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['descripcion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_periodo']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//------------------------------ PLAN DE ESTUDIO ----------------------------------

$fichero = fopen("Actas/plan_estudio".$institucion."", "w+"); 

$sql = "SELECT * FROM plan_estudio WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cursos']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//-------------------------------CURSOS PLAN -------------------------------------
$fichero = fopen("Actas/cursos_plan".$institucion."", "w+"); 

$sql = "SELECT cursos_plan.* FROM cursos_plan INNER JOIN plan_estudio ON cursos_plan.cod_decreto=plan_estudio.cod_decreto WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['pa']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sa']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ta']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cu']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['qu']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sx']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['oc']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//-------------------------------PLAN INSTITUCION ------------------------------------------
$fichero = fopen("Actas/plan_inst".$institucion."", "w+"); 

$sql = "SELECT distinct * FROM plan_inst WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//--------------------------------- PLAN TIPO -----------------------------------------------
$fichero = fopen("Actas/plan_tipo".$institucion."", "w+"); 

$sql = "SELECT plan_tipo.* FROM plan_tipo INNER JOIN plan_estudio ON plan_tipo.cod_decreto=plan_estudio.cod_decreto WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_tipo']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//------------------------------ TIPO ENSEÑANZA INSTITUCION ----------------------------

$fichero = fopen("Actas/tipo_ense_inst".$institucion."", "w+"); 

$sql = "SELECT * FROM tipo_ense_inst WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_tipo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['estado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nu_resolucion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_res']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nu_resolucion_cierre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_res_cierre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nu_grupos_dif']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_ecp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_pj']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cierre']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//------------------------------ HORA JORNADA MAÑANA -----------------------------
$fichero = fopen("Actas/hora_jm".$institucion."", "w+"); 

$sql = "SELECT hora_jm.* FROM hora_jm INNER JOIN tipo_ense_inst ON hora_jm.corre=tipo_ense_inst.corre WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['corre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ini']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ter']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//------------------------------ HORA JORNADA TARDE -----------------------------
$fichero = fopen("Actas/hora_jt".$institucion."", "w+"); 

$sql = "SELECT hora_jt.* FROM hora_jt INNER JOIN tipo_ense_inst ON hora_jt.corre=tipo_ense_inst.corre WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['corre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ini']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ter']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//------------------------------ HORA JORNADA MAÑANA Y TARDE -----------------------------
$fichero = fopen("Actas/hora_mt".$institucion."", "w+"); 

$sql = "SELECT hora_mt.* FROM hora_mt INNER JOIN tipo_ense_inst ON hora_mt.corre=tipo_ense_inst.corre WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['corre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ini']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ter']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//------------------------------ HORA JORNADA VERPERTINA -----------------------------
$fichero = fopen("Actas/hora_vn".$institucion."", "w+"); 

$sql = "SELECT hora_vn.* FROM hora_vn INNER JOIN tipo_ense_inst ON hora_vn.corre=tipo_ense_inst.corre WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['corre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ini']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['hora_ter']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- INCLUYE PROPIO----------------------------------------
$fichero = fopen("Actas/incluye_propio".$institucion."", "w+"); 

$sql = "SELECT incluye_propio.* FROM incluye_propio INNER JOIN plan_estudio ON incluye_propio.cod_decreto=plan_estudio.cod_decreto WHERE rdb=" . $institucion;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_subsector']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//--------------------------- CURSOS --------------------------------------------
$fichero = fopen("Actas/curso".$institucion."", "w+"); 

$sql = "SELECT  * FROM curso where id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['grado_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['letra_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ensenanza']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_decreto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_eval']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_es']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_sector']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_rama']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_jor']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['truncado_per']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//--------------------------- RAMOS --------------------------------------------
$fichero = fopen("Actas/ramo".$institucion."", "w+"); 

$sql = "SELECT ramo.* FROM ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['modo_eval']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['tipo_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_subsector']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['horas']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sub_obli']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sub_elect']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_ip']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_sar']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['conex']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['pct_examen']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota_exim']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['truncado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['orden']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- ALUMNOS ---------------------------------------------
$fichero = fopen("Actas/alumno".$institucion."", "w+"); 

//$sql = "SELECT * FROM alumno";
$sql = "SELECT alumno.* FROM alumno INNER JOIN matricula ON alumno.rut_alumno=matricula.rut_alumno WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dig_rut']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_alu']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_pat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_mat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['calle']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['depto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['block']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['villa']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['region']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ciudad']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['comuna']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['telefono']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sexo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['email']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_nac']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- MATRICULAS ---------------------------------------------
$fichero = fopen("Actas/matricula".$institucion."", "w+"); 

$sql = "SELECT * FROM matricula WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['num_mat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_baj']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_bchs']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_aoi']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_rg']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_ae']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_i']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_gd']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['bool_ar']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_retiro']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro_lista']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- MATRICULAS  TECNICO PROFESIONAL SIN CURSO---------------------------------------------
$fichero = fopen("Actas/matriculatp".$institucion."", "w+"); 

$sql = "SELECT * FROM matriculatpsincurso WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['integrado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['indigena']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['estado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['titulo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_tipo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_sector']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cod_esp']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- TIENE AÑO---------------------------------------------
$fichero = fopen("Actas/tiene".$institucion."", "w+"); 

$sql = "SELECT tiene$nro_ano.* FROM tiene$nro_ano INNER JOIN curso ON tiene$nro_ano.id_curso=curso.id_curso WHERE curso.id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//--------------------------- NOTAS DEL AÑO -------------------------------------------
$fichero = fopen("Actas/notas".$institucion."", "w+"); 

$sql = "SELECT notas$nro_ano.* FROM notas$nro_ano INNER JOIN ramo on notas$nro_ano.id_ramo=ramo.id_ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso WHERE id_ano=" . $ano;
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_periodo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota1']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota2']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota3']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota4']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota5']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota6']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota7']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota8']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota9']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota10']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota11']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota12']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota13']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota14']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota15']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota16']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota17']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota18']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota19']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota20']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['promedio']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//---------------------------- APODERADOS ---------------------------------------------
$fichero = fopen("Actas/apoderado".$institucion."", "w+"); 

//$sql = "SELECT * FROM apoderado";
$sql = "SELECT apoderado.* FROM apoderado INNER JOIN tiene2 ON apoderado.rut_apo=tiene2.rut_apo INNER JOIN matricula ON tiene2.rut_alumno=matricula.rut_alumno WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_apo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dig_rut']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_apo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_pat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_mat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['calle']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['depto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['block']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['villa']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['region']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ciudad']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['comuna']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['telefono']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['relacion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['email']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['celular']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nivel_educ']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['profesion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['lugar_trabajo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cargo']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- TIENE 2	 ---------------------------------------------
$fichero = fopen("Actas/tiene2".$institucion."", "w+"); 

//$sql = "SELECT * FROM tiene2";
$sql = "SELECT tiene2.* FROM tiene2 INNER JOIN matricula ON tiene2.rut_alumno=matricula.rut_alumno WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_apo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['responsable']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sostenedor']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- EMPLEADO ---------------------------------------------
$fichero = fopen("Actas/empleado".$institucion."", "w+"); 

//$sql = "SELECT * FROM empleado";
$sql = "SELECT empleado.* FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rdb=" . $institucion;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dig_rut']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_pat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ape_mat']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['calle']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['depto']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['block']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['villa']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['region']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ciudad']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['comuna']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['telefono']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['sexo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['email']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['estado_civil']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nro_resol']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['anos_exp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['idiomas']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nacionalidad']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['telefono2']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['telefono3']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['atencion']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- TRABAJA ---------------------------------------------
$fichero = fopen("Actas/trabaja".$institucion."", "w+"); 

$sql = "SELECT * FROM trabaja WHERE rdb=" . $institucion;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_ingreso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha_retiro']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['cargo']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- SUPERVISA ---------------------------------------------
$fichero = fopen("Actas/supervisa".$institucion."", "w+"); 

$sql = "SELECT supervisa.* FROM supervisa INNER JOIN CURSO ON supervisa.id_curso=curso.id_curso WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- DICTA ---------------------------------------------
$fichero = fopen("Actas/dicta".$institucion."", "w+"); 

$sql = "SELECT dicta.* FROM dicta INNER JOIN ramo ON dicta.id_ramo=ramo.id_ramo INNER JOIN curso on ramo.id_curso=curso.id_curso WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//---------------------------- AYUDA ---------------------------------------------
$fichero = fopen("Actas/ayuda".$institucion."", "w+"); 

$sql = "SELECT ayuda.* FROM ayuda INNER JOIN ramo ON ayuda.id_ramo=ramo.id_ramo INNER JOIN curso on ramo.id_curso=curso.id_curso WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_ramo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//---------------------------- INFORMACION PROFESOR ---------------------------------------------
$fichero = fopen("Actas/info".$institucion."", "w+"); 

$sql = "SELECT * FROM info_profesor WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_info']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['tipo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['descripcion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- INFORMACION PROFESOR ---------------------------------------------
$fichero = fopen("Actas/estudios".$institucion."", "w+"); 

//$sql = "SELECT * FROM empleado_estudios";
$sql = "SELECT a.* FROM empleado_estudios a INNER JOIN trabaja b ON a.rut_empleado=b.rut_emp where rdb=" . $institucion;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_empleado']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_estudio']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['institucion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['horas']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['tipo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['orden']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//---------------------------- TALLER ---------------------------------------------
$fichero = fopen("Actas/taller".$institucion."", "w+"); 

$sql = "SELECT taller.* FROM taller WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['id_taller']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_taller']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['modo_eval']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['conex']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['pct_examen']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota_exim']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['truncado']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 
//---------------------------- TIENE TALLER ---------------------------------------------
$fichero = fopen("Actas/tiene_taller".$institucion."", "w+"); 

$sql = "SELECT a.* FROM tiene_taller a INNER JOIN taller b ON a.id_taller=b.id_taller WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_taller']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//---------------------------- DICTA TALLER ---------------------------------------------
$fichero = fopen("Actas/dicta_taller".$institucion."", "w+"); 

$sql = "SELECT a.* FROM dicta_taller a INNER JOIN taller b ON a.id_taller=b.id_taller WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_emp']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_taller']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//----------------------------NOTAS TALLER ---------------------------------------------
$fichero = fopen("Actas/notas_taller".$institucion."", "w+"); 

$sql = "SELECT a.* FROM notas_taller a INNER JOIN taller b ON a.id_taller=b.id_taller WHERE id_ano=" . $ano;

$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_taller']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_periodo']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota1']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota2']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota3']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota4']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota5']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota6']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota7']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota8']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota9']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota10']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota11']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota12']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota13']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota14']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota15']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota16']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota17']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota18']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota19']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nota20']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['promedio']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";

	@ fwrite($fichero,"$ls_string"); 
}
fclose($fichero); 

//-------------------------- ASISTENCIA -----------------------------------
	$fichero = fopen("Actas/asistencia".$institucion."", "w+"); 
	$sql = "SELECT a.* FROM asistencia a INNER JOIN curso b ON a.id_curso=b.id_curso WHERE id_ano=". $ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++){
	$fils = @pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$ls_string 		= $ls_string . trim($fils['rut_alumno']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['ano']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_curso']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fecha']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------------ FICHA PSICOLOGICA ----------------------------------
	$fichero = fopen("Actas/ficha_psicologica".$institucion."", "w+"); 
	$sql = "SELECT * FROM ficha_psicologica WHERE id_ano=".$ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++){
	$fils =@ph_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 
$ls_string 		= $ls_string . trim($fils['id_ficha']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fechaconttrol']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['fechasesion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['medicamento']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['tratamiento']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['diagnostico']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['observacion']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['rut_alum']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['id_ano']) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------------ FICHA MEDICA -----------------------------------
	$fichero = fopen("Actas/ficha_medica".$institucion."", "w+"); 
	$sql = "SELECT id_ficha,of_alta,of_en_estudio,of_hipermetropia,of_miopia,of_astigmatismo_miope,of_astigmatismo_hipermetrope,of_astigmatismo_mixto,of_astigmatismo_miopito_comp,of_astigmatismo_hipermetria_c,of_anisometropia,of_estrabismo,of_influencia_convergencia,	of_otros_desc,of_lentes_primera_vez,of_cambiar_lentes,of_mantener_lentes,of_estudio_estrabismo,of_ejercicios_opticos,of_cirugia,of_otros_desc_indic,ot_alta,ot_en_estudio,ot_agenesia_pabellon,ot_cerumen_impactado,ot_mucosis_timpanica,ot_otitis_timpanica,ot_hipoacusia_neurosensorial,	ot_otros_desc,ot_audiometria,ot_impedanciometria,ot_radiografia,ot_medicamento,ot_audifono,ot_cirugia,ot_otros_desc_indic,or_alta,or_en_estudio,or_pie_plano,or_genu_valgo_varo,or_deform_adquir_dedos,or_escoliosis,or_otros_desc,or_cambiar_plantillas,or_mantener_plantillas,or_kinesiterapia,	or_rx_extrem_inferiores,or_rx_columna,or_corse,or_cirugia,or_otros_desc_indic,fecha_atencion,fecha_prox_at,rut_med,rut_med_coleg,accidentes,alergias,medicamentos,rut_alumno,	fono_clinica,grupo_sanguineo,problema_especifico1,problema_especifico2,problema_especifico3,problema_especifico4,problema_especifico5,problema_especifico6,problema_especifico7,problema_especifico8,problema_especifico_otros,tipo_seguro,clinica FROM FICHA_MEDICA ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++){
	$fils=@pg_fetch_array($resultado_query,$j);
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 
$ls_string 		= $ls_string . trim($fils['id_ficha']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['of_alta']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['of_es_estudio']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_hipermetropia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_miopia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_astigmatismo_miope']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_astigmatismo_hipermetrope']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_astigmatismo_mixto']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_astigmatismo_miopito_comp']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_astigmatismo_hipermetria_c']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_anisometropia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_estrabismo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_influencia_convergencia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_otros_desc']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_lentes_primera_vez']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_cambiar_lentes']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_matener_lentes']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_estudio_estrabismo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_ejercicios_opticos']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_cirugia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['of_otros_desc_indic']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_alta']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_en_estudio']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_agenesia_pabellon']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_cerumen_impactado']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_mucosis_timpanica']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_otitis_timpanica']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_hipoacusia_neurosensorial']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_otros_desc']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_audiometria']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_impedanciometria']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_radiografia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_medicamento']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_audifono']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_cirugia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['ot_otros_desc_indic']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_alta']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_en_estudio']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_pie_plano']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_genu_valgo_varo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_deform_adquir_dedos']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_escoliosos']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_otros_desc']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_cambiar_plantillas']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_mantener_plantillas']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_kinesiterapia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_rx_extrem_inferiores']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_rx_columna']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_corse']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_cirugia']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['or_otros_desc_indic']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['fecha_atencion']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['fecha_prox_at']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['rut_med']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['rut_med_coleg']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['accidentes']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['alergias']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['medicamentos']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['rut_alumno']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['fono_clinica']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['grupo_sanguineo']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico1']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico2']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico3']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico4']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico5']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico6']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico7']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico8']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['problema_especifico_otros']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['tipo_seguro']) . " $ls_espacio";	
$ls_string 		= $ls_string . trim($fils['clinica']) . " $ls_espacio";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------------- FICHA DEPORTIVA -----------------------------------------
	$fichero = fopen("Actas/ficha_deportiva".$institucion."", "w+"); 
	$sql = "SELECT id_ficha, pe3, pe4, pe5, pe6, pe7, pe8, pe9,pe10, pe11, pe12, ta3, ta4, ta5, ta6, ta7, ta8, ta9, ta10, ta11, ta12, pg3, pg6, pg9, pg11, rut_alumno, id_ano FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_ficha= trim(pg_result($resultado_query, $j, 0));
$li_subsector = trim(pg_result($resultado_query, $j, 1));
$li_pe3= trim(pg_result($resultado_query, $j, 2));
$li_pe4 = trim(pg_result($resultado_query, $j, 3));
$li_pe5= trim(pg_result($resultado_query, $j, 4));
$li_pe6 = trim(pg_result($resultado_query, $j, 5));
$li_pe7= trim(pg_result($resultado_query, $j, 6));
$li_pe8 = trim(pg_result($resultado_query, $j, 7));
$li_pe9= trim(pg_result($resultado_query, $j, 8));
$li_pe10 = trim(pg_result($resultado_query, $j, 9));
$li_pe11= trim(pg_result($resultado_query, $j, 10));
$li_pe12 = trim(pg_result($resultado_query, $j, 11));
$li_ta3= trim(pg_result($resultado_query, $j, 12));
$li_ta4 = trim(pg_result($resultado_query, $j, 13));
$li_ta5= trim(pg_result($resultado_query, $j, 14));
$li_ta6 = trim(pg_result($resultado_query, $j, 15));
$li_ta7= trim(pg_result($resultado_query, $j, 16));
$li_ta8 = trim(pg_result($resultado_query, $j, 17));
$li_ta9= trim(pg_result($resultado_query, $j, 18));
$li_ta10 = trim(pg_result($resultado_query, $j, 19));
$li_ta11= trim(pg_result($resultado_query, $j, 20));
$li_ta12 = trim(pg_result($resultado_query, $j, 21));
$li_pg3= trim(pg_result($resultado_query, $j, 22));
$li_pg6 = trim(pg_result($resultado_query, $j, 23));
$li_pg9= trim(pg_result($resultado_query, $j, 24));
$li_pg11 = trim(pg_result($resultado_query, $j, 25));

$ls_string 		= $ls_string . trim($li_id_ficha) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_subsector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe3) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe4) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe5) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe6) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe7) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe8) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe9) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe10) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe11) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pe12) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta3) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta4) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta5) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta6) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta7) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta8) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta9) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta10) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta11) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta12) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pg3) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pg6) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pg9) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pg11) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------------ SEDE -----------------------------------
	$fichero = fopen("Actas/sede".$institucion."", "w+"); 
	$sql = "SELECT id_sede, id_institucion, nombre, calle, nro, depto, block, villa, region, ciudad, comuna FROM SEDE WHERE ID_INSTITUCION=".$institucion;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_sede= trim(pg_result($resultado_query, $j, 0));
$li_id_institucion = trim(pg_result($resultado_query, $j, 1));
$li_nombre = trim(pg_result($resultado_query, $j, 2));
$li_calle= trim(pg_result($resultado_query, $j, 3));
$li_nro = trim(pg_result($resultado_query, $j, 4));
$li_depto = trim(pg_result($resultado_query, $j, 5));
$li_block= trim(pg_result($resultado_query, $j, 6));
$li_villa = trim(pg_result($resultado_query, $j, 7));
$li_region = trim(pg_result($resultado_query, $j, 8));
$li_ciudad= trim(pg_result($resultado_query, $j, 9));
$li_comuna = trim(pg_result($resultado_query, $j, 10));

$ls_string 		= $ls_string . trim($li_id_sede) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_institucion) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_calle) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nro) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_depto) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_block) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_villa) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_region) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ciudad) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_comuna) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------- ESTANCIA --------------------------------------
	$fichero = fopen("Actas/estancia".$institucion."", "w+"); 
	$sql = "SELECT id_estancia, id_institucion, id_sede, id_tipoestancia, nombre, capacidad, descripcion FROM ESTANCIA WHERE ID_INSTITUCION=".$institucion;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_estancia= trim(pg_result($resultado_query, $j, 0));
$li_id_institucion = trim(pg_result($resultado_query, $j, 1));
$li_id_sede = trim(pg_result($resultado_query, $j, 2));
$li_id_tipoestancia= trim(pg_result($resultado_query, $j, 3));
$li_nombre = trim(pg_result($resultado_query, $j, 4));
$li_capacidad = trim(pg_result($resultado_query, $j, 5));
$li_descripcion= trim(pg_result($resultado_query, $j, 6));

$ls_string 		= $ls_string . trim($li_id_estancia) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_institucion) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_sede) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_tipoestancia) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_capacidad) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_descripcion) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//---------------------------------HORARIO ----------------------------------------
	$fichero = fopen("Actas/horario".$institucion."", "w+"); 
	$sql = "SELECT id_horario, horario.id_curso, id_ramo, id_estancia, dia, horaini, horafin, id_taller FROM HORARIO INNER JOIN CURSO ON horario.id_curso=curso.id_curso WHERE CURSO.ID_ANO=".$ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_horario= trim(pg_result($resultado_query, $j, 0));
$li_id_curso = trim(pg_result($resultado_query, $j, 1));
$li_id_ramo = trim(pg_result($resultado_query, $j, 2));
$li_id_estancia= trim(pg_result($resultado_query, $j, 3));
$li_dia = trim(pg_result($resultado_query, $j, 4));
$li_hora_ini = trim(pg_result($resultado_query, $j, 5));
$li_hora_fin= trim(pg_result($resultado_query, $j, 6));
$li_id_taller = trim(pg_result($resultado_query, $j, 7));

$ls_string 		= $ls_string . trim($li_id_horario) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_curso) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_ramo) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_estancia) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_dia) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_hora_ini) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_hora_fin) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_taller) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//----------------------------- ANOTACIONES--------------------------------
	$fichero = fopen("Actas/anotacion".$institucion."", "w+"); 
	$sql = "SELECT id_anotacion, tipo, anotacion.fecha, observacion, hora, causal, tratamiento, anotacion.rut_alumno, rut_emp, tipo_conducta FROM (ANOTACION INNER JOIN MATRICULA ON anotacion.rut_alumno=matricula.rut_alumno) WHERE RDB=".$institucion."AND date_part('Y',anotacion.fecha) = ".$nro_ano." ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_anotacion= trim(pg_result($resultado_query, $j, 0));
$li_tipo = trim(pg_result($resultado_query, $j, 1));
$li_fecha = trim(pg_result($resultado_query, $j, 2));
$li_observacion = trim(pg_result($resultado_query, $j, 3));
$li_hora = trim(pg_result($resultado_query, $j, 4));
$li_causal = trim(pg_result($resultado_query, $j, 5));
$li_tratamiento = trim(pg_result($resultado_query, $j, 6));
$li_rut_alumno = trim(pg_result($resultado_query, $j, 7));
$li_rut_emp = trim(pg_result($resultado_query, $j, 8));
$li_tipo_conducta = trim(pg_result($resultado_query, $j, 9));


$ls_string 		= $ls_string . trim($li_id_anotacion) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_tipo) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_fecha) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_observacion) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_hora) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_causal) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_tratamiento) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_rut_alumno) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_rut_emp) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_tipo_conducta) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//-------------------------------- SITUACION FINAL --------------------------------
	$fichero = fopen("Actas/situacion_final".$institucion."", "w+"); 
	$sql = "SELECT rut_alumno, situacion_final.id_ramo, prom_gral, nota_examen, nota_final, prueba_especial FROM (SITUACION_FINAL INNER JOIN RAMO ON situacion_final.id_ramo=ramo.id_ramo) INNER JOIN CURSO ON ramo.id_curso=curso.id_curso WHERE CURSO.ID_ANO=".$ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_sector= trim(pg_result($resultado_query, $j, 0));
$li_nombre_sector = trim(pg_result($resultado_query, $j, 1));

$ls_string 		= $ls_string . trim($li_id_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_sector) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//---------------------------- PROMOCION *---------------------------------
	$fichero = fopen("Actas/promocion".$institucion."", "w+"); 
	$sql = "SELECT rdb, id_ano, id_curso, rut_alumno, promedio, asistencia, situacion_final, fecha_retiro, cod_esp, cod_sector, cod_rama, tipo_reprova, observacion FROM PROMOCION WHERE rdb=".$institucion."AND ID_ANO=".$ano;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_rdb= trim(pg_result($resultado_query, $j, 0));
$li_id_ano= trim(pg_result($resultado_query, $j, 1));
$li_id_curso= trim(pg_result($resultado_query, $j, 2));
$li_rut_alumno= trim(pg_result($resultado_query, $j, 3));
$li_promedio= trim(pg_result($resultado_query, $j, 4));
$li_asistencia= trim(pg_result($resultado_query, $j, 5));
$li_situacion_final= trim(pg_result($resultado_query, $j, 6));
$li_fecha_retiro= trim(pg_result($resultado_query, $j, 7));
$li_cod_esp= trim(pg_result($resultado_query, $j, 8));
$li_cod_sector= trim(pg_result($resultado_query, $j, 9));
$li_cod_rama= trim(pg_result($resultado_query, $j, 10));
$li_tipo_reprova= trim(pg_result($resultado_query, $j, 11));
$li_observacion= trim(pg_result($resultado_query, $j, 12));

$ls_string 		= $ls_string . trim($li_rdb) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_ano) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_curso) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_rut_alumno) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_promedio) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_asistencia) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_situacion_final) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_fecha_retiro) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_esp) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_rama) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_tipo_reprova) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_observacion) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//------------------------------ USUARIO -------------------------------
	$fichero = fopen("Actas/usuario".$institucion."", "w+"); 
	$sql = "SELECT usuario.id_usuario, nombre_usuario, pw FROM USUARIO INNER JOIN ACCEDE ON usuario.id_usuario=accede.id_usuario WHERE ACCEDE.rdb=".$institucion;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_usuario= trim(pg_result($resultado_query, $j, 0));
$li_nombre_usuario= trim(pg_result($resultado_query, $j, 1));
$li_pw= trim(pg_result($resultado_query, $j, 2));

$ls_string 		= $ls_string . trim($li_id_usuario) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_usuario) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pw) . "$ls_espacio";
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

//-------------------------------- ACCEDE ---------------------------------------
	$fichero = fopen("Actas/accede".$institucion."", "w+"); 
	$sql = "SELECT id_usuario, id_perfil, rdb, estado FROM ACCEDE where rdb=".$institucion;
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$li_id_usuario= trim(pg_result($resultado_query, $j, 0));
$li_id_pefil= trim(pg_result($resultado_query, $j, 1));
$li_rdb= trim(pg_result($resultado_query, $j, 2));
$li_estado= trim(pg_result($resultado_query, $j, 3));


$ls_string 		= $ls_string . trim($li_id_usuario) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_pefil) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_rdb) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_estado) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 
//pg_close($conn);

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="27%" height="363" align="left" valign="top"><?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
            </td>
            <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td height="0" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                  <tr>
                    <td><!-- AQUI VA TODA LA PROGRAMACI&Oacute;N  -->
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td  align="center" valign="top"><?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
                                    </td>
                                  </tr>
                                </table>
                                <table width="100%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td height="71" colspan="2"><div align="right">
                                        <INPUT class = "botonXX" TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                    </div></td>
                                  </tr>
                                  <tr  class="fondo">
                                    <td height="25" colspan="2" align="center">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">Nombre Tabla </font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">Nombre Archivo </font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">INSTITUCION</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/inst<? echo $institucion ?>'>&quot;instit<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">A&Ntilde;O ESCOLAR</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ano<? echo $institucion ?>'>&quot;ano<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PERIODOS</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/periodo<? echo $institucion ?>'>&quot;periodo<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PLAN DE ESTUDIO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/plan_estudio<? echo $institucion ?>'>&quot;plan_estudio<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">CURSOS PLAN</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/cursos_plan<? echo $institucion ?>'>&quot;cursos_plan<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PLAN INSTITUCION</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/plan_inst<? echo $institucion ?>'>&quot;plan_inst<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PLAN Y TIPO DE ENSE&Ntilde;ANZA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/plan_tipo<? echo $institucion ?>'>&quot;plan_tipo<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">TIPO DE ENSE&Ntilde;ANZA INSTITUCION</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/tipo_ense_inst<? echo $institucion ?>'>&quot;tipo_ense_inst<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">HORA JORNADA MA&Ntilde;ANA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/hora_jm<? echo $institucion ?>'>&quot;hora_jm<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">HORA JORNADA TARDE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/hora_jt<? echo $institucion ?>'>&quot;hora_jt<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">HORA JORNADA MA&Ntilde;ANA Y TARDE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/hora_mt<? echo $institucion ?>'>&quot;hora_mt<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">HORA JORNADA VESPERTINA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/hora_vn<? echo $institucion ?>'>&quot;hora_vn<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">CURSOS</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/curso<? echo $institucion ?>'>&quot;curso<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">RAMO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ramo<? echo $institucion ?>'>&quot;ramo<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ALUMNO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/alumno<? echo $institucion ?>'>&quot;alumno<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">MATRICULA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/matricula<? echo $institucion ?>'>&quot;matricula<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">MATRICULA TP SIN CURSO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/matriculatp<? echo $institucion ?>'>&quot;matriculatp<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">INSCRIPCION EN EL RAMO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/tiene<? echo $institucion ?>'>&quot;Inscripcion<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">NOTAS</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/notas<? echo $institucion ?>'>&quot;Notas<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">APODERADO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/apoderado<? echo $institucion ?>'>&quot;apoderado<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">RELACION PADRE APODERADO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/tiene2<? echo $institucion ?>'>&quot;relacion<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">EMPLEADO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/empleado<? echo $institucion ?>'>&quot;empleado<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">TRABAJA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/trabaja<? echo $institucion ?>'>&quot;trabaja<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PROFESOR JEFE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/supervisa<? echo $institucion ?>'>&quot;profesor<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">DOCENTE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/dicta<? echo $institucion ?>'>&quot;Docente<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">AYUDANTE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ayuda<? echo $institucion ?>'>&quot;Ayudante<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">INFORMACION DEL PROFESOR</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/info<? echo $institucion ?>'>&quot;Informacion<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ESTUDIOS DEL PROFESOR</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/estudios<? echo $institucion ?>'>&quot;Estudios<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">TALLER</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/taller<? echo $institucion ?>'>&quot;Taller<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ALUMNOS EN TALLER</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/tiene_taller<? echo $institucion ?>'>&quot;Inscritos en taller<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">DICTA TALLER</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/dicta_taller<? echo $institucion ?>'>&quot;DictaTaller<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">NOTAS TALLER</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/notas_taller<? echo $institucion ?>'>&quot;Notas_taller<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ASISTENCIA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/asistencia<? echo $institucion ?>'>&quot;asistencia<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">FICHA PSICOLOGICA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ficha_psicologica<? echo $institucion ?>'>&quot;ficha_psicologica<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">FICHA MEDICA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ficha_medica<? echo $institucion ?>'>&quot;ficha_medica<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">FICHA DEPORTIVA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/ficha_deportiva<? echo $institucion ?>'>&quot;ficha_deportiva<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">SEDE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/sede<? echo $institucion ?>'>&quot;sede<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ESTANCIA</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/estancia<? echo $institucion ?>'>&quot;estancia<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">HORARIO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/horario<? echo $institucion ?>'>&quot;horario<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ANOTACION</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/anotacion<? echo $institucion ?>'>&quot;anotacion<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">SITUACION FINAL</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/situacion_final<? echo $institucion ?>'>&quot;situacion _final<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">PROMOCION</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/promocion<? echo $institucion ?>'>&quot;promocion<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">USUARIO</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/usuario<? echo $institucion ?>'>&quot;usuario<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                  <tr>
                                    <td><font size="2" face="Geneva, Arial, Helvetica">ACCEDE</font></td>
                                    <td><font size="2" face="Geneva, Arial, Helvetica"><a href='Actas/accede<? echo $institucion ?>'>&quot;accede<? echo $institucion ?>.txt&quot;</a></font></td>
                                  <tr>
                                    <td colspan="2"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
                                      guardar el archivo en su PC Solo debe clickear con el boton derecho sobre 
                                      el Link que esta en el nombre del archivo y elegir la opcion guardar archivo 
                                      como(Save Target As)</font></div></td>
                                  </tr>
                                </table>
                                <!-- FIN DE INGRESO DE CODIGO NUEVO -->
                    </td>
                  </tr>
                </table>
                </tr>
            </table></td>
          </tr>
          <tr align="center" valign="middle">
            <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
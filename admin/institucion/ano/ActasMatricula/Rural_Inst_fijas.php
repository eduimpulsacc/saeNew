<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	
	$fichero = fopen("Rural/region.txt", "w+"); 
	

	$sql = "SELECT cod_reg, nom_reg, num_reg FROM REGION";

	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	
	
for ($j=0; $j < $total_filas; $j++)
{
	$ls_string = "";
	$salto = "\r\n"; 	 
	$ls_espacio= "\t";

$li_cod_reg = trim(pg_result($resultado_query, $j, 0));
$li_nom_reg = trim(pg_result($resultado_query, $j, 1));
$li_num_reg = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_reg) 	. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nom_reg)	. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_num_reg) 	. "$salto";	
		
	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/provincia.txt", "w+"); 
	
	$sql = "SELECT cor_pro, cod_reg, nom_pro FROM PROVINCIA";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cor_pro = trim(pg_result($resultado_query, $j, 0));
$li_cod_reg = trim(pg_result($resultado_query, $j, 1));
$li_nom_pro = trim(pg_result($resultado_query, $j, 2));

$ls_string 		= $ls_string . trim($li_cor_pro) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_reg) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nom_pro) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/comuna.txt", "w+"); 
	$sql = "SELECT cor_com, cor_pro, cod_reg, nom_com FROM COMUNA";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cor_com = trim(pg_result($resultado_query, $j, 0));
$li_cor_pro = trim(pg_result($resultado_query, $j, 1));
$li_cod_reg = trim(pg_result($resultado_query, $j, 2));
$li_nom_com = trim(pg_result($resultado_query, $j, 3));

$ls_string 		= $ls_string . trim($li_cor_com) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cor_pro) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_reg) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nom_com) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/tipo_ensenanza.txt", "w+"); 
	$sql = "SELECT cod_tipo, nombre_tipo FROM TIPO_ENSENANZA";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_tipo	= trim(pg_result($resultado_query, $j, 0));
$li_nombre_tipo = trim(pg_result($resultado_query, $j, 1));

$ls_string 		= $ls_string . trim($li_cod_tipo) 	. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_tipo). "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/plan_estudio.txt", "w+"); 
	$sql = "SELECT cod_decreto, cursos, nombre_decreto, rdb FROM PLAN_ESTUDIO WHERE RDB=0";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_decreto= trim(pg_result($resultado_query, $j, 0));
$li_cursos = trim(pg_result($resultado_query, $j, 1));
$li_nombre_decereto = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_decreto) 		. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cursos) 			. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_decereto) 	. "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/cursos_plan.txt", "w+"); 
	$sql = "SELECT cursos_plan.cod_decreto, pa, sa, ta, cu, qu, sx, sp, oc, rdb FROM CURSOS_PLAN inner join PLAN_ESTUDIO ON cursos_plan.cod_decreto=plan_estudio.cod_decreto WHERE plan_estudio.rdb=0 AND plan_estudio.cod_decreto >1000";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_decreto= trim(pg_result($resultado_query, $j, 0));
$li_pa = trim(pg_result($resultado_query, $j, 1));
$li_sa = trim(pg_result($resultado_query, $j, 2));
$li_ta= trim(pg_result($resultado_query, $j, 3));
$li_ca = trim(pg_result($resultado_query, $j, 4));
$li_qu = trim(pg_result($resultado_query, $j, 5));
$li_sx= trim(pg_result($resultado_query, $j, 6));
$li_sp = trim(pg_result($resultado_query, $j, 7));
$li_oc = trim(pg_result($resultado_query, $j, 8));




$ls_string 		= $ls_string . trim($li_cod_decreto) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_pa) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_sa) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ta) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_ca) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_qu) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_sx) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_sp) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_oc) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/subsector.txt", "w+"); 
	$sql = "SELECT cod_subsector, nombre FROM SUBSECTOR ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_subsector= trim(pg_result($resultado_query, $j, 0));
$li_nombre = trim(pg_result($resultado_query, $j, 1));



$ls_string 		= $ls_string . trim($li_cod_subsector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/plan_tipo.txt", "w+"); 
	$sql = "SELECT plan_tipo.cod_decreto, cod_tipo FROM PLAN_TIPO inner join PLAN_ESTUDIO ON plan_tipo.cod_decreto=plan_estudio.cod_decreto WHERE plan_estudio.rdb=0 AND plan_estudio.cod_decreto >1000 ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_decreto	= trim(pg_result($resultado_query, $j, 0));
$li_cod_tipo 	= trim(pg_result($resultado_query, $j, 1));



$ls_string 		= $ls_string . trim($li_cod_decreto) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_tipo) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/evaluacion.txt", "w+"); 
	$sql = "SELECT cod_eval, cursos, nombre_decreto_eval FROM EVALUACION ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_eval= trim(pg_result($resultado_query, $j, 0));
$li_cursos = trim(pg_result($resultado_query, $j, 1));
$li_nombre_decreto_eval = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_eval) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cursos) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_decreto_eval) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/tipo_ense_eval.txt", "w+"); 
	$sql = "SELECT cod_tipo, cod_eval, grado FROM TIPO_ENSE_EVAL ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_tipo= trim(pg_result($resultado_query, $j, 0));
$li_cod_eval = trim(pg_result($resultado_query, $j, 1));
$li_grado = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_tipo) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_eval) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_grado) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/incluye.txt", "w+"); 
	$sql = "SELECT cod_decreto, cod_subsector FROM INCLUYE ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_decreto= trim(pg_result($resultado_query, $j, 0));
$li_subsector = trim(pg_result($resultado_query, $j, 1));


$ls_string 		= $ls_string . trim($li_cod_decreto) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_subsector) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	$fichero = fopen("Rural/perfil.txt", "w+"); 
	$sql = "SELECT id_perfil, nombre_perfil, url FROM PERFIL ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_id_perfil= trim(pg_result($resultado_query, $j, 0));
$li_nombre_perfil = trim(pg_result($resultado_query, $j, 1));
$li_url = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_id_perfil) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_perfil) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_url) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/rama.txt", "w+"); 
	$sql = "SELECT cod_rama, nombre_rama, cod_tipo FROM RAMA ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_rama= trim(pg_result($resultado_query, $j, 0));
$li_nombre_rama = trim(pg_result($resultado_query, $j, 1));
$li_cod_tipo = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_rama) 	 . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_rama) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_tipo)	 . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/sector_eco.txt", "w+"); 
	$sql = "SELECT cod_sector, cod_rama, nombre_sector FROM SECTOR_ECO ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_sector= trim(pg_result($resultado_query, $j, 0));
$li_cod_rama = trim(pg_result($resultado_query, $j, 1));
$li_nombre_sector = trim(pg_result($resultado_query, $j, 2));


$ls_string 		= $ls_string . trim($li_cod_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_rama) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_sector) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/especialidad.txt", "w+"); 
	$sql = "SELECT cod_esp, cod_sector, cod_rama, nombre_esp FROM ESPECIALIDAD ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_esp		= trim(pg_result($resultado_query, $j, 0));
$li_cod_sector 	= trim(pg_result($resultado_query, $j, 1));
$li_cod_rama 	= trim(pg_result($resultado_query, $j, 2));
$li_nombre_esp 	= trim(pg_result($resultado_query, $j, 3));


$ls_string 		= $ls_string . trim($li_cod_esp) 	. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_rama) 	. "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_esp) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/sector.txt", "w+"); 
	$sql = "SELECT id_sector, nombre_sector FROM SECTOR ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_id_sector= trim(pg_result($resultado_query, $j, 0));
$li_nombre_sector = trim(pg_result($resultado_query, $j, 1));

$ls_string 		= $ls_string . trim($li_id_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_nombre_sector) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/sector_sub.txt", "w+"); 
	$sql = "SELECT cod_subsector, id_sector FROM SECTOR_SUB";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_subsector= trim(pg_result($resultado_query, $j, 0));
$li_id_sector= trim(pg_result($resultado_query, $j, 1));

$ls_string 		= $ls_string . trim($li_cod_subsector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_id_sector) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/incluye_tp.txt", "w+"); 
	$sql = "SELECT cod_sector, cod_rama, cod_esp, cod_subsector, complementario FROM INCLUYE_TP";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_cod_sector= trim(pg_result($resultado_query, $j, 0));
$li_cod_rama= trim(pg_result($resultado_query, $j, 1));
$li_cod_esp= trim(pg_result($resultado_query, $j, 2));
$li_cod_subsector= trim(pg_result($resultado_query, $j, 3));
$li_complementario= trim(pg_result($resultado_query, $j, 4));

$ls_string 		= $ls_string . trim($li_cod_sector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_rama) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_esp) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_cod_subsector) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_complementario) . "$salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


	$fichero = fopen("Rural/feriados_nac.txt", "w+"); 
	$sql = "SELECT id_feriado, fecha_inicio, fecha_fin, descripcion FROM FERIADOS_NAC";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= "\t";
 

$li_id_feriado= trim(pg_result($resultado_query, $j, 0));
$li_fecha_inicio= trim(pg_result($resultado_query, $j, 1));
$li_fecha_fin= trim(pg_result($resultado_query, $j, 2));
$li_descripcion= trim(pg_result($resultado_query, $j, 3));


$ls_string 		= $ls_string . trim($li_id_feriado) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_fecha_inicio) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_fecha_fin) . "$ls_espacio";
$ls_string 		= $ls_string . trim($li_descripcion) . "$salto";	


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
                                    <td height="71"><div align="right">
                                        <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                    </div></td>
                                  </tr>
                                  <tr height=30 >
                                    <td height="25" align="center">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Base de Datos Rural </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivos 
                                        Datos Rural</font></strong></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/region.txt'> &quot;region.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/provincia.txt'> &quot;provincia.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/comuna.txt'> &quot;comuna.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/tipo_ensenanza.txt'> &quot;tipo_ensenanza.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/plan_estudio.txt'> &quot;plan_estudio.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/cursos_plan.txt'> &quot;cursos_plan.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/subsector.txt'> &quot;subsector.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/plan_tipo.txt'> &quot;plan_tipo.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/evaluacion.txt'> &quot;evaluacion.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/tipo_ense_eval.txt'> &quot;tipo_ense_eval.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/incluye.txt'> &quot;incluye.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/perfil.txt'> &quot;perfil.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/rama.txt'> &quot;rama.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/sector_eco.txt'> &quot;sector_eco.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/especialidad.txt'> &quot;especialidad.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/sector.txt'> &quot;sector.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/sector_sub.txt'> &quot;sector_sub.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/incluye_tp.txt'> &quot;incluye_tp.txt&quot;</a> <br>
                                        </strong></font></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Rural/feriados_nac.txt'> &quot;feriados_nac.txt&quot;</a> <br>
                                        </strong></font></p>
                                    </div><br><br></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
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
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//------------------------
	// A�o Escolar
	//------------------------
	$sql_consulta = "select * from archivo07 where rdb = $institucion";
	$result_consulta =@pg_Exec($conn,$sql_consulta);
	$total_filas= pg_numrows($result_consulta);
	$fichero = fopen("Actas/a".$institucion."_7.txt", "w+"); 
	
?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="window.print();window.close();"> 
<center>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<tr  bgcolor=#003b85> 
    <td >
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong>Archivo 07. Acta del Curso </strong>
	    </font>
      </div></td>
  </tr>
	</td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N�</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>D&iacute;gito Rbd </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Ano Escolar </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� Estudiantes Matriculados al 30 de abril (Matr�cula inicial)</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� Estudiantes Matriculados al 30 de noviembre (Matr�cula Final)</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� de estudiantes promovidos</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� de estudiantes reprobados por inasistencia</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� de estudiantes reprobados por rendimiento</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� Estudiantes Ingresados entre el 1� de mayo y el  29 de noviembre</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>N� Estudiantes Retirados entre el 1� de mayo y el  29 de noviembre</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Encargado del Acta </strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Fecha del Acta</strong></font></td>
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Director del Establecimiento</strong></font></td>		
    <td valign="top"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Profesor Jefe</strong></font></td>			
  </tr>
<?
for ($j=0; $j < $total_filas; $j++)
{
	$ls_string = "";
	$salto = "\r\n"; 	 
	$ls_espacio= chr(9);
	$fila = @pg_fetch_array($result_consulta,$j);
	
	$rdb			=	trim($fila['rdb']);
	$dig_rdb 		=	trim($fila['dig_rdb']);
	$ensenanza 		=	trim($fila['ensenanza']);
	$grado 			=	trim($fila['grado']);
	$letra 			=	trim($fila['letra']);
	$nro_ano		=	trim($fila['ano']);
	$indicador1 	=	trim($fila['indicador1']);
	$indicador2 	=	trim($fila['indicador2']);
	$indicador3 	=	trim($fila['indicador3']);
	$indicador4 	=	trim($fila['indicador4']);
	$indicador5 	=	trim($fila['indicador5']);
	$indicador6 	=	trim($fila['indicador6']);
	$indicador7 	=	trim($fila['indicador7']);
	$encargado 		=	trim($fila['encargado']);
	$fecha_acta 	=	trim($fila['fecha_acta']);
	$director 		=	trim($fila['director']);
	$profe			=	trim($fila['profe']);
	//----------------------------------------------------------------		
	$ls_string = "7" . "$ls_espacio" . trim($rdb) . "$ls_espacio";
	$ls_string = $ls_string . trim($dig_rdb)  . "$ls_espacio";
	$ls_string = $ls_string . trim($ensenanza)  . "$ls_espacio";
	$ls_string = $ls_string . trim($grado)  . "$ls_espacio";
	$ls_string = $ls_string . trim($letra)  . "$ls_espacio";
	$ls_string = $ls_string . trim($nro_ano)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador1)  . "$ls_espacio";	
	$ls_string = $ls_string . trim($indicador2)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador3)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador4)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador5)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador6)  . "$ls_espacio";
	$ls_string = $ls_string . trim($indicador7)  . "$ls_espacio";
	$ls_string = $ls_string . trim($encargado)  . "$ls_espacio";
	$ls_string = $ls_string . date("d/m/Y") . "$ls_espacio";
	$ls_string = $ls_string . trim($director)  . "$ls_espacio";	
	$ls_string = $ls_string . trim($profe)  . "$salto";
	@ fwrite($fichero,"$ls_string"); 
  ?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador2?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador3?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador4?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador5?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador6?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $indicador7?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $encargado?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo date("d/m/Y")?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $director?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $profe?></font></td>			
  </tr>
  <?
}
//---------------------------------------------------
$sql="delete from archivo07 where rdb = $institucion";
$rsDele =@pg_Exec($conn,$sql);
//---------------------------------------------------
pg_close($conn);
fclose($fichero); 


?>
</table>


</center>
</body>
</html>
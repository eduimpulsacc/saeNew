<?php require('../../../../util/header.inc');?>
<?
	//---------------
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	//----------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];	
	//----------------
	$ls_string 		= ""		;
	$salto 			= "\n"		;
	$ls_espacio		= chr(9)	;
 	//---------------
	$fichero = fopen("Archivos/CURSOS".$nro_ano.".xls", "w"); 
	//---------------
$ls_string = $ls_string . "id_curso"  . "$ls_espacio";
$ls_string = $ls_string . "grado_curso"  . "$ls_espacio";
$ls_string = $ls_string . "letra_curso"  . "$ls_espacio";
$ls_string = $ls_string . "ensenanza"  . "$ls_espacio";
$ls_string = $ls_string . "cod_decreto"  . "$ls_espacio";
$ls_string = $ls_string . "cod_eval"  . "$ls_espacio";
$ls_string = $ls_string . "id_ano"  . "$ls_espacio";
$ls_string = $ls_string . "cod_es"  . "$ls_espacio";
$ls_string = $ls_string . "cod_sector"  . "$ls_espacio";
$ls_string = $ls_string . "cod_rama"  . "$ls_espacio";
$ls_string = $ls_string . "bool_jor"  . "$ls_espacio";
$ls_string = $ls_string . "truncado_per"  . "$salto";

	//---------------
	@ fwrite($fichero,"$ls_string"); 
	//---------------
	$sqlCurso = "select * from curso where id_ano = $ano";
	$rsCurso =@pg_Exec($conn,$sqlCurso);
	//---------------
	for($e=0 ; $e < @pg_numrows($rsCurso) ; $e++)
	{	
		//---------------
		$fCurso = @pg_fetch_array($rsCurso,$e);
		//---------------
		$ls_string = trim($fCurso['id_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['grado_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['letra_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['ensenanza'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['cod_decreto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['cod_eval'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['id_ano'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['cod_es'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['cod_sector'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['cod_rama'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['bool_jor'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fCurso['truncado_per'])  . "$salto";
		//---------------
		@ fwrite($fichero,"$ls_string"); 
		//---------------
	}
	//---------------	
	fclose($fichero); 
	//---------------
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
</head>
<body >
<center>
  <table width="60%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td height="71">
        <div align="right">
          <INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="../Menu_Respaldo.php">
      </div></td>
    </tr>
    <tr>
      <td>
	      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tableindex">
          <tr> 
             
            <td>Respaldo de Informaci&oacute;n desde Colegio Electrónico </td>
           </tr>
          </table>
	      
        </td>
    </tr>
    <tr>
      <td>        <div align="center">
          <p>&nbsp;</p>
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Cursos del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/CURSOS<? echo $nro_ano?>.xls'> &quot;CURSOS<? echo $nro_ano?>.xls&quot;</a> <br>
          </strong></font></p><br>
      </div></td>
    </tr>
    <tr>
      <td>
        <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para guardar el archivo en su PC Solo debe clickear con el boton derecho sobre el Link que esta en el nombre del archivo y elegir la opcion &quot;<strong>guardar destino como</strong>&quot; (Save Target As)</font></div></td>
    </tr>
  </table>
  
</center>
</body>
</html>
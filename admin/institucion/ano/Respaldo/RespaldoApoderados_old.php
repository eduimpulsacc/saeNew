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
	$fichero = fopen("Archivos/APODERADOS".$nro_ano.".xls", "w"); 
	//---------------
	$ls_string = $ls_string . "rut_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "dig_rut"  . "$ls_espacio";
	$ls_string = $ls_string . "nombre_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "ape_pat"  . "$ls_espacio";
	$ls_string = $ls_string . "ape_mat"  . "$ls_espacio";
	$ls_string = $ls_string . "calle"  . "$ls_espacio";
	$ls_string = $ls_string . "nro"  . "$ls_espacio";
	$ls_string = $ls_string . "depto"  . "$ls_espacio";
	$ls_string = $ls_string . "block"  . "$ls_espacio";
	$ls_string = $ls_string . "villa"  . "$ls_espacio";
	$ls_string = $ls_string . "region"  . "$ls_espacio";
	$ls_string = $ls_string . "ciudad"  . "$ls_espacio";
	$ls_string = $ls_string . "comuna"  . "$ls_espacio";
	$ls_string = $ls_string . "telefono"  . "$ls_espacio";
	$ls_string = $ls_string . "relacion"  . "$ls_espacio";
	$ls_string = $ls_string . "email"  . "$ls_espacio";
	$ls_string = $ls_string . "id_usuario"  . "$ls_espacio";
	$ls_string = $ls_string . "foto"  . "$ls_espacio";
	$ls_string = $ls_string . "celular"  . "$ls_espacio";
	$ls_string = $ls_string . "nivel_edu"  . "$ls_espacio";
	$ls_string = $ls_string . "profesion"  . "$ls_espacio";
	$ls_string = $ls_string . "lugar_trabajo"  . "$ls_espacio";
	$ls_string = $ls_string . "cargo"  . "$ls_espacio";
	$ls_string = $ls_string . "rut_apo"  . "$ls_espacio";
	$ls_string = $ls_string . "rut_alumno"  . "$ls_espacio";
	$ls_string = $ls_string . "responsable"  . "$ls_espacio";
	$ls_string = $ls_string . "sostenedor"  . "$salto";

	//---------------
	@ fwrite($fichero,"$ls_string"); 
	//---------------
	$sqlApo = "select apoderado.*, tiene2.* from apoderado, matricula, tiene2 ";
	$sqlApo = $sqlApo . "where matricula.id_ano = $ano ";
	$sqlApo = $sqlApo . "and   tiene2.rut_alumno = matricula.rut_alumno ";
	$sqlApo = $sqlApo . "and   apoderado.rut_apo = tiene2.rut_apo ";
	$sqlApo = $sqlApo . "order by apoderado.ape_pat, apoderado.ape_mat ";
	$rsApo =@pg_Exec($conn,$sqlApo);
	//---------------
	for($e=0 ; $e < @pg_numrows($rsApo) ; $e++)
	{	
		//---------------
		$fApo = @pg_fetch_array($rsApo,$e);
		//---------------
		$ls_string = trim($fApo['rut_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['dig_rut'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nombre_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['ape_pat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['ape_mat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['calle'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nro'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['depto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['block'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['villa'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['region'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['ciudad'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['comuna'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['telefono'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['relacion'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['email'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['id_usuario'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['foto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['celular'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['nivel_edu'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['profesion'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['lugar_trabajo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['cargo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['rut_apo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['rut_alumno'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['responsable'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fApo['sostenedor'])  . "$salto";

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
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Apoderados del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/APODERADOS<? echo $nro_ano?>.xls'> &quot;APODERADOS<? echo $nro_ano?>.xls&quot;</a> <br>
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
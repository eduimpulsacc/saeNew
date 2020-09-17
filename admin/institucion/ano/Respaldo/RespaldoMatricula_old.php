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
	$fichero = fopen("Archivos/MATRICULA".$nro_ano.".xls", "w"); 
	//---------------
	$ls_string = $ls_string . "rut alumno"  . "$ls_espacio";
	$ls_string = $ls_string . "dig rut"  . "$ls_espacio";
	$ls_string = $ls_string . "nombre alumno"  . "$ls_espacio";
	$ls_string = $ls_string . "apellido paterno"  . "$ls_espacio";
	$ls_string = $ls_string . "apellido materno"  . "$ls_espacio";
	$ls_string = $ls_string . "calle"  . "$ls_espacio";
	$ls_string = $ls_string . "nro"  . "$ls_espacio";
	$ls_string = $ls_string . "depto"  . "$ls_espacio";
	$ls_string = $ls_string . "block"  . "$ls_espacio";
	$ls_string = $ls_string . "villa"  . "$ls_espacio";
	$ls_string = $ls_string . "region"  . "$ls_espacio";
	$ls_string = $ls_string . "ciudad"  . "$ls_espacio";
	$ls_string = $ls_string . "comuna"  . "$ls_espacio";
	$ls_string = $ls_string . "telefono"  . "$ls_espacio";
	$ls_string = $ls_string . "sexo"  . "$ls_espacio";
	$ls_string = $ls_string . "email"  . "$ls_espacio";
	$ls_string = $ls_string . "situacion"  . "$ls_espacio";
	$ls_string = $ls_string . "id_usuario"  . "$ls_espacio";
	$ls_string = $ls_string . "fecha nacimiento"  . "$ls_espacio";
	$ls_string = $ls_string . "nacionalidad"  . "$ls_espacio";
	$ls_string = $ls_string . "fecha retiro"  . "$ls_espacio";
	$ls_string = $ls_string . "id ano"  . "$ls_espacio";
	$ls_string = $ls_string . "id curso"  . "$ls_espacio";
	$ls_string = $ls_string . "fecha"  . "$ls_espacio";
	$ls_string = $ls_string . "numero matricula"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_baj"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_bchs"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_aoi"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_rg"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_ae"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_i"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_gd"  . "$ls_espacio";
	$ls_string = $ls_string . "bool_ar"  . "$salto";
	//---------------
	@ fwrite($fichero,"$ls_string"); 
	//---------------
	$sqlMatri = "select alumno.*, matricula.* from alumno, matricula where matricula.id_ano = $ano and alumno.rut_alumno = matricula.rut_alumno order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
	$rsMatri =@pg_Exec($conn,$sqlMatri);
	//---------------
	for($e=0 ; $e < @pg_numrows($rsMatri) ; $e++)
	{	
		//---------------
		$fMatri = @pg_fetch_array($rsMatri,$e);
		//---------------
		$ls_string = trim($fMatri['rut_alumno'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['dig_rut'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nombre_alu'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['ape_pat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['ape_mat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['calle'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nro'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['depto'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['block'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['villa'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['region'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['ciudad'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['comuna'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['telefono'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['sexo'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['email'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['situacion'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['id_usuario'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['fecha_nac'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['nacionalidad'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['fecha_retiro'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['id_ano'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['id_curso'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['fecha'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['num_mat'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_baj'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_bchs'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_aoi'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_rg'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_ae'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_i'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_gd'])  . "$ls_espacio";
		$ls_string = $ls_string . trim($fMatri['bool_ar'])  . "$salto";
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
          <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo Matr&iacute;cula del Colegio </font></strong></p>
          <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El archivo ha sido creado con el nombre de <a href='Archivos/MATRICULA<? echo $nro_ano?>.xls'> &quot;MATRICULA<? echo $nro_ano?>.xls&quot;</a> <br>
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
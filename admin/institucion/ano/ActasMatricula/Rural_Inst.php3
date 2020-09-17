<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
$fichero = fopen("Actas/inst".$institucion."", "w+"); 

$sql = "SELECT * FROM institucion";
$resultado_query= pg_exec($conn,$sql);
$total_filas= pg_numrows($resultado_query);

for ($j=0; $j < $total_filas; $j++)
{
 $fils = @pg_fetch_array($resultado_query,$i)
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 

$ls_string 		= $ls_string . trim($fils['rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['dig_rdb']) . "$ls_espacio";
$ls_string 		= $ls_string . trim($fils['nombre_instit']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['calle']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['nro']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['depto']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['block']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['villa']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['region']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['ciudad']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['comuna']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['telefono']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['fax']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['email']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['tipo_instit']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['tipo_educ']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['tipo_regimen']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['idioma']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['sexo']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['metodo']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['formacion']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['nu_resolucion']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['numero_inst']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['fecha_resolucion']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['letra_inst']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['dependencia']) . " $salto";	
$ls_string 		= $ls_string . trim($fils['area_geo']) . " $salto";	
$ls_string 		= $ls_string . " $salto";	


	@ fwrite($fichero,"$ls_string"); 
 
}

pg_close($conn);
fclose($fichero); 

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="60%" height="172" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="71">
	  <div align="right">
		<INPUT class = "botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
      </div></td>
  </tr>
  
  <tr height=30 bgcolor=#003b85> 
    <td height="25">
		<div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif" >
	    <strong> Generación Electrónica de la Información de Matrícula Inicial </strong>
	    </font>
      </div></td>
  </tr>
  <tr> 
    <td>	  <div align="center">
      <p>&nbsp;</p>
        <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 
          21. Datos Rural</font></strong></p>
        <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
          archivo ha sido creado con el nombre de <a href='Actas/inst<? echo $institucion ?>'> 
          &quot;instit<? echo $institucion ?>.txt&quot;</a> <br>
          <br>
        </strong></font></p>
    </div>
	</td>
  </tr>
  <tr>
    <td>	  <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
        guardar el archivo en su PC Solo debe clickear con el boton derecho sobre 
        el Link que esta en el nombre del archivo y elegir la opcion guardar archivo 
        como(Save Target As)</font></div>
	</td>
  </tr>
</table>

</body>
</html>
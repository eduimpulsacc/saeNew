<?php require('../../../../util/header.inc');
?>
<?
   //// FUNCION QUE VALIDA EL RUT   ///////
	function validar_dav ($alumno,$dig_rut){	      
		 $alumno = $alumno;
		 $dig_rut = $dig_rut;		  
		 $largo_rut = strlen($alumno);
		 $multiplicador = 2;
		 $resultado = 0;
		 $largo=$largo_rut-1;			 
		 for ($i=0; $i < $largo_rut; $i++){
			 $num = substr($alumno,$largo,1);
			 
			 if ($multiplicador > 7){
				 $multiplicador = 2;
			 }
			 $resultado = $resultado + ($multiplicador * $num);			 
			 $multiplicador++; 
			 $largo--;		 
		 }				 
		 $resto = 11-($resultado%11);		 
		 
		 if ($resto==10){
			 $dig = "K";
		 }else{
		     if ($resto==11){
			     $dig = 0;
			 }else{	 
		         $dig = $resto;
			 }	 
		 }	 
		 
		 if ($dig_rut=="k"){
		     $dig_rut="K";   
		 } 
		 
		 if ($dig==$dig_rut){
			  $ok=1;  
		 }else{
			  $ok=0;
		 }	
		 return $ok;
		       	 
	}
    //// fin funcion que valida el rut /////



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;

	$sql = "select nro_ano from ano_escolar where id_ano = ".$ano;
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$ano_escolar = trim(pg_result($resultado_query, 0, 0));
	$fecha1 		= $ano_escolar."-04-30"; 		
	
	$sql = "SELECT DISTINCT institucion.dig_rdb, institucion.rdb, institucion.dig_rdb, alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.fecha_nac, alumno.region, alumno.ciudad, alumno.comuna, alumno.nacionalidad, matricula.bool_baj, matricula.bool_bchs, matricula.fecha_retiro, matricula.fecha, matricula.bool_ar ";
	$sql = $sql . "FROM ((institucion INNER JOIN matricula ON institucion.rdb = matricula.rdb) INNER JOIN curso ON matricula.id_curso = curso.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.")); ";
	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	//echo "tf: $total_filas <br>";
	
//	@pg_close($conn);

	$fichero = @fopen("Actas/m".$institucion."_23.txt", "w+"); 

	$count=0;
	
For ($j=0; $j < $total_filas; $j++)
{
	 $ls_string = "";
	 $salto = "\r\n"; 	 
	 $ls_espacio= chr(9);
	 
	$li_dato4 = NULL;
	$li_dato5 = NULL;
	$ok       = NULL;	
	
	$li_dato1 = "23";
	$li_dato2 = trim(pg_result($resultado_query, $j, 1)); // Rdb
	$li_dato3 = trim(pg_result($resultado_query, $j, 2)); // Dig
	$li_dato4 = trim(pg_result($resultado_query, $j, 3)); // Rut Estudiante
	$li_dato5 = trim(pg_result($resultado_query, $j, 4)); // Dig Estudiante
	$li_dato6 = trim(pg_result($resultado_query, $j, 5)); // Apellido Paterno
	$li_dato7 = trim(pg_result($resultado_query, $j, 6)); // Apellido Materno
	$li_dato8 = trim(pg_result($resultado_query, $j, 7)); // Nombres
	$li_dato9 = trim(pg_result($resultado_query, $j, 8)); // Código Sexo

	if ($li_dato9 == 1) //Sexo
		$li_dato9 = 2;
	elseif ($li_dato9 == 2) //Sexo
		$li_dato9 = 1;
	
	$li_dato10 = trim(Cfecha2(pg_result($resultado_query, $j, 9))); // Fecha de Nacimiento
	$li_dato11 = trim(pg_result($resultado_query, $j, 10)); // Region
	$li_dato12 = trim(pg_result($resultado_query, $j, 11)); // Cuidad
	$li_dato13 = trim(pg_result($resultado_query, $j, 12)); // Comuna
	$region = $li_dato11;
	$comuna = $li_dato13;
	

	if  ($li_dato11 <= 9) //Comuna
		$region = "0".$li_dato11;
		
	if ($li_dato13 <= 9)
		$comuna = "0".$li_dato13;
	
	$li_dato13 = $region.$li_dato12.$comuna;
	$li_dato14 = trim(pg_result($resultado_query, $j, 13)); // Nacionalidad
	$li_dato15 = trim(pg_result($resultado_query, $j, 14)); // Junaeb
	if ($li_dato15 == 0) //Sexo
		$li_dato15 = 2;

	$li_dato16 = trim(pg_result($resultado_query, $j, 15)); // Chile Solidario
	if ($li_dato16 == 0) //Sexo
		$li_dato16 = 2;
	$fecha_retiro = trim(pg_result($resultado_query, $j, 16));
	$fecha_matricula = trim(pg_result($resultado_query, $j, 17));
	$retiro = trim(pg_result($resultado_query, $j, 18));
	
	$ok = validar_dav($li_dato4,$li_dato5);		
	if ($li_dato5==NULL){
	   $ok = 0;
	}	
	if ($li_dato5== " "){
		$ok = 0;
	}   
	if ($ok==1){
	
		$ls_string = trim($li_dato1) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato2) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato3) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato4) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato5) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato6) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato7) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato8) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato9) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato10) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato13) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato14) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato15) . "$ls_espacio";
		$ls_string = $ls_string . trim($li_dato16) . "$salto";
	
		$ls_string = strtoupper($ls_string);
	
		//crea un fichero
		//echo $ls_string; (($fecha_matricula <= $fecha1) and  ($retiro == 1) and if ($fecha_retiro >= $fecha1)) or (if ($fecha_matricula <= $fecha1) and if ($retiro == 0))
		if ($fecha_matricula <= $fecha1)
		{
			if ($retiro == 1)
			{
				if ($fecha_retiro >= $fecha1)
					@ fwrite($fichero,"$ls_string"); 
			}
			if ($retiro == 0)
				@ fwrite($fichero,"$ls_string"); 
				
			$count++;	
		}else{
		    if ($_PERFIL==0){
		       echo "Revisar rut: $li_dato4 - $li_dato5 <br>";
		    }
		}
	}else{
	     if ($_PERFIL==0 or $_PERFIL==14){
	        echo "Rut inválido: $li_dato4 - $li_dato5 <br>";
	     }
	}	 	
		
}


@fclose($fichero); 

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

<body >
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
                                        <INPUT class="botonXX"TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                    </div></td>
                                  </tr>
                                  <tr height=30 bgcolor=>
                                    <td  class="fondo">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 23. N&oacute;mina de estudiantes en matr&iacute;cula inicial </font></strong></p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_23.txt'> &quot;m<? echo $institucion ?>_23.txt&quot;</a> , en total se encontraron
                                        <?=$count ?>
                                        registros.<br>
                                        <br>
                                        </strong></font></p>
                                    </div></td>
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
</body>
</html>
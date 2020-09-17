<?php require('../../../../util/header.inc');?>
<?php 
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





	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	$sql = "select nro_ano from ano_escolar where id_ano = ".$ano;
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	$ano_escolar = trim(pg_result($resultado_query, 0, 0));
	$fecha1 		= $ano_escolar."-04-30"; 		
	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, matricula.rut_alumno, alumno.dig_rut, matricula.bool_rg, matricula.bool_i, matricula.bool_gd, curso.cod_sector, curso.cod_es, matricula.fecha_retiro, matricula.fecha, matricula.bool_ar ";
	$sql = $sql . "FROM institucion, (ano_escolar INNER JOIN (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) ON ano_escolar.id_ano = matricula.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	if ($_INSTIT==24723){
	     $sql_aux = " and curso.ensenanza > 100 ";
	}	
	
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.")) $sql_aux ";
	$sql = $sql . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso, matricula.rut_alumno; ";

	$resultado_query1	= pg_exec($conn,$sql);
	$total_filas1		= pg_numrows($resultado_query1);
	
	//pg_close($conn);

	$fichero = @fopen("Actas/m".$institucion."_25.txt", "w+"); 
	
	For ($K=0; $K < $total_filas1; $K++)
	{
		$ls_string 	= "";
		$salto 		= "\r\n"; 	 
		$ls_espacio	= chr(9);
		
		
		$alumno = NULL;
		$dig_rut = NULL;
		$ok = NULL;
		
		//--------------------------------------------------------------------------
		// Respuesta directa de la consulta
		//--------------------------------------------------------------------------
		$Rdb 				= trim(pg_result($resultado_query1, $K, 0));
		$DigRbd 			= trim(pg_result($resultado_query1, $K, 1));
		$TipoEnseñanza 		= trim(pg_result($resultado_query1, $K, 2));
		$Grado 				= trim(pg_result($resultado_query1, $K, 3));
		$Letra 				= trim(pg_result($resultado_query1, $K, 4));
		$AnoEscolar 		= trim(pg_result($resultado_query1, $K, 5));
		$RutAlumno  		= trim(pg_result($resultado_query1, $K, 6));
		$alumno  = $RutAlumno;
		$DigAlumno 			= trim(pg_result($resultado_query1, $K, 7));
		$dig_rut = $DigAlumno;
		$Repitente 			= trim(pg_result($resultado_query1, $K, 8));
		if ($Repitente==0) $Repitente = 2;
		$Integrado 			= trim(pg_result($resultado_query1, $K, 9));
		if ($Integrado==0) $Integrado = 2;
		$Diferencial 		= trim(pg_result($resultado_query1, $K, 10));
		if ($Diferencial==0) $Diferencial = 2;
		$SectorEconomico 	= trim(pg_result($resultado_query1, $K, 11));
		if (($SectorEconomico=="") or (($TipoEnseñanza >400) and ($Grado < 3))) $SectorEconomico = 0;
		$Especialidad 		= trim(pg_result($resultado_query1, $K, 12));
		if (($Especialidad=="") or (($Especialidad >400) and ($Grado < 3))) $Especialidad = 0;
		$AlumnoPrebasA 		= 0;
		$AlumnoPrebasB 		= 0;
		$AlumnoBasA 		= 0;
		$AlumnoBasB 		= 0;
		$fecha_retiro = trim(pg_result($resultado_query1, $K, 13));
		$fecha_matricula = trim(pg_result($resultado_query1, $K, 14));
		$retiro = trim(pg_result($resultado_query1, $K, 15));


        $ok = validar_dav($alumno,$dig_rut);		
		if ($dig_rut==NULL){
	       $ok = 0;
	    }	
		if ($dig_rut== " "){
		    $ok = 0;
		} 
		if ($_INSTIT==9071){
		    $ok=1;
		}
		//// verificar si la institucion pertenece a la corporacion de viña
		$sql_vina = "select * from corp_instit where num_corp = 1 and rdb = '".$_INSTIT."'";
		$res_vina = @pg_exec($conn,$sql_vina);
		$num_vina = @pg_numrows($res_vina);
		if ($num_vina==1){
		   $ok=1;
		}
		/// fin viña	
		
		if ($ok==1){		

		//--------------------------------------------------------------------------
		// Consulta para obtener tipo de jornada
		//--------------------------------------------------------------------------		
			/*if ($DigAlumno == ""){
		     $DigAlumno = "$ls_espacio";
			 }*/

		$ls_string 		= "25" . "$ls_espacio";
		$ls_string 		= $ls_string . $Rdb				. "$ls_espacio";
		$ls_string 		= $ls_string . $DigRbd			. "$ls_espacio";
		$ls_string 		= $ls_string . $TipoEnseñanza	. "$ls_espacio";
		$ls_string 		= $ls_string . $Grado			. "$ls_espacio";
		$ls_string 		= $ls_string . $Letra			. "$ls_espacio";
		$ls_string 		= $ls_string . $AnoEscolar		. "$ls_espacio";
		$ls_string 		= $ls_string . $RutAlumno 		. "$ls_espacio";
		$ls_string 		= $ls_string . $DigAlumno		. "$ls_espacio";
		$ls_string 		= $ls_string . $Repitente		. "$ls_espacio";
		$ls_string 		= $ls_string . $Integrado		. "$ls_espacio";
		$ls_string 		= $ls_string . $Diferencial		. "$ls_espacio";
		$ls_string 		= $ls_string . $SectorEconomico	. "$ls_espacio";
		$ls_string 		= $ls_string . $Especialidad	. "$ls_espacio";
		$ls_string 		= $ls_string . $AlumnoPrebasA	. "$ls_espacio";
		$ls_string 		= $ls_string . $AlumnoPrebasB	. "$ls_espacio";
		$ls_string 		= $ls_string . $AlumnoBasA		. "$ls_espacio";
		$ls_string 		= $ls_string . $AlumnoBasB		. " $salto";
		
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
		       echo "Revisar rut: $RutAlumno - $DigAlumno <br>";
		    }
		}
	}else{
	     if ($_PERFIL==0 or $_PERFIL==14){
	        echo "Rut inválido: $RutAlumno - $DigAlumno <br>";
	     }
	}
}
	
//pg_close($conn);
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
                                        <input class="botonXX"  name="button" type="button" onClick=document.location="Menu_Actas.php"  value="VOLVER">
                                    </div></td>
                                  </tr>
                                  <tr align="center" >
                                    <td  class="fondo">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                        <p>&nbsp;</p>
                                      <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 25. Estudiantes de los cursos</font></strong> </p>
                                      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
                                        archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_25.txt'> &quot;m<? echo $institucion ?>_25.txt&quot;</a> , en total se encontraron
                                        <?=($count)?>
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
<? pg_close($conn); ?>
</body>
</html>
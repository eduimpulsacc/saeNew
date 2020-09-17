<?php require('../../../../util/header.inc');?>
<?php 

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
	 
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, tipo_ense_inst.cod_tipo, tipo_ense_inst.bool_ecp, tipo_ense_inst.bool_pj, tipo_ense_inst.nu_resolucion, tipo_ense_inst.fecha_res, tipo_ense_inst.nu_resolucion_cierre, tipo_ense_inst.fecha_res_cierre, tipo_ense_inst.nu_grupos_dif, tipo_ense_inst.corre, tipo_ense_inst.cod_decreto, tipo_ense_inst.estado ";
	$sql = $sql . "FROM institucion INNER JOIN tipo_ense_inst ON institucion.rdb = tipo_ense_inst.rdb ";
	if ($_INSTIT==24723){
	     $sql = $sql . " and tipo_ense_inst.cod_tipo > 100 ";
	}	
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((tipo_ense_inst.cod_tipo)>0)) ";
	$sql = $sql . "ORDER BY tipo_ense_inst.cod_tipo; ";

	
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	//pg_close($conn);

	$fichero = @fopen("Actas/m".$institucion."_22.txt", "w+"); 
	
	$valor="";
	$cont=0;

	For ($j=0; $j < $total_filas; $j++)
	{
		$fila = @pg_fetch_array($resultado_query,$j);
	    $Tipo 		= $fila['cod_tipo'];
		if(($valor=="") or (($valor!="") and ($valor!=$Tipo))){
		   $valor = $Tipo;
		   $cont = $cont +1;	

		 $ls_string = "";
		 $salto = "\r\n"; 	 
		 $ls_espacio= chr(9);
		 
		$rdb 				= trim(pg_result($resultado_query, $j, 0));
		$Dv 				= trim(pg_result($resultado_query, $j, 1));
		$TipoEnseñanza 		= trim(pg_result($resultado_query, $j, 2));
		
		$CentroPadres1 		= trim(pg_result($resultado_query, $j, 3));
		if ($CentroPadres1 == 1) 
			$CentroPadres =  "SI";
		else
			$CentroPadres =  "NO";
			
		$PersoJur1 			= trim(pg_result($resultado_query, $j, 4));
		if ($PersoJur1 == 1) 
			$PersoJur =  "SI";
		else
			$PersoJur =  "NO";
			
		$NumRes 			= trim(pg_result($resultado_query, $j, 5));
		$FechaRes 			= trim(pg_result($resultado_query, $j, 6));
		$NumResCierre 		= trim(pg_result($resultado_query, $j, 7));
		$FechaResCierre 	= trim(pg_result($resultado_query, $j, 8));
		
		if ($TipoEnseñanza == 110)
			$GruposDiferencia = trim(pg_result($resultado_query, $j, 9));
		else
			$GruposDiferencia = "";
			
		$Correlativo		=  trim(pg_result($resultado_query, $j, 10));
		$CodDecreto			=  trim(pg_result($resultado_query, $j, 11));
		$Estado				=  trim(pg_result($resultado_query, $j, 12));
		//-------------------------------------------------------------------------------------------------------
		if ($Estado == 0) 
			$Estado  = 1;
		elseif ($Estado == 1) 
			$Estado  = 4;
		elseif (
			$Estado == 2) $Estado  = 3;
		//-------------------------------------------------------------------------------------------------------
		
		$sql1 = "select * from hora_jm where corre = " . $Correlativo ;
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		$HoraIniM = "";
		$HoraFinM = "";
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$HoraIniM =  trim(pg_result($resultado_query1, $j1, 1));
			$HoraFinM = trim(pg_result($resultado_query1, $j1, 2));
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		
		$sql2 = "select * from hora_jt where corre = " . $Correlativo;
		
		$resultado_query2= pg_exec($conn,$sql2);
		$total_filas2= pg_numrows($resultado_query2);
		$HoraIniT ="";
		$HoraFinT ="";
		For ($j2=0; $j2 < $total_filas2; $j2++)
		{
			$HoraIniT =  trim(pg_result($resultado_query2, $j2, 1));
			$HoraFinT = trim(pg_result($resultado_query2, $j2, 2));
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
			
		$sql3 = "select * from hora_mt where corre = " . $Correlativo;
		
		$resultado_query3= pg_exec($conn,$sql3);
		$total_filas3= pg_numrows($resultado_query3);
		$HoraIniMT ="";
		$HoraFinMT ="";
		For ($j3=0; $j3 < $total_filas3; $j3++)
		{
			$HoraIniMT =  trim(pg_result($resultado_query3, $j3, 1));
			$HoraFinMT = trim(pg_result($resultado_query3, $j3, 2));
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
			
		$sql4 = "select * from hora_vn where corre = " . $Correlativo;
		
		$resultado_query4= pg_exec($conn,$sql4);
		$total_filas4= pg_numrows($resultado_query4);
		$HoraIniVN ="";
		$HoraFinVN ="";
		For ($j4=0; $j4 < $total_filas4; $j4++)
		{
			$HoraIniVN =  trim(pg_result($resultado_query4, $j4, 1));
			$HoraFinVN = trim(pg_result($resultado_query4, $j4, 2));
		}
		
		//----------------------------------- VALIDACION DE INGRESO DE HORAS A LOS TIPO DE ENSEÑANZA -------------------
		if(($HoraIniM=="")and ($HoraFinM=="")){ 
			if(($HoraIniT=="") and ($HoraIniT=="")){ 
				if(($HoraIniMT=="") and($HoraIniMT=="")) {
					if(($HoraIniVN=="") and ($HoraIniVN=="")){
			$error= "FALTA INGRESAR HORARIO EN EL TIPO DE ENSEÑANZA : " . $TipoEnseñanza ."";
			
					}
				}
			}
		}
		//-----------------------------------------------------------------------------------------------------------------
		
		//-------------------------------------------------------------------------------------------------------
		// Alumnos hombres orígen indígena en Grupos Diferenciales 
		//-------------------------------------------------------------------------------------------------------
		$sql1 = "SELECT Count(*) AS Cantidad ";
		$sql1 = $sql1 . "FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE ((matricula.bool_aoi)=1) AND ((matricula.bool_gd)=1) AND ((alumno.sexo)=2) AND ((curso.cod_decreto)=".$CodDecreto.") and ";
		$sql1 = $sql1 . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) and matricula.id_curso=". $ano ." ;";

		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica1 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// Alumnas mujeres orígen indígena en Grupos Diferenciales
		//-------------------------------------------------------------------------------------------------------
		$sql1 = "SELECT Count(*) AS Cantidad ";
		$sql1 = $sql1 . "FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matricula.bool_aoi)=1) AND ((matricula.bool_gd)=1) AND ((alumno.sexo)=1) AND ((curso.cod_decreto)=".$CodDecreto.")) and ";
		$sql1 = $sql1 . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) and matricula.id_curso=". $ano ." ;";
		
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica2 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// Als. hombres orígen indígena integrados 
		//-------------------------------------------------------------------------------------------------------
		$sql1 = "SELECT Count(*) AS Cantidad ";
		$sql1 = $sql1 . "FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matricula.bool_aoi)=1) AND ((matricula.bool_i)=1) AND ((alumno.sexo)=2) AND ((curso.cod_decreto)=".$CodDecreto.")) and ";
		$sql1 = $sql1 . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) and matricula.id_curso=". $ano ." ;";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica3 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// Als. mujeres orígen indígena integrados 
		//-------------------------------------------------------------------------------------------------------	
		$sql1 = "SELECT Count(*) AS Cantidad ";
		$sql1 = $sql1 . "FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matricula.bool_aoi)=1) AND ((matricula.bool_i)=1) AND ((alumno.sexo)=1) AND ((curso.cod_decreto)=".$CodDecreto.")) and ";
		$sql1 = $sql1 . "(((matricula.fecha <= '".$fecha1."') and  (matricula.bool_ar = 1) and (matricula.fecha_retiro >= '".$fecha1."')) or ((matricula.fecha <= '".$fecha1."') and (matricula.bool_ar = 0))) and matricula.id_curso=". $ano ." ;";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica4 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. hombres orígen indígena en Práctica (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=1) AND ((alumno.sexo)=2));";

		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica5 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. Mujeres orígen indígena en Práctica (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=1) AND ((alumno.sexo)=1));";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica6 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. hombres orígen indígena Egresados (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
		
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=2) AND ((alumno.sexo)=2));";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica7 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
		
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. mujeres orígen indígena Egresadas (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
		
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=2) AND ((alumno.sexo)=1));";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica8 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
	
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. hombres orígen indígena Titulados (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
			
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=3) AND ((alumno.sexo)=2));";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica9 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
		
		
	
		//-------------------------------------------------------------------------------------------------------
		// ?	Als. mujeres orígen indígena Tituladas (sólo E Media TP)
		//-------------------------------------------------------------------------------------------------------
		
		$sql1 = "SELECT count(*) as Cantidad ";
		$sql1 = $sql1 . "FROM matriculatpsincurso INNER JOIN alumno ON matriculatpsincurso.rut_alumno = alumno.rut_alumno ";
		$sql1 = $sql1 . "WHERE (((matriculatpsincurso.cod_tipo)=".$TipoEnseñanza.") AND ((matriculatpsincurso.indigena)=1) AND ((matriculatpsincurso.estado)=3) AND ((alumno.sexo)=1));";
	
		$resultado_query1= pg_exec($conn,$sql1);
		$total_filas1= pg_numrows($resultado_query1);
		
		For ($j1=0; $j1 < $total_filas1; $j1++)
		{
			$Indica10 =  trim(pg_result($resultado_query1, $j1, 0));
	
		}
				
		//crea un fichero
		//echo $ls_string;
		$FechaRes = Cfecha($FechaRes);
		$FechaResCierre  = Cfecha($FechaResCierre );

		
		$ls_string 		= "22" . "$ls_espacio";
		$ls_string 		= $ls_string . $rdb 				. "$ls_espacio";
		$ls_string 		= $ls_string . $Dv 					. "$ls_espacio";
		$ls_string 		= $ls_string . $TipoEnseñanza 		. "$ls_espacio";	
		$ls_string 		= $ls_string . $CentroPadres 		. "$ls_espacio";	
		$ls_string 		= $ls_string . $PersoJur 			. "$ls_espacio";	
		$ls_string 		= $ls_string . $NumRes 				. "$ls_espacio";	
		$ls_string 		= $ls_string . $FechaRes	. "$ls_espacio";	
		$ls_string 		= $ls_string . $NumResCierre 		. "$ls_espacio";	
		$ls_string 		= $ls_string . $FechaResCierre	. "$ls_espacio";	
		$ls_string 		= $ls_string . $GruposDiferencia 	. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraIniM			. "$ls_espacio"; 
		$ls_string 		= $ls_string . $HoraFinM 			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraIniT			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraFinT			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraIniMT			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraFinMT			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraIniVN 			. "$ls_espacio";
		$ls_string 		= $ls_string . $HoraFinVN 			. "$ls_espacio";
		$ls_string 		= $ls_string . $Estado				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica1				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica2				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica3				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica4				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica5				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica6				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica7				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica8				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica9				. "$ls_espacio";
		$ls_string 		= $ls_string . $Indica10			. " $salto";
		
		@ fwrite($fichero,"$ls_string"); 
		}
	 
	}
	
//@pg_close($conn);
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
<FORM method=post name="frm" action="Menu_Actas.php">
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
                                          <INPUT class="botonXX" TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="Menu_Actas.php">
                                      </div></td>
                                    </tr>
                                    <tr height=30 >
                                      <td height="25" align="center" class="fondo">Generaci&oacute;n Electr&oacute;nica de la Informaci&oacute;n de Matr&iacute;cula Inicial </td>
                                    </tr>
                                    <tr>
                                      <td><div align="center">
                                          <p>&nbsp;</p>
                                        <p><strong><font face="Verdana, Arial, Helvetica, sans-serif">Archivo 22. Datos de las unidades educativas (tipos de ense&ntilde;anza)</font></strong> </p>
                                        <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
<? if (!$error){?>										El 
                                          archivo ha sido creado con el nombre de <a href='Actas/m<? echo $institucion ?>_22.txt'> &quot;m<? echo $institucion ?>_22.txt&quot;</a> , en total se encontraron
                                          <?=($cont)?>
                                          registros.
										  <? }else{echo $error;}s?>
										  <br>
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
</form>
<? pg_close($conn); ?>
</body>
</html>
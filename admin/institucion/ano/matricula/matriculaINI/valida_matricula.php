<?
echo "<script>alert('llegada valida matricula')</script>";
require('../../../../../util/header.inc');

$institucion	= $_INSTIT;

	if (!empty($_FILES)) {
		echo $tempFile = $_FILES['archivo']['tmp_name'];
		$targetPath = "files/";
		$tiempo      = time();
		$newFileName = $institucion."_".$tiempo.".xls";
		echo "<br>".$targetFile =  str_replace('//','/',$targetPath) . $newFileName;
		
		$sql = "INSERT INTO tmp_matricula (rdb,nombre) VALUES (".$institucion.",'".trim($newFileName)."')";
		$rs_tmp = pg_exec($conn,$sql);
		
		move_uploaded_file($tempFile,$targetFile);
		copy($tempFile,$targetFile);
		
	}
	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	
	$cont=0;
	require_once('Excel/reader.php');		 
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	
	
	$sql ="SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
	$rs_tmp = @pg_exec($conn,$sql);
	
	pg_numrows($rs_tmp);


	for($j=0;$j<@pg_numrows($rs_tmp);$j++){
		$fila =@pg_fetch_array($rs_tmp,$j);
		$archivo_nombre = $fila['nombre'];
		
		 
	
		// ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
			
		 $data->read('files/'.$archivo_nombre);
		 	
		 //error_reporting(E_ALL ^ E_NOTICE);

         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		 
		     echo "<br>";
		     echo "nro año-->".$nro_ano	    = $data->sheets[0]['cells'][$i][1];
			 echo ".. rdb -->".$rdb		    = $data->sheets[0]['cells'][$i][2];
			 echo ".. tipo ensenanza -->".$tipo_ense		= $data->sheets[0]['cells'][$i][3];
			 echo ".. grado curso -->".$grado_curso   = $data->sheets[0]['cells'][$i][4];
			 echo ".. descripcion -->".$desc_grado	= $data->sheets[0]['cells'][$i][5];
			 echo ".. letra -->".$letra_curso	= $data->sheets[0]['cells'][$i][6];
			 echo ".. rut -->".$rut_alumno	= $data->sheets[0]['cells'][$i][7];
			 echo ".. dig rut -->".$dig_rut		= $data->sheets[0]['cells'][$i][8];
			 echo ".. sexo -->".$sexo			= $data->sheets[0]['cells'][$i][9];
			 echo ".. nombres -->".$nombres		= $data->sheets[0]['cells'][$i][10];
			 echo ".. paterno -->".$ape_pat		= $data->sheets[0]['cells'][$i][11];
			 echo ".. materno -->".$ape_mat		= $data->sheets[0]['cells'][$i][12];
			 echo ".. direccion -->".$direccion		= $data->sheets[0]['cells'][$i][13];
			 echo ".. comuna -->".$comuna		= $data->sheets[0]['cells'][$i][14];
			 echo ".. direc -->".$direc			= $data->sheets[0]['cells'][$i][15];
			 echo ".. email -->".$email			= $data->sheets[0]['cells'][$i][16];
			 echo ".. fono -->".$fono			= $data->sheets[0]['cells'][$i][17];
			 echo ".. celular -->".$celular		= $data->sheets[0]['cells'][$i][18];
			 echo ".. fecha nac -->".$fecha_nac		= $data->sheets[0]['cells'][$i][19];
			 echo ".. etnia -->".$ethnia		= $data->sheets[0]['cells'][$i][20];
			 echo ".. codigo -->".$codigo		= $data->sheets[0]['cells'][$i][21];
			 echo ".. fecha matricula -->".$fecha_mat		= $data->sheets[0]['cells'][$i][22];
			 echo ".. fecha retiro -->".$fecha_ret		= $data->sheets[0]['cells'][$i][23];
			 $cursos 		= $desc_grado."º".$letra_curso;
			echo "<br>".$tipo_ense."--".$tipo_ense2;
			echo "<br>".$grado_curso."--".$grado_curso2;
			echo "<br>".$letra_curso."--".$letra_curso;
			
			if($tipo_ense!=$tipo_ense2 and $grado_curso!=$grado_curso2 and $letra_curso!=$letra_curso){
				echo "<br>".$sql = "SELECT * FROM curso WHERE id_ano=".$ano." AND ensenanza=".$tipo_ense." AND grado_curso=".$grado_curso." AND letra_curso='".$letra_curso."'";
				$rs_curso = @pg_exec($conn,$sql);
				if($cursos2!=$cursos){
					if(@pg_numrows($rs_curso)==0){
						$cont++;
						$curso[$cont] = "<br>curso :".$cursos;
					}	
				}
			}else{
				echo "<br> no entro";
			}
			$cursos2= $desc_grado."º".$letra_curso;	 
			$tipo_ense2 = $tipo_ense;	
			$grado_curso2 = $grado_curso;
			$letra_curso2 = $letra_curso;
			
         }		

	}

	//fclose('files/'.$archivo_nombre);
	if($cont==0){
		echo "<script>window.location='inscribe_alumnos.php'</script>";
	}
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3; 
						 include("../../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <!-- INICIO CODIGO CUERPO DE PROGRAMA-->
								  <table width="50%" border="0" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td width="10%"><div align="center"><img src="../../../../../icono_atencion.gif" width="33" height="28"></div></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" >Atenci&oacute;n esta p&aacute;gina contiene <font color="#FF0000"><b><?=$cant_errores?></b></font> observaciones, las cuales debe corregir. </font></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><? 
								  echo "CREAR LOS SIGUIENTES CURSOS -->";
									for($i=0;$i<$cont;$i++){
										echo $curso[$i];
									}
									?>	&nbsp;</font></td>
											</tr>
								    </table>
								  														  
								  <!-- FIN DEL NUEVO CÓDIGO -->
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</tr>
</tr></div>
</body>
</html>

<? echo "<script>alert('salida valida matricula')</script>";
 pg_close($conn);?>
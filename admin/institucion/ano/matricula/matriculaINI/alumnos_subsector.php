<? 
echo "<script>alert('llegada subsector')</script>";
require('../../../../../util/header.inc');


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
.Estilo3 {
	font-size: 14px;
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
								  <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td colspan="2"><span class="Estilo3"><font face="Verdana, Arial, Helvetica, sans-serif">PROCESO DE MATRICULA ALUMNOS</font> </span></td>
										    </tr>
											<tr>
											  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">REGISTRO DE ALUMNOS </font></td>
											  <td><img src="../../../../../vb.jpg" width="25" height="25"></td>
											</tr>
											<tr>
											  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROCESO DE MATRICULA </font></td>
											  <td><img src="../../../../../vb.jpg" width="25" height="25"></td>
									</tr>
											<tr>
											  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROCESO DE INSCRIPCI&Oacute;N DE RAMOS </font> </td>
											  <td><img src="../../../../../cargando.gif" width="200" height="100" border="0"></td>
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
</tr>
</body>
</html>

<?


$institucion	= $_INSTIT;
$ano			= $_ANO;

$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
$nro_ano = $fil_ano_actual['nro_ano'];

$sql = "SELECT id_curso FROM curso WHERE id_ano =".$ano;
$rs_cur = @pg_exec($conn,$sql);

for($z=0;$z<@pg_numrows($rs_cur);$z++){
	$fila_cur = @pg_fetch_array($rs_cur,$z);
	$sql = "DELETE FROM tiene$nro_ano WHERE id_curso=".$fila_cur['id_curso'];
	$rs_tiene = @pg_exec($conn,$sql);
}

$sql ="SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
$rs_tmp = @pg_exec($conn,$sql);
require_once 'Excel/reader.php';		 
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');

for($j=0;$j<@pg_numrows($rs_tmp);$j++){
	$fila =@pg_fetch_array($rs_tmp,$j);
	$archivo_nombre = $fila['nombre'];
	
		
	
	 // ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
		
		 $data->read('files/'.$archivo_nombre);
		 
		 //error_reporting(E_ALL ^ E_NOTICE);

         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		 
		    $nro_ano	    = $data->sheets[0]['cells'][$i][1];
			 $rdb		    = $data->sheets[0]['cells'][$i][2];
			 $tipo_ense		= $data->sheets[0]['cells'][$i][3];
			 $grado_curso   = $data->sheets[0]['cells'][$i][4];
			 $desc_grado	= $data->sheets[0]['cells'][$i][5];
			 $letra_curso	= $data->sheets[0]['cells'][$i][6];
			 $rut_alumno	= $data->sheets[0]['cells'][$i][7];
			 $dig_rut		= $data->sheets[0]['cells'][$i][8];
			 $sexo			= $data->sheets[0]['cells'][$i][9];
			 $nombres		= $data->sheets[0]['cells'][$i][10];
			 $ape_pat		= $data->sheets[0]['cells'][$i][11];
			 $ape_mat		= $data->sheets[0]['cells'][$i][12];
			 $direccion		= $data->sheets[0]['cells'][$i][13];
			 $comuna		= $data->sheets[0]['cells'][$i][14];
			 $direc			= $data->sheets[0]['cells'][$i][15];
			 $email			= $data->sheets[0]['cells'][$i][16];
			 $fono			= $data->sheets[0]['cells'][$i][17];
			 $celular		= $data->sheets[0]['cells'][$i][18];
			 $fecha_nac		= $data->sheets[0]['cells'][$i][19];
			 $ethnia		= $data->sheets[0]['cells'][$i][20];
			 //$codigo		= $data->sheets[0]['cells'][$i][21];
			 $fecha_mat		= $data->sheets[0]['cells'][$i][21];
			 $fecha_ret		= $data->sheets[0]['cells'][$i][22];
			 
						
			 
			 
			 if($tipo_ense!="10"){
				$sql = "SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$tipo_ense." AND grado_curso=".$grado_curso." AND letra_curso='".$letra_curso."'";
				
				$rs_curso = @pg_exec($conn,$sql);
				$id_curso = @pg_result($rs_curso,0);
				
				$sql = "SELECT id_ramo FROM ramo WHERE id_curso=".$id_curso;
				$rs_ramo = @pg_exec($conn,$sql);
				
			
				
				for($x=0;$x<@pg_numrows($rs_ramo);$x++){
					$fila_ramo = @pg_fetch_array($rs_ramo,$x);
					$sql = "INSERT INTO tiene$nro_ano (rut_alumno,id_ramo,id_curso) VALUES(".$rut_alumno.",".$fila_ramo['id_ramo'].",".$id_curso.")";
					$result = @pg_exec($conn,$sql);	
				}
			}
					
         }	
		
}
echo "<script>alert('salida subsector')</script>";
//fclose('files/'.$archivo_nombre);
echo "<script>window.location='../listarMatricula.php3';</script>";

pg_close($conn);
?>


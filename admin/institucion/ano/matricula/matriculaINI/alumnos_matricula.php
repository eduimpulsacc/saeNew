<? 
echo "<script>alert('llegada matricula')</script>";
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
											  <td colspan="2"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROCESO DE MATRICULA ALUMNOS </font></td>
										    </tr>
											<tr>
											  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">REGISTRO DE ALUMNOS </font></td>
											  <td><img src="../../../../../vb.jpg" width="25" height="25"></td>
											</tr>
											<tr>
											  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROCESO DE MATRICULA </font></td>
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
</tr></div>
</body> 
</html> 
<?
 
  
$institucion	= $_INSTIT; 
$sql = "DELETE FROM matricula WHERE id_ano=".$ano;   
$rs_detele =@pg_exec($conn,$sql);   
  
$ano			= $_ANO;

$sql ="SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
$rs_tmp = @pg_exec($conn,$sql);
echo "antes del for";
for($j=0;$j<@pg_numrows($rs_tmp);$j++){
	$fila =@pg_fetch_array($rs_tmp,$j);
	$archivo_nombre = $fila['nombre'];
		echo "<br> dentro del for";
	 // ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
		 require_once 'Excel/reader.php';		 
		 $data = new Spreadsheet_Excel_Reader();
		 $data->setOutputEncoding('CP1251');
		 $data->read('files/'.$archivo_nombre);
		 		 
		 //error_reporting(E_ALL ^ E_NOTICE);

         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
			 unset($fecha_ret);
			 echo "<br>primera fecha retiro-->".$fecha_ret;
			 echo "<br>".date("d-m-Y");
			 $fecha_matricula = "";
			 $fecha_retiro = "";
		    echo "<br>".$nro_ano	    = $data->sheets[0]['cells'][$i][1];
			echo "<br>". $rdb		    = $data->sheets[0]['cells'][$i][2];
			echo "<br>". $tipo_ense		= $data->sheets[0]['cells'][$i][3];
			echo "<br>".$grado_curso   = $data->sheets[0]['cells'][$i][4];
			echo "<br>". $desc_grado	= $data->sheets[0]['cells'][$i][5];
			echo "<br>".$letra_curso	= $data->sheets[0]['cells'][$i][6];
			echo "<br>". $rut_alumno	= $data->sheets[0]['cells'][$i][7];
			echo "<br>". $dig_rut		= $data->sheets[0]['cells'][$i][8];
			 echo "<br>".$sexo			= $data->sheets[0]['cells'][$i][9];
			 echo "<br>".$nombres		= $data->sheets[0]['cells'][$i][10];
			echo "<br>". $ape_pat		= $data->sheets[0]['cells'][$i][11];
			echo "<br>". $ape_mat		= $data->sheets[0]['cells'][$i][12];
			echo "<br>". $direccion		= $data->sheets[0]['cells'][$i][13];
			echo "<br>". $comuna		= $data->sheets[0]['cells'][$i][14];
			echo "<br>". $direc			= $data->sheets[0]['cells'][$i][15];
			echo "<br>". $email			= $data->sheets[0]['cells'][$i][16];
			echo "<br>". $fono			= $data->sheets[0]['cells'][$i][17];
			echo "<br>". $celular		= $data->sheets[0]['cells'][$i][18];
			echo "<br>". $fecha_nac		= $data->sheets[0]['cells'][$i][19];
			echo "<br>". $ethnia		= $data->sheets[0]['cells'][$i][20];
			//$codigo		= $data->sheets[0]['cells'][$i][21];
			echo "<br>". $fecha_mat		= $data->sheets[0]['cells'][$i][21];
			 echo "<br>--->FECHA DE RETIRO A CAMBIAR-->".$fecha_ret		= $data->sheets[0]['cells'][$i][22];
			 
			 /* "fecha_retiro -->".$fecha_ret		= $data->sheets[0]['cells'][$i][17];
			
			// fecha de antofasgata 
			//echo "<br> fecha matricula--->".$fecha_matricula = fEs2EnAN($fecha_mat);
			//echo "<br>fecha retiro -->".$fecha_retiro = fEs2EnAN($fecha_ret);
			*/
			$fecha_matricula = $fecha_mat;
			echo "segunda fecha retiro-->".$fecha_retiro = $fecha_ret;
			//if($fecha_retiro=='22/04/2014'){ //HABILITADO SOLO PARA ERROR EN ANTOFAGASTA
//					$fecha_retiro="01/01/1900";
//			}else{
				/*if(pg_dbname($conn)=="coi_antofagasta"){
					$fecha_retiro=substr($fecha_ret,0,2); //DIA
					$fecha_retiro.="-";
					$fecha_retiro.=substr($fecha_ret,3,2); // MES
					$fecha_retiro.="-";
					$fecha_retiro.=substr($fecha_ret,6,4); // AÑO
				}else{*/
					/*$fecha_retiro =substr($fecha_ret,3,2); // MES
					$fecha_retiro.="-"; 
					$fecha_retiro.=substr($fecha_ret,0,2); //DIA
					$fecha_retiro.="-";
					$fecha_retiro.=substr($fecha_ret,6,4); // AÑO*/
					echo "rrrrrrrrrr->".$fecha_retiro=CambioFE($fecha_ret);
				//}
			//}
			// fecha de BD
			/*if(pg_dbname($conn)=="coi_antofagasta"){
				$fecha_matricula = substr($fecha_mat,0,2); //DIA
				$fecha_matricula.="-";
				$fecha_matricula.= substr($fecha_mat,3,2); // MES
				$fecha_matricula.="-";
				$fecha_matricula.=substr($fecha_mat,6,4); // AÑO			
			}else{*/
				$fecha_matricula = substr($fecha_mat,3,2); // MES
				$fecha_matricula.="-";
				$fecha_matricula.=substr($fecha_mat,0,2); //DIA
				$fecha_matricula.="-";
				$fecha_matricula.=substr($fecha_mat,6,4); // AÑO			
	
			//}
			
			/*if(pg_dbname($conn)=="coi_antofagasta"){
				$fecha_nac = substr($fecha_nac,0,2); //DIA
				$fecha_nac.="-";
				$fecha_nac.= substr($fecha_nac,3,2); // MES
				$fecha_nac.="-";
				$fecha_nac.=substr($fecha_nac,6,4); // AÑO			
			}else{*/
				$fecha_nac = substr($fecha_nac,3,2); // MES
				$fecha_nac.="-";
				$fecha_nac.=substr($fecha_nac,0,2); //DIA
				$fecha_nac.="-";
				$fecha_nac.=substr($fecha_nac,6,4); // AÑO			
	
			//}
			
			//echo "<br> fecha matricula--->".$fecha_matricula = fEs2En($fecha_mat);
			//echo "<br>fecha retiro -->".$fecha_retiro = fEs2En($fecha_ret);
			 
			$sql = "SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$tipo_ense." AND grado_curso=".$grado_curso." AND letra_curso='".$letra_curso."'";
			$rs_curso = @pg_exec($conn,$sql);
			$id_curso = @pg_result($rs_curso,0);
			
			/* $sql ="SELECT * FROM matricula WHERE rut_alumno=".$rut_alumno." AND id_ano=".$ano;
			 $rs_existe_alu = @pg_exec($conn,$sql);
			 
			 if(@pg_numrows($rs_existe_alu)==0){*/
			 
			 if($fecha_retiro!='1900-01-01' || $fecha_retiro!=0){
				echo "<br>".$sql = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,bool_ar,fecha_retiro,fecha) VALUES(".$rut_alumno.",".$institucion.",".$ano.",".$id_curso.", 1,'".$fecha_retiro."','".$fecha_matricula."')";
			 }else{
			 	echo "<br>".$sql = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,bool_ar,fecha) VALUES(".$rut_alumno.",".$institucion.",".$ano.",".$id_curso.",0,'".$fecha_matricula."')";
			}
				$result = @pg_exec($conn,$sql);
				
			 //}
		    		
		
         }	 
}

//el update
$sql_up="update matricula set bool_ar=0,fecha_retiro=null where id_ano=$ano";
pg_exec($conn,$sql_up);
//exit;
// CUANDO HALLA ERROR AGREGAR UN EXIT PARA VERIFICAR FECHA DE RETIRO

echo "<br> despues del for";

echo "<script>alert('salida matricula')</script>";

//fclose('files/'.$archivo_nombre);

//echo "<script>window.location='alumnos_subsector.php';</script>";


pg_close($conn);
?>

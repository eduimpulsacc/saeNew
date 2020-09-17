<? 
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
$ano			= $_ANO;
 

$archivo_nombre = "archivo_04.xls";

// ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
require_once 'Excel/reader.php';		 
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read('files/'.$archivo_nombre);
	 
//error_reporting(E_ALL ^ E_NOTICE);

for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {

	$nro_archivo	    = $data->sheets[0]['cells'][$i][1];
	$rdb		    	= $data->sheets[0]['cells'][$i][2];
	$dig_rdb			= $data->sheets[0]['cells'][$i][3];
	$ensenanza		   	= $data->sheets[0]['cells'][$i][4];
	$grado_cruso		= $data->sheets[0]['cells'][$i][5];
	$letra_curso		= $data->sheets[0]['cells'][$i][6];
	$nro_ano			= $data->sheets[0]['cells'][$i][7];
	$rut_alumno			= $data->sheets[0]['cells'][$i][8];
	$dig_rut			= $data->sheets[0]['cells'][$i][9];
	$plan_estudio		= $data->sheets[0]['cells'][$i][10];
	$decreto_evaluacion	= $data->sheets[0]['cells'][$i][11];
	$cod_subsector		= $data->sheets[0]['cells'][$i][12];
	$nota				= $data->sheets[0]['cells'][$i][13];
	$religion			= $data->sheets[0]['cells'][$i][14];
	
	if($nota==""){
		$promedio = $religion;
	}else{
		$promedio = $nota;	
	}
	
	$sql = "SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$tipo_ense." AND grado_curso=".$grado_curso." AND letra_curso='".$letra_curso."'";
	$rs_curso = @pg_exec($conn,$sql);
	$id_curso = @pg_result($rs_curso,0);
	
	$sql ="SELECT rut_alumno FROM matricula WHERE id_ano=".$ano." AND id_curso=".$id_curso." AND rut_alumno=".$rut_alumno;
	$rs_alumno = pg_exec($conn,$sql);
	if(@pg_numrows($rs_alumno)>0){
		$sql = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,bool_ar,fecha) VALUES(".$rut_alumno.",".$rdb.",".$ano.",".$id_curso.", 0,'01-01-2012')";
		$result = @pg_exec($conn,$sql);
	}
	
	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$id_curso." AND cod_subsector=".$cod_subsector;
	$rs_ramo = pg_exec($conn,$sql);
	$id_ramo = pg_result($rs_ramo,0);
	
	$sql ="INSERT INTO tiene$nro_ano (rut_alumno,id_ramo,id_curso) VALUES (".$rut_alumno.",".$id_ramo.",".$id_curso.")";
	$rs_tiene = pg_exec($conn,$sql);
	
	$sql="INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) VALUES (".$rdb.",".$ano.",".$id_curso.",".$id_ramo.",".$rut_alumno.",'".$promedio."')";
	$rs_promedio =pg_exec($conn,$sql);
	
	if($rs_promedio){
		$contador++;	
	}
	

		

}	 

echo "cantidad de registros-->".$contador;


pg_close($conn);
?>

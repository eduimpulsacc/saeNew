<? 
echo "<script>alert('llegada inscribe alumnos')</script>";
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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


//-->



</script>
<body>
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


$sql ="SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
$rs_tmp = @pg_exec($conn,$sql);

require('Excel/reader.php');	
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$ruta = "files/".$archivo_nombre;

for($j=0;$j<@pg_numrows($rs_tmp);$j++){
	$fila =@pg_fetch_array($rs_tmp,$j);
	$archivo_nombre = $fila['nombre'];
		
	
	 // ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
		 
		 $data->read('files/'.$archivo_nombre);

		 //error_reporting(E_ALL ^ E_NOTICE);
		/* show($data->sheets[0]['cells']);
		 die();*/
			
         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		 	 echo "<br>";
		     echo "<br>nro año-->".$nro_ano	    = $data->sheets[0]['cells'][$i][1];
			 echo "<br>.. rdb -->".$rdb		    = $data->sheets[0]['cells'][$i][2];
			 echo "<br>.. tipo ensenanza -->".$tipo_ense		= $data->sheets[0]['cells'][$i][3];
			 echo "<br>.. grado curso -->".$grado_curso   = $data->sheets[0]['cells'][$i][4];
			 echo "<br>.. descripcion -->".$desc_grado	= $data->sheets[0]['cells'][$i][5];
			 echo "<br>.. letra -->".$letra_curso	= $data->sheets[0]['cells'][$i][6];
			 echo "<br>.. rut -->".$rut_alumno	= $data->sheets[0]['cells'][$i][7];
			 echo "<br>.. dig rut -->".$dig_rut		= $data->sheets[0]['cells'][$i][8];
			 echo "<br>.. sexo -->".$sexo			= $data->sheets[0]['cells'][$i][9];
			 echo "<br>.. nombres -->".$nombres		= $data->sheets[0]['cells'][$i][10];
			 echo "<br>.. paterno -->".$ape_pat		= $data->sheets[0]['cells'][$i][11];
			 echo "<br>.. materno -->".$ape_mat		= $data->sheets[0]['cells'][$i][12];
			 echo "<br>.. direccion -->".$direccion		= substr($data->sheets[0]['cells'][$i][13],0,50);
			 echo "<br>.. comuna -->".$comuna		= $data->sheets[0]['cells'][$i][14];
			 echo "<br>.. direc -->".$direc			= substr($data->sheets[0]['cells'][$i][15],0,50);
			 echo "<br>.. email -->".$email			= $data->sheets[0]['cells'][$i][16];
			 echo "<br>.. fono -->".$fono			= $data->sheets[0]['cells'][$i][17];
			 echo "<br>.. celular -->".$celular		= $data->sheets[0]['cells'][$i][18];
			 echo "<br>.. fecha nac -->".$fecha_nac		= $data->sheets[0]['cells'][$i][19];
			 echo "<br>.. etnia -->".$ethnia		= $data->sheets[0]['cells'][$i][20];
			 //echo ".. codigo -->".$codigo		= $data->sheets[0]['cells'][$i][21];
			 echo "<br>.. fecha matricula -->".$fecha_mat		= $data->sheets[0]['cells'][$i][21];
			 echo "<br>.. fecha retiro -->".$fecha_ret		= $data->sheets[0]['cells'][$i][22];
			 
			 
			 if($sexo=="F"){
			 	$sex = 1;
			} else{
			 	$sex = 2;
			}	
			if(strlen($direc)==5){
				$region = substr($direc,0,2);
				$ciudad = substr($direc,2,1);
				$comuna = substr($direc,4,2);
			}else{
				$region = substr($direc,0,1);
				$ciudad = substr($direc,1,1);
				$comuna = substr($direc,3,2);
			}
				$dia = substr($fecha_nac,0,2);
				$mes = substr($fecha_nac,3,2);
				$ano = substr($fecha_nac,6,4);
			if(pg_dbname($conn)=="coi_antofagasta"){
				$fecha_nac = $dia."-".$mes."-".$ano; // fecha de antofagasta
			}else{
				$fecha_nac = $mes."-".$dia."-".$ano; // fecha otra BD			
			}
			
			$nacionalidad =2;
			

			 
			 $sql_alu ="SELECT * FROM alumno WHERE rut_alumno=".$rut_alumno;
			 $rs_existe_alu = @pg_exec($conn,$sql_alu);
			 
			 if(@pg_numrows($rs_existe_alu)==0){
			 	echo $sql_insert = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,calle,telefono,email,fecha_nac,region,ciudad,comuna,nacionalidad,celular) VALUES(".$rut_alumno.",'".$dig_rut."','".$nombres."','".$ape_pat."','".$ape_mat."',".$sex.",'".$direccion."','".$fono."','".$email."','".$fecha_nac."',".$region.",".$ciudad.",".$comuna.",".$nacionalidad.",'".$celular."')";
				$result = @pg_exec($conn,$sql_insert);
				
			 }else{
				echo "<br>".$sql = "UPDATE alumno SET nombre_alu='".$nombres."',ape_pat='".$ape_pat."',ape_mat='".$ape_mat."',calle='".$direccion."', telefono='".$fono."', email='".$email."',region=".$region.",ciudad=".$ciudad.",comuna=".$comuna.", celular='".$celular."' WHERE rut_alumno=".$rut_alumno."";
				$result = @pg_exec($conn,$sql) or die (pg_last_error($conn));
			 }
         }	 
}
echo "<script>alert('salida inscribe alumnos')</script>";
//fclose('files/'.$archivo_nombre);
echo "<script>window.location='alumnos_matricula.php'</script>";


pg_close($conn);
?>

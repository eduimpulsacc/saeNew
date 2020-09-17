<?php 

require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$reporte		=$c_reporte;
    $_POSP = 4;
	$_bot = 8;
	
	if (trim($_url)=="") $_url=0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
      
	  
	   <?
						include("../../../../cabecera/menu_inferior.php");
						?>
	  
	  
	  
	  
	  <tr>
		</tr> 
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->


<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form action="printListaCurso_Comuna_C.php" method="post" target="_blank">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<? 
$ob_motor = new MotorBusqueda();
$ob_motor->ano = $ano;
$resultado_query_cue = $ob_motor->curso($conn);
$resultado_comuna = $ob_motor->Comuna($conn);



?>
<center>
<table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550">
	<table width="90%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="tableindex" align="center">Buscador Avanzado</td>
  </tr>
  <tr>
    <td height="27"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2" class="cuadro01">Buscar por Curso
          <select name="cmb_curso" class="ddlb_x">
              <?
			  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
			  {
				  $fila = @pg_fetch_array($resultado_query_cue,$i); 
				  $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				  if ($fila['id_curso'] == $cmb_curso){
				     echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
				  }else{
				     echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
				  }	 	 
			   } ?>
            </select>        </td>
      </tr>
      <tr>
        <td class="cuadro01" colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td class="cuadro01">Buscar por Comuna
          <select name="cmb_comuna" class="ddlb_x">
              <option value=0 selected>(Todas las Comunas)</option>
              <?
			  for($j=0 ; $j < @pg_numrows($resultado_comuna) ; $j++)
			  {
				  $fila2 = @pg_fetch_array($resultado_comuna,$j);
				  
				  
				  echo "<option value=".$fila2['cor_com'].">".$fila2['nom_com']."</option>";
				    	  
			   } ?>
            </select>        </td>
        <td width="182" class="cuadro01"><div align="center"></div></td>
      </tr>
      <tr>
        <td colspan="2" class="cuadro01">&nbsp;</td>
        </tr>
      <tr>
        <td class="cuadro01">Orden<br>
          <input name="ck_orden" type="radio" value="0" checked>
          Alfabetico 
          <input name="ck_orden" type="radio" value="1">
          Nro Lista </td>
        <td class="cuadro01">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="cuadro01">&nbsp;</td>
        <td align="center" class="cuadro01"><p>
          <input name="cb_ok" class="botonXX"  type="submit" value=" Buscar  ">
          <input name="cb_ex" class="botonXX"  type="submit" value="Exportar">
          </p>
          <p align="right">
            <input name="cb_ok2" class="botonXX"  type="button" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
            </p></td>
      </tr>
      
    </table></td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
				 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
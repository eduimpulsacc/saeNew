<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
	}   

?>
<?php 
    //setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	$curso			=$c_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.target="_parent";
				form.action = 'InformeCertificadoEBasicaMedia_C.php';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

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
      
	  
	  <?	include("../../../../cabecera/menu_inferior.php");
						?>
		</td>
		</tr> 
  
  
</table>
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="printCertificadoEBasicaMedia_C.php" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor ->ano=$ano;
$resultado_query_cue = $ob_motor ->Certificado($conn);


?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="78" class="textosimple">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
          <option value=0 selected>(Seleccione Curso)</option>
            <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if (($resultado_query_cue[grado_curso]==5)&&($resultado_query_cue[grado_curso]!=10)) {}else{
			  if ($fila["id_curso"]==$cmb_curso){
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }else{
					$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
					echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
			  }
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="61" class="textosimple">Alumno</td>
    <td width="219"><select name="cmb_alumno" class="ddlb_9_x">
      <option value="0" selected>(Todos los Alumnos)</option>
      <?
	  	$ob_motor ->cmb_curso =$cmb_curso;
		$result= $ob_motor ->alumno($conn);

		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
			<?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
      <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	           <?
			}else{
			   ?>
      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	           <?
			 }
	  ?>		 
			     
      
	  
	  
	  <?
		}
		?>
    </select></td>
	
    <td width="80"><div align="right"></div></td>
  </tr>
  <tr>
    <td class="textosimple">Transicion</td>
    <td><input type="checkbox" name="ck_parvulo" value="1"></td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5" class="textosimple"><table width="320" border="0" cellspacing="2" cellpadding="0" align="center">
      <tr>
        <td class="textosimple">Fecha del Informe</td>
        <td><div align="center">
            <input name="dia" type="text" id="dia" size="2" value="<?=$dia ?>">
        </div></td>
        <td><div align="center">
            <input name="mes" type="text" id="mes" size="11" value="<?=$mes ?>">
        </div></td>
        <td><div align="center">
            <input name="ano2" type="text" id="ano2" size="4" value="<?=$ano2 ?>">
        </div></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="5" class="textosimple"><div align="right">
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar">
      <? if($_PERFIL==0){?>
      <input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
      <? }?>
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
    </div></td>
    </tr>
</table>

	</td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2006</td>
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

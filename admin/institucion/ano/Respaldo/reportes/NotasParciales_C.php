<? 
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');
//setlocale("LC_ALL","es_ES");

?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'NotasParciales_C.php';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso; 
	$alumno		    =$c_alumno; 
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	
	$_POSP = 4;
	$_bot = 8;
	
		
	$ob_motor = new MotorBusqueda();
	$ob_motor -> ano = $ano;
	$ob_motor -> cmb_curso = $cmb_curso;
	
	
	$resultado_query_cue =$ob_motor ->curso($conn); //---- BUSQUEDA DE CURSOS
	$result_peri = $ob_motor->periodo($conn);  //----- BUSQUEDA DE PERIODOS
	$result = $ob_motor ->alumno($conn); //--------- BUSQUEDA DE ALUMNO
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="98%" border="0" cellspacing="0" cellpadding="0">
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
                      <td width="73%" align="left" valign="top">
					  <form method="post" action="">
					  <input name="c_reporte" type="hidden" value="<?=$reporte;?>">
					  <? 
				
					//echo $_CURSO;
					?>
  <center>
  <table width="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="53%">
        <table width="100%" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="53%" class="tableindex">Buscador Avanzado </td>
    </tr>
          <tr>
            <td height="27">
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="5" class="textosmediano"><span class="textosimple">Per&iacute;odo</span><br>
                    <select name="cmb_periodos" class="ddlb_9_x">
                      <option value=0 selected>(Seleccione Periodo)</option>
                      <?
						  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++) {
							  $fila = @pg_fetch_array($result_peri,$i); 
							  if ($fila['id_periodo']==$cmb_periodos)
								echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
							  else
								echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
						  
                       	} ?>
                    </select>
				</td>
      		</tr>
                <tr>
                  <td colspan="5" class="textosmediano"><br>
                    <span class="textosimple">Curso</span>
                    <div align="left"> 
                      <font size="1" face="arial, geneva, helvetica">
                        <? if($_PERFIL == 17){ ?>
                        <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
                          <option value=0 selected>(Seleccione Curso)</option>
                          <? 
						  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
						  {
						  $fila = @pg_fetch_array($resultado_query_cue,$i); 
						  if ($fila["id_curso"]==$_CURSO){
								if($fila["id_curso"]==$cmb_curso){
									echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}else{
									echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}
							}	
						  } ?>
                          </select>
                        <? }else{ ?> 
                        <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
                          <option value=0 selected>(Seleccione Curso)</option>
                          <?
						  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++) {
							  $fila = @pg_fetch_array($resultado_query_cue,$i); 
							  if ($fila["id_curso"]==$cmb_curso){
						  		if($fila['cod_decreto']==771982 || $fila['cod_decreto']==461987 || $fila['cod_decreto']==121987 || $fila['cod_decreto']==1521989 || $fila['cod_decreto']==1000){
									$ob_motor ->decreto = $fila['cod_decreto'];
									$ob_motor ->grado = $fila["grado_curso"];
									$ob_motor ->Sigla($conn);
									echo "<option selected value=".$fila['id_curso'].">".$ob_motor->sigla." - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}else{
								echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}		  
						  }else{
								if($fila['cod_decreto']==771982 || $fila['cod_decreto']==461987 || $fila['cod_decreto']==121987 || $fila['cod_decreto']==1521989 || $fila['cod_decreto']==1000){
									$ob_motor ->decreto = $fila['cod_decreto'];
									$ob_motor ->grado = $fila["grado_curso"];
									$ob_motor ->Sigla($conn);
									echo "<option selected value=".$fila['id_curso'].">".$ob_motor->sigla." - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}else{
									echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
								}		
						  }
						} ?>
                          </select>
                        <? } ?>
  </font>	  </div>
	  
                   </td>
      </tr>
                <tr>
                  <td colspan="5" class="textosmediano"><br>
                    <span class="textosimple">Alumno</span>
                    <div align="left">
                      <select name="cmb_alumno" class="ddlb_9_x">
                        <option value=0 selected>(Todos los Alumnos)</option>
                        <?
						for($i=0 ; $i < pg_numrows($result) ; $i++){
							$fila_alumno = pg_fetch_array($result,$i);
							$ob_motor->CambiaDato($fila_alumno);
							if ($ob_motor->alumno == $cmb_alumno){
							?>
								<option value="<?=$ob_motor->alumno; ?>" selected><?=$ob_motor->nombres;?></option>
							<? }else{ ?>
								<option value="<?=$ob_motor->alumno; ?>"><?=$ob_motor->nombres;?></option>
							<?
							}		
						}
						?>
                        </select>
                      </div></td>
		      </tr>
                <tr>
                  <td width="39" class="textosmediano">&nbsp;</td>
      <td width="498" colspan="4"><div align="right">
        
        <? if ($flag==0) {
	         if ($_INSTIT==516 or $_INSTIT==2278){  ?>
        <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_3y4_d.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
        
        
        <? } elseif ($_INSTIT == 26080){ ?>
        <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_subsector.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
        
        
        <?
			 }else{ ?>	   
        <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_3y4.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
        <? } ?>
        <? }else if($flag==1) { ?>	  
        <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_3y4_extre.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
        <? } if($flag==2){?>
        <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_Examen.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar">
        <? } ?>
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
                        
                        
                        
                      </td></tr>
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
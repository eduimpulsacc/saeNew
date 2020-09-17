<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	
	
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag2(form){
					form.target="_blank";
					var curso= document.form.cmb_curso.value;
					var opcion = document.form.orden.value;
					document.form.action='printRegistroMatriculaCurso_C.php?curso='+curso+'&orden='+opcion;
					document.form.submit(true);
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


function SelectAllCheckBox(chkbox,FormId){        
	for (var i=0;i < document.forms[FormId].elements.length;i++)

	{
		var Element = document.forms[FormId].elements[i];
		if (Element.type == "checkbox")
			Element.checked = chkbox.checked;
	}
}



//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
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
							
<form method="post" name="form" Id="FrmSelectAllChecbox" action="printRegistroMatriculaCursoAdaptable.php" target="_blank">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
  <td><br>
								  
								


<? 
$ob_motor = new MotorBusqueda();
$ob_motor->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$resultado_query_cue = $ob_motor->curso2($conn);
?>
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="tableindex">Registro Matricula Curso Adaptable</td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="cuadro01">Curso</td>
    <td width="263">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
        </select>
</font>	  </div></td>
   
  </tr>
  <tr>
    <td class="cuadro01">Ordenado por </td>
    <td><span class="Estilo1">
      <input name="orden" type="radio" value="2">
      Numero Matricula 
        <input name="orden" type="radio" value="1" checked>
        Apellido
        <label>
        <input type="checkbox" name="ocupacion" value="1">
        Ocupacion</label>
    </span></td>
  </tr>
   <tr>
    <td class="cuadro01">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">Seleccionar Todos</td>
    <td><input type="checkbox" name="SelectedAll" onclick="SelectAllCheckBox(this,'FrmSelectAllChecbox');"/>
 </td>
  </tr>
  <tr>
    <td class="cuadro01">Datos Opcionales</td>
    <td class="Estilo1">Nº de Matricula<input type="checkbox" name="n_matricula" value="1">&nbsp;
    Integrado<input type="checkbox" name="integrado" value="1">
    &nbsp;Sexo<input type="checkbox" name="sexo" value="1">
    &nbsp;Rut<input type="checkbox" name="rut_" value="1">
    &nbsp;Fecha Nac<input type="checkbox" name="fecha_n_" value="1">
    &nbsp;Comuna<input type="checkbox" name="comuna" value="1">
   </td>
  </tr>
  <tr>
    <td class="cuadro01">Antecedentes Escolares</td>
    <td class="Estilo1">Domicilio<input type="checkbox" name="domicilio" value="1">&nbsp;
    Fecha Matricula<input type="checkbox" name="fecha_mat" value="1">
    &nbsp;
    Ha repetido curso<input type="checkbox" name="curso_rep" value="1">
    &nbsp;Con quien vive<input type="checkbox" name="c_vive" value="1">
    </td>
  </tr>
  <tr>
  <td class="cuadro01">Padres</td>
  <td class="Estilo1">Padre<input type="checkbox" name="padre" value="1">
  &nbsp;Madre<input type="checkbox" name="madre" value="1">
  &nbsp;Tutor<input type="checkbox" name="tutor" value="1">
  &nbsp;Prof Tutor<input type="checkbox" name="prof_tutor" value="1">
   &nbsp;Ocupacion Tutor<input type="checkbox" name="ocu_tutor" value="1">
  &nbsp;Domicilio Tutor<input type="checkbox" name="dir_tutor" value="1">
   &nbsp;Fono Tutor<input type="checkbox" name="fono_tutor" value="1">
   </td>
  </tr>
  <tr>
  <td class="cuadro01">&nbsp;</td>
  <td class="Estilo1">
  &nbsp;Informacion de Salud<input type="checkbox" name="inf_salud" value="1">
  Datos de Interes<input type="checkbox" name="d_Interes" value="1">
  &nbsp;Avisar en caso de emergencia<input type="checkbox" name="f_emergencia" value="1">
  email apoderado 
  <input name="email_apo" type="checkbox" id="email_apo" value="1"></td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="Estilo1">telefono recado 
      <input name="fono_recado" type="checkbox" id="fono_recado" value="1"></td>
  </tr>
    </table>

	<table width="600" border="0" align="right" cellpadding="1" cellspacing="0">
      <tr>
        <th width="462" scope="col"><div align="right">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="  Buscar ">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="button" class="botonXX"  id="cb_exp" onClick="enviapag2(this.form)" value="Exportar">
        </div></th>
        <th width="52" scope="col"><div align="right">
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
        </div></th>
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
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

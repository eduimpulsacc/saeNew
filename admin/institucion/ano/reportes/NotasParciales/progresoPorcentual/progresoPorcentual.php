<?php


require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');

$_POSP = 6;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	
	$fecha =date("d-m-Y");	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target="_parent";
		form.action = 'progresoPorcentual.php';
		form.submit(true);
	}	
}



			
				
</script>
<SCRIPT language="JavaScript">
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../../cabecera/menu_superior.php");
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
						include("../../../../../../menus/menu_lateral.php");
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
                                  <td><center>

<br>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<? //if($_PERFIL==0 && $institucion==25114){?>
	<form method "post" action="printprogresoPorcentual.php" name="form" target="_blank">
<? //}else{ ?>
	<!--<form method "post" action="printInformeNotasParciales_C.php" name="form" target="_blank">-->
<? //} ?>
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<input name="cabeza" type="hidden" value="1">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$result_curso = $ob_motor ->curso2($conn);

$result_peri = $ob_motor ->periodo($conn);

//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="98" class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">Periodo</td>
    <td>
	  <div align="left"><span class="cuadro01">
	    <select name="cmb_periodos" class="ddlb_9_x">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
          <? } 
		 
		  ?>
        </select>
	   </span>
	  </div></td>
    <td width="80"><div align="right"></div></td>
  </tr>
  
  <tr>
    <td class="textosimple">Curso</td>
    <td width="506"><font size="1" face="arial, geneva, helvetica"><span class="cuadro01">
      <select name="c_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select>
    </span><br>
    </font></td>
    
  </tr>
  
  <tr>
    <td class="textosimple">Alumno</td>
    <td><span class="cuadro01">
      <select name="c_alumno" class="ddlb_9_x">
        <option value=0 selected>(Todos los Alumnos)</option>
        <?
			$ob_alumno = new MotorBusqueda();
			$ob_alumno ->ano = $ano;
			$ob_alumno ->cmb_curso = $c_curso;
			$ob_alumno ->rdb = $institucion;
			$result_alumno = $ob_alumno -> alumno($conn);
			
		for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
			$fila = @pg_fetch_array($result_alumno,$i);
			$rutalumno = $fila["rut_alumno"];
			if ($rutalumno == $c_alumno){
		?>
        <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>	><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
        <? }else{ ?>
        <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
        <?
	       }
		}
		?>
      </select>
    </span></td>
    <td><div align="center"></div></td>
  </tr>
 <!--
  <tr>
    <td colspan="2" class="textosimple">Tipo Reporte </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
		<input name="tipo_rep" type="radio" value="0" checked="checked">Tradicional
	   <br>
	  	<input name="tipo_rep" type="radio" value="5">	  	
	  	C/Promedio Anual<br></td>
    <td colspan="2">&nbsp;</td>
  </tr>-->
  <tr>
    <td class="textosimple">Opciones</td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
		
        <input name="opc_obs" type="checkbox" id="opc_obs" value="1" checked>Observaciones 
       
        <input name="Just_Asis" type="checkbox" id="Just_Asis" value="1" checked>
        Justifica Asistencia </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="opc_mprom" type="checkbox" id="opc_mprom" value="1" checked>
      Mostrar promedios</td>
    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="2" class="textosimple">Detalle Total Anotaciones </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="det_anot" type="radio" value="1" checked>
      Si 
        <input name="det_anot" type="radio" value="0">
        No </td>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td class="textosimple">Asignaturas</td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="rdASIGNATURA" type="radio" id="rdASIGNATURA" value="2" checked>
      Todas 
        <input type="radio" name="rdASIGNATURA" id="rdASIGNATURA" value="1">
        Incide en promocion</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">Estad&iacute;sticas</td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple" >
    <span class="medida"><input name="chk_totdp" type="checkbox" id="chk_totdp" value="1" checked>
      Total d&iacute;as Periodo</span> 
        <input name="chk_totdinas" type="checkbox" id="chk_totdinas" value="1" checked>
        Total d&iacute;as inasistentes</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"> <span class="medida"><input name="chk_prcas" type="checkbox" id="chk_prcas" value="1" checked>
      % Asistencia </span>
        <span class="medida"><input name="chk_totdat" type="checkbox" id="chk_totdat" value="1" checked>
        Total d&iacute;as atrasos </span>
        <span class="medida"><input name="chk_pasisano" type="checkbox" id="chk_pasisano" value="1" checked>
      % Asistencia Anual</span> </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
     <span class="medida"><input name="chk_anp" type="checkbox" id="chk_anp" value="1" checked>Anotaciones Positivas </span>
      <input name="chk_ann" type="checkbox" id="chk_ann" value="1" checked>
      Anotaciones Negativas
      <input name="chk_anr" type="checkbox" id="chk_anr" value="1" checked>
Anotaciones Responsabilidad</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">Sin Colilla</td>
    <td><input name="chkCOLILLA" type="checkbox" id="chkCOLILLA" value="1" checked="CHECKED"></td>
    <td width="90">Fecha</td>
    <td width="250"><input type="text" name="txtFECHA" id="txtFECHA" value="<?=date("d-m-Y");?>"></td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>

  
  
  
  
</table>	
	<table width="650" border="0" cellpadding="1" cellspacing="0">
     <!-- <tr>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
        <th scope="col">&nbsp;</th>
      </tr>-->
      <tr>
        <th width="512" scope="col"><div align="right">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="button" onClick="enviapag2(this.form)" class="botonXX"  id="cb_exp" value="Exportar">
        </div></th>
        <th width="52" scope="col"><div align="right">
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'">
        </div></th>
      </tr>
    </table></td>
  </tr>
</table>	</td>
  </tr>
  
</table>
</center>
</form>
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->								  </td>
                                </tr>
                              </table></td>
                          </tr>
                         
                         
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
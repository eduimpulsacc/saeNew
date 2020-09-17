<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');

$_POSP = 4;
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">

function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target="_parent";
		form.action = 'InformeNotasParciales_H.php';
		form.submit(true);
	}	
}


function enviapag2(form){
        if( form.c_curso.value!=0 || form.cmb_periodos.value!=0){
                form.target="_blank";
                document.form.action = 'printInformeNotasParciales_C.php?xls=1';
                document.form.submit(true);
        }
}
			
				
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
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
                                  <td><center>

<br>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<? //if($_PERFIL==0 && $institucion==25114){?>
	<form method "post" action="Print_InformeNotasParciales_H.php" name="form" target="_blank">
<? //}else{ ?>
	<!--<form method "post" action="printInformeNotasParciales_C.php" name="form" target="_blank">-->
<? //} ?>
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$result_curso = $ob_motor ->curso($conn);

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
  <tr>
    <td colspan="2" class="textosimple">Anexos</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
		<input type="checkbox" name="opc_Taller" value="1">C/Taller
		<input type="checkbox" name="opc_Anotacion" value="1">C/Anotaciones
		<input name="opc_Colilla" type="checkbox" value="1" checked>C/Colilla	</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Tipo Reporte </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
		<input name="tipo_rep" type="radio" value="0" checked="checked">Tradicional
	   <!-- <input name="tipo_rep" type="radio" value="1">C/Subsector Hijo-->
	  	<input name="tipo_rep" type="radio" value="2">C/ Promedio Curso	
	  	<input name="tipo_rep" type="radio" value="3">
	  	S/Promedio General 
	  	<input name="tipo_rep" type="radio" value="4">
	  	S/Promedio Final<br></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Opciones</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">
		<input name="opc_estadistica" type="checkbox" id="opc_estadistica" value="1" checked>Estadistica 
        <input name="opc_obs" type="checkbox" id="opc_obs" value="1" checked>Observaciones 
        <input name="txtOBS" type="text" value="3" size="2" maxlength="1">
        <input name="chk_prom_taller" type="checkbox" id="chk_prom_taller" value="1"> 
        S/Promedio Taller 
        <input name="Just_Asis" type="checkbox" id="Just_Asis" value="1" checked>
        Justifica Asistencia </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Tipo Evaluaci&oacute;n </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="tipo_eval" type="radio" value="0" checked="checked">Promedio &nbsp; <input name="tipo_eval" type="radio" value="1">
    Ponderación 
    <input name="tipo_eval" type="radio" value="2">
    Apreciaci&oacute;n</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Firmas </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">Espacio de firmas
      <input name="txtESPACIO" type="text" id="txtESPACIO" value="3" size="5" maxlength="2"> 
      Firma Apoderado 
      <input name="chk_apo" type="checkbox" id="chk_apo" value="1"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Alumnos</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="ck_alumnos" type="checkbox" id="ck_alumnos" value="1">
      Eximidos 
        <input name="ck_orden" type="radio" value="0">
        Ordenado N&ordm; Lista 
        <input name="ck_orden" type="radio" value="1" checked>
        Ordenado Alfabetico </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="textosimple">Subsector </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="rb_subsector" type="radio" value="0" checked>
      Validos 
        <input name="rb_subsector" type="radio" value="1">
        No validos </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">Fecha</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="txtFECHA" type="text" id="txtFECHA" value="<?=$fecha;?> " size="10"> 
      (dia-mes-a&ntilde;o) </td>
    <td>&nbsp;</td>
  </tr>
</table>	
	<table width="650" border="0" cellpadding="1" cellspacing="0">
      <tr>
        <th width="512" scope="col"><div align="right">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="button" onClick="enviapag2(this.form)" class="botonXX"  id="cb_exp" value="Exportar">
        </div></th>
        <th width="52" scope="col"><div align="right">
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
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
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
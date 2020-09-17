<?php require('../../../../../util/header.inc');
session_start();
require "mod_infespecial.php";
$obj_infespecial = new Infespecial(); 


	$rs_inf =  $obj_infespecial->traeReporte($conn,$idFicha);
	$fila_inf = pg_fetch_array($rs_inf,0);
	$rs_emp = $obj_infespecial->empleado1($conn,$fila_inf['rut_emp']);
	$nom_doc = pg_result($rs_emp,2)." ".pg_result($rs_emp,3)." ".pg_result($rs_emp,4);
	$rut_doc = pg_result($rs_emp,0)."-".pg_result($rs_emp,1);
	$cont_doc = pg_result($rs_emp,7)." / ".pg_result($rs_emp,5);
	$cargo_doc = pg_result($rs_emp,12);
	
	$rs_alu = $obj_infespecial->treaAlumno($conn,$fila_inf['rut_alumno']);
	$fila_alu = pg_fetch_array($rs_alu,0);
	
	$rs_ins = $obj_infespecial->inst($conn,$_INSTIT);
	$fila_ins = pg_fetch_array($rs_ins,0);
	 

?>
<style>
.tableindex{
background-color:#FABF90;
font-family:Arial, Helvetica, sans-serif;
font-weight:bold;
font-size:12px;

}
.textonegrita{
font-family:Arial, Helvetica, sans-serif;
font-weight:bold;
font-size:12px;

}
.textosimple{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
height:27px;
vertical-align:bottom;

}
.textosimple2{
font-family:Arial, Helvetica, sans-serif;
font-size:12px;

vertical-align:top;

}
@media all {
   div.saltopagina{
      display: none;
   }
}
@media print{
   div.saltopagina{ 
      display:block; 
      page-break-before:always;
   }
}
</style>
<body onLoad="window.print();">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="650"  border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse" align="center" cellspacing="0">
  <tr>
    <td><?php include('cabecera.php'); ?><br>
<br>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
   
  <tr>
    <td colspan="4" ><table width="100%"  border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr  class="tableindex">
     <td colspan="5">IDENTIFICACI&Oacute;N DEL ESTUDIANTE</td>
   </tr>
      <tr>
        <td height="27" colspan="4" valign="bottom"  class="textosimple"><?php echo $fila_alu['nombre_alu'] ?> <?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?></td>
        <td  class="textosimple"><?php echo $fila_alu['rut_alumno'] ?>-<?php echo $fila_alu['dig_rut'] ?></td>
      </tr>
      <tr >
        <td colspan="4" class="textonegrita">Nombre</td>
        <td width="23%" class="textonegrita">Rut</td>
      </tr>
     <tr class="textosimple">
        <td width="20%" ><?php echo CambioFD($fila_alu['fecha_nac']) ?></td>
        <td width="8%" align="center"><?php echo CalcularEdad($fila_alu['fecha_nac']) ?></td>
        <td width="34%"><?=CursoPalabra($fila_inf['id_curso'],0,$conn)?></td>
        <td width="15%" colspan="2"><?php echo $fila_ins['nombre_instit'] ?></td>
        </tr>
      <tr class="textonegrita">
        <td width="20%">Fecha Nacimiento</td>
        <td width="8%">Edad</td>
        <td width="34%">Curso / Nivel</td>
        <td colspan="2">Establecimiento</td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  
  <tr>
    <td colspan="4" ><table width="100%"  border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr  class="tableindex">
    <td colspan="4">IDENTIFICACI&Oacute;N DEL PROFESIONAL DEL ESTABLECIMIENTO ESCOLAR QUE ENTREGA LA INFORMACI&Oacute;N</td>
    </tr>
      <tr class="textosimple">
        <td colspan="2"><?php echo  $nom_doc ?></td>
        <td width="33%"><?php echo  $rut_doc ?></td>
      </tr>
      <tr class="textonegrita">
        <td colspan="2">Nombre</td>
        <td width="33%">Rut</td>
      </tr>
     <tr class="textosimple">
        <td width="35%"><?php echo  $cargo_doc ?></td>
        <td width="33%"><?php echo  $cont_doc ?></td>
        <td width="33%"><?php echo cambioFD($fila_inf['fecha_entrega']) ?></td>
      </tr>
      <tr class="textonegrita">
        <td width="35%">Rol/cargo</td>
        <td width="33%">Tel&eacute;fono / E-mail de contacto</td>
        <td width="33%">Fecha Entrega del Informe</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
   
  <tr>
    <td colspan="4"><table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr  class="tableindex">
    <td colspan="4">IDENTIFICACI&Oacute;N DE LA PERSONA QUE RECIBE LA INFORMACI&Oacute;N</td>
    </tr>
            <tr class="textosimple">
        <td colspan="2"><?php echo $fila_inf['nombre_recibe'] ?>&nbsp;</td>
        <td width="24%"><?php echo $fila_inf['rut_recibe'] ?>-<?php echo $fila_inf['digrut_recibe'] ?></td>
        </tr>
      <tr class="textonegrita">
        <td colspan="2">Nombre</td>
        <td>Rut</td>
        </tr>
      <tr class="textosimple">
        <td width="33%"><?php echo $fila_inf['relacion_recibe'] ?></td>
        <td colspan="2"><?php echo $fila_inf['interprete_recibe'] ?></td>
        </tr>
      <tr class="textonegrita">
        <td>Relaci&oacute;n con el/la estudiante</td>
        <td colspan="2">En presencia de (miembro de la familia, int&eacute;prete, otro/a)</td>
        </tr>
     
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
   
  <tr>
    <td colspan="4">
    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <tr  class="tableindex">
    <td colspan="4">RESULTADOS DE LA EVALUACI&Oacute;N</td>
    </tr>
    <tr>
    <td colspan="4" bgcolor="#FDE9D9" class="textonegrita">MOTIVO DE LA EVALUACI&Oacute;N&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo ($fila_inf['tipo_evaluacion']==1)?"<b>X</b>":"&nbsp;"; ?>
      de Ingreso &nbsp;&nbsp;&nbsp;
      <?php echo ($fila_inf['tipo_evaluacion']==2)?"<b>X</b>":"&nbsp;"; ?>
      Reevaluaci&oacute;n</td>
    </tr>
  <tr>
    <td height="100" colspan="4" valign="top" class="textosimple2"><?php echo $fila_inf['motivo_evaluacion'] ?></td>
    </tr>
    </table>
    </td>
    </tr>
  <tr valign="top" >
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr valign="top" class="tableindex">
    <td colspan="4" style="border:#000 1px solid">DIAGN&Oacute;STICO</td>
    </tr>
  <tr>
    <td height="100" colspan="4" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['diagnostico'] ?></td>
    </tr>
  <tr>
    <td colspan="4"> <div class="saltopagina">
    <?php include('cabecera.php'); ?>
    </div>&nbsp;</td>
    </tr>
   
    <td colspan="4" ><table width="100%" border="0" cellspacing="0" >
    <tr  class="tableindex">
    <td colspan="4"  style="border:1px #000000 solid">FORTALEZAS Y NECESIDADES DE APOYO EN CADA &Aacute;MBITO</td>
    </tr>
    <tr>
      <tr >
        <td colspan="2" class="tableindex" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid">AMBITO ACADEMICO</td>
        </tr>
      <tr  class="textonegrita" bgcolor="#FDE9D9" >
        <td width="50%" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid">FORTALEZAS</td>
        <td style=" border-bottom:1px #000 solid; border-right:1px #000 solid; ">NECESIDADES DE APOYO</td>
      </tr>
      <tr class="textosimple">
        <td height="100" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid" ><?php echo $fila_inf['academico_fortaleza'] ?></td>
        <td valign="top" class="textosimple2" style=" border-bottom:1px #000 solid;  border-right:1px #000 solid"><?php echo $fila_inf['academico_necesidad'] ?></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;
   
    </td>
    </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0"  >
      <tr class="tableindex">
        <td colspan="2" style=" border:1px #000 solid">&Aacute;MBITO SOCIAL/AFCTIVO</td>
      </tr>
      <tr  class="textonegrita" bgcolor="#FDE9D9">
        <td width="50%" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid">FORTALEZAS</td>
        <td style=" border-bottom:1px #000 solid;  border-right:1px #000 solid">NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td height="100" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['social_fortaleza'] ?></td>
        <td valign="top" class="textosimple2" style=" border-bottom:1px #000 solid;  border-right:1px #000 solid"><?php echo $fila_inf['social_necesidad'] ?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4"><table width="100%" border="0" cellspacing="0">
      <tr class="tableindex">
        <td colspan="2" style="border:1px #000000 solid">&Aacute;MBITO DE LA SALUD</td>
      </tr>
      <tr  class="textonegrita" bgcolor="#FDE9D9">
        <td width="50%" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid">FORTALEZAS</td>
        <td style=" border-bottom:1px #000 solid;  border-right:1px #000 solid">NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td height="100" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['salud_fortaleza'] ?></td>
        <td height="100" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid;  border-right:1px #000 solid"><?php echo $fila_inf['salud_necesidad'] ?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr  class="tableindex">
    <td colspan="4" style="border:1px #000000 solid">APOYOS EDUCATIVOS QUE DAR&Aacute; LA ESCUELA AL ESTUDIANTE (En  sala de clases, en sala de recursos, en la participaci&oacute;n de la comundad educativa)</td>
    </tr>
  <tr valign="top">
    <td height="100" colspan="4" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['apoyo_hogar'] ?></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
   <tr  class="tableindex">
    <td colspan="4" style="border:1px #000000 solid">DESCRIPCI&Oacute;N DE LOS APOYOS QUE EL ALUMNO O ALUMNA REQUIERE RECIBIR EN EL HOGAR (refuerzo escolar, apoyo afectivo, desarrollo de h&aacute;bitos, actitud y compromiso de participaci&oacute;n)</td>
    </tr>
  <tr>
    <td height="100" colspan="4" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['descrip_apoyo'] ?></td>
    </tr>
  <tr>
    <td colspan="4"> <div class="saltopagina">
    <?php include('cabecera.php'); ?>
    </div>&nbsp;</td>
    </tr>
  <tr >
    <td colspan="4"  class="tableindex" style="border:1px #000000 solid">NECESIDADES DE APOYO QUE REQUIERE LA FAMILIA PARA PODER CUMPLIR CON LOS APOYOS EN EL HOGAR</td>
    </tr>
  <tr>
    <td height="100" colspan="4" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['necesidad_apoyo'] ?></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
   <tr  class="tableindex">
    <td colspan="4" style="border:1px #000000 solid">ACUERDOS Y COMPROMISOS DE LA ESCUELA Y DE LA FAMILIA</td>
    </tr>
  <tr>
    <td height="100" colspan="4" valign="top" class="textosimple2" style=" border-bottom:1px #000 solid; border-left:1px #000 solid; border-right:1px #000 solid"><?php echo $fila_inf['acuerdo'] ?></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
 
  <tr>
    <td width="73%" bgcolor="#FDE9D9"  class="textonegrita" style="border:1px #000000 solid">FECHA EN QUE SE EVALUAR&Aacute;N LOS AVANCES Y LOGROS      </td>
    <td width="100" align="center" style="vertical-align:middle ; border-bottom:1px #000 solid; border-top:1px #000 solid; border-right:1px #000 solid"  class="textosimple" ><?php echo cambioFD($fila_inf['prox_evaluacion']) ?></td>
    <td width="100" align="center" style="vertical-align:middle ; border-bottom:1px #000 solid; border-top:1px #000 solid; border-right:1px #000 solid" class="textonegrita">&nbsp;</td>
    <td width="100" align="center"  style="vertical-align:middle ; border-bottom:1px #000 solid; border-top:1px #000 solid; border-right:1px #000 solid" class="textonegrita">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" >&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" ><table width="100%" border="0" cellspacing="0">
      <tr>
        <td width="50%" height="100" align="center" valign="bottom">_______________________________</td>
        <td align="center" valign="bottom">_______________________________</td>
      </tr>
      <tr class="textonegrita">
        <td align="center">Firma y timbre representante<br>
          del establecimiento educativo</td>
        <td align="center">Firma Familiar o representante<br>
          del estiduante</td>
      </tr>
    </table></td>
    </tr>
</table>
  </body>
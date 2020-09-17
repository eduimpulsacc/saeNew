<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$ramo			=$sel_ramo;
	$reporte		=$c_reporte;
	$total          =$anual;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$Curso_pal = CursoPalabra($curso, 6, $conn);

$ob_reporte ->curso = $curso;
$ob_reporte ->ano = $ano;
$ob_config = new Reporte();
$ob_config->id_item=$reporte;
$ob_config->institucion=$institucion;
$ob_config->curso=$curso;
$rs_config = $ob_config->ConfiguraReporte($conn);
$fila_config = @pg_fetch_array($rs_config,0);
$ob_config->CambiaDatoReporte($fila_config);


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);
$ob_reporte->ano = $ano;
$ob_reporte->retirado = 0;
$ob_reporte->curso = $curso;

$ob_membrete->ano = $ano;
$ob_membrete->AnoEscolar($conn);

if($alumno==0){
	$rs_alumno = $ob_reporte->FichaAlumnoTodos($conn);
}else{
	$ob_reporte->alumno = $alumno;
	$rs_alumno = $ob_reporte->FichaAlumnoUno($conn);
}

?><STYLE>
body{
	font-size:11px}
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 } 
.item strong {
	font-style: italic;
}
.c {
	text-align: center;
}
.letra_chica
{
font-family:Arial, Helvetica, sans-serif;
font-size:8px;
font-weight:bold;
}
</STYLE>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<div id="capa0">
<table width="850" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" /></td>
  </tr>
</table>
</div>
<? for($i=0;$i<@pg_numrows($rs_alumno);$i++){ 
$fila_alu = pg_fetch_array($rs_alumno,$i);
$ob_reporte->CambiaDato($fila_alu);

$fenac =explode("-",$fila_alu['fecha_nac']);

?>

<table width="850" border="0" align="center" cellspacing="0">
  <tr>
    <td width="850">

<table width="850" border="0" align="center" cellspacing="0">
  <tr>
    <td width="850"><table width="850" border="0" cellspacing="0">
      <tr>
        <td width="133" rowspan="2">
       <? if($institucion!=""){
			echo "<img src='../../../../../../tmp/".$institucion."insignia". "' alt='70' width='75' >";
		}else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
		}	?>
        </td>
        <td colspan="2" class="textosimple"><?php echo $ob_membrete->ins_pal; ?></td>
        <td colspan="2" align="right" class="textonegrita">CURSO
          <span style="border:1px #000000 solid; width:80px">&nbsp;<?php echo $Curso_pal ?>&nbsp;</span></td>
      </tr>
      <tr>
        <td colspan="2" class="textosimple"><?php echo $ob_membrete->comuna;?></td>
        <td colspan="2" align="right" class="textonegrita">N&ordm; LISTA
          <span style="border:1px #000000 solid; width:80px">&nbsp;<?=$ob_reporte->nro_lista;?>&nbsp;</span></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td colspan="2" align="center" style="font-size:33px; text-decoration:underline;" class="textonegrita"><i>FICHA FAMILIAR <?=($ob_membrete->nro_ano);?></i></td>
        <td width="96" rowspan="2" align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="textonegrita">COMPLETAR CON LETRA DE IMPRENTA MAY&Uacute;SCULA Y MARQUE CON UNA X DONDE CORRESPONDA</td>
        <td width="100" rowspan="2" align="center" valign="middle"  class="textonegrita"><div style="border:1px #000000 solid; width:100px; height:120px; text-align:center;">
          <?php if (!is_file("../../../../../../infousuario/images/".$ob_reporte->alumno)){echo "<br /><br /><br />FOTO";} 
		else {?>
          <br /><img src="../../../../../../infousuario/images/<?php echo $ob_reporte->alumno ?>" width="80" height="90" />
          <?php }?></div></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table>
    <br>
<br>
<table width="850" border="0" cellspacing="0"  class="textosimple" >
  <tr>
    <td width="228" height="30"  class="textosimple"><strong>1.-<u>DATOS DEL ALUMNO</u> </strong></td>
    <td width="618" align="right">RUT <span style="border:1px #000000 solid; width:120px">&nbsp;<?php echo $ob_reporte->alumno ?>&nbsp;</span> - <span style="border:1px #000000 solid; width:80px">&nbsp;<?php echo $ob_reporte->ddv ?>&nbsp;</span></td>
    </tr>
  <tr>
    <td colspan="2"><table width="850" border="0" cellspacing="0"  class="textosimple">
      <tr>
        <td align="center" style="border:1px #000 solid"><?php echo strtoupper($ob_reporte->ape_pat) ?>&nbsp;</td>
        <td align="center" style="border:1px #000 solid"><?php echo strtoupper($ob_reporte->ape_mat) ?>&nbsp;</td>
        <td align="center" style="border:1px #000 solid"><?php echo strtoupper($ob_reporte->nombre) ?>&nbsp;</td>
      </tr>
      <tr class="letra_chica">
        <td align="center" valign="top" class="letra_chica">Apellido Paterno</td>
        <td align="center" valign="top">Apellido Materno</td>
        <td align="center" valign="top">Nombres</td>
      </tr>
      </table></td>
    </tr>
  <tr>
    <td colspan="2">
    <table width="850" border="0" cellpadding="0" cellspacing="0"  class="textosimple">
      <tr>
        <td width="94"  class="textosimple"><strong>Domicilio:</strong></td>
        <td width="285" align="center" style="border:1px #000 solid"><?php echo $fila_alu['calle'] ?></td>
        <td width="159" align="center" style="border:1px #000 solid"><?php echo $fila_alu['nro'] ?></td>
        <td width="154" align="center" style="border:1px #000 solid"><?php echo $fila_alu['villa'] ?></td>
        <td width="148" align="center" style="border:1px #000 solid"><?=$ob_reporte->comuna;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" class="letra_chica">Calle</td>
        <td align="center" class="letra_chica">N&ordm;</td>
        <td align="center" class="letra_chica">Sector</td>
        <td align="center" class="letra_chica">Comuna</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"  height="30">
    <table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="65"><strong>Tel.Fijo</strong></td>
        <td width="140" style="border:1px #000 solid"><?php echo $fila_alu['telefono'] ?></td>
        <td width="59" class="textosimple">&nbsp;<strong>Celular</strong></td>
        <td width="140"  style="border:1px #000 solid">&nbsp;</td>
        <td width="54" class="textosimple"><strong>&nbsp;E-Mail</strong></td>
        <td width="380"  style="border:1px #000 solid"><?php echo $fila_alu['email'] ?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"  height="30">
    <table width="850" border="0" cellspacing="0"  class="textosimple">
      <tr>
        <td width="165"><strong>Fecha de Nacimiento</strong></td>
        <td width="180" rowspan="2"><table width="180" border="0" cellspacing="0"  class="textosimple">
          <tr>
            <td align="center" style="border:1px #000 solid">&nbsp;<?php echo $fenac[2] ?>&nbsp;</td>
            <td align="center" style="border:1px #000 solid">&nbsp;<?php echo $fenac[1] ?>&nbsp;</td>
            <td align="center" style="border:1px #000 solid">&nbsp;<?php echo $fenac[0] ?>&nbsp;</td>
          </tr>
          <tr class="letra_chica">
            <td align="center">D&iacute;a</td>
            <td align="center">Mes</td>
            <td align="center">A&ntilde;o</td>
          </tr>
        </table></td>
        <td width="278" align="right"><strong>&iquest;Con qu&iacute;en vive?</strong></td>
        <td width="219" style="border:1px #000 solid"><?php echo $fila_alu['con_quien_vive'] ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"><table width="850" border="0" cellspacing="0"  class="textosimple">
      <tr>
        <td width="145"><strong>Enfermedad o alergia</strong></td>
        <td width="301" style="border:1px #000 solid"><?php echo $fila_alu['alergia'] ?></td>
        <td width="147"><strong>&nbsp;Medicamento que usa</strong></td>
        <td width="249" style="border:1px #000 solid"><?php echo $fila_alu['medicamento'] ?></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"  height="30"><table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="205"><strong>Medicamentos Contraindicados </strong></td>
        <td width="641" style="border:1px #000 solid">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="240"><strong>&iquest;Realiza alg&uacute;n trabajo remunerado?</strong></td>
        <td width="39" align="center" style="border:1px #000 solid"><strong>SI</strong></td>
        <td width="40" align="center" style="border:1px #000 solid"><strong>NO</strong></td>
        <td width="109"><strong>&nbsp;&iquest;En qu&eacute; lugar?</strong></td>
        <td width="165" style="border:1px #000 solid">&nbsp;</td>
        <td width="119"><strong>&nbsp;&iquest;En qu&eacute; horario?</strong></td>
        <td width="126"  style="border:1px #000 solid">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
<!--tabla madre-->
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_madre = $ob_reporte->Madre($conn);
	$fila_madre = pg_fetch_array($rs_madre,0);
	
	$fnam = explode("-",$fila_madre['fecha_nac']);
	
?>
<table width="850" border="0" cellspacing="0"  class="textosimple">
<tr>
    <td width="228" height="30"><strong>2.-<u>DATOS DE LA MADRE</u> </strong></td>
    <td width="618" align="right">RUT  <span style="border:1px #000000 solid; width:120px">&nbsp;<?php echo $fila_madre['rut_apo'] ?>&nbsp;</span> - <span style="border:1px #000000 solid; width:80px">&nbsp;<?php echo $fila_madre['dig_rut'] ?>&nbsp;</span></td>
    </tr>
    <tr>
    <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_madre['ape_pat'] ?>&nbsp;</td>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_madre['ape_mat'] ?></td>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_madre['nombre_apo'] ?></td>
      </tr>
      <tr class="letra_chica">
        <td align="center">Apellido Paterno</td>
        <td align="center">Apellido Materno</td>
        <td align="center">Nombres</td>
      </tr>
      </table></td>
    </tr>
    <tr>
    <td colspan="2">
    <table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="104" ><strong>Fecha de Nac</strong></td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnam[2] ?>&nbsp;</td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnam[1] ?>&nbsp;</td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnam[0] ?>&nbsp;</td>
        <td width="74"><strong>&nbsp;E. B&aacute;sica</strong></td>
        <td width="46" style="border:1px #000 solid">&nbsp;</td>
        <td width="78"><strong>&nbsp;E. Media</strong></td>
        <td width="46" style="border:1px #000 solid">&nbsp;</td>
        <td width="76"><strong>E. Superior</strong></td>
        <td width="62" style="border:1px #000 solid">&nbsp;</td>
        <td width="109"><strong>T&iacute;tulo o Profesi&oacute;n</strong></td>
        <td width="144" style="border:1px #000 solid"><?php echo $fila_madre['profesion'] ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" class="letra_chica">D&iacute;a</td>
        <td align="center" class="letra_chica">Mes</td>
        <td align="center" class="letra_chica">A&ntilde;o</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
   	 </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="121"><strong>Actividad Actual</strong></td>
          <td width="274"  style="border:1px #000 solid">&nbsp;</td>
          <td width="119"><strong>&nbsp;Lugar de trabajo</strong></td>
          <td width="328"  style="border:1px #000 solid"><?php echo $fila_madre['lugar_trabajo'] ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="15%"><strong>Tel&eacute;fono casa</strong></td>
          <td width="15%" style="border:1px #000 solid"><?php echo $fila_madre['telefono'] ?></td>
          <td width="15%"><strong>&nbsp;Tel&eacute;fono Trabajo</strong></td>
          <td width="15%" style="border:1px #000 solid"><?php echo $fila_madre['fono_pega'] ?></td>
          <td width="15%"><strong>&nbsp;Celular</strong></td>
          <td width="15%" style="border:1px #000 solid">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="171"><strong>&iquest;Ex alumno de JCB?</strong></td>
          <td width="29" align="center" style="border:1px #000 solid"><strong>SI</strong></td>
          <td width="29" align="center" style="border:1px #000 solid"><strong>NO</strong></td>
          <td width="89" align="right"><strong>E-mail&nbsp;</strong></td>
          <td width="488"  style="border:1px #000 solid"><?php echo $fila_madre['email'] ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="210"><strong>&iquest;Padece alguna enfermedad?</strong></td>
          <td width="29" align="center" style="border:1px #000 solid"><strong>SI</strong></td>
          <td width="29" align="center" style="border:1px #000 solid"><strong>NO</strong></td>
          <td width="89" align="right"><strong>&iquest;C&uacute;al?&nbsp;</strong></td>
          <td width="488"  style="border:1px #000 solid">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
</table><br>
<br>
<br>
<? 	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable = 0;
	$rs_padre = $ob_reporte->Padre($conn);
	$fila_padre = pg_fetch_array($rs_padre,0);
	$fnap = explode("-",$fila_padre['fecha_nac']);
	
?>
<table width="850" border="0" cellspacing="0"  class="textosimple">
<tr>
    <td width="228" height="30"><strong>3.-<u>DATOS DEL PADRE</u> </strong></td>
    <td width="618" align="right">RUT <span style="border:1px #000000 solid; width:120px">&nbsp;<?php echo $fila_padre['rut_apo'] ?>&nbsp;</span> - <span style="border:1px #000000 solid; width:80px">&nbsp;<?php echo $fila_padre['dig_rut'] ?>&nbsp;</span></td>
    </tr>
    <tr>
    <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_padre['ape_pat'] ?>&nbsp;</td>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_padre['ape_mat'] ?></td>
        <td width="33%" align="center" style="border:1px #000 solid"><?php echo $fila_padre['nombre_apo'] ?></td>
      </tr>
      <tr class="letra_chica">
        <td align="center">Apellido Paterno</td>
        <td align="center">Apellido Materno</td>
        <td align="center">Nombres</td>
      </tr>
      </table></td>
    </tr>
    <tr>
    <td colspan="2">
    <table width="850" border="0" cellspacing="0" class="textosimple">
      <tr>
        <td width="104" >Fecha de Nac</td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnap[2] ?>&nbsp;</td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnap[1] ?>&nbsp;</td>
        <td width="29" align="center" style="border:1px #000 solid">&nbsp;<?php echo $fnap[0] ?>&nbsp;</td>
        <td width="74">&nbsp;E. B&aacute;sica</td>
        <td width="46" style="border:1px #000 solid">&nbsp;</td>
        <td width="78">&nbsp;E. Media</td>
        <td width="46" style="border:1px #000 solid">&nbsp;</td>
        <td width="76">E. Superior</td>
        <td width="62" style="border:1px #000 solid">&nbsp;</td>
        <td width="109">T&iacute;tulo o Profesi&oacute;n</td>
        <td width="144" style="border:1px #000 solid"><?php echo $fila_padre['profesion'] ?></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center" class="letra_chica">D&iacute;a</td>
        <td align="center" class="letra_chica">Mes</td>
        <td align="center" class="letra_chica">A&ntilde;o</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    </table></td>
   	 </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="121">Actividad Actual</td>
          <td width="274"  style="border:1px #000 solid">&nbsp;</td>
          <td width="119">&nbsp;Lugar de trabajo</td>
          <td width="328"  style="border:1px #000 solid"><?php echo $fila_padre['lugar_trabajo'] ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="15%">Tel&eacute;fono casa</td>
          <td width="15%" style="border:1px #000 solid"><?php echo $fila_padre['telefono'] ?></td>
          <td width="15%">&nbsp;Tel&eacute;fono Trabajo</td>
          <td width="15%" style="border:1px #000 solid"><?php echo $fila_padre['fono_pega'] ?></td>
          <td width="15%">&nbsp;Celular</td>
          <td width="15%" style="border:1px #000 solid"><?php echo $fila_padre['celular'] ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="171">&iquest;Ex alumno de JCB?</td>
          <td width="29" align="center" style="border:1px #000 solid">SI</td>
          <td width="29" align="center"  style="border:1px #000 solid">NO</td>
          <td width="89" align="right">E-mail&nbsp;</td>
          <td width="488"  style="border:1px #000 solid"><?php echo $fila_padre['email'] ?></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><table width="850" border="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="210">&iquest;Padece alguna enfermedad?</td>
          <td width="29" align="center" style="border:1px #000 solid">SI</td>
          <td width="29" align="center" style="border:1px #000 solid">NO</td>
          <td width="89" align="right">&iquest;C&uacute;al?&nbsp;</td>
          <td width="488"  style="border:1px #000 solid">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
</table>
</td></tr></table>
<?php if(pg_numrows($rs_alumno)>1){?>
<H1 class="SaltoDePagina"></H1>
<?php }?>

<?php }?>
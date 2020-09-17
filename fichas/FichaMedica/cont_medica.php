<?php 
	require('../../util/header.inc');
	require("mod_medica.php");

	$ob_reporte = new Medica();
	
	$funcion =$_POST['funcion'];

if($funcion==1){
	$rs_institucion = $ob_reporte->Institucion($conn,$_INSTIT);
	$rs_alumno = $ob_reporte->Alumno($conn,$_ALUMNO);
	$rs_listado = $ob_reporte->Listado($conn,$_ALUMNO);
	?>
<table width="85%" border="0" align="center">
  <tr>
    <td width="18%" class="textonegrita">INSTITUCION</td>
    <td width="54%" class="textosimple">&nbsp;<?=pg_result($rs_institucion,0);?></td>
    <td width="28%" rowspan="5" align="right" class="textonegrita">&nbsp;<img src="../../admin/institucion/ano/fichas/medicas/enfermeria_alumno.png"></td>
  </tr>
  <tr>
    <td class="textonegrita">ALUMNO</td>
    <td class="textosimple">&nbsp;<?=pg_result($rs_alumno,1);?></td>
  </tr>
  <tr>
    <td align="justify" class="textonegrita">RUT ALUMNO&nbsp;</td>
    <td align="justify" class="textosimple">&nbsp;<?=$_ALUMNO."-".pg_result($rs_alumno,0);?></td>
  </tr>
  <tr>
    <td align="justify" class="textonegrita">CURSO</td>
    <td align="justify" class="textosimple">&nbsp;<? echo CursoPalabra($_CURSO,0,$conn);?></td>
  </tr>
  <tr>
    <td align="justify" class="textosimple">&nbsp;</td>
    <td align="justify" class="textosimple">&nbsp;</td>
  </tr>
</table>
<p><br />
</p>
<table width="85%" border="0" align="center" class="tableindexredondo">
  <tr>
    <td>&nbsp;REGISTRO DE SALUD DEL ALUMNO </td>
  </tr>
</table>
<br />
<table width="85%" border="0" align="center" cellspacing="3">
  <tr class="tableindexredondo">
    <td>&nbsp;ULTIMA ACTUALIZACION</td>
    <td>USUARIO ACTUALIZACION</td>
    <td>OPCIONES</td>
  </tr>
  
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
	
		if(($i % 2)==0){
			$class="detalleon";	
		}else{
			$class="detalleoff";
		}
  ?>
  <tr>
    <td class="<?=$class;?>">&nbsp;<?=impF($fila['fecha']);?></td>
    <td class="<?=$class;?>">&nbsp;</td>
    <td align="center" class="<?=$class;?>"><DIV align="center"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" onclick="Modifica(<?=$fila['id_ficha'];?>)" /></a></DIV></td>
  </tr>
  <? } ?>
</table>

	
<?
}

if($funcion==2){
	$rs_alumno = $ob_reporte->Alumno($conn,$_ALUMNO);
	$rs_ano = $ob_reporte->AnoEscolar($conn,$_ANO);
	$rs_ficha = $ob_reporte->Ficha($conn,$ficha);
		$fila_ficha = pg_fetch_array($rs_ficha,0);
	$rs_fichacompleta = $ob_reporte->FichaCompleta($conn,$_ALUMNO);
		$fila= pg_fetch_array($rs_fichacompleta,0);
?>
<table width="85%" border="0" align="center">
  <tr>
    <td width="21%" class="textonegrita">A&Ntilde;O ESCOLAR</td>
    <td width="79%" class="textosimple">&nbsp;<?=pg_result($rs_ano,0);?></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;NOMBRE ALUMNO</td>
    <td class="textosimple">&nbsp;<?=pg_result($rs_alumno,1);?></td>
  </tr>
</table><br />
<table width="85%" border="0" align="center">
  <tr>
    <td align="right">&nbsp;<input name="VOLVER" type="button" value="VOLVER"  class="botonXX" onclick="inicio();"/></td>
  </tr>
</table><br />
<table width="85%" border="0" align="center">
  <tr>
    <td colspan="2" class="tableindexredondo">REGISTR0 DE SALUD DEL ALUMNO</td>
  </tr>
  <tr>
    <td width="21%" class="detalleon">FECHA</td>
    <td width="79%" class="detalleoff">&nbsp;<?=impF($fila_ficha['fecha']);?></td>
  </tr>
  <tr>
    <td class="detalleon">HORA</td>
    <td class="detalleoff">&nbsp;<?=$fila_ficha['hora'];?></td>
  </tr>
  <tr>
    <td class="detalleon">OBSERVACIONES</td>
    <td class="detalleoff">&nbsp;<?=$fila_ficha['observaciones'];?></td>
  </tr>
</table><br />
<table width="85%" border="0" align="center">
  <tr>
    <td class="tableindexredondo">&nbsp;INFORMACION GENERAL</td>
  </tr>
</table><br />
<table width="85%" border="0" align="center" cellspacing="3">
  <tr>
    <td colspan="6" class="titulos-respaldo">OFTALMOLOG&Iacute;A</td>
  </tr>
  <tr>
    <td class="detalleon">ALTA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_alta']==1)?"SI":"NO";?></td>
    <td class="detalleon">EN ESTUDIO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_en_estudio']==1)?"SI":"NO";?></td>
    <td class="detalleon">HIPERMETROPIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_hipermetropia']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">MIOPIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_miopia']==1)?"SI":"NO";?></td>
    <td class="detalleon">ASTIGMATISMO MIOPE</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_astigmatismo_miope']==1)?"SI":"NO";?></td>
    <td class="detalleon">ASTIGMATISMO HIPERMETROPE</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_astigmatismo_hipermetrope']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">ASTIGMATISMO MIXTO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_astigmatismo_mixto']==1)?"SI":"NO";?></td>
    <td class="detalleon">ASTIGMATISMO MIOPITO COMP</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_astigmatismo_miopito_comp']==1)?"SI":"NO";?></td>
    <td class="detalleon">ASTIGMATISMO HIPERMETRIA COMP</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_astigmatismo_hipermetria_c']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">ANISOMETROPIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_anisometropia']==1)?"SI":"NO";?></td>
    <td class="detalleon">ESTRABISMO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_estrabismo']==1)?"SI":"NO";?></td>
    <td class="detalleon">INFLUENCIA CONVENGENCIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_influencia_convergencia']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">OTRO</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['of_otros_desc']);?></td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">INDICACIONES</td>
  </tr>
  <tr>
    <td class="detalleon">LENTES PRIMERA VEZ</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_lentes_primera_vez']==1)?"SI":"NO";?></td>
    <td class="detalleon">CAMBIAR LENTES</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_cambiar_lentes']==1)?"SI":"NO";?></td>
    <td class="detalleon">MANTENER LENTES</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_mantener_lentes']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">ESTUDIO ESTRABISMO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_estudio_estrabismo']==1)?"SI":"NO";?></td>
    <td class="detalleon">EJERCICIOS OPTICOS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_ejercicios_opticos']==1)?"SI":"NO";?></td>
    <td class="detalleon">CIRUGIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['of_cirugia']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['of_otros_desc_indic']);?></td>
  </tr>
  <tr>
    <td colspan="6"><hr width="80%" color="black" /></td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">OTORRINO</td>
  </tr>
  <tr>
    <td class="detalleon">ALTA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_alta']==1)?"SI":"NO";?></td>
    <td class="detalleon">EN ESTUDIO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_en_estudio']==1)?"SI":"NO";?></td>
    <td class="detalleon">AGENESIA PABELLON</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_agenesia_pabellon']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">CERUMEN IMPACTADO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_cerumen_impactado']==1)?"SI":"NO";?></td>
    <td class="detalleon">MUCOSIS TIMPANICA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_mucosis_timpanica']==1)?"SI":"NO";?></td>
    <td class="detalleon">HIPOACUSIA NEUROSENSORIAL</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['ot_hipoacusia_neurosensorial']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['ot_otros_desc']);?></td>
  </tr>
  
   <tr>
    <td colspan="6" class="titulos-respaldo">INDICACIONES</td>
  </tr>
   <tr>
     <td class="detalleon">AUDIOMETRIA</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_audiometria']==1)?"SI":"NO";?></td>
     <td class="detalleon">IMPEDANCIOMETRIA</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_impedanciometria']==1)?"SI":"NO";?></td>
     <td class="detalleon">RADIOGRAFIA</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_radiografia']==1)?"SI":"NO";?></td>
   </tr>
   <tr>
     <td class="detalleon">MEDICAMENTO</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_medicamento']==1)?"SI":"NO";?></td>
     <td class="detalleon">AUDIFONO</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_audifono']==1)?"SI":"NO";?></td>
     <td class="detalleon">CIRUGIA</td>
     <td class="detalleoff">&nbsp;<? echo ($fila['ot_cirugia']==1)?"SI":"NO";?></td>
   </tr>
   <tr>
     <td class="detalleon">OTROS</td>
     <td colspan="5">&nbsp;<?php echo nl2br($fila['ot_otros_desc_indic']);?></td>
   </tr>
   <tr>
     <td colspan="6"><hr width="80%" color="black" /></td>
   </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">ORTOPEDIA</td>
  </tr>
  <tr>
    <td class="detalleon">ALTA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_alta']==1)?"SI":"NO";?></td>
    <td class="detalleon">EN ESTUDIO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_en_estudio']==1)?"SI":"NO";?></td>
    <td class="detalleon">PIE PLANO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_pie_plano']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">GENU VALGO/VARO</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_genu_valgo_varo']==1)?"SI":"NO";?></td>
    <td class="detalleon">DEFORM. ADQUIR. DEDOS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_deform_adquir_dedos']==1)?"SI":"NO";?></td>
    <td class="detalleon">ESCOLIOSIS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_escoliosis']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['or_otros_desc']);?></td>
  </tr>
  
  <tr>
    <td colspan="6" class="titulos-respaldo">INDICACIONES</td>
  </tr>
  <tr>
    <td class="detalleon">CAMBIAR PLANTILLAS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_cambiar_plantillas']==1)?"SI":"NO";?></td>
    <td class="detalleon">MANTENER PLANTILLAS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_mantener_plantillas']==1)?"SI":"NO";?></td>
    <td class="detalleon">KINESIOTERAPIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_kinesiterapia']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">RX EXTREM. INFERIORES</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_rx_extrem_inferiores']==1)?"SI":"NO";?></td>
    <td class="detalleon">RX COLUMNA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_rx_columna']==1)?"SI":"NO";?></td>
    <td class="detalleon">CORSE</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_corse']==1)?"SI":"NO";?></td>
  </tr>
  <tr>
    <td class="detalleon">CIRUGIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['or_cirugia']==1)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['or_otros_desc_indic']);?></td>
  </tr>
  <tr>
    <td colspan="6"><hr width="80%" color="black" /></td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">&nbsp;OBSERVACIONES GENERALES</td>
  </tr>
  <tr>
    <td class="detalleon">ACCIDENTES</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['accidentes']);?></td>
  </tr>
  <tr>
    <td class="detalleon">ALERGIAS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['alergias']);?></td>
  </tr>
  <tr>
    <td class="detalleon">MEDICAMENTOS</td>
    <td colspan="5" class="detalleoff">&nbsp;<?php echo nl2br($fila['medicamentos']);?></td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">GRUPO SANGUINEO</td>
  </tr>
  <tr>
    <td class="detalleon">RH(-)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==1)?"SI":"NO";?></td>
    <td class="detalleon">RH(+)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==2)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">AB(I)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==3)?"SI":"NO";?></td>
    <td class="detalleon">A(II)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==4)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">B(III)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==5)?"SI":"NO";?></td>
    <td class="detalleon">0(IV)</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['grupo_sanguineo']==6)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">PROBLEMAS ESPECIFICOS DE SALUD DEL ALUMNO</td>
  </tr>
  <tr>
    <td class="detalleon">DIABETES</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico1']==1)?"SI":"NO";?></td>
    <td class="detalleon">PROBLEMAS DE COAGULAC&Iacute;ON</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico2']==1)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">EPILEPSIA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico3']==1)?"SI":"NO";?></td>
    <td class="detalleon">CRISIS ASM&Aacute;TICAS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico4']==1)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">CRISIS CONVULSIVAS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico5']==1)?"SI":"NO";?></td>
    <td class="detalleon">ASMA</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico6']==1)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">SANGRAMIENTO NASAL FRECUENTE</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico7']==1)?"SI":"NO";?></td>
    <td class="detalleon">REACCI&Oacute;N AL&Eacute;RGICA A PICADURA DE INSECTOS</td>
    <td class="detalleoff">&nbsp;<? echo ($fila['problema_especifico8']==1)?"SI":"NO";?></td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;<? echo nl2br($fila['problema_especifico_otros'])?></td>
  </tr>
   <tr>
    <td colspan="6"><hr width="80%" color="black" /></td>
  </tr>
  <tr>
    <td colspan="6" class="titulos-respaldo">TRATAMIENTO CON ESPECIALISTA</td>
  </tr>
  <tr>
    <td class="detalleon">NEUROLOG&Iacute;A</td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">PSICOPEDAGOG&Iacute;A</td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">PSICOLOG&Iacute;A</td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">FONOAUDIOLOG&Iacute;A</td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">OTROS</td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">SEGURO CL&Iacute;NICA </td>
    <td colspan="5" class="detalleoff">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><hr width="80%" color="black" /></td>
  </tr>
  <tr>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td class="detalleon">&nbsp;</td>
    <td class="detalleoff">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>





<?		
}
?>

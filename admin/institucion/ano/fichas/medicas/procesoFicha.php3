<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
if ($GrupoSangre>0) $GrupoSangre = $GrupoSangre; else $GrupoSangre = 0 ;
if ($tipo_seguro>0) $tipo_seguro= $tipo_seguro; else $tipo_seguro= 0 ;

if($frmModo=="ingresar"){
	$qry="SELECT MAX(ID_FICHA) AS CANT FROM FICHA_MEDICA";
	$result =@pg_Exec($conn,$qry);
	if (!$result){
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		$fila = @pg_fetch_array($result,0);
		if (!$fila){
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			exit();
		}
		$newID =  $fila['cant'];
		$newID++;

		$qry="INSERT INTO FICHA_MEDICA (ID_FICHA, RUT_ALUMNO) VALUES (".$newID.",'".$_ALUMNO."')";
		$result =@pg_Exec($conn,$qry);
		if (!$result){
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			}else{
				if($chk1=="on"){$chk1=1;}else{$chk1=0;};
				if($chk2=="on"){$chk2=1;}else{$chk2=0;};
				if($chk3=="on"){$chk3=1;}else{$chk3=0;};
				if($chk4=="on"){$chk4=1;}else{$chk4=0;};
				if($chk5=="on"){$chk5=1;}else{$chk5=0;};
				if($chk6=="on"){$chk6=1;}else{$chk6=0;};
				if($chk7=="on"){$chk7=1;}else{$chk7=0;};
				if($chk8=="on"){$chk8=1;}else{$chk8=0;};
				if($chk9=="on"){$chk9=1;}else{$chk9=0;};
				if($chk10=="on"){$chk10=1;}else{$chk10=0;};
				if($chk11=="on"){$chk11=1;}else{$chk11=0;};
				if($chk12=="on"){$chk12=1;}else{$chk12=0;};
				if($chk13=="on"){$chk13=1;}else{$chk13=0;};
				if($chk14=="on"){$chk14=1;}else{$chk14=0;};
				if($chk15=="on"){$chk15=1;}else{$chk15=0;};
				if($chk16=="on"){$chk16=1;}else{$chk16=0;};
				if($chk17=="on"){$chk17=1;}else{$chk17=0;};
				if($chk18=="on"){$chk18=1;}else{$chk18=0;};
				if($chk19=="on"){$chk19=1;}else{$chk19=0;};
				if($chk20=="on"){$chk20=1;}else{$chk20=0;};
				if($chk21=="on"){$chk21=1;}else{$chk21=0;};
				if($chk22=="on"){$chk22=1;}else{$chk22=0;};
				if($chk23=="on"){$chk23=1;}else{$chk23=0;};
				if($chk24=="on"){$chk24=1;}else{$chk24=0;};
				if($chk25=="on"){$chk25=1;}else{$chk25=0;};
				if($chk26=="on"){$chk26=1;}else{$chk26=0;};
				if($chk27=="on"){$chk27=1;}else{$chk27=0;};
				if($chk28=="on"){$chk28=1;}else{$chk28=0;};
				if($chk29=="on"){$chk29=1;}else{$chk29=0;};
				if($chk30=="on"){$chk30=1;}else{$chk30=0;};
				if($chk31=="on"){$chk31=1;}else{$chk31=0;};
				if($chk32=="on"){$chk32=1;}else{$chk32=0;};
				if($chk33=="on"){$chk33=1;}else{$chk33=0;};
				if($chk34=="on"){$chk34=1;}else{$chk34=0;};
				if($chk35=="on"){$chk35=1;}else{$chk35=0;};
				if($chk36=="on"){$chk36=1;}else{$chk36=0;};
				if($chk37=="on"){$chk37=1;}else{$chk37=0;};
				if($chk38=="on"){$chk38=1;}else{$chk38=0;};
				if($chk39=="on"){$chk39=1;}else{$chk39=0;};
				if($chk40=="on"){$chk40=1;}else{$chk40=0;};
				if($chk41=="on"){$chk41=1;}else{$chk41=0;};
				if($chk42=="on"){$chk42=1;}else{$chk42=0;};
				if($chk43=="on"){$chk43=1;}else{$chk43=0;};
				if($chk44=="on"){$chk44=1;}else{$chk44=0;};
				if($chk45=="on"){$chk45=1;}else{$chk45=0;};
				if($chk46=="on"){$chk46=1;}else{$chk46=0;};
				if($chk47=="on"){$chk47=1;}else{$chk47=0;};
				if($chk48=="on"){$chk48=1;}else{$chk48=0;};
				if($chk49=="on"){$chk49=1;}else{$chk49=0;};
		if($problema_especifico1=="on"){$problema_especifico1=1;}else{$problema_especifico1=0;};
		if($problema_especifico2=="on"){$problema_especifico2=1;}else{$problema_especifico2=0;};
		if($problema_especifico3=="on"){$problema_especifico3=1;}else{$problema_especifico3=0;};
		if($problema_especifico4=="on"){$problema_especifico4=1;}else{$problema_especifico4=0;};
		if($problema_especifico5=="on"){$problema_especifico5=1;}else{$problema_especifico5=0;};
		if($problema_especifico6=="on"){$problema_especifico6=1;}else{$problema_especifico6=0;};
		if($problema_especifico7=="on"){$problema_especifico7=1;}else{$problema_especifico7=0;};
		if($problema_especifico8=="on"){$problema_especifico8=1;}else{$problema_especifico8=0;};												

		$qry="UPDATE ficha_medica SET of_alta = ".$chk1.", of_en_estudio = ".$chk2.", of_hipermetropia = ".$chk3.", of_miopia = ".$chk4.", of_astigmatismo_miope = ".$chk5.", of_astigmatismo_hipermetrope = ".$chk6.", of_astigmatismo_mixto = ".$chk7.", of_astigmatismo_miopito_comp = ".$chk8.", of_astigmatismo_hipermetria_c = ".$chk9.", of_anisometropia = ".$chk10.", of_estrabismo = ".$chk11.", of_influencia_convergencia = ".$chk12.", of_otros_desc = '".$of_otros_desc."', of_lentes_primera_vez = ".$chk14.", of_cambiar_lentes = ".$chk15.", of_mantener_lentes = ".$chk16.", of_estudio_estrabismo = ".$chk17.", of_ejercicios_opticos = ".$chk18.", of_cirugia = ".$chk19.", of_otros_desc_indic = '".$of_otros_desc_indic."', ot_alta = ".$chk21.", ot_en_estudio = ".$chk22.", ot_agenesia_pabellon = ".$chk23.", ot_cerumen_impactado = ".$chk24.", ot_mucosis_timpanica = ".$chk25.",  ot_hipoacusia_neurosensorial = ".$chk26;
		$qry= $qry. ", ot_otros_desc = '".$ot_otros_desc."', ot_audiometria = ".$chk28.", ot_impedanciometria = ".$chk29;
		$qry= $qry. ", ot_radiografia = ".$chk30.", ot_medicamento = ".$chk31.", ot_audifono = ".$chk32.", ot_cirugia = ".$chk33;
		$qry= $qry. ", ot_otros_desc_indic = '".$ot_otros_desc_indic."', or_alta = ".$chk35.", or_en_estudio = ".$chk36;
		$qry= $qry. ", or_pie_plano = ".$chk37.", or_genu_valgo_varo = ".$chk38.", or_deform_adquir_dedos = ".$chk39.", or_escoliosis = ".$chk40;
		$qry= $qry. ", or_otros_desc = '".$or_otros_desc."', or_cambiar_plantillas = ".$chk42.", or_mantener_plantillas = ".$chk43;
		$qry= $qry. ", or_kinesiterapia = ".$chk44.", or_rx_extrem_inferiores = ".$chk45.", or_rx_columna = ".$chk46.", or_corse = ".$chk47;
		$qry= $qry. ", or_cirugia = ".$chk48.", or_otros_desc_indic = '".$or_otros_desc_indic."', fecha_atencion = '".fEs2En($txtFECHAATE);
		$qry= $qry. "', fecha_prox_at = '".fEs2En($txtFECHAPROXATE)."', rut_med = '88888888', rut_med_coleg = '88888888', accidentes='".$txtACCIDENTE;
		$qry= $qry. "',alergias='".$txtALERGIA."', medicamentos='".$txtMEDICAMENTO."', grupo_sanguineo = ".$GrupoSangre;
		$qry= $qry. ", problema_especifico1 = ".$problema_especifico1;
		$qry= $qry. ", problema_especifico2 = ".$problema_especifico2;
		$qry= $qry. ", problema_especifico3 = ".$problema_especifico3;
		$qry= $qry. ", problema_especifico4 = ".$problema_especifico4;
		$qry= $qry. ", problema_especifico5 = ".$problema_especifico5;
		$qry= $qry. ", problema_especifico6 = ".$problema_especifico6;
		$qry= $qry. ", problema_especifico7 = ".$problema_especifico7;
		$qry= $qry. ", problema_especifico8 = ".$problema_especifico8;
		$qry= $qry. ", problema_especifico_otros = '".$problema_especifico_otros;
		$qry= $qry. "', tipo_seguro = ".$tipo_seguro;
		$qry= $qry. ", clinica = '".$clinica;		
		$qry= $qry. "', fono_clinica = '".$fono_clinica;				
		$qry= $qry. "' WHERE id_ficha = ".$newID;
				$result =@pg_Exec($conn,$qry);
				if (!$result){
				echo $qry;
					}else{
						echo "<script>window.location = 'seteaFicha.php3?caso=1&alumno=".$_ALUMNO."&idFicha=".$newID."'</script>";
				}
			}
		}
	}

	if($frmModo=="modificar"){
		if($chk1=="on"){$chk1=1;}else{$chk1=0;};
		if($chk2=="on"){$chk2=1;}else{$chk2=0;};
		if($chk3=="on"){$chk3=1;}else{$chk3=0;};
		if($chk4=="on"){$chk4=1;}else{$chk4=0;};
		if($chk5=="on"){$chk5=1;}else{$chk5=0;};
		if($chk6=="on"){$chk6=1;}else{$chk6=0;};
		if($chk7=="on"){$chk7=1;}else{$chk7=0;};
		if($chk8=="on"){$chk8=1;}else{$chk8=0;};
		if($chk9=="on"){$chk9=1;}else{$chk9=0;};
		if($chk10=="on"){$chk10=1;}else{$chk10=0;};
		if($chk11=="on"){$chk11=1;}else{$chk11=0;};
		if($chk12=="on"){$chk12=1;}else{$chk12=0;};
		if($chk13=="on"){$chk13=1;}else{$chk13=0;};
		if($chk14=="on"){$chk14=1;}else{$chk14=0;};
		if($chk15=="on"){$chk15=1;}else{$chk15=0;};
		if($chk16=="on"){$chk16=1;}else{$chk16=0;};
		if($chk17=="on"){$chk17=1;}else{$chk17=0;};
		if($chk18=="on"){$chk18=1;}else{$chk18=0;};
		if($chk19=="on"){$chk19=1;}else{$chk19=0;};
		if($chk20=="on"){$chk20=1;}else{$chk20=0;};
		if($chk21=="on"){$chk21=1;}else{$chk21=0;};
		if($chk22=="on"){$chk22=1;}else{$chk22=0;};
		if($chk23=="on"){$chk23=1;}else{$chk23=0;};
		if($chk24=="on"){$chk24=1;}else{$chk24=0;};
		if($chk25=="on"){$chk25=1;}else{$chk25=0;};
		if($chk26=="on"){$chk26=1;}else{$chk26=0;};
		if($chk27=="on"){$chk27=1;}else{$chk27=0;};
		if($chk28=="on"){$chk28=1;}else{$chk28=0;};
		if($chk29=="on"){$chk29=1;}else{$chk29=0;};
		if($chk30=="on"){$chk30=1;}else{$chk30=0;};
		if($chk31=="on"){$chk31=1;}else{$chk31=0;};
		if($chk32=="on"){$chk32=1;}else{$chk32=0;};
		if($chk33=="on"){$chk33=1;}else{$chk33=0;};
		if($chk34=="on"){$chk34=1;}else{$chk34=0;};
		if($chk35=="on"){$chk35=1;}else{$chk35=0;};
		if($chk36=="on"){$chk36=1;}else{$chk36=0;};
		if($chk37=="on"){$chk37=1;}else{$chk37=0;};
		if($chk38=="on"){$chk38=1;}else{$chk38=0;};
		if($chk39=="on"){$chk39=1;}else{$chk39=0;};
		if($chk40=="on"){$chk40=1;}else{$chk40=0;};
		if($chk41=="on"){$chk41=1;}else{$chk41=0;};
		if($chk42=="on"){$chk42=1;}else{$chk42=0;};
		if($chk43=="on"){$chk43=1;}else{$chk43=0;};
		if($chk44=="on"){$chk44=1;}else{$chk44=0;};
		if($chk45=="on"){$chk45=1;}else{$chk45=0;};
		if($chk46=="on"){$chk46=1;}else{$chk46=0;};
		if($chk47=="on"){$chk47=1;}else{$chk47=0;};
		if($chk48=="on"){$chk48=1;}else{$chk48=0;};
		if($chk49=="on"){$chk49=1;}else{$chk49=0;};
		
		if($problema_especifico1=="on"){$problema_especifico1=1;}else{$problema_especifico1=0;};
		if($problema_especifico2=="on"){$problema_especifico2=1;}else{$problema_especifico2=0;};
		if($problema_especifico3=="on"){$problema_especifico3=1;}else{$problema_especifico3=0;};
		if($problema_especifico4=="on"){$problema_especifico4=1;}else{$problema_especifico4=0;};
		if($problema_especifico5=="on"){$problema_especifico5=1;}else{$problema_especifico5=0;};
		if($problema_especifico6=="on"){$problema_especifico6=1;}else{$problema_especifico6=0;};
		if($problema_especifico7=="on"){$problema_especifico7=1;}else{$problema_especifico7=0;};
		if($problema_especifico8=="on"){$problema_especifico8=1;}else{$problema_especifico8=0;};												

		$qry="UPDATE ficha_medica SET of_alta = ".$chk1.", of_en_estudio = ".$chk2.", of_hipermetropia = ".$chk3.", of_miopia = ".$chk4.", of_astigmatismo_miope = ".$chk5.", of_astigmatismo_hipermetrope = ".$chk6.", of_astigmatismo_mixto = ".$chk7.", of_astigmatismo_miopito_comp = ".$chk8.", of_astigmatismo_hipermetria_c = ".$chk9.", of_anisometropia = ".$chk10.", of_estrabismo = ".$chk11.", of_influencia_convergencia = ".$chk12.", of_otros_desc = '".$of_otros_desc."', of_lentes_primera_vez = ".$chk14.", of_cambiar_lentes = ".$chk15.", of_mantener_lentes = ".$chk16.", of_estudio_estrabismo = ".$chk17.", of_ejercicios_opticos = ".$chk18.", of_cirugia = ".$chk19.", of_otros_desc_indic = '".$of_otros_desc_indic."', ot_alta = ".$chk21.", ot_en_estudio = ".$chk22.", ot_agenesia_pabellon = ".$chk23.", ot_cerumen_impactado = ".$chk24.", ot_mucosis_timpanica = ".$chk25.",  ot_hipoacusia_neurosensorial = ".$chk26;
		$qry= $qry. ", ot_otros_desc = '".$ot_otros_desc."', ot_audiometria = ".$chk28.", ot_impedanciometria = ".$chk29;
		$qry= $qry. ", ot_radiografia = ".$chk30.", ot_medicamento = ".$chk31.", ot_audifono = ".$chk32.", ot_cirugia = ".$chk33;
		$qry= $qry. ", ot_otros_desc_indic = '".$ot_otros_desc_indic."', or_alta = ".$chk35.", or_en_estudio = ".$chk36;
		$qry= $qry. ", or_pie_plano = ".$chk37.", or_genu_valgo_varo = ".$chk38.", or_deform_adquir_dedos = ".$chk39.", or_escoliosis = ".$chk40;
		$qry= $qry. ", or_otros_desc = '".$or_otros_desc."', or_cambiar_plantillas = ".$chk42.", or_mantener_plantillas = ".$chk43;
		$qry= $qry. ", or_kinesiterapia = ".$chk44.", or_rx_extrem_inferiores = ".$chk45.", or_rx_columna = ".$chk46.", or_corse = ".$chk47;
		$qry= $qry. ", or_cirugia = ".$chk48.", or_otros_desc_indic = '".$or_otros_desc_indic."', fecha_atencion = '".fEs2En($txtFECHAATE);
		$qry= $qry. "', fecha_prox_at = '".fEs2En($txtFECHAPROXATE)."', rut_med = '88888888', rut_med_coleg = '88888888', accidentes='".$txtACCIDENTE;
		$qry= $qry. "',alergias='".$txtALERGIA."', medicamentos='".$txtMEDICAMENTO."', grupo_sanguineo = ".$GrupoSangre;
		$qry= $qry. ", problema_especifico1 = ".$problema_especifico1;
		$qry= $qry. ", problema_especifico2 = ".$problema_especifico2;
		$qry= $qry. ", problema_especifico3 = ".$problema_especifico3;
		$qry= $qry. ", problema_especifico4 = ".$problema_especifico4;
		$qry= $qry. ", problema_especifico5 = ".$problema_especifico5;
		$qry= $qry. ", problema_especifico6 = ".$problema_especifico6;
		$qry= $qry. ", problema_especifico7 = ".$problema_especifico7;
		$qry= $qry. ", problema_especifico8 = ".$problema_especifico8;
		$qry= $qry. ", problema_especifico_otros = '".$problema_especifico_otros;
		$qry= $qry. "', tipo_seguro = ".$tipo_seguro;
		$qry= $qry. ", clinica = '".$clinica;		
		$qry= $qry. "', fono_clinica = '".$fono_clinica;				

		$qry= $qry. "', isapre = '".$isapre;		

		$qry= $qry. "' WHERE id_ficha = ".$_FICHAM;
		
		$result =@pg_Exec($conn,$qry);
		if (!$result){
				echo $qry;
			}else{
				echo "<script>window.location = 'seteaFicha.php3?caso=1&alumno=".$_ALUMNO."&idFicha=".$_FICHAM."'</script>";
		}
	}
?>
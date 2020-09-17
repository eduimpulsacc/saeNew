<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

<? require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if($tipo_hoja!=1){
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	}else{
	/**********VARIABLES PARA HOJA DE VIDA***************/
	$ano			=$c_ano;
	$alumno			=$c_alumno;
	$c_curso;
	/************************/
	}
	$idFicha		=$_FICHAM;
	$_POSP          = 5;
	
	
					
			
			// ACTUALIZAMOS
			
			
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
		
		
		if ($GrupoSangre = " "){
		   $GrupoSangre = 0;
		}    
	  
	    if ($tipo_seguro < 1){
		    $tipo_seguro = 0;
	    }    
		 $dd = substr($fechacontrol,0,2);
		 $mm = substr($fechacontrol,3,2);
		 $aa = substr($fechacontrol,6,4);
		 $fechacontrol2 = "$mm-$dd-$aa";
		
		$qry="SELECT MAX(ID_FICHA) AS CANT FROM FICHA_MEDICA";
	    $result =@pg_Exec($conn,$qry);
		$id_f = pg_result($result,0) + 1;
		
		$qry="INSERT INTO ficha_medica (
		id_ficha,
		rut_alumno,
		fecha,
		observaciones,
		hora,
		of_alta,
		of_en_estudio,
		of_hipermetropia,
		of_miopia,
		of_astigmatismo_miope,
		of_astigmatismo_hipermetrope,
		of_astigmatismo_mixto,
		of_astigmatismo_miopito_comp,
		of_astigmatismo_hipermetria_c,
		of_anisometropia,
		of_estrabismo,
		of_influencia_convergencia,
		of_otros_desc,
		of_lentes_primera_vez,
		of_cambiar_lentes,
		of_mantener_lentes,
		of_estudio_estrabismo,
		of_ejercicios_opticos,
		of_cirugia,
		of_otros_desc_indic,
		ot_alta,
		ot_en_estudio,
		ot_agenesia_pabellon,
		ot_cerumen_impactado,
		ot_mucosis_timpanica,
		ot_hipoacusia_neurosensorial,
		ot_otros_desc,
		ot_audiometria,
		ot_impedanciometria,
		ot_radiografia,
		ot_medicamento,
		ot_audifono, 
		ot_cirugia,
		ot_otros_desc_indic,
		or_alta,
		or_en_estudio,
		or_pie_plano,
		or_genu_valgo_varo,
		or_deform_adquir_dedos,
		or_escoliosis,
		or_otros_desc,
		or_cambiar_plantillas,
		or_mantener_plantillas,
		or_kinesiterapia,
		or_rx_extrem_inferiores,
		or_rx_columna,
		or_corse,
		or_cirugia,
		or_otros_desc_indic,
		fecha_atencion,
		rut_med,
		rut_med_coleg,
		accidentes,
		alergias,
		medicamentos,
		grupo_sanguineo,
		problema_especifico1,
		problema_especifico2,
		problema_especifico3,
		problema_especifico4,
		problema_especifico5,
		problema_especifico6,
		problema_especifico7,
		problema_especifico8,
		problema_especifico_otros,
		tipo_seguro,
		clinica,
		fono_clinica,
		isapre) 
		VALUES(
		".$id_f.",
		'".$alumno."',
		'".$fechacontrol2."',
		'".$observaciones."',
		'".$horacontrol."',
		".$chk1.",
		".$chk2.",
		".$chk3.",
		".$chk4.",
		".$chk5.",
		".$chk6.",
		".$chk7.",
		".$chk8.",
		".$chk9.",
		".$chk10.",
		".$chk11.",
		".$chk12.",
		'".$of_otros_desc."',
		".$chk14.",
		".$chk15.",
		".$chk16.",
		".$chk17.",
		".$chk18.",
		".$chk19.",
		'".$of_otros_desc_indic."',
		".$chk21.",
		".$chk22.",
		".$chk23.",
		".$chk24.",
		".$chk25.",
		".$chk26.",
		'".$ot_otros_desc."',
		".$chk28.",
		".$chk29.",
		".$chk30.",
		".$chk31.",
		".$chk32.",
		".$chk33.",
		'".$ot_otros_desc_indic."',
		".$chk35.",
		".$chk36.",
		".$chk37.",
		".$chk38.",
		".$chk39.",
		".$chk40.",
		'".$or_otros_desc."',
		".$chk42.",
		".$chk43.",
		".$chk44.", 
		".$chk45.",
		".$chk46.",
		".$chk47.",
		".$chk48.",
		'".$or_otros_desc_indic."',
		'".$fechacontrol2."',
		'88888888',
		'88888888',
		'".$txtACCIDENTE."',
		'".$txtALERGIA."',
		'".$txtMEDICAMENTO."',
		".$GrupoSangre.",
		".$problema_especifico1.",
		".$problema_especifico2.",
		".$problema_especifico3.",
		".$problema_especifico4.",
		".$problema_especifico5.",
		".$problema_especifico6.",
		".$problema_especifico7.",
		".$problema_especifico8.",
		'".$problema_especifico_otros."',
		".$tipo_seguro.",
		'".$clinica."',
		'".$fono_clinica."',
		'".$isapre."')";
		$result =pg_Exec($conn,$qry);
		if (!$result){  //if 7
			echo $qry;
			exit;
		}else{
			
		}  // fin 7
	

?>
<html>
<? if($tipo_hoja!=1){?>
<meta http-equiv="refresh" content="0;URL=listarFichasAlumno.php3?alumno=<?=$alumno ?>&caso=1">
<? }else{?>
<meta http-equiv="refresh" content="0;URL=listarFichasAlumno.php3?alumno=<?=$alumno ?>&curso=<?=$c_curso?>&c_ano=<?=$ano?>&tipo_hoja=<?=$tipo_hoja?>&caso=1">
<? }?>
<body>
</body>
</html>
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
	
	foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion);
  // echo "<br>".$asignacion; 
}

$dataExist= "SELECT * FROM ficha_medicanew3 WHERE rut_alumno=".$alumno;
	$result =@pg_Exec($conn,$dataExist);
			
	if(pg_numrows($result)!=0){
		
		$sql="update ficha_medicanew3 set nombre_alt1 ='$nombre_alt1' ,
		celular_alt1 = '$cel_alt1',
		fonotrab_alt1 = '$fonotrab_alt1',
		fonocasa_alt1 = '$fonocasa_alt1',
		nombre_alt2 = '$nombre_alt2',
		celular_alt2 = '$cel_alt2',
		fonotrab_alt2 = '$fonotrab_alt2',
		fonocasa_alt2 = '$fonocasa_alt2',
		bool_alergia = $bool_alergia,
		bool_asma = $bool_asma,
		bool_diabetes = $bool_diabetes,
		bool_epilepsia = $bool_epilepsia,
		bool_afeccioncardiaca = $bool_afeccioncardiaca,
		bool_afeccionrespiratoria = $bool_afeccionrespiratoria,
		bool_afeccioncutanea = $bool_afeccioncutanea,
		bool_alteracionsensorial = $bool_alteracionsensorial,
		bool_alteracionmotriz = $bool_alteracionmotriz,
		bool_cirugia = $bool_cirugia,
		bool_medacamentoabitual = $bool_medacamentoabitual,
		bool_otrasenfermedades = $bool_otrasenfermedades,
		bool_mareos = $bool_mareos,
		txt_mareos = '$txt_mareos',
		bool_desmayos = $bool_desmayos,
		txt_desmayos = '$txt_desmayos',
		bool_dolorpecho = $bool_dolorpecho,
		txt_dolorpecho = '$txt_dolorpecho',
		bool_difrespiratoria = $bool_difrespiratoria,
		txt_boolrespiratoria = '$txt_difrespiratoria',
		bool_antecedentefamiliar = $bool_antecedentefamiliar,
		txt_antecedentefamiliar = '$txt_antecedentefamiliar',
		bool_paracetamolgo = $bool_paracetamolgo,
		bool_paracetamolgr = $bool_paracetamolgr,
		bool_predual = $bool_predual,
		bool_ibuprofeno = $bool_ibuprofeno,
		bool_diclofenaco = $bool_diclofenaco,
		bool_loratadina = $bool_loratadina,
		bool_salbutamol = $bool_salbutamol,
		bool_viadil = $bool_viadil,
		bool_valpin = $bool_valpin,
		observaciones = '$observaciones',
		txt_seguropart= '$txt_seguropart',
		medicion_antropometrica = $medicion_antropometrica,
		txt_sangre = '$blood_group',
		vacunas_ministeriales = $vacuna,
		trastorno_sueno = $sueno,
		enf_recurrente='$enf_recurrente',
		med_recurrente='$med_recurrente',
		bool_desmayo3m=$bool_desmayo3m,
		med_alergias='$med_alergias',
		aut_enfermeria=".intval($aut_enfermeria);

		if($_PERFIL==15){
			$sql.=", fecha_actualizacion='".date("Y-m-d")."',
			apo_actualizacion = '".$_NOMBREUSUARIO."'";
		}
		if($_PERFIL==0){
			$sql.=", fecha_actualizacion='".date("Y-m-d")."',
			apo_actualizacion = '".$_NOMBREUSUARIO."'";
		}
		
		$sql.=" where rut_alumno = $alumno;";
	}else{
		
		$sql ="insert into ficha_medicanew3 (
		rut_alumno,
		nombre_alt1,
		celular_alt1,
		fonotrab_alt1,
		fonocasa_alt1,
		nombre_alt2,
		celular_alt2,
		fonotrab_alt2,
		fonocasa_alt2,
		bool_alergia,
		bool_asma,
		bool_diabetes,
		bool_epilepsia,
		bool_afeccioncardiaca,
		bool_afeccionrespiratoria,
		bool_afeccioncutanea,
		bool_alteracionsensorial,
		bool_alteracionmotriz,
		bool_cirugia,
		bool_medacamentoabitual,
		bool_otrasenfermedades,
		bool_mareos,
		txt_mareos,
		bool_desmayos,
		txt_desmayos,
		bool_dolorpecho,
		txt_dolorpecho,
		bool_difrespiratoria,
		txt_boolrespiratoria,
		bool_antecedentefamiliar,
		txt_antecedentefamiliar,
		bool_paracetamolgo,
		bool_paracetamolgr,
		bool_predual,
		bool_ibuprofeno,
		bool_diclofenaco,
		bool_loratadina,
		bool_salbutamol,
		bool_viadil,
		bool_valpin,
		observaciones,
		fecha_creacion,
		txt_seguropart,
		medicion_antropometrica,
		txt_sangre,
		vacunas_ministeriales,
		trastorno_sueno,
		enf_recurrente,
		med_recurrente,
		bool_desmayo3m,
		med_alergias,
		aut_enfermeria
		) values
		(
		$rut_alumno,
		'$nombre_alt1',
		'$cel_alt1',
		'$fonotrab_alt1',
		'$fonocasa_alt1',
		'$nombre_alt2',
		'$cel_alt2',
		'$fonotrab_alt2',
		'$fonocasa_alt2',
		".intval($bool_alergia).",
		".intval($bool_asma).",
		".intval($bool_diabetes).",
		".intval($bool_epilepsia).",
		".intval($bool_afeccioncardiaca).",
		".intval($bool_afeccionrespiratoria).",
		".intval($bool_afeccioncutanea).",
		".intval($bool_alteracionsensorial).",
		".intval($bool_alteracionmotriz).",
		".intval($bool_cirugia).",
		".intval($bool_medacamentoabitual).",
		".intval($bool_otrasenfermedades).",
		".intval($bool_mareos).",
		'$txt_mareos',
		".intval($bool_desmayos).",
		'$txt_desmayos',
		".intval($bool_dolorpecho).",
		'$txt_dolorpecho',
		".intval($bool_difrespiratoria).",
		'$txt_difrespiratoria',
		".intval($bool_antecedentefamiliar).",
		'$txt_antecedentefamiliar',
		".intval($bool_paracetamolgo).",
		".intval($bool_paracetamolgr).",
		".intval($bool_predual).",
		".intval($bool_ibuprofeno).",
		".intval($bool_diclofenaco).",
		".intval($bool_loratadina).",
		".intval($bool_salbutamol).",
		".intval($bool_viadil).",
		".intval($bool_valpin).",
		'$observaciones',
		'".date("Y-m-d")."',
		'$txt_seguropart',
		$medicion_antropometrica,
		'$blood_group',
		$vacuna,
		$sueno,
		'$enf_recurrente',
		'$med_recurrente',
		".intval($bool_desmayo3m).",
		'$med_alergias',
		".intval($aut_enfermeria)."

		
		)"; 
		
	}	
	
		//echo $sql;
	$result =@pg_Exec($conn,$sql);

?>

<html>
<? if($tipo_hoja!=1){?>
<meta http-equiv="refresh" content="0;URL=listarFichasAlumno.php3?alumno=<?=$alumno ?>&curso=<?=$id_curso?>&caso=1">
<? }else{?>
<meta http-equiv="refresh" content="0;URL=listarFichasAlumno.php3?alumno=<?=$alumno ?>&curso=<?=$id_curso?>&c_ano=<?=$ano?>&tipo_hoja=<?=$tipo_hoja?>&caso=1">
<? }?>
<body>
</body>
</html>

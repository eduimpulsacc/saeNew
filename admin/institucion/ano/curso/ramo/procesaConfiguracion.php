<?	require('../../../../../util/header.inc');

$frmModo		=$_FRMMODO;
$institutcion	=$_INSTIT;
$curso			=$_CURSO;
$ano			=$_ANO;


if($frmModo=="modificar"){
	for($i=0;$i<$contador;$i++){
		$id_ramo 		= ${"cod_ramo".$i};														
		$obligatorio	= ${"cb_OBLIG".$i};						if($obligatorio!=1){$obligatorio=0;$electivo=1;}else{$electivo=0;}		
		$incide			= ${"cb_PROMO".$i};						if($incide!=1) $incide=0;				
		$religion		= ${"cb_RELIGION".$i};					if($religion!=1) $religion=0;			
		$artistico		= ${"cb_ARTISTICO".$i};					if($artistico!=1) $artistico=0;				
		$hrs_jec		= ${"txt_JEC".$i};						if($hrs_jec=="") $hrs_jec=0;					
		$hrs_plan		= ${"txt_PLAN".$i};						if($hrs_plan=="") $hrs_plan=0;				
		$orden			= ${"txt_ORDEN".$i};					if($orden=="") $orden=0;			
		$evaluacion		= ${"cmbEVALUACION".$i};				//if($evaluacion=="") $evaluacion=1; else $evaluacion=0;		
		$docente		= ${"cmbDOCENTE".$i};					//if($docente=="") $docente=1; else $docente=0;																		
		$examen			= ${"cb_EXAMEN".$i};					if($examen!=1) $examen=0; 
		$porc_examen	= ${"txt_PEXAMEN".$i};					if($porc_examen=="") $porc_examen=0;
		$nota_examen	= ${"txt_NEXAMEN".$i};					if($nota_examen=="") $nota_examen=0; 
		$ex_escrito		= ${"txt_ESCRITO".$i};					if($ex_escrito=="") $ex_escrito=0; 
		$ex_oral		= ${"txt_ORAL".$i};						if($ex_oral=="") $ex_oral=0; 
		$prueba_nivel	= ${"cb_NIVEL".i};						if($prueba_nivel!=1) $prueba_nivel=0;
		$porc_nivel		= ${"txt_PNIVEL".$i};					if($porc_nivel=="") $porc_nivel=0; 
		$aprox_p_nivel	= ${"cb_APROXN".$i};					if($aprox_p_nivel!=1) $aprox_p_nivel=0; 
		$evalua_nivel	= ${"cmbEVALUAPRUEBANIVEL".$i};			if($evalua_nivel=="") $evalua_nivel=0;		
		$apreciacion	= ${"txt_APRECIACION".$i};				if($apreciacion=="") $apreciacion=0; 
		$aprox_nota		= ${"cb_APROX".$i};						if($aprox_nota!=1) $aprox_nota=0; 
		$aprox_entero	= ${"cb_APROXENTERO".$i};				if($aprox_entero!=1) $aprox_entero=0; 
		$minima1		= ${"txt_MINIMA1".$i};					if($minima1=="") $minima1=0; 
		$maxima1		= ${"txt_MAXIMA1".$i};					if($maxima1=="") $maxima1=0;		
		$bonifica1		= ${"txt_BONIFICA1".$i};				if($bonifica1=="") $bonifica1=0;		
		$minima2		= ${"txt_MINIMA2".$i};					if($minima2=="") $minima2=0;		
		$maxima2		= ${"txt_MAXIMA2".$i};					if($maxima2=="") $maxima2=0;		
		$bonifica2		= ${"txt_BONIFICA2".$i};				if($bonifica2=="") $bonifica2=0;		
		$minima3		= ${"txt_MINIMA3".$i};					if($minima3=="") $minima3=0;																											
		$maxima3		= ${"txt_MAXIMA3".$i};					if($maxima3=="") $maxima3=0;		
		$bonifica3		= ${"txt_BONIFICA3".$i};				if($bonifica3=="") $bonifica3=0;	
		$minima4		= ${"txt_MINIMA4".$i};					if($minima4=="") $minima4=0;																											
		$maxima4		= ${"txt_MAXIMA4".$i};					if($maxima4=="") $maxima4=0;		
		$bonifica4		= ${"txt_BONIFICA4".$i};				if($bonifica4=="") $bonifica4=0;
		$bonifica4		= ${"txt_BONIFICA4".$i};				if($bonifica4=="") $bonifica4=0;	
		$formacion		= ${"cmbFORMACION".$i};		
		$codigo			= ${"txtCODIGO".$i};
		$nquiz	= ${"cb_NQUIZ".$i};				if($nquiz!=1) $nquiz=0; 
																											
																											
		$sql ="UPDATE RAMO SET sub_obli='".$obligatorio."',sub_elect='".$electivo."', bool_ip='".$incide."', bool_sar='".$religion."', bool_artis='".$artistico."', aprox_entero='".$aprox_entero."', truncado='".$aprox_nota."', conex='".$examen."', pct_examen='".$porc_examen."', nota_exim='".$nota_examen."', pct_ex_escrito='".$ex_escrito."', pct_ex_oral='".$ex_oral."', prueba_nivel='".$prueba_nivel."', truncado_pnivel='".$aprox_p_nivel."', pct_nivel='".$porc_nivel."', modo_eval_pnivel='".$evalua_nivel."', id_orden='".$orden."', hrs_jec='".$hrs_jec."', hrs_plan='".$hrs_plan."', modo_eval='".$evaluacion."', apreciacion='".$apreciacion."',minima1='".$minima1."', maxima1='".$maxima1."', bonifica1='".$bonifica1."', minima2='".$minima2."', maxima2='".$maxima2."', bonifica2='".$bonifica2."', minima3='".$minima3."', maxima3='".$maxima3."', bonifica3='".$bonifica3."', minima4='".$minima4."', maxima4='".$maxima4."', bonifica4='".$bonifica4."',formacion=".$formacion.",bool_nquiz=".$nquiz."";
		if($_PERFIL==0){
			$sql.="	, cod_subsector=".$codigo." ";
		}
		$sql.=" WHERE id_ramo=".$id_ramo;
		
		$rs_ramo = @pg_exec($conn,$sql) or die ("UPDATE FALLO :".$sql);
		
		echo pg_ErrorMessage($rs_ramo);
		
		/*$sql = "SELECT * FROM dicta WHERE id_ramo=".$id_ramo;
		$rs_existe = @pg_exec($conn,$sql);
		
		if(@pg_numrows($rs_existe)==0){
			$sql = "INSERT INTO dicta (rut_emp,id_ramo) VALUES ('".$docente."',".$id_ramo.")";
		}else{
			$sql = "UPDATE dicta SET rut_emp='".$docente."' WHERE id_ramo=".$id_ramo;
		}
		$rs_dicta = @pg_exec($conn,$sql);*/
		
		$sql ="DELETE FROM dicta WHERE id_ramo=".$id_ramo;
		$rs_existe = @pg_exec($conn,$sql);
		$sql = "INSERT INTO dicta (rut_emp,id_ramo) VALUES ('".$docente."',".$id_ramo.")";
		$rs_dicta = @pg_exec($conn,$sql);
	}



}
echo "<script>window.location='seteaConfig.php3?caso=1&curso=$curso'</script>";

pg_close($conn);?>
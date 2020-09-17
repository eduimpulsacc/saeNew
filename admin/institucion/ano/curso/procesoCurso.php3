<?php require('../../../../util/header.inc');
   
 	$frmModo=$_FRMMODO;
	$institucion	=$_INSTIT;
	
	//var_dump($_POST);exit;
	
	
 $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = @pg_exec($conn,$qryIns);
		  $filaIns	= @pg_fetch_array($resultIns,0);
		    $Tipo_Ins = $filaIns['tipo_instit'];


if ($truncado_per==1){
     $truncado_per=1;
}else{
	 $truncado_per=0;
}	 

if ($truncado_final==1){
     $truncado_final=1;
}else{
	 $truncado_final=0;
}
	

if ($truncado_sf==1){
     $truncado_sf=1;
}else{
	 $truncado_sf=0;
}	 

if ($bloq_ramos==1){
  $bloq_ramos=1;
}else{
  $bloq_ramos=0;
}

if ($bool_psemestral==1){
  $bool_psemestral=1;
}else{
  $bool_psemestral=0;
}	 
	 

if ($simce==NULL){
    $simce=0;
}

if ($val_sub==NULL){
    $val_sub=0; 
	
}	

if ($autoev_ip==1){
     $autoev_ip=1;
}else{
	 $autoev_ip=0;
}

$fecha_incio=($fecha_inicio=='')?'1111-11-11':CambioFE($fecha_inicio);
		
		$fecha_termino=($fecha_termino=='')?'1111-11-11':CambioFE($fecha_termino);


if ($pj_edita==1){
  $pj_edita=1;
}else{
  $pj_edita=0;
}

if(empty($jornada)) $jornada=0;


if ($frmModo=="ingresar") {
	
	if($btnGuardarSige=='GUARDAR EN SIGE'){
		require_once('ServicioCursoSige.php');
	}


	//VERIFICAR EXISTENCIA PREVIA DE (GRADO-LETRA-ENSEÑANZA-AÑO)
	$qry="select * from (curso inner join plan_estudio on curso.cod_decreto=plan_estudio.cod_decreto) where curso.grado_curso='".$cmbGRA."' and curso.letra_curso='".$cmbLETRA."' and curso.ensenanza=".$cmbENS." and curso.id_ano=".$ano." and plan_estudio.rdb=".$rdb;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
	}else{
		if(pg_numrows($result)!=0){
			echo "<html><title>ERROR</title></head>";
			echo "<body><center>";
			echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
			echo "ERROR: EL CURSO YA SE ENCUENTRA PREVIAMENTE INGRESADO...";
			echo "<BR>";
			echo "<INPUT TYPE=button value=VOLVER onClick=history.back();>";
			echo "</center></body></html>";
		}else{
				//if(($Tipo_Ins==1) and ($cmbPLAN!=1000)){//COLEGIO
				if($Tipo_Ins==1){//COLEGIO
					if($cmbPLAN=="")
						$cmbPLAN=0;

					if($cmbEVAL=="")
						$cmbEVAL=0;
					
					if ($cmbESP=="")
						$cmbESP=0;
						
					if ($cmbSEC=="")
						$cmbSEC=0;
					
					if ($txtRAMA=="")
						$txtRAMA=0;
					
					if($cmbACTA=="")
					   $cmbACTA=0;
					   
					if($observaciones=="")
					   $observaciones=0;
						
					if ($simce==""){
					   $simce = 0;
					} 
					if ($cap_curso==""){
					   $cap_curso = 0;
					}   	
					
					
						
						
				    $qryEVAL="SELECT cod_eval FROM tipo_ense_eval WHERE cod_tipo=". $cmbENS." AND grado=".$cmbGRA;
					$resultEVAL=pg_Exec($conn,$qryEVAL);
					$filaEVAL = pg_fetch_array($resultEVAL,0);
					
				
					
					
					$qry_ult = "select id_curso from curso order by id_curso desc limit 1";
					$res_ult = pg_Exec($conn, $qry_ult);
					$fil_ult = pg_fetch_array($res_ult,0);
					$id_curso_ult = $fil_ult['id_curso'];
					
					$id_curso_ult++;
					
					//------------- ASIGANCIÓN DE NIVELES A LOS CURSOS -------------------------//
					
					//--------------BASICA------------------//
					if($cmbENS==110){
						if($cmbGRA==1 || $cmbGRA==2){
							$nivel=1;
						}
						if($cmbGRA==3 || $cmbGRA==4){
							$nivel=2;
						}
						if($cmbGRA==5){
							$nivel=3;
						}
						if($cmbGRA==6){
							$nivel=4;
						}
						if($cmbGRA==7){
							$nivel=5;
						}
						if($cmbGRA==8){
							$nivel=6;
						}
					}
					
					//-----------------MEDIA-----------//
					
					if($cmbENS==310 || $cmbENS==410 || $cmbENS==510 || $cmbENS==610 || $cmbENS==710 || $cmbENS==810){
						if($cmbGRA==1){
							$nivel=7;
						}
						if($cmbGRA==2){
							$nivel=8;
						}
						if($cmbGRA==3){
							$nivel=9;
						}
						if($cmbGRA==4){
							$nivel=10;
						}
					}
					if($cmbENS!=310 || $cmbENS!=410 || $cmbENS!=510 || $cmbENS!=610 || $cmbENS!=710 || $cmbENS!=810 || $cmbENS!=110){
						$nivel=0;
					}
					//--------------------------------------------------------------------------//
		//$filaEVAL['cod_eval']= (pg_numrows($filaEVAL)==0)?'null':$filaEVAL['cod_eval'];								
						
					$qry="INSERT INTO CURSO (ID_CURSO,GRADO_CURSO,LETRA_CURSO,ENSENANZA,COD_DECRETO,COD_EVAL,ID_ANO,COD_ES,COD_SECTOR,COD_RAMA,BOOL_JOR, TRUNCADO_PER,TRUNCADO_FINAL,TRUNCADO_SF, SIMCE, ACTA, OBSERVACIONES, VAL_SUB,CAP_CURSO, ID_NIVEL,BLOQ_RAMOS,FECHA_INICIO,FECHA_TERMINO,BOOL_PSEMESTRAL,AUTOEV_IP,SEDE,PJ_EDITA) VALUES ('".$id_curso_ult."',".$cmbGRA.",'".$cmbLETRA."',".$cmbENS.", ".$cmbPLAN." , ".$filaEVAL['cod_eval'].",".$ano.",".$cmbESP.",".$cmbSEC.",".$txtRAMA.",".$jornada.", ".$truncado_per.",".$truncado_final.",".$truncado_sf.",".$simce.",".$cmbACTA.",'".$observaciones."','".$val_sub."','".$cap_curso."',".$nivel.",".$bloq_ramos.",'".$fecha_incio."','".$fecha_termino."',".$bool_psemestral.",".$autoev_ip.",".$sede.",".$pj_edita.")";
					
					$result =@pg_Exec($conn,$qry);

					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3_Dav)'.$qry);
					}
									
					//$newCURSO=$newID;

				}else{//JARDIN O SALA CUNA
					$qry="INSERT INTO CURSO (GRADO_CURSO,cod_decreto,LETRA_CURSO,ENSENANZA,ID_ANO,BOOL_JOR,CAP_CURSO,SEDE) VALUES (0,1000,'".$cmbLETRA."',".$cmbENS.",".$ano.",".$jornada.",'0',".$sede.")";

/*					echo "<br>";
					echo $qry;
					echo "<br>";*/
					
					$result =pg_Exec($conn,$qry);
					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD. (33)'.$qry);
					}
				}
			//}

			//SUPERVISOR
			$qryCur="SELECT max(id_curso)as curso_max FROM curso WHERE id_ano=".$ano;
			$resultCur =@pg_Exec($conn,$qryCur);
			$filaCur = @pg_fetch_array($resultCur,0);
			$newCURSO = $filaCur['curso_max'];
			
			$qry="INSERT INTO SUPERVISA (RUT_EMP,ID_CURSO) VALUES ('".$cmbSUP."',".$newCURSO.")";
			$result =@pg_Exec($conn,$qry);

			/*********CREANDO RAMOS DEL CURSO. (CORRESPONDEN A LOS SUBSECTORES OBLIGATORIOS)*********/
			
			//RAMOS SON COMUNES PARA 1, 2, 3 y 4 BASICO CON PLAN INDICATIVO
			if (($cmbENS==110) and (($cmbPLAN==5451996) or ($cmbPLAN==5521997))){
				$qry="select * from subsector where ((cod_subsector=14) or (cod_subsector=15) or (cod_subsector=16) or (cod_subsector=17) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=13))";
				$result=@pg_Exec($conn,$qry);
				
			//RAMOS PARA 5 Y 8 BASICO CON PLAN INDICATIVO CREADO 30-03-2012
			}else if (($cmbENS==110) and (($cmbPLAN==1363))){
				$qry="select * from subsector where ((cod_subsector=14) or (cod_subsector=5) or (cod_subsector=19) or (cod_subsector=6) or (cod_subsector=2280) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13) )";
				$result=@pg_Exec($conn,$qry);
				

				
			//RAMOS PARA 5 Y 6 BASICO CON PLAN INDICATIVO
			}else if (($cmbENS==110) and (($cmbPLAN==2201999) or ($cmbPLAN==812000))){
				$qry="select * from subsector where ((cod_subsector=14) or (cod_subsector=15) or (cod_subsector=20) or (cod_subsector=21) or (cod_subsector=17) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13) or (cod_subsector=19))";
				$result=@pg_Exec($conn,$qry);
				

			//RAMOS PARA 7 Y 8 BASICO CON PLAN INDICATIVO
			}else if (($cmbENS==110) and (($cmbPLAN==4812000) or ($cmbPLAN==922002))){
				$qry="select * from subsector where ((cod_subsector=14) or (cod_subsector=15) or (cod_subsector=20) or (cod_subsector=21) or (cod_subsector=17) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13))";
				$result=@pg_Exec($conn,$qry);
				
			
			//RAMOS COMUNES PARA 1 Y 2 MEDIO HC Y TP CON PLAN INDICATIVO
			}else if  (($cmbENS>=310) and (($cmbPLAN==771999) or ($cmbPLAN==832000))){
				$qry="select * from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35) or (cod_subsector=3) or (cod_subsector=8) or (cod_subsector=7) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=17) or (cod_subsector=11) or (cod_subsector=144) or (cod_subsector=13))";
				$result=@pg_Exec($conn,$qry);
			

			//RAMOS COMUNES PARA 3 Y 4 MEDIO HC CON PLAN INDICATIVO
			}else if (($cmbENS==310) and (($cmbPLAN==272001) or ($cmbPLAN==1022002))){
				$qry="select * from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35) or (cod_subsector=999) or (cod_subsector=3) or (cod_subsector=8) or (cod_subsector=7) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=11) or (cod_subsector=144) or (cod_subsector=13))";
				$result=@pg_Exec($conn,$qry);

			
			//RAMOS COMUNES (qry) Y OBLIGATORIOS ($qry_tp) PARA 3 Y 4 TP CON PLAN INDICATIVO
			}else if (($cmbENS>310) and (($cmbPLAN==272001) or ($cmbPLAN==4592002)) and (($cmbGRA==3) or ($cmbGRA==4))){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35)) UNION select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_sector=".$cmbSEC." AND incluye_tp.cod_rama=".$txtRAMA." AND incluye_tp.cod_esp=".$cmbESP." and complementario=0";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION BASICA COMUN ADULTOS 1er NIVEL 1 a 4 BASICO
			}else if (($cmbENS==160) and ($cmbPLAN==771982) and ($cmbGRA=="1")){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=5))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION BASICA COMUN ADULTOS 2º NIVEL 5º A 6º BASICO Y 3er NIVEL 7º A 8º BASICO
			}else if (($cmbENS==160) and ($cmbPLAN==771982) and (($cmbGRA=="2") or ($cmbGRA=="3")  or ($cmbGRA=="4"))){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=5) or (cod_subsector=6) or (cod_subsector=131))";
				$result=@pg_Exec($conn,$qry);
				
				
				
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 1º MEDIO 1901975
			}else if (($cmbENS==360) and ($cmbPLAN==1901975) and ($cmbGRA==1)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=131) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=3))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 2º MEDIO 1901975
			}else if (($cmbENS==360) and ($cmbPLAN==1901975) and ($cmbGRA==2)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=131) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=7) or (cod_subsector=3) or (cod_subsector=8))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 3º MEDIO 1901975
			}else if (($cmbENS==360) and ($cmbPLAN==1901975) and ($cmbGRA==3)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=2) or (cod_subsector=131) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=7) or (cod_subsector=3) or (cod_subsector=8))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 4º MEDIO 1901975
			}else if (($cmbENS==360) and ($cmbPLAN==1901975) and ($cmbGRA==4)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=2) or (cod_subsector=131) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=7) or (cod_subsector=3) or (cod_subsector=8))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 1er CICLO 121987
			}else if (($cmbENS==361) and ($cmbPLAN==121987) and ($cmbGRA=="1")){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=23) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=6))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA H-C ADULTOS 2º CICLO 121987
			}else if (($cmbENS==361) and ($cmbPLAN==121987) and ($cmbGRA=="2")){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=2) or (cod_subsector=23) or (cod_subsector=4) or (cod_subsector=38) or (cod_subsector=5) or (cod_subsector=3) or (cod_subsector=7) or (cod_subsector=8))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION MEDIA T-P ADULTOS 1º CICLO  Y 3º Y 4º MEDIO 1521989
			}else if ((($cmbENS==460) or ($cmbENS==461) or ($cmbENS==560) or ($cmbENS==561) or ($cmbENS==660) or ($cmbENS==661) or ($cmbENS==760) or ($cmbENS==761) or ($cmbENS==860) or ($cmbENS==861)) and ($cmbPLAN==1521989) and (($cmbGRA=="1") or ($cmbGRA==3) or ($cmbGRA=="4"))){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=5)) UNION select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_sector=".$cmbSEC." AND incluye_tp.cod_rama=".$txtRAMA." AND incluye_tp.cod_esp=".$cmbESP." and complementario=0";
				//$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=5))";
				$result=@pg_Exec($conn,$qry);
			
			
			
			//EDUCACION BASICA ADULTOS (ESCUELAS CARCELES) 461987 1er NIVEL, 2º NIVEL Y 3er NIVEL
			}else if (($cmbENS==163) and ($cmbPLAN==461987) and (($cmbGRA=="1") or ($cmbGRA=="2") or ($cmbGRA=="3"))){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=1) or (cod_subsector=5) or (cod_subsector=6) or (cod_subsector=131))";
				$result=@pg_Exec($conn,$qry);
			
			//   NUEVO PLAN 2392004 CREADO EN NOVIEMBRE 2008
			}else if(($cmbENS==165) and ($cmbPLAN==2392004)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=27) or (cod_subsector=15))";
				$result=@pg_Exec($conn,$qry);
			
			
			//   NUEVO PLAN 2392004 CREADO EN NOVIEMBRE 2008
			}else if(($cmbENS==365) and ($cmbPLAN==2392004)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=27) or (cod_subsector=15) or (cod_subsector=4579) or (cod_subsector=6) or (cod_subsector=254))";
				$result=@pg_Exec($conn,$qry);
			
			
			//   NUEVO PLAN 2392004 CREADO EN NOVIEMBRE 2008
			}else if(($cmbENS==167) and ($cmbPLAN==2392004)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=27) or (cod_subsector=15) or (cod_subsector=4579) or (cod_subsector=6))";
				$result=@pg_Exec($conn,$qry);
			}
	//echo $qry;
	//exit;
	
			$sql="SELECT cod_subsector FROM incluye WHERE cod_decreto=".$cmbPLAN;
			$result =pg_exec($conn,$sql);
			
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
					if ($fila['cod_subsector']!=13){
							$conceptual=1;
						}else{
							$conceptual=2;
						}
							
		   echo "<br>".$qry2="INSERT INTO ramo (MATERIAL, MODO_EVAL, TIPO_RAMO, ID_CURSO, COD_SUBSECTOR, SUB_OBLI, 	
		   BOOL_IP, CONEX, ID_ORDEN,bool_bloq) VALUES ('',".$conceptual.",1,".$newCURSO.",".$fila['cod_subsector'].
		   ",1,1,2,".($i+1).",".$bloq_ramos .")";
							
			$result2 =pg_Exec($conn,$qry2);

			}
			
			echo "<script>window.location = 'listarCursos.php3'</script>";
		}
	}
}

		if ($frmModo=="modificar"){
					$qry="SELECT * FROM SUPERVISA WHERE ID_CURSO=".$_CURSO;
					$result =@pg_Exec($conn,$qry);
					if (!$result)
						error('<b> ERROR :</b>Error al acceder a la BD.(4)'.$qry);
						else{
							if(pg_numrows($result)!=0){
								$fila1 = @pg_fetch_array($result,0);
								$profe=trim($fila1['rut_emp']);
								$qry="DELETE FROM SUPERVISA WHERE RUT_EMP='".trim($profe)."' AND ID_CURSO=".$_CURSO;
								$result =@pg_Exec($conn,$qry);
							}
							$qry="INSERT INTO SUPERVISA VALUES ('".$cmbSUP."',".$_CURSO.")";
							$result =@pg_Exec($conn,$qry);
							
							if ($cap_curso==""){
					            $cap_curso = 0;
					        } 
							

			 $qryJ="UPDATE CURSO SET BOOL_JOR=".$jornada.", truncado_per = ".$truncado_per.", truncado_final = ".$truncado_final." ,truncado_sf = ".$truncado_sf.", simce = ".$simce.", acta = ".$cmbACTA.", observaciones = '".$observaciones."', val_sub = '".$val_sub."', cap_curso = '".$cap_curso."' ,  bloq_ramos = '".$bloq_ramos."', fecha_inicio='$fecha_incio',fecha_termino='$fecha_termino',bool_psemestral=".$bool_psemestral.",autoev_ip=".$autoev_ip.",sede=".$sede.",pj_edita=".$pj_edita." WHERE ID_CURSO=".$_CURSO;
					$resultJ =@pg_Exec($conn,$qryJ) or die($qryJ);
										
							$sql = "UPDATE ramo set bool_bloq = $bloq_ramos  WHERE ID_CURSO=".$_CURSO;
							$re =@pg_Exec($conn,$sql);						
							
							
							if(!$re) echo "Ramos no Actualizados";
							
				echo "<script>window.location = 'seteaCurso.php3?curso=".$_CURSO."&caso=1&ano=".$_ANO."&institucion=".$_INSTIT."'</script>";

						}

				}


		if ($frmModo=="eliminar") {
			//ELIMINANDO EL CURSO
			$qry="DELETE FROM CURSO WHERE ID_CURSO=".$_CURSO;
			$result =@pg_Exec($conn,$qry);
		
			//ELIMINANDO LOS RAMOS DEL CURSO
			$qry="DELETE FROM RAMO WHERE ID_CURSO=".$_CURSO;
			$result =@pg_Exec($conn,$qry);
		
			echo "<script>window.location = 'listarCursos.php3'</script>";
		}
?>
 <?php require('../../../../util/header.inc');?>
<?php
 
 	$frmModo		=$_FRMMODO;
	$institucion	=$_INSTIT;
	
	if($_PERFIL==0){
		echo $cmbPLAN;
		exit;
	}
		
		$fecha_incio=($fecha_incio=='')?'':CambioFE($fecha_inicio);
		
		$fecha_termino=($fecha_termino=='')?'':CambioFE($fecha_termino);
		
		
	
 $qryIns="select tipo_instit from institucion where rdb=".$institucion;
		 $resultIns = @pg_exec($conn,$qryIns);
		  $filaIns	= @pg_fetch_array($resultIns,0);
		    $Tipo_Ins = $filaIns['tipo_instit'];


if($truncado_per) $truncado_per=1;	else	$truncado_per=0;
if(empty($jornada)) $jornada=0;

if ($frmModo=="ingresar") {

	//VERIFICAR EXISTENCIA PREVIA DE (GRADO-LETRA-ENSEÑANZA-AÑO)
	$qry="select * from (curso inner join plan_estudio on curso.cod_decreto=plan_estudio.cod_decreto) where curso.grado_curso='".$cmbGRA."' and curso.letra_curso='".$cmbLETRA."' and curso.ensenanza=".$cmbENS." and curso.id_ano=".$ano." and plan_estudio.rdb=".$rdb;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
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
						
						
					$qryEVAL="SELECT cod_eval FROM tipo_ense_eval WHERE cod_tipo=". $cmbENS. "AND grado=".$cmbGRA;
					$resultEVAL=@pg_Exec($conn,$qryEVAL);
					$filaEVAL = @pg_fetch_array($resultEVAL,0);
						
					$qry="INSERT INTO CURSO (GRADO_CURSO,LETRA_CURSO,ENSENANZA,COD_DECRETO,COD_EVAL,ID_ANO,COD_ES,COD_SECTOR,COD_RAMA,BOOL_JOR, TRUNCADO_PER,FECHA_INICIO,FECHA_TERMINO,SEDE) VALUES (".$cmbGRA.",'".$cmbLETRA."',".$cmbENS.", ".$cmbPLAN." , ".$filaEVAL['cod_eval'].",".$ano.",".$cmbESP.",".$cmbSEC.",".$txtRAMA.",".$jornada.", ".$truncado_per.",'".$fecha_incio."','".$fecha_termino."',".$sede.")";
					$result =@pg_Exec($conn,$qry);

					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
					}
									
					//$newCURSO=$newID;

				}else{//JARDIN O SALA CUNA
					$qry="INSERT INTO CURSO (GRADO_CURSO,cod_decreto,LETRA_CURSO,ENSENANZA,ID_ANO,BOOL_JOR,SEDE) VALUES (0,1000,'".$cmbLETRA."',".$cmbENS.",".$ano.",".$jornada.",".$sede.")";
					$result =@pg_Exec($conn,$qry);
					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
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
				
				
			//RAMOS PARA 5 Y 6 BASICO CON PLAN INDICATIVO
			}else if (($cmbENS==110) and (($cmbPLAN==2201999) or ($cmbPLAN==812000))){
				$qry="select * from subsector where ((cod_subsector=14) or (cod_subsector=15) or (cod_subsector=20) or (cod_subsector=21) or (cod_subsector=17) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13))";
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
			}else if (($cmbENS==160) and ($cmbPLAN==771982) and (($cmbGRA=="2") or ($cmbGRA=="3"))){
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
			}else if(($cmbENS==165) and ($cmbPLAN==2392004)){
				$qry="select subsector.cod_subsector, subsector.nombre from subsector where ((cod_subsector=27) or (cod_subsector=15))";
				$result=@pg_Exec($conn,$qry);
			}
	//echo $qry;
	//exit;
			
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
					if ($fila['cod_subsector']!=13){
							$conceptual=1;
						}else{
							$conceptual=2;
						}
							$qry2="INSERT INTO ramo (MATERIAL, MODO_EVAL, TIPO_RAMO, ID_CURSO, COD_SUBSECTOR, SUB_OBLI, BOOL_IP, CONEX, ID_ORDEN) VALUES ('',".$conceptual.",1,".$newCURSO.",".$fila['cod_subsector'].",1,1,2,".($i+1).")";
							$result2 =pg_Exec($conn,$qry2);

				}
			
			
			echo "<script>window.location = 'listarCursos.php'</script>";
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
							
							$qryJ="UPDATE CURSO SET BOOL_JOR=".$jornada.", truncado_per = ".$truncado_per.",fecha_inicio='$fecha_incio',fecha_termino='$fecha_termino',sede=".$sede." WHERE ID_CURSO=".$_CURSO;
							$resultJ =@pg_Exec($conn,$qryJ);
							//echo "<script>window.location = 'seteaCurso.php?curso=".$_CURSO."&caso=1'</script>";
						}
				}


		if ($frmModo=="eliminar") {
			//ELIMINANDO EL CURSO
			$qry="DELETE FROM CURSO WHERE ID_CURSO=".$_CURSO;
			$result =@pg_Exec($conn,$qry);
		
			//ELIMINANDO LOS RAMOS DEL CURSO
			$qry="DELETE FROM RAMO WHERE ID_CURSO=".$_CURSO;
			$result =@pg_Exec($conn,$qry);
		
			echo "<script>window.location = 'listarCursos.php'</script>";
		}
?>
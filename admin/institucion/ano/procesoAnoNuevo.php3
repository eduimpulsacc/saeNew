<?php require('../../../util/header.inc');?>
<?php
 
 	$frmModo		=$_FRMMODO;
	
	$sqlNuevo="select max(id_ano) as anonuevo from ano_escolar where id_institucion =".$_INSTIT;
	$resultNuevo=@pg_Exec($conn,$sqlNuevo);
	if (!$resultNuevo){
		error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>'.$sqlNuevo);
		exit;
	}
		$filaNuevo = @pg_fetch_array($resultNuevo,0);
		$ano = $filaNuevo['anonuevo'];

	
	$sql="select * from curso where id_ano=".$ultAno;
	$resultSql=@pg_Exec($conn,$sql);
	if (!$resultSql){
		error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>'.$sql);
	}else{//else nro 1
		for ($i=0 ; $i<pg_numrows($resultSql) ; $i++){//for nro 1
			$filaSql = @pg_fetch_array($resultSql,$i);
			

							if($_TIPOINSTIT==1){//COLEGIO
								if($filaSql['cod_decreto']=="")
									$filaSql['cod_decreto']=0;
									
								if($filaSql['cod_eval']=="")
									$filaSql['cod_eval']=0;
								
								if ($filaSql['cod_es']=="")
									$filaSql['cod_es']=0;
									
								if ($filaSql['cod_sector']=="")
									$filaSql['cod_sector']=0;
								
								if ($filaSql['cod_rama']=="")
									$filaSql['cod_rama']=0;
								
								$sql = "SELECT MAX(ID_CURSO) + 1 FROM CURSO";
								$rs_newcurso = @pg_exec($conn,$sql);
								$id_curso_new = @pg_result($rs_newcurso,0);
									
								$qryI="INSERT INTO CURSO (ID_CURSO,GRADO_CURSO,LETRA_CURSO,ENSENANZA,COD_DECRETO,COD_EVAL,ID_ANO,COD_ES,COD_SECTOR,COD_RAMA) VALUES (".$id_curso_new.",".$filaSql['grado_curso'].",'".$filaSql['letra_curso']."',".$filaSql['ensenanza'].",".$filaSql['cod_decreto'].",".$filaSql['cod_eval'].",".$ano.",".$filaSql['cod_es'].",".$filaSql['cod_sector'].",".$filaSql['cod_rama'].")";
								$resultI =@pg_Exec($conn,$qryI);
								if (!$resultI) {
									error('<b> ERROR :</b>Error al acceder a la BD. (31)'.$qryI);
								}
												
							}else{//JARDIN O SALA CUNA
								$qryI="INSERT INTO CURSO (GRADO_CURSO,LETRA_CURSO,ENSENANZA,ID_ANO) VALUES (".$filaSql['grado_curso'].",'".$filaSql['letra_curso']."',".$filaSql['ensenanza'].",".$ano.")";
								$resultI =@pg_Exec($conn,$qryI);
								if (!$resultI) {
									error('<b> ERROR :</b>Error al acceder a la BD. (32)'.$qryI);
								}
							}
						

		/*********CREANDO RAMOS DEL CURSO. (CORRESPONDEN A LOS SUBSECTORES OBLIGATORIOS)*********/
						
						//RAMOS SON COMUNES PARA 1, 2, 3 y 4 BASICO CON PLAN INDICATIVO
						if (($filaSql['ensenanza']==110) and (($filaSql['cod_decreto']==5451996) or ($filaSql['cod_decreto']==5521997))){
							$qry="select cod_subsector from subsector where ((cod_subsector=19) or (cod_subsector=14) or (cod_subsector=15) or (cod_subsector=16) or (cod_subsector=17) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=13))";
							$result=@pg_Exec($conn,$qry);
							
							
							
						//RAMOS PARA 5 Y 6 BASICO CON PLAN INDICATIVO
						}else if (($filaSql['ensenanza']==110) and (($filaSql['cod_decreto']==2201999) or ($filaSql['cod_decreto']==812000))){
							$qry="select cod_subsector from subsector where ((cod_subsector=19) or (cod_subsector=14) or (cod_subsector=15) or (cod_subsector=20) or (cod_subsector=21) or (cod_subsector=17) or (cod_subsector=18) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13))";
							$result=@pg_Exec($conn,$qry);
							
			
						//RAMOS PARA 7 Y 8 BASICO CON PLAN INDICATIVO
						}else if (($filaSql['ensenanza']==110) and (($filaSql['cod_decreto']==4812000) or ($filaSql['cod_decreto']==922002))){
							$qry="select cod_subsector from subsector where ((cod_subsector=19) or (cod_subsector=14) or (cod_subsector=15) or (cod_subsector=20) or (cod_subsector=21) or (cod_subsector=17) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=11) or (cod_subsector=22) or (cod_subsector=13))";
							$result=@pg_Exec($conn,$qry);
							
						
						//RAMOS COMUNES PARA 1 Y 2 MEDIO HC Y TP CON PLAN INDICATIVO
						}else if  (($filaSql['ensenanza']>=310) and (($filaSql['cod_decreto']==771999) or ($filaSql['cod_decreto']==832000))){
							$qry="select cod_subsector from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35) or (cod_subsector=3) or (cod_subsector=8) or (cod_subsector=7) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=17) or (cod_subsector=11) or (cod_subsector=144) or (cod_subsector=13))";
							$result=@pg_Exec($conn,$qry);
						
			
						//RAMOS COMUNES PARA 3 Y 4 MEDIO HC CON PLAN INDICATIVO
						}else if (($filaSql['ensenanza']==310) and (($filaSql['cod_decreto']==272001) or ($filaSql['cod_decreto']==1022002))){
							$qry="select cod_subsector from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35) or (cod_subsector=999) or (cod_subsector=3) or (cod_subsector=8) or (cod_subsector=7) or (cod_subsector=28) or (cod_subsector=29) or (cod_subsector=11) or (cod_subsector=144) or (cod_subsector=13))";
							$result=@pg_Exec($conn,$qry);
			
						
						//RAMOS COMUNES (qry) Y OBLIGATORIOS ($qry_tp) PARA 3 Y 4 TP CON PLAN INDICATIVO
						}else if (($filaSql['ensenanza']>310) and (($filaSql['cod_decreto']==272001) or ($filaSql['cod_decreto']==4592002)) and (($filaSql['grado_curso']==3) or ($filaSql['grado_curso']==4))){
							$qry="select subsector.cod_subsector from subsector where ((cod_subsector=27) or (cod_subsector=5) or (cod_subsector=35)) UNION select subsector.cod_subsector from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_sector=".$filaSql['cod_sector']." AND incluye_tp.cod_rama=".$filaSql['cod_rama']." AND incluye_tp.cod_esp=".$filaSql['cod_es']." and complementario=0";
							$result=@pg_Exec($conn,$qry);
						}
						$qry2="SELECT MAX(ID_CURSO) AS CURSO_NEW FROM CURSO WHERE ID_ANO=".$ano;
							$result2 =@pg_Exec($conn,$qry2);
							$fila2 = @pg_fetch_array($result2,0);	
							$newCURSO = trim($fila2['curso_new']);
						
						for($j=0 ; $j < @pg_numrows($result) ; $j++){
							$filaR = @pg_fetch_array($result,$j);
								if ($filaR['cod_subsector']!=13){
										$conceptual=1;
									}else{
										$conceptual=2;
									}
										$qry2="INSERT INTO ramo (MATERIAL, MODO_EVAL, TIPO_RAMO, ID_CURSO, COD_SUBSECTOR, SUB_OBLI, BOOL_IP, CONEX) VALUES ('',".$conceptual.",1,".$newCURSO.",".$filaR['cod_subsector'].",1,1,2)";
										$result2 =pg_Exec($conn,$qry2);
							}
						
			}//for nro 1
		}//else nro 1
		pg_close($conn);
			echo "<script>window.location = 'listarAno.php3'</script>";  
?>

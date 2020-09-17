<?php require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$regimen		=$cmbREGIMEN;
	


	// VALIDAR LA EXISTENCIA DE UN AÑO ACADEMICO ABIERTO POR INSTITUCION
	$qry="SELECT COUNT(*) AS CANT FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT." AND SITUACION=1";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
	$cantAbiertos=$fila['cant'];

	$qry="SELECT ID_ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT." AND SITUACION=1";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
	$idAbierto=$fila['id_ano'];
	
	/*********------trae el año actual para crear cursos nuevos en el nuevo año------*********/
	$qryUlt="SELECT max(id_ano) AS ult_ano FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT;
	$resultUlt = @pg_Exec($conn,$qryUlt);
	$filaUlt	= @pg_fetch_array($resultUlt,0);
	$ultAno=$filaUlt['ult_ano'];
	/***************_-------------------_****************/
	
/*	$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];
*/
	if ($frmModo=="ingresar"){
		if($cantAbiertos==0){//NO EXISTEN AÑOS ACADEMICOS REGISTRADOS ABIERTOS 
		  if (pg_numrows($resultUlt)==0){
		   $ultAno = 0;	
		  }
				$qry="INSERT INTO ANO_ESCOLAR (NRO_ANO, FECHA_INICIO, FECHA_TERMINO, ID_INSTITUCION, SITUACION, ANO_ANTERIOR, TIPO_REGIMEN) VALUES (".$txtANO.",'".fEs2En($txtFECHAINI)."','".fEs2En($txtFECHATER)."',".$rdb.",".$rdSIT.",'".$ultAno."',".$cmbREGIMEN.")";
				$result =@pg_Exec($conn,$qry);
				if (!$result)
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				else{
					if($regimen=="2"){//TRIMESTRAL
						//INGRESO AUTOMATICO DE PERIODOS
						$qry="SELECT MAX(ID_ANO) AS ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$rdb;
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
						}else{
							$fila = @pg_fetch_array($result,0);	
							if (!$fila){
								error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
								exit();
							}
							$newANO = trim($fila['ano']);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER TRIMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHAINI)."')";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO TRIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('TERCER TRIMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHATER)."')";
							$result =@pg_Exec($conn,$qry);
						}
					}


					if($regimen=="3"){//SEMESTRAL
						//INGRESO AUTOMATICO DE PERIODOS
						$qry="SELECT MAX(ID_ANO) AS ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$rdb;
						$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
						}else{
							$fila = @pg_fetch_array($result,0);	
							if (!$fila){
								error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
								exit();
							}
							$newANO = trim($fila['ano']);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER SEMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHAINI)."')";
							$result =@pg_Exec($conn,$qry);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('SEGUNDO SEMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHATER)."')";
							$result =@pg_Exec($conn,$qry);
						}
					}
					if ($ultAno!=0){
					    pg_close($conn);
						echo "<script>window.location = 'procesoAnoNuevo.php3? ultAno=".$ultAno."'</script>";
					}else{
					    pg_close($conn);
						echo "<script>window.location = 'listarAno.php'</script>";
					}
			}
		}else{
			if($rdSIT==0){//EL NUEVO AÑO VIENE CERRADO
					$qry="INSERT INTO ANO_ESCOLAR (NRO_ANO, FECHA_INICIO, FECHA_TERMINO, ID_INSTITUCION, SITUACION, TIPO_REGIMEN) VALUES (".$txtANO.",'".fEs2En($txtFECHAINI)."','".fEs2En($txtFECHATER)."',".$rdb.",".$rdSIT.", ".$cmbREGIMEN.")";
					$result =@pg_Exec($conn,$qry);

					if (!$result)
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
					else{
					
						if($regimen=="2"){//TRIMESTRAL
							//INGRESO AUTOMATICO DE PERIODOS
							$qry="SELECT MAX(ID_ANO) AS ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$rdb;
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
							}else{
								$fila = @pg_fetch_array($result,0);	
								if (!$fila){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
								$newANO =  $fila['ano'];
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER TRIMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHAINI)."')";
								$result =@pg_Exec($conn,$qry);
								
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO TRIMESTRE',".$newANO.",0,0)";
								$result =@pg_Exec($conn,$qry);

								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('TERCER TRIMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHATER)."')";
								$result =@pg_Exec($conn,$qry);

							}
						}



						if($regimen=="3"){//SEMESTRAL
							//INGRESO AUTOMATICO DE PERIODOS
							$qry="SELECT MAX(ID_ANO) AS ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$rdb;
							$result =@pg_Exec($conn,$qry);
							if (!$result) {
								error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
							}else{
								$fila = @pg_fetch_array($result,0);	
								if (!$fila){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
								$newANO =  $fila['ano'];
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER SEMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHAINI)."')";
								$result =@pg_Exec($conn,$qry);

								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('SEGUNDO SEMESTRE',".$newANO.",0,0,'".fEs2En($txtFECHATER)."')";
								$result =@pg_Exec($conn,$qry);
							}
						}
						  $qryN = "SELECT ano_anterior FROM  ANO_ESCOLAR WHERE id_ano=".$newAno;
						  $resultN =@pg_Exec($conn,$qryN);
						  $filaN = @pg_fetch_array($resultN,0);
						  $anterior=$filaN['ano_anterior'];
						if (($anterior!=0) or ($anterior!="") or ($ultAno!=0)){
						     pg_close($conn);
						     echo "<script>window.location = 'procesoAnoNuevo.php3?ultAno=".$ultAno."'</script>";
						}else{
						     pg_close($conn);
						     echo "<script>window.location = 'listarAno.php'</script>";
						}
				}
			}else{//EL NUEVO AÑO ACADEMICO VIENE ABIERTO Y EXISTE OTRO AÑO ACADEMICO ABIERTO. (ERROR)
				echo "<html><title>ERROR</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ERROR: YA EXISTE UN AÑO ACADEMICO ABIERTO...";
				echo "<BR>"; ?>
				<script> setTimeout("window.location='listarAno.php'",2000);</script>
				<?php //echo "<INPUT TYPE=button value=VOLVER onClick=history.back();>";
				echo "</center></body></html>";
			}

		}
	}

	if ($frmModo=="modificar"){
		if((int)$idAbierto==(int)$_ANO)
			$cantAbiertos--;
		if($cantAbiertos==0){//NO EXISTEN AÑOS ACADEMICOS REGISTRADOS ABIERTOS 
			$qry="UPDATE ano_escolar SET nro_ano = ".$txtANO.", fecha_inicio = '".fEs2En($txtFECHAINI)."', situacion = ".$rdSIT.", fecha_termino = '".fEs2En($txtFECHATER)."' WHERE (((id_ano)=".$_ANO."))";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			}else{
			    pg_close($conn);
				echo "<script>window.location = 'seteaAno.php?caso=1&ano=".$_ANO."'</script>";
			}
		}else{
			if($rdSIT==0){//EL NUEVO AÑO VIENE CERRADO
				$qry="UPDATE ano_escolar SET nro_ano = ".$txtANO.", fecha_inicio = '".fEs2En($txtFECHAINI)."', situacion = ".$rdSIT.", fecha_termino = '".fEs2En($txtFECHATER)."' WHERE (((id_ano)=".$_ANO."))";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
				    pg_close($conn);
					echo "<script>window.location = 'seteaAno.php?caso=1&ano=".$_ANO."'</script>";
				}
			}else{
				echo "<html><title>ERRO1R</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ERROR: YA EXISTE UN AÑO ACADEMICO ABIERTO...";
				echo "<BR>"; ?>
				<script> setTimeout("window.location='listarAno.php'",2000);</script>
				<?php //echo "<INPUT TYPE=button value=VOLVER onClick=history.back();>";
				echo "</center></body></html>";
			}
		}
	}

	if ($frmModo=="eliminar") {
		$qry="DELETE FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.'.$qry);
		}else{
		    pg_close($conn);
			echo "<script>window.location = 'listarAno.php'</script>";
		}
	}
?>
<?php 
require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$regimen		=$cmbREGIMEN;
	$corporacion    =$_CORPORACION;
	
	
	if($txtHORAENTRADA==""){
		$txtHORAENTRADA="00:00";
	}
     $txtHORAENTRADA.'.00';

	// VALIDAR LA EXISTENCIA DE UN AÑO ACADEMICO ABIERTO POR INSTITUCION
	$qry="SELECT COUNT(*) AS CANT FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT." AND SITUACION=1";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
	$cantAbiertos=$fila['cant'];

	$qry="SELECT ID_ANO FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT." AND SITUACION=1";
	$result = @pg_Exec($conn,$qry);
	$fila	= @pg_fetch_array($result,0);
	$idAbierto=$fila['id_ano'];
	
	$nro_ano =$txtANO -1;
	/*********------trae el año actual para crear cursos nuevos en el nuevo año------*********/
	$qryUlt="SELECT id_ano, nro_ano FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$_INSTIT;
	$resultUlt = @pg_Exec($conn,$qryUlt);
	for($a=0;$a<@pg_numrows($resultUlt);$a++){
		$filaUlt	= @pg_fetch_array($resultUlt,$a);
		if($nro_ano ==$filaUlt['nro_ano']){
			$ultAno=$filaUlt['id_ano'];
		}
	}
	//$ultAno=1205;
	/***************_-------------------_****************/
	
/*	$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];
*/
	if ($frmModo=="ingresar"){
	    
			if(pg_dbname($conn)=='coi_antofagasta'){
				$fechainicio=fEs2En($txtFECHAINI);
				$fechatermino=fEs2En($txtFECHATER);
			} else{
				$fechainicio=fEs2En($txtFECHAINI);
				$fechatermino=fEs2En($txtFECHATER);
			}	
	
	/*if(pg_dbname($conn)=='coi_final'){
		
		$fechainicio=$txtFECHAINI;
		$fechatermino=$txtFECHATER;
		}
		*/ 
		
	
		if($cantAbiertos==0){//NO EXISTEN AÑOS ACADEMICOS REGISTRADOS ABIERTOS 
		  if (pg_numrows($resultUlt)==0){
		   $ultAno = 0;	
		  }
		  		if($ultAno=="")
				{
					$ultAno = $txtANO - 1;
				}
						
				
						
				
			 $qry="INSERT INTO ANO_ESCOLAR (NRO_ANO, FECHA_INICIO, FECHA_TERMINO, ID_INSTITUCION, SITUACION, ANO_ANTERIOR, TIPO_REGIMEN,HORA_ENTRADA,JUSTIFICA_INASISTENCIA) VALUES (".$txtANO.",'".$fechainicio."','".$fechatermino."',".$rdb.",".$rdSIT.",'".$ultAno."',".$cmbREGIMEN.",'".$txtHORAENTRADA.':00'."',".$cmbJUSTINA.")";
				$result =@pg_Exec($conn,$qry);

				if (!$result)
					error('<b> ERROR :</b>Error al acceder a la BD. (3.1)'.$qry);
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
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER TRIMESTRE',".$newANO.",0,0,'".$fechainicio."')";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO TRIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('TERCER TRIMESTRE',".$newANO.",0,0,'".$fechatermino."')";
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
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER SEMESTRE',".$newANO.",0,0,'".$fechainicio."')";
							$result =@pg_Exec($conn,$qry);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('SEGUNDO SEMESTRE',".$newANO.",0,0,'".$fechatermino."')";
							$result =@pg_Exec($conn,$qry);
						}
					}
					if($regimen=="4"){//BIMESTRAL
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
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER BIMESTRE',".$newANO.",0,0,'".$fechainicio."')";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO BIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('TERCER BIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							
							
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('CUARTO BIMESTRE',".$newANO.",0,0,'".$fechatermino."')";
							$result =@pg_Exec($conn,$qry);
						}
					}
					if ($ultAno!=0){
					    pg_close($conn);
						echo "<script>window.location = 'procesoAnoNuevo.php3?ultAno=".$ultAno."'</script>";
					}else{
					    pg_close($conn);
						echo "<script>window.location = 'listarAno.php3'</script>";
					}
			}
		}else{
			if($rdSIT==0){//EL NUEVO AÑO VIENE CERRADO
					$qry="INSERT INTO ANO_ESCOLAR (NRO_ANO, FECHA_INICIO, FECHA_TERMINO, ID_INSTITUCION, SITUACION, TIPO_REGIMEN,HORA_INICIO,JUSTIFICA_INASISTENCIA) VALUES (".$txtANO.",'".$fechainicio."','".$fechatermino."',".$rdb.",".$rdSIT.", ".$cmbREGIMEN.",'".$txtHORAENTRADA.':00'."',".$cmbJUSTINA.")";
					$result =@pg_Exec($conn,$qry);

					if (!$result)
						error('<b> ERROR :</b>Error al acceder a la BD. (3.2)'.$qry);
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
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER TRIMESTRE',".$newANO.",0,0,'".$fechainicio."')";
								$result =@pg_Exec($conn,$qry);
								
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO TRIMESTRE',".$newANO.",0,0)";
								$result =@pg_Exec($conn,$qry);

								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('TERCER TRIMESTRE',".$newANO.",0,0,'".$fechatermino."')";
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
								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER SEMESTRE',".$newANO.",0,0,'".$fechainicio."')";
								$result =@pg_Exec($conn,$qry);

								$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('SEGUNDO SEMESTRE',".$newANO.",0,0,'".$fechatermino."')";
								$result =@pg_Exec($conn,$qry);
							}
						}
						if($regimen=="4"){//BIMESTRAL
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
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_INICIO) VALUES ('PRIMER BIMESTRE',".$newANO.",0,0,'".$fechainicio."')";
							$result =@pg_Exec($conn,$qry);
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('SEGUNDO BIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES) VALUES ('TERCER BIMESTRE',".$newANO.",0,0)";
							$result =@pg_Exec($conn,$qry);
							
							
							
							$qry="INSERT INTO PERIODO (NOMBRE_PERIODO, ID_ANO, MOSTRAR_NOTAS,DIAS_HABILES,FECHA_TERMINO) VALUES ('CUARTO BIMESTRE',".$newANO.",0,0,'".$fechatermino."')";
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
						    echo "<script>window.location = 'listarAno.php3'</script>";
						}
				}
			}else{//EL NUEVO AÑO ACADEMICO VIENE ABIERTO Y EXISTE OTRO AÑO ACADEMICO ABIERTO. (ERROR)
				echo "<html><title>ERROR</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ERROR: YA EXISTE UN AÑO ACADEMICO ABIERTO...";
				echo "<BR>"; ?>
<script> setTimeout("window.location='listarAno.php3'",2000);</script>
				<?php //echo "<INPUT TYPE=button value=VOLVER onClick=history.back();>";
				echo "</center></body></html>";
			}

		}
	}
//echo pg_dbname($conn);	
	if ($frmModo=="modificar"){
	if (pg_dbname($conn)=='coi_antofagasta'){
		
	
		//$fechainicio=($txtFECHAINI);
		//$fechatermino=($txtFECHATER);
		$fechainicio=fEs2En($txtFECHAINI);
		$fechatermino=fEs2En($txtFECHATER);
	} else{
		$fechainicio=fEs2En($txtFECHAINI);
		$fechatermino=fEs2En($txtFECHATER);
	}	
	
	/*if(pg_dbname($conn)=='coi_final'){
		
		$fechainicio=$txtFECHAINI;
		$fechatermino=$txtFECHATER;
		}*/

		if((int)$idAbierto==(int)$_ANO)
			$cantAbiertos--;
		if($cantAbiertos==0){
			//echo "dentro if";
			//NO EXISTEN AÑOS ACADEMICOS REGISTRADOS ABIERTOS 
			
		$qry="UPDATE ano_escolar SET nro_ano = ".$txtANO.", fecha_inicio = '".$fechainicio."', situacion = ".$rdSIT.", fecha_termino = '".$fechatermino."', hora_entrada='".$txtHORAENTRADA."', JUSTIFICA_INASISTENCIA = ".$cmbJUSTINA." WHERE (((id_ano)=".$_ANO."))";
			$result =pg_Exec($conn,$qry) or die("UPDATE FALLO : ".$qry);
			/*if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD. (3.3)'.$qry);
			}else{*/
			    pg_close($conn);
				echo "<script>window.location = 'seteaAno.php3?caso=1&ano=".$_ANO."'</script>";
			//}
		}else{

			if($rdSIT==0){//EL NUEVO AÑO VIENE CERRADO
			 $qry="UPDATE ano_escolar SET nro_ano = ".$txtANO.", fecha_inicio = '".$fechainicio."', situacion = ".$rdSIT.", fecha_termino = '".$fechatermino."', hora_entrada= '".$txtHORAENTRADA."', JUSTIFICA_INASISTENCIA = ".$cmbJUSTINA." WHERE (((id_ano)=".$_ANO."))";
			 $result =pg_Exec($conn,$qry);
				/*if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3.4)'.$qry);
				}else{*/
				    pg_close($conn);
				echo "<script>window.location = 'seteaAno.php3?caso=1&ano=".$_ANO."'</script>";
				//}
			}else{
				echo "<html><title>ERROR</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ERROR: YA EXISTE UN AÑO ACADEMICO ABIERTO...";
				echo "<BR>"; ?>
				<script> setTimeout("window.location='listarAno.php3'",2000);</script>
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
			pg_close($conn);
		}else{
		    pg_close($conn);
			echo "<script>window.location = 'listarAno.php3'</script>";
		}
	}

?>
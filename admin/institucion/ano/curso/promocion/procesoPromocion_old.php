<?php require('../../../../../util/header.inc'); ?>
<?php
		$institucion= $_INSTIT;
		$frmModo	= $_FRMMODO;
		$ano		= $_ANO;
		$curso		= $_CURSO;
		

	if ($frmModo=="ingresar") {
		$i_retir = 0;
		$i_aprob = 0;

		for ($i=0;$i<$contalum;$i++){
			$SQL = "SELECT * FROM promocion WHERE rut_alumno='" . Trim($rutalum[$i]) . "' AND id_curso=".$curso;
			$rs_promocion = @pg_exec($conn,$SQL);
			if (!$rs_promocion){
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$SQL);
				exit();
			};
			
			if (@pg_numrows($rs_promocion)!=0){ /*--- Modifica situación del alumno ---*/
			         
				if ($cmbsituacion[$i]==1){ /*--- El alumno está aprobado ---*/
					if ($gradomax!=0 && $gradomax==$grado && $ensenanza>=410){ /*--- El curso es técnico profesional y debe agregar la especialidad ---*/
						$SQL = "UPDATE promocion SET promedio=" . intval(Trim($promedio[$i])) . ", asistencia=" . intval(Trim($asistencia[$i])) . ", situacion_final=" . intval(Trim($cmbsituacion[$i])) . " WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalum[$i])."'";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						$rut_aprobado[$i_aprob] = Trim($rutalum[$i]);
						$i_aprob = $i_aprob + 1;
					}else{ /*--- El curso no es tecnico profesional ---*/
						$SQL = "UPDATE promocion SET promedio=" . intval(Trim($promedio[$i])) . ", asistencia=" . intval(Trim($asistencia[$i])) . ", situacion_final=" . intval(Trim($cmbsituacion[$i])) . " WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalum[$i])."'";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						if (!$ejecutapromocion){
						error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$SQL);
						exit();
						};
						//echo $SQL;
					};
  
				}else{
					if ($cmbsituacion[$i]==2){ /*--- El alumno esta reprobado ---*/
						$SQL = "UPDATE promocion SET promedio=" . intval(Trim($promedio[$i])) . ", asistencia=" . intval(Trim($asistencia[$i])) . ", situacion_final=" . intval(Trim($cmbsituacion[$i])) . " WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalum[$i])."'";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						//echo $SQL;
					}else{
						if ($cmbsituacion[$i]==3){ /*--- El alumno ha sido retirado del curso ---*/
							$SQL = "UPDATE promocion SET situacion_final=" . intval(Trim($cmbsituacion[$i])) . " WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno='".Trim($rutalum[$i])."'";
							$ejecutapromocion = @pg_Exec($conn,$SQL);
							$rut_retirado[$i_retir] = Trim($rutalum[$i]);
							$i_retir = $i_retir + 1;								
						};
					}; 
				};

			}else{ /*--- Inserta situacion del alumno ---*/

				if (intval($cmbsituacion[$i])==1){
					if ($gradomax!=0 && $gradomax==$grado && $ensenanza>=410){ /*--- El curso es técnico profesional y debe agregar la especialidad ---*/
						$SQL = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rutalum[$i]) . "'," . intval(Trim($promedio[$i]))  . "," . intval(Trim($asistencia[$i])) . "," . intval(Trim($cmbsituacion[$i])) . ")";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						$rut_aprobado[$i_aprob] = Trim($rutalum[$i]);
						$i_aprob = $i_aprob + 1;						
					}else{ /*--- El curso no es tecnico profesional ---*/
						$SQL = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rutalum[$i]) . "'," . intval(Trim($promedio[$i]))  . "," . intval(Trim($asistencia[$i])) . "," . intval(Trim($cmbsituacion[$i])) . ")";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						if (!$ejecutapromocion){
						error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$SQL);
						exit();
							};
						//	echo $SQL;
					};
				}else{
					if ($cmbsituacion[$i]==2){ /*--- El alumno esta reprobado ---*/
						$SQL = "INSERT INTO promocion (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rutalum[$i]) . "'," . intval(Trim($promedio[$i]))  . "," . intval(Trim($asistencia[$i])) . "," . intval(Trim($cmbsituacion[$i])) . ")";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
						//echo $SQL;
					}else{
						if (intval($cmbsituacion[$i])==3){
						$SQL = "INSERT INTO promocion  (rdb,id_ano,id_curso,rut_alumno,situacion_final) VALUES (" . $institucion . "," . $ano . "," . $curso . ",'" . Trim($rutalum[$i]) . "'," . intval(Trim($cmbsituacion[$i])) . ")";
						$ejecutapromocion = @pg_Exec($conn,$SQL);
							$rut_retirado[$i_retir] = Trim($rutalum[$i]);
							$i_retir = $i_retir + 1;
						};

					};
				};
		
			};

		};

		//if (count($rut_aprobado)!=0){
			$_RUT_APROBADO = $rut_aprobado;
			session_register('_RUT_APROBADO');
		//};

		//if (count($rut_retirado)!=0){
			$_RUT_RETIRADO = $rut_retirado;
			session_register('_RUT_RETIRADO');
		//};
		
		if (count($rut_aprobado)!=0 || count($rut_retirado)!=0){
			echo "<script>window.location = 'fechaespec.php?institucion=" . $_INSTIT . "&ano=" . $_ANO . "&curso=" . $_CURSO  . "&caso=2'</script>";
		}else{
			echo "<script>window.location = 'seteapromocion.php3?institucion=" . $_INSTIT . "&ano=" . $_ANO . "&curso=" . $_CURSO . "&caso=1'</script>";
		};
	};


	//if ($frmModo=="modificar"){
	//	for ($i=0;$i<$contalum;$i++){
	//		$SQL = "SELECT * FROM promocion WHERE rut_alumno='" . $rutalum[$i] . "'";
	//		$rs_promocion = @pg_exec($conn,$SQL);
	//		if (!$rs_promocion){
	//			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	//			exit();
	//		};
	//		if (@pg_NumRows!=0){ /*--- Inserta situacion del alumno ---*/
	//			$SQL = "UPDATE promocion SET ";
	//		}else{ /*--- Modifica datos del alumno ---*/
	//			$SQL = "INSERT INTO promocion () VALUES ()";
	//		};

	//	};
	//echo "<script>window.location = 'seteapromocion.php3?institucion=" . $_INSTIT . "&ano=" . $_ANO . "&curso=" . 	//$_CURSO . "&caso=1'</script>";
	//};

	//if ($frmModo=="eliminar") {
	//	echo "<script>window.location = 'promocion.php'</script>";
	//};

?>
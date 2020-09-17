<? include"../../Coneccion/conexion.php"?>
<?	

	$li_id_usuario	  = $_GET["hf_usuario"];
	$hoy		      = getdate();
	$dia_actual       = $hoy["mday"];
	$mes_actual       = date(m);	
	$year_actual      = $hoy["year"];
	$ldt_periodo      = $year_actual.$mes_actual;
	
	$ldt_hora_hours    = date(H);
	$ldt_hora_minutes  = date(i);
	$ldt_hora_seconds  = date(s);
	$ldt_hora		   = $ldt_hora_hours.$ldt_hora_minutes.$ldt_hora_seconds;
	$dia_actual_1_digito = date(j);


		$sql             = "Select * From con_parametro where dia_cierre = $dia_actual_1_digito ;";
		$resultado_query = pg_exec($conexion,$sql);
		$total_filas     = pg_numrows($resultado_query);

		IF($total_filas <= 0)
		{
		echo("<Center><Font Size='2'><BR><B> No Se encontraron Instituciones con Día de Cierre de SALDOS para Hoy... </B></Center>");
		}ELSE
		{

			FOR($i=0; $i < $total_filas; $i++)
			{
			
			$li_id_colegio = pg_result($resultado_query, $i, 0);
			
			$sql = "Select distinct a.rdb, a.id_ctacte, a.rut_apoderado, c.rut_alumno FROM con_apoderado_ctacte a, con_estado_pago b, con_estado_pago_detalle c WHERE a.rdb = $li_id_colegio And a.id_ctacte = b.id_ctacte And b.vigente = 'S' And b.periodo = '$ldt_periodo' And a.id_ctacte = c.id_ctacte and b.periodo = c.periodo order by 1,2 ";		
			//echo("<b>SQL 1:</b> $sql <BR>");
			$resultado_query_ctacte = pg_exec($conexion,$sql);
			$total_filas_ctacte     = pg_numrows($resultado_query_ctacte);
			
				if($total_filas_ctacte<=0)
				{
					echo("<BR> No existen Ctactes para este Colegio <BR><BR>");
				}else
				{
					for($j=0; $j < $total_filas_ctacte; $j++) //Recorre SQL linea 33
					{
					$ls_ctacte        = pg_result($resultado_query_ctacte, $j, 1);
					$ls_rut_apoderado = pg_result($resultado_query_ctacte, $j, 2);
					$ls_rut_alumno 	  = pg_result($resultado_query_ctacte, $j, 3);

					echo("<br>Alumno : ($ls_rut_alumno) - Apoderado : ($ls_rut_apoderado) <BR>");
					
					$sql= "Select Distinct a.id_ctacte, b.* , c.monto as monto_apagar From con_comprobante a, con_comprobante_pago b , con_estado_pago_detalle c Where a.id_ctacte = '$ls_ctacte' And a.ep_periodo = '$ldt_periodo' And a.ep_periodo = c.periodo And a.id_comprobante = b.id_comprobante And b.rut_alumno = '$ls_rut_alumno' And a.id_ctacte = c.id_ctacte and b.rut_alumno = c.rut_alumno and b.id_cuenta = c.cuenta_id ";
					//echo("<BR> <font color='#FF0000'>SQL 2 :</font> $sql <BR><BR>");					
					$resultado_query_com = pg_exec($conexion,$sql);
					$total_filas_com     = pg_numrows($resultado_query_com);
					
						if($total_filas_com <= 0)
						{
								$li_monto_cancelado  = 0;
								$li_monto_acancelar  = 0;
								$li_monto_saldo		 = 0;								
						}else
						{
								$li_monto_cancelado  = 0;
								$li_monto_acancelar  = 0;
								
							for($x=0; $x < $total_filas_com; $x++) // * Cuenta y Alumno
							{
								$ls_rut_alumno 		 = pg_result($resultado_query_com, $x, 2);
								$li_id_cuenta  		 = pg_result($resultado_query_com, $x, 3);
								$li_monto_cancelado  = pg_result($resultado_query_com, $x, 4);
								$li_monto_acancelar  = pg_result($resultado_query_com, $x, 5);
								$li_monto_saldo 	 = ($li_monto_acancelar - $li_monto_cancelado);
								$ls_op	 			 = " Ingresó Pagos...";													
								
						
							echo("<br><Font color='#993300'>Aplicando : $li_monto_acancelar - $li_monto_cancelado = ($li_monto_saldo) </font> -- <Font color='#FF0000'>($ls_op)</Font> <BR> -------------------------------------------------------------------------------------- <BR><BR>");
						
						
						$sql= "Select * From con_saldo Where id_ctacte = '$ls_ctacte' And periodo = '$ldt_periodo' and rut_alumno = '$ls_rut_alumno' and cuenta_id = $li_id_cuenta ";
						$resultado_query_Verifica = pg_exec($conexion,$sql);
						$total_filas_Verifica     = pg_numrows($resultado_query_Verifica);


						if($total_filas_Verifica <= 0)
						{				
						
							$sql_insert= "INSERT INTO con_saldo VALUES('$ls_ctacte', '$ldt_periodo', '$ls_rut_alumno', $li_id_cuenta, $li_monto_saldo) ";
							$rs_insert = pg_exec($conexion,$sql_insert);
						
						}else
						{
						
							$sql_insert= "UPDATE con_saldo SET monto = $li_monto_saldo WHERE id_ctacte = '$ls_ctacte' And periodo = '$ldt_periodo' and rut_alumno = '$ls_rut_alumno' and cuenta_id = $li_id_cuenta ";
							$rs_insert = pg_exec($conexion,$sql_insert);
						
						}//echo(" $sql_insert <BR>");

							} //Cierra FOR 63
							
				} // Cierra IF Linea 54


										
					}

				}// Cierra IF Linea 32
			
			
			}//Cierra el FOR 22
		
		echo("<Center><Font Size='2'><BR><B> Todos los procesos SALDO terminaron exitosamente. </B><br><br>
Todas las cargas efectuadas...</Center>");		
		}//Cierra if 16
	
?>
		


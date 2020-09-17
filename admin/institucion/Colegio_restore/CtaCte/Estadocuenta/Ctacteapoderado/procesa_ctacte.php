<? include"../../../Coneccion/conexion.php"?>
<?
echo("<br> PROCESANDO...<br> ESPERE MENSAJE DE TERMINO. <br>");
?>
<?
	
	$hoy		 = getdate();
	$dia_actual  = date(j);
	$mes_actual  = date(m);	
	$year_actual_consulta = $hoy["year"];


	$sql_colegios= "Select b.*, a.rdb, a.nombre_instit From institucion a, con_parametro b Where a.rdb = b.rdb And b.dia_emision = $dia_actual order by 6 ;";
	//echo("SQL ENTRADA : $sql_colegios <BR>");
	$resultado_query_colegios = pg_exec($conexion,$sql_colegios);
	$total_filas_colegios     = pg_numrows($resultado_query_colegios);

	if($total_filas_colegios <= 0)
	{
	ECHO("<BR><Font color='#FF0000'>Procesos x COLEGIOS Terminados ...</Font><BR><BR>");
	}

FOR($i=0; $i < $total_filas_colegios; $i++)
{

	$li_id_colegio     = pg_result($resultado_query_colegios, $i, 0);
	$ls_nombre_colegio = Trim(pg_result($resultado_query_colegios, $i, 5));
	$ldt_dia_emision   = pg_result($resultado_query_colegios, $i, 1);	
	$ldt_dia_vencimie  = pg_result($resultado_query_colegios, $i, 2);
	
		
		If (strlen($ldt_dia_emision)< 2)
		{
			$ldt_dia_emision = "0".$ldt_dia_emision;
		}
		
		If (strlen($ldt_dia_vencimie)< 2)
		{
			$ldt_dia_vencimie = "0".$ldt_dia_vencimie;
		}
	
		ECHO("<Font color='#FF0000'>Iniciando Proceso Ctacte de Apoderados ...<BR> Colegio : ($li_id_colegio) Nombre : ($ls_nombre_colegio) </Font><BR>");
	

	$sql= "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $li_id_colegio And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual_consulta And e.situacion = 1 and a.rut_alumno = b.rut_alumno and b.rut_apo = c.rut_apo Order by 4 ;";

	//ECHO("<br> SQL : $sql <br><br>");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);
	echo("<BR> Total Apoderados ($total_filas)... <BR><BR>");

		If($total_filas<=0)
		{
		echo("<br> No se encontraron apoderados para el Año abierto... <br>");
		}
			
		$sql_correlativo= "Select correlativo from con_apoderado_ctacte Order By correlativo DESC;";
		$resultado_query_corr = pg_exec($conexion,$sql_correlativo);
		$total_filas_corr     = pg_numrows($resultado_query_corr);
		
		If($total_filas_corr<=0)
		{
		$li_correlativo = 0;
		}Else
		{
		$li_correlativo = pg_result($resultado_query_corr, 0, 0);
		}
		$li_correlativo       = $li_correlativo + 1;
		$li_id_correlativo    = $li_correlativo;
			
			// Comienza a Recorrer los Datos del Query
			For ($j=0; $j < $total_filas; $j++)
			{

			$li_id_colegio    = Trim(pg_result($resultado_query, $j, 0));
			$ls_rut_apoderado = Trim(pg_result($resultado_query, $j, 2));
			$ldt_ano_escolar  = Trim(pg_result($resultado_query, $j, 6));
			
			$sql_valida= "Select * from con_apoderado_ctacte where rdb = $li_id_colegio and Trim(rut_apoderado) = Trim('$ls_rut_apoderado');";
			
			$resultado_query_valida = pg_exec($conexion,$sql_valida);
			$total_filas_valida     = pg_numrows($resultado_query_valida);
			
				if($total_filas_valida<=0)
				{
			
			$li_espacio_cero  = substr("000", 1, 3 - strlen($li_id_correlativo)).$li_id_correlativo;
			$ls_espacio_rut   = substr("00000000", 1, 8 - strlen($ls_rut_apoderado)).$ls_rut_apoderado;
			$ls_espacio_col   = substr("00000", 1, 5 - strlen($li_id_colegio)).$li_id_colegio;
			$li_id_ctacte = ($ls_espacio_col.$ls_espacio_rut.$li_espacio_cero);
			
			//echo(" <BR> Colegio Id : ($ls_espacio_col) - Rut Apo : ($ls_espacio_rut) - Correlativo : ($li_espacio_cero) <BR> Ctacte Generado -- ($li_id_ctacte) - Ano Escolar ($ldt_ano_escolar) <BR>");
				
				$sql_insert= "INSERT INTO con_apoderado_ctacte VALUES('$li_id_ctacte', $li_id_colegio, '$ls_rut_apoderado', $li_id_correlativo);";
				//echo("Insert : $sql_insert <BR>");
				$rs_insert = pg_exec($conexion,$sql_insert);
				
				$li_id_correlativo = $li_id_correlativo + 1;

				}Else
				{
				echo("Ya Existe Apoderado : .... ($ls_rut_apoderado) en Colegio : $li_id_colegio - Ult.Correlativo Nuevo : ($li_id_correlativo)<BR>");
				}
			
			}
			ECHO("<BR> Procesando Terminado CTACTES APODERADOS ...<BR><BR>");
			//*** TERMINA PROCESO QUE GENERA LAS CTACTES PARA LOS APODERADOS ***//




//********************************************************************************			
	echo("Iniciando Proceso de Estado Pago por Ctacte (APODERADOS)...<BR><BR>");
	

	//$sql_delete = "DELETE from con_estado_pago WHERE periodo = '200409' ";
	//$rs_delete  = pg_exec($conexion,$sql_delete);



	$sql_apo = "Select * from con_apoderado_ctacte Where rdb = $li_id_colegio Order By correlativo;";
	$resultado_query_acta = pg_exec($conexion,$sql_apo);
	$total_filas_acta     = pg_numrows($resultado_query_acta);

	$hoy		 = getdate();
	$dia_actual  = $hoy["mday"];
	$mes_actual  = date(m);	
	$year_actual = $hoy["year"];
	$ldt_fecha_generacion = ($year_actual.$mes_actual.$dia_actual);
	
	$ldt_periodo = $year_actual.$mes_actual;
	echo("<BR><BR> PERIODO : $ldt_periodo ");

	
	$ldt_hora_hours    = date(H);
	$ldt_hora_minutes  = date(i);
	$ldt_hora_seconds  = date(s);
	$ldt_hora_generacion = ($ldt_hora_hours.$ldt_hora_minutes.$ldt_hora_seconds);
	
	$ldt_fecha_emision     = ($year_actual.$mes_actual.$ldt_dia_emision);
	echo("<BR> Fecha Emision : $ldt_fecha_emision <BR>");
	
	If($ldt_dia_vencimie <= $ldt_dia_emision)
	{
	$ldt_mes_vencimie  	   = $mes_actual + 1;
		If (strlen($ldt_mes_vencimie)< 2)
		{
		$ldt_mes_vencimie = "0".$ldt_mes_vencimie;
		}
	
		$ldt_fecha_vencimiento = ($year_actual.$mes_actual.$ldt_dia_vencimie);
	}Else
	{
		If (strlen($mes_actual)< 2)
		{
		$ldt_mes_vencimie = "0".$mes_actual;
		}
	
		$ldt_fecha_vencimiento = ($year_actual.$mes_actual.$ldt_dia_vencimie);
	}
	echo("Fecha Vencimiento : $ldt_fecha_vencimiento <BR><BR>");

	//Saca el Correlativo desde Con_estado_pago 
	$sql_correlativo= "Select correlativo from con_estado_pago where periodo = '$ldt_periodo' Order By correlativo DESC;";
	$resultado_query_corr = pg_exec($conexion,$sql_correlativo);
	$total_filas_corr     = pg_numrows($resultado_query_corr);

	If($total_filas_corr<=0)
	{
		$li_correlativo_epago = 0;
	}Else
	{
		$li_correlativo_epago = pg_result($resultado_query_corr, 0, 0);
	}
		$li_correlativo_epago = $li_correlativo_epago + 1;


		//Comienza a recorrer el Query con_apoderado_ctacte
		For ($j=0; $j < $total_filas_acta; $j++)
		{
		
		$li_id_ctacte     = pg_result($resultado_query_acta, $j, 0);
		$ls_rut_apoderado = pg_result($resultado_query_acta, $j, 2);
	
		$sql_valida_acta= "Select * from con_estado_pago where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo';";
		$resultado_query_valida_acta = pg_exec($conexion,$sql_valida_acta);
		$total_filas_valida_acta     = pg_numrows($resultado_query_valida_acta);		
			
			//Aqui pregunta si existe o no en la DB
			IF($total_filas_valida_acta<=0)
			{

			//echo(" <br><br><b> <font color = '#000099'>***************** NO EXISTE SE GRABA EN CON_ESTADO PAGO ******************** </font></b><br><br> ");
			// ***********************************************************************************************
			
			// DEJANDO LAS CTAS ANTERIORES EN ESTADO NO VIGENTE (N)
			$sql_update= "UPDATE con_estado_pago SET vigente = 'N' WHERE id_ctacte = '$li_id_ctacte' ;";
			$rs_update = pg_exec($conexion,$sql_update);
			
			$sql_insert= "INSERT INTO con_estado_pago VALUES('$li_id_ctacte', '$ldt_periodo', $li_correlativo_epago, '$ldt_fecha_emision', '$ldt_fecha_vencimiento', 0, 0, '$ldt_fecha_generacion', '$ldt_hora_generacion', 'S');";
			$rs_insert = pg_exec($conexion,$sql_insert);
			
	
			$sql_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, d.nombre_alu, d.ape_pat, d.ape_mat from matricula a, tiene2 b, alumno d, ano_escolar e where a.rdb = $li_id_colegio and b.rut_apo = '$ls_rut_apoderado' and a.rut_alumno = b.rut_alumno and a.rut_alumno = d.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual_consulta And e.situacion = 1 Order by 1 ;";
			//echo("<b> Sql 1 :</b> $sql_alumno <br>");
			$resultado_query_alumno = pg_exec($conexion,$sql_alumno);
			$total_filas_alumno     = pg_numrows($resultado_query_alumno);		

				$li_valor_generico    = 0;
				$li_suma_valores	  = 0;
				$mes_actual_2  		  = date(m);				
				
				For ($i=0; $i < $total_filas_alumno; $i++)
				{
				$ls_rut_alumno = pg_result($resultado_query_alumno, $i, 0);
				//echo("<BR> $i - Apoderado : ($ls_rut_apoderado) - Alumno : ($ls_rut_alumno) - Ctacte ($li_id_ctacte) <BR>");
				
				$sql_cuentas = "Select a.* from con_categoria_cuenta a, con_categoria_cuenta_periodo b Where a.rdb = $li_id_colegio And a.rdb = b.rdb And a.id_categoria = b.id_categoria And a.id_cuenta = b.id_cuenta And b.id_mes = $mes_actual_2 Order by 1,2,3  ";
				
				//echo(" <BR><strong>***** SQL Cuentas 2 :</strong> <BR> $sql_cuentas <BR><BR>");				
				$resultado_query_cuentas = pg_exec($conexion,$sql_cuentas);
				$total_filas_cuentas     = pg_numrows($resultado_query_cuentas);		
				
						if($total_filas_cuentas<=0)
						{
							//echo("<BR> No existen Cuentas para Calcular Montos en Estado de Pagos...<BR>");
						}else
						{
						
						//***************************************************************
						//  GRABANDO Y CALCULANDO MONTOS PARA EL DETALLE DE LAS CUENTAS
						//***************************************************************

						$sql_busca_correlativo_detalle= "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' Order By correlativo DESC "; 
						$resultado_query_busca_corr_detalle = pg_exec($conexion,$sql_busca_correlativo_detalle);
						$total_filas_busca_corr_detalle     = pg_numrows($resultado_query_busca_corr_detalle);	
						
						if($total_filas_busca_corr_detalle<=0)
						{
							$li_correlativo_epago_detalle = 0;
						}else
						{
							$li_correlativo_epago_detalle = pg_result($resultado_query_busca_corr_detalle, 0, 0);
						}
						
					$li_suma_if			  = 0;
					$li_suma_for		  = 0;
					$li_suma_sinadicional = 0;
					$li_suma_monto_cdescue= 0;
					$li_suma_beca_tope    = 0;
					$li_suma_total_beca   = 0;
					$li_contador    	  = $li_correlativo_epago_detalle;
				
					For($x=0; $x < $total_filas_cuentas; $x++)
					{
					$li_contador     = $li_contador + 1;
					$li_id_categoria = pg_result($resultado_query_cuentas, $x, 1);						
					$li_id_cuenta    = pg_result($resultado_query_cuentas, $x, 2);
					$li_id_moneda    = pg_result($resultado_query_cuentas, $x, 3);
					$li_id_monto     = pg_result($resultado_query_cuentas, $x, 4);
					//$li_monto_saldoanterior = pg_result($resultado_query_cuentas, $x, 5);
					//if($li_monto_saldoanterior == '') { $li_monto_saldoanterior = 0;}
					//if($li_monto_saldoanterior < 0) { $li_monto_saldoanterior = 0;}					
					
				$sql_categoria= "select * from con_categoria_grado where rdb = $li_id_colegio and id_categoria = $li_id_categoria and grado in(select curso.grado_curso from matricula, curso, ano_escolar where curso.id_curso = matricula.id_curso and ano_escolar.id_ano = matricula.id_ano and ano_escolar.id_ano = curso.id_ano and ano_escolar.nro_ano = $year_actual_consulta and matricula.rut_alumno = $ls_rut_alumno and matricula.rdb = $li_id_colegio and curso.ensenanza = con_categoria_grado.ensenanza) ";
				
				//echo("<br><b> SQL 3 Categoria : </b> $sql_categoria <BR><BR>");
				$resultado_query_cate = pg_exec($conexion,$sql_categoria);
				$total_filas_cate     = pg_numrows($resultado_query_cate);		
			
					IF($total_filas_cate <= 0)
					{
						echo("<Font color='#006699'><BR> ALUMNO ($ls_rut_alumno) NO existe dentro de la Categoria </Font><BR><BR>");
					}
					else
					{
						$li_id_grado = pg_result($resultado_query_cate, 0, 2);					
						//echo("<Font color='#006699'<BR> ALUMNO ($ls_rut_alumno) Existe dentro de la Categoria Grado : ($li_id_grado) - Cuenta ($li_id_cuenta) </Font><BR><BR>");
					
					
					$sql_cuentas_con_descue= "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_extra, a.valor, b.tipo , b.signo from con_categoria_extra  a, con_extra b where a.rdb = $li_id_colegio And a.id_categoria = $li_id_categoria And a.id_cuenta = $li_id_cuenta And a.id_extra <> 0 and a.rdb = b.rdb and a.id_extra = b.id_extra and b.saldo = 'N' ";
					
					//echo("<strong> SQL 4 :</strong> <BR> $sql_cuentas_con_descue <BR><BR>");
					$resultado_query_cuentas_con_descue = pg_exec($conexion,$sql_cuentas_con_descue);
					$total_filas_cuentas_con_descue     = pg_numrows($resultado_query_cuentas_con_descue);						
					

						if($total_filas_cuentas_con_descue <= 0)								
						{

						// ************** NO TIENE ADICIONAL *************************
						// ***********************************************************						

						$li_valor_generico    = $li_id_monto;
						
						}else
						{
						//echo("<Font color='#993300'> Tiene Adicional </Font><BR>");
						// ************** TIENE ADICIONAL 						***************
						//                SE APLICAN LAS CUENTAS ADICIONALES.
						// ********************************************************************

									for($p=0; $p<$total_filas_cuentas_con_descue; $p++)
									{
									
									$li_id_catextra = pg_result($resultado_query_cuentas_con_descue, $p, 1);
									$li_id_cuextra  = pg_result($resultado_query_cuentas_con_descue, $p, 2);
									$li_id_extra    = pg_result($resultado_query_cuentas_con_descue, $p, 3);
									$li_valor       = pg_result($resultado_query_cuentas_con_descue, $p, 4);
									$ls_tipo        = Trim(pg_result($resultado_query_cuentas_con_descue, $p, 5));
									$ls_signo       = Trim(pg_result($resultado_query_cuentas_con_descue, $p, 6));

						//echo("<br> --> ($p) <b>MONTO : ($li_id_monto) con VALOR ($li_valor)</b> = Id_categoria ($li_id_catextra) - Id_cuentaextra ($li_id_cuextra) -  Id_extra ($li_id_extra) <br><br>");


									if($li_id_monto > 0)
									{

											if($li_id_extra == -1)
											{
											
										//echo("<br> Este es el RUT ($ls_rut_alumno) De Alumno <BR>");
									
										$sql_busca_beca_tope= "Select * From con_alumno_beca Where rut_alumno = '$ls_rut_alumno' "; 
										$resultado_query_busca_beca_tope = pg_exec($conexion,$sql_busca_beca_tope);
										$total_filas_busca_beca_tope     = pg_numrows($resultado_query_busca_beca_tope);	
										
											if($total_filas_busca_beca_tope<=0)
											{
												$li_monto_beca_tope = 0;
											}else
											{
												$li_monto_beca_tope = pg_result($resultado_query_busca_beca_tope, 0, 1);
											}
	
												if($li_monto_beca_tope > 0)												
												{
												
														$li_valor_m       = ($li_id_monto * $li_valor);
														$li_valor_d       = ($li_valor_m / 100); //4500
														$li_valor_primero = $li_valor_d; //4500
														$li_valor_tope    = ($li_valor_primero * $li_monto_beca_tope);
														$li_valor_tope_d  = ($li_valor_tope / 100); //4500*75/100=3375
														$li_suma_beca     = ($li_valor_primero - $li_valor_tope_d); //19375
												
												
												}else{
												
														$li_valor_m    	 = ($li_id_monto * $li_valor);
														$li_valor_d  	 = ($li_valor_m / 100); 												
														$li_suma_beca	 = $li_valor_d;
												
												} // Cierra If linea 336

												$li_suma_monto_cdescue = $li_suma_beca;

											}else{ // del IF -1

													If($ls_signo=="+")
													{
														if($ls_tipo=="$")
														{
														$li_valor = $li_valor;
														}Else
														{
														$li_valor = ($li_id_monto * $li_valor);
														$li_valor = ($li_valor / 100);
														}
														$li_suma_monto_cdescue = ($li_id_monto + $li_valor);
													}Else
													{
														if($ls_tipo=="$")
														{
														$li_valor = $li_valor;
														}else
														{
														$li_valor = ($li_id_monto * $li_valor);
														$li_valor = ($li_valor / 100);
														}
														$li_suma_monto_cdescue = ($li_id_monto - $li_valor);
													} //FIN DE LA LINEA 357
											
											} // Cierra IF Linea 319 -1
										
										
									} //CIERRA IF Linea 316									
									$li_id_monto = $li_suma_monto_cdescue;
										
									} //FOR LINEA 303
									$li_valor_generico = $li_suma_monto_cdescue;

						
						} //Cierra IF Linea 291
						//echo("<BR> <b>Termina monto : ($li_valor_generico) </b> <BR>");
						

//echo("<BR> ///===== GRABANDO PAGOS EN CON_ESTADO_PAGO_DETALLE ==================// <BR>");

						$sql_busca_nombre= "Select nombre From con_cuenta Where id_cuenta = $li_id_cuenta ;"; 
						$resultado_query_busca_nombre = pg_exec($conexion,$sql_busca_nombre);
						$total_filas_busca_nombre     = pg_numrows($resultado_query_busca_nombre);	
						
						If($total_filas_busca_nombre<=0)
						{
							$ls_cuenta_nombre = ' ';
						}Else
						{
							$ls_cuenta_nombre = Trim(pg_result($resultado_query_busca_nombre, 0, 0));
						}

	$sql_valida_detalle= "Select * From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And correlativo = $li_correlativo_epago And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta ;"; 
	$resultado_valida_detalle = pg_exec($conexion,$sql_valida_detalle);
	$total_valida_detalle     = pg_numrows($resultado_valida_detalle);	
	
		if($total_valida_detalle <= 0)
		{

			$sql_insert_detalle= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $li_correlativo_epago, '$ls_rut_alumno', $li_id_cuenta, Trim('$ls_cuenta_nombre'), $li_valor_generico, 0);";
			//echo(" <br> $sql_insert_detalle <br><br> ");
			$rs_insert_detalle = pg_exec($conexion,$sql_insert_detalle);
			
			$li_suma_valores = ($li_suma_valores + $li_valor_generico);
	
		}else{
		
			$sql_update_detalle= "UPDATE con_estado_pago_detalle SET monto = $li_valor_generico WHERE id_ctacte = '$li_id_ctacte' AND periodo = '$ldt_periodo' AND correlativo = $li_correlativo_epago AND rut_alumno = '$ls_rut_alumno' AND cuenta_id = $li_id_cuenta ";
			//echo(" <br> $sql_update_detalle <br><br> ");
			$rs_update_detalle = pg_exec($conexion,$sql_update_detalle);
			
			$li_suma_valores = ($li_suma_valores + $li_valor_generico);
			
		}

//echo(" ///===== TERMINA PAGOS CON_ESTADO_PAGO_DETALLE  =====================// <BR><BR>");
					
					} //Cierra IF Linea 246				
				
				
				}//Cierra el FOR Linea 257						
						
						
						}// Cierra If Linea 227 SI EXISTE CUENTA O NO



			//******************************************************************************************************
			// Actualizacion del 06 de Agosto
			//******************************************************************************************************
			// ESTO ES PARA LOS SALDOS
			//******************************************************************************************************
			
						if($total_filas_cuentas<=0)
						{
							//echo("<BR> No existen SALDOS para Calcular Montos en Estado de Pagos...<BR>");
						}else
						{
							$li_id_categoria = pg_result($resultado_query_cuentas, 0, 1);												
							//echo("<BR> Existen SALDOS ($li_id_categoria) para Calcular Montos en Estado de Pagos...<BR>");
							
							$sql_adicionales_saldo = "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_extra, a.valor, b.tipo , b.signo from con_categoria_extra a, con_extra b where a.rdb = $li_id_colegio And a.id_categoria = $li_id_categoria And a.id_extra <> 0 and a.rdb = b.rdb and a.id_extra = b.id_extra and b.saldo = 'S' ";
							//echo("<BR> SQL 5 : $sql_adicionales_saldo <BR>");
							$resultado_saldo = pg_exec($conexion,$sql_adicionales_saldo);
							$total_saldo     = pg_numrows($resultado_saldo);	

							$ls_calculo3 = 0;				
							for($ii=0; $ii<$total_saldo; $ii++)
							{
								$li_id_cuenta_ = pg_result($resultado_saldo, $ii, 2);
								$li_valor_adi_ = pg_result($resultado_saldo, $ii, 4); //Valor												
								$ls_id_tipo___ = pg_result($resultado_saldo, $ii, 5); //Tipo
								$ls_id_signo__ = pg_result($resultado_saldo, $ii, 6); //Signo												
																				
								//echo("<BR> Estas cuentas contienen SALDO : ($li_id_cuenta_) - ($li_id_ctacte) - rutalumno ($ls_rut_alumno)<BR>");
							
								$ldt_periodo_mesAnt = ($ldt_periodo - 1);
								$sql_S = "Select a.id_comprobante, b.* from con_comprobante a, con_saldo b where a.id_ctacte = '$li_id_ctacte' and a.ep_periodo = '$ldt_periodo_mesAnt' and a.id_ctacte = b.id_ctacte and a.ep_periodo = b.periodo and rut_alumno = '$ls_rut_alumno' and cuenta_id = $li_id_cuenta_ ";
								//echo("<BR> SQL 6 : $ldt_periodo_mesAnt <BR>");
								$resultado_saldo_S = pg_exec($conexion,$sql_S);
								$total_saldo_S     = pg_numrows($resultado_saldo_S);
								
									if($total_saldo_S <= 0)
									{
									}else{
									
										$li_monto_saldoAnterior = pg_result($resultado_saldo_S, 0, 5);
										
										if($li_monto_saldoAnterior < 0)
										{


		$sql__datos_ = "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' "; 
		$resultado__datos_= pg_exec($conexion,$sql__datos_);
							
							$correlativo = pg_result($resultado__datos_, 0, 0);

		$sql__datos_2 = "select nombre from con_cuenta where id_cuenta = $li_id_cuenta_ "; 
		$resultado__datos_2= pg_exec($conexion,$sql__datos_2);

							$ls_cuenta_nombre = pg_result($resultado__datos_2, 0, 0);
											
							$sql_insert_D= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $correlativo, '$ls_rut_alumno', $li_id_cuenta_, '$ls_cuenta_nombre', 0, $li_monto_saldoAnterior) ";
							//echo("<br><font color='009999'>INSERT MONTOSALDO Pago_Estado_Detalle  : $sql_insert_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_insert_D);																						

										
										} // Cierra el If < 0 Linea 443																				
										
										
										
										
										if($li_monto_saldoAnterior == 0)
										{
													$ls_calculo3 = 0;
										}else if($li_monto_saldoAnterior > 0){
										
											if($ls_id_tipo___ == '%') // Porcentaje *****
											{
												if($ls_id_signo__ == '+') //Aumenta
												{
												
													$ls_calculo1 = ($li_monto_saldoAnterior * $li_valor_adi_);
													$ls_calculo2 = ($ls_calculo1 /100);
													$ls_calculo3 = ($li_monto_saldoAnterior + $ls_calculo2);
												
												}else{					  //Descuenta 

													$ls_calculo1 = ($li_monto_saldoAnterior * $li_valor_adi_);
													$ls_calculo2 = ($ls_calculo1 /100);
													$ls_calculo3 = ($li_monto_saldoAnterior - $ls_calculo2);

												}
											
											}else{ 						  // Valor *****

												if($ls_id_signo__ == '+') //Aumenta
												{
												
													$ls_calculo3 = ($li_monto_saldoAnterior + $li_valor_adi_);
												
												}else{					  //Descuenta

													$ls_calculo3 = ($li_monto_saldoAnterior - $li_valor_adi_);

												}
											
											} //Cierra If Linea 452
											
										}//Cierra If Linea 447
										
										//echo(" <br><font size=5><strong>al Saldo :</strong> ($ls_calculo3) - Cuenta :($li_id_cuenta_) - ($li_id_ctacte) - RutAlumno ($ls_rut_alumno) </font><br> ");
										
										if($ls_calculo3 > 0) //SALDO
										{
										
										$sql__valida_cuenta_S = "Select monto From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta_ "; 
										$resultado__valida_S = pg_exec($conexion,$sql__valida_cuenta_S);
										$total__valida_S     = pg_numrows($resultado__valida_S);	

											if($total__valida_S <= 0)
											{
		$sql__datos_ = "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' "; 
		$resultado__datos_= pg_exec($conexion,$sql__datos_);
							
							$correlativo = pg_result($resultado__datos_, 0, 0);

		$sql__datos_2 = "select nombre from con_cuenta where id_cuenta = $li_id_cuenta_ "; 
		$resultado__datos_2= pg_exec($conexion,$sql__datos_2);

							$ls_cuenta_nombre = pg_result($resultado__datos_2, 0, 0);
											
							$sql_insert_D= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $correlativo, '$ls_rut_alumno', $li_id_cuenta_, '$ls_cuenta_nombre', 0, $ls_calculo3) ";
							//echo("<br><font color='009999'>INSERT MONTOSALDO Pago_Estado_Detalle  : $sql_insert_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_insert_D);																						
											
											}else{

							$sql_update_D= "UPDATE con_estado_pago_detalle SET monto_saldo = $ls_calculo3 WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta_ ";
							//echo("<br><font color='009999'>MODIFICANDO MONTOSALDO Pago_Estado_Detalle  : $sql_update_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_update_D);
											
											} //Cierra IF linea 495
										
										
										} //Cierra IF linea 488

									
									} //Cierra IF Linea 442	
							
							} //426
													
						} //Cierra if linea 411



							//echo("<BR><BR><br>");
			// ********************************************************************************************
			//AQUI  MODIFICA EL TOTAL ESTADO PAGO
			
			$sql_update= "UPDATE con_estado_pago SET monto = $li_suma_valores WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' ;";
			//echo("<font color='FF0000'>MODIFICANDO MONTO Pago_Estado 2 : $sql_update </font><BR><BR>");
			$rs_update = pg_exec($conexion,$sql_update);
			// ********************************************************************************************

				
				} //Cierra FOR Linea 208 //213
			
			
			// *********************************************************************************************
			// AQUI SE GUARDAN LOS VALORES EN TRANSACCIONES

			$sql_busca_valida_tns= "Select * From con_transaccion Where Trim(id_ctacte) = Trim('$li_id_ctacte');"; 
			$resultado_query_busca_valida_tns = pg_exec($conexion,$sql_busca_valida_tns);
			$total_filas_busca_valida_tns     = pg_numrows($resultado_query_busca_valida_tns);	

			If($total_filas_busca_valida_tns <= 0)
			{			
			
			$sql_insert_trans= "INSERT INTO con_transaccion VALUES('$li_id_ctacte', '$ldt_fecha_generacion', '$ldt_hora_generacion', 1, 'ESTADO DE CUENTA', 'D', $li_suma_valores);";
			//echo("Grabando Tabla TRANSACCION : $sql_insert_trans <BR><BR>");
			$rs_insert_trans = pg_exec($conexion,$sql_insert_trans);
			
			}Else
			{
			
			$sql_update_trans= "UPDATE con_transaccion SET fecha = '$ldt_fecha_generacion', hora = '$ldt_hora_generacion', monto = $li_suma_valores WHERE Trim(id_ctacte) = '$li_id_ctacte' And id_tipo_operacion = 1 And tipo = 'D' ;";
			//echo("MODIFICANDO  Tabla TRANSACCION : $sql_update_trans <BR><BR>");
			$rs_update_trans = pg_exec($conexion,$sql_update_trans);
			
			//Echo("Ya Existe Transaccion para Ctacte : ($li_id_ctacte) <BR><BR>");
			}
			// ********************************************************************************************

			$li_correlativo_epago = $li_correlativo_epago + 1;
			
			
			
			}ELSE //Abre IF Linea 185
			{
	
	
	// ********************************************************************************************************************************
	// ********************************************************************************************************************************
	// ********************************************************************************************************************************	
	// ********************************************** Existe ESTADO PAGO **************************************************************
	// ********************************************************************************************************************************
	// ********************************************************************************************************************************
	// ********************************************************************************************************************************
	// ********************************************************************************************************************************

			$sql_interes= "Select tipo_interes from con_parametro Where rdb = $li_id_colegio ";
			$resultado_query_interes = pg_exec($conexion,$sql_interes);
			$total_filas_interes     = pg_numrows($resultado_query_interes);		
				
				if($total_filas_interes <= 0)
				{ 
				
					$li_id_interes = 0;	
				
				}else{
				// CONTIENE INTERES A APLICAR
					
					$li_id_interes = pg_result($resultado_query_interes, 0, 0);
				}
					
					if($li_id_interes <= 0 or $li_id_interes > 2)
					{
					?>
					<Script>
						alert("No ha ingresado el Tipo de Intéres a aplicar");
						parent.Cuerpo.location.href = '../../Admin/Parametros/main.php?ai_colegio_selec=<?=($li_id_colegio)?>';
					</Script>					
					<?					
					}else{
					//APLICAR INTERES
				

			$sql_update= "UPDATE con_estado_pago SET vigente = 'N' WHERE id_ctacte = '$li_id_ctacte' ;";
			//echo("MODIFICANDO Tabla Pago_Estado : $sql_update <BR><BR>");
			$rs_update = pg_exec($conexion,$sql_update);
			
			$sql_delete= "DELETE FROM con_estado_pago_detalle WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' ; ";
			//echo("<BR> ELIMINANDO Tabla Pago_Estado_Detalle : $sql_delete <BR>");
			$rs_delete_detalle = pg_exec($conexion,$sql_delete);
			
			$sql_busca_corr= "Select correlativo From con_estado_pago WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' ;"; 
			$resultado_query_busca_corr = pg_exec($conexion,$sql_busca_corr);
			$total_filas_busca_corr     = pg_numrows($resultado_query_busca_corr);	
			

						If($total_filas_busca_corr<=0)
						{
							$li_correlativo_epago = 0;
						}Else
						{
							$li_correlativo_epago = pg_result($resultado_query_busca_corr, 0, 0);
						}


			$sql_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, d.nombre_alu, d.ape_pat, d.ape_mat from matricula a, tiene2 b, alumno d, ano_escolar e where a.rdb = $li_id_colegio and b.rut_apo = '$ls_rut_apoderado' and a.rut_alumno = b.rut_alumno and a.rut_alumno = d.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual_consulta And e.situacion = 1 Order by 1 ;";
			//echo("<b> Sql 1 :</b> $sql_alumno <br>");
			$resultado_query_alumno = pg_exec($conexion,$sql_alumno);
			$total_filas_alumno     = pg_numrows($resultado_query_alumno);		

				$li_valor_generico    = 0;
				$li_suma_valores	  = 0;
				$mes_actual_2  		  = date(m);				
				
				For ($i=0; $i < $total_filas_alumno; $i++)
				{
				$ls_rut_alumno = pg_result($resultado_query_alumno, $i, 0);
				//echo("<BR> $i - Apoderado : ($ls_rut_apoderado) - Alumno : ($ls_rut_alumno) - Ctacte ($li_id_ctacte) <BR>");
				
				$sql_cuentas = "Select Distinct a.*, c.nombre from con_categoria_cuenta a, con_categoria_cuenta_periodo b, con_categoria c Where a.rdb = $li_id_colegio And a.rdb = b.rdb And a.id_categoria = b.id_categoria And a.id_cuenta = b.id_cuenta And b.id_mes = $mes_actual_2 And a.id_categoria = c.id_categoria Order by 1,2,3  ";
				
				//echo(" <BR><strong>***** SQL Cuentas 2 :</strong> <BR> $sql_cuentas <BR><BR>");				
				$resultado_query_cuentas = pg_exec($conexion,$sql_cuentas);
				$total_filas_cuentas     = pg_numrows($resultado_query_cuentas);		
				
						if($total_filas_cuentas<=0)
						{
							//echo("<BR> No existen Cuentas para Calcular Montos en Estado de Pagos...<BR>");
						}else
						{
						
						//***************************************************************
						//  GRABANDO Y CALCULANDO MONTOS PARA EL DETALLE DE LAS CUENTAS
						//***************************************************************

						$sql_busca_correlativo_detalle= "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' Order By correlativo DESC "; 
						$resultado_query_busca_corr_detalle = pg_exec($conexion,$sql_busca_correlativo_detalle);
						$total_filas_busca_corr_detalle     = pg_numrows($resultado_query_busca_corr_detalle);	
						
						if($total_filas_busca_corr_detalle<=0)
						{
							$li_correlativo_epago_detalle = 0;
						}else
						{
							$li_correlativo_epago_detalle = pg_result($resultado_query_busca_corr_detalle, 0, 0);
						}
						
					$li_suma_if			  = 0;
					$li_suma_for		  = 0;
					$li_suma_sinadicional = 0;
					$li_suma_monto_cdescue= 0;
					$li_suma_beca_tope    = 0;
					$li_suma_total_beca   = 0;
					$li_contador    	  = $li_correlativo_epago_detalle;
				
					for($x=0; $x < $total_filas_cuentas; $x++)
					{
					$li_contador     = $li_contador + 1;
					$li_id_categoria = pg_result($resultado_query_cuentas, $x, 1);						
					$li_id_cuenta    = pg_result($resultado_query_cuentas, $x, 2);
					$li_id_moneda    = pg_result($resultado_query_cuentas, $x, 3);
					$li_id_monto     = pg_result($resultado_query_cuentas, $x, 4);
					$ls_name_categoria = pg_result($resultado_query_cuentas, $x, 5);
					//echo("<br> Alumno dentro de la Categoria ---> $ls_name_categoria <---  Cuenta Id ($li_id_cuenta) <br><br>");
					
				$sql_categoria= "select * from con_categoria_grado where rdb = $li_id_colegio and id_categoria = $li_id_categoria and grado in(select curso.grado_curso from matricula, curso, ano_escolar where curso.id_curso = matricula.id_curso and ano_escolar.id_ano = matricula.id_ano and ano_escolar.id_ano = curso.id_ano and ano_escolar.nro_ano = $year_actual_consulta and matricula.rut_alumno = $ls_rut_alumno and matricula.rdb = $li_id_colegio and curso.ensenanza = con_categoria_grado.ensenanza) ";
				
				//echo("<br><b> SQL 3 Categoria : </b> $sql_categoria <BR><BR>");
				$resultado_query_cate = pg_exec($conexion,$sql_categoria);
				$total_filas_cate     = pg_numrows($resultado_query_cate);		
			
					if($total_filas_cate <= 0)
					{
						//echo("<Font color='#006699'><BR> ALUMNO ($ls_rut_alumno) NO existe dentro de la Categoria ---> $ls_name_categoria <--- Cuenta Id ($li_id_cuenta) </Font><BR><BR>");
					}
					else
					{
						$li_id_grado 	 = pg_result($resultado_query_cate, 0, 1);
						$li_id_ensenanza = pg_result($resultado_query_cate, 0, 2);					
					
						//echo("<Font color='#006699'<BR> ALUMNO ($ls_rut_alumno) Existe dentro de la Categoria ---> $ls_name_categoria <--- Grado : ($li_id_grado) / ensenanza : ($li_id_ensenanza) - Cuenta ($li_id_cuenta) </Font><BR><BR>");
					
					
					$sql_cuentas_con_descue= "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_extra, a.valor, b.tipo , b.signo from con_categoria_extra  a, con_extra b where a.rdb = $li_id_colegio And a.id_categoria = $li_id_categoria And a.id_cuenta = $li_id_cuenta And a.id_extra <> 0 and a.rdb = b.rdb and a.id_extra = b.id_extra and b.saldo = 'N' ";
					
					//echo("<strong> SQL 4 :</strong> <BR> $sql_cuentas_con_descue <BR><BR>");
					$resultado_query_cuentas_con_descue = pg_exec($conexion,$sql_cuentas_con_descue);
					$total_filas_cuentas_con_descue     = pg_numrows($resultado_query_cuentas_con_descue);						
					

						if($total_filas_cuentas_con_descue <= 0)								
						{

						// ************** NO TIENE ADICIONAL *************************
						// ***********************************************************						

							$li_valor_generico    = $li_id_monto;
						
						}else
						{
						//echo("<Font color='#993300'> Tiene Adicional </Font><BR>");
						// ************** TIENE ADICIONAL 						***************
						//                SE APLICAN LAS CUENTAS ADICIONALES.
						// ********************************************************************

									for($p=0; $p<$total_filas_cuentas_con_descue; $p++)
									{
									
									$li_id_catextra = pg_result($resultado_query_cuentas_con_descue, $p, 1);
									$li_id_cuextra  = pg_result($resultado_query_cuentas_con_descue, $p, 2);
									$li_id_extra    = pg_result($resultado_query_cuentas_con_descue, $p, 3);
									$li_valor       = pg_result($resultado_query_cuentas_con_descue, $p, 4);
									$ls_tipo        = Trim(pg_result($resultado_query_cuentas_con_descue, $p, 5));
									$ls_signo       = Trim(pg_result($resultado_query_cuentas_con_descue, $p, 6));

						//echo("<br> --> ($p) <b> MONTO : ($li_id_monto) con VALOR ($li_valor)</b> = Id_categoria ($li_id_catextra) - Id_cuentaextra ($li_id_cuextra) -  Id_extra ($li_id_extra) <br><br>");


									if($li_id_monto > 0)									
									{
									
											if($li_id_extra == -1)
											{
											
										//echo("<br> Este es el RUT ($ls_rut_alumno) De Alumno <BR>");
									
										$sql_busca_beca_tope= "Select * From con_alumno_beca Where rut_alumno = '$ls_rut_alumno' "; 
										$resultado_query_busca_beca_tope = pg_exec($conexion,$sql_busca_beca_tope);
										$total_filas_busca_beca_tope     = pg_numrows($resultado_query_busca_beca_tope);	
										
											if($total_filas_busca_beca_tope<=0)
											{
												$li_monto_beca_tope = 0;
											}else
											{
												$li_monto_beca_tope = pg_result($resultado_query_busca_beca_tope, 0, 1);
											}
	
												if($li_monto_beca_tope > 0)												
												{
												
														$li_valor_m       = ($li_id_monto * $li_valor);
														$li_valor_d       = ($li_valor_m / 100); 
														$li_valor_primero = $li_valor_d; 
														$li_valor_tope    = ($li_valor_primero * $li_monto_beca_tope);
														$li_valor_tope_d  = ($li_valor_tope / 100); 
														$li_suma_beca     = ($li_valor_primero - $li_valor_tope_d); 
												
												
												}else{
														$li_valor_m    	 = ($li_id_monto * $li_valor);
														$li_valor_d  	 = ($li_valor_m / 100); 												
														$li_suma_beca	 = $li_valor_d;
												
												} // Cierra If linea 760

												$li_suma_monto_cdescue = $li_suma_beca;
											
											}else{ // del IF -1


													if($ls_signo=="+")
													{
														if($ls_tipo=="$")
														{
														$li_valor = $li_valor;
														}else
														{
														$li_valor = ($li_id_monto * $li_valor);
														$li_valor = ($li_valor / 100);
														}
														$li_suma_monto_cdescue = ($li_id_monto + $li_valor);
													}else
													{
														if($ls_tipo=="$")
														{
														$li_valor = $li_valor;
														}else
														{
														$li_valor = ($li_id_monto * $li_valor);
														$li_valor = ($li_valor / 100);
														}
														$li_suma_monto_cdescue = ($li_id_monto - $li_valor);
													} //FIN DE LA LINEA 748
												
												} // Cierra IF -1 Linea 815																																			
										
										} //CIERRA IF Linea 812									
										$li_id_monto = $li_suma_monto_cdescue;
										
									} //FOR LINEA 749
									$li_valor_generico = $li_suma_monto_cdescue;

						
						} //Cierra IF Linea 719
						//echo("<BR> <b>Termina monto : ($li_valor_generico) </b> <BR>");
						

//echo("<BR> ///===== GRABANDO PAGOS EN CON_ESTADO_PAGO_DETALLE ==================// <BR>");

						$sql_busca_nombre= "Select nombre From con_cuenta Where id_cuenta = $li_id_cuenta ;"; 
						$resultado_query_busca_nombre = pg_exec($conexion,$sql_busca_nombre);
						$total_filas_busca_nombre     = pg_numrows($resultado_query_busca_nombre);	
						
						If($total_filas_busca_nombre<=0)
						{
							$ls_cuenta_nombre = ' ';
						}Else
						{
							$ls_cuenta_nombre = Trim(pg_result($resultado_query_busca_nombre, 0, 0));
						}

	$sql_valida_detalle= "Select * From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And correlativo = $li_correlativo_epago And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta ;"; 
	$resultado_valida_detalle = pg_exec($conexion,$sql_valida_detalle);
	$total_valida_detalle     = pg_numrows($resultado_valida_detalle);	
	
		if($total_valida_detalle <= 0)
		{

			$sql_insert_detalle= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $li_correlativo_epago, '$ls_rut_alumno', $li_id_cuenta, Trim('$ls_cuenta_nombre'), $li_valor_generico, 0, 0, 0, $li_valor_generico);";
			//echo(" <br> $sql_insert_detalle <br><br> ");
			$rs_insert_detalle = pg_exec($conexion,$sql_insert_detalle);
			
			$li_suma_valores = ($li_suma_valores + $li_valor_generico);
	
		}else{
		
			$sql_update_detalle= "UPDATE con_estado_pago_detalle SET monto = $li_valor_generico, total_bruto = $li_valor_generico WHERE id_ctacte = '$li_id_ctacte' AND periodo = '$ldt_periodo' AND correlativo = $li_correlativo_epago AND rut_alumno = '$ls_rut_alumno' AND cuenta_id = $li_id_cuenta ";
			//echo(" <br> $sql_update_detalle <br><br> ");
			$rs_update_detalle = pg_exec($conexion,$sql_update_detalle);
			
			$li_suma_valores = ($li_suma_valores + $li_valor_generico);
			
		}

//echo(" ///===== TERMINA PAGOS CON_ESTADO_PAGO_DETALLE  =====================// <BR><BR>");
					
					} //Cierra IF Linea 246				
				
				
				}//Cierra el FOR Linea 257						
						
						
						}// Cierra If Linea 227 SI EXISTE CUENTA O NO



			//******************************************************************************************************
			// Actualizacion del 06 de Agosto y del 08 de Septiembre (Interes Simple y Compuesto)
			//******************************************************************************************************
			// ESTO ES PARA LOS SALDOS
			//******************************************************************************************************
			
						if($total_filas_cuentas<=0)
						{
							//echo("<BR> No existen SALDOS para Calcular Montos en Estado de Pagos...<BR>");
						}else
						{
									
						
							$li_id_categoria = pg_result($resultado_query_cuentas, 0, 1);												
							//echo("<BR> Existen SALDOS ($li_id_categoria) para Calcular Montos en Estado de Pagos...<BR>");
							
							$sql_adicionales_saldo = "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_extra, a.valor, b.tipo , b.signo from con_categoria_extra a, con_extra b where a.rdb = $li_id_colegio And a.id_categoria = $li_id_categoria And a.id_extra <> 0 and a.rdb = b.rdb and a.id_extra = b.id_extra and b.saldo = 'S' ";
							//echo("<BR> SQL 5 : $sql_adicionales_saldo <BR>");
							$resultado_saldo = pg_exec($conexion,$sql_adicionales_saldo);
							$total_saldo     = pg_numrows($resultado_saldo);	

							$ls_calculo3 = 0;
							$li_total_neto = 0;
							$li_total_brut = 0;				
							for($ii=0; $ii<$total_saldo; $ii++)
							{
								$li_id_cuenta_ = pg_result($resultado_saldo, $ii, 2);
								$li_valor_adi_ = pg_result($resultado_saldo, $ii, 4); //Valor												
								$ls_id_tipo___ = pg_result($resultado_saldo, $ii, 5); //Tipo
								$ls_id_signo__ = pg_result($resultado_saldo, $ii, 6); //Signo												
																				
								//echo("<BR> Estas cuentas contienen SALDO : ($li_id_cuenta_) - ($li_id_ctacte) - rutalumno ($ls_rut_alumno)<BR>");
							
								$ldt_periodo_mesAnt = ($ldt_periodo - 1);
								$sql_S = "Select a.id_comprobante, b.* from con_comprobante a, con_saldo b where a.id_ctacte = '$li_id_ctacte' and a.ep_periodo = '$ldt_periodo_mesAnt' and a.id_ctacte = b.id_ctacte and a.ep_periodo = b.periodo and rut_alumno = '$ls_rut_alumno' and cuenta_id = $li_id_cuenta_ ";
								//echo("<BR> SQL 6 : $sql_S <BR>");
								$resultado_saldo_S = pg_exec($conexion,$sql_S);
								$total_saldo_S     = pg_numrows($resultado_saldo_S);
								
									if($total_saldo_S <= 0)
									{
									}else{
									
										$li_monto_saldoAnterior = pg_result($resultado_saldo_S, 0, 5);
										$li_id_cuenta_saldo		= pg_result($resultado_saldo_S, 0, 4);
										//echo("Monto Saldo : ($li_monto_saldoAnterior) - alumno : ($ls_rut_alumno) <br>");
								if($li_monto_saldoAnterior < 0) //Saldo a Favor
								{

		$sql__datos_ = "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' "; 
		$resultado__datos_= pg_exec($conexion,$sql__datos_);
							
							$correlativo = pg_result($resultado__datos_, 0, 0);

		$sql__datos_2 = "select nombre from con_cuenta where id_cuenta = $li_id_cuenta_ "; 
		$resultado__datos_2= pg_exec($conexion,$sql__datos_2);

							$ls_cuenta_nombre = pg_result($resultado__datos_2, 0, 0);
											
							$sql_insert_D= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $correlativo, '$ls_rut_alumno', $li_id_cuenta_, '$ls_cuenta_nombre', 0, $li_monto_saldoAnterior, 0, 0, $li_monto_saldoAnterior) ";
							//echo("<br><font color='009999'>INSERT MONTOSALDO Pago_Estado_Detalle  : $sql_insert_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_insert_D);																						
										
								} // Cierra el If < 0 Linea 982																				
										
										
										if($li_monto_saldoAnterior == 0)
										{
													$ls_calculo3 = 0; // No tiene Saldo la cuenta
										
										}else if($li_monto_saldoAnterior > 0){
										
											if($ls_id_tipo___ == '%') // Porcentaje *****
											{
												if($ls_id_signo__ == '+') //Aumenta
												{
												
													$ls_calculo1 = ($li_monto_saldoAnterior * $li_valor_adi_);
													$ls_calculo2 = ($ls_calculo1 /100);
													$ls_calculo3 = ($li_monto_saldoAnterior + $ls_calculo2);
												
												}else{					  //Descuenta 

													$ls_calculo1 = ($li_monto_saldoAnterior * $li_valor_adi_);
													$ls_calculo2 = ($ls_calculo1 /100);
													$ls_calculo3 = ($li_monto_saldoAnterior - $ls_calculo2);

												}
											
											}else{ 						  // Valor *****

												if($ls_id_signo__ == '+') //Aumenta
												{
												
													$ls_calculo2 = $li_valor_adi_;
													$ls_calculo3 = ($li_monto_saldoAnterior + $li_valor_adi_);													
												
												}else{					  //Descuenta

													$ls_calculo2 = $li_valor_adi_;
													$ls_calculo3 = ($li_monto_saldoAnterior - $li_valor_adi_);

												}
											
											} //Cierra If Linea 1007
											
										}//Cierra If Linea 1002
										
		$sql__datos_02 = "select monto from con_estado_pago_detalle where id_ctacte = '$li_id_ctacte' and periodo = '200409' and rut_alumno = '$ls_rut_alumno' and cuenta_id = $li_id_cuenta_ "; 
		$resultado__datos_= pg_exec($conexion,$sql__datos_02);
		$total__datos_    = pg_numrows($resultado__datos_);


		if($total__datos_ <= 0)
		{
			$li_monto__ = 0;
		}else{
		
			$li_monto__ = pg_result($resultado__datos_, 0, 0);
		}
		
		$li_total_neto = ($li_monto__ + $li_monto_saldoAnterior);
		$li_total_brut = ($li_monto__ + $li_monto_saldoAnterior + $ls_calculo2);
		
		echo(" <br><font size=2><strong> MONTO ($li_monto__) - MONTO Saldo :</strong> ($li_monto_saldoAnterior) - <strong>Interes Saldo :</strong> ($ls_calculo2) - Total Neto ($li_total_neto) - Total Bruto : ($li_total_brut) CUENTA >> $li_id_cuenta_ << ALUMNO >> $ls_rut_alumno << </font><br> ");
		
										
										if($li_monto_saldoAnterior > 0) //SALDO
										{
										
										$sql__valida_cuenta_S = "Select monto From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta_ "; 
										$resultado__valida_S = pg_exec($conexion,$sql__valida_cuenta_S);
										$total__valida_S     = pg_numrows($resultado__valida_S);	

											if($total__valida_S <= 0)
											{
		$sql__datos_ = "Select correlativo From con_estado_pago_detalle Where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' "; 
		$resultado__datos_= pg_exec($conexion,$sql__datos_);
							
							$correlativo = pg_result($resultado__datos_, 0, 0);

		$sql__datos_2 = "select nombre from con_cuenta where id_cuenta = $li_id_cuenta_ "; 
		$resultado__datos_2= pg_exec($conexion,$sql__datos_2);

							$ls_cuenta_nombre = pg_result($resultado__datos_2, 0, 0);
											
							$sql_insert_D= "INSERT INTO con_estado_pago_detalle VALUES('$li_id_ctacte', '$ldt_periodo', $correlativo, '$ls_rut_alumno', $li_id_cuenta_, '$ls_cuenta_nombre', $li_monto__, $li_monto_saldoAnterior, $ls_calculo2, $li_total_neto, $li_total_brut) ";
							echo("<br><font color='009999'>INSERT MONTOSALDO Pago_Estado_Detalle  : $sql_insert_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_insert_D);																						
											
											}else{

							$sql_update_D= "UPDATE con_estado_pago_detalle SET monto_saldo = $li_monto_saldoAnterior, interes_saldo = $ls_calculo2, total_neto = $li_total_neto, total_bruto = $li_total_brut WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' And rut_alumno = '$ls_rut_alumno' And cuenta_id = $li_id_cuenta_ ";
							echo("<br><font color='009999'>MODIFICANDO MONTOSALDO Pago_Estado_Detalle  : $sql_update_D </font><BR><BR>");
							$rs_update = pg_exec($conexion,$sql_update_D);
											
											} //Cierra IF linea 1050
										
										
										} //Cierra IF linea 1043

									
									} //Cierra IF Linea 976	
							
							} //FOR 965
							
						
						} //Cierra if linea 947



							//echo("<BR><BR><br>");
			// ********************************************************************************************
			//AQUI  MODIFICA EL TOTAL ESTADO PAGO
			
			$sql_update= "UPDATE con_estado_pago SET vigente = 'S', monto = $li_suma_valores WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' ;";
			//echo("<font color='FF0000'>MODIFICANDO MONTO Pago_Estado 2 : $sql_update </font><BR><BR>");
			$rs_update = pg_exec($conexion,$sql_update);
			// ********************************************************************************************

				
				} //Cierra FOR Linea 615

		
			} // Cierra el ELSE 673 de si existe INTERES (SIMPLE - COMPUESTO)
				
			
		}// Cierra ELSE Linea 568 (CONSULTA SI EXISTE ESTADO PAGO EN LA DB)		
		
	} //Cierra FOR Linea 179
	//echo("<BR>Procesando Terminado ESTADO PAGO Y DETALLE...<BR><BR>");


//********************************************************************************			
	echo("<br> Iniciando Proceso de Estado Pago por ALUMNO ...<BR><BR>");
	

	$sql_correlativo_alum= "Select correlativo from con_estado_pago_alumno where periodo = '$ldt_periodo' Order By correlativo DESC;";
	
	$resultado_query_corr = pg_exec($conexion,$sql_correlativo_alum);
	$total_filas_corr     = pg_numrows($resultado_query_corr);

	If($total_filas_corr<=0)
	{
	$li_correlativo_epago_alumno = 0;
	}Else
	{
	$li_correlativo_epago_alumno = pg_result($resultado_query_corr, 0, 0);
	}
	$li_correlativo_epago_alumno = $li_correlativo_epago_alumno + 1;


	$sql_apo= "Select * from con_apoderado_ctacte Where rdb = $li_id_colegio Order By correlativo;";
	
	$resultado_query_acta = pg_exec($conexion,$sql_apo);
	$total_filas_acta     = pg_numrows($resultado_query_acta);


	//Comienza a recorrer el Query con_apoderado_ctacte
	For ($j=0; $j < $total_filas_acta; $j++)
	{
	$li_id_ctacte     = Trim(pg_result($resultado_query_acta, $j, 0));
	$ls_rut_apoderado = Trim(pg_result($resultado_query_acta, $j, 2));


	$sql_delete= "DELETE FROM con_estado_pago_alumno WHERE id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo' ; ";
	//echo("<BR> ELIMINANDO Alumnos : $sql_delete <BR><BR><BR>");
	$rs_delete_detalle = pg_exec($conexion,$sql_delete);



		$sql_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso from matricula a, tiene2 b, ano_escolar e where a.rdb = $li_id_colegio and b.rut_apo = '$ls_rut_apoderado' and a.rut_alumno = b.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual_consulta And e.situacion = 1 Order by 1 ;";
		
		//Echo("<BR> SQL : $sql_alumno <BR>");
		$resultado_query_alumno = pg_exec($conexion,$sql_alumno);
		$total_filas_alumno     = pg_numrows($resultado_query_alumno);		
	
			For ($i=0; $i < $total_filas_alumno; $i++)
			{
			
			$sql_busca_corr= "Select correlativo From con_estado_pago where id_ctacte = '$li_id_ctacte' And periodo = '$ldt_periodo';"; 
			$resultado_query_busca_corr = pg_exec($conexion,$sql_busca_corr);
			$total_filas_busca_corr     = pg_numrows($resultado_query_busca_corr);		
		
			If($total_filas_busca_corr<=0)				
			{
			$li_correlativo_epago2 = $li_correlativo_epago_alumno;
			}Else
			{
			$li_correlativo_epago2 = pg_result($resultado_query_busca_corr, 0, 0);
			}
			
			
			$ls_rut_alumno = Trim(pg_result($resultado_query_alumno, $i, 0));
			$li_id_ano     = Trim(pg_result($resultado_query_alumno, $i, 3));
			$li_id_curso   = Trim(pg_result($resultado_query_alumno, $i, 4));
			

				// SACA LA BECA POR ALUMNO
				$sql_busca_beca= "Select * From con_alumno_beca Where rut_alumno = '$ls_rut_alumno' ;"; 
				$resultado_query_busca_beca = pg_exec($conexion,$sql_busca_beca);
				$total_filas_busca_beca     = pg_numrows($resultado_query_busca_beca);		

				If($total_filas_busca_beca<=0)
				{
				$li_valor_beca = 0;
				}Else
				{
				$li_valor_beca = pg_result($resultado_query_busca_beca, 0, 1);
				}
			
			
			//Echo("<BR> $i en UParte - Apoderado : ($ls_rut_apoderado) - Alumno : ($ls_rut_alumno) - Curso : ($li_id_curso) <BR>");
			
			
			$sql_insert_alumno= "INSERT INTO con_estado_pago_alumno VALUES('$li_id_ctacte', '$ldt_periodo', $li_correlativo_epago2, Trim('$ls_rut_alumno'), $li_id_curso, $li_valor_beca);";
			//echo("<-- Grabando Tabla Pago_Estado ALUMNO : $sql_insert_alumno <BR><BR>");
			$rs_insert_alumno = pg_exec($conexion,$sql_insert_alumno);
			
			
			}//Cierra el FOR Linea 872

	}//Cierra el FOR Linea 860

			$li_correlativo_epago_alumno = $li_correlativo_epago_alumno + 1;

	ECHO("<BR><Font color='#FF0000'>Procesos x COLEGIOS Terminados ...</Font><BR><BR>");
//********************************************************************************			
	
			
} //CIERRA EL FOR PRINCIPAL POR COLEGIOS	
pg_close($conexion);

?>

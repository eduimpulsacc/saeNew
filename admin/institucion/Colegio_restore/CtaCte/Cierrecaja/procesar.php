<? include"../../Coneccion/conexion.php"?>
<?	

	//$li_id_usuario	  = $_USUARIO;
	$li_id_usuario	  = $_GET['ai_usuario'];
	$hoy		 = getdate();
	$dia_actual  = $hoy["mday"];
	$mes_actual  = date(m);	
	$year_actual = $hoy["year"];
	$ldt_fecha   = $year_actual.$mes_actual.$dia_actual;
	
	$ldt_hora_hours    = date(H);
	$ldt_hora_minutes  = date(i);
	$ldt_hora_seconds  = date(s);
	$ldt_hora		   = $ldt_hora_hours.$ldt_hora_minutes.$ldt_hora_seconds;


		$sql             = "Select * From con_cierre_detalle ";
		$resultado_query_verifica = pg_exec($conexion,$sql);
		$total_filas_verifica     = pg_numrows($resultado_query_verifica);
	
			If($total_filas_verifica <= 0) 
			{
	
				$sql             = "Select id_comprobante, monto From con_comprobante ;";
			
			}Else
			{
	
				$sql             = "Select Distinct a.id_comprobante, a.monto From con_comprobante a, con_cierre_detalle b Where a.id_comprobante not in (Select Distinct a1.id_comprobante From con_comprobante a1, con_cierre_detalle b1 Where a1.id_comprobante = b1.id_comprobante);";
			
			}//Cierra el Else Linea 26
		
		//echo("SQL : $sql <BR>");
		$resultado_query = pg_exec($conexion,$sql);
		$total_filas     = pg_numrows($resultado_query);

		if($total_filas <= 0)
		{
			echo("<Center><Font Size='2'><BR><B> No Se encontraron Nuevos Comprobantes para hoy... </B></Center>");
		}else
		{

			// *********************************************************************************************
			// GRABA EL PRIMER REGISTRO EN CIERRE CAJA (CORRELATIVO)
			// *********************************************************************************************
			
			$sql_validcorr= "Select id_cierre From con_cierre_caja Order By id_cierre DESC ";
			$resultado_query_validcorr = pg_exec($conexion,$sql_validcorr);
			$total_filas_validcorr     = pg_numrows($resultado_query_validcorr);
			
			If($total_filas_validcorr<=0)
			{
				$li_id_cierre = 0;
			}Else
			{
				$li_id_cierre = pg_result($resultado_query_validcorr, 0, 0);
			}
				$li_id_cierre = $li_id_cierre + 1;
			
			$sql_insert= "INSERT INTO con_cierre_caja VALUES($li_id_cierre, '$ldt_fecha', '$ldt_hora', $li_id_usuario);";
			//echo(" : $sql_insert <BR>");
			$rs_insert = pg_exec($conexion,$sql_insert);
			
			// *********************************************************************************************

			// For que Recorre el Primer Query
			FOR($i=0; $i < $total_filas; $i++)
			{
			
			$li_id_comprobante = pg_result($resultado_query, $i, 0);
			$li_monto		   = pg_result($resultado_query, $i, 1);
			
				$sql_total_pagado = "Select Sum(monto) From con_documento where id_comprobante = $li_id_comprobante ";
				$resultado_query_tpagado = pg_exec($conexion,$sql_total_pagado);
				$total_filas_tpagado     = pg_numrows($resultado_query_tpagado);
				
				If($total_filas_tpagado <= 0)
				{
				$li_monto_pagado = 0;
				}Else
				{
				$li_monto_pagado = pg_result($resultado_query_tpagado, 0, 0);
				}
			
			$sql_insert= "INSERT INTO con_cierre_detalle VALUES($li_id_cierre, $li_id_comprobante, $li_monto_pagado);";
			//echo(" SQL 3 : $sql_insert <BR>");
			$rs_insert = pg_exec($conexion,$sql_insert);
			
			}
		
		echo("<Center><Font Size='2'><BR><B> Todos los procesos CIERRE CAJA terminaron exitosamente... </B></Center>");		
		}//Cierra el ELSE Linea 34
	
?>
	



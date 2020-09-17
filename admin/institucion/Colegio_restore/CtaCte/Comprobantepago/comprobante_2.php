<? include"../../Coneccion/conexion.php"?>
<?
if($_GET["MM_delete"] != '')
{

	$li_id_comprobante    = $_GET["MM_delete"];
	$ls_id_tipodoc        = $_GET["MM_delete_02"];
	$ls_nserie            = $_GET["MM_delete_03"];

	$sql_delete = "Delete From con_documento_temp Where id_temp = $li_id_comprobante And id_tipo_documento = $ls_id_tipodoc And Trim(numero) = '$ls_nserie' ;";
	$res_delete = pg_exec($conexion,$sql_delete);
	
	
			$li_id_usuario    = Trim($_GET["hf_id_usuario"]);
			$ls_ctacte		  = Trim($_GET["hf_ctacte"]);
			$ls_comprobante	  = Trim($_GET["hf_comprobante"]);
			$li_id_comprobante= Trim($_GET["hf_id_comprobante"]);
			$li_monto_total	  = Trim($_GET["hf_monto_total"]);
			$ls_obs1		  = Trim($_GET["tf_obs_1"]);
			$ls_obs2	      = Trim($_GET["tf_obs_2"]);
			//echo(" $li_id_usuario - $ls_ctacte - $ls_comprobante - $li_id_comprobante - $li_monto_total - $ls_obs1 -  $ls_obs2 <br> ");
		
			?>
			<Script>
			window.location.href="comprobante_2.php?ai_mostrar=1&ai_go=1&ai_usuario=<?=($li_id_usuario)?>&as_ctacte=<?=($ls_ctacte)?>&ai_monto_apagar=<?=($li_monto_total)?>&as_obs1=<?=($ls_obs1)?>&as_obs2=<?=($ls_obs2)?>&ai_comprobante=<?=($li_id_comprobante)?>&as_comprobante=<?=($ls_comprobante)?>"
			</Script>
			<?		
	
}

?>
<?
	if($_GET["cb_save"] != '')
	{
	// Datos que se Repiten
	$li_id_usuario    = Trim($_GET["hf_id_usuario"]);
	$li_id_perfil     = Trim($_GET["hf_id_perfil"]);
	if($li_id_usuario == '')

	{?>
		<Script>
		window.location.href="no_user.php"
		</Script>

	<?
	}

	$ls_ctacte		  = Trim($_GET["hf_ctacte"]);
	$ls_comprobante	  = Trim($_GET["hf_comprobante"]);
	$li_monto_total	  = Trim($_GET["hf_monto_total"]);
	$ls_obs1		  = Trim($_GET["tf_obs_1"]);
	$ls_obs2	      = Trim($_GET["tf_obs_2"]);
	$ls_cancela	      = Trim($_GET["ddlb_cancela"]);

		If($ls_ctacte == '')

		{
		}Else
		{
		$hoy = getdate();
		$year_actual = $hoy["year"];
		$mes_actual  = date(m);
		$ldt_periodo = $year_actual.$mes_actual;

		$sql_datos= "Select * From con_estado_pago where id_ctacte = '$ls_ctacte' and periodo = '$ldt_periodo' ;";
		$resultado_query_datos = pg_exec($conexion,$sql_datos);
		$total_filas_datos     = pg_numrows($resultado_query_datos);

			If($total_filas_datos<=0)

			{

				$ls_ep_id_ctacte   = 0;
				$ls_ep_periodo	   = 0;
				$li_ep_correlativo = 0;

			}Else

			{

				$ls_ep_id_ctacte   = Trim(pg_result($resultado_query_datos, 0, 0));
				$ls_ep_periodo	   = Trim(pg_result($resultado_query_datos, 0, 1));
				$li_ep_correlativo = Trim(pg_result($resultado_query_datos, 0, 2));

			}

		}

	$li_graba  = Trim($_GET["hf_save_2"]);
	If($li_graba != 1)

	{	

	//Obtiene el correlativo Del ID_Comprobante
	$sql_validcorr= "Select id_comprobante from con_comprobante Order By id_comprobante Desc ;";
	$resultado_query_validcorr = pg_exec($conexion,$sql_validcorr);
	$total_filas_validcorr     = pg_numrows($resultado_query_validcorr);

		If($total_filas_validcorr<=0)
		{
			$li_id_comprobante = 0;
		}Else
		{
			$li_id_comprobante = Trim(pg_result($resultado_query_validcorr, 0, 0));
		}
		$li_id_comprobante = $li_id_comprobante + 1;

	}Else

	{
		$li_id_comprobante = Trim($_GET["hf_id_comprobante"]);
	}

	//Obtiene la Fecha y Hora del Sistema
	If($li_id_perfil == 0)

	{
		$year_actual = Trim($_GET["tf_year"]);
		$mes_actual  = Trim($_GET["tf_mes"]);
		$dia_actual  = Trim($_GET["tf_dia"]);
	}Else{
		$hoy = getdate();
		$year_actual = $hoy["year"];
		$mes_actual  = date(m);
		$dia_actual  = $hoy["mday"];
	}

	$ldt_fecha_actual = $year_actual.$mes_actual.$dia_actual;

	$ldt_hora_hours    = date(H);
	$ldt_hora_minutes  = date(i);
	$ldt_hora_seconds  = date(s);
	$ldt_hora_actual   = ($ldt_hora_hours.$ldt_hora_minutes.$ldt_hora_seconds);


	If($li_graba != 1)

	{

	$sql_delete= "DELETE FROM con_comprobante_temp ";
	$rs_delete = pg_exec($conexion,$sql_delete);

	$sql_delete_02= "DELETE FROM con_documento_temp ";
	$rs_delete_02 = pg_exec($conexion,$sql_delete_02);

	$sql_delete_03= "DELETE FROM con_comprobante_pago_temp ";
	$rs_delete_03 = pg_exec($conexion,$sql_delete_03);


	//GRABANDO LOS PRIMEROS VALORES

	$sql_insert= "INSERT INTO con_comprobante_temp VALUES($li_id_comprobante, '$ls_ctacte', $li_id_usuario, '$ldt_fecha_actual', '$ldt_hora_actual', '$ls_cancela', '$ls_ep_id_ctacte', '$ls_ep_periodo', $li_ep_correlativo, $li_monto_total, '$ls_obs1', '$ls_obs2');";
	//echo("Insert con_comprobante_temp : $sql_insert <BR>");
	$rs_insert = pg_exec($conexion,$sql_insert);

	}


	//Actualizacion 03 Agosto
	$li_total_cuentas = $_GET["hf_total_cuentas"];
	$sql_valida_cuenta = "";
		For ($x=0; $x < $li_total_cuentas; $x++)
		{
		
			$li_monto_cancela = $_GET["tf_cancela_".$x];
			$ls_rut_alumno    = $_GET["hf_rutalumno_cuenta_".$x];
			$li_id_cuenta     = $_GET["hf_id_cuenta_".$x];			
			
			$sql_valida_cuenta = "Select * From con_comprobante_pago_temp Where id_comprobante = $li_id_comprobante and rut_alumno = '$ls_rut_alumno' and id_cuenta = $li_id_cuenta ";
			$resultado_query_valida = pg_exec($conexion,$sql_valida_cuenta);
			$total_filas_valida     = pg_numrows($resultado_query_valida);
			
					if($total_filas_valida <= 0)
					{

						$sql_insert= "INSERT INTO con_comprobante_pago_temp VALUES($li_id_comprobante, '$ls_rut_alumno', $li_id_cuenta, $li_monto_cancela );";
						$rs_insert = pg_exec($conexion,$sql_insert);
					
					}else{//Modifica
					
						$sql_update= "UPDATE con_comprobante_pago_temp SET monto = $li_monto_cancela WHERE id_comprobante = $li_id_comprobante AND rut_alumno = '$ls_rut_alumno' and id_cuenta = $li_id_cuenta ";
						$rs_update = pg_exec($conexion,$sql_update);
					
					}

			
		}

	// Datos PARA DOCUMENTOS

	$li_item 		   = Trim($_GET["hf_item"]);

		if($li_item =='')
		{
		$li_item = 1;
		}
	$li_tipo_documento = Trim($_GET["ddlb_tipo_doc"]);
	$ls_nserie		   = Trim($_GET["tf_nserie"]);

		if($ls_nserie =='')
		{
		$ls_nserie = '';
		}

	$li_monto	       = Trim($_GET["tf_monto"]);

		if($li_monto =='')
		{
		$li_monto = 0;
		}

	$ls_obs3		   = Trim($_GET["tf_obs_3"]);

		if($ls_obs3 =='')
		{
		$ls_obs3 = '';
		}

	$ls_obs4	       = Trim($_GET["tf_obs_4"]);

		if($ls_obs4 =='')
		{
		$ls_obs4 = '';
		}

	//GRABANDO LOS PRIMEROS VALORES en  CON_DOCUMENTO

	$sql_insert_2= "INSERT INTO con_documento_temp VALUES($li_id_comprobante, $li_item, $li_tipo_documento, '$ls_nserie', $li_monto, '$ls_obs3', '$ls_obs4');";
	//echo("Insert 2 : $sql_insert_2 <BR>");
	$rs_insert = pg_exec($conexion,$sql_insert_2);

?>
		<Script>
		window.location.href="comprobante_2.php?ai_mostrar=1&ai_go=1&ai_usuario=<?=($li_id_usuario)?>&as_ctacte=<?=($ls_ctacte)?>&ai_monto_apagar=<?=($li_monto_total)?>&as_obs1=<?=($ls_obs1)?>&as_obs2=<?=($ls_obs2)?>&ai_comprobante=<?=($li_id_comprobante)?>&as_comprobante=<?=($ls_comprobante)?>"
		</Script>
<?
	}
	//TERMINA EL PRIMER GRABAR BOTON +
?>

<?
	if($_GET["cb_finaliza"] != '')
	{
	$li_id_temp = $_GET["hf_id_comprobante"];


	//GUARDANDO EN CON_COMPROBANTE_PAGO DESDE EL TEMP
	$sql_2= "Select * from con_comprobante_pago_temp where id_comprobante = $li_id_temp ;";
	$resultado_query_sql_2 = pg_exec($conexion,$sql_2);
	$total_filas_sql_2     = pg_numrows($resultado_query_sql_2);

		$li_sumatotaldocumentos = $_GET["hf_sumatotaldocumentos"];
		$li_sumatotalcancela	= $_GET["hf_sumatotalcancela"];
		
		if($li_sumatotaldocumentos != $li_sumatotalcancela)
		{
		
			$li_id_usuario    = Trim($_GET["hf_id_usuario"]);
			$ls_ctacte		  = Trim($_GET["hf_ctacte"]);
			$ls_comprobante	  = Trim($_GET["hf_comprobante"]);
			$li_id_comprobante= Trim($_GET["hf_id_comprobante"]);
			$li_monto_total	  = Trim($_GET["hf_monto_total"]);
			$ls_obs1		  = Trim($_GET["tf_obs_1"]);
			$ls_obs2	      = Trim($_GET["tf_obs_2"]);
			//echo(" $li_id_usuario - $ls_ctacte - $ls_comprobante - $li_id_comprobante - $li_monto_total - $ls_obs1 -  $ls_obs2 <br> ");
		
			?>
			<Script>
			alert("Usted contiene Totales en Documentos que no coinciden con el Total que Cancela en Transacciones !!! ");
			window.location.href="comprobante_2.php?ai_mostrar=1&ai_go=1&ai_usuario=<?=($li_id_usuario)?>&as_ctacte=<?=($ls_ctacte)?>&ai_monto_apagar=<?=($li_monto_total)?>&as_obs1=<?=($ls_obs1)?>&as_obs2=<?=($ls_obs2)?>&ai_comprobante=<?=($li_id_comprobante)?>&as_comprobante=<?=($ls_comprobante)?>"
			</Script>
			<?		
		}else{

		For ($j=0; $j < $total_filas_sql_2; $j++)

		{
		$ls_rut_alumno 	= pg_result($resultado_query_sql_2, $j, 1);		
		$li_id_cuenta 	= pg_result($resultado_query_sql_2, $j, 2);
		$li_monto	  	= pg_result($resultado_query_sql_2, $j, 3);
		$li_total_cancelado = ($li_total_cancelado + $li_monto);


		$sql_insert_3 = "INSERT INTO con_comprobante_pago VALUES($li_id_temp, '$ls_rut_alumno', $li_id_cuenta, $li_monto) ";
		$rs_insert_3  = pg_exec($conexion,$sql_insert_3);
		}
		
		//} //Cierra IF linea 234


	$sql= "Select * from con_comprobante_temp where id_temp = $li_id_temp ;";
	$resultado_query_sql = pg_exec($conexion,$sql);
	$total_filas_sql     = pg_numrows($resultado_query_sql);

		For ($j=0; $j < $total_filas_sql; $j++)

		{
		$ls_ctacte 	 = Trim(pg_result($resultado_query_sql, $j, 1));
		$li_usuario  = Trim(pg_result($resultado_query_sql, $j, 2));
		$ldt_fecha   = Trim(pg_result($resultado_query_sql, $j, 3));
		$ldt_hora	 = Trim(pg_result($resultado_query_sql, $j, 4));
		$ls_cancela  = Trim(pg_result($resultado_query_sql, $j, 5));
		$ls_ep_ctacte  		= Trim(pg_result($resultado_query_sql, $j, 6));
		$ls_ep_periodo  	= Trim(pg_result($resultado_query_sql, $j, 7));
		$li_ep_correlativo  = Trim(pg_result($resultado_query_sql, $j, 8));
		$li_monto_apagar    = Trim(pg_result($resultado_query_sql, $j, 9));
		$ls_obs1	   	    = Trim(pg_result($resultado_query_sql, $j, 10));
		$ls_obs2  		    = Trim(pg_result($resultado_query_sql, $j, 11));

		

		$sql_insert= "INSERT INTO con_comprobante VALUES($li_id_temp, '$ls_ctacte', $li_usuario, '$ldt_fecha', '$ldt_hora', '$ls_cancela', '$ls_ep_ctacte', '$ls_ep_periodo', $li_ep_correlativo, $li_monto_apagar, '$ls_obs1', '$ls_obs2');";
		$rs_insert = pg_exec($conexion,$sql_insert);
		}

	//GUARDANDO EN CON_DOCUMENTO DESDE EL TEMP
	$sql= "Select * from con_documento_temp where id_temp = $li_id_temp ;";
	$resultado_query_sql = pg_exec($conexion,$sql);
	$total_filas_sql     = pg_numrows($resultado_query_sql);

		For ($j=0; $j < $total_filas_sql; $j++)

		{
		$li_item 	     = Trim(pg_result($resultado_query_sql, $j, 1));
		$li_id_tipo_doc  = Trim(pg_result($resultado_query_sql, $j, 2));
		$ls_nserie   	 = Trim(pg_result($resultado_query_sql, $j, 3));
		$li_monto	 	 = Trim(pg_result($resultado_query_sql, $j, 4));
		$ls_obs3	 	 = Trim(pg_result($resultado_query_sql, $j, 5));
		$ls_obs4     	 = Trim(pg_result($resultado_query_sql, $j, 6));

		$sql_insert_2= "INSERT INTO con_documento VALUES($li_id_temp, $li_item, $li_id_tipo_doc, '$ls_nserie', $li_monto, '$ls_obs3', '$ls_obs4');";
		$rs_insert = pg_exec($conexion,$sql_insert_2);
		}

				
	$sql_delete03= "DELETE FROM con_comprobante_pago_temp WHERE id_comprobante = $li_id_temp ;";
	$rs_delete = pg_exec($conexion,$sql_delete03);

	$sql_delete= "DELETE FROM con_comprobante_temp WHERE id_temp = $li_id_temp ;";
	$rs_delete = pg_exec($conexion,$sql_delete);

	$sql_delete_02= "DELETE FROM con_documento_temp WHERE id_temp = $li_id_temp ;";
	$rs_delete_02 = pg_exec($conexion,$sql_delete_02);		

	$ls_comprobante	  = $_GET["hf_comprobante"];
	?>

	<Script>
	window.location.href="none.php?as_ctacte=<?=($ls_ctacte)?>&ai_comprobante=<?=($li_id_temp)?>&ai_usuario=<?=($li_usuario)?>&as_comprobante=<?=($ls_comprobante)?>"
	</Script>
	<?
	
		} //Cierra IF linea 237
	
	}
	//TERMINA EL FINALIZAR
	//*************************************************************************
	?>
<?
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = date(m);
	$ldt_periodo = $year_actual.$mes_actual;

	$li_go_table	= Trim($_GET["ai_go"]);
	$li_id_usuario  = Trim($_GET["ai_id_usuario"]);
	$li_id_perfil 	= Trim($_GET["ai_perfil"]);
	$li_id_epago    = Trim($_GET["ai_epago"]); // Estado de Pago a Cancelar
	//echo("Ctacte : $li_id_epago - User : ($li_id_usuario) - Perfil : ($li_id_perfil) <BR>");
	
	
	// Actualizacion 05 de Agosto
	//****************************************************************************	
	$sql_verifica_saldo = "Select * from con_saldo where id_ctacte = '$li_id_epago' And periodo = '$ldt_periodo' ";
	$verifica_saldo	    = pg_exec($conexion,$sql_verifica_saldo);
	$total_verifica     = pg_numrows($verifica_saldo);
	//echo(" $sql_verifica_saldo - $total_verifica");
		if($total_verifica > 0)
		{?>
			<Script>
			alert("El proceso se encuentra Cerrado !!!");
			window.location.href="cerrado.php"
			</Script>
		<?
		}
	//****************************************************************************	
		
		$sql_ctacte= "Select id_ctacte from con_apoderado_ctacte where id_ctacte = '$li_id_epago';";
		$resultado_query_ctacte = pg_exec($conexion,$sql_ctacte);
		$total_filas_ctacte     = pg_numrows($resultado_query_ctacte);

			If($total_filas_ctacte<=0)
			{
				$ls_ctacte  = '';
			}Else{
				$ls_ctacte = Trim(pg_result($resultado_query_ctacte, 0, 0));

			//$sql_monto= "Select monto, id_ctacte, periodo, correlativo From con_estado_pago where id_ctacte = '$ls_ctacte' and periodo = '$ldt_periodo' ;";
			//$sql_monto = "Select distinct a.monto, a.id_ctacte, a.periodo, a.correlativo, sum(b.monto) From con_estado_pago a , con_saldo b where a.id_ctacte = '$ls_ctacte' and a.periodo = '$ldt_periodo' and a.id_ctacte = b.id_ctacte and b.periodo <='$ldt_periodo' group by a.monto, a.id_ctacte, a.periodo, a.correlativo";
			$sql_monto = "Select a.monto, a.id_ctacte, a.periodo, a.correlativo, sum(b.monto) From con_estado_pago a left outer join con_saldo b ON (a.id_ctacte=b.id_ctacte And b.periodo <='$ldt_periodo') Where a.id_ctacte = '$ls_ctacte' and a.periodo = '$ldt_periodo' Group by a.monto, a.id_ctacte, a.periodo, a.correlativo ";
			$resultado_query_monto = pg_exec($conexion,$sql_monto);
			$total_filas_monto     = pg_numrows($resultado_query_monto);

				If($total_filas_monto<=0)
				{
					$li_monto_apagar = 0;
				}Else{
					$li_monto_apagar 		 = pg_result($resultado_query_monto, 0, 0);
					$li_monto_saldoanterior  = pg_result($resultado_query_monto, 0, 4);
						If($li_monto_saldoanterior == ''){$li_monto_saldoanterior = 0;}
					$li_monto_apagar = ($li_monto_apagar + $li_monto_saldoanterior);
					$ls_id_ctacte	 = Trim(pg_result($resultado_query_monto, 0, 1));
					$ls_periodo		 = Trim(pg_result($resultado_query_monto, 0, 2));
					$li_correlativo  = Trim(pg_result($resultado_query_monto, 0, 3));
					$ls_comprobante	 = $ls_id_ctacte.$ls_periodo.$li_correlativo;
				}
				//echo("Bandera 1 : $sql_monto <BR><BR> A pagar : ($li_monto_apagar) - Anterior ($li_monto_saldoanterior)<BR>");

				//Busca si existen datos en las Tabla COMPROBANTE
				$sql_verifica= "Select * from con_comprobante where id_ctacte = '$li_id_epago' And ep_periodo = '$ldt_periodo';";
				$resultado_query_verifica = pg_exec($conexion,$sql_verifica);
				$total_filas_verifica     = pg_numrows($resultado_query_verifica);

					if($total_filas_verifica<=0)
					{

						$li_go = '';

					}Else{

						$li_id_comprobante = Trim(pg_result($resultado_query_verifica, 0, 0));
						$ls_ctacte	       = Trim(pg_result($resultado_query_verifica, 0, 1));
						$ls_obs1		   = Trim(pg_result($resultado_query_verifica, 0, 10));
						$ls_obs2		   = Trim(pg_result($resultado_query_verifica, 0, 11));
						$li_go 			   = 0;

					}

			}

?>

<?

	$li_mostrar = Trim($_GET["ai_mostrar"]);
	//echo("<BR> li_mostrar : ($li_mostrar)  <BR><BR>");
	
	If($li_mostrar <> 0)
	{
		// Parametros que Recibe Despues de Buscar 
		$ls_rut_apoderado  = Trim($_GET["as_id_rut"]);
		$ls_ctacte		   = Trim($_GET["as_ctacte"]);
		$li_id_usuario	   = Trim($_GET["ai_usuario"]);
		$li_monto_apagar   = Trim($_GET["ai_monto_apagar"]);
		$li_id_comprobante = Trim($_GET["ai_comprobante"]);
		$ls_obs1	  	   = Trim($_GET["as_obs1"]);
		$ls_obs2		   = Trim($_GET["as_obs2"]);
		$ls_comprobante	   = Trim($_GET["as_comprobante"]);
		//echo("<BR> Bandera 2 li_monto_apagar : ($li_monto_apagar) - li_id_comprobante ($li_id_comprobante)- ls_comprobante ($ls_comprobante) <BR>");
	}
?>
<?
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = $hoy["mon"];
	$dia_actual  = $hoy["mday"];


	  If($mes_actual == 1)

	  {

	  	$li_nombre_mes = "ENERO";

	  }Else If($mes_actual == 2) 

	  {

	  	$li_nombre_mes = "FEBRERO";

	  }Else If($mes_actual == 3) 

	  {

	 	 $li_nombre_mes = "MARZO";

	  }Else If($mes_actual == 4) 

	  {

	  	$li_nombre_mes = "ABRIL";

	  }Else If($mes_actual == 5) 

	  {

	  	$li_nombre_mes = "MAYO";

	  }Else If($mes_actual == 6) 

	  {

	  	$li_nombre_mes = "JUNIO";

	  }Else If($mes_actual == 7) 

	  {

	  	$li_nombre_mes = "JULIO";

	  }Else If($mes_actual == 8) 

	  {

	  	$li_nombre_mes = "AGOSTO";

	  }Else If($mes_actual == 9) 

	  {

	  	$li_nombre_mes = "SEPTIEMBRE";

	  }Else If($mes_actual == 10) 

	  {

	 	 $li_nombre_mes = "OCTUBRE";

	  }Else If($mes_actual == 11) 

	  {

	  	$li_nombre_mes = "NOVIEMBRE";

	  }Else If($mes_actual == 12) 

	  {

	  	$li_nombre_mes = "DICIEMBRE";

	  }
	$ldt_fecha_actual = $dia_actual." de ".$li_nombre_mes." de ".$year_actual

?>
<?
	$sql= "Select * from con_tipo_documento Order By nombre ;";
	$resultado_query   = pg_exec($conexion,$sql);
	$total_filas_tipo  = pg_numrows($resultado_query);


	$sql= "SELECT B.NOMBRE_APO, B.APE_PAT, B.APE_MAT, B.RUT_APO, B.DIG_RUT, A.RDB FROM CON_APODERADO_CTACTE A, APODERADO B WHERE A.ID_CTACTE = '$ls_ctacte' AND A.RUT_APODERADO = B.RUT_APO ;";
	$resultado_query_apo = pg_exec($conexion,$sql);
	$total_filas_apo     = pg_numrows($resultado_query_apo);

	
	// CALCULA EL SALDO SI PAGO EN EL DIA
	If($li_id_comprobante > 0)
	{
		$sql= "SELECT SUM(con_documento.monto) as MONTO FROM con_documento, con_comprobante, con_estado_pago WHERE con_documento.id_comprobante = con_comprobante.id_comprobante and con_comprobante.ep_id_ctacte = con_estado_pago.id_ctacte and con_comprobante.ep_periodo = con_estado_pago.periodo and con_comprobante.ep_correlativo = con_estado_pago.correlativo and con_estado_pago.id_ctacte = '$ls_ctacte' and con_estado_pago.periodo = '$ldt_periodo' and con_documento.id_comprobante = $li_id_comprobante; ";
		//echo(" ($li_id_comprobante) : $sql <BR>");
		$resultado_query_saldo = pg_exec($conexion,$sql);
		$total_filas_saldo     = pg_numrows($resultado_query_saldo);
	
	}



	if($li_go_table == 1)

	{

	$sql_doc= "Select a.*, b.nombre From con_documento_temp a, con_tipo_documento b Where a.id_temp = $li_id_comprobante And a.id_tipo_documento = b.id_tipo_documento Order By 2,3;";
	//echo("SQL : $sql_doc <BR>");	
	$resultado_query_doc   = pg_exec($conexion,$sql_doc);
	$total_filas_doc       = pg_numrows($resultado_query_doc);

	}
?>
<?
$li_agno_actual = date(Y);
$li_agno_actual = $li_agno_actual + 2;
$li_cant_agno   = $li_agno_actual - 2003;
?>
<?
	// Ultimas Actualizaciones del Martes 03 de Agosto
	// ********************************************************
	
	$ls_rut_apoderado = pg_result($resultado_query_apo, 0, 3);
	$li_id_colegio	  = pg_result($resultado_query_apo, 0, 5);
	
	$sql_datos_cuentas= "SELECT distinct a.id_cuenta, c.rut_alumno, c.cuenta_nombre, (c.monto + c.monto_saldo) as Totalapagar FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c where a.rdb = $li_id_colegio and a.rdb = b.rdb and b.rut_apoderado = '$ls_rut_apoderado' and c.periodo = '$ldt_periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id Order by 2  ";
	//echo(" $sql_datos_cuentas <br>");
	$resultado_query_datos_cuentas = pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = pg_numrows($resultado_query_datos_cuentas);

?>
<html>
<head>
<title>COMPROBANTE DE PAGO</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" action="">
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 

      <td colspan="2" class="linea_datos_02"> 

        <div align="center"><b><font size="2">COMPROBANTE DE PAGO.</font></b></div>

      </td>

    </tr>

    <tr> 

      <td colspan="2"> 

        <div align="right"> 

          <input type="button" name="cb_go1" value="&lt;&lt; Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_callJS('history.go(-1)')">

        </div>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%">

        <div align="right">NOMBRE :</div>

      </td>

      <td class="membrete_datos" width="65%"><strong><font size="2">&nbsp; 
        <?=pg_result($resultado_query_apo, 0, 0)?>
        <?=pg_result($resultado_query_apo, 0, 1)?>
        <?=pg_result($resultado_query_apo, 0, 2)?>
        </font></strong></td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%">

        <div align="right">RUT :</div>

      </td>

      <td class="membrete_datos" width="65%">&nbsp; <font size="2"> <strong> 
        <?=pg_result($resultado_query_apo, 0, 3)?>
        - 
        <?=pg_result($resultado_query_apo, 0, 4)?>
        </strong> </font></td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">N&deg; CTACTE :</div>

      </td>

      <td class="membrete_datos" width="65%"> &nbsp; 

        <input type="text" name="tf_ctacte" class="text_9_x_200" value="<?=($ls_ctacte)?>" disabled>
        <input type="hidden" name="hf_ctacte" value="<?=($ls_ctacte)?>">
        <input type="hidden" name="hf_id_usuario" value="<?=($li_id_usuario)?>">
        <input type="hidden" name="hf_id_perfil" value="<?=($li_id_perfil)?>">

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">ESTADO PAGO :</div>

      </td>

      <td class="membrete_datos" width="65%">&nbsp; 

        <input type="text" name="tf_comprobante" class="text_9_x_200" value="<?=($ls_comprobante)?>" disabled>

        <input type="hidden" name="hf_comprobante" value="<?=Trim($ls_comprobante)?>">
        <?
		if($li_id_comprobante > 0)
		{
	  		$li_monto_saldo = pg_result($resultado_query_saldo, 0,0);
	  	}else
		{
			$li_monto_saldo = 0;
		}
		
	  //echo("Monto Cancelado Anterior: ($li_monto_apagar) - ($li_monto_saldo) <BR>");
	  $li_montoapagar_saldo = ($li_monto_apagar - $li_monto_saldo);
		
		If ($li_montoapagar_saldo <= 0)
		{
		echo("<b><Font size='1'> Cuenta Cancelada </Font></b>");
		}
		?>
      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">MONTO :</div>

      </td>

      <td class="membrete_datos" width="65%">&nbsp;

        <input type="text" name="tf_monto_total" class="text_9_x_200" value="<?=number_format(($li_montoapagar_saldo),2)?>" disabled>

        <input type="hidden" name="hf_monto_total" value="<?=($li_montoapagar_saldo)?>">

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">FECHA CANCELACION :</div>

      </td>

      <td class="membrete_datos" width="65%">&nbsp; 
        <?

		If($li_id_perfil == 0 or $li_id_perfil == 14 or $li_id_perfil == 3)

		{

		?>
        <select name="tf_dia" class="text_9_x_50" >

          <?

	For ($j=1; $j <= 31; $j++)

	{

		echo "<option value='".substr('00',1,2-strlen($j)) ."$j' ";

		if($j==date(j))

		{

			print "Selected";

		}

		echo ">".substr('00',1,2-strlen($j))."$j</option> ";

	}

	?>

        </select>
        <select name="tf_mes" class="text_9_x_80" >

          <option value="01"

	  <? If(date(n)==1)

	  {echo "selected";}

	  ?>>Enero </option>

          <option value="02"

  	  <? If(date(n)==2)

	  {echo "selected";}

	  ?>>Febrero </option>

          <option value="03"

   	  <? If(date(n)==3)

	  {echo "selected";}

	  ?>>Marzo </option>

          <option value="04"

   	  <? If(date(n)==4)

	  {echo "selected";}

	  ?>>Abril </option>

          <option value="05"

   	  <? If(date(n)==5)

	  {echo "selected";}

	  ?>>Mayo </option>

          <option value="06"

   	  <? If(date(n)==6)

	  {echo "selected";}

	  ?>>Junio </option>

          <option value="07"

   	  <? If(date(n)==7)

	  {echo "selected";}

	  ?>>Julio </option>

          <option value="08"

  	  <? If(date(n)==8)

	  {echo "selected";}

	  ?>>Agosto </option>

          <option value="09"

      <? If(date(n)==9)

	  {echo "selected";}

	  ?>>Seprtimbre </option>

          <option value="10"

   	  <? If(date(n)==10)

	  {echo "selected";}

	  ?>>Octubre </option>

          <option value="11"

   	  <? If(date(n)==11)

	  {echo "selected";}

	  ?>>Noviembre </option>

          <option value="12"

   	  <? If(date(n)==12)

	  {echo "selected";}

	  ?>>Diciembre </option>

        </select>
        <select name="tf_year" class="text_9_x_50" >

          <?

	$li_x = 2;

	For ($j=0; $j <= $li_cant_agno; $j++)

	{

		$li_x = $li_x + 1;

		echo "<option value='200$li_x'";

		$li_agno_paso = "200".$li_x;

		if($li_agno_paso == date(Y))

		{

			print "Selected";

		} 

		echo ">200$li_x</option> ";	

	}

	?>

        </select>

        <?

	}Else{

	?>

        <?=($ldt_fecha_actual)?>

        <?

	} //Cierra If perfil 0

	?>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">OBSERVACIONES 1 :</div>

      </td>

      <td class="membrete_datos" width="65%"> &nbsp; 

        <textarea name="tf_obs_1"><?=($ls_obs1)?></textarea>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%" height="68"> 

        <div align="right">OBSERVACIONES 2 :</div>

      </td>

      <td class="membrete_datos" width="65%" height="68"> &nbsp; 

        <textarea name="tf_obs_2"><?=($ls_obs2)?></textarea>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">CANCELA :</div>

      </td>

      <td class="membrete_datos" width="65%"> &nbsp; 

        <select name="ddlb_cancela" class="ddlb_x">

          <option value="T">TOTAL</option>

          <option value="A">ABONO</option>

        </select>

      </td>

    </tr>

  </table>  
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02" colspan="3"> <div align="center"><b> <font size="2">DETALLE 
          TRANSACCIONES.</font></b></div></td>
    </tr>
    <tr class="linea_datos_05"> 
      <td>&nbsp;CUENTA </td>
      <td> 
        <div align="center">MONTO a cancelar</div></td>
      <td><div align="center"> Cancela</div></td>
    </tr>
    <?
	$li_total_apagar = 0;
	$li_total_cancelado = 0;
	For ($x=0; $x < $total_filas_datos_cuentas; $x++)
	{
	
	$ls_rut_alumno = pg_result($resultado_query_datos_cuentas, $x, 1);
	$li_id_cuenta  = pg_result($resultado_query_datos_cuentas, $x, 0);
	

		  if($li_go_table == 1)
		  {
	
	$sql_datos_monto = "SELECT monto FROM con_comprobante_pago_temp WHERE id_comprobante = $li_id_comprobante AND rut_alumno = '$ls_rut_alumno' and id_cuenta = $li_id_cuenta ";
	$resultado_monto = pg_exec($conexion,$sql_datos_monto);
	$total_filas_monto_cuenta = pg_numrows($resultado_monto);

			}
	
				if($total_filas_monto_cuenta > 0)
				{ $li_monto_cuenta = pg_result($resultado_monto, 0, 0);
				}else{
				  $li_monto_cuenta = 0;
				}
				
				
				$li_monto_acancelar = pg_result($resultado_query_datos_cuentas, $x, 3);
				if($li_monto_acancelar >= 0)		
				{ //Despliga si es Saldo en Contra
	?>
    <tr> 
      <td class="membrete_datos">&nbsp; <?=pg_result($resultado_query_datos_cuentas, $x, 2);?> 
      </td>
      <td class="membrete_datos"> <div align="right">&nbsp; <?=number_format($li_monto_acancelar,2);?> 
        </div></td>
      <td class="membrete_datos"><div align="center">
          <input name="tf_cancela_<?=($x)?>" type="text" class="text_9_x_100" onKeyPress="Numero()" value="<?=($li_monto_cuenta)?>">
          <input name="hf_rutalumno_cuenta_<?=($x)?>" type="hidden" value="<?=pg_result($resultado_query_datos_cuentas, $x, 1)?>">
		  <input name="hf_id_cuenta_<?=($x)?>" type="hidden" value="<?=pg_result($resultado_query_datos_cuentas, $x, 0)?>">		  
        </div></td>
    </tr>
    <?
				}
	$li_total_pagar = ($li_total_pagar + pg_result($resultado_query_datos_cuentas, $x, 3));
	$li_total_cancelado = ($li_total_cancelado + $li_monto_cuenta);
	}
	?>
    <tr> 
      <td class="linea_datos_02"> <div align="right"><b>TOTAL TRANSACCIONES $ 
          </b></div></td>
      <td class="linea_datos_02"> <div align="right">&nbsp;<b> 
          <?=number_format($li_total_pagar,2)?>
          </b></div></td>
      <td class="linea_datos_02"><div align="center">
        <?=number_format($li_total_cancelado,2)?>
        <input type="hidden" name="hf_sumatotalcancela" value="<?=($li_total_cancelado)?>">
		</div></td>
    </tr>
  </table>
  <input name="hf_total_cuentas" type="hidden" value="<?=($total_filas_datos_cuentas)?>">
  <br>
        <?
		If ($li_montoapagar_saldo <= 0)
		{}
		Else
		{
		?>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 

      <td colspan="6" class="linea_datos_02"> 

        <div align="center"><b><font size="2">DOCUMENTO PAGO.</font></b></div>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_05"> 

        <div align="center">TIPO DOCUMENTO</div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">NUMERO - SERIE </div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">MONTO $</div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">OBSERVACION 1</div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">OBSERVACION 2</div>

      </td>

      <td class="linea_datos_05">&nbsp;</td>

    </tr>

    <tr> 

      <td class="membrete_datos"> 

        <div align="center"> 

          <select name="ddlb_tipo_doc" class="ddlb_x">

            <?

		For ($j=0; $j < $total_filas_tipo; $j++)

		{

		?>

            <option value="<?=pg_result($resultado_query, $j, 0)?>"> 

            <?=Trim(pg_result($resultado_query, $j, 1))?>

            </option>

            <?

		}

		?>

          </select>

        </div>

      </td>

      <td class="membrete_datos"> 

        <div align="center"> 

          <input type="text" name="tf_nserie" class="text_9_x_80">

        </div>

      </td>

      <td class="membrete_datos"> 

        <div align="center"> 

          <input type="text" name="tf_monto" class="text_9_x_100" onKeyPress="Numero()">

        </div>

      </td>

      <td class="membrete_datos"> 

        <div align="center"> 

          <textarea name="tf_obs_3" rows="3" class="text_9_x_100"></textarea>

        </div>

      </td>

      <td class="membrete_datos"> 

        <div align="center"> 

          <textarea name="tf_obs_4" rows="3" class="text_9_x_100"></textarea>

        </div>

      </td>

      <td class="membrete_datos"> 

        <div align="center"> 
        <?
		If ($li_montoapagar_saldo <= 0)
		{}
		Else
		{
		?>
          <input type="submit" name="cb_save" value="+" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
		<?
		}
		?>
        </div>

      </td>

    </tr>

  </table>
<?
}
?>


  <?

  if($li_go_table == 1)

  {

  ?><br>

  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>

      <td> 

        <input type="hidden" name="hf_id_comprobante" value="<?=($li_id_comprobante)?>">
        <input type="hidden" name="hf_save_2" value="<?=($li_go_table)?>">

      </td>

    </tr>

  </table>

  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 

      <td class="linea_datos_02" width="99"> 

        <div align="center">TIPO DOCUMENTO</div>

      </td>

      <td class="linea_datos_02" width="151"> 

        <div align="center">NUMERO - SERIE</div>

      </td>

      <td class="linea_datos_02" width="150"> 

        <div align="center">MONTO $</div>

      </td>

      <td class="linea_datos_02" width="184"> 

        <div align="center">OBSERVACION 1</div>

      </td>

      <td class="linea_datos_02" width="168"> 

        <div align="center">OBSERVACION 2</div>

      </td>

      <td class="linea_datos_02" width="34">&nbsp;</td>

    </tr>

    <?

	$li_suma_monto = 0;

	$li_item 	   = 1;

	For ($j=0; $j < $total_filas_doc; $j++)

	{

	?>

    <tr> 

      <td class="membrete_datos" width="99">&nbsp; 

        <?print Trim(pg_result($resultado_query_doc, $j, 7));?>

      </td>

      <td class="membrete_datos" width="151">&nbsp;

        <?print Trim(pg_result($resultado_query_doc, $j, 3));?>

      </td>

      <td class="membrete_datos" width="150">&nbsp; 

        <?=number_format(pg_result($resultado_query_doc, $j, 4),2);?>

        <?

		$li_suma_monto = $li_suma_monto + pg_result($resultado_query_doc, $j, 4);

		?>

      </td>

      <td class="membrete_datos" width="184">&nbsp; 

        <?print Trim(pg_result($resultado_query_doc, $j, 5));?>

      </td>

      <td class="membrete_datos" width="168">&nbsp; 

        <?print Trim(pg_result($resultado_query_doc, $j, 6));?>

      </td>

      <td class="membrete_datos" width="34"> 

        <div align="center"> 

          <input type="hidden" name="hf_id_comprobante_<?=($j)?>" value="<?=($li_id_comprobante)?>">
          <input type="hidden" name="hf_id_tipodoc_<?=($j)?>"     value="<?=Trim(pg_result($resultado_query_doc, $j, 2))?>">
          <input type="hidden" name="hf_id_nserie_<?=($j)?>"      value="<?=Trim(pg_result($resultado_query_doc, $j, 3))?>">
          <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="if (confirm('¿Esta seguro de eliminar este Documento ?')){MM_delete.value = hf_id_comprobante_<?=($j)?>.value;MM_delete_02.value = hf_id_tipodoc_<?=($j)?>.value;MM_delete_03.value = hf_id_nserie_<?=($j)?>.value;this.form.submit()}">

        </div>

      </td>

    </tr>

    <?

	$li_item = $li_item + 1;

	}

	?>

    <tr> 

      <td class="membrete_datos" colspan="2"> 

        <div align="right"><b>TOTAL $</b></div>

      </td>

      <td class="membrete_datos" width="150">&nbsp; 

        <?=number_format(($li_suma_monto),2)?>

      </td>

      <td class="membrete_datos" colspan="3">&nbsp;
	  <input type="hidden" name="hf_sumatotaldocumentos" value="<?=($li_suma_monto)?>"></td>

    </tr>

  </table>

  <input type="hidden" name="hf_item" value="<?=($li_item)?>" >

  <input type="hidden" name="MM_delete">

  <input type="hidden" name="MM_delete_02">

  <input type="hidden" name="MM_delete_03">

  <br>

  <table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>

    <td>

        <div align="right"> 

          <input type="submit" name="cb_finaliza" value="Finalizar PAGO" class="cb_none_9_x_100" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

        </div>

      </td>

  </tr>

</table>
  <?
  }
  ?>
</form>
</body>
</html>
<?
	pg_close($conexion);
?>
<Script>
function Numero()
{
var key = window.event.keyCode;
	if (key < 40 || key > 57)
	{
	window.event.keyCode=0;
	}
}
</Script>
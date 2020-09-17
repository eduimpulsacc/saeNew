<? include"../../Coneccion/conexion.php";

		/* COMENZA A GRABAR BOTON + */
		

		
	if($_POST["cb_save"] != '')

	{
	// Datos que se Repiten

	//echo $li_id_usuario    = Trim($_POST["hf_id_usuario"]);
	$li_id_colegio = trim($hf_id_colegio);
	$li_id_usuario    = Trim($ai_usuario);
	$li_id_perfil     = Trim($_POST["hf_id_perfil"]);
	if($li_id_usuario == '')

	{?>
		<Script>
		window.location.href="no_user.php"
		</Script>

	<?
	}

	$ls_ctacte		  = Trim($_POST["hf_ctacte"]);
	$ls_comprobante	  = Trim($_POST["hf_comprobante"]);
	//$li_monto_total	  = Trim($_POST["hf_monto_total"]);
	$li_monto_total	  = Trim($hf_monto_total);
	$ls_obs1		  = Trim($_POST["tf_obs_1"]);
	$ls_cancela	      = Trim($_POST["ddlb_cancela"]);

		If($ls_ctacte == '')

		{
		}Else
		{
		$hoy = getdate();
		$year_actual = $hoy["year"];
		$mes_actual  = date(m);
		$ldt_periodo = $year_actual.$mes_actual;

		//$sql_datos= "Select * From con_estado_pago where id_ctacte = '$ls_ctacte' and periodo = '$ldt_periodo' ;";
		//$resultado_query_datos = pg_exec($conexion,$sql_datos);
		//$total_filas_datos     = pg_numrows($resultado_query_datos);

			/*If($total_filas_datos<=0)

			{

				$ls_ep_id_ctacte   = 0;
				$ls_ep_periodo	   = 0;
				$li_ep_correlativo = 0;

			}Else

			{

				$ls_ep_id_ctacte   = Trim(pg_result($resultado_query_datos, 0, 0));
				$ls_ep_periodo	   = Trim(pg_result($resultado_query_datos, 0, 1));
				$li_ep_correlativo = Trim(pg_result($resultado_query_datos, 0, 2));

			}*/

		}

	$li_graba  = Trim($_POST["hf_save_2"]);
	/*If($li_graba != 1)

	{	

	//Obtiene el correlativo Del ID_Comprobante
	$sql_validcorr= "Select id_comprobante from con_comprobante Order By id_comprobante Desc ;";
	$resultado_query_validcorr = pg_exec($conexion,$sql_validcorr);
	$total_filas_validcorr     = pg_numrows($resultado_query_validcorr);

		If($total_filas_validcorr<=0)
		{
			$li_id_comprobante = 0;
		}Else{
			$li_id_comprobante = Trim(pg_result($resultado_query_validcorr, 0, 0));
		}
		$li_id_comprobante = $li_id_comprobante + 1;

	}Else{
		$li_id_comprobante = Trim($_POST["hf_id_comprobante"]);
	}*/

	//Obtiene la Fecha y Hora del Sistema
	If($li_id_perfil == 0)

	{
		$year_actual = Trim($_POST["tf_year"]);
		$mes_actual  = Trim($_POST["tf_mes"]);
		$dia_actual  = Trim($_POST["tf_dia"]);
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

	echo $sql_ins_id="INSERT INTO con_documenta_comprobante (id_ctacte, observacion) VALUES('$ls_ctacte','1')";
	$rs_ins_id = pg_exec($conexion,$sql_ins_id);	

	If($li_graba != 1)

	{

	 $sql_delete= "DELETE FROM con_comprobante_temp ;";
	
	$rs_delete = pg_exec($conexion,$sql_delete);

	 $sql_delete_02= "DELETE FROM con_documento_temp ;";
	
	$rs_delete_02 = pg_exec($conexion,$sql_delete_02);


	//GRABANDO LOS PRIMEROS VALORES
	
	echo $sql_maxid="SELECT id_comprobante_doc as max from con_documenta_comprobante WHERE id_ctacte='$ls_ctacte' AND observacion='1'";
	$rs_maxid = pg_exec($conexion,$sql_maxid);
	$fila_maxid = pg_fetch_array($rs_maxid,0);


	echo $sql_insert= "INSERT INTO con_comprobante_temp (id_temp, id_ctacte, id_usuario, fecha, hora,  monto) VALUES('".$fila_maxid['max']."','$ls_ctacte', $li_id_usuario, '$ldt_fecha_actual', '$ldt_hora_actual', $li_monto_total);";
	//echo("Insert con_comprobante_temp : $sql_insert <BR>");
	$rs_insert = pg_exec($conexion,$sql_insert);

	}

	// Datos PARA DOCUMENTOS

	$li_item 		   = Trim($_POST["hf_item"]);

		if($li_item =='')

		{

		$li_item = 1;

		}

	$li_tipo_documento = Trim($_POST["ddlb_tipo_doc"]);

	$ls_nserie		   = Trim($_POST["tf_nserie"]);

		if($ls_nserie =='')

		{

		$ls_nserie = '';

		}

	$li_monto	       = Trim($_POST["tf_monto"]);

		if($li_monto =='')

		{

		$li_monto = 0;

		}

	$ls_obs1		   = Trim($_POST["tf_obs_4"]);

		if($ls_obs1 =='')

		{

		$ls_obs1 = '';

		}




	//GRABANDO LOS PRIMEROS VALORES en  CON_DOCUMENTO

	echo $sql_insert_2= "INSERT INTO con_documento_temp (id_temp, item, id_tipo_documento, numero, monto, observacion01) VALUES(".$fila_maxid['max'].", $li_item, $li_tipo_documento, '$ls_nserie', $li_monto, '$ls_obs1');";
	//echo("Insert 2 : $sql_insert_2 <BR>");
	$rs_insert = pg_exec($conexion,$sql_insert_2);

?>
		<Script>
		window.location.href="Man_Documentar.php?ai_mostrar=1&ai_go=1&ai_usuario=<?=($li_id_usuario)?>&as_ctacte=<?=($ls_ctacte)?>&ai_monto_apagar=<?=($li_monto_total)?>&as_obs1=<?=($ls_obs1)?>&as_obs2=<?=($ls_obs2)?>&ai_comprobante=<?=($li_id_comprobante)?>&as_comprobante=<?=($ls_comprobante)?>&ai_colegio_selec=<?=($li_id_colegio)?>&ai_cuenta=<?=($ai_cuenta) ?>"
		</Script>
<?

	}//FIN if($_POST["cb_save"] != '')

	//TERMINA EL PRIMER GRABAR BOTON +

	//*************************************************************************


?>
	<?
	if($_POST["cb_finaliza"] != '')
	{
	$li_id_temp = Trim($_POST["hf_id_comprobante"]);

	$sql= "Select * from con_comprobante_temp where id_temp = $li_id_temp ;";
	//echo("SQL $sql <BR>");
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
		//$li_monto_apagar    = Trim($_POST["hf_monto_total"]);
		$ls_obs1	   	    = Trim(pg_result($resultado_query_sql, $j, 10));
		$ls_obs2  		    = Trim(pg_result($resultado_query_sql, $j, 11));

		

		$sql_insert= "INSERT INTO con_comprobante VALUES($li_id_temp, '$ls_ctacte', $li_usuario, '$ldt_fecha', '$ldt_hora', '$ls_cancela', '$ls_ep_ctacte', '$ls_ep_periodo', $li_ep_correlativo, $li_monto_apagar, '$ls_obs1', '$ls_obs2');";
		//ECHO(" SQL 1: $sql_insert <br>");		
		$rs_insert = pg_exec($conexion,$sql_insert);
		}

	//GUARDANDO EN CON_DOCUMENTO DESDE EL TEMP

	$sql= "Select * from con_documento_temp where id_temp = $li_id_temp ;";
	$resultado_query_sql = pg_exec($conexion,$sql);
	$total_filas_sql     = pg_numrows($resultado_query_sql);

		For ($j=0; $j < $total_filas_sql; $j++)	{
		$li_item 	     = Trim(pg_result($resultado_query_sql, $j, 1));
		$li_id_tipo_doc  = Trim(pg_result($resultado_query_sql, $j, 2));
		$ls_nserie   = Trim(pg_result($resultado_query_sql, $j, 3));
		$li_monto	 = Trim(pg_result($resultado_query_sql, $j, 4));
		$ls_obs3	 = Trim(pg_result($resultado_query_sql, $j, 5));
		$ls_obs4     = Trim(pg_result($resultado_query_sql, $j, 6));

		$sql_insert_2= "INSERT INTO con_documento VALUES($li_id_temp, $li_item, $li_id_tipo_doc, '$ls_nserie', $li_monto, '$ls_obs3', '$ls_obs4');";
		//ECHO("SQL : $sql_insert_2 <br>");
		$rs_insert = pg_exec($conexion,$sql_insert_2);
		}

		

	$sql_delete= "DELETE FROM con_comprobante_temp WHERE id_temp = $li_id_temp ;";
	$rs_delete = pg_exec($conexion,$sql_delete);

	$sql_delete_02= "DELETE FROM con_documento_temp WHERE id_temp = $li_id_temp ;";
	$rs_delete_02 = pg_exec($conexion,$sql_delete_02);		

	$ls_comprobante	  = Trim($_POST["hf_comprobante"]);
	?>

	<Script>
	window.location.href="none.php?as_ctacte=<?=($ls_ctacte)?>&ai_comprobante=<?=($li_id_temp)?>&ai_usuario=<?=($li_usuario)?>&as_comprobante=<?=($ls_comprobante)?>"
	</Script>
	<?
	}
	//TERMINA EL FINALIZAR
	//*************************************************************************
	
?>
<?
	$li_go_table	= Trim($_GET["ai_go"]);
	//$li_id_usuario  = Trim($_GET["ai_usuario"]);
	if ($ai_usuario!="") $li_id_usuario  = Trim($ai_usuario);
	$li_id_perfil 	= Trim($_GET["ai_perfil"]);
	$li_id_epago    = Trim($_GET["ai_epago"]); // Estado de Pago a Cancelar

$hoy = getdate();
$year_actual = $hoy["year"];
$mes_actual  = date(m); //Numero del mes Rango 01 al 12
$dia_actual  = $hoy["mday"];

	$li_mostrar_tabla = 1;
	if($li_mostrar_tabla==1)
	{
	$ldt_mes_consulta = Trim($_GET["ai_mes"]);
	$ls_rut_apoderado = Trim($_GET["as_rut_apo"]);
	$li_id_colegio    = Trim($_GET["ai_colegio_selec"]);
	$ldt_periodo	  = $year_actual.$ldt_mes_consulta;

		If(strlen($ldt_periodo) <= 4)
		{
			$ldt_periodo = $year_actual.$mes_actual;
		}Else
		{
			$ldt_periodo = $year_actual.$ldt_mes_consulta;
		}
	//ECHO("PERIODO  2 : $ldt_periodo <BR>");
	 $sql = "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $li_id_colegio And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 and a.rut_alumno = b.rut_alumno and b.rut_apo = c.rut_apo Order by 4 ;";
//exit;
	//ECHO("SQL 1: $sql <br>");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);

	If($total_filas > 0)
	{
	  If(Trim($ls_rut_apoderado) == '')
	  {
	  	$ls_rut_apoderado = Trim(pg_result($resultado_query, 0, 2));
	  }Else
	  {
	 	 $ls_rut_apoderado = $ls_rut_apoderado;
	  }

	$sql= "Select dig_rut From apoderado where rut_apo = '$ls_rut_apoderado' ;";
	$resultado_query_dig = pg_exec($conexion,$sql);

	$sql_instit= "Select rdb, nombre_instit From institucion Where rdb = $li_id_colegio ;";
	$resultado_query_instit = pg_exec($conexion,$sql_instit);
	$total_filas_instit     = pg_numrows($resultado_query_instit);

	// *** QUERY QUE SACA LAS FECHAS Y EL TOTAL SEGUN EL APODERADO

	$sql_datos= "select distinct * From con_apoderado_ctacte a, con_estado_pago b Where a.rdb = $li_id_colegio AND a.rut_apoderado = '$ls_rut_apoderado' and a.id_ctacte = b.id_ctacte and b.periodo = '$ldt_periodo' ;";
	
	//ECHO("SQL (1) : <BR> $sql_datos <br>");		
	$resultado_query_datos = pg_exec($conexion,$sql_datos);
	$total_filas_datos     = pg_numrows($resultado_query_datos);

	// *** QUERY QUE SACA LOS ALUMNO SEGUN EL APODERADO
	
	$sql_datos_alumno= "Select distinct a.rut_alumno, b.rut_apo, a.rdb, a.id_ano, a.id_curso, f.nombre_alu, f.ape_pat, f.ape_mat, f.dig_rut, f1.grado_curso, f1.letra_curso From matricula a, tiene2 b, ano_escolar e, alumno f, curso f1 where a.rdb = $li_id_colegio and b.rut_apo = '$ls_rut_apoderado' And a.rut_alumno = b.rut_alumno And a.rut_alumno = f.rut_alumno And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 And a.id_curso = f1.id_curso Order by 1 ; ";
	//ECHO("SQL ALUMNO X APODERADO (2) : <BR> $sql_datos_alumno <BR>");		
	$resultado_query_datos_alumno = pg_exec($conexion,$sql_datos_alumno);
	$total_filas_datos_alumno     = pg_numrows($resultado_query_datos_alumno);

	
	
	// *** QUERY QUE SACA VALORES DE CUENTAS SEGUN EL APODERADO
	$sql_datos_cuentas= "SELECT distinct a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, b.id_ctacte FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c where a.rdb = $li_id_colegio and a.rdb = b.rdb and b.rut_apoderado = '$ls_rut_apoderado' and c.periodo = '$ldt_periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id Order by 5,6 ";
	//ECHO("SQL SACA VALORES (3) : <BR> $sql_datos_cuentas <br>");			
	$resultado_query_datos_cuentas = pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = pg_numrows($resultado_query_datos_cuentas);
		If($total_filas_datos_cuentas<=0)
			{
				$li_mostrar_tabla_saldo = 0;
			}Else{

			$li_mostrar_tabla_saldo = 1;
			$ls_ctacte				= Trim(pg_result($resultado_query_datos_cuentas, 0, 6));

			// *** QUERY QUE SACA VALORES DE SALDO MES ACTUAL Y ANTERIORES
			//$sql_saldo = "SELECT distinct monto FROM con_saldo WHERE id_ctacte = '$ls_ctacte' And periodo <= '$ldt_periodo';";
			$sql_saldo = "SELECT sum(monto) FROM con_saldo WHERE id_ctacte = '$ls_ctacte' And periodo <= '$ldt_periodo';";
			//ECHO("SQL SALDO:: $sql_saldo <br>");						
			$resultado_query_saldo = pg_exec($conexion,$sql_saldo);
			$total_filas_saldo     = pg_numrows($resultado_query_saldo);

			}
		$sql= "Select * From con_cuenta where rdb = $li_id_colegio and asignar< 3 Order by nombre;";
		$resultado_query_cue = pg_exec($conexion,$sql);
		$total_filas_cue     = pg_numrows($resultado_query_cue);

		} //Cierra el Mayor a 0

	}

?>

<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<script language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post">
  <?
		if($li_mostrar_tabla==1){
			if($total_filas_datos <=0){
			Echo("<br><br><Center><font face='Verdana, Arial, Helvetica, sans-serif' size='2'>No se encontraron Registros.</font></Center>");
			?>
		<BR>
		<table width="50%" border="0" align="center">
			<tr>
			<td>
			<div align="center">
			  <input type="hidden" name="hf_rut_apo" value="<?=($ls_rut_apoderado)?>">
			  <input type="text" name="hf_id_colegio" value="<?=($li_id_colegio)?>">
			  <input type="button" name="cb_back" value="&lt;&lt; Volver a Consultar" class="cb_none_9_x_200" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'Cuerpo\']','Man_Documentar.php?ai_mostrar=1&as_rut_apo='+hf_rut_apo.value+'&ai_colegio_selec='+hf_id_colegio.value);return document.MM_returnValue">
			</div>
			</td>
			</tr>
			</table>
			<? }Else{?>
	<br>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"><font size="2"><b>DOCUMENTAR </b></font></div>
      </td>
    </tr>
  </table>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"><b>INSTITUCION :</b></div>
      </td>
      <td class="linea_datos_02"><font size="2"><b> 
        <?print Trim(pg_result($resultado_query_instit, 0, 1));?>
        <input type="text" name="hf_id_colegio" value="<?=($li_id_colegio)?>">
        </b></font></td>
    </tr>
    <tr> 
      <td height="41" class="linea_datos_02"> 
        <div align="center">CONSULTE MES</div>
      </td>
      <td class="linea_datos_02">
	  <?
	  If($ldt_mes_consulta == ''){
	  $ldt_mes_consulta = $mes_actual;
	  }
	  ?>
        <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.Cuerpo.location.href='Man_Documentar.php?ai_mostrar=1&ai_colegio_selec='+hf_id_colegio.value+'&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value">
          <option value="01" <? If($ldt_mes_consulta==1) {echo("Selected"); }?>>Enero</option>
          <option value="02" <? If($ldt_mes_consulta==2) {echo("Selected"); }?>>Febrero</option>
          <option value="03" <? If($ldt_mes_consulta==3) {echo("Selected"); }?>>Marzo</option>
          <option value="04" <? If($ldt_mes_consulta==4) {echo("Selected"); }?>>Abril</option>
          <option value="05" <? If($ldt_mes_consulta==5) {echo("Selected"); }?>>Mayo</option>
          <option value="06" <? If($ldt_mes_consulta==6) {echo("Selected"); }?>>Junio</option>
          <option value="07" <? If($ldt_mes_consulta==7) {echo("Selected"); }?>>Julio</option>
          <option value="08" <? If($ldt_mes_consulta==8) {echo("Selected"); }?>>Agosto</option>
          <option value="09" <? If($ldt_mes_consulta==9) {echo("Selected"); }?>>Septiembre</option>
          <option value="10" <? If($ldt_mes_consulta==10) {echo("Selected"); }?>>Octubre</option>
          <option value="11" <? If($ldt_mes_consulta==11) {echo("Selected"); }?>>Noviembre</option>
          <option value="12" <? If($ldt_mes_consulta==12) {echo("Selected"); }?>>Diciembre</option>
        </select>
      </td>
    </tr>
  </table>
  <br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02" colspan="2"> <div align="center">APODERADO</div></td>
      <td class="linea_datos_02" colspan="2">ESTADO DE LA CUENTA :</td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">NOMBRE :</div></td>
      <td class="membrete_datos"> <select name="ddlb_apoderado" class="ddlb_9_x_250" OnChange="parent.Cuerpo.location.href='Man_Documentar.php?ai_mostrar=1&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio_selec='+hf_id_colegio.value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value">
          <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
          <option value="<?=Trim(pg_result($resultado_query, $j, 2));?>" <? If(Trim(pg_result($resultado_query, $j, 2)) == $ls_rut_apoderado) {echo("selected");}?> > 
          <?=Trim(pg_result($resultado_query, $j, 3));?>
          <?=Trim(pg_result($resultado_query, $j, 4));?>
          <?=Trim(pg_result($resultado_query, $j, 5));?>
          </option>
          <?
	}
	?>
        </select> </td>
      <td class="linea_datos_02">Cuenta :</td>
      <td class="membrete_datos">
	  		<input type="text" name="hf_id_usuario" value="<?=($li_id_usuario)?>">
	  <select name="ddlb_cuenta" class="text_9_x_100" OnChange="parent.Cuerpo.location.href='Man_Documentar.php?ai_mostrar=1&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio_selec='+hf_id_colegio.value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_cuenta='+ddlb_cuenta.options[ddlb_cuenta.selectedIndex].value+'&ai_usuario='+<?php echo $li_id_usuario;?>+'&ai_perfil='+<?php echo $li_id_perfil;?>">
          <option value=0 selected>Seleccione Cuenta</option>
		  <?
			For ($x=0; $x<$total_filas_cue; $x++)
			{
		  		if (pg_result($resultado_query_cue, $x, 3)==$ai_cuenta){?>
		          <option value="<?=Trim(pg_result($resultado_query_cue, $x, 3));?>" selected> 
        		  <?=Trim(pg_result($resultado_query_cue, $x, 2));?>
          		  </option>
				 <? }else{ ?>
			      <option value="<?=Trim(pg_result($resultado_query_cue, $x, 3));?>"> 
        		  <?=Trim(pg_result($resultado_query_cue, $x, 2));?>
          		  </option>
		<?			}
		  }
		  ?>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">RUT :</div></td>
      <td class="membrete_datos">&nbsp; 
        <?
	  If(Trim($ls_rut_apoderado) == '')
	  {
	  	$ls_rut_apoderado = Trim(pg_result($resultado_query, 0, 2));
	  }Else
	  {
	  	$ls_rut_apoderado = $ls_rut_apoderado;
	  }
	  ?>
        <?=($ls_rut_apoderado)?>
        - 
        <?=Trim(pg_result($resultado_query_dig, 0, 0))?>
      </td>
      <td class="linea_datos_02">&nbsp;</td>
      <td class="membrete_datos">&nbsp; </td>
    </tr>
    <tr> 
      <td class="linea_datos_02">

        <input type="hidden" name="hf_ctacte" value="<?=($ls_ctacte)?>">

        <input type="hidden" name="hf_id_usuario" value="<?=($li_id_usuario)?>">

        <input type="hidden" name="hf_id_perfil" value="<?=($li_id_perfil)?>">
&nbsp;</td>
      <td class="membrete_datos">&nbsp;</td>
      <td class="linea_datos_02"><b>TOTAL A PAGAR :</b></td>
      <td class="membrete_datos">&nbsp; 
        <?
		For ($j=0; $j < $total_filas_datos_alumno; $j++){
			$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
			$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
			$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
			$sql_grado= "select distinct grado,monto from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and b.rdb=$ls_rdb and b.id_categoria=a.id_categoria and b.id_cuenta in (select id_cuenta from con_cuenta where rdb=$ls_rdb and asignar=$ai_cuenta)";
			$resultado_query_grado = @pg_exec($conexion,$sql_grado);
			$total_filas_grado = @pg_numrows($resultado_query_grado);
			$ls_total_matr=$ls_total_matr + @pg_result($resultado_query_grado, 0, 1);
		}
	?>
        <b>
        <?=number_format($ls_total_matr,2)?>
        </b> </td>
    </tr>
  </table>
  <br>
  <table width="650" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="4" class="linea_datos_02">
        <div align="center"><b>ALUMNOS </b></div>
      </td>
    </tr>
    <tr> 
		<TD class="linea_datos_02">&nbsp;</TD>	
      <td class="linea_datos_02">NOMBRE</td>
      <td class="linea_datos_02">
        <div align="center">CURSO</div>
      </td>
      <td class="linea_datos_02">
        <div align="center">MONTO <? if ($ai_cuenta=="1") echo "MATRICULA"; else echo "COLEGIATURA";?></div>
      </td>
    </tr>
    <?
	For ($j=0; $j < $total_filas_datos_alumno; $j++)
	{
	$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));
	$ls_grado = Trim(pg_result($resultado_query_datos_alumno, $j, 9));
	$ls_rdb = Trim(pg_result($resultado_query_datos_alumno, $j, 2));
	$sql_grado= "select distinct grado,monto from con_categoria_cuenta b, con_categoria_grado a where grado=$ls_grado and b.rdb=$ls_rdb and b.id_categoria=a.id_categoria and b.id_cuenta in (select id_cuenta from con_cuenta where rdb=$ls_rdb and asignar=$ai_cuenta)";
	$resultado_query_grado = @pg_exec($conexion,$sql_grado);
	$total_filas_grado = @pg_numrows($resultado_query_grado);
	
	?>
    <tr> 
		<td><input name="chk[$j]" type="checkbox" value=""></td>
      <td class="membrete_datos">&nbsp;<?print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?> <?print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?> <?print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?></td>
      <td class="membrete_datos">
        <div align="right">&nbsp; 
          <?print pg_result($resultado_query_datos_alumno, $j, 9);?>
          <?print Trim(pg_result($resultado_query_datos_alumno, $j, 10));?>
        </div>
      </td>
      <td class="membrete_datos"><div align="right">&nbsp; <? echo(@pg_result($resultado_query_grado, 0, 1));?></div>
	  </td>
    </tr>
	<?
	$ls_total_matricula=$ls_total_matricula + @pg_result($resultado_query_grado, 0, 1);
	}
	?>
	<tr>
		<td colspan="3" class="linea_datos_02">TOTAL <? if ($ai_cuenta=="1") echo "MATRICULA"; else echo "COLEGIATURA";?></td>
		<td class="membrete_datos">
        <div align="right">
          <input type="hidden" name="hf_monto_total" value="<? echo $ls_total_matricula; ?>">
          &nbsp; <? echo number_format($ls_total_matricula,'2'.'.'.'.'); ?> </div>
      </td>
	</tr>
  </table>
  <br>
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

        <div align="center">FECHA Venc.</div>

      </td>

      <td class="linea_datos_05"> 

        <div align="center">OBSERVACION </div>

      </td>

      <td class="linea_datos_05">&nbsp;</td>

    </tr>

    <tr> 

      <td class="membrete_datos"> 

        <div align="center"> 
		<?php 
			$sql= "Select * from con_tipo_documento Order By nombre ;";
			$resultado_query   = pg_exec($conexion,$sql);
			$total_filas_tipo  = pg_numrows($resultado_query);

		?>

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
          <input type="text" name="tf_venc" class="text_9_x_100">
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
		/*If ($li_montoapagar_saldo <= 0)
		{}
		Else
		{*/
		?>
          <input type="submit" name="cb_save" value="+" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
		<?
		//}
		?>
        </div>
      </td>
    </tr>
  </table>
 <br>
 <?

  if($li_go_table == 1){
  ?><br>

  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">

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

      <td class="membrete_datos" colspan="3">&nbsp;</td>

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
  <BR>

  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center" id="capa0">
          <input type="hidden" name="hf_ai_mes" value="<?=($ldt_mes_consulta)?>">
          <input type="hidden" name="hf_rut_apo" value="<?=($ls_rut_apoderado)?>">
          <input type="hidden" name="hf_colegio" value="<?=($li_id_colegio)?>">
 		<input 	name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" 		onclick="imprimir();" value="Imprimir">		  
        </div>
     </td>
  </tr>
</table>
  <?
	}
		}Else
		{
		echo("<Center><BR><Font size='2'> Seleccione una Institución... </Center>");
		}
?>
</form>
</body>
</html>
<?
pg_close($conexion);
?>
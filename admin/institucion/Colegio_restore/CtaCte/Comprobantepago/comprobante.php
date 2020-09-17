<? include"../../Coneccion/conexion.php"?>

<?

	if($_GET["cb_go"] != '')
	{

	

	$ls_input 		= Trim($_GET["tf_input"]);

	$li_tipo_busqda = Trim($_GET["ddlb_tipo"]);

	$li_id_usuario  = Trim($_GET["hf_id_usuario"]);

	$li_id_perfil   = Trim($_GET["hf_id_perfil"]);

	$li_id_colegio  = Trim($_GET["hf_colegio"]);

	

	?>

	<Script>

	window.location.href="comprobante.php?ai_mostrar_epago=100&ai_tipo_busqda=<?=($li_tipo_busqda)?>&ai_usuario=<?=($li_id_usuario)?>&as_input=<?=($ls_input)?>&ai_perfil=<?=($li_id_perfil)?>&ai_colegio_selec=<?=($li_id_colegio)?>"

	</Script>	

	<?

	

	}

?>

<?

		// Parametros que Recibe cuando Entra 

		$li_id_colegio	  = Trim($_GET["ai_colegio_selec"]);	

		$li_id_perfil 	  = Trim($_GET["ai_perfil"]);

		$li_id_usuario	  = Trim($_GET["ai_usuario"]);

		$li_mostrar_epago = Trim($_GET["ai_mostrar_epago"]);

		$li_tipo_busqda   = Trim($_GET["ai_tipo_busqda"]);

		$ls_input		  = Trim($_GET["as_input"]);

		

		// Aqui se Aplica combinacion de Coleres para el Menu

		$ls_color_over = "#FFCC66";

		$ls_color_out  = "#FFFFFF";



				

		If($li_mostrar_epago == 100) //Numero cualquiera		

		{

			$hoy = getdate();

			$year_actual = $hoy["year"];

			$mes_actual  = date(m);

			$ldt_periodo = $year_actual.$mes_actual;

		

			If($li_tipo_busqda == 2) //Busqueda Por Rut Apoderado

			{

			$sql_epago= "SELECT DISTINCT a.id_ctacte, b.rdb, c.nombre_instit, c1.nombre_apo, c1.ape_pat, c1.ape_mat, a.periodo, a.correlativo, b.rut_apoderado, c1.dig_rut FROM con_estado_pago a, con_apoderado_ctacte b, institucion c, apoderado c1, MATRICULA A1, TIENE2 B1, ANO_ESCOLAR E1 WHERE substr(Trim(a.id_ctacte),6,8) like Trim('%$ls_input%') And a.periodo = '$ldt_periodo' And Trim(a.vigente) = 'S' And a.id_ctacte = b.id_ctacte And b.rdb = c.rdb And b.rut_apoderado = c1.rut_apo AND B.RDB = $li_id_colegio AND B.RDB = A1.RDB AND A1.rdb = E1.id_institucion And A1.id_ano = E1.id_ano And E1.nro_ano = $year_actual And E1.situacion = 1 and A1.rut_alumno = B1.rut_alumno and B1.rut_apo = C1.rut_apo Order By 4,5,6 ;";

			

			}Else IF($li_tipo_busqda == 1) // Sino Solo Despliega 1 Solo

			{

					

			$sql_epago= "SELECT DISTINCT a.id_ctacte, b.rdb, c.nombre_instit, c1.nombre_apo, c1.ape_pat, c1.ape_mat, a.periodo, a.correlativo, b.rut_apoderado, c1.dig_rut FROM con_estado_pago a, con_apoderado_ctacte b, institucion c, apoderado c1, MATRICULA A1, TIENE2 B1, ANO_ESCOLAR E1 WHERE (substr(Trim(a.id_ctacte),1,16) || a.periodo || a.correlativo) LIKE '%$ls_input%' And a.periodo = '$ldt_periodo' And Trim(a.vigente) = 'S' And a.id_ctacte = b.id_ctacte And b.rdb = c.rdb And b.rut_apoderado = c1.rut_apo AND B.RDB = $li_id_colegio AND B.RDB = A1.RDB AND A1.rdb = E1.id_institucion And A1.id_ano = E1.id_ano And E1.nro_ano = $year_actual And E1.situacion = 1 and A1.rut_alumno = B1.rut_alumno and B1.rut_apo = C1.rut_apo Order By 4,5,6 ;";

			

			

			}Else IF($li_tipo_busqda == 3)

			{



			echo $sql_epago= "SELECT DISTINCT a.id_ctacte, b.rdb, c.nombre_instit, c1.nombre_apo, c1.ape_pat, c1.ape_mat, a.periodo, a.correlativo, b.rut_apoderado, c1.dig_rut FROM con_estado_pago a, con_apoderado_ctacte b, institucion c, apoderado c1, MATRICULA A1, TIENE2 B1, ANO_ESCOLAR E1 WHERE a.id_ctacte = b.id_ctacte And b.rut_apoderado = c1.rut_apo And (Upper(trim(c1.nombre_apo) || ' ' || trim(c1.ape_pat) || ' ' || trim(c1.ape_mat))) LIKE Upper('%$ls_input%') And a.periodo = '$ldt_periodo' And Trim(a.vigente) = 'S' And b.rdb = c.rdb AND B.RDB = $li_id_colegio AND B.RDB = A1.RDB AND A1.rdb = E1.id_institucion And A1.id_ano = E1.id_ano And E1.nro_ano = $year_actual And E1.situacion = 1 and A1.rut_alumno = B1.rut_alumno and B1.rut_apo = C1.rut_apo Order By 4,5,6 ;";



			}

			

			//Echo("Bus : ($li_tipo_busqda) - SQL : ($sql_epago) <BR>");

			$resultado_query_epago = pg_exec($conexion,$sql_epago);

			$total_filas_epago     = pg_numrows($resultado_query_epago);





			pg_close($conexion);



			

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



<html>

<head>

<title>COMPROBANTE DE PAGO</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" href="../../css/objeto.css" type="text/css">

</head>



<body bgcolor="#FFFFFF" text="#000000">

<form name="form1"  action="">

  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      <td colspan="2" class="linea_datos_02"> 

        <div align="center"><b><font size="2">COMPROBANTE DE PAGO.</font></b></div>

      </td>

    </tr>

    <tr> 

      <td colspan="2">&nbsp;</td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%"> 

        <div align="right">BUSQUEDA POR :</div>

      </td>

      <td class="membrete_datos" width="65%">&nbsp; 

        <select name="ddlb_tipo" class="ddlb_9_x_150">

          <option value="1" <?If($li_tipo_busqda ==1) {Echo("Selected");}?>>N&deg; 

          ESTADO PAGO</option>

          <option value="2" <?If($li_tipo_busqda ==2) {Echo("Selected");}?>>RUT 

          APODERADO</option>

          <option value="3" <?If($li_tipo_busqda ==3) {Echo("Selected");}?>>NOMBRE 

          APODERADO</option>

        </select>

        <input type="hidden" name="hf_id_usuario" value="<?=($li_id_usuario)?>">

        <input type="hidden" name="hf_id_perfil" value="<?=($li_id_perfil)?>">

        <input type="hidden" name="hf_colegio" value="<?=($li_id_colegio)?>">

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02" width="35%">&nbsp;</td>

      <td class="membrete_datos" width="65%"> &nbsp; 

        <input type="text" name="tf_input" class="text_9_x_200" value="<?=($ls_input)?>">

        <input type="submit" name="cb_go" value="Buscar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

      </td>

    </tr>

    <?

	  If($li_mostrar_epago == 100)

	  {

	  ?>

    <?

		If($total_filas_epago <= 0)

		{

		?>

    <tr> 

      <td colspan="2"> 

        <div align="center"><font size="2"><b>No se encontraron Registros...</b></font></div>

      </td>

    </tr>

    <?

		}

		?>

    <?

		

	} //Cierra Cuendo Contiene mas de 1 PAGO

	?>

  </table>  

  <br>

  <?

	  If($li_mostrar_epago == 100 And $total_filas_epago <> 0)

	  {

	  ?>

  <table width="600" border="1" cellspacing="0" cellpadding="0" align="center">

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center"><font size="2"><b>RESULTADO DE LA BUSQUEDA.</b></font></div>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02">&nbsp; 

        <?=($total_filas_epago)?>

        Registros</td>

    </tr>

  </table>

  <table width="600" border="1" cellspacing="0" cellpadding="0" align="center">

    <tr> 

      <td class="linea_datos_05">&nbsp;INSTITUCI&Oacute;N</td>

      <td class="linea_datos_05">&nbsp;NOMBRE APODERADO</td>

      <td class="linea_datos_05">&nbsp;RUT</td>

      <td class="linea_datos_05">&nbsp;N&deg; ESTADO PAGO</td>

    </tr>

    <?

For ($j=0; $j < $total_filas_epago; $j++)

{

?>

    <tr onMouseOver="this.style.backgroundColor='<?=($ls_color_over)?>'; this.style.cursor='hand'"

	onMouseOut="this.style.backgroundColor='<?=($ls_color_out)?>';" Onclick="Enviar(<?=($j)?>)"> 

      <td><font size="1">&nbsp; 

        <?=pg_result($resultado_query_epago, $j, 2);?>

        </font></td>

      <td ><font size="1">&nbsp; 

        <?=pg_result($resultado_query_epago, $j, 3);?>

        <?=pg_result($resultado_query_epago, $j, 4);?>

        <?=pg_result($resultado_query_epago, $j, 5);?>

        </font></td>

      <td >

        <div align="right"><font size="1">&nbsp; 

          <?=pg_result($resultado_query_epago, $j, 8);?>

          - 

          <?=pg_result($resultado_query_epago, $j, 9);?>

          </font></div>

      </td>

      <td >

        <div align="right"><font size="1">&nbsp; 

          <?=pg_result($resultado_query_epago, $j, 0);?>

          <?=pg_result($resultado_query_epago, $j, 6);?>

          <?=pg_result($resultado_query_epago, $j, 7);?>

          <input type="hidden" name="hf_ctacte_<?=($j)?>" value="<?=pg_result($resultado_query_epago, $j, 0)?>">

        </font></div>

      </td>

    </tr>

    <?

}

?>

  </table>



	<?

	} //Cierra IF 595

	?>
</form>
</body>
</html>
<script language="Javascript">
function Enviar(correlativo)
{
var ctacte    = eval('document.form1.hf_ctacte_'+correlativo+'.value');
var usuario   = eval('document.form1.hf_id_usuario.value');
var perfil    = eval('document.form1.hf_id_perfil.value');
parent.Cuerpo.location.href = 'comprobante_2.php?ai_epago='+ctacte+'&ai_id_usuario='+usuario+'&ai_perfil='+perfil;
}
</script>


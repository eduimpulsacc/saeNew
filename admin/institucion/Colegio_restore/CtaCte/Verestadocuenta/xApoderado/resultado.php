<? include"../../../Coneccion/conexion.php"?>
<?
$hoy = getdate();
$year_actual = $hoy["year"];
$mes_actual  = date(m); //Numero del mes Rango 01 al 12
$dia_actual  = $hoy["mday"];
?>

<?	

	$li_mostrar_tabla = Trim($_GET["ai_mostrar"]);

	if($li_mostrar_tabla==1)

	{

	$ldt_mes_consulta = Trim($_GET["ai_mes"]);

	$ls_rut_apoderado = Trim($_GET["as_rut_apo"]);

	$li_id_colegio    = Trim($_GET["ai_colegio"]);

	

	

	$li_id_usuario = Trim($_GET["ai_usuario"]);

	$li_id_perfil  = Trim($_GET["ai_perfil"]);

	//Echo("Pefil : ($li_id_perfil) <BR>");

	

	if($li_id_perfil == 16)

	{

		$sql= "SELECT DISTINCT A.ID_USUARIO, B.RUT_APO, B.RUT_ALUMNO FROM USUARIO A, TIENE2 B WHERE A.ID_USUARIO = $li_id_usuario AND A.NOMBRE_USUARIO = B.RUT_ALUMNO ;";
		$resultado_query_user= pg_exec($conexion,$sql);
		$total_filas_user    = pg_numrows($resultado_query_user);

	

		If($total_filas_user <= 0)
		{
			$ls_rut = 0;

		}else{

			$ls_rut_alumno_Ver  = pg_result($resultado_query_user, 0, 2); 
			$ls_rut        		= pg_result($resultado_query_user, 0, 1);	

		}

	

	}Else //PERFIL APODERADO

	{	

		$sql= "Select nombre_usuario From usuario Where id_usuario = $li_id_usuario ;";
		$resultado_rut = pg_exec($conexion,$sql);
		$total_rut     = pg_numrows($resultado_rut);
	

		If($total_rut <=0)

		{}
		else{

			$ls_rut = Trim(pg_result($resultado_rut, 0, 0));

		}

	}

	

	$ldt_periodo	  = $year_actual.$ldt_mes_consulta;
	If(strlen($ldt_periodo) <= 4)
	{

		$ldt_periodo = $year_actual.$mes_actual;

	}else{

		$ldt_periodo = $year_actual.$ldt_mes_consulta;

	}
	//ECHO("PERIODO  2 : $ldt_periodo <BR>");


	$sql = "Select distinct b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat  From tiene2 b, apoderado c where b.rut_apo = '$ls_rut' and b.rut_apo = c.rut_apo Order by 2, 3, 1 ; ";
	//ECHO("SQL 1: $sql <br>");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);


	If($total_filas > 0)

	{

	  If(Trim($ls_rut_apoderado) == '')
	  {

	  	$ls_rut_apoderado = Trim(pg_result($resultado_query, 0, 0));

	  }else{

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
	//ECHO("SQL ALUMNO X APODERADO PERFIL ($li_id_perfil) : <BR> $sql_datos_alumno <BR>");		
	$resultado_query_datos_alumno = pg_exec($conexion,$sql_datos_alumno);
	$total_filas_datos_alumno     = pg_numrows($resultado_query_datos_alumno);
	

	// *** QUERY QUE SACA VALORES DE CUENTAS SEGUN EL APODERADO
	$sql_datos_cuentas= "SELECT a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, c.rut_alumno, c.monto_saldo, (c.monto + c.monto_saldo) as Total_apagarconsaldo FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c where a.rdb = $li_id_colegio and a.rdb = b.rdb and b.rut_apoderado = '$ls_rut_apoderado' and c.periodo = '$ldt_periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id ";
	//echo("SQL CUENTAS VALORES (3) : <BR> $sql_datos_cuentas <br>");			
	$resultado_query_datos_cuentas = pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = pg_numrows($resultado_query_datos_cuentas);

		} //Cierra el Mayor a 0

	}
?>
<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
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

<form name="form1" method="post" action="procesar.php?ai_colegio=<?=($li_id_colegio)?>">

  <?

		if($li_mostrar_tabla==1)

	{

	

			if($total_filas_datos <=0)

			{

			Echo("<br><br>

			<Center><font face='Verdana, Arial, Helvetica, sans-serif' size='2'>No se encontraron Registros...</font></Center>");

			Echo("

			<Center><font face='Verdana, Arial, Helvetica, sans-serif' size='1'>Usuario NO Existe en la Institución.</font></Center>");

			?>

			<BR>

			

			<table width="50%" border="0" align="center">

			<tr>

			<td>

			<div align="center">

			  <input type="hidden" name="hf_rut_apo" value="<?=($ls_rut_apoderado)?>">

			  <input type="hidden" name="hf_id_colegio" value="<?=($li_id_colegio)?>">

          	  <input type="hidden" name="hf_id_usuario" value="<?=($li_id_usuario)?>">

          <input type="button" name="cb_back" value="&lt;&lt; Volver a Consultar" class="cb_none_9_x_200" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'Cuerpo\']','resultado.php?ai_mostrar=1&as_rut_apo='+hf_rut_apo.value+'&ai_colegio='+hf_id_colegio.value+'&ai_usuario='+hf_id_usuario.value);return document.MM_returnValue">

			</div>

			</td>

			</tr>

			</table>

			<?

			}Else

			{?>

	<br>

  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center"><font size="2"><b>CONSULTA DE ESTADO DE CUENTA.</b></font></div>

      </td>

    </tr>

  </table>

  <table width="80%" border="1" align="center" cellspacing="0" cellpadding="0">

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center"><b>INSTITUCION :</b></div>

      </td>

      <td class="linea_datos_02"><font size="2"><b> 

        <?print Trim(pg_result($resultado_query_instit, 0, 1));?>

        <input type="hidden" name="hf_id_colegio" value="<?=($li_id_colegio)?>">

        </b></font></td>

    </tr>

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center">CONSULTE MES</div>

      </td>

      <td class="linea_datos_02"> 

        <?

	  If($ldt_mes_consulta == '')

	  {

	  $ldt_mes_consulta = $mes_actual;

	  }

	  ?>

        <input type="hidden" name="hf_id_usuario" value="<?=($li_id_usuario)?>">

        <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.Cuerpo.location.href='resultado.php?ai_mostrar=1&ai_colegio='+hf_id_colegio.value+'&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_usuario='+hf_id_usuario.value">

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

  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      <td class="linea_datos_02" colspan="2">

        <div align="center">APODERADO</div>

      </td>

      <td class="linea_datos_02"><div align="center">ESTADO DE LA CUENTA </div></td>

      <td class="membrete_datos">&nbsp;</td>

    </tr>

    <tr> 

      <td class="linea_datos_02">

        <div align="center">NOMBRE :</div>

      </td>

      <td class="membrete_datos">

        <select name="ddlb_apoderado" class="ddlb_9_x_250" OnChange="parent.Cuerpo.location.href='resultado.php?ai_mostrar=1&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio='+hf_id_colegio.value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value">

          <?

	For ($j=0; $j < $total_filas; $j++)

	{

	?>

          <option value="<?=Trim(pg_result($resultado_query, $j, 0));?>" <? If(Trim(pg_result($resultado_query, $j, 0)) == $ls_rut_apoderado) {echo("selected");}?> >

		<!-- CAMBIE EL ORDEN DE PRESENTACION DEL NOMBRE DE NOMBRE, APE_PAT, APE_MAT A APE_PAT,APE_MAT,NOMBRE -->

		  <?=Trim(pg_result($resultado_query, $j, 2));?> <?=Trim(pg_result($resultado_query, $j, 3));?> <?=Trim(pg_result($resultado_query, $j, 1));?>

		 </option>

	<?

	}

	?>

        </select>

      </td>

      <td class="linea_datos_02">FECHA EMISION :</td>

      <td class="membrete_datos">&nbsp;

        <?

		$ldt_fecha_emision = Trim(pg_result($resultado_query_datos, 0, 7));

		$ldt_dia_fecha 	   = substr($ldt_fecha_emision,6,2);

		$ldt_mes_fecha 	   = substr($ldt_fecha_emision,4,2);

		$ldt_year_fecha    = substr($ldt_fecha_emision,0,4);

		?>

        <?=($ldt_dia_fecha)?>/<?=($ldt_mes_fecha)?>/<?=($ldt_year_fecha)?>

	  </td>

    </tr>

    <tr> 

      <td class="linea_datos_02">

        <div align="center">RUT :</div>

      </td>

      <td class="membrete_datos">&nbsp;

	  <?

	  If(Trim($ls_rut_apoderado) == '')

	  {

	  $ls_rut_apoderado = Trim(pg_result($resultado_query, 0, 0));

	  }Else

	  {

	  $ls_rut_apoderado = $ls_rut_apoderado;

	  }

	  ?>

	  <?=($ls_rut_apoderado)?> - <?=Trim(pg_result($resultado_query_dig, 0, 0))?></td>

      <td class="linea_datos_02">FECHA VENCIMIENTO :</td>

      <td class="membrete_datos">&nbsp;

        <?

		$ldt_fecha_venci = Trim(pg_result($resultado_query_datos, 0, 8));

		$ldt_dia_fecha 	   = substr($ldt_fecha_venci,6,2);

		$ldt_mes_fecha 	   = substr($ldt_fecha_venci,4,2);

		$ldt_year_fecha    = substr($ldt_fecha_venci,0,4);

		?>

        <?=($ldt_dia_fecha)?>/<?=($ldt_mes_fecha)?>/<?=($ldt_year_fecha)?>

	  </td>

    </tr>

    <tr> 

      <td class="linea_datos_02">&nbsp;</td>

      <td class="membrete_datos">&nbsp;</td>

      <td class="linea_datos_02"><b>TOTAL A PAGAR :</b></td>

      <td class="membrete_datos">&nbsp;
    <?
	$li_total_pagar = 0;
	$li_monto		= 0;

	For ($x=0; $x < $total_filas_datos_cuentas; $x++)
	{

	$li_monto 		= pg_result($resultado_query_datos_cuentas, $x, 8);
	$li_monto_saldo = pg_result($resultado_query_datos_cuentas, $x, 7);
	
	$li_total_pagar = $li_total_pagar + $li_monto;
	$li_total_saldo = $li_total_saldo + $li_monto_saldo;
	
	}
	?>
	<b><?=number_format($li_total_pagar,2)?></b>
	  </td>

    </tr>

  </table>

  <br>

  <table width="80%" border="1" align="center" cellspacing="0" cellpadding="0">

    <tr> 

      <td colspan="3" class="linea_datos_02">

        <div align="center"><b>ALUMNOS</b></div>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02">NOMBRE</td>

      <td class="linea_datos_02">

        <div align="center">CURSO</div>

      </td>

      <td class="linea_datos_02">

        <div align="center">% BECA</div>

      </td>

    </tr>

    <?

	For ($j=0; $j < $total_filas_datos_alumno; $j++)

	{

	$ls_rut_alumno = Trim(pg_result($resultado_query_datos_alumno, $j, 0));

	

	$sql_beca= "SELECT * FROM CON_ALUMNO_BECA WHERE  RUT_ALUMNO = '$ls_rut_alumno';";

	$resultado_query_beca = pg_exec($conexion,$sql_beca);

	$total_filas_beca     = pg_numrows($resultado_query_beca);

	

	If($total_filas_beca <= 0)

	{

	$li_valor_beca = "0.00";

	}Else

	{

	$li_valor_beca = pg_result($resultado_query_beca, 0, 1);

	}

	?>

    <tr> 

      <td class="membrete_datos">&nbsp;

		  <?

		  If($li_id_perfil == 16 AND $ls_rut_alumno == $ls_rut_alumno_Ver)

		  {

		  ?>

		  <Font color="#FF0000">

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?>

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?>

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?>

		  </Font>

		  <?

		  }Else{

		  ?>

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 5));?>

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 6));?>

		  <?print Trim(pg_result($resultado_query_datos_alumno, $j, 7));?>

		  <?

		  } //Cierra el IF 375

		  ?>		  

	  </td>

      <td class="membrete_datos">

        <div align="right">&nbsp; 

          <?

		  If($li_id_perfil == 16 AND $ls_rut_alumno == $ls_rut_alumno_Ver)

		  {

		  ?>

          <Font color="#FF0000"> 

          <?print pg_result($resultado_query_datos_alumno, $j, 9);?>

          <?print Trim(pg_result($resultado_query_datos_alumno, $j, 10));?>

          </Font> 

          <?

		   }Else{

		   ?>

          <?print pg_result($resultado_query_datos_alumno, $j, 9);?>

          <?print Trim(pg_result($resultado_query_datos_alumno, $j, 10));?>

          <?

		   }

		   ?>

        </div>

      </td>

      <td class="membrete_datos">

        <div align="right">&nbsp; 

          <?

		  If($li_id_perfil == 16 AND $ls_rut_alumno == $ls_rut_alumno_Ver)

		  {

		  ?>

          <Font color="#FF0000"> 

          <?=($li_valor_beca)?>

          </Font> 

          <?

		   }Else{

		   ?>

          <?=($li_valor_beca)?>

          <?

			}

			?>

        </div>

      </td>

    </tr>

	<?

	}

	?>

  </table>

  <br>

  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02" colspan="2"> <div align="center"><b> DETALLE 
          TRANSACCIONES.</b></div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02">CUENTA</td>
      <td class="linea_datos_02"> <div align="right">MONTO</div></td>
    </tr>
    <?

	$li_monto_cuenta	  = 0;

	

	$li_suma_monto_saldo = 0;

	$li_monto_saldo_2      = 0;

	For ($x=0; $x < $total_filas_datos_cuentas; $x++)

	{
		$li_valida_saldo = pg_result($resultado_query_datos_cuentas, $x, 7);
		if($li_valida_saldo != 0)
		{
			$ls_name_class = "linea_datos_05";
		}else{
			$ls_name_class = "membrete_datos";		
		}

	?>
    <tr class="<?=($ls_name_class)?>"> 
      <td>&nbsp; <?print Trim(pg_result($resultado_query_datos_cuentas, $x, 4));?> 
        ( 
        <?=pg_result($resultado_query_datos_cuentas, $x, 6);?>
        ) </td>
      <td><div align="right"> <?print number_format(pg_result($resultado_query_datos_cuentas, $x, 8),2);?> 
        </div></td>
    </tr>
    <?

	}

	?>
    <tr> 
      <td class="linea_datos_02"> <div align="right"><b>TOTAL TRANSACCIONES $</b></div></td>
      <td class="linea_datos_02"><div align="right"><?=number_format($li_total_pagar,2)?>
        </div></td>
    </tr>
  </table>

  <br>
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      <td class="linea_datos_02"> 

        <div align="right"><b>TOTAL</b> $ </div>

      </td>

      <td class="linea_datos_02"><div align="right"> 

        <?=number_format($li_total_pagar,2)?>

        </div>

      </td>

    </tr>

    <tr> 
		<?
		if($li_total_saldo != 0)
		{
			$ls_name_class = "linea_datos_05";
		}else{
			$ls_name_class = "linea_datos_02";		
		}
		?>

      <td class="<?=($ls_name_class)?>"> 

        <div align="right"><b>SALDO $</b> </div>

      </td>

      <td class="<?=($ls_name_class)?>"> 

        <div align="right">&nbsp; 
          		<?
		if($li_total_saldo != 0)
		{
		?>
		<a href="#" Onclick="MM_openBrWindow('saldo.php?ai_id_colegio=<?=($li_id_colegio)?>&as_rut_apoderado=<?=($ls_rut_apoderado)?>','','status=yes,menubar=yes,width=500,height=300')"> 
          <?=number_format($li_total_saldo,2)?></a>
		 <?
		 }else{
		 ?>
		 <?=number_format($li_total_saldo,2)?>
		 <?
		 }
		 ?>
        </div>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02"> 

        <div align="right"><b>TOTAL A PAGAR $ </b></div>

      </td>

      <td class="linea_datos_02"> 

        <div align="right">&nbsp; 
          <b> 
          <?=number_format($li_total_pagar,2)?>
          </b> </div>

      </td>

    </tr>

  </table>

  <BR>

  <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td> 

        <div align="center" id="capa0">

          <input type="hidden" name="hf_ai_mes" value="<?=($ldt_mes_consulta)?>">

          <input type="hidden" name="hf_rut_apo" value="<?=($ls_rut_apoderado)?>">

          <input type="hidden" name="hf_colegio" value="<?=($li_id_colegio)?>">



          <!--input type="button" name="cb_imprimir" value="Version Imprimible" class="cb_none_9_x_100" onClick="MM_openBrWindow('resultado_impreso.php?ai_mostrar=1&amp;ai_mes=<?=($ldt_mes_consulta)?>&amp;as_rut_apo=<?=($ls_rut_apoderado)?>&amp;ai_colegio=<?=($li_id_colegio)?>','','toolbar=yes,status=yes,menubar=no,scrollbars=yes,width=600,height=500')"-->

	  

  		<input 	name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onclick="imprimir();" value="Imprimir">		  

		  

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
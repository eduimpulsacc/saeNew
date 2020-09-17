<?include"../Coneccion/conexion.php"?>

<?

$li_institucion = $_GET["ai_institucion"];



	$sql = " select distinct b.* from tipo_ense_inst a, tipo_ensenanza b, institucion c";

	$sql = $sql . " where a.cod_tipo = b.cod_tipo ";

	$sql = $sql . " and a.rdb = c.rdb and a.rdb = $li_institucion and a.estado < 2";

	

	//echo "SQL : $sql";

	$resultado_query_te= pg_exec($conexion,$sql);

	$total_filas_te= pg_numrows($resultado_query_te);

	

	pg_close($conexion);



$li_agno_actual = date(Y);

$li_cant_agno = $li_agno_actual - 2000;



?>

<html>

<head>

<title>Motor</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/JavaScript">

<!--

function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}

//-->

</script>

<link href="../css/objeto.css" rel="stylesheet" type="text/css">

</head>



<body leftmargin="0" topmargin="4" marginwidth="0" marginheight="0">

<FORM NAME="Listas" METHOD="POST" ACTION="">

  <table width="53%" border="1" align="center" cellpadding="1" cellspacing="0">

    <tr>

    <td>



  <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr> 

            <td colspan="2" class="titulosMotores">Busqueda Avanzada</td>

          </tr>

          <tr> 

            <td class="textosmediano">Buscar Por </td>

            <td><select name="ddlb_curso" class="ddlb_9_x">

                <?

					For ($j=1; $j < 9; $j++)

					{

				  ?>

							<option value="<?=$j;?>"> 

							<?=$j;?>

							</option>

							<?

					}	  

				  ?>

              </select>

              <select name="ddlb_letra" class="ddlb_9_x">

                <option value="A">A</option>

                <option value="B">B</option>

                <option value="C">C</option>

                <option value="D">D</option>

                <option value="E">E</option>

                <option value="F">F</option>

                <option value="G">G</option>

                <option value="H">H</option>

                <option value="I">I</option>

                <option value="J">J</option>

                <option value="K">K</option>

                <option value="L">L</option>

                <option value="M">M</option>

                <option value="N">N</option>

                <option value="&Ntilde;">&Ntilde;</option>

                <option value="O">O</option>

                <option value="P">P</option>

                <option value="Q">Q</option>

                <option value="R">R</option>

                <option value="S">S</option>

                <option value="T">T</option>

                <option value="U">U</option>

                <option value="V">V</option>

                <option value="W">W</option>

                <option value="X">X</option>

                <option value="Y">Y</option>

                <option value="Z">Z</option>

              </select>

              <select name="ddlb_tipo_ense" class="ddlb_9_x_250">

                <?

		For ($j=0; $j < $total_filas_te; $j++)

		{

   	  ?>

                <option value="<?print Trim(pg_result($resultado_query_te, $j, 0));?>"><?print Trim(pg_result($resultado_query_te, $j, 1));?></option>

                <?

		}	  

	  ?>

              </select> 

              <select name="ddlb_ano" class="ddlb_9_x" >

                <?

	For ($j=0; $j <= $li_cant_agno; $j++)

	{

		echo "<option value='200$j'";

		$li_agno_paso = "200".$j;

		if($li_agno_paso ==date(Y))

		{

			print "Selected";

		} 

		echo ">200$j</option> ";	

	}

	?>

              </select>

              <input name="cb_ok" type="button" class="cb_submit_9_x_75" id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','RegistroMatricula.php?as_institucion=<?=($li_institucion)?>&ai_curso='+ddlb_curso.options[ddlb_curso.selectedIndex].value+'&as_letra='+ddlb_letra.options[ddlb_letra.selectedIndex].value+'&ai_tipo_ense='+ddlb_tipo_ense.options[ddlb_tipo_ense.selectedIndex].value+'&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value);return document.MM_returnValue" value="Buscar"> 

            </td>

          </tr>

        </table>

</td>

  </tr>

</table>

</form>



</body>

</html>


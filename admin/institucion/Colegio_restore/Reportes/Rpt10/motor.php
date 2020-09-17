<?include"../Coneccion/conexion.php"?>
<?

$li_institucion = $_GET["ai_institucion"];

$sql= "select  distinct(alumno.rut_alumno), alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat from alumno, matricula where ";
$sql = $sql . " alumno.rut_alumno = matricula.rut_alumno and matricula.rdb = $li_institucion order by alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat;";
$resultado_query_cue = pg_exec($conexion,$sql);
$total_filas_cue     = pg_numrows($resultado_query_cue);

//pg_close($conexion);

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
            <td width="10%" class="textosmediano">Buscar Por </td>
            <td width="90%"> <select name="ddlb_alumno" class="ddlb_9_x">
                <!--?
		for ($j=0; $j<$total_filas_cue; $j++)
			{
		?>
                <option value="<?=(Trim(pg_result($resultado_query_cue, $j, 0)));?>"> 
                <?=(Trim(pg_result($resultado_query_cue, $j, 1)));?>
                <?=(Trim(pg_result($resultado_query_cue, $j, 2)));?>
                <?=(Trim(pg_result($resultado_query_cue, $j, 3)));?>
                </option>
                <!?
			}
		?-->
              </select>
              <SCRIPT LANGUAGE="Javascript">
<!--
function Tupla_alu ( campo1, campo2 )
{
	this.campo1 = campo1;
	this.campo2 = campo2;
}

<?
$li_ano_js = date(Y);
	if($li_ano_js=='')
	{
	$li_ano_js = "12345678";
	}
	
$sql= " select alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, ";
$sql = $sql . " alumno.ape_pat, alumno.ape_mat, ano_escolar.nro_ano ";
$sql = $sql . " from alumno, matricula, ano_escolar ";
$sql = $sql . " where alumno.rut_alumno = matricula.rut_alumno ";
$sql = $sql . " and ano_escolar.id_ano = matricula.id_ano ";
$sql = $sql . " and matricula.rdb = $li_institucion ";
$sql = $sql . " order by ano_escolar.nro_ano, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat"; 
//$sql = $sql . " and ano_escolar.nro_ano = 2004 ";
//echo "$sql";
$resultado_query_cue = pg_exec($conexion,$sql);
$total_filas_cue     = pg_numrows($resultado_query_cue);

$li_cuenta = 0;
$ls_cat    = date(Y);

for ($j=0; $j<$total_filas_cue; $j++)
{
	$li_ano_escolar = Trim(pg_result($resultado_query_cue, $j, 5));
	//echo("Id Perfil $perfil <BR>");
	if($ls_cat != $li_ano_escolar)
	{
	//cambio de categoria, empiezo a contar en 0
		$li_cuenta = 0;
		$ls_cat    = pg_result($resultado_query_cue, $j, 5);
	//además tengo que crear un nuevo array para la categoría
	?>
	var opciones_alu<?=$ls_cat?> = new Array();
	<?
	}
	?>
	opciones_alu<?=$ls_cat?>[<?=$li_cuenta?>]=new Tupla_alu("<?=Trim(pg_result($resultado_query_cue, $j, 2));?> <?=Trim(pg_result($resultado_query_cue, $j, 3));?> <?=Trim(pg_result($resultado_query_cue, $j, 4));?>","<?=pg_result($resultado_query_cue, $j, 0);?>");
<?
$li_cuenta = $li_cuenta+1;
}
?>

var li_contador;

function ComponerLista_alu ( array ) {
{
	if (array == 1 )
		{
		array = "<?=($li_ano_js)?>"
		}
}

BorrarLista_alu();
array = eval("opciones_alu" + array);

for (li_contador=0; li_contador<array.length; li_contador++) 
{
var optionObj_alu = new Option( array[li_contador].campo1, array[li_contador].campo2 );

Listas.ddlb_alumno.options[li_contador] = optionObj_alu;
} 
} 


function BorrarLista_alu() 
{
Listas.ddlb_alumno.length = 0;
}

//Inicializamos
ComponerLista_alu (1);

-->
</SCRIPT> 
              <select name="ddlb_ano" class="ddlb_9_x" OnChange="ComponerLista(document.forms.Listas.ddlb_ano[selectedIndex].value);ComponerLista_alu(document.forms.Listas.ddlb_ano[selectedIndex].value)">
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
              <select name="ddlb_periodo" class="ddlb_9_x">
              </select>
<!------->

              <SCRIPT LANGUAGE="Javascript">
<!--
function Tupla ( campo1, campo2 )
{
	this.campo1 = campo1;
	this.campo2 = campo2;
}

<?
$perfil = date(Y);
	if($perfil=='')
	{
	$perfil = "12345678";
	}
	
$sql= " select ano_escolar.nro_ano,periodo.id_periodo, periodo.nombre_periodo ";
$sql = $sql . " from periodo, ano_escolar ";
$sql = $sql . " where ano_escolar.id_ano = periodo.id_ano  ";
$sql = $sql . " and ano_escolar.id_institucion = $li_institucion ";
//$sql = $sql . " and ano_escolar.nro_ano = 2004 ";
$sql = $sql . " order by ano_escolar.nro_ano, periodo.id_periodo ";
//echo "$sql";
$resultado_query_cue = pg_exec($conexion,$sql);
$total_filas_cue     = pg_numrows($resultado_query_cue);

$cuenta = 0;
$cat    = date(Y);

for ($j=0; $j<$total_filas_cue; $j++)
{
	$li_id_colegio = Trim(pg_result($resultado_query_cue, $j, 0));
	//echo("Id Perfil $perfil <BR>");
	if($cat != $li_id_colegio)
	{
	//cambio de categoria, empiezo a contar en 0
		$cuenta = 0;
		$cat    = pg_result($resultado_query_cue, $j, 0);
	//además tengo que crear un nuevo array para la categoría
	?>
	var opciones<?=$cat?> = new Array();
	<?
	}
	?>
	opciones<?=$cat?>[<?=$cuenta?>]=new Tupla("<?=Trim(pg_result($resultado_query_cue, $j, 2));?> ","<?=pg_result($resultado_query_cue, $j, 1);?>");
<?
$cuenta = $cuenta+1;
}
?>

var contador;

function ComponerLista ( array ) {
{
	if (array == 1 )
		{
		array = "<?=($perfil)?>"
		}
}

BorrarLista();
array = eval("opciones" + array);

for (contador=0; contador<array.length; contador++) 
{
var optionObj = new Option( array[contador].campo1, array[contador].campo2 );

Listas.ddlb_periodo.options[contador] = optionObj;
} 
} 


function BorrarLista() 
{
Listas.ddlb_periodo.length = 0;
}

//Inicializamos
ComponerLista (1);

-->
</SCRIPT> 


<!----->
              <input name="cb_ok" type="button" class="cb_submit_9_x_75" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','Rpt10.php?as_institucion=<?=($li_institucion)?>&as_alumno='+ddlb_alumno.options[ddlb_alumno.selectedIndex].value+'&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value+'&ai_periodo='+ddlb_periodo.options[ddlb_periodo.selectedIndex].value);return document.MM_returnValue" value="Buscar"> 
            </td>
          </tr>
        </table>
</td>
  </tr>

</table>
</form>
</body>
</html>
<?
pg_close($conexion);
?>
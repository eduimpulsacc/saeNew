<? include"Coneccion/conexion.php"?>
<?
		$li_colegio_selec  = Trim($_GET["ai_colegio_selec"]);

		$li_id_area    = Trim($_GET["ai_area"]);
		$li_id_usuario = Trim($_GET["ai_usuario"]);
		$li_perfil     = Trim($_GET["ai_perfil"]);
		$ls_nombre     = Trim($_GET["as_nombre_user"]);
		$ls_nombre_menu= Trim($_GET["as_nombre_menu"]);
		$ls_nombre_menu_blanco = '';
		
		// Aqui se Aplica combinacion de Coleres para el Menu
		$ls_color_over = "#FFFFFF";
		//$ls_color_out  = "#FFCC66";
		$ls_color_out  = "#FFFFFF";

		$sql= "SELECT DISTINCT A.ID_AREA, B.*, C.ID_PERFIL , C.ID_NIVEL FROM CON_AREA A, CON_MODULO B, CON_PERFIL_MODULO C WHERE A.ID_AREA = $li_id_area AND A.ID_AREA = B.ID_AREA AND B.ID_MODULO = C.ID_MODULO AND C.ID_PERFIL = $li_perfil ORDER BY B.ORDEN ;";
		//ECHO(" SQL : $sql <BR>");
		$resultado_query = pg_exec($conexion,$sql);
	    $total_filas     = pg_numrows($resultado_query);
		
		pg_close($conexion);

?>
<html>
<head>
<title>Motor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/main_links.css" type="text/css">
<link rel="stylesheet" href="css/objeto.css" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="pagina">
<form name="form1" method="post" action="">
  <table width="118%" border="0" align="center" cellpadding="5" bordercolor="#0066CC" class="pagina">
    <? For ($j=0; $j < $total_filas; $j++)
{ 
?>
    <tr> 
      <td
  	onMouseOver="this.style.backgroundColor='<?=($ls_color_over)?>'; this.style.cursor='hand'"
	onMouseOut="this.style.backgroundColor='<?=($ls_color_out)?>';" 
	  ><font size="1"><b><a href="<?=Trim(pg_result($resultado_query, $j, 4));?>?ai_usuario=<?=($li_id_usuario)?>&ai_nivel=<?=Trim(pg_result($resultado_query, $j, 7));?>&ai_perfil=<?=($li_perfil)?>&ai_colegio_selec=<?=($li_colegio_selec)?>" target="Cuerpo" onClick="Enviar(<?=($j)?>)"> 
        <?=Trim(pg_result($resultado_query, $j, 3));?>
        </a> 
        <?
		$ls_nombre_menu_2 = ($ls_nombre_menu." / ".Trim(pg_result($resultado_query, $j, 3)));
		?>
        <input type="hidden" name="hf_nombre_<?=($j)?>" value="<?=($ls_nombre_menu_2)?>">
        </b></font></td>
    </tr>
    <?
}
?>
    <tr> 
      <td
  	onMouseOver="this.style.backgroundColor='<?=($ls_color_over)?>'; this.style.cursor='hand'"
	onMouseOut="this.style.backgroundColor='<?=($ls_color_out)?>';"  
	  ><font size="1"><a href="main_menu.php?ai_perfil=<?=($li_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&as_nombre=<?=($ls_nombre)?>&ai_colegio=<?=($li_colegio_selec)?>" target="Menu" onClick="Abrir()"><strong>VOLVER</strong></a></font></td>
    </tr>
  </table>
</form>
</body>
</html>
<script language="Javascript">
function Abrir()
{
parent.Cuerpo.location.href = "main_bienvenida.php";
parent.Banner.location.href = "main_banner.php?as_nombre_menu=<?=($ls_nombre_menu_blanco)?>&ai_usuario=<?=($li_id_usuario)?>&as_nombre=<?=($ls_nombre)?>";
}

function Enviar(correlativo)
{
var nombre    = eval('document.form1.hf_nombre_'+correlativo+'.value');

parent.Banner.location.href = 'main_banner.php?as_nombre_menu='+nombre+'&ai_usuario=<?=($li_id_usuario)?>&as_nombre=<?=($ls_nombre)?>';
}

</script>

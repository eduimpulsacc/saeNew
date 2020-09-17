<? include"Coneccion/conexion.php"?>
<?
		$li_id_usuario = Trim($_GET["ai_usuario"]);
		$ls_nombre     = Trim($_GET["as_nombre"]);
		$li_id_perfil  = Trim($_GET["ai_perfil"]);
		//Echo("Perfil ($li_id_perfil) <BR>");
		
		// Aqui se ingresa el Colegio que Vienes desde  ColegioElectronico.com
		$li_colegio_selec  = Trim($_GET["ai_colegio"]);
		// ===================================================================
		//echo("instit : $li_colegio_selec");
		
		if($li_id_usuario == 1)
		{
		$li_id_perfil = 0;
		}		
		
		
		// Aqui se Aplica combinacion de Coleres para el Menu
		$ls_color_over = "#FFFFFF";
		//$ls_color_out  = "#FFCC66";
		$ls_color_out  = "#FFFFFF";
		

		if($total_filas_perfil <=0)
		{
		}Else
		{
		$li_id_perfil = Trim(pg_result($resultado_query_perfil, 0, 1));
		}

		$sql= "SELECT C.ID_AREA, C.NOMBRE FROM CON_MODULO A, CON_PERFIL_MODULO B, CON_AREA C WHERE B.ID_PERFIL = $li_id_perfil AND A.ID_MODULO = B.ID_MODULO AND A.ID_AREA = C.ID_AREA GROUP BY C.ID_AREA, C.NOMBRE  ;";
		
		//echo("SQL : $sql <BR>");
		$resultado_query = pg_exec($conexion,$sql);
	    $total_filas     = pg_numrows($resultado_query);
		
		pg_close($conexion);
		
?>
<html>
<head>
<title>Motor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/objeto.css" type="text/css">
<link rel="stylesheet" href="css/main_links.css" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="pagina">
<form name="form1" method="post" action="">
  <table width="118%" border="0" align="center" cellpadding="5" bordercolor="#999966">
    <? For ($j=0; $j < $total_filas; $j++)
{ 
?>
    <tr> 
      <td
  	onMouseOver="this.style.backgroundColor='<?=($ls_color_over)?>'; this.style.cursor='hand'"
	onMouseOut="this.style.backgroundColor='<?=($ls_color_out)?>';" 
	  ><b> <font size="1"><a href="main_menu_interno.php?ai_area=<?=Trim(pg_result($resultado_query, $j, 0));?>&ai_perfil=<?=($li_id_perfil)?>&ai_usuario=<?=($li_id_usuario)?>&as_nombre_user=<?=($ls_nombre)?>&as_nombre_menu=<?=Trim(pg_result($resultado_query, $j, 1))?>&ai_colegio_selec=<?=($li_colegio_selec)?>" target="Menu" onClick="Enviar(<?=($j)?>)"> 
        <?=Trim(pg_result($resultado_query, $j, 1));?>
        </a> 
        <input type="hidden" name="hf_nombre_<?=($j)?>" value="<?=Trim(pg_result($resultado_query, $j, 1))?>">
        </font></b></td>
    </tr>
    <?
}
?>
  </table>
</form>
</body>
</html>
<script language="Javascript">
function Enviar(correlativo)
{
var nombre    = eval('document.form1.hf_nombre_'+correlativo+'.value');
var name_user = <?=($ls_nombre)?>;
var li_user   = <?=($li_id_usuario)?>;

//alert(nombre);
parent.Banner.location.href = 'main_banner.php?as_nombre_menu='+nombre+'&as_nombre='+name_user+'&ai_usuario='+li_user;
}
</script>
<?
$ls_nombre     = Trim($_GET["as_nombre"]);
$li_id_usuario = Trim($_GET["ai_usuario"]);
$ls_nombre_menu = Trim($_GET["as_nombre_menu"]);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/objeto.css" type="text/css">
</head>
<body class="pagina">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr> 
    <td class="linea_datos_01_sr" width="12%"><b>&Uacute;ltima Visita&gt;&gt;</b></td>
    <td class="linea_datos_01_sr" width="88%"><b> 
      <?=($ls_nombre_menu)?>
      </b></td>
  </tr>
</table>
</body>
</html>

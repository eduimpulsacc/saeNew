<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>


</script>
<title>SISTEMA SAE:====> BIBLIOTECA</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="center" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td width="5%" colspan="4"><br />
<br />

            <table width="75%" border="0" cellpadding="3" align="center">
              <tr>
                <td class="titulos-respaldo">LISTADO DE REPORTES</td>
            </tr>
             <tr>
                <td>&nbsp;</td>
            </tr>
            <? //$sql="SELECT * FROM biblio.reportes";
			if($_PERFIL==0){
	  		$sql="SELECT * FROM biblio.reportes ORDER BY id_reporte ASC";
		}else{
  			$sql="SELECT * FROM biblio.reportes r INNER JOIN biblio.perfil_reporte pr 
  				ON r.id_reporte=pr.id_reporte WHERE rdb=".$_INSTIT." AND id_perfil=".$_PERFIL." ORDER BY r.id_reporte ASC";
		}
				$rs_reporte = pg_exec($conn,$sql);
				
				for($i=0;$i<pg_numrows($rs_reporte);$i++){
					$fila = pg_fetch_array($rs_reporte,$i);
					$cont = $i+1;
			?>		
              <tr class="cuadro01">
                <td>&nbsp;<a href="<?=$fila['url'];?>"><? echo $cont.".- ".$fila['nombre'];?></a></td>
            </tr>
            <? } ?>
          </table>    	  
         <br /><br />
<br />
</td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>


</body>

</html>

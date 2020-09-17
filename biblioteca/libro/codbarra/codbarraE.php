<?php

require('../../../util/header.inc');


$query="SELECT * FROM biblio.ejemplares where id_ejemplar=".$_REQUEST['ejemplar'];
$rs = pg_exec($conn,$query);

$fila_alu = pg_fetch_array($rs,0);
?>
 <body onLoad="window.print()">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
</style>


    <table border="0" cellpadding="0" style="border-collapse:collapse" align="left">
  
  <tr>
    <td align="center">
  <img src="http://app.colegiointeractivo.cl/sae3.0/biblioteca/libro/codbarra/barcode.php?text=<?php echo $fila_alu['codigo'] ?>&size=60&print=true" />
    </td>
  </tr>
</table>

</body>
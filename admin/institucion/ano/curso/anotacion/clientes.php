

<?php  

 header("Content-type: application/vnd.ms-excel; name='excel'");  
 header("Content-Disposition: filename=ficheroExcel.xls");  
 header("Pragma: no-cache");  
 header("Expires: 0");  
 echo $_POST['datos_a_enviar'];  

 ?> 



<style type="text/css">
<!--
body,td,th {
	color: #FF0000;
}
body {
	background-color: #000000;
}
-->
</style>

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>

<script language="javascript">  
 $(document).ready(function() {  
      $(".botonExcel").click(function(event) {  
      $("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());  
      $("#FormularioExportacion").submit();  
   });  
 });  
</script> 


<!-- <form action="clientes.php" method="post" target="_blank" id="FormularioExportacion">  
 <p>Exportar a Excel  <img src="export_to_excel.gif" class="botonExcel" /></p>  
 <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />  
 </form> -->

<?
require('../../../../../util/header.inc');

$sql = "SELECT a.rdb,a.dig_rdb,a.nombre_instit, 
        a.telefono,s.direccion,b.num_corp,c.nombre_corp,
        a.estado_colegio
        FROM institucion a
        LEFT OUTER JOIN corp_instit b ON a.rdb=b.rdb 
        LEFT OUTER JOIN corporacion c ON b.num_corp = c.num_corp
        LEFT OUTER JOIN salida s ON s.rdb = a.rdb order by b.num_corp desc";

$result =@pg_Exec($conn,$sql);

echo '<table width="100%" border="1" style="border-collapse:collapse" id="Exportar_a_Excel">

 <tr>
  <th>RBD</th>
  <th>DIG-RBD</th>
  <th>NOMBRE-INSTITUCION</th>
  <th>TELEFONO</th>
  <th>DIRECCION-WEB</th>
  <th>ESTADO</th>
  <th>NUM-CORP</th>
  <th>NOMBRE-CORP</th>
  
 </tr>';

for($i=0 ; $i < @pg_numrows($result) ; $i++){

    $fila = @pg_fetch_array($result,$i);


echo "<tr>
      <td>".$fila['rdb']."</td>
	  <td>".$fila['dig_rdb']."</td>
      <td>".$fila['nombre_instit']."</td>
      <td>".$fila['telefono']."</td>
      <td>".$fila['direccion']."</td>
	  <td>".$fila['estado_colegio']."</td>
      <td>".$fila['num_corp']."</td>
      <td>".$fila['nombre_corp']."</td>
	  </tr>";

    }
   
echo '</table>';

?>

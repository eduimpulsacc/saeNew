<?php 

require('../../../../../../../util/header.inc');

$id_curso=$_REQUEST['id_curso'];
$id_ramo=$_REQUEST['id_ramo']; 
$id_ano=$_REQUEST['id_ano']; 
$num_nota=$_REQUEST['num_nota']; 
$id_periodo=$_REQUEST['id_periodo']; 

$q1 = "SELECT * FROM lexionario as lex 
WHERE lex.id_ano=$id_ano AND lex.id_curso=$id_curso 
AND lex.id_ramo=$id_ramo AND lex.nota=$num_nota and lex.id_periodo=$id_periodo";
$r1 = pg_Exec($conn,$q1) or die ( pg_last_error($conn) );
$n1 = pg_numrows($r1);
if ($n1 > 0){
$fila1 = pg_fetch_array($r1,0);
echo "<table width='100' >";
echo "<tr>";
echo "<td aling='center' >&nbsp;&nbsp;";
echo $fila1['descripcion'];
echo "&nbsp;&nbsp;</td>";
echo "</tr>";
echo "</table>";
}else{
echo "<table width='100' >";
echo "<tr>";
echo "<td aling='center' >&nbsp;&nbsp;";
echo "No Existe Descripci&oacute;n de la Nota";
echo "&nbsp;&nbsp;</td>";
echo "</tr>";
echo "</table>";
}
?>

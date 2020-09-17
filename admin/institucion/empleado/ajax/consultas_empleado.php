
<?	require('../../../clases/OpenConnect.php');

$sql="SELECT * FROM comuna";
$resp=pg_exec($conn,$sql);
$num=pg_numrows($resp);

for($i=0;$i<$num;$i++){
	$fila=pg_fetch_array($resp,$i);
	$cod=$fila['cod_reg'];
	$cod2=$fila['cor_pro'];
	$cod1=$fila['cor_com'];
	$nom=$fila['nom_com'];
echo "<br />}else if(opcionSeleccionada=='".$cod1."' && reg=='".$cod."' && pro=='".$cod2."'){<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;capa.innerHTML='".$nom."';";
}

?>
<table width="56%" border="1">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="70%">&nbsp;</td>
  </tr>
</table>
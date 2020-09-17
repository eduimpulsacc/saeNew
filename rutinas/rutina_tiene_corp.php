<? $conn=@pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

if($flag!=1){
	$desde =5000;
	$hasta =0;
	$cuenta=0;
}

echo "<br>DESDE ".$desde;
echo "<br> HASTA ".$hasta;

echo "<br>".$sql = "SELECT * FROM tiene2007 LIMIT $desde OFFSET $hasta";
$rs_tiene = @pg_exec($conn,$sql);
echo "<br>".pg_numrows($rs_tiene);

for($i=0; $i<pg_numrows($rs_tiene); $i++){
	$fila = pg_fetch_array($rs_tiene,$i);

	
	/*$sql = "SELECT * FROM tiene2007_new WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_curso=".$fila['id_curso'];
	$rs_existe = pg_exec($conn,$sql);
	if(pg_numrows($rs_existe)==0){*/
		$sql = "INSERT INTO tiene2007_new (rut_alumno,id_ramo,id_curso) VALUES(".$fila['rut_alumno'].",".$fila['id_ramo'].",".$fila['id_curso'].")";
		$result = pg_exec($conn,$sql);
	//}

}


$cuenta ++;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../estilo1.css" rel="stylesheet" type="text/css">
</head>

<body>
<input name="indice" type="hidden" value="<? echo $num+1; ?>">
<?
		$desde = $desde + 10000;
		$hasta = $hasta + 10000;
		$sql ="SELECT count(*) FROM tiene2007";
		$rs_total = @pg_exec($conn,$sql);
		$total_filas = pg_result($rs_total,0);
		$porcentaje = round(($desde*100)/$total_filas,2);
		
		$sql ="SELECT count(*) FROM tiene2007_new";
		$rs_total2 = @pg_exec($conn,$sql);
		$total_filas2 = pg_result($rs_total2,0);
		
		echo "<br>HASTA ".$hasta;
		echo "<br> total_ tiene2007 ".$total_filas;
		if($hasta > 1650562){
			echo "FIN DEL PROCESO";
			exit;
		}
		?>
		<table width="700" border="0" class="celdas3" align="center" >
  <tr>
    <td><strong>Proceso de Cierre de Mes </strong></td>
  </tr>
  <tr>
    <td><table width="699" border="0" class="celdas2">
      <tr>
        <td width="689">CANTIDAD REGISTROS TIENE2007: <? echo $total_filas;?> </td>
      </tr>
	  <tr>
        <td width="689">CANTIDAD REGISTROS TIENE2007_NEW: <? echo $total_filas2;?> </td>
      </tr>
      <tr>
        <td><strong>TOTAL DE REGISTROS: <? echo $porcentaje; ?> %</strong>
          </td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='rutina_tiene_corp.php?desde=<?=$desde;?>&hasta=<?=$hasta;?>&flag=1&cuenta=<?=$cuenta;?>'");</script>
</body>
</html>







<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

if($flag!=1){
	$desde =1149000;
	$hasta =1144000;
	$cuenta=0;
}

echo "<br>DESDE ".$desde;
echo "<br> HASTA ".$hasta;

echo "<br>".$sql = "SELECT * FROM notas2006 LIMIT $desde OFFSET $hasta";
$rs_tiene = @pg_exec($conn,$sql);
echo "<br>".pg_numrows($rs_tiene);

for($i=0; $i<pg_numrows($rs_tiene); $i++){
	$fila = pg_fetch_array($rs_tiene,$i);

	
	$sql = "SELECT * FROM notas2006_new WHERE rut_alumno=".$fila['rut_alumno']." AND id_ramo=".$fila['id_ramo']." AND id_periodo=".$fila['id_periodo'];
	$rs_existe = pg_exec($conn,$sql);
	if(pg_numrows($rs_existe)==0){
		$sql = "INSERT INTO notas2006_new (rut_alumno, id_ramo, id_periodo, nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14, nota15, nota16,nota17,nota18,nota19,nota20,promedio) VALUES (".$fila['rut_alumno'].",".$fila['id_ramo'].",".$fila['id_periodo'].",'".$fila['nota1']."','".$fila['nota2']."','".$fila['nota3']."','".$fila['nota4']."','".$fila['nota5']."','".$fila['nota6']."','".$fila['nota7']."','".$fila['nota8']."','".$fila['nota9']."','".$fila['nota10']."','".$fila['nota11']."','".$fila['nota12']."','".$fila['nota13']."','".$fila['nota14']."','".$fila['nota15']."','".$fila['nota16']."','".$fila['nota17']."','".$fila['nota18']."','".$fila['nota19']."','".$fila['nota20']."','".$fila['promedio']."')";
		$result = pg_exec($conn,$sql);
	}

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
		$sql ="SELECT count(*) FROM notas2006";
		$rs_total = @pg_exec($conn,$sql);
		$total_filas = pg_result($rs_total,0);
		$porcentaje = round(($desde*100)/$total_filas,2);
		
		$sql ="SELECT count(*) FROM notas2006_new";
		$rs_total2 = @pg_exec($conn,$sql);
		$total_filas2 = pg_result($rs_total2,0);
		
		echo "<br>HASTA ".$hasta;
		echo "<br> total_ notas2006 ".$total_filas;
		if($hasta > 1500000){
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
        <td width="689">CANTIDAD REGISTROS NOTAS2006: <? echo $total_filas;?> </td>
      </tr>
	  <tr>
        <td width="689">CANTIDAD REGISTROS NOTAS2006_NEW: <? echo $total_filas2;?> </td>
      </tr>
      <tr>
        <td><strong>TOTAL DE REGISTROS: <? echo $porcentaje; ?> %</strong>
          </td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='rutina_notas.php?desde=<?=$desde;?>&hasta=<?=$hasta;?>&flag=1&cuenta=<?=$cuenta;?>'");</script>
</body>
</html>







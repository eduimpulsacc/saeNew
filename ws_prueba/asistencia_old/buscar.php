<?php 
$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	

echo $srdb = "select ins.rdb,ins.nombre_instit from institucion ins inner join corp_instit on corp_instit.rdb=ins.rdb where num_corp=38";
$rrdb=pg_exec($conn2,$srdb);
?>
<form action="ws.php" method="post">
<select name="rdb">
<?php for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    <option value="<?php echo $ff['rdb'] ?>"><?php echo $ff['nombre_instit'] ?></option>
<?php }?>
</select><br>
<select name="ano">
<option value="2016">2016</option>
<option value="2017">2017</option>
</select><br>
<select name="mes">
<option value="01">Enero</option>
<option value="02">Febrero</option>
<option value="03">Marzo</option>
<option value="04">Abril</option>
<option value="05">Mayo</option>
<option value="06">Junio</option>
<option value="07">Julio</option>
<option value="08">Agosto</option>
<option value="09">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>

</select><br>
<input type="submit" value="enviar">

</form>
<?php 
//base de datos coifinal
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//if($conn2)echo "conecte viña"; 
 
//exit;
$nro_ano=2016
?>
<?php 
$sql2="select ins.nombre_instit,an.id_ano
from institucion ins
inner join evados.eva_ano_escolar an on an.id_institucion = ins.rdb
inner join evados.eva_periodos_evaluacion pe on pe.id_anio = an.id_ano
where nro_ano=$nro_ano 
order by ins.rdb";
$rs2=pg_exec($conn2,$sql2);

?>
<script type="text/javascript">
			function submitform()
			{
				if(document.getElementById("nano").value!=0 && document.getElementById("bloque").value!=0 ){
			  document.myform.submit();
				}
			}
			submitform();
			</script>
            <form name="myform" action="informe.php" target="_blank" method="post">
<select name="nano" id="nano" >
<option value="0">seleccione</option>
<?php for($v=0;$v<pg_numrows($rs2);$v++){
	$rd=pg_fetch_array($rs2,$v);
	?>
    <option value="<?php echo $rd['id_ano'] ?>"><?php echo $rd['nombre_instit'] ?></option>
<?php }?>
</select>
<br />
<br />
<select name="bloque" id="bloque" onChange="submitform()">
<option value="0">seleccione</option>
<option value="32">Director</option>
<option value="34">Inspector General</option>
<option value="29">Jefe UTP</option>
<option value="19">Orientador</option>
<option value="33">Capell&aacute;n</option>
<option value="37">Profesor Jefe</option>
<option value="31">Docente</option>

</select>
 </form>
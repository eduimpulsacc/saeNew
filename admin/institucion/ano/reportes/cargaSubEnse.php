<?php 
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');
$ob_motor = new MotorBusqueda();

 $sql="select distinct(ramo.cod_subsector),nombre  from ramo
inner join curso
on ramo.id_curso = curso.id_curso
inner join subsector
on ramo.cod_subsector = subsector.cod_subsector
and curso.ensenanza = ".$_POST['tipo']." 
and curso.id_ano = ".$_POST['ano']." and ramo.modo_eval=1
order by nombre";
		$res_reg = pg_exec($conn, $sql);
		
if(pg_numrows($res_reg)>0){
?>
<select name="cmbramo" id="cmbramo">
<option value="0">Seleccione</option>
<?php for($i=0;$i<pg_numrows($res_reg);$i++){
	$fil_ramo = pg_fetch_array($res_reg,$i);
	?>
<option value="<?php echo $fil_ramo['cod_subsector'] ?>"><?php echo $fil_ramo['nombre'] ?></option>
<?php }?>
</select>
<?php }?>

<?php 
//carga tipos de enseñanza
if($_POST['carga'] ==1){
$sql = "select distinct(tipo_ensenanza.cod_tipo), tipo_ensenanza.nombre_tipo
from curso
inner join ano_escolar
on curso.id_ano = ano_escolar.id_ano
inner join tipo_ensenanza
on curso.ensenanza = tipo_ensenanza.cod_tipo
where 
ano_escolar.id_institucion = ".$_POST['rdb']."
and ano_escolar.id_ano between ".$_POST['anodesde']." and  ".$_POST['anohasta']."
--and curso.ensenanza >10
 ORDER BY tipo_ensenanza.cod_tipo";
		$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
//EnsenanzaAnos
if(pg_numrows($result)>0){
?>
<select name="cmbENS" id="cmbENS" onchange="cargaRamos();" >
<option value=0 selected>Seleccione Tipo de Ense&ntilde;anza</option>
<?php for($i=0;$i<pg_numrows($result);$i++){
	$fil_ense = pg_fetch_array($result,$i);
	?>
<option value="<?php echo $fil_ense['cod_tipo'] ?>"><?php echo $fil_ense['cod_tipo'] ?> - <?php echo $fil_ense['nombre_tipo'] ?></option>
<?php }?>

</select>

<?php	
	
}


}

//carga tipos de enseñanza
if($_POST['carga'] ==2 && $_POST['tipo'] != 0){
	
 $sql ="select distinct(ramo.cod_subsector),nombre 
from ramo
inner join curso
on ramo.id_curso = curso.id_curso
inner join ano_escolar
on curso.id_ano = ano_escolar.id_ano
inner join subsector
on ramo.cod_subsector = subsector.cod_subsector
where ano_escolar.id_institucion = ".$_POST['rdb']."
and ano_escolar.id_ano between ".$_POST['anodesde']." and  ".$_POST['anohasta']."
and curso.ensenanza = ".$_POST['tipo']." 
and curso.ensenanza >10
and ramo.modo_eval = 1
";
$result =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
if(pg_numrows($result)>0){
?>
<select name="cmbramo" id="cmbramo">
<option value=0 selected>Seleccione Asignatura</option>
<?php for($i=0;$i<pg_numrows($result);$i++){
	$fil_ramo= pg_fetch_array($result,$i);
	?>
  <option value="<?php echo $fil_ramo['cod_subsector'] ?>"><?php echo $fil_ramo['nombre'] ?></option>
    <?php }?>
</select>
<?php }
}

?>
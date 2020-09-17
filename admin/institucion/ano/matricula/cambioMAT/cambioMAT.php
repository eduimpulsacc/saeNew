<?php 
require('../../../../../util/header.inc');
if($funcion==1){
$query ="select nro_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano=$ano";
$rs=pg_exec($conn,$query);
$nano = pg_result($rs,0);
$fecha_inicio =pg_result($rs,1);
$fi = explode("-",$fecha_inicio); 
$fecha_termino =pg_result($rs,2);
$ft = explode("-",$fecha_termino); 	
?>
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	
	
</style>
<script>

$( document ).ready(function() {
   $("#selfecha").datepicker({
	firstDay: 1,
	changeMonth: true,
	minDate: new Date('<?php echo $fi[0] ?>/01/01'),
	maxDate: new Date('<?php echo $ft[0] ?>/<?php echo $ft[1] ?>/<?php echo $ft[2] ?>'),
	defaultDate: new Date(<?php echo date("d") ?>,<?php echo date("m")-1 ?>, <?php echo $fi[0] ?>),
	dateFormat: 'dd/mm/yy',
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic']
	});
	
});
</script>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td colspan="2">Seleccione fecha de matr&iacute;cula para actualizaci&oacute;n</td>
  </tr>
  <tr class="cuadro01">
    <td width="33%">Fecha</td>
    <td width="67%"><input type="text" name="selfecha" id="selfecha" readonly value="<?php echo date("d/m/$nano"); ?>"></td>
  </tr>
</table>

<?
}
if($funcion==2){
$fecha = CambioFE($_POST['fmay']);
$sql="update matricula set fecha='$fecha' where id_ano=$ano";
$rs=pg_exec($conn,$sql);
echo($rs)?1:0;
}
if($funcion==3){
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td>&nbsp;&nbsp;Tipo de orden </td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;&nbsp;<select name="selOrden" id="selOrden">
      <option value="0">Seleccione</option>
      <option value="1">Apellido</option>
      <option value="2">Tipo de Ense&ntilde;anza</option>
      <option value="3">Correlativo</option>
    &nbsp;</select></td>
  </tr>
</table>
<?
}
if($funcion==4){
$orden=$_POST['ord'];
$id_ano=$_POST['ano'];
if($orden==1){ 
//solo ordenar por apellido y fecha de matricula
$ord = " m.fecha,a,a.ape_mat,a.nombre_alu"; 
$and = "";

$sql="select case 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Á') THEN REPLACE(upper(a.ape_pat),'Á','A') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='É') THEN REPLACE(upper(a.ape_pat),'É','E') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Í') THEN REPLACE(upper(a.ape_pat),'Í','I') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ó') THEN REPLACE(upper(a.ape_pat),'Ó','O') 
WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ú') THEN REPLACE(upper(a.ape_pat),'Ú','U') 
ELSE upper(a.ape_pat) END AS paterno,
a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu 
from matricula m 
inner join curso c on c.id_curso = m.id_curso 
inner join alumno a on a.rut_alumno = m.rut_alumno 
where m.id_ano = $id_ano $and 
order by $ord ";

echo "<br>";
$rs = pg_exec($conn,$sql);
//$mat=0;
for($i=0;$i<pg_numrows($rs);$i++){
	$fila = pg_fetch_array($rs,$i);
	//echo $fila['paterno'];
	
	$squ = "update matricula set num_mat = ".($i+1)." where rut_alumno = ".$fila['rut_alumno']." AND id_curso=".$fila['id_curso']."  and id_ano=$id_ano";
	//echo $squ."<br>";
	$rsu = pg_exec($conn,$squ);
	$mat++;
}



}
if($orden==2){
	// resetar por numero de enseñanza, da lo mismo la fecha
	//ver tipos de ensenaza colegio
	$sql_ense="select DISTINCT(ensenanza) as ense from curso where id_curso in
	(select id_curso from matricula where id_ano = $id_ano)
	order by 1 asc";
	$rs_ense = pg_exec($conn,$sql_ense);
	$cade="";
	for($e=0;$e<pg_numrows($rs_ense);$e++){
	$filae=pg_fetch_array($rs_ense,$e);
	$ense=$filae['ense'];
	
	//$ense=substr($cade,0,-1);
	
	$and="and c.ensenanza =$ense";
	$ord = " c.grado_curso,c.letra_curso,paterno,a.ape_mat,a.nombre_alu";
	
	
	$sql="select case 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Á') THEN REPLACE(upper(a.ape_pat),'Á','A') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='É') THEN REPLACE(upper(a.ape_pat),'É','E') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Í') THEN REPLACE(upper(a.ape_pat),'Í','I') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ó') THEN REPLACE(upper(a.ape_pat),'Ó','O') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ú') THEN REPLACE(upper(a.ape_pat),'Ú','U') 
	ELSE upper(a.ape_pat) END AS paterno,
	a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu 
	from matricula m 
	inner join curso c on c.id_curso = m.id_curso 
	inner join alumno a on a.rut_alumno = m.rut_alumno 
	where m.id_ano = $id_ano $and 
	order by $ord ";
	
	
	$rs = pg_exec($conn,$sql);
	//$mat=0;
	for($i=0;$i<pg_numrows($rs);$i++){
		$fila = pg_fetch_array($rs,$i);
		//echo $fila['paterno'];
		
		$squ = "update matricula set num_mat = ".($i+1)." where rut_alumno = ".$fila['rut_alumno']." AND id_curso=".$fila['id_curso']."  and id_ano=$id_ano";
		//echo $squ."<br>";
		$rsu = pg_exec($conn,$squ);
		$mat++;
	}
}

	
}
//correlativo
if($orden==3){
	$and="";
	$ord = " c.ensenanza,c.grado_curso,c.letra_curso,paterno,a.ape_mat,a.nombre_alu";
	
	
	$sql="select case 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Á') THEN REPLACE(upper(a.ape_pat),'Á','A') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='É') THEN REPLACE(upper(a.ape_pat),'É','E') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Í') THEN REPLACE(upper(a.ape_pat),'Í','I') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ó') THEN REPLACE(upper(a.ape_pat),'Ó','O') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ú') THEN REPLACE(upper(a.ape_pat),'Ú','U') 
	ELSE upper(a.ape_pat) END AS paterno,
	a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu 
	from matricula m 
	inner join curso c on c.id_curso = m.id_curso 
	inner join alumno a on a.rut_alumno = m.rut_alumno 
	where m.id_ano = $id_ano $and 
	order by $ord ";
	$rs = pg_exec($conn,$sql);
	//$mat=0;
	for($i=0;$i<pg_numrows($rs);$i++){
		$fila = pg_fetch_array($rs,$i);
		//echo $fila['paterno'];
		
		$squ = "update matricula set num_mat = ".($i+1)." where rut_alumno = ".$fila['rut_alumno']." AND id_curso=".$fila['id_curso']."  and id_ano=$id_ano";
		//echo $squ."<br>";
		$rsu = pg_exec($conn,$squ);
		$mat++;
	}
}
}
if($funcion==5){
//cursos
$sql_cur = "select id_curso from curso where id_ano=$ano";
$rs_cur = pg_exec($conn,$sql_cur);
for($c=0;$c<pg_numrows($rs_cur);$c++){
$fila_curso = pg_fetch_array($rs_cur,$c);
$id_curso = $fila_curso['id_curso'];

 $sql_alu="select case 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Á') THEN REPLACE(upper(a.ape_pat),'Á','A') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='É') THEN REPLACE(upper(a.ape_pat),'É','E') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Í') THEN REPLACE(upper(a.ape_pat),'Í','I') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ó') THEN REPLACE(upper(a.ape_pat),'Ó','O') 
	WHEN (SUBSTRING(upper(a.ape_pat),1,1)='Ú') THEN REPLACE(upper(a.ape_pat),'Ú','U') 
	ELSE upper(a.ape_pat) END AS paterno,
	a.rut_alumno,m.id_curso,m.fecha, a.ape_pat,a.ape_mat,a.nombre_alu 
	from matricula m 
	inner join curso c on c.id_curso = m.id_curso 
	inner join alumno a on a.rut_alumno = m.rut_alumno 
	where m.id_curso = $id_curso
	order by 1,3,4 ";
	
	$rs_alu = pg_exec($conn,$sql_alu);
	for($al=0;$al<pg_numrows($rs_alu);$al++){
		$f_alu = pg_fetch_array($rs_alu,$al);
		//poner numero lista
		echo "<br>".$sql_num = "update matricula set nro_lista=".($al+1).",numero_reporte=".($al+1)." where rut_alumno=".$f_alu['rut_alumno']." and id_curso=".$id_curso;
		$rs_num = pg_exec($conn,$sql_num);
	}


}

}
if($funcion==6){
	//primero la nacionalidad
 $sql_nac = "select apo.rut_apo from apoderado apo
 where apo.rut_apo in(
 select rut_apo from tiene2 where rut_alumno in(
 select rut_alumno from matricula where id_ano = $ano)
 ) and (nacionalidad =0 or nacionalidad is null)
 order by apo.nacionalidad";
 $rs_nac = pg_exec($conn,$sql_nac);
 
 for($n=0;$n<pg_numrows($rs_nac);$n++){
	 $fn = pg_fetch_array($rs_nac,$n);
	 $sql_up = "update apoderado set nacionalidad = 2, pais_origen=46 where rut_apo=".$fn['rut_apo'];
	pg_exec($conn,$sql_up);
	}
	


//comuna
$selcol = "select region,ciudad,comuna from institucion where rdb in(select id_institucion from ano_escolar where id_ano= $ano)";
$rscol = pg_exec($conn,$selcol);
$region = pg_result($rscol,0);
$ciudad = pg_result($rscol,1);
$comuna = pg_result($rscol,2);


$sql_com = " select apo.rut_apo,apo.comuna
 from apoderado apo
 where apo.rut_apo in(
 select rut_apo from tiene2 where rut_alumno in(
 select rut_alumno from matricula 
where id_ano = $ano and bool_ar=0 )
 ) and (apo.comuna=0 or apo.comuna is null )
 order by apo.comuna";
$rs_col = pg_exec($conn,$sql_com);

for($c=0;$c<pg_numrows($rs_col);$c++){
	 $fc = pg_fetch_array($rs_col,$c);
	 $sql_uc = "update apoderado set region=$region,ciudad=$ciudad,comuna=$comuna where rut_apo=".$fc['rut_apo'];
	pg_exec($conn,$sql_uc);
	}
	
	
echo 1;
}
if($funcion==7){
$query ="select nro_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano=$ano";
$rs=pg_exec($conn,$query);
$nano = pg_result($rs,0);
$fecha_inicio =pg_result($rs,1);
$fi = explode("-",$fecha_inicio); 
$fecha_termino =pg_result($rs,2);
$ft = explode("-",$fecha_termino); 

$sql_cur = "select id_curso from curso where id_ano =$ano order by ensenanza,grado_curso,letra_curso";
$rs_cur = pg_exec($conn,$sql_cur);
?>
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	
	
</style>
<script>

$( document ).ready(function() {
   $("#finicio,#ffin").datepicker({
	firstDay: 1,
	changeMonth: true,
	minDate: new Date('<?php echo $fi[0] ?>/01/01'),
	maxDate: new Date('<?php echo $ft[0] ?>/<?php echo $ft[1] ?>/<?php echo $ft[2] ?>'),
	defaultDate: new Date(<?php echo date("d") ?>,<?php echo date("m")-1 ?>, <?php echo $fi[0] ?>),
	dateFormat: 'dd/mm/yy',
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	dayNamesMin: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ]
	});
	
	
	 $('#sela:checkbox').toggle(function(){
        $('.curso').attr('checked','checked');
       
    },function(){
          $('.curso').removeAttr('checked');
             
    })
	
});
</script>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td colspan="2">&nbsp;Seleccione fecha de matr&iacute;cula para actualizaci&oacute;n</td>
  </tr>
  <tr class="cuadro01">
    <td width="33%">&nbsp;Fecha inicio</td>
    <td width="67%"><input type="text" name="finicio" id="finicio" readonly value="<?php echo CambioFD($fecha_inicio) ?>"></td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;Fecha t&eacute;rmino</td>
    <td><input type="text" name="ffin" id="ffin" readonly="readonly" value="<?php echo CambioFD($fecha_termino) ?>" /></td>
  </tr>
  <tr class="cuadro01">
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr class="cuadro02">
    <td colspan="2">&nbsp;Cursos que aplica</td>
  </tr>
  <tr class="cuadro02">
    <td colspan="2">&nbsp;<input name="sela" type="checkbox" id="sela"/>TODOS</td>
  </tr>
 <?php  for($c=0;$c<pg_numrows($rs_cur);$c++){
	 $rc= pg_fetch_array($rs_cur,$c);
	 ?>
  <tr class="cuadro01">
    <td colspan="2">&nbsp;<input type="checkbox" name="curso[]" class="curso" id="curso<?php echo $rc['id_curso'] ?>"   value="<?php echo $rc['id_curso'] ?>" /> <?php echo CursoPalabra($rc['id_curso'],1,$conn); ?>
   </td>
  </tr>
  <?php }?>
</table>
<?	
	}
if($funcion==8){
$fi=CambioFE($fecha_inicio);
$ft=CambioFE($fecha_fin);
 $sqL="update curso set fecha_inicio='$fi', fecha_termino='$ft' where id_curso in($cursos)";
pg_exec($conn,$sqL);
echo 1;
}
?>
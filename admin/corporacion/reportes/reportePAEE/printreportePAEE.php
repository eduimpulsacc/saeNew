<?php require('../../../../util/header.inc');?>
<?php 
	
	$institucion	=$_INSTIT;
	$_POSP = 3;
	
	$menu = $_GET['menus'];
	
	if ($menu == ''){
	
	$menu =0 ;
	
	}
	
   $_MDINAMICO = 1;	
   
  foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

//cmb_curso
$cad=($cmb_curso>0)?" and c.id_curso = $cmb_curso":"";

$ord=($cmb_curso>0)?" nro_lista":"ensenanza,grado_curso,letra_curso";

$sql_al="select al.rut_alumno as codigo, upper(al.ape_pat||' '||al.ape_mat||' '||al.nombre_alu) as nombre from alumno al
inner join matricula m on m.rut_alumno = al.rut_alumno
inner join curso c on c.id_curso = m.id_curso
 where m.id_ano=$i_ano $cad order by $ord";
   $rs_al = pg_exec($conn,$sql_al);
   ?>
   
<?php   
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=PAEE.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);?>
<table>
<tr>
  <td>CODIGO</td><td>NOMBRE</td></tr>
 <?php  for($a=0;$a<pg_numrows($rs_al);$a++){
	 $fila_al = pg_fetch_array($rs_al,$a);
	 ?>
<tr><td><?php echo  $fila_al['codigo'] ?></td><td><?php echo  $fila_al['nombre'] ?></td></tr>
<?php }?>
</table>

<? session_start();
require("../../util/header.php");
 require("mod_ano.php");
 
 $funcion=$_POST['funcion'];
$obj_ano = new Ano();

if($funcion==1){
//var_dump($_POST);
$rs_anos = $obj_ano->traeAnos($conn,$_INSTIT);
$parte = $obj_ano->anoParte($conn,$_INSTIT);

if(pg_numrows($parte)==0){
$ultimo =  $obj_ano->anoUltimo($conn,$_INSTIT);
$_ANO = pg_result($ultimo,0);

}else{
$_ANO = pg_result($parte,0);
}

//$_ANO = 

$obj_ano->ActualizaRegistro($conn,$_ANO);

?><br>
<br>
<center>
<table border="0" class="tablaredonda" width="85%">
<tr class="tableindex">
  <td colspan="4"  class=" cuadro02 tablaredonda">A&ntilde;os Instituci&oacute;n</td>
  </tr>
<tr class="cuadro02 tablaredonda">
  <td  class="tablaredonda">Nro. A&ntilde;o</td>
  <td  class="tablaredonda">Fecha Inicio </td>
  <td  class="tablaredonda">Fecha T&eacute;rmino</td>
  <td  class="tablaredonda">Estado</td>
</tr>
<?php for($a=0;$a<pg_numrows($rs_anos);$a++){
	$fila=pg_fetch_array($rs_anos,$a);
	
	if(($a % 2)==0){
		$estilo = "detalleoff";	
	}else{
		$estilo = "detalleon";
	}
	?>
<tr onClick="seteaAno(<?php echo $fila['id_ano'] ?>,<?php echo $fila['nro_ano'] ?>)" style="cursor:pointer" onmouseover="this.style.background='gray';" onMouseOut="this.style.background='white';" class="textosimple">
  <td class="<?=$estilo;?>"><?php echo $fila['nro_ano'] ?></td>
  <td class="<?=$estilo;?>"><?php echo CambioFD($fila['fecha_inicio']) ?></td>
  <td class="<?=$estilo;?>"><?php echo CambioFD($fila['fecha_termino']) ?></td>
  <td class="<?=$estilo;?>" align="center"><img src="../img/PNG-48/<?php echo ($fila['id_ano']!=$_ANO)?"Delete":"Add" ?>.png" width="24" height="24" title="A&ntilde;o <?php echo ($fila['id_ano']!=$_ANO)?"Cerrado":"Abierto" ?>"></td>
</tr>
<?php }?>
</table>
</center><br>
<br>

<?
}
if($funcion==2){
$_ANO=$ano;
session_unregister('_ANO');
session_register('_ANO');

$_NANO=$nro_ano;
session_unregister('_NANO');
session_register('_NANO');
}
?>
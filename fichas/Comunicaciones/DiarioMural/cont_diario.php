<?php 
require('../../../util/header.inc');
require('mod_diario.php');

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =3;
	
	$ob_diario = new Diario();
	
	if($funcion==1){
		$rs_listado = $ob_diario->Listado($conn,$ano);
	?>
    <table width="85%" border="0" align="center"> 
      <tr>
        <td class="datagrid table thead th">&nbsp;LISTADO DIARIO MURAL</td>
      </tr>
    </table>

	<table width="85%" border="0" align="center">
    <? for($i=0;$i<pg_numrows($rs_listado);$i++){
			$fila = pg_fetch_array($rs_listado,$i);
	?>
      <tr>
        <td rowspan="2" onmouseover=this.style.background='#009FE3';this.style.cursor='hand' onmouseout=this.style.background='transparent'>&nbsp;<img src=../../diario/images/<?php echo $fila['nom_foto'] ?> ALT="FOTO DIARIO MURAL"  width=200></td>
        <td class="textonegrita" onmouseover=this.style.background='#009FE3';this.style.cursor='hand' onmouseout=this.style.background='transparent'>&nbsp;<? echo strtoupper($fila['titulo']);?></td>
      </tr>
      <tr>
        <td class="textosimple" onmouseover=this.style.background='#009FE3';this.style.cursor='hand' onmouseout=this.style.background='transparent'>&nbsp;<? echo $fila['detalle'];?></td>
      </tr>
     <? } ?>
    </table>
<?	
	}
	
?>
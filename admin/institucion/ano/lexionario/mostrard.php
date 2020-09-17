<?
require('../../../../util/header.inc');

$cmb_curso = $_REQUEST[id_curso];
$id_ramo  = $_REQUEST[id_ramo];
$nro_ano  = $_REQUEST[id_ano];
$nombre = $_REQUEST[txt_tipo];

$sql= "select id_ramo, ramo.cod_subsector, subsector.nombre
from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
where id_ramo=".$id_ramo;
$rs_lexionario= pg_Exec($conn,$sql);
$nombre_ramo = @pg_result($rs_lexionario,2);

  $Curso_pal = CursoPalabra($cmb_curso, 1, $conn);   
?>


<table width="100%" align="center">				 
	  <td align="middle" colspan="6" class="tableindex">Tipo Lexionario </td>
	</tr></table>
<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center class="textonegrita" >

<tr><td height="28" align='left'>Curso:</td>
	<td height="28" align='left'><?=$Curso_pal;?></td>
	
	
	
</tr>

<tr>
	<td height="28" align=left>Ramo:<?=$fila['id_ramo'];?></td>
	<td height="28" align=left><?=$nombre_ramo;?></td>
	
</tr>
<br>
<tr>
	<td width="15%" align=left>Nombre Tipo:&nbsp;&nbsp;</td>
	<td><textarea name='txt_tipo'  id='txt_tipo' cols='30' rows='2'></textarea></td>
	
	
</tr>

</tr>
	<tr height=20 class="">
	<td colspan=2>  </TD>
</tr>


<td align="center"><input class='botonXX'  TYPE='button' name="guardatipo" value='Guarda Tipo' onClick='validatipo()'></td>


<td><input class='botonXX'  TYPE='button' name="cerar" value='CERRAR' onClick='cerrar()'></td>

<TR>
<TD colspan=4>

	</TD>
</TR>


</TABLE><br><br>

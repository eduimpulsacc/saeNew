<?

require('../../../../util/header.inc');




$cmb_curso = $_REQUEST[id_curso];
$nro_ano  = $_REQUEST[id_ano];
$id_ramo  = $_REQUEST[id_ramo];

$sql= "select *
from lexionario 
where id_ano = $nro_ano and id_curso = $cmb_curso and id_ramo= $id_ramo";
$rs_lexionario= pg_Exec($conn,$sql);

$TR="";

$TR .='<table width="100%"  id="listalexionario" class="textosimple" align="center">
	<tr height="20"> 
	  <td align="middle" colspan="5" class="tableindex">Lexionario</td>
	</tr>
	<tr > 
	  <td align="center" class="tablatit2-1"> 
	  FECHA </td>
	  <td align="center" class="tablatit2-1"> 
		DESCRIPCION </td>
	  <td align="center" class="tablatit2-1"> 
		TIPO</td>
	  <td align="center" class="tablatit2-1"> 
		CASILLERO </td>
		<td ALIGN=CENTER class="tablatit2-1">&nbsp;</td>
	</tr>';

for($i=0;$i<pg_numrows($rs_lexionario);$i++){
			
$fil=pg_fetch_array($rs_lexionario,$i); 

//$fil[id_lexionario]

$TR .= "
<tr bgcolor='#ffffff' onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' >

<td align='center' onclick='pruebalex(".$fil["id_lexionario"].")'>".$fil['fecha']."</td>

<td align='center' onclick='pruebalex(".$fil["id_lexionario"].")'>".$fil['descripcion']."</td>

<td align='center'onclick='pruebalex(".$fil["id_lexionario"].")'>".$fil['tipo']."</td>

<td align='center'onclick='pruebalex(".$fil["id_lexionario"].")'>".$fil['nota']."</td>
 
<td  align='center'
onClick='elimina_lexionario(".$fil['id_lexionario'].")'>	  
<img src='../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Delete.png' width='18' height='18' border='0' />
</td>

</tr>";
 
 }

$TR .= "</table>";
 
echo $TR;


?>
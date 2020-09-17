
<?
require('../../../util/header.inc');
require('mod_escala.php');

$ob_grupo = new Escala();


foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

if($funcion==1){
$nmin = $nmin/10;
$nmax = $nmax/10;
$napr = $napr/10;
$exig = $exig/100;
$cuenta = $ob_grupo->getEscala($conn,$_INSTIT);
if(pg_numrows($cuenta)==0){
//crear escala

$rs_crear = $ob_grupo->creaEscala($conn,$_INSTIT,$nmin,$nmax,$napr,$exig);
}else{
//actualizar escala
$rs_crear =$ob_grupo->updEscala($conn,$_INSTIT,$nmin,$nmax,$napr,$exig);
}

echo($rs_crear)?1:0;

}
if($funcion==2){
	$rs_esc = $ob_grupo->getEscala($conn,$_INSTIT);
	$fila_esc = pg_fetch_array($rs_esc,0);?>
	<table width="500" border="0"  cellpadding="0" cellspacing="5">
                                        <tr>
                                          <td colspan="4"><p><strong>Escala de notas actual</strong></p></td>
                                        </tr>
                                        <tr class="tableindex">
                                          <td align="center">Nota m&iacute;nima</td>
                                          <td align="center">Nota m&aacute;xima</td>
                                          <td align="center">Nota aprobaci&oacute;n</td>
                                          <td align="center">% Exigencia</td>
                                        </tr>
                                        <tr class="textosimple">
                                          <td align="center" ><?php echo round($fila_esc['nmin'],1)*10 ?></td>
                                          <td align="center"><?php echo round($fila_esc['nmax'],1)*10 ?></td>
                                          <td align="center"><?php echo round($fila_esc['napr'],1)*10 ?></td>
                                          <td align="center"><?php echo $fila_esc['exig']*100 ?></td>
                                        </tr>
                                      </table>
                                      <?
}

?>
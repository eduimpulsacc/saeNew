<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
include_once("mod_validar.php");
$funcion=$_POST['funcion'];

if($funcion==1){
$eCertificado = buscaCertificado($connection,$codigo);
if(pg_numrows($eCertificado)==0){
?>
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><h3 class="top-1 p0">CERTIFICADO NO V&Aacute;LIDO</h3></td>
  </tr>
  <tr>
    <td align="center"><br />      <img src="../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Delete.png" width="48" height="48" /><br /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="btn_volver" class="button" value="Cerrar" onclick="window.close()" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?
}else{
$fila = pg_fetch_array($eCertificado,0);
$rut = $fila['rut_alumno'];
$rbd = $fila['rbd'];
$id_ano = $fila['id_ano'];
$id_base  = $fila['id_base'];
$id_curso = $fila['id_curso'];
$tipo_certificado = $fila['tipo_certificado'];
$fecha_emision = $fila['fecha_emision'];
$hora_emision = $fila['hora_emision'];

$rs_alumno = datoAlumno($id_base,$rut,$id_ano,$id_curso);
$fila_alumno = pg_fetch_array($rs_alumno,0);

$rs_certo = infoCertificado($id_base,$tipo_certificado);


?>
<br>
<table width="647" height="309"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="5"><h3 class="top-1 p0"><div align="center">CERTIFICADO V&Aacute;LIDO</div></h3></td>
  </tr>
  <tr>
    <td width="133" rowspan="12" align="center" valign="top"><br />      <img src="../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Accept-icon.png" width="49" height="48" /></td>
    <td align="left" valign="middle"><strong>C&oacute;digo </strong></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><?php echo $codigo ?></td>
  </tr>
  <tr>
    <td width="122" align="left" valign="middle"><strong><span style="width:150px;"> Nombre Alumno </span></strong></td>
    <td width="13" align="left" valign="middle">&nbsp;</td>
    <td width="379" align="left" valign="middle"><?php echo $fila_alumno['nombre'] ?></td>
    
  </tr>
  
  
  <tr>
    <td align="left" valign="middle"><strong>Curso</strong></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><?php echo $fila_alumno['dcurso'] ?></td>
  </tr>
  
  <tr>
    <td align="left" valign="middle"><strong><span id="lbl_etiqueta_fecha">Fecha de Emisi&oacute;n</span></strong></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><?php echo CambioFD($fecha_emision)/*." ".$hora_emision*/ ?></td>
  </tr>
 
  <tr>
    <td align="left" valign="middle"><strong> Instituci&oacute;n </strong></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><span style="width:500px;"><?php echo $fila_alumno['colegio'] ?></span></td>
  </tr>
 
  <tr>
    <td align="left" valign="middle"><strong>Certificado</strong></td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle"><?php echo pg_result($rs_certo,0); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left"><p>
      <input type="submit" name="btn_volver2" class="button" value="Cerrar" onclick="window.close()" />
    </p>
    <p>&nbsp; </p></td>
  </tr>
 
</table>


<?
}

}

?>
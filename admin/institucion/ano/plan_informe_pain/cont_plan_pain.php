<?php 
require('../../../../util/header.inc');
session_start();
require "mod_plan_pain.php";
$ob_pei = new PlanPain();

$funcion = $_POST['funcion'];
$institucion = $_SESSION['_INSTIT'];
$ano = $_SESSION['_ANO'];
if($funcion==1){
$rs_cur=$ob_pei->listacurso($conn,$ano);
	?>
    <table width="650" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>LISTA DE CURSOS</td>
    </tr>
    <?php for($c=0;$c<pg_numrows($rs_cur);$c++){
		$fila_c=pg_fetch_array($rs_cur,$c);?>
  <tr onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='transparent'" onclick="plan(<?php echo $fila_c['id_curso']?>)">
    <td><b><font face="arial, geneva, helvetica" size="1" color="#000000"><?php echo CursoPalabra($fila_c['id_curso'],1,$conn) ?></font></b></td>
    </tr>
    <?php }?>
</table>

    <?
}
if($funcion==2){
	$rs_per=$ob_pei->listaPersonal($conn,$institucion);
	$rs_plan =$ob_pei->buscaPlan($conn,$curso);
	$tipo=(pg_numrows($rs_plan)>0)?1:0;
	$fila_plan=pg_fetch_array($rs_plan,0);
	
	?><br />
<form id="formplan">
<div  class="textonegrita">CURSO:<?php echo CursoPalabra($curso,1,$conn) ?>

  <input name="werw" type="hidden" id="werw"  />
  <input name="curso" type="hidden" id="curso" value="<?php echo $curso ?>" />
   <input name="tipo" type="hidden" id="tipo" value="<?php echo $tipo ?>" />
   <input name="idplan" type="hidden" id="tipo" value="<?php echo $fila_plan['id_plan'] ?>" />
</div><br />

<table width="750" border="0">
  <tr class="tableindex">
    <td colspan="4" align="center"> <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">PLANIFICACI&Oacute;N PLAN DE APOYO INDIVIDUAL</td>
  </tr>
  <tr class="tableindex">
    <td width="25%">TIPO DE APOYO</td>
    <td width="25%">DESCRIPCI&Oacute;N</td>
    <td width="25%">RESPONSABLE</td>
    <td width="25%">CONTEXTO<br />
      (Aula de recursos,aula com&uacute;n, taller, otros)</td>
  </tr>
  <tr >
    <td class="tableindex">PERSONAL<br />
      (Tipo de profesional que apoya y periodos)</td>
    <td><textarea name="personal_descripcion" cols="25" rows="5" id="personal_descripcion"><?php echo $fila_plan['personal_descripcion'] ?></textarea></td>
    <td><select name="personal_responsable" id="personal_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['personal_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="personal_contexto" cols="25" rows="5" id="personal_contexto"><?php echo $fila_plan['personal_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">CURRICULAR<br />
(Se&ntilde;ala asignaturas y periodos)</td>
    <td><textarea name="curricular_descripcion" cols="25" rows="5" id="curricular_descripcion"><?php echo $fila_plan['curricular_descripcion'] ?></textarea></td>
    <td><select name="curricular_responsable" id="curricular_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['curricular_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="curricular_contexto" cols="25" rows="5" id="curricular_contexto"><?php echo $fila_plan['curricular_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">MEDIOS Y RECURSOS MATERIALES Y/O TENCOL&Oacute;GICOS</td>
    <td><textarea name="medios_descripcion" cols="25" rows="5" id="medios_descripcion"><?php echo $fila_plan['medios_descripcion'] ?></textarea></td>
    <td><select name="medios_responsable" id="medios_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['medios_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="medios_contexto" cols="25" rows="5" id="medios_contexto"><?php echo $fila_plan['medios_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">ORGANIZACI&Oacute;N Y AGRUPAMIENTO EN EL AULA<br />
(Tiempo, espacio, forma de agrupar en la sala,tutor, etc.)</td>
    <td><textarea name="org_descripcion" cols="25" rows="5" id="org_descripcion"><?php echo $fila_plan['org_descripcion'] ?></textarea></td>
    <td><select name="org_responsable" id="org_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['org_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="org_contexto" cols="25" rows="5" id="org_contexto"><?php echo $fila_plan['org_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">FAMILIAR</td>
    <td><textarea name="familiar_descripcion" cols="25" rows="5" id="familiar_descripcion"><?php echo $fila_plan['familar_descripcion'] ?></textarea></td>
    <td><select name="familar_responsable" id="familar_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['familar_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="familiar_contexto" cols="25" rows="5" id="familiar_contexto"><?php echo $fila_plan['familar_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">OTROS</td>
    <td><textarea name="otros_descripcion" cols="25" rows="5" id="otros_descripcion"><?php echo $fila_plan['otros_descripcion'] ?></textarea></td>
    <td><select name="otros_responsable" id="otros_responsable">
     <option value="0">Seleccione</option>
    <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
    <option value="<?php echo $fila_p['rut_emp'] ?>" <?php echo ($fila_p['rut_emp']==$fila_plan['otros_responsable'])?"selected":""; ?>><?php echo $fila_p['ape_pat']." ".$fila_p['ape_pat']." ".$fila_p[nombre_emp] ?></option>
    <?php }?>
    </select></td>
    <td><textarea name="otros_contexto" cols="25" rows="5" id="otros_contexto"><?php echo $fila_plan['otros_contexto'] ?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" >&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4" align="right" ><input type="button" name="button" id="button" value="Guardar Datos" onclick="guardafrm()" class="botonXX" /></td>
    </tr>
</table>
</form>
<?
}
if($funcion==3){

if($tipo==0){
$rs_guarda=$ob_pei->guardaForm($conn,$ano,$curso,utf8_decode($personal_descripcion),$personal_responsable,utf8_decode($personal_contexto),utf8_decode($curricular_descripcion),$curricular_responsable,utf8_decode($curricular_contexto),utf8_decode($medios_descripcion),$medios_responsable,utf8_decode($medios_contexto),utf8_decode($org_descripcion),$org_responsable,utf8_decode($org_contexto),utf8_decode($familiar_descripcion),$familar_responsable,utf8_decode($familiar_contexto),utf8_decode($otros_descripcion),$otros_responsable,utf8_decode($otros_contexto));
}
if($tipo==1){
$rs_guarda=$ob_pei->updForm($conn,utf8_decode($personal_descripcion),$personal_responsable,utf8_decode($personal_contexto),utf8_decode($curricular_descripcion),$curricular_responsable,utf8_decode($curricular_contexto),utf8_decode($medios_descripcion),$medios_responsable,utf8_decode($medios_contexto),utf8_decode($org_descripcion),$org_responsable,utf8_decode($org_contexto),utf8_decode($familiar_descripcion),$familar_responsable,utf8_decode($familiar_contexto),utf8_decode($otros_descripcion),$otros_responsable,utf8_decode($otros_contexto),$idplan);	
}

echo ($rs_guarda)?1:0;
}
?>
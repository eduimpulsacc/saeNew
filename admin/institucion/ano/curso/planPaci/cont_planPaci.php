<?php 
require('../../../../../util/header.inc');


session_start();
require "mod_planPaci.php";
$ob_paci = new PlanPaci();

$funcion = $_POST['funcion'];
$institucion = $_SESSION['_INSTIT'];
$ano = $_SESSION['_ANO'];

if($funcion==1){
	//show($_POST);
$rs_alumno=$ob_paci->dAlumno($conn,$alumno);
$fila_alumno=pg_fetch_array($rs_alumno,0);
$rs_periodo = $ob_paci->dPeriodo($conn,$ano);

	
?><br>
<br>
 <input type="hidden" name="an" id="an" value="<?php echo $ano ?>">
<table>
<tr>
<td align=left><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </font> </td>
<td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
<td><font face="arial, geneva, helvetica" size=2> <strong><?php echo CursoPalabra($curso,1,$conn); ?>
  <input type="hidden" name="cur" id="cur" value="<?php echo $curso ?>">
</strong></font></td>
</tr>
<tr>
  <td align=left><font face="arial, geneva, helvetica" size=2> <strong>ALUMNO</strong> </font></td>
  <td>:</td><td><font face="arial, geneva, helvetica" size=2> <strong><?php echo $fila_alumno['ape_pat'] ?> <?php echo $fila_alumno['ape_mat'] ?> <?php echo $fila_alumno['nombre_alu'] ?>
    <input type="hidden" name="al" id="al" value="<?php echo $alumno ?>">
  </strong></td>
  
</tr>
<tr>
  <td align=left><font face="arial, geneva, helvetica" size=2> <strong>PERIODO</strong> </font></td>
  <td>:</td><td>
  <select name="cmb_periodo" id="cmb_periodo" onChange="infoper()">
  <option value="0">Seleccione Periodo</option>
  <?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
	  $fila_periodo= pg_fetch_array($rs_periodo,$p);
	  ?>
  <option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
  <?php }?>
  </select></td>
  
</tr>
</table>
<br>
<br>
<div id="eee"></div>



<?
}
if($funcion==2){
$rs_plan = $ob_paci->dPlan($conn,$ano,$curso);
$fila_plan=pg_fetch_array($rs_plan,0);

$rs_per=$ob_paci->listaPersonal($conn,$institucion);

/*$p_responsable=$ob_paci->temp($conn,$fila_plan['personal_responsable']);
$f_responsable=pg_fetch_array($p_responsable,0);

$cp_responsable=$ob_paci->temp($conn,$fila_plan['curricular_responsable']);
$f_cresponsable=pg_fetch_array($cp_responsable,0);

$cm_responsable=$ob_paci->temp($conn,$fila_plan['medios_responsable']);
$f_vmresponsable=pg_fetch_array($cm_responsable,0);

$or_responsable=$ob_paci->temp($conn,$fila_plan['org_responsable']);
$f_orgresponsable=pg_fetch_array($or_responsable,0);

$fam_responsable=$ob_paci->temp($conn,$fila_plan['familar_responsable']);
$f_famresponsable=pg_fetch_array($fam_responsable,0);

$otr_responsable=$ob_paci->temp($conn,$fila_plan['otros_responsable']);
$f_otrresponsable=pg_fetch_array($otr_responsable,0);

 */
$rs_cont = $ob_paci->contPlan($conn,$periodo,$curso,$alumno);
$tipo=(pg_numrows($rs_cont)==0)?0:1;
@$fila_cont = pg_fetch_array($rs_cont,0);

?>

<table width="750" border="0">
  <tr class="tableindex">
    <td colspan="5" align="center">    <strong>
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo ?>">
    </strong>PLANIFICACI&Oacute;N PLAN DE APOYO INDIVIDUAL</td>
  </tr>
  <tr class="tableindex">
    <td width="25%">TIPO DE APOYO</td>
    <td width="25%">DESCRIPCI&Oacute;N</td>
    <td width="25%">RESPONSABLE</td>
    <td width="25%">CONTEXTO<br />
      (Aula de recursos,aula com&uacute;n, taller, otros)</td>
    <td width="25%" align="center">CONTINUIDAD</td>
  </tr>
  <tr >
    <td class="tableindex">PERSONAL<br />
      (Tipo de profesional que apoya y periodos)</td>
    <td class="textosimple"><textarea name="personal_descripcion" cols="25" rows="5" id="personal_descripcion"><?php echo $fila_cont['personal_descripcion'] ?></textarea></td>
    <td class="textosimple"><select name="personal_responsable" id="personal_responsable" multiple="multiple" style="height:120px; width:150px">
      
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){  
		$fila_p=pg_fetch_array($rs_per,$p); 
		
		
		
		?>
      <option value="<?php echo $fila_p['rut_emp'] ?>" 
      
     <?php  if ($fila_cont['personal_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['personal_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
             //  $sep[$cp];
			   //$ob_paci->temp($conn,$fila_plan['personal_responsable']);
			   //$f_per=pg_fetch_array($p_responsable,0);
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
      
      
      ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p['nombre_emp'] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="personal_contexto" cols="25" rows="5" id="personal_contexto"><?php echo $fila_cont['personal_contexto'] ?></textarea></td>
    <td align="center"><input type="checkbox" name="personal" id="personal" <?php echo ($fila_cont['personal']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">CURRICULAR<br />
(Se&ntilde;ala asignaturas y periodos)</td>
    <td class="textosimple" ><textarea name="curricular_descripcion" cols="25" rows="5" id="curricular_descripcion"><?php echo $fila_cont['curricular_descripcion'] ?></textarea></td>
    <td class="textosimple"><select name="curricular_responsable" id="curricular_responsable" multiple="multiple" style="height:120px; width:150px">
     
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
      <option value="<?php echo $fila_p['rut_emp'] ?>" 
      //tooooooodos esto es para marcar los responsables
       <?php  if ($fila_cont['curricular_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['curricular_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
            
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
        
        ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p[nombre_emp] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="curricular_contexto" cols="25" rows="5" id="curricular_contexto"><?php echo $fila_cont['curricular_contexto'] ?></textarea></td>
    <td align="center"><input type="checkbox" name="curricular" id="curricular" <?php echo ($fila_cont['curricular']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">MEDIOS Y RECURSOS MATERIALES Y/O TENCOL&Oacute;GICOS</td>
    <td class="textosimple"><textarea name="medios_descripcion" cols="25" rows="5" id="medios_descripcion"><?php echo $fila_cont['medios_descripcion'] ?></textarea></td>
    <td><select name="medios_responsable" id="medios_responsable" multiple="multiple" style="height:120px; width:150px">
      
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
      <option value="<?php echo $fila_p['rut_emp'] ?>" 
	  
	  <?php  if ($fila_cont['medios_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['medios_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
            
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
	  
	 ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p[nombre_emp] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="medios_contexto" cols="25" rows="5" id="medios_contexto"><?php echo $fila_cont['medios_contexto'] ?></textarea></td>
    <td align="center" class="textosimple"><input type="checkbox" name="medios" id="medios" <?php echo ($fila_cont['medios']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">ORGANIZACI&Oacute;N Y AGRUPAMIENTO EN EL AULA<br />
(Tiempo, espacio, forma de agrupar en la sala,tutor, etc.)</td>
    <td class="textosimple"><textarea name="org_descripcion" cols="25" rows="5" id="org_descripcion"><?php echo $fila_cont['org_descripcion'] ?></textarea></td>
    <td class="textosimple"><select name="org_responsable" id="org_responsable" multiple="multiple" style="height:120px; width:150px">
      
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
      <option value="<?php echo $fila_p['rut_emp'] ?>" 
      
      <?php  if ($fila_cont['org_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['org_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
            
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
      
      ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p[nombre_emp] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="org_contexto" cols="25" rows="5" id="org_contexto"><?php echo $fila_cont['org_contexto'] ?></textarea></td>
    <td align="center"><input type="checkbox" name="organizacion" id="organizacion" <?php echo ($fila_cont['organizacion']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">FAMILIAR</td>
    <td class="textosimple"><textarea name="familiar_descripcion" cols="25" rows="5" id="familiar_descripcion"><?php echo $fila_cont['familar_descripcion'] ?></textarea></td>
    <td class="textosimple"><select name="familar_responsable" id="familar_responsable" multiple="multiple" style="height:120px; width:150px">
     
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
      <option value="<?php echo $fila_p['rut_emp'] ?>"
      
       <?php  if ($fila_cont['familar_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['familar_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
            
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
      
      ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p[nombre_emp] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="familiar_contexto" cols="25" rows="5" id="familiar_contexto"><?php echo $fila_cont['familar_contexto'] ?></textarea></td>
    <td align="center"><input type="checkbox" name="familiar" id="familiar" <?php echo ($fila_cont['familiar']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">OTROS</td>
    <td class="textosimple"><textarea name="otros_descripcion" cols="25" rows="5" id="otros_descripcion"><?php echo $fila_cont['otros_descripcion'] ?></textarea></td>
    <td class="textosimple"><select name="otros_responsable" id="otros_responsable" multiple="multiple" style="height:120px; width:150px">
      
      <?php for($p=0;$p<pg_numrows($rs_per);$p++){
		$fila_p=pg_fetch_array($rs_per,$p); ?>
      <option value="<?php echo $fila_p['rut_emp'] ?>"
      
       <?php  if ($fila_cont['otros_responsable'] != "0,") {
		$sep = explode(",", substr($fila_cont['otros_responsable'], 0, -1));
		 for ($cp = 0; $cp < count($sep); $cp++) {
            
			   echo ($sep[$cp]==$fila_p['rut_emp'])?"selected":"";
		 }
		}?>
      
       ><?php echo $fila_p['ape_pat']." ".$fila_p['ape_mat']." ".$fila_p[nombre_emp] ?></option>
      <?php }?>
    </select></td>
    <td class="textosimple"><textarea name="otros_contexto" cols="25" rows="5" id="otros_contexto"><?php echo $fila_cont['otros_contexto'] ?></textarea></td>
    <td align="center" class="textosimple"><input type="checkbox" name="otros" id="otros" <?php echo ($fila_cont['otros']==1)?"checked":""; ?>></td>
  </tr>
  <tr>
    <td class="tableindex">OBSERVACIONES</td>
    <td colspan="4" class="textosimple"><textarea name="observaciones" cols="50" rows="5" id="observaciones"><?php echo $fila_cont['observaciones'] ?></textarea></td>
  </tr>
  <tr>
    <td colspan="5" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="right" ><input type="button" name="button" id="button" value="GUARDAR DATOS" class="botonXX" onClick="guardaCont()"></td>
  </tr>
</table>
<?
}
if($funcion==3){
	
	//show($_POST);
if($tipo==0){
//insert
$rs_data=$ob_paci->insComt($conn,$curso,$alumno,$periodo,$personal,$curricular,$medios,$organizacion,$familiar,$otros,utf8_decode($observaciones),
utf8_decode($personal_descripcion),$personal_responsable,utf8_decode($personal_contexto),
utf8_decode($curricular_descripcion),$curricular_responsable,utf8_decode($curricular_contexto),
utf8_decode($medios_descripcion),$medios_responsable,utf8_decode($medios_contexto),
utf8_decode($org_descripcion),$org_responsable,utf8_decode($org_contexto),
utf8_decode($familiar_descripcion),$familiar_responsable,utf8_decode($familiar_contexto),
utf8_decode($otros_descripcion),$otros_responsable,utf8_decode($otros_contexto));
}
if($tipo==1)
{
	//update
	$rs_data=$ob_paci->upComt($conn,$curso,$alumno,$periodo,$personal,$curricular,$medios,$organizacion,$familiar,$otros,utf8_decode($observaciones),
	utf8_decode($personal_descripcion),$personal_responsable,utf8_decode($personal_contexto),
	utf8_decode($curricular_descripcion),$curricular_responsable,utf8_decode($curricular_contexto),
	utf8_decode($medios_descripcion),$medios_responsable,utf8_decode($medios_contexto),
	utf8_decode($org_descripcion),$org_responsable,utf8_decode($org_contexto),
	utf8_decode($familiar_descripcion),$familiar_responsable,utf8_decode($familiar_contexto),
	utf8_decode($otros_descripcion),$otros_responsable,utf8_decode($otros_contexto));
	}
	
	echo($rs_data)?1:0;	
}
?>
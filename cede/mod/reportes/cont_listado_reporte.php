<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_listado_reporte.php";


$institucion=$_INSTIT;
$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reportes($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];

//var_dump($_POST);


if($funcion==1){
	$rs_reporte = $ob_reporte->ListadoReportes();
	
	?>

<fieldset>
<legend>LISTADO DE REPORTES</legend>

<table width="80%" border="0">
<? for($i=0;$i<pg_numrows($rs_reporte);$i++){
		$fila = pg_fetch_array($rs_reporte,$i);
		$j=$i + 1;
?>
	
  <tr  onmouseover=this.style.background='gray';this.style.cursor='hand' onMouseOut=this.style.background='none'>
    <td onclick="reporte1('<?=$fila['url'];?>',<?=$fila['id_reporte'];?>)">&nbsp;<? echo $j.".-".htmlentities($fila['nombre'],ENT_QUOTES,'UTF-8')?></td>
  </tr>
  
<? } ?>
</table>

  
</fieldset>
<? } // fin funcion 

if($funcion==2){
	
	$rs_ano =$ob_reporte->Ano($institucion);?>

<fieldset>
<legend><?=htmlentities("MOTOR DE BÚSQUEDA",ENT_QUOTES,'UTF-8');?></legend>
<?php if($tipo!=7){?>
<table border="0">
  <tr>
    <td width="91" >&nbsp;<?=htmlentities("AÑO :",ENT_QUOTES,'UTF-8');?></td>
    <td width="156">&nbsp;
    <select name="cmbANO" id="cmbANO" onchange="carga_curso(this.value)">
    	<option>seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_ano);$i++){
			$fila_ano = pg_fetch_array($rs_ano,$i);
			if($fila_ano['situacion']==1) $situacion="(abierto)"; else $situacion="(cerrado)";?>
            <option value="<?=$fila_ano['id_ano'];?>"><?=$fila_ano['nro_ano']." ".$situacion;?></option>
		<? }?>
    </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;CURSO :</td>
    <td>&nbsp;
   
    	<select name="select_cursos" id="select_cursos" style="margin-left:15px"  <?php if($tipo!=3 && $tipo!=5 && $tipo!=6){echo "onchange='AbrirReporte(this.value)'";}elseif($tipo==5){echo "onchange='carga_alumno(this.value)'";}elseif($tipo==6){echo "onchange='carga_alumno(this.value)'";}?>>
			<option value="0" selected="selected" >Seleccionar</option>
		</select>
    </td>
  </tr>
 <?php  if($tipo==3){?>
  <tr>
    <td>TIPO BECA:</td>
    <td>&nbsp;<select name="select_beca" id="select_beca" onchange="AbrirReporteBeca(this.value)">
    <option value="0" selected="selected">Seleccione</option>
    <option value="1" >Becas Estatales</option>
    <option value="2" >Becas Institucionales</option>
    </select></td>
  </tr>
  <?php }?>
  
   <?php  if($tipo==5 || $tipo==6){?>
  <tr>
    <td>ALUMNO:</td>
    <td><label id="label_alumno">&nbsp;
<select name="select_alumnos"  id="select_alumnos" style="margin-left:5px">
<option value="0" selected="selected" >Seleccionar</option>
</select></label></td>
  </tr>
  <?php }?>
  
  
 
</table>
<?php } else{?>
<!--tabla entrevista-->
<table border="0" id="cmb">
  <tr>
    <td width="91" >&nbsp;<?=htmlentities("AÑO :",ENT_QUOTES,'UTF-8');?></td>
    <td width="156">&nbsp;
    <select name="cmbANO" id="cmbANO" onchange="carga_curso(this.value)">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_ano);$i++){
			$fila_ano = pg_fetch_array($rs_ano,$i);
			if($fila_ano['situacion']==1) $situacion="(abierto)"; else $situacion="(cerrado)";?>
            <option value="<?=$fila_ano['id_ano'];?>"><?=$fila_ano['nro_ano']." ".$situacion;?></option>
		<? }?>
    </select>
    </td>
  </tr>
<tr>
    <td>TIPO ENTREVISTA:</td>
    <td>&nbsp;<select name="cmbPlantilla" id="cmbPlantilla" onChange="carga()">
      <option value="0" >Seleccione Tipo de Entrevista</option>
      <option value="1" >Apoderado</option>
      <option value="2" >Alumno</option>
      <option value="3" >Entrevistador</option>
      
    </select></td>
  </tr>  
  
 
</table>
<?php }?>
  
</fieldset>
<? } // fin funcion 

 
if($funcion==3){
	$rs_curso = $ob_reporte->Curso($ano);?>
    <select name="select_cursos" id="select_cursos" style="margin-left:15px" onchange="AbrirReporte(this.value)">
		<option value="0" selected="selected" >Seleccione</option>
	<? for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
			$Curso_pal = htmlentities($objMembrete->CursoPalabra($fila['id_curso'],1))
	?>
    	<option value="<?=$fila['id_curso'];?>"><?=$Curso_pal;?></option>
    <? } ?>	
	
</select>

<br />

<?
    	
}
if($funcion==4){
	$result = $ob_reporte->Carga_Alumnos($_POST['id_curso'],$_POST['id_ano']); 
		
		if($result){?>
		  <select name="select_alumnos" id="select_alumnos" 
		  onChange="AbrirReporteanotaciones()" style="margin-left:1px">
          <option value=0 selected>Selecccionar</option>
		<?php for($i=0 ; $i < @pg_numrows($result ) ; $i++){  
  		   
		  $fila = @pg_fetch_array($result ,$i); 
		    
		  $nombre  = ucwords(strtolower(htmlentities(trim($fila["ape_pat"]))));
	      $nombre .= "&nbsp;".ucwords(strtolower(htmlentities(trim($fila["ape_mat"]))));
	      $nombre .= "&nbsp;".ucwords(strtolower(htmlentities(trim($fila["nombre_alu"]))));?>
		 
          <option value="<?php echo trim($fila["rut_alumno"]) ?>"><?php echo $nombre  ?></option>
		 
		<?php   }?>
		</select>
		
		<?php 
		}
}//fin funcion carga alumno

if($funcion==5){
		
	?>
	
<tr id="cc3" >
      <td>&nbsp;CURSO :</td>
    <td>&nbsp;
   
    	<?php $rs_curso = $ob_reporte->Curso($ano);?>
    <select name="select_cursos" id="select_cursos" style="margin-left:15px" onChange="cargaApo();cargaPlantillaApo();">
		<option value="0" selected="selected" >Seleccione</option>
	<? for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
			$Curso_pal = htmlentities($objMembrete->CursoPalabra($fila['id_curso'],1));
	?>
    	<option value="<?=$fila['id_curso'];?>"><?=$Curso_pal;?></option>
    <? } ?>	
	
</select>
    </td>
    </tr>
	<?
}
if($funcion==6){
	$result_apo=$ob_reporte->listaApo($ano,$curso);
	if($result_apo){
	?>
   <tr id="cc1"> <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>APODERADO</strong></font></td>                                     
     <td>
<select name="cmb_entre"  id="cmb_entre">
    <option value="0">(TODOS LOS APODERADOS)
    <?php   for($a=0;$a<pg_numrows($result_apo);$a++){
	  $fila_apo = pg_fetch_array($result_apo,$a);
	  ?>
  <option value="<?php echo $fila_apo['rut_apo'] ?>"><?php echo $fila_apo['ape_pat']." ". $fila_apo['ape_mat']." , ". $fila_apo['nombre_apo']?></option>
      <?php }?>
    </select>
</td></tr>
    <?php
	}
	else echo 0;
	}
if($funcion==7){
	$result_curso=$ob_reporte->enseCurso($curso,$tipo);
	
	 $ense = pg_result($result_curso,1);
	
	$grado = pg_result($result_curso,0);
	$rs_plantilla = $ob_reporte->planActiva($ense,$grado,$tipo,$institucion);
	
	if($rs_plantilla && pg_numrows($rs_plantilla)>0){
	?>
    <tr id="cc2">  <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>PLANTILLA</strong></font></td>
<td>
    
    <select name="idplantilla" id="idplantilla" onchange="AbrirReporteEntrevista()">
    <option value="0">Seleccione Plantilla</option>
    <?php for($p=0;$p<pg_numrows($rs_plantilla);$p++){
		$fil_plantilla = pg_fetch_array($rs_plantilla,$p);
		?>
    <option value="<?php echo $fil_plantilla['id_plantilla'] ?>"><?php echo $fil_plantilla['nombre_informe'] ?></option>
    <?php }?>
    </select>
    </td></tr>
    <?php
	}else echo 0;
	}
if($funcion==8){
$result_alu=$ob_reporte->listaalu($curso);
	if($result_alu){
	?>
    <tr id="cc1"> <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>ALUMNO</strong></font></td>
                                        <td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td>
<select name="cmb_alu">
    <option value="0">(TODOS LOS ALUMNOS)
    <?php   for($a=0;$a<pg_numrows($result_alu);$a++){
	  $fila_alu = pg_fetch_array($result_alu,$a);
	  ?>
  <option value="<?php echo $fila_alu['rut_alumno'] ?>"><?php echo $fila_alu['ape_pat']." ". $fila_alu['ape_mat']." , ". $fila_alu['nombre_alu']?></option>
      <?php }?>
    </select>
</td></tr>
    <?php
	}
	else echo 0;
}

if($funcion==22){
	 $rs_curso = $ob_reporte->Curso($ano);
	if($rs_curso){
		?>
		<tr id="cc1">
     <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong></font></td>
                                                           <td><select name="select_cursos"  class="ddlb_9_x" id="select_cursos" onChange="cargaAlu();cargaPlantillaApo();">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($rs_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($rs_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso']);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = $objMembrete->CursoPalabra($fila['id_curso']);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></td>
    </tr>
	<?php }
	else echo 0;

}
if($funcion==11){
	$result_alu=$ob_reporte->listaalu($curso);
	if($result_alu){
	?>
<tr id="cc2" > <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>ALUMNO</strong></font></td> <td>
<select name="cmb_entre" id="cmb_entre">
    <option value="0">(TODOS LOS ALUMNOS)
    <?php   for($a=0;$a<pg_numrows($result_alu);$a++){
	  $fila_alu = pg_fetch_array($result_alu,$a);
	  ?>
  <option value="<?php echo $fila_alu['rut_alumno'] ?>"><?php echo $fila_alu['ape_pat']." ". $fila_alu['ape_mat']." , ". $fila_alu['nombre_alu']?></option>
      <?php }?>
    </select>
</td></tr>
    <?php
	}
	else echo 0;
}
if($funcion==9){
	$result_emp=$ob_reporte->listaTrabaja($institucion);
	if($result_emp){
	?>
<tr id="cc2"> <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>EMPLEADO</strong></font></td><td>
<select name="cmb_entre" id="cmb_entre" >
    <option value="0">(TODOS LOS EMPLEADOS)
    <?php    for($a=0;$a<pg_numrows($result_emp);$a++){
	  $fila_emp = pg_fetch_array($result_emp,$a);
	  ?>
  <option value="<?php echo $fila_emp['rut_emp'] ?>"><?php echo $fila_emp['ape_pat']." ". $fila_emp['ape_mat']." , ". $fila_emp['nombre_emp']?></option>
      <?php }?>
    </select>
   </td></tr>
    <?php
	}
	else echo 0;
}

if($funcion==18){
	
	$rs_plantilla = $ob_reporte->planActivaEmp($tipo,$institucion);
	
	if($rs_plantilla && pg_numrows($rs_plantilla)>0){
	?>
    <tr id="cc2">  <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>PLANTILLA</strong></font></td>
    <td>
    <label for="idplantilla"></label>
    <select name="idplantilla" id="idplantilla"  onchange="AbrirReporteEntrevista()">
    <option value="0">Seleccione Plantilla</option>
    <?php for($p=0;$p<pg_numrows($rs_plantilla);$p++){
		$fil_plantilla = pg_fetch_array($rs_plantilla,$p);
		?>
    <option value="<?php echo $fil_plantilla['id_plantilla'] ?>"><?php echo $fil_plantilla['nombre_informe'] ?></option>
    <?php }?>
    </select>
    </td></tr>
    <?php
	}else echo 0;
}


?>
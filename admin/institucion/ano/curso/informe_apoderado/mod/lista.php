<?
require('../../../../../../util/header.inc');

$institucion=$_INSTIT;

require "../class/plantilla.php";
$obj_carga = new Plantilla();


foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
    eval($asignacion); 
	//echo "<br>".$asignacion;
}



if($funcion==1){
	$result_curso=$obj_carga->listaCurso($conn,$ano);
	if($result_curso){
	?>
	
<tr id="cc1">
     <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong></font></td>
                                        <td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td><div id="sne"></div><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="cargaApo();cargaPlantillaApo();">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></td>
    </tr>
   
	
	<?php
	}else
	echo 0;

}


if($funcion==2){
	$result_curso=$obj_carga->listaCurso($conn,$ano);
	if($result_curso){
		?>
		<tr id="cc1">
     <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong></font></td>
                                        <td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="cargaAlu();cargaPlantillaApo();">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></td>
    </tr>
	<?php }
	else echo 0;

}
if($funcion==3){
	
	$result_emp=$obj_carga->listaTrabaja($conn,$institucion);
	if($result_emp){
	?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr class="tablatit2-1">
    <td width="123">RUT</td>
    <td width="511"> NOMBRE EMPLEADO</td>
    </tr>
  <?php   for($a=0;$a<pg_numrows($result_emp);$a++){
	  $fila_emp = pg_fetch_array($result_emp,$a);
	  ?>
    <tr onClick="aEvaluar(<?php echo $fila_emp['rut_emp'] ?>)" class="textosimple" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='white'" style="cursor: pointer; ">
      <td ><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila_emp['rut_emp']." - ".$fila_emp['dig_rut'] ?></font></td>
      <td> <?php echo $fila_emp['ape_pat']." ". $fila_emp['ape_mat']." , ". $fila_emp['nombre_emp']?></td>
    </tr>
    <?php }?>
    </table>
    <?php
	}
	else echo 0;
	
	

}
if($funcion==4){
	$result_apo=$obj_carga->listaApo($conn,$ano,$curso);
	if($result_apo){
	?>
    <table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr class="tablatit2-1">
    <td width="123">RUT</td>
    <td width="511"> NOMBRE APODERADO</td>
    </tr>
  <?php   for($a=0;$a<pg_numrows($result_apo);$a++){
	  $fila_apo = pg_fetch_array($result_apo,$a);
	  ?>
    <tr onClick="aEvaluar(<?php echo $fila_apo['rut_apo'] ?>)" class="textosimple" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='white'" style="cursor: pointer; ">
      <td ><?php echo $fila_apo['rut_apo']." - ".$fila_apo['dig_rut'] ?></font></td>
      <td> <?php echo $fila_apo['ape_pat']." ". $fila_apo['ape_mat']." , ". $fila_apo['nombre_apo']?></td>
    </tr>
    <?php }?>
    </table>
    <?php
	}
	else echo 0;

}

if($funcion==5){
	$result_periodo=$obj_carga->listaPeriodo($conn,$ano);
	if($result_periodo){?>
    <select name="periodo" id="periodo" onChange="pp()" >
                <option value="0">Seleccione Periodo</option>
                <?php
				for($countPer=0 ; $countPer<@pg_numrows($result_periodo) ; $countPer++){
					$filaPeriodo=@pg_fetch_array($result_periodo, $countPer);
					if($filaPeriodo['id_periodo']==$periodo){
					echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}else{
					echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}
				}
				?>
</select>
    <?php
		}
	else echo 0;
}

if($funcion==6){
$result_alu=$obj_carga->listaalu($conn,$curso);
	if($result_alu){
	?>
<table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr class="tablatit2-1">
    <td width="123">RUT</td>
    <td width="511"> NOMBRE ALUMNO</td>
    </tr>
  <?php   for($a=0;$a<pg_numrows($result_alu);$a++){
	  $fila_alu = pg_fetch_array($result_alu,$a);
	  ?>
    <tr onClick="aEvaluar(<?php echo $fila_alu['rut_alumno'] ?>)" class="textosimple" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='white'" style="cursor: pointer; ">
      <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $fila_alu['rut_alumno']." - ".$fila_alu['dig_rut'] ?></font></td>
      <td> <?php echo $fila_alu['ape_pat']." ". $fila_alu['ape_mat']." , ". $fila_alu['nombre_alu']?></td>
    </tr>
    <?php }?>
    </table>
    <?php
	}
	else echo 0;
}

//buscar plantillas disponibles 
if($funcion==7){
	$result_curso=$obj_carga->enseCurso($conn,$curso,$tipo);
	
	$ense = pg_result($result_curso,1);
	
	$grado = pg_result($result_curso,0);
	$rs_plantilla = $obj_carga->planActiva($conn,$ense,$grado,$tipo,$_INSTIT);
	
	if($rs_plantilla && pg_numrows($rs_plantilla)>0){
	?>
    <tr id="cc2">  <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>PLANTILLA</strong></font></td>
<td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
    <td>
    <label for="tip"></label>
    <select name="tip" id="tip" onChange="idp()">
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
	
	$rs_plantilla = $obj_carga->planActivaEmp($conn,$tipo,$institucion);
	
	if($rs_plantilla && pg_numrows($rs_plantilla)>0){
	?>
    <tr id="cc2">  <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>PLANTILLA</strong></font></td>
<td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
    <td>
    <label for="tip"></label>
    <select name="tip" id="tip" onChange="idp()">
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

if($funcion==9){
	$result_emp=$obj_carga->listaTrabaja($conn,$institucion);
	if($result_emp){
	?>
<tr id="cc2"> <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>EMPLEADO</strong></font></td>
                                        <td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td>
<select name="cmb_emp">
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
if($funcion==10){
	$result_apo=$obj_carga->listaApo($conn,$ano,$curso);
	if($result_apo){
	?>
   <tr id="cc1"> <td align="left" width="110"><font face="arial, geneva, helvetica" size=2> <strong>APODERADO</strong></font></td>
                                        <td width="4"><font face="arial, geneva, helvetica" size=2> <strong>:</strong></font></td>
                                        <td>
<select name="cmb_apo">
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
if($funcion==11){
	$result_alu=$obj_carga->listaalu($conn,$curso);
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


?>

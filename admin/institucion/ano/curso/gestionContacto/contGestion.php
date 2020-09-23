<?php require('../../../../../util/header.inc');
session_start();
require "modGestion.php";
$obj_gestion = new Gestion();

foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

if($funcion==1){
$listaP = $obj_gestion->getPeriodo($conn,$_ANO); 
?>
<table width="100%" border="1" cellspacing="1" cellpadding="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td align="center">Periodo</td>
    <td align="center">Ingresar</td>
    <td align="center">Descargar</td>
   <?php  //if($_PERFIL==0){?>
    <td align="center">Eliminar</td>
    <?php //}?>
    </tr>
   <?php  for($l=0;$l<pg_numrows($listaP);$l++){
	   $lista = pg_fetch_array($listaP,$l);
	   ?>
  <tr class="textosimple">
    <td>Del <span id="fec<?php echo $lista['id_gestion'] ?>"><?php echo CambioFD($lista['fecha_desde']) ?> al <?php echo CambioFD($lista['fecha_hasta']) ?></span></td>
    <td align="center" valign="middle"><input type="button" name="button" id="button" value="Ingresar" onclick="ingPer(<?php echo $lista['id_gestion'] ?>)" class="botonXX" /></td>
    <td align="center">
    <!--onclick="window.open('generaExcel.php?ipe=<?php echo $lista['id_gestion'] ?>','_blank');"-->
    <input type="button" name="button2" id="button2" value="Descargar" class="botonXX" onclick="revisaRes(<?php echo $lista['id_gestion'] ?>)" />
    
    </td>
    <?php  //if($_PERFIL==0){?>
    <td align="center"><input type="button" name="button3" id="button3" value="Eliminar" onclick="delPer(<?php echo $lista['id_gestion'] ?>)" class="botonXX" /></td>
    <?php //}?>
  </tr>
    <?php }?>
</table>
   <?
}
if($funcion==2){
	$nro_ano = $obj_gestion->getNroAno($conn,$_ANO);
?>
 <script>
  $( function() {
    $( "#fini,#fter" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	/*showOn: "both",
                buttonImage: "bitacora/Calendario/calendario.gif",
                buttonImageOnly: true,*/
	//yearRange: '<?php echo $nro_ano ?>:<?php echo $nro_ano ?>',
	// minDate: new Date(<?php echo $nro_ano ?>, 1 - 1, 1), maxDate: new Date(<?php echo $nro_ano ?>, 12 - 1, 31),
	changeMonth: true,
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	
});
  } );
  </script>
<table border="1" style="border-collapse:collapse">
<tr><td class="cuadro02">Fecha Inicio</td><td><input name="fini" type="text" class="cuadro01" id="fini" style="width:90px; font-size:10px" readonly="readonly"/>&nbsp;</td>
  <td class="cuadro02">Fecha T&eacute;rmino</td><td><input name="fter" type="text" class="cuadro01" id="fter" style="width:90px; font-size:10px" readonly="readonly" /></td></tr>
</table>
<? 
}
if($funcion==3){

$ini = CambioFE($ini);
$ter = CambioFE($ter);

$ex = $obj_gestion->existPeriodo($conn,$_ANO,$ini,$ter);
if(pg_numrows($ex)>0){
echo 2;
}else{
$rs_guarda = $obj_gestion->guardaPer($conn,$_ANO,$ini,$ter);
echo ($rs_guarda)?1:0;
}
}
if($funcion==4){
$rs_cur = $obj_gestion->getCurso($conn,$_ANO);
?>
 <form id="frm">
<input type="hidden" name="x" />
<input type="hidden" id="ip" value="<?php echo $pe ?>" />
<select id="cmb_curso" name="cmb_curso" onchange="cargacurso(this.value)">
<option value="0">Seleccione curso</option>
<?php for($c=0;$c<pg_numrows($rs_cur);$c++){
	$fila_c = pg_fetch_array($rs_cur,$c);
	?>
    <option value="<?php echo $fila_c['id_curso']?>"><?php echo CursoPalabra($fila_c['id_curso'],1,$conn)?></option>
<?php }?>
</select>
<div id="pcur"></div>
</form>
<?
}
if($funcion==5){
	
$l_alu = $obj_gestion->getAlumno($conn,$cu);
$l_pre = $obj_gestion->getPreguntas($conn);
if($cu!=0){
?><br />

<table width="98%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td valign="top">N&ordm;</td>
    <td valign="top">Alumno</td>
    <?php  for($l=0;$l<pg_numrows($l_pre);$l++){
		$f_pre = pg_fetch_array($l_pre,$l);
		?>
     <td style="width:150px !important"><?php echo $f_pre['texto_pregunta'] ?></td>
     <?php }?>
  </tr>
  <?php for($a=0;$a<pg_numrows($l_alu);$a++){
	  $f_al = pg_fetch_array($l_alu,$a);?>
  <tr class="textosimple">
    <td><?php echo ($a+1) ?></td>
    <td><?php echo $f_al['nombre'] ?></td>
   <?php  for($l=0;$l<pg_numrows($l_pre);$l++){
	   $f_pre = pg_fetch_array($l_pre,$l);
	   $id_pre = $f_pre['id_pregunta'];
	   
	  
	   ?>
     <td align="center">
   <?php    //alternativas repuesta
	   $l_alt = $obj_gestion->getAlternativas($conn,$id_pre);?>
     <select name="<?php echo  $f_al['rut_alumno']?>_<?php echo $id_pre ?>"  id="<?php echo  $f_al['rut_alumno']?>_<?php echo $id_pre ?>" style="width:180px" onchange="saveRespuesta(<?php echo  $f_al['rut_alumno']?>,this.value, <?php echo $id_pre ?>)"> 
     <option value="0">Seleccione</option>
     <?php  for($r=0;$r<pg_numrows($l_alt);$r++){
		 $f_alt = pg_fetch_array($l_alt);
		 $f_al['rut_alumno']=trim($f_al['rut_alumno']);
		 
		$re =  $obj_gestion->extRespuesta($conn,$per,$cu,$f_al['rut_alumno'],$id_pre);
		
		$exp = pg_result($re,0);
		
		$sel=($exp==$f_alt['id_alternativa'])?"selected":"";
		
		 ?>
      <option value="<?php echo $f_alt['id_alternativa'] ?>" <?php echo $sel ?>><?php echo $f_alt['texto_alternativa'] ?></option>
      <?php }?>
     
     </select></td>
     <?php }?>
  </tr>
  <?php }?>
 
</table>

<?php }
}
?>
<?
if($funcion==6){

$ext= $obj_gestion->extRespuesta($conn,$per,$cu,$al,$pr);
if(pg_numrows($ext)==0){
//agregar
$rs_guarda = $obj_gestion->addRespuesta($conn,$per,$cu,$al,$pr,$an,$re);

}else{
//actualizar
$rs_guarda = $obj_gestion->upRespuesta($conn,$per,$cu,$al,$pr,$an,$re);
}

}

if($funcion==7){
	$tpre = $obj_gestion->getPreguntas($conn);
	$tpre = pg_numrows($tpre);
	$tres = $obj_gestion->cuentaRes($conn,$_ANO,$per);
	
	$tmat = $obj_gestion->getCantMatricula($conn,$_ANO);
	
	$treg = $tres*$tpre;
	
	$tpos = $tmat*$tpre;
	
	if($treg < $tpos){
		echo 0;	
	}
	else{
		echo 1;	
	}
	
}

if($funcion==8){
$ext = $obj_gestion->cuentaRes($conn,$_ANO,$per);
if($ext>0){
	$delres = $obj_gestion->delRespuestas($conn,$per);
	
	}
$delper= $obj_gestion->delPeriodo($conn,$per);

//echo ($delper)?1:0;
echo 1;
}
?>
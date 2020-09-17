<?php 
session_start();
require("../../util/header.php");
 require("mod_multa.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_multa = new MultaAdm();

if($funcion==2){
$rs_emp = $ob_multa->traeEmp($conn,$rdb);
?>
<select name="cmbRUT" id="cmbRUT" onchange="traeMulta()">
 <option value="0">Seleccione</option>
         
<?
for($e=0;$e<pg_numrows($rs_emp);$e++){
	$fila_e = pg_fetch_array($rs_emp,$e);
	?>
 <option value="<?php echo $fila_e['rut_emp'] ?>"><?php echo strtoupper(sanear_string($fila_e['ape_pat']." ".$fila_e['ape_mat']." ".$fila_e['nombre_emp']));?></option>
    <?
	} 
	?>
	</select>
    <?
}
if($funcion==3){
	$rs_cur = $ob_multa->traeCurso($conn,$ano);
?>
<select name="cmbCurso" id="cmbCurso" onChange="traeNombre()">
<option value="0">Seleccione Curso</option>
<?php  for($e=0;$e<pg_numrows($rs_cur);$e++){
$fila_e = pg_fetch_array($rs_cur,$e); ?>
<option value="<?php echo $fila_e['id_curso'] ?> "><?php echo CursoPalabra($fila_e['id_curso'],0,$conn) ?> </option>
<?php }?>
</select>
<?
}
if($funcion==4){
if($tipo==2){
	$rs_listado = $ob_multa->traeApoCurso($conn,$curso);	
	}
elseif($tipo==3){
	$rs_listado = $ob_multa->traeAluCurso($conn,$curso);	
	}
	
	?>
    <select name="cmbRUT" id="cmbRUT" onChange="traeMulta()">
            <option value="0">Seleccione</option>
            <?php  for($e=0;$e<pg_numrows($rs_listado);$e++){
$fila_e = pg_fetch_array($rs_listado,$e); ?>
<option value="<?php echo $fila_e['rut'] ?> "><?php echo strtoupper($fila_e['nombre']) ?> </option>
<?php }?>
    </select>
    <?
}
if($funcion==5){
	$rs_pres = $ob_multa->multasUsuario($conn,$usu);
?>

 <table width="80%" align="center">
 <?php if(pg_numrows($rs_pres)>0){
	 ?>
 <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>PRESTAMOS CON MULTA</p></td>
    </tr>
  <tr class="cuadro02">
  
    <td width="9%">#</td>
    <td width="39%" align="center">T&iacute;tulo</td>
    <td width="27%" align="center">Fecha Devoluci&oacute;n</td>
    
    <td  align="center">Acciones</td>
    </tr>
  <?php   
  for($p=0;$p<pg_numrows($rs_pres);$p++){
	   $fila_pres = pg_fetch_array($rs_pres,$p);
	   $val = ($fila_pres['rut_usuario']==$rut_usuario)?"R":"";
	  ?>
  <tr class="cuadro01">
    <td><?php echo $p+1 ?></td>
    <td align="center"><?php echo $fila_pres['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fila_pres['fecha_devolucion']) ?></td>
   
    <td width="9%" align="center">
     <!-- i-->
     <input name="" type="button" title="Pr&eacute;stamo multado" value="M" onClick="datoMulta(<?php echo $fila_pres['id_prestamo'] ?>,<?php echo $fila_pres['id_ejemplar'] ?>)">
      </td>
   
    
    
  </tr>
  <?php }?>
  <?php }else{?>
  <tr>
    <td colspan="6" class="titulos-respaldo" align="center"><p>SIN PRESTAMOS CON MULTA</p></td>
    </tr>
  <?php }?>
 </table>
<?
}if($funcion==6){
//show($_POST);
 //ver si tengo cinfigurada las multas
$rs_multa = $ob_multa->tengoMulta($conn,$_INSTIT);
$r_pres =	$ob_multa->datopres($conn,$pres);
$fila_pres = pg_fetch_array($r_pres,0);
$rsamo =$ob_multa->anoEs($conn,$_ANO);
$nanio = pg_result($rsamo,1);
 $hab = hbl($fila_pres['fecha_devolucion'],date("$nanio-m-d"));
$arrfer = $ob_multa->rangoFeriadoAno($conn,$_ANO,$fila_pres['fecha_devolucion'],date("$nanio-m-d"));


$cuf =0;
	for($f=0;$f<pg_numrows($arrfer);$f++){
		$ffer = pg_fetch_array($arrfer,$f);
		
		$cuf = $cuf+ddiff($ffer['fecha_inicio'],$ffer['fecha_fin']);
	}
	
	 $dias_utiles = $hab-$cuf;

?>
<table width="95%" border="0">
  <tr>
    <td colspan="2" align="center"><input type="hidden" name="prestamo" id="prestamo" value="<?php echo $fila_pres['id_prestamo'] ?>" /><input name="ejemplar" type="hidden" id="ejemplar" value="<?php echo $fila_pres['id_ejemplar'] ?>" />
      <input name="rutu" type="hidden" id="rutu" value="<?php echo $fila_pres['rut_usuario'] ?>" />
      
      <input type="hidden" name="nano" id="nano" value="<?php echo $nanio ?>" />
    Informaci&oacute;n Pr&eacute;stamo</td>
  </tr>
  <tr>
    <td width="23%">Usuario</td>
    <td width="77%"><?php if($fila_pres['tipo_usuario']==1){
		$r_us = $ob_multa->traeEmpUno($conn,$fila_pres['rut_usuario']);
	}
	elseif($fila_pres['tipo_usuario']==2){
		$r_us = $ob_multa->traeApo($conn,$fila_pres['rut_usuario']);
	}
	elseif($fila_pres['tipo_usuario']==3){
		$r_us = $ob_multa->traeAlu($conn,$fila_pres['rut_usuario']);
	}
	 $fusu = pg_fetch_array($r_us,0); ?>
     <?php echo $fusu['nombre'] ?></td>
  </tr>
 <?php  if($fila_pres['tipo_usuario']!=1){
	// $rus = $ob_devolucion->cursoUs($conn,$fila_pres['rut_usuario'],$fila_pres['tipo_usuario'],$_ANO);
	// $ic = pg_result($rus,0);
	 ?>
  <tr>
    <td>Curso</td>
    <td><?php switch($fila_pres['tipo_usuario']){
	   case 1:
	   	$tpu="EMPLEADO";
		$rus = $ob_multa->traeEmpUno($conn,$fila_pres['rut_usuario']);
		$us = strtoupper(pg_result($rus,1));
		
		$cc="-";
		
	   break;
	   case 2:
	  	$tpu="APODERADO";
		//$rus = $ob_devolucion->traeApo($conn,$fila_pres['rut_usuario']);
		//$us = strtoupper(pg_result($rus,1));
		//$rcu = $ob_devolucion->cpapo($conn,$_ANO,$fila_pres['rut_usuario']);
		//echo $cc=CursoPalabra(pg_result($rcu,1),1,$conn);
		
		
	   break;
	   case 3:
	   	$tpu="ALUMNO";
		$rus = $ob_multa->traeAlu($conn,$fila_pres['rut_usuario']);
		$us = strtoupper(pg_result($rus,1));
		$rcu=  $ob_multa->cpal($conn,$_ANO,$fila_pres['rut_usuario']);
		echo $cc=CursoPalabra(pg_result($rcu,0),1,$conn);
		
		
	   break;
	   } ?></td>
  </tr>
  <?php }?>
  
  <tr>
    <td>T&iacute;tulo</td>
    <td><?php  
	$r_tit= $ob_multa->buscaLibroCodigo($conn,$fila_pres['id_libro']);
	$f_tit = pg_fetch_array($r_tit,0);
	echo $f_tit['titulo']; ?></td>
  </tr>
  <tr>
    <td>Fecha Pr&eacute;stamo</td>
    <td><?php echo CambioFD($fila_pres['fecha_prestamo']) ?></td>
  </tr>
  <tr>
    <td>Fecha Devoluci&oacute;n</td>
    <td><?php echo CambioFD($fila_pres['fecha_devolucion']) ?></td>
  </tr>
  <tr>
    <td>D&iacute;as atraso</td>
    <td><?php echo $diasm = $dias_utiles ?>&nbsp;
    <input type="hidden" name="datraso" id="datraso" value="<?php echo $diasm ?>" /></td>
  </tr>
  <tr>
    <td>Valor Multa</td>
    <td><?php echo $valmulta = pg_result($rs_multa,2)*$diasm ?>&nbsp;
      <input type="hidden" name="mon" id="mon" value="<?php echo $valmulta ?>"  />
<input type="hidden" name="rebaja" id="rebaja" value="<?php echo $valmulta ?>" onchange="cambiovalo()"  />
    <input type="button" name="button" id="button" value="Rebaja" class="botonXX" onclick="muestrarebaja()" /></td>
  </tr>
  <tr>
    <td>Valor a pagar</td>
    <td><div id="valpago"><?php echo $valmulta ?></div></td>
  </tr>
</table>
<?
}if($funcion==7){
	$rs_pago = $ob_multa->creaMulta($conn,$_ANO,$ejm,$rutu,$datr,$mon,$pres,$nano);
	
	if($rs_pago){
	//actualizar ejemplar
//$rs_ace = $ob_devolucion->dejemplar($conn,$ejm);
//$rs_acp = $ob_devolucion->cprestamo($conn,$pres);
	echo 1;
	}
?>

<?php }?>
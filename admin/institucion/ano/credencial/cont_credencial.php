<?php require('../../../../util/header.php');

$funcion=$_POST['funcion'];

require "mod_credencial.php";
$ob_credencial = new Credencial();

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

if($funcion==1){
	
	$ntipo = ($tipo!=1)?"Curso":"Cargo";
	if($tipo==1){
	$nom="empleado";
	$rs_cur = $ob_credencial->lcargo($conn,$ins);
	}
	if($tipo==2){
	$nom="apoderado";
	$rs_cur = $ob_credencial->lcursos($conn,$ano);
	}
	if($tipo==3){
	$nom="alumno";
	$rs_cur = $ob_credencial->lcursos($conn,$ano);
	}
	
?>
<tr class="app ">
<td class="cuadro02"><?php echo $ntipo ?></td>
<td class="cuadro01">
<select id="idC" onChange="carN()">
<option value="0">Seleccione <?php echo $ntipo ?></option>
<?php for($c=0;$c<pg_numrows($rs_cur);$c++){
	$filac = pg_fetch_array($rs_cur,$c);
	
	$nc = ($tipo==1)?$filac['nombre_cargo']:CursoPalabra($filac['idc'],1,$conn);
	?>
<option value="<?php echo $filac['idc'] ?>"><?php echo $nc ?></option>
<?php }?>
</select>
</td>
</tr>
<tr class="app ">
<td class="cuadro02">Nombre <?php echo $nom  ?></td>
<td class="cuadro01">
<div id="nom">
</div>
</td>
</tr>
<?

}
if($funcion==2){
	if($tipo==1){
	$rs_nom  = $ob_credencial->nomemp($conn,$ins,$cc);
	}
	if($tipo==2){
	$rs_nom  = $ob_credencial->nomapo($conn,$cc);
	}
	if($tipo==3){
	$rs_nom  = $ob_credencial->nomalu($conn,$cc);
	}
	?>
<select id="idN">
<option value="0">TODOS</option>
<?php for($n=0;$n<pg_numrows($rs_nom);$n++){
	$fila_nom = pg_fetch_array($rs_nom,$n);
	?>
<option value="<?php echo $fila_nom['rut'] ?>"><?php echo $fila_nom['nombre'] ?></option>
<?php }?>
</select>
    <?
}
if($funcion==3){
	
	if($tipo==1){
		if($idn==0){
		$rs_nom  = $ob_credencial->nomemp($conn,$ins,$cc);
		}else{
		$tt = "emp";
		$tabla="empleado";
		$rs_nom = $ob_credencial->dato1($conn,$tt,$tabla,$idn);
		}
	}
	if($tipo==2){
		if($idn==0){
		$rs_nom  = $ob_credencial->nomapo($conn,$cc);
		}else{
		$tt = "apo";
		$tabla="apoderado";
		$rs_nom = $ob_credencial->dato1($conn,$tt,$tabla,$idn);
		}
	}
	if($tipo==3){
		if($idn==0){
		$rs_nom  = $ob_credencial->nomalu($conn,$cc);
		}
		else{
		$rs_nom = $ob_credencial->dato1alumno($conn,$idn);
		}
	}
	
$rs_col = $ob_credencial->datoColegio($conn,$ins);
$fcol = pg_fetch_array($rs_col,0);	

?>
<?php for($nn=0;$nn<pg_numrows($rs_nom);$nn++){
	$fnom = pg_fetch_array($rs_nom,$nn);
	?>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td align="right">
<div style="border-color: grey; border: 1px solid;width:321px;height:204px;">
<table style="width:321px;height:204px;" border="0" cellspacing="0" cellpadding="0" bordercolor="#FF0000">
<tr>
  <td width="2" rowspan="5" valign="top"><div style="width:8px">&nbsp;</div></td>
  <td height="50" colspan="2" valign="top" style="padding-top:7px;padding-left: 6px;"><span style="font-family:Verdana, Geneva, sans-serif; font-size:6px;padding-top:3px"><?php echo $fcol['nombreins'] ?><br>
    <?php echo $fcol['dirins'] ?><br>
    <?php echo strtoupper($fcol['nom_com']) ?></span></td>
  <td colspan="2" align="right" style="padding-top:5px"><? if(is_file("../../../../tmp/".$fcol['rdb']."insignia")){?>
    <img src="../../../../tmp/<?php echo $fcol['rdb'] ?>insignia" height="45" >
    <?
  }else{
     ?>
    <img src='../../../../menu/imag/logo.gif' >
    <? }?>
    &nbsp;&nbsp;</td>
  <td width="2" rowspan="3" align="right">&nbsp;</td>
</tr>
<tr>
  <td width="113"><? if(is_file("../../../../infousuario/images/".$fnom['rut'])){ ?>
    <img src="../../../../infousuario/images/<?php echo $fnom['rut'] ?>" style="height:3cm;width:2,4cm" >
    <?
  }else{
     ?>
    <img src="../../../../tmp/noperson.png" style="height:3cm;width:2,4cm" >
    <? }?></td>
  <td colspan="3" valign="center">
  <span style="font-family:Verdana, Geneva, sans-serif; font-size:8px;padding-top:0.5">
  <?php echo $fnom['nombre'] ?><br>
<?php echo $fnom['rut']."-".$fnom['dig_rut'] ?><br>
<?php if($tipo==2){?>
APODERADO
<?php }?>
<?php if($tipo==3){?>
ESTUDIANTE
<?php }?>
<?php if($tipo==1){
$rs_cargo = $ob_credencial->cargo1($conn,$fnom['rut'],$ins);
echo pg_result($rs_cargo,0);
 }?>
  </span>
  
  </td>
</tr>
<tr>
  <td colspan="4" align="center"></td>
  </tr>
</table>
</div>

<td align="left">
<div style="border-color: grey; border: 1px solid;width:321px;height:204px;">
<table style="width:321px;height:204px" border="0" cellspacing="0" cellpadding="0" bordercolor="#FF0000">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="8" rowspan="3" align="center">
  <span style="font-family:Verdana, Geneva, sans-serif; font-size:8px;padding-top:0.5">
  Esta credencial es personal es intransferible. Si encuentra esta tarjeta rogamos devolverla al establecimiento
  </span><br><br><br>


<img src="http://app.colegiointeractivo.cl/sae3.0/admin/institucion/ano/curso/alumno/codbarra/barcode.php?text=<?php echo $fnom['rut'] ?>&size=&amp;size=80&amp;print=true" width="209" height="63"   />
</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
</div>
</td>
</tr>
</table><br>
<?php }?>
<?

}
?>
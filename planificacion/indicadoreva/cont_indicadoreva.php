<? 
 
 
session_start();
require("../../util/header.php");
require("mod_indicadoreva.php");

$funcion = $_POST['funcion'];

$ob_indicador = new IndicadorEva();


if($funcion==1){
	$rs_ense = $ob_indicador->tipoEnse($conn);
	$rs_uni = $ob_indicador->numUni($conn);
	
	
?>
<script type="text/javascript">
$(document).ready(function(){
	
	$(".tr1").hide();
	$("#btn").hide();
  });
</script>

<table width="650" border="0" align="center" cellspacing="0">
  <tr>
    <td colspan="3" class="tableindexredondo">INDICADORES DE EVALUACI&Oacute;N</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="108" class="textonegrita">Tipo Ense&ntilde;anza</td>
    <td width="9" align="center" class="textonegrita">:</td>
    <td width="527">
   
    <select name="cmb_ense" id="cmb_ense" style="width:300px" onchange="gradoe()" class="select_redondo">
     <option value="0">seleccione...</option>
     <?php for($a=0;$a<pg_numrows($rs_ense);$a++){
		 $filae = pg_fetch_array($rs_ense,$a);
		 ?>
      <option value="<?php echo $filae['cod_tipo'] ?>">(<?php echo $filae['cod_tipo'] ?>) <?php echo $filae['nombre_tipo'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="textonegrita">Grado</td>
    <td align="center" class="textonegrita">:</td>
    <td><div id="grd"><select name="cmb_grado" id="cmb_grado" class="select_redondo">
      <option value="0">seleccione...</option>
    </select></div></td>
  </tr>
  <tr>
    <td class="textonegrita">Subsector</td>
    <td align="center" class="textonegrita">:</td>
    <td><div id="subs">
      <select name="cmb_subsector" id="cmb_subsector" class="select_redondo">
        <option value="0">seleccione...</option>
      </select>
   </div></td>
  </tr>
  <tr>
    <td class="textonegrita">Tipo</td>
    <td align="center" class="textonegrita">:</td>
    <td>
    <div id="tip">
    <select name="cmb_tipo" id="cmb_tipo" class="select_redondo">
       <option value="0">seleccione...</option>
     
    </select></div></td>
  </tr>
  <tr>
    <td class="textonegrita">Eje</td>
    <td align="center" class="textonegrita">:</td>
    <td><div id="deje">
      <select name="cmb_eje" id="cmb_eje" style="width:300px" class="select_redondo">
        <option value="0">seleccione...</option>
      </select>
   </div></td>
  </tr>
  <tr>
    <td class="textonegrita">Objetivo</td>
    <td align="center" class="textonegrita">:</td>
    <td><div id="obj">
      <select name="cmb_objetivo" id="cmb_objetivo" style="width:300px" class="select_redondo">
      <option value="0">seleccione...</option>
    </select></div></td>
  </tr>
  <tr>
    <td class="textonegrita">Unidad</td>
    <td align="center" class="textonegrita">:</td>
    <td><div id="uni">
      <select name="cmb_unidad" id="cmb_unidad" style="width:100px" class="select_redondo" >
      <option value="0">seleccione...</option>
        <?php for($u=0;$u<pg_numrows($rs_uni);$u++){
		 $filau = pg_fetch_array($rs_uni,$u);
		 ?>
      <option value="<?php echo $filau['id_ubase'] ?>"><?php echo $filau['nombre'] ?></option>
      <?php }?>
    </select></div></td>
  </tr>
  <tr class="tr1">
    <td class="textonegrita">Texto</td>
    <td align="center" class="textonegrita">:</td>
    <td>
      <textarea name="txt_ind" id="txt_ind" style="width: 293px; height: 138px;" /></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right"><input type="button" name="btn" id="btn" value="Guardar" onclick="ingresarIND();" class="botonXX" />      </td>
  </tr>
</table>
<br />
<br />
<br />


<? }
if($funcion==2){

$rs_grado = $ob_indicador->gradosense($conn,$ense);
?>
<select name="cmb_grado" id="cmb_grado" onchange="subs()" class="select_redondo">
      <option value="0">seleccione...</option>
      <?php for($i=0;$i<pg_numrows($rs_grado);$i++){
		   $fila = pg_fetch_array($rs_grado,$i);
		  ?>
       <option value="<?php echo $fila['grado'] ?>"><?php echo $fila['grado'] ?> A&Ntilde;O</option>
       <?php }?>
</select>
<?
}if($funcion==3){
	
if($_PERFIL==0){	
	 $rs_asig = $ob_indicador->listaRamoADM($conn,$ense,$grado);
	}else{
	 $rs_asig = $ob_indicador->listaRamoINS($conn,$ense,$_ANO,$grado);
	}	
?>
<select name="cmb_subsector" id="cmb_subsector" onchange="tipo()" class="select_redondo">
        <option value="0">seleccione...</option>
         <?php for($i=0;$i<pg_numrows($rs_asig);$i++){
		   $fila = pg_fetch_array($rs_asig,$i);
		  ?>
           <option value="<?php echo $fila['cod_subsector'] ?>"><?php echo $fila['nombre'] ?></option>
            <?php }?>
</select>
<?
}if($funcion==4){
	
	 $rs_asig = $ob_indicador->BuscarEje($conn,$subs,$tipo,$_INSTIT);
	 ?>
     <select name="cmb_eje" id="cmb_eje" onchange="obje()" style="width:300px" class="select_redondo">
        <option value="0">seleccione...</option>
          <?php for($t=0;$t<pg_numrows($rs_asig);$t++){
		   $filat = pg_fetch_array($rs_asig,$t);
		  ?>
     <option value="<?php echo $filat['id_eje'] ?>"><?php echo $filat['texto'] ?></option>
     <?php }?>
</select>
     <?
	
}
if($funcion==5){
	$rs_tipo = $ob_indicador->listaTipoObj($conn);
	?>
<select name="cmb_tipo" id="cmb_tipo" onchange="eje()" style="width:300px" class="select_redondo">
      <?php for($t=0;$t<pg_numrows($rs_tipo);$t++){
		   $filat = pg_fetch_array($rs_tipo,$t);
		  ?>
     <option value="<?php echo $filat['id_objetivo'] ?>"><?php echo $filat['nombre'] ?></option>
     <?php }?>
     
</select>
    <?
}
if($funcion==6){
$rs_tipo = $ob_indicador->listaObj($conn,$tipo,$eje,$grado,$ense);
?>
<select name="cmb_objetivo" id="cmb_objetivo" style="width:300px" onchange="lista();NuevoInd()" class="select_redondo">
      <option value="0">seleccione...</option>
       <?php for($t=0;$t<pg_numrows($rs_tipo);$t++){
		   $filat = pg_fetch_array($rs_tipo,$t);
		  ?>
     <option value="<?php echo $filat['id_obj'] ?>"><?php echo $filat['codigo'] ?></option>
     <?php }?>
</select>
<?
}

if($funcion==8){
	

$rdb = ($_PERFIL==0)?0:$_INSTIT;	
	
$rs_ing = $ob_indicador->guardaInd($conn,$eje,$obj,$rdb,$txt,$_ID_BASE,$uni);
if($rs_ing){
	echo 1;
}else
{
	echo 0;
}
	
}
if($funcion==9){
//show($_POST);
$rs_listado =$ob_indicador->listado($conn,$eje,$obj,$_INSTIT,$uni);
?><br />
<br />

<table width="870" border="0" class="cajaborde">
         <tr><td>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="3" >
  <tr class="cuadro02" style="height:20px">
    <td height="31" >&nbsp;&nbsp;Nombre Indicador</td>
    <td height="31" align="center" >Unidad</td>
    <td height="31" colspan="3" >&nbsp;</td>
    </tr>
 <?php  for($i=0;$i<pg_numrows($rs_listado);$i++){
	$fila = pg_fetch_array($rs_listado,$i); 
	
	
	 ?>
  <tr class="">
    <td width="414" class="cuadro01 tablaredonda">&#8226; &nbsp;<?php echo nl2br(htmlentities($fila['texto'])) ?></td>
    <td width="105" align="center" class="cuadro01 tablaredonda"> Unidad <?php echo $fila['id_ubase'] ?></td>
    <td width="37" align="center" class="cuadro01 tablaredonda"><img src="../../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onclick="elimina(<?php echo $fila['id_indicador'] ?>)" /></td>
    <td width="37" align="center" class="cuadro01 tablaredonda"><img src="../../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/edit.png" width="24" height="24" onclick="edita(<?php echo $fila['id_indicador'] ?>)" /></td>
    <td width="39" align="center" class="cuadro01 tablaredonda"><img src="../../admin/clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Load.png" width="24" height="24" onclick="replica(<?php echo $fila['id_indicador'] ?>)"/></td>
  </tr>
  <?php }?>
</table>
</td></tr></table>
<?
}if($funcion==10){
	
$rs_eli = $ob_indicador->borraInd($conn,$id,$_ID_BASE);
if($rs_eli){
	echo 1;
}else
{
	echo 0;
}
}
if($funcion==11){

$rs_uni = $ob_indicador->numUni($conn);
$rs_pla = $ob_indicador->buscaPlani($conn,$id);
$f_pla=pg_fetch_array($rs_pla,0);
?>
<table width="90%" border="0">
  <tr>
    <td><input type="checkbox" name="uni1" id="uni1" <?php echo ($f_pla['id_ubase']==1)?"disabled":""; ?> /> 
    Unidad 1</td>
    <td><input type="checkbox" name="uni5" id="uni5" <?php echo ($f_pla['id_ubase']==5)?"disabled":""; ?>/>
    Unidad 5</td>
    <td><input type="checkbox" name="uni9" id="uni9" <?php echo ($f_pla['id_ubase']==9)?"disabled":""; ?>/>
    Unidad 9</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="uni2" id="uni2" <?php echo ($f_pla['id_ubase']==2)?"disabled":""; ?>/>
    Unidad 2</td>
    <td><input type="checkbox" name="uni6" id="uni6" <?php echo ($f_pla['id_ubase']==6)?"disabled":""; ?>/>
    Unidad 6</td>
    <td><input type="checkbox" name="uni10" id="uni10" <?php echo ($f_pla['id_ubase']==10)?"disabled":""; ?>/>
    Unidad 10</td>
  </tr>
  <tr>
    <td><input type="checkbox" name="uni3" id="uni3" <?php echo ($f_pla['id_ubase']==3)?"disabled":""; ?>/>
    Unidad 3</td>
    <td><input type="checkbox" name="uni7" id="uni7" <?php echo ($f_pla['id_ubase']==7)?"disabled":""; ?>/>
    Unidad 7</td>
    <td><input type="hidden" name="iduni" id="iduni" value="<?php echo $id; ?>" /></td>
  </tr>

  <tr> </tr>
  <tr>
    <td><input type="checkbox" name="uni4" id="uni4" <?php echo ($f_pla['id_ubase']==4)?"disabled":""; ?>/>
    Unidad 4</td>
    <td><input type="checkbox" name="uni8" id="uni8" <?php echo ($f_pla['id_ubase']==8)?"disabled":""; ?>/>
    Unidad 8</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?
}
if($funcion==12){
//buscar planificacion que se va a copiar
 $rs_cp = 	$ob_indicador->buscaPlani($conn,$idun);
 $fila_cp=pg_fetch_array($rs_cp,0);

$id_eje = $fila_cp['id_eje'];
$id_obj = $fila_cp['id_obj'];
$texto = utf8_decode($fila_cp['texto']);
$ubase = utf8_decode($fila_cp['id_ubase']);
$rdb = ($_PERFIL==0)?0:$_INSTIT;

//show($_POST);
	for($i=1;$i<11;$i++){
		if($_POST["uni".$i]!=0 && $_POST["uni".$i]!=$ubase){
		$unidad=$_POST["uni".$i];
		 
		// $sql="insert into planificacion.inidicador_evaluacion (id_eje,id_obj,rdb,texto,id_ubase) values($id_eje,$id_obj,$rdb,'$texto',$id_ubase)";
		$rs_guarda = $ob_indicador->copiaInd($conn,$id_eje,$id_obj,$rdb,$texto,$unidad,$_ID_BASE);
		 
		}
	}
	echo 1;
}
if($funcion==13){
	//show($_POST);
	 $rs_cp = 	$ob_indicador->buscaPlani($conn,$id);
 $fila_cp=pg_fetch_array($rs_cp,0);
 ?>
 <table width="100%" border="0">
  <tr>
    <td>Texto</td>
    <td><textarea name="txt_edi" id="txt_edi" style="width: 293px; height: 138px;"><?php echo $fila_cp['texto'] ?>
    </textarea>
      <input type="hidden" name="iduedi" id="iduedi" value="<?php echo $id; ?>" />   
    </td>
  </tr>
</table>

 <?
}
if($funcion==14){
//show($_POST);
$rs_guarda = $ob_indicador->modtxtPlani($conn,$id,utf8_decode($txt),$_ID_BASE);
echo ($rs_guarda)?1:0;
}
?>

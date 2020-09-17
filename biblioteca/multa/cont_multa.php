<?php 
session_start();
require("../../util/header.php");
 require("mod_multa.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_multa = new Multa();
 
 if($funcion==1){
$rs_listado = $ob_multa->traeMulta($conn,$_INSTIT);
$fila = pg_fetch_array($rs_listado,0);
$ac= (pg_numrows($rs_listado)==0)?0:1;
?>
<script>
$( document ).ready(function() {
    
	$('.solo-numero').keyup(function (){
			this.value = (this.value + '').replace(/[^0-9]/g, '');			
		  });
});
</script>
<table width="85%" border="0" align="center">
      <tr>
        <td colspan="3" align="center" class="titulos-respaldo"><p>CONFIGURACI&Oacute;N MULTAS</p></td>
  </tr>
        <tr>  
          <td width="22%" align="right">&nbsp;</td>
          <td width="4%" align="right">&nbsp;</td>
          <td width="74%" align="right" class="textosimple">&nbsp;</td>
      </tr>  
        <tr>
          <td class="cuadro02">MONTO MULTA</td>
          <td align="center" class="cuadro02">:</td>
          <td align="left"><input type="text" name="monto" id="monto" class="solo-numero"  value="<?php echo $fila['monto'] ?>" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
  </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="right"><input type="button" name="button" id="button"  value="GUARDAR DATOS" onclick="guarda(<?php echo $ac ?>)" />&nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button"  value="ELIMINAR CONFIGURACI&Oacute;N" onclick="elimina()" /></td>
        </tr>
    </table>
<? 
}
if($funcion==2){
	//show($_POST);
if($tipo==0){
	$rs=$ob_multa->guardaMulta($conn,$_INSTIT,intval($monto));
}
if($tipo==1){
	$rs=$ob_multa->cambiaMulta($conn,$_INSTIT,intval($monto));
}
}


if($funcion==3){
$rs = $ob_multa->quitaMulta($conn,$_INSTIT);
if(!$rs){echo 0;}else{echo 1;}
}

?>
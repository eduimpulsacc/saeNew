<?php 
session_start();
require("../../util/header.php");
 require("mod_restriccion.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_restriccion = new Restriccion();
 
 if($funcion==1){
$rs_listado = $ob_restriccion->traeRes($conn,$_INSTIT);
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
<table width="95%" border="0">
      <tr>
        <td colspan="3" align="center" class="titulos-respaldo"><p>RESTRICCIONES SISTEMA</p></td>
  </tr>
        <tr>  
          <td width="22%" align="right">&nbsp;</td>
          <td width="4%" align="right">&nbsp;</td>
          <td width="74%" align="right" class="textosimple">(*: Sin l&iacute;mite, debe digitar &quot;0&quot;)</td>
      </tr>  
        <tr>
          <td class="cuadro02">L&iacute;mite Renovaciones*</td>
          <td align="center" class="cuadro02">:</td>
          <td align="left"><input type="text" name="lim_reno" id="lim_reno" class="solo-numero"  value="<?php echo $fila['lim_renovacion'] ?>" /></td>
        </tr>
        <tr>
          <td class="cuadro02">L&iacute;mite Pr&eacute;stamos*</td>
          <td align="center" class="cuadro02">:</td>
          <td align="left"><input type="text" name="lim_pres" id="lim_pres" class="solo-numero" value="<?php echo $fila['lim_prestamo'] ?>"/></td>
        </tr>
        <tr>
          <td class="cuadro02">L&iacute;mite Reservas*</td>
          <td align="center" class="cuadro02">:</td>
          <td align="left"><input type="text" name="lim_rese" id="lim_rese" value="<?php echo $fila['lim_reservas'] ?>"/></td>
        </tr>
        <tr>
          <td class="cuadro02">D&iacute;as bloqueo por d&iacute;a de atraso</td>
          <td align="center" class="cuadro02">&nbsp;</td>
          <td align="left"><input type="text" name="lim_diasbloqueo" id="lim_diasbloqueo" value="<?php echo $fila['lim_diasbloqueo'] ?>"/></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="right">&nbsp;</td>
  </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right">&nbsp;</td>
          <td align="right"><input type="button" name="button" id="button"  value="GUARDAR DATOS" onclick="guarda(<?php echo $ac ?>)" /></td>
        </tr>
    </table>
<? 
}
if($funcion==2){

if($tipo==0){
	$rs=$ob_restriccion->guardaRes($conn,$_INSTIT,intval($lim_reno),intval($lim_pres),intval($lim_rese),intval($lim_diasbloqueo));
}
if($tipo==1){
	$rs=$ob_restriccion->cambiaRes($conn,$_INSTIT,intval($lim_reno),intval($lim_pres),intval($lim_rese),intval($lim_diasbloqueo));
}

}
?>
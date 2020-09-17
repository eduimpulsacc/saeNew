<?php 
session_start();
require('../../../../util/header.inc');
 require("mod_duplica.php");
 
 $funcion=$_POST['funcion'];
$obj_duplica = new Duplica();


if($funcion==1){
$resultEns = $obj_duplica->ense($conn,$_INSTIT);
?>
 <script>
 $( document ).ready(function() {
    $("#marcarTodo").click(
			function() {
				var marcado = $("#marcarTodo").is(":checked");
 
				if(!marcado)
					$(".chh :checkbox").attr('checked',true);
				else
					$(".chh :checkbox").attr('checked', false);
			}
		);
});
 </script>
<input type="hidden" name="plan" id="plan" value="<?php echo $plantilla ?>">
<table width="90%" border="1">
  <tr>
    <td width="16%">Tipo De Ense&ntilde;anza</td>
    <td> 	<select name="cmbEns" id="cmbEns" onChange="tipense(this.value)">
            <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
            <?php
            
            for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
            $filaEns=pg_fetch_array($resultEns,$cEns);
            ?>
            <option value="<?php echo $filaEns['cod_tipo'] ?>"><?php echo $filaEns['nombre_tipo'] ?></option>
           <? 
		   }//fin for
            
            ?>
            </select>
     </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Grado</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div id="com"></div></td>
  </tr>
</table>

<?
}
if($funcion==2){
if($cbe>0){
		?>

<table width="100%" border="0">
<tr class="textosesion">
<td><input name="pa" type="checkbox" id="pa" value="1" class="chh">
PRIMER A&Ntilde;O</td>
<td><input name="sa" type="checkbox" id="sa" value="1" class="chh">
SEGUNDO A&Ntilde;O </td>
<td><input name="ta" type="checkbox" id="ta" value="1" class="chh">
TERCER A&Ntilde;O </td>
<td><input name="cu" type="checkbox" id="cu" value="1" class="chh">
CUARTO A&Ntilde;O </td>
</tr>
<tr class="textosesion">
<td><input name="qu" type="checkbox" id="qu" value="1" class="chh">
QUINTO A&Ntilde;O</td>
<td><input name="sx" type="checkbox" id="sx" value="1" class="chh">
SEXTO A&Ntilde;O</td>
<td><input name="sp" type="checkbox" id="sp" value="1" class="chh">
SEPTIMO A&Ntilde;O</td>
<td><input name="oc" type="checkbox" id="oc" value="1" class="chh">
OCTAVO A&Ntilde;O</td>
</tr>
<tr class="textosesion">
<td><input name="nv" type="checkbox" id="nv" value="1" class="chh">
NOVENO A&Ntilde;O</td>
<td><input name="dc" type="checkbox" id="dc" value="1" class="chh">
DECIMO A&Ntilde;O</td>
<td><input name="un" type="checkbox" id="un" value="1" class="chh">
UNDECIMO A&Ntilde;O</td>
<td><input name="duo" type="checkbox" id="duo" value="1" class="chh">
DUODECIMO A&Ntilde;O</td>
</tr>
<tr class="textosesion">
<td><input name="tre" type="checkbox" id="tre" value="1" class="chh">
DECIMO TERCER A&Ntilde;O</td>
<td><input name="cat" type="checkbox" id="cat" value="1" class="chh">
DECIMO CUARTO A&Ntilde;O</td>
<td><input name="quince" type="checkbox" id="quince" value="1" class="chh">
DECIMO QUINTO A&Ntilde;O</td>
<td><input name="diezseis" type="checkbox" id="diezseis" value="1" class="chh">
DECIMO SEXTO A&Ntilde;O</td>
</tr>

                <tr class="textosesion">
                                        <td><input name="diecisiete" type="checkbox" id="diecisiete" value="1">
                            DECIMO SEPTIMO A&Ntilde;O</td>
                                        <td><input name="dieciocho" type="checkbox" id="dieciocho" value="1">
                            DECIMO OCTAVO A&Ntilde;O</td>
                                        <td><input name="diecinueve" type="checkbox" id="diecinueve" value="1">
                            DECIMO NOVENO A&Ntilde;O</td>
                                        <td><input name="veinte" type="checkbox" id="veinte" value="1">
VIG&Eacute;SIMO A&Ntilde;O</td>
                                      </tr>
                 <tr class="textosesion">
                                        <td><input name="veintiuno" type="checkbox" id="veintiuno" value="1">
                            VIG&Eacute;SIMO PRIMER A&Ntilde;O</td>
                                        <td><input name="veintidos" type="checkbox" id="veintidos" value="1">
                            VIG&Eacute;SIMO SEGUNDO A&Ntilde;O</td>
                                        <td><input name="veintitres" type="checkbox" id="veintitres" value="1">
                            VIG&Eacute;SIMO TERCER A&Ntilde;O</td>
                                        <td><input name="veinticuatro" type="checkbox" id="veinticuatro" value="1">
                                          VIG&Eacute;SIMO CUARTO  A&Ntilde;O</td>
                                      </tr>    <tr class="textosesion">
                                        <td><input name="veinticinco" type="checkbox" id="veinticinco" value="1">
VIG&Eacute;SIMO  QUINTO A&Ntilde;O</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
</table>
           
			
		<?
	
	
	}
}if($funcion==3){
	
$rs_plan=$obj_duplica->traePlantilla($conn,$plantilla);
$rs_max=$obj_duplica->traeMax($conn);
$max = (pg_result($rs_max,0)+1);

$fila_plan =pg_fetch_array($rs_plan,0);
$nombre=$fila_plan['nombre'];
$activa=$fila_plan['activa'];
$orientacion=$fila_plan['orientacion'];
$titulo_informe1=$fila_plan['titulo_informe1'];
$titulo_informe2=$fila_plan['titulo_informe2'];
$tipo=$fila_plan['tipo'];
$nuevo_sis=$fila_plan['nuevo_sis'];
$rdb=$fila_plan['rdb'];




$rs_gua = $obj_duplica->guardaPlantilla($conn,$max,$plantilla,$pa,$sa,$ta,$cu,$qu,$sx,$sp,$oc,$nv,$dc,$un,$duo,$tre,$cat,$quince,$diezseis,$tipo_ensenanza,trim($nombre),$activa,intval($orientacion),trim($titulo_informe1),trim($titulo_informe2),$nuevo_sis,$tipo,$rdb,$diecisiete,$dieciocho,$diecinueve,$veinte,$veintiuno,$veintidos,$veintitres,$veinticuatro,$veinticinco);

if($rs_gua){
echo 1;
}else{
echo 0;
}

}


?> 
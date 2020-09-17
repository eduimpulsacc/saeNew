<?

require('../../../../../util/header.inc');

$institucion = $_REQUEST[institucion];
$ano = $_REQUEST[ano];
$nombreusuario = $_REQUEST[nombreusuario];

?>

<!--<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>-->

<script type="text/javascript" language="javascript">

	$(function() {
		$( "#tabs" ).tabs();
	});
	
	
	$(document).ready(function(){			
	$("#txtFECHA2").datepicker({
		showOn: 'both',
		//changeYear:true,
		changeMonth:true
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
		
		
	$(document).ready(function(){			
	$("#txtFECHA3").datepicker({
		showOn: 'both',
		//changeYear:true,
		changeMonth:true
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})		
	
	
	$(document).ready(function(){			
	$("#txtFECHA").datepicker({
		showOn: 'both',
		//changeYear:true,
		changeMonth:true
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
	


	$("input:radio").click(function() {
    
	  if ( $(this).is(':checked') )
          
		  var x = $(this).val();
		  
		  switch (x) {
          case '1':
			  var H ="Tipo Conducta:&nbsp;POSITIVA:<input name='tipo_conducta' type='radio' value='1'>";
				  H = H+"NEGATIVA:<input name='tipo_conducta' type='radio' value='2'>";  
			   $("#tipoconducta").html(H);
			   break;
		  case '2':
			  var H = "Hora Atraso&nbsp;(HH:MM):&nbsp;";
				  H = H+"<input name='txtHORAS2' type='text' size='4' maxlength='5'>"
			   $("#tipoconducta").html(H);
			   break;
          case '3':
           
		   $("#tipoconducta").html("&nbsp;");
		   break;
             
            }
   	     
		 });

</script>
<form name="Formulariolista" id="Formulariolista">


<div id="tabs" style="width:700px; margin: 20px auto 0 auto;" >

	<ul>
		<li><a href="#codigo">codigo</a></li>
		<li><a href="#seleccion">seleccion</a></li>
		<li><a href="#tradicional">tradicional</a></li>
		<li><a href="#masivo">masivo</a></li>
	</ul>


<div id="codigo">

  <table class="textonegrita">
    <tr>
      <td><div align="left">
        <input 
	  name="btnGuardar1" type="button" class="botonXX" id="btnGuardar1" onclick="guardar1()" 
	  value="GUARDAR" />
        &nbsp;
        <input name="button2"  type="button" class="botonXX" 
		onclick="window.history.go(-1)" value="VOLVER" />
        <br />
      </div></td>
    </tr>
    <tr>
      <td nowrap="nowrap" class="textonegrita" ><div align="left">CODIGO DE ANOTACION </div></td>
      <td>
	  <table border="0" align="left" cellpadding="3" cellspacing="0">
          <tr>
            <td><div align="center" class="textonegrita" >
              <div align="left">SIGLA</div>
            </div></td>
            <td><div align="center"></div></td>
            <td><div align="center" >CODIGO</div></td>
          </tr>
          <tr>
            <td><label> </label>

                  <div align="left">
                    <input name="sigla2" type="text" id="sigla2" size="10" />
                    <span >(*)</span></div></td>
            <td><div align="center">-</div></td>
            <td><label> </label>

              <div align="left">
                <input name="codigo2" type="text" id="codigo2" size="10" />
                <span >(*)</span></div></td>
          </tr>
      </table></td>
      </tr>
    <tr>
      <td nowrap="nowrap" ><div align="left"><font face="Geneva, Arial, Helvetica" color=#000000>NOMBRE RESPONSABLE</font></div></td>
      <td nowrap="nowrap" ><?

$q200 = "select DISTINCT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat 
         from empleado,trabaja 
		 where empleado.rut_emp = trabaja.rut_emp 
		 and trabaja.rdb =".$institucion." 
		 AND trabaja.rut_emp not in(7717287,11850353,4818331,14051464,13270730,16008794,
		 13561508,14166024,10425397,13689507,5924397,11653768,12657018,8434778,7051273,16986896) ORDER 
		 BY empleado.nombre_emp ASC";

									  //echo $q200;

									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
          <div align="left">
            <select name="tipo_responsable2" id="tipo_responsable2" >
              <option value="0">Seleccione Responsable </option>
              <?									
    	$k = 0;
		while ($k < $n200){
		$f200 = pg_fetch_array($r200,$k);
        $rut_emp = $f200['rut_emp'];
		$nombre = $f200['nombre_emp'];
		$ape=$f200['ape_pat'];
			?>
              <option value="<?=$rut_emp ?>"><? echo "$nombre"." "."$ape"; ?></option>
              <?
		$k++;
		}						  
?>
              </select>
          </div></td>
    </tr>
    <tr>
      <td nowrap="nowrap" ><div align="left">PERIODO</div></td>
      <td nowrap="nowrap" ><div align="left">
        <select id="cmb_periodos2" name="cmb_periodos2" class="ddlb_9_x Estilo2">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
	$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano;
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		{
		$fila1 = @pg_fetch_array($result_peri,$i); 
		 if ($fila1['id_periodo']==$cmb_periodos)
	echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
	else
	echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
 } ?>
        </select>
        <span >(*)</span></div></td>
    </tr>
    <tr>
      <td nowrap="nowrap" ><div align="left">FECHA</div></td>
      <td nowrap="nowrap" ><div align="left">
        <input type="text" name="txtFECHA2" id="txtFECHA2" readonly="readonly" size="11" maxlength="11" />
        <span class="textosimple">(*)</span> <br />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">OBSERVACI&Oacute;N</div></td>
      <td><textarea name="txtOBS2" id="txtOBS2" cols="40" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="center" class="Estilo13">(*) Datos obligatorios </div></td>
    </tr>
  </table>
</div> 
<!--PRIMER DIV-->



<div id="seleccion">  <!--SEGUNDO DIV-->
<table class="textonegrita" >
<tr nowrap="nowrap">
<td>
  <div align="left">
  <input name="btnGuardar2" type="button" class="botonXX" id="btnGuardar2" 
onClick="guardar2()" value="GUARDAR">
  &nbsp;
  <input class="botonXX" type="button" value="VOLVER" onClick="window.history.go(-1)">
  <br>
  </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">PERIODO</div></td>
<td nowrap="nowrap" >
	<div align="left">
	  <select name="cmb_periodos3" id="cmb_periodos3" class="ddlb_9_x Estilo2">
	    <option value=0 selected>(Seleccione Periodo)</option>
	    <?
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
	{
	$fila1 = @pg_fetch_array($result_peri,$i); 
	
	if ($fila1['id_periodo']==$cmb_periodos)
	echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
	else
	echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
	 } 	?>
	    </select> 
	  <span class="Estilo7">(*)</span>
    </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">SECTOR DE APRENDIZAJE </div></td>
<td nowrap="nowrap" >
	<div align="left">
	  <?
	$q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
	$r100 = pg_Exec($conn,$q100);
	$n100 = pg_numrows($r100);
	?> 
	  <select name="sigla_subsector" id="sigla_subsector">
	    <option value="0">Seleccione Sector de Aprendizaje </option>
	    <?
	  $j = 0;
	  while ($j < $n100){
		$f100 = pg_fetch_array($r100,$j);
		$sigla    = $f100['sigla'];
		$detalle  = $f100['detalle'];
		$id_sigla = $f100['id_sigla'];
			?>
	     <option value="<?=$id_sigla ?>" 
	<? if ($sigla_subsector==$id_sigla) { ?> selected="selected" <? } ?> 
	 ><? echo substr($detalle,0,15);  ?></option>
	    <?
			$j++;
				}
	 ?>									
	    </select>
	  <span class="Estilo7">(*)</span>
    </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">TIPO ANOTACION </div></td>
<td nowrap="nowrap">
	<div align="left">
	  <?
	$q200 = "select * from tipos_anotacion where rdb = '$institucion'";
	$r200 = pg_Exec($conn,$q200);
	$n200 = pg_numrows($r200);								 
		 ?>
	  <select name="tipo_anotacion" onChange="enviapag3(this.form);" id="tipo_anotacion">
	    <option value="0">Seleccione Tipo de Anotaci&oacute;n </option>
	    <?									
	$k = 0;
	while ($k < $n200){
		$f200 = pg_fetch_array($r200,$k);
		$id_tipo = $f200['id_tipo'];
		$codtipo = $f200['codtipo'];
		$descripcion = $f200['descripcion'];
			?>
	    <option value="<?=$id_tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> >
	      <? echo "$codtipo -"; echo substr($descripcion,0,15); ?></option>
	    <? $k++; }  ?>
	    </select>
	  <span class="Estilo7">(*)</span>
    </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">SUB TIPO </div></td>
<td nowrap="nowrap" >
<div id="SubTipo">
    <div align="left">
      <select name="detalle_anotaciones" id="detalle_anotaciones">
        <option value="0">Seleccione Sub-Tipo</option>
      </select>
      <span class="Estilo7">(*)</span>
    </div>
</div>	
</td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">NOMBRE RESPONSABLE </div></td>
<td nowrap="nowrap" >
  <div align="left">
    <?
  $q200 = "select distinct empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja 
  where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." ORDER BY 
  empleado.nombre_emp  ASC";
		//if($_PERFIL==0) echo $q200;
		$r200 = pg_Exec($conn,$q200);
		$n200 = pg_numrows($r200);								 
				 ?>
    <select name="tipo_responsable" id="tipo_responsable">
           <option value="0">Seleccione Responsable </option>
      <?									
			$k = 0;
			while ($k < $n200){
				$f200 = pg_fetch_array($r200,$k);
				$rut_emp = $f200['rut_emp'];
				$nombre = $f200['nombre_emp'];
				$ape=$f200['ape_pat'];
					?>
           <option value="<?=$rut_emp ?>"><? echo "$nombre"." "."$ape"; ?></option>
       <? $k++; }  ?>
    </select>
    <span class="Estilo7">(*)</span>
  </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">FECHA</div></td>
<td nowrap="nowrap" >
  <div align="left">
    <INPUT type="text" name="txtFECHA3" id="txtFECHA3" readonly="readonly" size=11 maxlength=11>
    <span class="Estilo7">(*)</span>
  </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">OBSERVACI&Oacute;N</div></td>
<td nowrap="nowrap" >
  <div align="left">
    <textarea name="txtOBS3" cols="40" rows="5" id="txtOBS3"></textarea>
  </div></td>
</tr>
<tr>
<td colspan="2"><div align="center" class="Estilo13">(*) Datos obligatorios </div></td>
</tr>  
</table>

</div>  <!--SEGUNDO DIV-->
	


<div id="tradicional"> <!--TERCER DIV-->

<table width="463" class="textonegrita" >  

<tr>
<td>
  <div align="left">
  <input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="valida4(this.form);" >
  &nbsp;
  <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)">
  <br>
  <br>
  </div></td>
</tr>
<tr>
	<td>
	  <div align="left">Responsable : <? 
	  
	  $sql = "SELECT empleado.rut_emp,
	upper((empleado.nombre_emp || cast('  ' as varchar )|| empleado.ape_pat)) as nombre 
    FROM empleado where empleado.rut_emp = $nombreusuario";
		
		$r = pg_Exec($conn,$sql);
		$n = pg_numrows($r);
		if ($n != "") $f = pg_fetch_array($r,0);
		$nombreus = $f['nombre'];
	  
	  echo $nombreus;?> 
	        <input type="hidden" name="usuarioactual" id="usuarioactual" value="<?=$nombreus;?>">	
	    </div></td>
</tr>
	<tr>
		<td>
		  <div align="left">PERIODO:&nbsp;
		      <select name="cmb_periodos" class="ddlb_9_x" id="cmb_periodos">
		        <option value=0 selected>(Seleccione Periodo)</option>
		        <?
	  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
	  {
	  $fila1 = @pg_fetch_array($result_peri,$i); 
	  if ($fila1['id_periodo']==$cmb_periodos)
	  echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
	  else
	  echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		} ?>
	            </select>
	        </div></td>
	</tr>
<tr>
<td>
  <div align="left">FECHA :&nbsp; 
      <input type="text" name="txtFECHA" id="txtFECHA" size=11 maxlength=11 />
  </div></td>
</tr>
<tr>
<td>
  <div align="left">TIPO ANOTACION</div></td>
</tr>
<tr>
<td>
  <div align="left">
    <input type="radio" value="1" name="rdTIPO" id="rdTIPO1" >
    CONDUCTA
  <input type="radio" value="2" name="rdTIPO" id="rdTIPO2" >
    ATRASO
  <input type="radio" value="3" name="rdTIPO" id="rdTIPO3" >
    RESPONSABILIDAD</div></td>
</tr>
<tr>
<td>
<div id="tipoconducta">
&nbsp;
<div align="left"></div>
</div></td>
</tr>
<tr>
<td ><div align="left">OBSERVACION:<br>
      <textarea name="txtOBS" cols="60" rows="5"><?=trim($fila['observacion'])?>
    </textarea>
</div></td>
</tr>
</table>

</div> <!--TERCER DIV-->


<div id="masivo"> <!--CUARTO DIV-->

<table border="1" style="border-collapse:collapse" class="textonegrita" >
<tr>
<td colspan="7" class="Estilo14">INGRESO MASIVO POR SELECCI&Oacute;N <br>
<input name="oculto" type="hidden" id="oculto" value="0"></td>
</tr>
<tr>
<td width="134" >FECHA</td>
<td width="74" >PER&Iacute;ODO</td>
<td width="170" >SECTOR APRENDIZAJE </td>
<td width="109" >RESPONSABLE</td>
</tr>
<?
	for ($iii=0; $iii < 10; $iii++){
    $txtFechadesde       = $_POST['txtFechadesde'.$iii];
	$cmb_periodos        = $_POST['cmb_periodos'.$iii];
	$sigla_subsector     = $_POST['sigla_subsector'.$iii];
	$tipo_responsable    = $_POST['tipo_responsable'.$iii];
	$tipo_responsable    = $_POST['tipo_responsable'.$iii];
	$tipo_anotacion      = $_POST['tipo_anotacion'.$iii];
	$detalle_anotaciones = $_POST['detalle_anotaciones'.$iii];
	$observaciones       = $_POST['observaciones'.$iii];								
	                            
?>															
<tr>
<td>
<input type="text" name="txtFechadesde<?=$iii?>" id="txtFechadesde<?=$iii?>" size="8" maxlength="10" readonly="true" class="ingreso" value="<?=$txtFechadesde?>" />
<input name="button" type="button" class="botadd" id="txtFecha_btn<?=$iii?>" value="." /></td>
<td>
<select name="cmb_periodos<?=$iii?>" >
<option value="0" selected="selected">...</option>
<?			
	 for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
		$fila1 = @pg_fetch_array($result_peri,$i); 
		if ($fila1['id_periodo']==$cmb_periodos){
echo  "<option selected value=".$fila1["id_periodo"]." ><font style='font-size:6px'>".substr($fila1['nombre_periodo'],0,10)."</font></option>";
		}else{
		echo  "<option value=".$fila1["id_periodo"]." ><font style='font-size:6px'>".substr($fila1['nombre_periodo'],0,10)."</font></option>";
			}	
	 } ?>
 </select>
 </td>
<td>
<?
$q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
$r100 = pg_Exec($conn,$q100);
$n100 = pg_numrows($r100);
 ?>
<select name="sigla_subsector<?=$iii?>">
 <option value="0">...</option>
   <?							
	$j = 0;
	while ($j < $n100){
	$f100 = pg_fetch_array($r100,$j);
	$sigla    = $f100['sigla'];
	$detalle  = $f100['detalle'];
	$id_sigla = $f100['id_sigla'];
	 ?>
<option value="<?=$id_sigla ?>" <? if ($sigla_subsector==$id_sigla){ ?> selected="selected" <? } ?> >
<? echo substr($detalle,0,15);  ?></option>
   <?
	 $j++;
		}								  
	?>
</select>
</td>
<td>
<?
								 /* $q200 = "select empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion;*/
									 
   $q200 = "select DISTINCT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja   where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." AND trabaja.rut_emp not   
in(7717287,11850353,4818331,14051464,13270730,16008794,13561508,14166024,10425397,13689507,5924397,11653768,8434778,7051273,16986896) ORDER BY empleado.ape_pat ASC";
									 
	 //echo $q200;
									 
	$r200 = pg_Exec($conn,$q200);
	$n200 = pg_numrows($r200);								 
	 ?>
<select name="tipo_responsable<?=$iii?>">
<option value="0">...</option>
   <?									
	$k = 0;
	while ($k < $n200){
	$f200 = pg_fetch_array($r200,$k);
    $rut_emp = $f200['rut_emp'];
	$nombre = $f200['nombre_emp'];
	$ape=$f200['ape_pat'];
	 ?>
<option value="<?=$rut_emp ?>" <? if ($tipo_responsable==$rut_emp){ ?> selected="selected" <? } ?>><? echo substr($ape,0,10); echo substr($nombre,0,8); ?></option>
   <?
	$k++;
		 }								    
	?>
</select>
</td>
</tr>
<tr>
<td>TIPO ANOTACI&Oacute;N</td>
<td>SUB-TIPO</td>
<td>OBSERVACI&Oacute;N</td>
                            
</tr>
<tr>
<td><label>
<script type="text/javascript">
	Calendar.setup({
		inputField     :    "txtFechadesde<?=$iii?>",      // id of the input field
		ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
		button         :    "txtFecha_btn<?=$iii?>",  // trigger button (well, IMG in our case)
		align          :    "Bl",           // alignment (defaults to "Bl")
		singleClick    :    true,
		mondayFirst	   :    true
									});
</script>
<?									
	$q200 = "select * from tipos_anotacion where rdb = '$institucion'";
	$r200 = pg_Exec($conn,$q200);
	$n200 = pg_numrows($r200);								 
 ?>
 <select name="tipo_anotacion<?=$iii?>" onchange="enviapag4(this.form);">
 <option value="0">...</option>
   <?								
		$k = 0;
		while ($k < $n200){
		$f200 = pg_fetch_array($r200,$k);
        $id_tipo = $f200['id_tipo'];
		$codtipo = $f200['codtipo'];
		$descripcion = $f200['descripcion'];
			?>
 <option value="<?=$id_tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> >
 <? echo "$codtipo -"; echo substr($descripcion,0,15); ?></option>
       <?
			 $k++;
			  }								    
			 ?>
 </select>
</label></td>
<td><label>
<?					
$q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' order by codigo";
	$r300 = @pg_Exec($conn,$q300);
	$n300 = @pg_numrows($r300);
								    ?>
  <select name="detalle_anotaciones<?=$iii?>">
  <option value="0">...</option>
  <?															  
	$l = 0;
	while ($l < $n300){
	$f300 = pg_fetch_array($r300,$l);
	$codigosubtipo  = $f300['codigo'];
	$detallesubtipo = $f300['detalle'];
											   
	if ($codigosubtipo!=NULL){
		?>
  <option value="<?=$codigosubtipo?>" <? if ($detalle_anotaciones==$codigosubtipo){?> selected="selected" <? } ?>>
  <? echo "$codigosubtipo -"; echo substr($detallesubtipo,0,15);  ?></option>
   <? }	  $l++;  }	 ?>
</select>
</label></td>
<td>
<input name="observaciones<?=$iii?>" type="text" value="<?=$observaciones?>" size="10" />
</td>
</tr>
 <? } ?>
                             
<tr>
<td colspan="7"><div align="center">
<input type="button" class="botonXX" name="Submit" value="GRABAR INFORMACI&Oacute;N" onClick="valida3(this.form);">
&nbsp;
<input class="botonXX"  type="button" value="CANCELAR" name="btnCancelar" onClick="window.history.go(-1)"></div></td>
</tr>
</table>
</div>  <!--CUARTO DIV-->


</div><!-- End -->

</form>
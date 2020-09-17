<?
require('../../../../../util/header.inc');

$institucion = $_REQUEST[institucion];
$ano = $_REQUEST[ano];
 $rutusuario = $_REQUEST[rutusuario];
 $usuario = $_USUARIO;
 $cur = $_REQUEST['cur'];

/*$_ANO = $ano;
session_register('_ANO');*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">

<!--<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" language="javascript">

	$(function() {
		$( "#tabs" ).tabs();
	});
	
	
	$(document).ready(function(){			
	
	var rut_usuario = "<?=$rutusuario?>";
	$("#usuarioactual2 option[value="+rut_usuario+"]").attr("selected",true);
	
	$("#txtFECHA2").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
		
		
	$(document).ready(function(){			
	$("#txtFECHA3").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})		
	
	
	$(document).ready(function(){			
	$("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'dd/mm/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']		
	})	
	

	$("input:radio").click(function() {
    
	  if ( $(this).is(':checked') )
          
		  var x = $(this).val();
		  
	switch (x) {
    case '1':

var H ="Tipo Conducta:&nbsp;POSITIVA:<input type='radio' name='tipoconducta' id='positiva' value='1'>";
	H = H+"NEGATIVA:<input type='radio' name='tipoconducta' id='negativa'  value='2'>"; 
		 
			   $("#tipoconducta").html(H);
			   break;
	case '2':

var H = "Hora Atraso&nbsp;(HH:MM):&nbsp;";
    H = H+"<input name='txtHORAS2' id='txtHORAS2'  type='text' size='4' maxlength='5' value='00:00'>"
			   $("#tipoconducta").html(H);
			   break;
    case '3':

    $("#tipoconducta").html("&nbsp;");
	
	break;
             
            }
   	     
		 });
		 

		 


function buscarperiodos(){ 
		
		
	if ($('#cmb_periodos2').val() != 0 )
		{
		  var idper = $('#cmb_periodos2').val();
		  var x = 1;
		   }
		
	if ($('#cmb_periodos3').val() != 0 )
		{
		  var idper = $('#cmb_periodos3').val();
		  var x = 2;
			}
		
	if ($('#cmb_periodos').val() != 0  )
		{
		  var idper = $('#cmb_periodos').val();
		  var x = 3;
		  }
		
	var parametros ="idperiodo="+idper;
		
		//alert(parametros);
		
			$.ajax({
							
			  url:'buscafechaperiodo.php',
			  data:parametros,
			  type:'POST',
			  
			  success:function(data){
			        $("#fechasdeperiodo"+x+"").html(data);
				    } 
					
	 }) 
		
  }
	
	
 function sgl(){
 var vsg = $('#sigla_subsector').val();
$('#sigla2_').val(vsg);
}

function tip_a(){
/* var vsg = $('#tipo_anotacion').val();
$('#tipo_a2').val(vsg);*/
var tp = $("#tipo_anotacion").val();
  var t1 = tp.split("_");
  var vsg = t1[1];
  $('#tipo_a2').val(vsg)

}
/*function validarfecha(){

//TEXT FECHAS 
	if ( $("#txtFECHA2").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA2").val(); 
	var obsfocus = 1; }
	
	if ( $("#txtFECHA3").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA3").val(); 
	var obsfocus = 2; }
	
	if ( $("#txtFECHA").val() != 0 ){ 
	var fechaingresada = $("#txtFECHA").val(); 
	var obsfocus =  3; }

// SELECT PERIODOS
    if ($('#cmb_periodos2').val() != 0 ){ var idper = $('#cmb_periodos2').val();}
		
	if ($('#cmb_periodos3').val() != 0 ){ var idper = $('#cmb_periodos3').val();}
		
	if ($('#cmb_periodos').val() != 0  )	{ var idper = $('#cmb_periodos').val();}

   	var parametros ="idperiodo="+idper+"&fechaingresada="+fechaingresada;
	//alert(parametros);
		
	if ( $('#fecha_inicio').val() == "Ingresar Fecha Inicio" ) {
	         alert("Si no tiene Fecha Inicio periodo no puede realizar este Registro");
	         return false;
	        }
	
		if ( $('#fecha_termino').val() == "Ingresar Fecha Termino" ) {
	         alert("Si no tiene Fecha Termino periodo no puede realizar este Registro");
	         return false;
	        }
		
				$.ajax({
						url:'validacionfechaperiodo.php',
						data:parametros,
						type:'POST',
						success:function(data){
						
						//alert(data);
						
									if (data == 0){
									   alert("Error: Verificar las Fechas de Periodo");
									} else {
											   if (data == 1){ 
													   //alert("Fecha es Correcta");
													   if(obsfocus == 1){
													   $("#txtOBS2").focus();
													   }
															   if(obsfocus == 2){
															   $("#txtOBS3").focus();
															   }
																	   if(obsfocus == 3){
																	   $("#txtOBS").focus();
																	   }
											   }else{
				alert("Esta Fecha no esta Dentro del Rango de Fechas de Periodo");
											   //$("#fechasdeperiodo1").html(data);
												}
								   } 
					
							} //success
				 }) 
	   
 }	
	*/


 function compare_dates(fecha,fecha2) // 08/12/2010 
   {  
     var xMonth=fecha.substring(3,5);  
     var xDay=fecha.substring(0,2);  
     var xYear=fecha.substring(6,10);  
	 
     var yMonth=fecha2.substring(3,5);  
     var yDay=fecha2.substring(0,2);  
     var yYear=fecha2.substring(6,10);  
     
	 if (xYear > yYear)  
     {  return(true) }  
     else  
     {  
       if (xYear == yYear)  
       {   
         if (xMonth > yMonth)  
         { return(true) }  
         else  
         {   
           
		   if (xMonth == yMonth)  
           {  
             if (xDay > yDay)  
               return(true);  
             else  
               return(false);  
           }  
           else  
             return(false);  
         }  
       }  
       else  
         return(false);  
     }  
 }  


  function reseteo(){
	//$('#Formulariolista')[0].reset();
      }
	  
	  function buscatipoconducta(){
	var vsg = $('#codigo2').val();
	var parametros ="codigo="+vsg;
	$.ajax({
							
			  url:'tipoconducta.php',
			  data:parametros,
			  type:'POST',
			  
			  success:function(data){
			        $("#tipo_a").val(data);
				    } 
					
	 }) 
	}

</script>

<body>
<form name="Formulariolista" id="Formulariolista" >

<div id="tabs" style="width:700px; margin: 20px auto 0 auto;" >

	<ul>
		<li ><a href="#codigo" onClick="reseteo()" >codigo</a></li>
		<li ><a href="#seleccion" onClick="reseteo()" >seleccion</a></li>
		<li ><a href="#tradicional" onClick="reseteo()" >tradicional</a></li>
	</ul>


<div id="codigo">

  <table class="textonegrita">
    <tr>
      <td><div align="left">
        <input 
	  name="btnGuardar1" type="button" class="botonXX" id="btnGuardar1" onClick="guardar1()" 
	  value="GUARDAR" />
        &nbsp;<br />
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
                <input name="codigo2" type="text" id="codigo2" size="10" onchange="buscatipoconducta()" />
                <span >(*)</span></div><input type="hidden" name="tipo_a" id="tipo_a" value="" /></td>
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
<select  id="cmb_periodos2" name="cmb_periodos2" class="ddlb_9_x Estilo2" onChange="buscarperiodos()">
          <option value=0 selected>(Seleccione Periodo)</option>
          <?
		  
$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano." order by 1";
	
	$result_peri = @pg_exec($conn,$sql);
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
	
		$fila1 = @pg_fetch_array($result_peri,$i); 
		echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		
      } 
	  
	  ?>
        </select>
        <span >(*)</span>
		
		</div><div id="fechasdeperiodo1"></div></td>
    </tr>
    <tr>
      <td nowrap="nowrap" ><div align="left">FECHA</div></td>
      <td nowrap="nowrap" ><div align="left">
        <input type="text" name="txtFECHA2" 
		id="txtFECHA2" readonly="readonly" size="11" maxlength="11" onChange="validarfecha()" />
        <span class="textosimple">(*)</span> <br />
      </div></td>
    </tr>
    <tr>
      <td><div align="left">OBSERVACI&Oacute;N</div></td>
      <td><textarea name="txtOBS2" id="txtOBS2" cols="40" rows="5"></textarea>      </td>
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
  &nbsp;<br>
  </div></td>
</tr>
<tr>
<td nowrap="nowrap" ><div align="left">PERIODO</div></td>
<td nowrap="nowrap" >

<div align="left">
<select name="cmb_periodos3" id="cmb_periodos3" class="ddlb_9_x Estilo2" onChange="buscarperiodos()">
 <option value=0 selected>(Seleccione Periodo)</option>
	    <?
	for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
	{
	$fila1 = @pg_fetch_array($result_peri,$i); 
	   echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
	 } 	?>
</select> 
<span class="Estilo7">(*)</span>
</div><div id="fechasdeperiodo2"></div></td>
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
	  <select name="sigla_subsector" id="sigla_subsector" onchange="sgl()">
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
       <input name="sigla2" type="hidden" id="sigla2_" size="10" />
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
	  <select name="tipo_anotacion" onChange="enviapag3(this.form);tip_a()" id="tipo_anotacion">
	    <option value="0">Seleccione Tipo de Anotaci&oacute;n </option>
	    <?									
	$k = 0;
	while ($k < $n200){
		$f200 = pg_fetch_array($r200,$k);
		$id_tipo = $f200['id_tipo'];
		$codtipo = $f200['codtipo'];
		$descripcion = $f200['descripcion'];
		$tipo = $f200['tipo'];
			?>
	    <option value="<?=$id_tipo ?>_<?php echo $tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> >
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
</div>	 <input type="hidden" name="tipo_a2" id="tipo_a2" value="" />
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
    <INPUT type="text" name="txtFECHA3" id="txtFECHA3" readonly="readonly" size=11 maxlength=11 onChange="validarfecha()" >
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
  <div align="left" id="guardar3" >
  <input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="guardar3()" >
  &nbsp;<br>
  <br>
  </div></td>
</tr>
<tr>
<td nowrap="nowrap" >
<div align="left">NOMBRE RESPONSABLE 
 <?

	
	$q200 = "select distinct empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja 
  where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." ORDER BY 
  empleado.nombre_emp  ASC";
		
				 ?>
  <select name="usuarioactual2" id="usuarioactual2">
    <option value="0">Seleccione Responsable </option>
    <?							
	
	

		if($_PERFIL==0){ echo $q200; }
		$r200 = pg_Exec($conn,$q200);
		$n200 = pg_numrows($r200);				
			$k = 0;
			while ($k < $n200){
				$f200 = pg_fetch_array($r200,$k);
				$rut_emp = $f200['rut_emp'];
				$nombre = $f200['nombre_emp'];
				$ape=$f200['ape_pat'];
					?>
    <option value="<?=$rut_emp;?>"><? echo "$nombre"." "."$ape"; ?></option>
    <? $k++; }  ?>
  </select>
  <span class="Estilo7">(*)</span></div>
  <div align="left">
   
  </div></td>

   
</tr>

<tr>
  <td nowrap="nowrap" >ASIGNATURA:
  <?php  $sql_ram = "select r.id_ramo,s.nombre from ramo r inner join subsector s on s.cod_subsector = r.cod_subsector where id_curso = $cur order by r.id_orden";
  	$rs_ram = pg_exec($conn,$sql_ram);
  ?>
  
  <select id="cmbRAMO" name="cmbRAMO">
  <option value="0">Seleccione Asignatura</option>
 <?php  for($a=0;$ra<pg_numrows($rs_ram);$ra++){
	 $fila_ra = pg_fetch_array($rs_ram,$ra);
	 ?>
 <option value="<?php echo $fila_ra['id_ramo'] ?>"><?php echo $fila_ra['nombre'] ?></option>
 <?php } ?>
  </select>
  
    </td>
</tr>

	<tr>
		<td>
		  <div align="left">PERIODO:&nbsp;
	  <select name="cmb_periodos" class="ddlb_9_x" id="cmb_periodos" onChange="buscarperiodos()">
		<option value=0 selected>(Seleccione Periodo)</option>
		        <?
	  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
	  {
	  $fila1 = @pg_fetch_array($result_peri,$i); 
          echo "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
		} ?>
              </select>
	        <span class="Estilo7">(*)</span></div>
		  <div id="fechasdeperiodo3"></div></td>
	</tr>
<tr>
<td>
  <div align="left">FECHA :&nbsp; 
      <input type="text" name="txtFECHA" id="txtFECHA" size=11 maxlength=11 onChange="validarfecha()" >
	  <span class="Estilo7">(*)</span>
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
      <textarea name="txtOBS" id="txtOBS" cols="60" rows="5"></textarea>
</div></td>
</tr>
</table>

</div> <!--TERCER DIV-->


<div id="masivo"> <!--CUARTO DIV-->
</div>  
<!--CUARTO DIV-->


</div><!-- End -->

</form>
</body>
</head>
</html>
<?
pg_close($conn);
pg_close($connection);
?>

<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

require "../class_reporte/class_motor.php";



$ob_motor = new Motor($_IPDB,$_ID_BASE);




//$rs_periodo = $ob_motor->busca_periodo($_ANO);
$perfil	= $_PERFIL;

echo"<pre>";
//print_r($GLOBALS);
echo"</pre>";

if($perfil==45){	
//corporaciones
$sql_corpo="select * from corporacion as cor where cor.num_corp 
in (SELECT num_corp from nacional_corp as nac where nac.id_nacional=1)";
$rs_corpo = @pg_exec($ob_motor->Conec->conectar(),$sql_corpo) or die("select fallo:".$sql_corpo);


for($i=0;$i<@pg_numrows($rs_corpo);$i++){
	$fila=pg_fetch_array($rs_corpo,$i);
	$array_corp[] = $fila['num_corp'];
} 

$x=0;
foreach($array_corp as $d_corp => $val_corp){
	$x++;
	$institucion_all.= ($x<count($array_corp))?$val_corp.",":$val_corp;
	$instituciones.= ($x<count($array_corp))?$val_corp."|":$val_corp;
	
}



$sql_instit = "SELECT distinct(i.rdb),nombre_instit FROM public.institucion i 
INNER JOIN public.corp_instit ci 
ON i.rdb=ci.rdb WHERE num_corp in (".$institucion_all.")
order by i.rdb";
$rs_instit = @pg_exec($ob_motor->Conec->conectar(),$sql_instit) or die("select fallo:".$sql_corpo);
}
else{
$corp=$_CORPORACION;
$rs_ano = $ob_motor->Anos($_INSTIT);


$rs_corp = $ob_motor->corporacion($_INSTIT);
$num_corp=pg_fetch_array($rs_corp,0);
$num_corp[0];

$rs_instit = $ob_motor->busca_institucion2($num_corp[0]);

$rs_mision= $ob_motor->misiones();

$instituciones = $num_corp[0];
$institucion_all = $num_corp[0];
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>
function enviapag2(form){
	form.target="_blank";
	form.action = 'mod/reportes/reporteXcargo/printReporteXcargo.php';
	form.submit(true);
			}

function cargar_cargo(ano){
			
		var nro_ano=$('#cmbANO').val();	
		var inst=$('#cmbINST').val();
		//alert(inst);
		if(inst==0){
		ano=0;	
		}
		var parametros = 'funcion=carga_cargo&inst='+inst;
		//alert(parametros);
		$.ajax({
			url:'mod/reportes/reporteXcargo/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#cargo').html(data);
					
				}
			}
			})
     	}



function carga_anos(rdb){
	
	
	if(rdb == 0){
	rdb ="_+<?php echo $instituciones ?>";	
	}else
	{rdb = rdb;}
	
	
	var parametros ="funcion=carga_ano&rdb="+rdb;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporteXcargo/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
					//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#anos').html(data);
				}
			}
	})
}



function carga_instit(num_corp){
	
	var parametros ="funcion=carga_intit&num_corp="+num_corp;
	//alert(parametros);
	$.ajax({
		url:'mod/reportes/reporteXcargo/cont_motor.php',
		data:parametros,
		type:'POST',
			success:function(data){
					//alert(data);
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#intitucion').html(data);
				}
			}
	})
}


	

//VALIDACIONES cmbCARGO
	function valida(form){
	if($('#cmbANO').val()==0){
	alert("Seleccione Año Academico");
	return false;
	}	
	
	
	if($('#cmbCARGO').val()==0){
		alert("Escoja un cargo");
		return false;
	 }	
	
	
	form.action = 'mod/reportes/reporteXcargo/printReporteXcargo.php';
	form.submit(true);		
	
}

$( document ).ready(function() {
  carga_anos(0);
});

</script>
</head>

<body >
<br />
<br />
<form name="form" action="" method="post" target="_blank" >
  <table width="550" height="43" border="1" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse">
	<tr><td>
		<table width="550" height="43" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td width="500" class="cuadro02" align="center">Buscador Avanzado</td>
		  </tr>
		  <tr>
			<td width="500" align="center">
		    <input type="hidden" name="crp" id="crp" value="<?php echo $institucion_all ?>"/></td>
		  </tr>
		  <tr>
			<td height="27">
            <table width="550" border="0" cellspacing="0" cellpadding="3">
            
            
               <?php
            	if($perfil==45){
					
			?>    
            <tr>
				<td width="141" class="textosimple">Instituci&oacute;n</td>
				<td width="409" colspan="2">
                <div align="left" id="intitucion">
                <span class="textosmediano">              
				  <select name="cmbINS" id="cmbINS" class="ddlb_x" onchange="carga_anos(this.value);" >
					<option value="0">(TODOS)</option>
                     <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
			$fila=pg_fetch_array($rs_instit,$i);?>
<option value="<?=$fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
            <?php }?>
            
            
            <?php
            	if($perfil==43){
			?>
            <tr>
				<td width="141" class="textosimple">Instituci&oacute;n</td>
				<td width="409" colspan="2">
                <div align="left"><span class="textosimple">
				  <select name="cmbINS" id="cmbINS" class="ddlb_x" onchange="carga_anos(this.value);" >
					<option value="0">(TODOS)</option>
					<? 
					for($i=0;$i<pg_numrows($rs_instit);$i++){
						$fila = pg_fetch_array($rs_instit,$i);?>
						<option value="<? echo $fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
            <?php }?>
             <tr>
				<td width="141" class="textosimple">Año</td>
				<td width="409" colspan="2">
                <div align="left" id="anos">
                <span class="textosmediano">
				  <select name="cmbANO" id="cmbANO" class="ddlb_x" onchange="cargar_cargo(this.value);" >
					<option value="0">seleccione</option>
					<? 
					for($i=0;$i<pg_numrows($rs_ano);$i++){
						$fila = pg_fetch_array($rs_ano,$i);?>
						<option value="<? echo $fila['id_ano'];?>"><?=$fila['nro_ano'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
			   <tr>
				<td class="textosimple">Cargo </td>
				<td colspan="2" class="textosmediano">
				<div id="cargo">
				<table border="0">
					<tr><td>
				  <select name="cmbCARGO" id="cmbCARGO" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
			  
			    <tr>
				<td colspan="3" class="textosimple"><div align="right">
				  <input name="cb_ok" class="botonXX" onmouseover="this.style.background='#FFFFD7';this.style.color='#003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='#FFFFD7'" type="button" value="Exportar a Excel" onclick="valida(this.form);" />
                   
				</div></td>
                
                
                
				</tr>
			</table></td>
		  </tr>
		</table>
	</td></tr>
</table>
</form>
<br />
<br />

</body>
</html>

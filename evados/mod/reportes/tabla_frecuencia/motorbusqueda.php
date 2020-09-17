
<?

header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

//require "../class_reporte/class_motor.php";
require "../../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ano=$_ANO;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

<script>

	function cargar_intitu(num_corp){
	
		var nro_ano=$('#cmbANO').val();
		var nacional = 1;
		var parametros = 'funcion=institu&num_corp='+num_corp+'&nro_ano='+nro_ano;
		//alert(parametros);
		$.ajax({
			url:'mod/reportes/tabla_frecuencia/cont_motor.php',
		    data:parametros,
		    type:'POST',
			success:function(data){
				if(data==0){
					alert("Error al cargar Select");
				}else{
					$('#intitucion').html(data);
					//cargar_cargo(nro_ano);
				}
			}
			})
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
			url:'mod/reportes/tabla_frecuencia/cont_motor.php',
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
		
		
	  	
	function limpia_todo(){  
    
        $("#cmbCORP option[value=0]").attr("selected",true);  
		$("#cmbINST option[value=0]").attr("selected",true); 
		$("#cmbANO option[value=0]").attr("selected",true); 
		$("#cmbCARGO option[value=0]").attr("selected",true); 
		
  };  
		
		
	function valida(form){
		if($('#cmbANO').val()==0){
		alert("Seleccione Año Academico");
		return false;
	  }	
	
		if($('#cmbCORP').val()==0){
		alert("Escoja Una Corporación");
		return false;
	 }	
	
		form.action = 'mod/reportes/tabla_frecuencia/printReporteTablaFrecuencia.php';
		form.submit(true);		
	
  }
	
		
		

</script>
</head>

<body><br />
<br />
<form name="form" id="form" action="" method="post" target="_blank">
<table width="550" height="43" border="1" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse">
	<tr><td>
		<table width="550" height="43" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
			<td width="500" class="cuadro02" align="center">Buscador Avanzado</td>
		  </tr>
		  <tr>
			<td width="500" align="center">&nbsp;</td>
		  </tr>
		  <tr>
			<td height="27"><table width="550" border="0" cellspacing="0" cellpadding="3">
            
            
             <tr>
				<td class="textosmediano">Año Academico </td>
				<td colspan="2" class="textosmediano">
				<div id="año_academico">
				<table border="0">
					<tr><td>
				 <select name="cmbANO" id="cmbANO" class="ddlb_x">
					<option value="0">seleccione</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                   
				  </select>
				  </td></tr></table>
				 </div>
				</td>
			  </tr>
            
             <tr>
				<td width="141" class="textosmediano">Corporaci&oacute;n</td>
				<td width="409" colspan="2"><div align="left"><span class="textosmediano">
				  <select name="cmbCORP" id="cmbCORP" class="ddlb_x" onchange="cargar_intitu(this.value)">
					<option value="0">seleccione</option>
					<?
 echo $sql="select * from corporacion as cor where cor.num_corp 
in (SELECT num_corp from nacional_corp as nac where nac.id_nacional=1)";					
$rs_evaluados = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("select fallo:".$sql);
		for($i=0;$i<@pg_numrows($rs_evaluados);$i++){
			$fila=pg_fetch_array($rs_evaluados,$i);?>
<option value="<?=$fila['num_corp'];?>"><?=$fila['nombre_corp'];?></option>
					<? } ?>
				  </select>
				</span></div></td>
			  </tr>
              
              <tr>
				<td class="textosmediano">Instituci&oacute;n </td>
				<td colspan="2" class="textosmediano">
				<div id="intitucion">
				<table border="0">
					<tr><td>
				  <select name="cmbINST" id="cmbINST" class="ddlb_x">
					<option value="0">seleccione</option>
				  </select>
				  </td></tr></table> 
				 </div>
				</td>
			  </tr>
              
              <tr>
				<td class="textosmediano">Cargo </td>
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
				<td colspan="3" class="textosmediano"><div align="right">
				  <input name="cb_ok" class="botonXX" onmouseover="this.style.background='#FFFFD7';this.style.color='#003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='#FFFFD7'" type="button" value="Buscar" onclick="valida(this.form)" />
				</div></td>
                
                <td colspan="3" class="textosmediano"><div align="right">
				  <input name="limpiar" id="limpiar" class="botonXX" onmouseover="this.style.background='#FFFFD7';this.style.color='#003b85'" onmouseout="this.style.background='#5c6fa9';this.style.color='#FFFFD7'" type="button" value="Limpiar" onclick="limpia_todo()" />
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

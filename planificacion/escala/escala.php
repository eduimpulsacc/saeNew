<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script><script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	var ano =$("#cmbANO").val();
	carga_tabla(ano);
	
	
});

function carga_tabla(ano){
 var ano =$("#cmbANO").val();
 var parametros="funcion=1&ano="+ano;
 
 $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		  }
	  })		
}


function nueva_escala(){
 var ano =$("#cmbANO").val();
 var parametros="funcion=2&ano="+ano;
 $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ventana").html(data);
		$("#ventana").dialog({ 
		   closeOnEscape: false,
		   modal:true,
		   resizable: false,
		   Width: 500,
		   Height: 300,
		   minWidth: 500,
		   minHeight: 300,
		   maxWidth: 500,
		   maxHeight: 300,
		   show: "fold",
		   hide: "scale",
		   stack: true,
		   sticky: true,
		   position:"fixed",
		   position: "absolute",
		   buttons: {
		   "Guardar Datos": function(){
			   	guardar_escala();
				$(this).dialog("close");
			 } ,
		   "Cerrar": function(){
				$(this).dialog("close");
		  }
		}     
  })
		  }
	  })		
}

function guardar_escala(){
	var nombre = $("#txtNOMBRE").val();
	var minimo = $("#txtMINIMO").val();
	var maximo = $("#txtMAXIMO").val();
	var ano    = $("#cmbANO").val();
	
	var parametros ="funcion=3&nombre="+nombre+"&minimo="+minimo+"&maximo="+maximo+"&ano="+ano;
	 $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			carga_tabla();
		  }else{
			alert("ERROR DE CARGA");  
		  }
//		$("#tabla").html(data);
		  }
	  })		
}


function eliminar(escala){
	alert("NO DEBE TENER REGISTROS INGRESADOS CON ESTE CONCEPTO");
	 var parametros ="funcion=4&escala="+escala;
	  $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			carga_tabla();
		  }else{
			alert("ERROR DE CARGA");  
		  }
		  }
	  })	
		
}

function modifica(escala){
	 var parametros="funcion=5&escala="+escala;
	 $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ventana").html(data);
		$("#ventana").dialog({ 
		   closeOnEscape: false,
		   modal:true,
		   resizable: false,
		   Width: 500,
		   Height: 300,
		   minWidth: 500,
		   minHeight: 300,
		   maxWidth: 500,
		   maxHeight: 300,
		   show: "fold",
		   hide: "scale",
		   stack: true,
		   sticky: true,
		   position:"fixed",
		   position: "absolute",
		   buttons: {
		   "Guardar Datos": function(){
			   	modificar_escala(escala);
				$(this).dialog("close");
			 } ,
		   "Cerrar": function(){
				$(this).dialog("close");
		  }
		}     
  })
		  }
	  })
}

function modificar_escala(escala){
	var nombre = $("#txtNOMBRE").val();
	var minimo = $("#txtMINIMO").val();
	var maximo = $("#txtMAXIMO").val();
	var ano    = $("#cmbANO").val();
	var parametros="funcion=6&escala="+escala+"&nombre="+nombre+"&minimo="+minimo+"&maximo="+maximo+"&ano="+ano;
	 $.ajax({
	  url:'cont_escala.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			carga_tabla();
		  }else{
			alert("ERROR DE CARGA");  
		  }
		  }
	  })	
}

</script>
<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">


<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50" height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/index.php");?></td>
    <td valign="top" align="center"><br />
<br />
<table width="870" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
                          <tr>
                            <td width="5%" colspan="4">
                            
                            <br />
                            
                            <table width="90%" border="0" align="center">
                              <tr>
                                <td class="textonegrita">&nbsp;AÑO</td>
                                <td class="textonegrita">&nbsp;:</td>
                                <td>&nbsp;
                                <select name="cmbANO" id="cmbANO" class="select_redondo" onchange="carga_tabla()">
                                	<option value="0">seleccione...</option>
                                <?	$sql="SELECT id_ano,nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$_INSTIT." ORDER BY nro_ano ASC";
									$rs_ano = pg_exec($conn,$sql);
									
									for($i=0;$i<pg_numrows($rs_ano);$i++){
										$fila=pg_fetch_array($rs_ano,$i);
										if($fila['situacion']==1) $estado="(abierto)"; else $estado="(cerrado)";
								?>
                                <option value="<?=$fila['id_ano'];?>" <? if($fila['situacion']==1) echo "selected";?>><? echo $fila['nro_ano']." ".$estado;?></option>
                                <? } ?>
                                </select>
                                </td>
                              </tr>
                              <tr>
                                <td class="textonegrita">&nbsp;</td>
                                <td class="textonegrita">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="3" class="tableindex tablaredonda">ESCALA DE EVALUACIÓN</td>
                              </tr>
                               <tr>
                                <td colspan="3" align="right" ><input name="AGREGAR" type="button" value="AGREGAR" class="botonXX" onclick="nueva_escala();" /></td>
                              </tr>
                            </table>

                            <br />
                            <div id="tabla">&nbsp;</div>
                            <div id="ventana">&nbsp;</div>
                            <br />
                            
                            </td>
                          </tr>
                          </table></td>
  </tr>
  <tr>
    <td valign="top" colspan="2" align="left"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>




</body>

</html>

<?php require('../../../../util/header.inc');
//print_r($_POST);
	//echo pg_dbname();
     $_PERFIL;
	 $_CORPORACION;
	 $_FRMMODO;
	 $nacional=	$_ID_NACIONAL;
	 
	 //echo pg_dbname();
	 
	 
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>
		 	
<script type="text/JavaScript">

$(document).ready(function() {

	//carga_instit();
	//$('#cargando').hide();
    
});

function habilita_text()
{
	if($('#porcentaje').is(':checked')){
		$('#txt_porc').attr('disabled',false);
		$('#txt_porc').focus();
		$('#titulo').html("REPORTE GR\u00c1FICOS SUBVENCI\u00d3N ESTIMATIVA");
		}else{
		$('#txt_porc').attr('disabled',true);
		$('#titulo').html("REPORTE GR\u00c1FICOS SUBVENCI\u00d3N REAL");

	}	
}

function validar()
{
	
	var anos = $('#cmb_anos').val();
	//alert(probar);
	
	
	/*if($('#cmb_mes').val()==0)
	{
		alert("Seleccione mes");
		return false;	
	}*/
	
	if($('#porcentaje').is(':checked')){
	document.form.action='print_graficos_subvencionEstimada.php';
	
	}else{
	document.form.action='print_graficos.php';
	}
	document.form.submit();
	
}







</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../cabecera/menu_superior_corp_vina.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<center>
    
  
	<form name="form" action="print_reporte_subvencion.php" method="post" target="_blank">
		<table WIDTH="840"  BORDER="1" CELLSPACING="1" CELLPADDING="3" style="border-collapse:collapse">
		 <tr class="tableindex">	
		<td align="center"><div id="titulo">REPORTE GRAFICOS SUBVENCION REAL</div></td>
		</tr>
		</table>
        
        <table WIDTH="750" CELLSPACING="1" CELLPADDING="3" >
      
        <tr>	
		<td width="145" align="center">&nbsp;</td>
		</tr>
        <!--<tr >	
        <td>Instituci&oacute;n :</td>
        <td>
        <div id="div_inst">
        <select id="cmb_instit" name="cmb_instit">
        <option value="0">Seleccione</option>
        </select>
        </div>
        </td>
        </tr>-->
        <tr>
        <td>Mes :</td>
         <td><select id="cmb_mes" name="cmb_mes">
        <option value="0">Seleccione</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
        
        </select></td>
        </tr>
        <tr>
		<td align="left">A&ntilde;os Academicos :</td>
        <td width="588" align="left"><select id="cmb_anos" name="cmb_anos">
        <option value="2014">2014</option>
        <option value="2013">2013</option>
        <option value="2012">2012</option>
        <option value="2011">2011</option>
        <option value="2010">2010</option>
        <option value="2009">2009</option>
        <option value="2008">2008</option>
        
        </select>
        </td>
		</tr>
        
       
		
        <tr>
        <td align="left">&nbsp;Estimativo</td>
        <td>
         Porcentaje <input type="checkbox" value="1" name="porcentaje" id="porcentaje" title="Porcentaje" onClick="habilita_text()"> 
      <input type="text" name="txt_porc" id="txt_porc" size="2" disabled maxlength="3">
         </td>
        </tr>        
        
        <tr >	
		<td align="left" colspan="3">&nbsp;</td>
		</tr>
        
         <tr >	
		<td align="left">&nbsp;</td>
        <td width="588" align="left">
      <input type="button" class="botonXX" value="Buscar" name="btn_buscar" id="btn_buscar" onClick="validar(this.form)"> 
         </td>
		</tr>
        
        
        
        </table>
          <div id='cargando'></div>
	</form>
	</center>
	<?
	$ano			=$_ANO;
	?>
									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							   </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>


</body>
</html>

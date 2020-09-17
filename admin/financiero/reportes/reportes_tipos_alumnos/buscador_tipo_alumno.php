<?php require('../../../../util/header.inc');

	//echo pg_dbname();
     $_PERFIL;
	 $_CORPORACION;
	 $_FRMMODO;
	 $nacional=	$_ID_NACIONAL;
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		 	
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
	<form name="form" action="print_reporte_tipoAlumno.php" method="post" target="_blank">
    
    <input type="hidden" name="id_nacional" value="<?=$nacional?>">
		<table WIDTH="840"  BORDER="1" CELLSPACING="1" CELLPADDING="3" style="border-collapse:collapse">
		 <tr class="tableindex">	
		<td align="center">TIPO DE ESTUDIANTE SEG&Uacute;N MATR&Iacute;CULA</td>
		</tr>
		</table>
        
        <table WIDTH="750" CELLSPACING="1" CELLPADDING="3" >
        <tr>	
		<td width="145" align="center">&nbsp;</td>
		</tr>
        <tr >	
		<td align="left">A&ntilde;os&nbsp;Academicos&nbsp;:</td>
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
    <td width="74">Mes	:
    </td>
    <td colspan="2">
	    <select class="ddlb_9_x" id="cmb_mes" name="cmb_mes" >
          <option value=0 selected>(Seleccione Mes)</option>
          <?
          for($i=1;$i<=12;$i++){
			
			if($i<10){
			$mes='0'.$i;
			}else{
			$mes=$i;	
			}
			switch($mes){
			case $mes == 01;
			$mes='Enero';
			break;
			case $mes == 02;
			$mes='Febrero';
			break;
			case $mes == 03;
			$mes='Marzo';
			break;
			case $mes == 04;
			$mes='Abril';
			break;
			case $mes == 05;
			$mes='Mayo';
			break;
			case $mes == 06;
			$mes='Junio';
			break;
			case $mes == 07;
			$mes='Julio';
			break;
			case $mes == 8;
			$mes='Agosto';
			break;
			case $mes == 9;
			$mes='Septiembre';
			break;
			case $mes == 10;
			$mes='Octubre';
			break;
			case $mes == 11;
			$mes='Noviembre';
			break;
			case $mes == 12;
			$mes='Diciembre';
			break;
			}
			?>
            <option value="<?=$i?>"><?=$mes;?></option>
            <?
	    }
   ?>
          
        </select>
	   </td>
    <td width="29">&nbsp;</td>
    <td width="120">
	  	</td>
    <td width="90"></td>
  </tr>
        
        
        
        <tr >	
		<td align="left">&nbsp;</td>
        <td width="588" align="left">
      <input type="submit" class="botonXX" value="Buscar" name="btn_buscar">
        </td>
		</tr>
        
        </table>
        
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

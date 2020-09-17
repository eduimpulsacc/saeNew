<?
require('util/header2.php');
$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;

if ($ano == NULL){
   $_MDINAMICO = 0;
}else{
   $_MDINAMICO = 1;
}      

$id=$_GET["id"];
$perfil = $_PERFIL; 
	
$usuarioensesion = $_USUARIOENSESION;
##Selecciono los datos para mostrar en el Diario Mural.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>www.colegiointeractivo.com</title>
</head>

<body topmargin="0" leftmargin="0">
<table width="700" height="400" border="1">
  <tr>
    <td valign="top">
	
	<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="left" valign="top"> 
                                  <td  align="center">
                                    <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            
                                            <tr> 
                                              <td height="23" align="left" valign="top" class="borde"> 
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                  <!-- AQUI LA INFORMACION DEL DIARIO MURAL -->
												  
												  <? 
														$sqlDiario = "SELECT * FROM din_noticias order by id_noticia desc limit 1";
														//echo $sqlDiario;
														//return;
														$rsDiario  = @pg_Exec($conn,$sqlDiario);
												  	if(@pg_numrows($rsDiario)!=0){
	                                                    for($i=0 ; $i < @pg_numrows($rsDiario); $i++)
	                                                       {
		                                                   $fDiario = @pg_fetch_array($rsDiario,$i);			   													   
														  ?>
												     	  <tr> 
                                                          <td height="10" align="center" valign="top" bgcolor="#666666"><font face="arial, geneva, helvetica" size="3" color="#FFFFFF"><b><? echo $fDiario['tx_titulo']?></b></font></td>
                                                        </tr>
														<tr>
														<td width="10" height="10" align="left" valign="top">&nbsp;</td>
     													</tr>
														<tr>
														<td><font face="arial, geneva, helvetica" size="2"><? echo nl2br($fDiario['tx_detalle']) ?></font><br></td>
                                                         </tr>														 
														 <?
														}
														
												    }	
													?>	
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                  </table></td>
                                </tr>
                              </table>
	
	
	</td>
  </tr>
</table>
</body>
</html>

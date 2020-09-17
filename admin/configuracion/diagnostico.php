<?	require('../../util/header.inc');
	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 2;
	$_bot = 8;


	
	$sql = "SELECT * FROM diagnostico WHERE rdb=".$institucion." ORDER BY id_dignos ASC";
	$result= @pg_exec($conn,$sql);
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
function txt_ciclo(){
	document.form.txt_ciclo.focus();
}
function elimina_curso(id_curso,id_ciclo,ensenanza){
	window.location="procesa_ciclo.php?tipo=3&id_curso="+id_curso+"&id_ciclo="+id_ciclo+"&ensenanza="+ensenanza;
	//form.submit(true);
}
function Show_cursos(id_ciclo){
	var ensenanza = document.form.cmb_ensenanza.value;
	window.location="asignar_ciclo.php?tipo=2&id_ciclo="+id_ciclo+"&cmb_ensenanza="+ensenanza;
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function confirma(caso,id_dig){
	
	if(window.confirm("Desea eliminar diagnostico")){
		window.location='procesoDiagnostico.php?caso='+ caso + '&id_dig='+ id_dig +'';	
	}
}
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<style type="text/css">
<!--
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo12 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?	include("../../cabecera/menu_superior.php");?>				 				
				</td>
				</tr>
				</table>				
				</td>
              </tr>              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  
 								  								  
								  <form id="form" name="form" action="procesoDiagnostico.php" method="post">
								  <input name="caso" value="<?=$caso;?>" type="hidden">
								  <input name="id_dig" value="<?=$id_dig;?>" type="hidden">
								  <table width="650" border="0">
								  <tr>
									<td align="right"><input name="VOLVER" type="button" value="VOLVER" onClick="window.location='listaProyectoGrupo.php'" class="botonXX"></td>
								  </tr>
								</table>
								    <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                      <tr>
                                        <td colspan="4">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="4" class="tableindex">DIAGNOSTICOS</td>
                                      </tr>
                                      <tr>
                                        <td colspan="4">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td width="128"><div align="right"><span class="Estilo7">Nombre  </span></div></td>
                                        <td width="6"><strong>:</strong></td>
                                        <td width="350">
										  <div align="left"><span class="Estilo10">
								          <? if($caso==2){
										  		$sql = "SELECT nombre,tipo FROM diagnostico WHERE id_dignos=".$id_dig;
												$rs_dig = pg_exec($conn,$sql);
												$nombre = pg_result($rs_dig,0);
												$tipo	= pg_result($rs_dig,1);?>
										    	<input name="txtNOMBRE" type="text" size="40" value="<?=$nombre;?>">
										    <? } 
											if($caso==3){?>
										   		<input name="txtNOMBRE" type="text" size="40">
										    <? } ?>
									      </span></div></td>
                                        <td width="126"><div align="left">
                                          <input type="submit" name="Submit" value="+" class="botonXX">
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td><div align="right"><span class="Estilo7">Tipo</span></div></td>
                                        <td class="Estilo7">:</td>
                                        <td colspan="2" class="Estilo10">
										<? if($caso==2){?>
										<input name="tipo" type="radio" value="1" <? if($tipo==1) echo "checked";?>>
                                          Proyecto Integraci&oacute;n 
                                          <input name="tipo" type="radio" value="2" <? if($tipo==2) echo "checked";?>>
                                          Grupo Diferencial
										
										<? }
											if($caso==3){ ?>
										  <input name="tipo" type="radio" value="1">
                                          Proyecto Integraci&oacute;n 
                                          <input name="tipo" type="radio" value="2">
                                          Grupo Diferencial
										  
										 <? } ?> 
										   </td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="4"><table width="650" border="0" align="center" cellpadding="3" cellspacing="3">
                                          <tr >
                                            <td colspan="5"><table width="100%" border="0">
                                              <tr>
                                                <td><input type="submit" name="Submit2" value="+" class="botonXX"> 
                                                <span class="Estilo7">agregar </span></td>
                                                <td><input type="submit" name="Submit3" value="E" class="botonXX"> 
                                               <span class="Estilo7"> eliminar </span> </td>
                                                <td><input type="submit" name="Submit4" value="V" class="botonXX">
                                                <span class="Estilo7">ver</span></td>
                                              </tr>
                                            </table></td>
                                          </tr>
                                          <tr  class="tableindex">
                                            <td width="4%">N&ordm;</td>
                                            <td width="63%">DIAGNOSTICO</td>
                                            <td width="14%">TIPO</td>
                                            <td width="13%">ELIMINAR</td>
                                            <td width="6%">VER</td>
                                          </tr>
										  <? for($i=0;$i<@pg_numrows($result);$i++){
										  		$fila = @pg_fetch_array($result,$i);
												$cont++;
										  ?>
                                          <tr>
                                            <td><span class="Estilo12">&nbsp;<?=$cont;?></span></td>
                                            <td><span class="Estilo12">&nbsp;<?=$fila['nombre'];?></span></td>
                                           	<td><span class="Estilo12">&nbsp;<? if($fila['tipo']==1) echo "PI"; elseif($fila['tipo']==2) echo "GD"; else echo "&nbsp;";?></span></td>
                                           	<td align="center"><span class="Estilo12"><input name="elimina" type="button" value="E" class="botonXX" onClick="confirma(1,<?=$fila['id_dignos'];?>)"></span></td>
											<td align="center"><input name="ver" type="button" class="botonXX" onClick="window.location='diagnostico.php?caso=2&id_dig=<?=$fila['id_dignos'];?>'" value="V" alt="VISTA PREVIA"></td>
											</tr>
										  <? } ?>
                                        </table></td>
                                      </tr>
                                    </table>
								  
								  </form>
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><table width="" height="49" border="0" cellpadding="0" cellspacing="0">
									  <tr> 
										<td width="" height="30" align="center" valign="top"> <? include("../../cabecera/menu_inferior.php");?></td>	  
									  </tr> 
								  </table></td>
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
<? pg_close($conn);?>
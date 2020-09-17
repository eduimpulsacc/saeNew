<?php 	

	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
//var_dump($_SESSION);

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$perfil 		=$_PERFIL;
	$_POSP = 4;
	$_bot  =8;
	
	
	
	if($_PERFIL==26){
		echo $institucion."  ".$frmModo."  ".$ano."  ".$perfil;	
	}
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	

	
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../../clases/jquery-ui-1.9.2.custom/development-bundle/demos/demos.css">
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
<SCRIPT language="JavaScript" src="../../../../util/chkform.js">
</script>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					//exit();
				}
			}
		}
	}
?>
	<HEAD>
	
	
	<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>
<script>
function Permiso(){
	var total_checko = $("input.rpt[type=checkbox]:checked").length;
	var fr='Ingrese contrase&ntilde;a <input name="clave" type="password" id="clave">'; 
	
	if(total_checko>0)
	{
	 $("#formfirma").html(fr);
	$("#formfirma").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 300,
   Height: 100,
   minWidth: 300,
   minHeight: 100,
   maxWidth: 300,
   maxHeight: 100,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		
		  if($('#clave').val().length==0){
			  alert("Ingrese su contraseña");
			  return false;
			 }
			 
		  else{
			 ingresar_firma(); 
			 }
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  })
	}else{
	alert("Debe seleccionar al menos 1 reporte");
	}
}

function ingresar_firma(){
	var emp = $('#clave').val();
	var searchIDs = [];
$("input.rpt[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
  
  var parametros = "emp="+emp+"&repos="+searchIDs;
  $.ajax({
		url:"validacion/valfirma.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data)
				if(data == 0){
				   alert("Clave inválida");
				}else{
				   //$('#chknota').html(data);
				   alert('Datos almacenados');
				   location.reload();
				  
				}
			}
		})

}
</script>
	
<style type="text/css">
<!--
.Estilo1 {color: #0033FF}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<? include("../../../../cabecera/menu_superior.php");?>				 				
				</td>
				</tr>
				</table>
					
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
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
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
								  
	
	<FORM method=post name="frm">
	  <TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
	  <TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD width="597" align=left></td>
						</tr>
					</table>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 align="center">
					  
					  <TR>
							<TD align=left class="textonegrita"><strong>AÑO ESCOLAR</strong>							</TD>
							<TD>
									<strong>:</strong>							</TD>
							<TD>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila22 = @pg_fetch_array($result,0);	
													if (!$fila22){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila22['nro_ano']);

												}
											}
										?>
									</strong>							</TD>
						</TR>
					</TABLE>				</TD>
		</TR>
	  <TR height=15>
	    <TD>&nbsp;</TD>
	    </TR>
	  </TABLE>
	  
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="811" height="508" align="center" valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="100%" align="center" valign="top"><div align="left"> 
              <p class="fondo">Reportes</p>
            </div></td>
        </tr>
        <tr> 
          <td height="640" align="center" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td align="left" valign="top" class="textonegrita"><p><img src="../../../../images/icono_reportes.png">
                  <?
				if ($situacion !=0){ 
				if($_PERFIL!=15 && $_PERFIL!=16){ ?>
                <!--boton-->
                <input name="" class="botonXX" type="button" value="Guardar" onClick="Permiso()">&nbsp;&nbsp;<input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver" onclick="window.location='Menu_Reportes_new2.php'">
                  <? } 
					
				}?>
                    <a href="listaConfiguracionReporte.php"><br>
                    </a></p></td>
              </tr>
              <tr>  
                <td align="left" valign="top">
                  <table width="100%" border="0">
                  <tr>
                    <td valign="top" width="50%">
                      <? $ob_reporte =new Reporte();
						$result=$ob_reporte->Menu($conn);
						$contador =1;
						for($i=0;$i<7;$i++){
							$fila=@pg_fetch_array($result,$i);
					?>
                      <table width="100%" border="0">
                        <tr>
                          <td colspan="3" class="cuadro02"><?=$fila['nombre'];?></td>
					      </tr>
                        <? 	$ob_reporte->reporte=$fila['id_reporte'];
							$ob_reporte->perfil=$perfil;
							$ob_reporte->rdb=$institucion;
							if($_PERFIL==0 || $_PERFIL==14){
								$rs_item=$ob_reporte->ItemMenu($conn);
							}else{
								$rs_item=$ob_reporte->ItemReporte($conn);
							}
							
							
							
							for($z=0;$z<@pg_numrows($rs_item);$z++){
								$fils_item = @pg_fetch_array($rs_item,$z);
								
								$ob_reporte->item= $fils_item['id_item'];
								$ob_reporte->usuario= $_NOMBREUSUARIO;
								$rp = $ob_reporte->checAutReporte($conn);
								
								
						?>
                        <tr>
                          <td><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
						  <td class="cuadro01">&nbsp;<? echo $contador.".- ".$fils_item['nombre'];?></td>
						  <td class="cuadro01"><input id="aut<?=$fils_item['id_item']?>" type="checkbox" value="<?=$fils_item['id_item']?>" name="reporte[]" class="rpt" <?php echo (pg_result($rp,0)==$fils_item['id_item'])?"checked":""; ?>></td>
					    </tr>
                        <? $contador++;
					  } if(@pg_numrows($rs_item)==0){?>
						 <tr>
                            <td><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                          <td class="cuadro01">&nbsp;No hay reporte autorizado</a></td>
                          <td class="cuadro01">&nbsp;</td>
                         </tr>
					<?	} ?>
                        </table>
					  <? 
					} ?>					</td>
                      <td width="50%" valign="top">
                        <? for($x=$i;$x<=@pg_numrows($result);$x++){
						$fila =@pg_fetch_array($result,$x);
						
					?>
                        <table width="100%" border="0">
                          <tr>
                            <td colspan="3" class="cuadro02"><?=$fila['nombre'];?></td>
                          </tr>
                          <? 	$ob_reporte->reporte=$fila['id_reporte'];
								$ob_reporte->perfil=$perfil;
								if($_PERFIL==0 || $_PERFIL==14){
									$rs_item=$ob_reporte->ItemMenu($connection);
								}else{
									$rs_item=$ob_reporte->ItemReporte($conn);
								}
							
						for($y=0;$y<@pg_numrows($rs_item);$y++){
							$fils_item = @pg_fetch_array($rs_item,$y);
							
							 $ob_reporte->item= $fils_item['id_item'];
								$ob_reporte->usuario= $_NOMBREUSUARIO;
								$rp = $ob_reporte->checAutReporte($conn);
							?>
                          <tr>
                            <td><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                          <td class="cuadro01">&nbsp;<? echo $contador.".- ".$fils_item['nombre'];?></td>
                          <td class="cuadro01"><input id="aut<?=$fils_item['id_item']?>" type="checkbox" value="<?=$fils_item['id_item']?>" name="reporte[]" class="rpt" <?php echo (pg_result($rp,0)==$fils_item['id_item'])?"checked":""; ?>></td>
                          </tr>
                          <? $contador++;
					 } 
					 	if(@pg_numrows($rs_item)==0){?>
						 <tr>
                            <td><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                          <td class="cuadro01">&nbsp;No hay reporte autorizado</a></td>
                          <td class="cuadro01">&nbsp;</td>
                         </tr>
					<?	} ?>
                          </table>
					  <? 
					 }?>                        </td>
                  </tr>
                </table></td></tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
        <tr> 
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr> 
          <td height="44" align="center" valign="middle"> <table width="40%" border="0" cellpadding="0" cellspacing="0" class="boton02">
              <tr align="center" valign="middle"> 
                <td height="23"><img src="../../../../cortes/volver2.png" width="18" height="18"> 
                  Volver</td>
                <td><img src="../../../../cortes/subir2.png" width="18" height="18"> Subir</td>
                </tr>
            </table></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>  
</table>
    </FORM>
	
	
								 
   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
<div id="formfirma" title="Validar usuario"></div>
</body>
</html>
<? pg_close($conn);?>
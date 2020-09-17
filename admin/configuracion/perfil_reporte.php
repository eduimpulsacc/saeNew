<?	require('../../util/header.inc');
	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 2;
	$_bot = 8;

	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);

	$caso=1;	
	if($cmbPERFIL!=0){
		  $sql = "SELECT id_item FROM perfil_reporte WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL;
		$result = @pg_exec($conn,$sql);
		if(@pg_numrows($result) > 0){
			for($i=0;$i<@pg_numrows($result);$i++){
				$fila = @pg_fetch_array($result,$i);
				$perfil_reporte[$i]=$fila['id_item'];
			}
			$caso=2;
		}
	}
	$sql="SELECT id_reporte, nombre FROM reporte ORDER BY id_reporte ASC";
	$resultMenu =@pg_exec($connection,$sql);
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
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
function enviapag(perfil){
	if(document.form.cmbPERFIL.value!=0){
		form.action='perfil_reporte.php';
		form.submit(true);
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
function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
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
                      <td height="363" align="left" valign="top"> 
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
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
									  <tr> 
										<td width="" height="30" align="center" valign="top"> </td>	  
									  </tr> 
								  </table>
 								  								  
								  <form id="form" name="form" action="procesorReporte.php" method="post">
								  <input name="caso" type="hidden" value="<?=$caso;?>">
								    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td class="tableindex"><div align="center">CONFIGURACI&Oacute;N PERFIL REPORTE </div></td>
                                      </tr>
                                    </table><br>
									<table width="650" border="0" align="center" cellpadding="0" cellspacing="5">
									  <tr>
										<td width="240"><div align="right" class="Estilo7">Perfil&nbsp;</div></td>
										<td width="183">
										<select name="cmbPERFIL" onChange="enviapag(this.value)">
										<option value="0" selected="selected">seleccione</option>
										<? 	$sql = "SELECT id_perfil,nombre_perfil FROM perfil WHERE id_perfil not in (0,24)  ORDER BY nombre_perfil ASC ";
											$rs_perfil = @pg_exec($connection,$sql);
											for($i=0;$i<@pg_numrows($rs_perfil);$i++){
												$fila_perfil = @pg_fetch_array($rs_perfil,$i);
												if($fila_perfil['id_perfil']==$cmbPERFIL){?>
													<option value="<?=$fila_perfil['id_perfil'];?>" selected="selected"><?=$fila_perfil['nombre_perfil'];?></option>
											<? }else{ ?>
													<option value="<?=$fila_perfil['id_perfil'];?>"><?=$fila_perfil['nombre_perfil'];?></option>
												<? }
											 } ?>
										</select>    </td>
										<td width="83"><div align="right">
										<? if ($situacion !=0){
										if($caso==1){ 
												if($ingreso==1){?>
												  <input type="submit" name="Submit" value="AGREGAR" class="botonXX">
										<? 		}
											}
										}// cierre if año escolar?>
										<? if($caso==2){
												if($modifica==1){?>
												  <input type="submit" name="Submit3" value="MODIFICAR" class="botonXX">
										 <? 	}
										 	} ?>
										</div></td>
									  </tr>
									</table>
									<br>
									<table width="100%" border="0">
                                      <tr>
                                        <td valign="top" class="textonegrita"> TODOS <input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);"></td>
                                        <td valign="top">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td valign="top" width="50%"><? 
						
									$contador =1;
									for($i=0;$i<7;$i++){
										$fila=@pg_fetch_array($resultMenu,$i);
								?>
										
										<table width="100%" border="0">
										  <tr>
											<td colspan="2" class="cuadro02"><?=$fila['nombre'];?></td>
										  </tr>
										  <? 	
										  	 $sql = " SELECT * FROM item_reporte WHERE id_reporte=".$fila['id_reporte']." ORDER BY id_reporte, id_item ASC";
											$rs_item=@pg_exec($connection,$sql);
										
										for($z=0;$z<@pg_numrows($rs_item);$z++){
											$fils_item = @pg_fetch_array($rs_item,$z);
											$ok=0;
											for($m=0;$m<@pg_numrows($result);$m++){
												if($fils_item['id_item']==$perfil_reporte[$m])
													$ok=1;
											}?>
										  <tr>
											<td>
											<input name="ck_reporte<?=$contador;?>" type="checkbox" value="<?=$fils_item['id_item'];?>"  <? if($ok==1) echo "checked=checked";?>>											</td>
											<td class="cuadro01">&nbsp;<? echo $contador.".- ".$fils_item['nombre'];?></td>
										  </tr>
										  <? $contador++;
										  } ?>
										</table>
										<? 	} ?>										</td>
										<td width="50%" valign="top">
										<? for($x=$i;$x<=@pg_numrows($resultMenu);$x++){
											$fila =@pg_fetch_array($resultMenu,$x);
											
											?>
											<table width="100%" border="0">
											  <tr>
												<td colspan="2" class="cuadro02"><?=$fila['nombre'];?></td>
											  </tr>
											 <? 	
											$sql = " SELECT * FROM item_reporte WHERE id_reporte=".$fila['id_reporte']." ORDER BY id_reporte, id_item ASC";
											$rs_item=@pg_exec($connection,$sql);
							
										for($y=0;$y<@pg_numrows($rs_item);$y++){
											$fils_item = @pg_fetch_array($rs_item,$y);
											$ok=0;
											for($m=0;$m<@pg_numrows($result);$m++){
												if($fils_item['id_item']==$perfil_reporte[$m])
													$ok=1;
											}?>
											  <tr>
												<td><input name="ck_reporte<?=$contador;?>" type="checkbox" value="<?=$fils_item['id_item'];?>" <? if($ok==1) echo "checked=checked";?>></td>
												<td class="cuadro01">&nbsp;<? echo $contador.".- ".$fils_item['nombre'];?></td>
											  </tr>
											  <? $contador++;
											 } ?>
											</table>
										  <?  }?>										</td>
									  </tr>
									</table>
									<br>
									<input name="contador" type="hidden" value="<?=$contador;?>">
								  </form>
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
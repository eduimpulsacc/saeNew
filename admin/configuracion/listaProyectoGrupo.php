<?	require('../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 2;
//	$_bot = 8;
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);


	
	
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
.Estilo13 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
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
				<?
				include("../../cabecera/menu_superior.php");
				?>				 
				
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
								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
									  <tr> 
										<td width="" height="30" align="center" valign="top"> </td>	  
									  </tr> 
								</table>
 								  								  
								  <br>
								  <table width="650" border="0" align="center">
                                    <tr>
                                      <td><div align="right">
									  <? 
									  if ($situacion !=0){
									  if($ingreso==1){?>
                                        <input name="AGREGAR" type="button" value="AGREGAR" onClick="window.location='proyecto_grupo.php?caso=3'" class="botonXX">
									  <? } 
									  }//cierre if año escolar?>
										<? if($_PERFIL==0){?>
										<input name="DIAGNOSTICO" type="button" value="DIAGNOSTICO" onClick="window.location='diagnostico.php?caso=3'" class="botonXX">
										<? } ?>
                                      </div></td>
                                    </tr>
                                  </table>
								  <form id="form" name="form" action="procesa_ciclo.php?rdb=<?=$institucion?>&tipo=1&ano=<?=$ano?>" method="post">
								    <table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td class="tableindex">PROYECTO DE INTEGRACI&Oacute;N </td>
                                      </tr>
                                    </table>
                                    <table width="650" border="0" align="center" cellpadding="3" cellspacing="2">
                                      <tr class="tableindex">
                                        <td width="19">N&ordm;</td>
                                        <td width="244">NOMBRE</td>
                                        <td width="199">PROFESIONAL</td>
                                        <td width="154">OBSERVACIONES</td>
                                      </tr>
									  <?  $sql = "select a.id_proy,a.nombre,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' '  as varchar) || ape_mat as empleado, a.objetivo FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$institucion." AND tipo=1";
										  $rs_proyecto = @pg_exec($conn,$sql);
									  
									  	for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
											$fila_pro = @pg_fetch_array($rs_proyecto,$i);
											$cont++;

											if($modifica==1 || $ver==1){

									?> 
                                      <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick="window.location='proyecto_grupo.php?caso=1&id_pro=<?=$fila_pro['id_proy'];?>'">
									  <? }else{
										  ?>
									  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'>
									  <? } ?>
                                        <td><span class="Estilo13"><?=$cont;?></span></td>
                                        <td><span class="Estilo13"><?=$fila_pro['nombre'];?></span></td>
                                        <td><span class="Estilo13"><?=$fila_pro['empleado'];?></span></td>
                                        <td><span class="Estilo13"><?=substr($fila_pro['objetivo'],0,20)."...";?></span></td>
                                      </tr>
                                    <? } ?>
									</table>
									<br><br>
									<table width="650" border="0" align="center" cellpadding="3" cellspacing="0">
                                      <tr>
                                        <td class="tableindex">GRUPO DIFERENCIAL </td>
                                      </tr>
                                    </table>
                                    <table width="650" border="0" align="center" cellpadding="3" cellspacing="2">
                                      <tr class="tableindex">
                                        <td width="19">N&ordm;</td>
                                        <td width="244">NOMBRE</td>
                                        <td width="199">PROFESIONAL</td>
                                        <td width="154">OBSERVACIONES</td>
                                      </tr>
									    <? $sql = "select a.id_proy,a.nombre,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' '  as varchar) || ape_mat as empleado, a.objetivo FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$institucion." AND tipo=2";
									  $rs_proyecto = @pg_exec($conn,$sql);
									  
									  	for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
											$fila_pro = @pg_fetch_array($rs_proyecto,$i);
											$conta++;
											if($modifica==1 || $ver==1){
									?> 
                                       <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('proyecto_grupo.php?caso=1&id_pro=<?=$fila_pro['id_proy'];?>')>
									   <? }else{?>
                                       <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'>
									   <? } ?>
                                       <td><span class="Estilo13"><?=$conta;?></span></td>
                                        <td><span class="Estilo13"><?=$fila_pro['nombre'];?></span></td>
                                        <td><span class="Estilo13"><?=$fila_pro['empleado'];?></span></td>
                                        <td><span class="Estilo13"><?=substr($fila_pro['objetivo'],0,20)."...";?></span></td>
                                      </tr>
									  <? } ?>
                                    </table>
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
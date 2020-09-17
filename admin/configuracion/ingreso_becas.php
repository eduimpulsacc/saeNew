<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP=2;
	
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
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->

<SCRIPT language="JavaScript">

function eliminar(form){
	if(confirm("¿Desea eliminar la tarea seleccionada?")){
		form.action = 'procesaagregar_becas.php?tipo=4';
		form.submit(true);
	}	
}

function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function eliminar_sub_simce(subsector,ano,grado,ensenanza,id_sim,rdb){
	if(confirm("SE ELIMARA EL SUBSECTOR Y LOS PUNTAJES RELACIONADOS.")){
		window.location='procesaagregarsubsector_simce.php?tipo=2&cod_subsector='+subsector+'&ano='+ano+'&grado='+grado+'&ensenanza='+ensenanza+'&id_sub_sim='+id_sim+'&rdb='+rdb
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
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
                              <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->	
<FORM method="post" name="form" action="agregasubsector_simce.php">

  <div align="right">
  <? 
  if ($situacion !=0){
  if($ingreso==1){?>
    <input name="AGREGAR" type="button" class="botonXX" onClick="window.location='config_becas.php'" id="volver" value="AGREGAR">
  <? } 
  }//cierre if año escolar?>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cuadro01">
      <tr>
        <td colspan="4" class="tableindex">BECAS</td>
        </tr>
      <tr>
        <td colspan="4" class="tableindex">&nbsp;&nbsp;<input type="button" name="borrar_simce2" value="E" class="botonXX"> 
          ELIMINAR </td>
          </tr>
      <tr>
        <td width="25%">&nbsp;</td>
        <td width="40%" class="cuadro02"><div align="center">NOMBRE BECA </div></td>
          <td width="10%" class="cuadro02"><div align="center">
            <input type="button" name="borrar_simce22" value="E" class="botonXX">
          </div></td>
          <td width="25%">&nbsp;</td>
      </tr>
      <? $sql = "SELECT * FROM becas_conf WHERE id_ano=".$ano;
		 $res_sql = pg_exec($conn,$sql);
		 $cuenta = pg_numrows($res_sql);
		
		for($i=0;$i<$cuenta;$i++){
		$becas=pg_fetch_array($res_sql,$i);
	?>
      <tr>
        <td width="25%">&nbsp;</td>
        <? if($modifica==1){?>
		<td width="40%" onClick="window.location='config_becas.php?id_beca=<?=$becas['id_beca'];?>&tipo=3'" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='transparent'>&nbsp;&nbsp;
	    <? }else{ ?>
		<td width="40%" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='transparent'>&nbsp;&nbsp;
		<? } ?>
		    <div align="center">
            <?=ucfirst($becas['nomb_beca'])?>
            </div></td>
          <td width="10%"><div align="center">
		  <? if($elimina==1){?>
            <input type="button" name="borrar_simce" value="E"  class="botonXX" onClick="eliminar(this.form)">
		<? } ?>
            <input type="hidden" name="id_beca" value="<?=$becas['id_beca'];?>">
          </div></td>
          <td width="25%">&nbsp;</td>
      </tr>
      <? }?>
      <tr>
        <td width="25%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="25%">&nbsp;</td>
      </tr>
    </table>
  </div>
</form>


	
<!-- FIN CUERPO DE LA PAGINA -->

 								  								  
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
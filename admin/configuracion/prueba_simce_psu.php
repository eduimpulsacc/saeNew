<?	require('../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	$_POSP = 2;


	
	
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

<script language="javascript" type="text/javascript">


</script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->
<script type="text/javascript" language="javascript">
function agregar(form2){
	if(document.form2.count.value < 6){
			form2.submit(true);
	}else{
			alert("YA SE AGREGARON TODOS LOS SUBSECTORES.");
	}
}
			 </script>
<SCRIPT language="JavaScript">
function enviapag(){
	form.submit(true);
}
function borrar_psu(){

}
function eliminar_sub(cod_psu,ano,cod_sub_psu){
	if(confirm("SE ELIMARAN LOS PUNTAJES RELACIONADOS.")){
		window.location='procesaagregarsubsector_psu.php?tipo=2&cod_sub_psu='+cod_sub_psu+'&cod_subsector='+cod_psu+'&cod_ano='+ano+'&caso=1'
	}
}
function ponderaciones(cod_subsector,cod_sub_psu){
		window.location='detalle_ponderacion_psu.php?cod_subsector='+cod_subsector+'&cod_sub_psu='+cod_sub_psu
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
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
<FORM method="post" name="form" action="agregasubsector_simce.php">
	
			<?php
				
			?>
		<center>		 
		 <table width="70%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td></td>
              <td colspan="2"><div align="right">
			  <? 
			  if ($situacion ==0){
			  if($ingreso==1){?>
                <input type="submit" name="Submit2" value="Agregar" class="botonXX">
			  <? } 
			  }?>
              </div></td>
              </tr>
            <tr>
              <td width="50%" class="tableindex">
                <div align="left">
				&nbsp;&nbsp;&nbsp;
                  <input type="button" value="E" class="botonXX">
                  <?="ELIMINAR"?>
                  </div></td>
              <td colspan="2" class="tableindex">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" class="tableindex">SIMCE&nbsp;</td>
              </tr>
            <tr>
              <td class="tablatit2-1">Subsectores</td>
              <td class="tablatit2-1">Grado</td>
              <td class="tablatit2-1">E</td>
            </tr>
				<? 	$sql = "SELECT * FROM simce_conf_2009 WHERE id_ano=".$_ANO." and rdb=".$institucion." ORDER BY grado ASC";
				$resp = pg_exec($conn,$sql);
				$num_simce = pg_numrows($resp);
				for($i=0;$i<$num_simce;$i++){
				$simce = pg_fetch_array($resp,$i);
			?>
            <tr>
              <td class="cuadro01">
			  <?
			  if($simce['ensenanza']==110){
			  	if($simce['grado']==4){
					 	switch ($simce['cod_subsector']) {
					 case 14:
						  echo "LENGUAJE Y COMUNICACION";
						  break;
					 case 15:
						  echo "EDUCACION MATEMATICA";
						  break;
					 case 132:
						  echo "COMPRENSION DEL MEDIO NATURAL";
						  break;
				 	 case 133:
						  echo "COMPRENSION DEL MEDIO SOCIAL Y CULTURAL";
						  break;
					 case 89:
						  echo "ESCRITURA";
						  break;
				  }
				}
				
			  if($simce['grado']==8){
					 	switch ($simce['cod_subsector']) {
					 case 14:
						  echo "LENGUAJE Y COMUNICACION";
						  break;
					 case 15:
						  echo "EDUCACION MATEMATICA";
						  break;
					 case 20:
						  echo "ESTUDIO Y COMPRENSION DE LA NATURALEZA";
						  break;
				 	 case 21:
						  echo "ESTUDIO Y COMPRENSION DE LA SOCIADAD";
						  break;
				  }
				}		
				
			 }
			 
		    if($simce['ensenanza']!=110){
			  	if($simce['grado']==2){
					switch ($simce['cod_subsector']) {
					 case 27:
						  echo "LENGUA CASTELLANA Y COMUNICACION";
						  break;
					 case 5:
						  echo "MATEMATICA";
						  break;
						  }
				}	
			 }	 
			  ?>
			  </td>
              <td class="cuadro01" align="center"><?=$simce['grado']."º";
			  if($simce['ensenanza']==110){
			  echo " Básico";
			  }else{
			  echo " Medio";
			  }?></td>
              <td class="cuadro01">
			  <? if($elimina==1){?>
			  <input type="button" name="borrar_simce" value="E" onClick="javascript:eliminar_sub_simce(<?=$simce['cod_subsector']?>,<?=$_ANO?>,<?=$simce['grado']?>,<?=$simce['ensenanza']?>,<?=$simce['id_sub_sim']?>,<?=$institucion?>)" class="botonXX">
			  <? } ?>
			  </td>
            </tr>
			<? }?>
          </table>
		  </center>
		  </form>
		  <form name="form2" method="post" action="agregasubsector_psu.php">
		 <center>
		 <? 	$sql = "SELECT * FROM psu_conf_2009 WHERE cod_ano=".$_ANO;
				$resp = pg_exec($conn,$sql);
				$num_psu = pg_numrows($resp);

			?>
		  <table width="70%" border="0" cellpadding="0" cellspacing="0">

            <tr>
              <td></td>
              <td colspan="3"><div align="right">
			  <?
			   if ($situacion ==0){
			   if($ingreso==1){?>
                <input type="button" name="Submit2" onClick="javascript:agregar(this.form);" value="Agregar" class="botonXX">
			  <? } 
			   }?>
              </div></td>
              </tr>
            <tr>
              <td class="tableindex" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;
			  <? if($elimina==1){?>
			  <input type="button" value="E" class="botonXX"><?="ELIMINAR"?>
			  <? } ?>
			  &nbsp;&nbsp;&nbsp;&nbsp;
			  <? if($ingreso==1 || $modifica==1){?>
			  <input type="button" value="P" class="botonXX"><?="PONDERACIONES"?>
			  <? } ?>
              </td>
              <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4" class="tableindex">PSU&nbsp; (4tos Medios) </td>
              </tr>
            <tr>
              <td class="tablatit2-1">Subsectores</td>
              <td class="tablatit2-1">&nbsp;</td>
              <td class="tablatit2-1">&nbsp;</td>
              <td class="tablatit2-1">&nbsp;</td>
            </tr>
			<? 
				for($i=0;$i<$num_psu;$i++){
				$valor = 0;
				$fila_sub_psu = pg_fetch_array($resp,$i);
				$cod_psu = $fila_sub_psu['cod_subsector'];
				$cod_sub_psu = $fila_sub_psu['cod_sub_psu'];
				?>
            <tr>
              <td class="cuadro01"><?
			  	switch ($cod_psu) {
					 case 1:
						  echo "HISTORIA Y CIENCIAS SOCIALES";
						  break;
					 case 2:
						  echo "MATEMATICA";
						  break;
					 case 3:
						  echo "BIOLOGIA";
						  break;
				 	 case 4:
						  echo "QUIMICA";
						  break;
					 case 5:
						  echo "FISICA";
						  break;
					 case 6:
						  echo "LENGUA CASTELLANA Y COMUNICACION";
						  break;
					 case 7:
						  echo "CIENCIAS";
						  break;
				 }
			  ?></td>
			  <td class="cuadro01" align="center">&nbsp;</td>
              <td class="cuadro01">
			    <? if($elimina==1){?>
				  <input type="button" name="borrar_psu" value="E" onClick="javascript:eliminar_sub(<?=$cod_psu?>,<?=$_ANO?>,<?=$cod_sub_psu?>)" class="botonXX">
				<? } ?>  
				  </td>
              <td class="cuadro01">
			  	<? if($modifica==1 || $ingreso==1){?>
			  <input type="button" name="ponderacion" value="P" onClick="javascript:ponderaciones(<?=$cod_psu?>,<?=$cod_sub_psu?>)" class="botonXX">
			  	<? } ?>
			  </td>
            </tr>
			<?
			 $valor = $valor +$i;
			 }?>
			 
			 <input type="hidden" name="count" id="count" value="<?=$valor?>">
			</table>
		</center>			
</FORM>

	
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
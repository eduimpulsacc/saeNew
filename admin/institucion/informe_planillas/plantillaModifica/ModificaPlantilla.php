<?php require('../../../../util/header.inc');

$institucion =$_INSTIT;
$ano		=$_ANO;
$Modo		=$_FRMMODO;
$plantilla	=$_PLANTILLA;
$_POSP = 4;
$_bot = 7;

if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";


	$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
	$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
	
	//trae areas
	$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$plantilla;
	$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
	$filaTraeArea = @pg_fetch_array($resultTraeArea,0);

	$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
	$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);

	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
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
<script>
function Confirmacion(form){
		var pla=form.hiddenPlantilla.value;
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			//window.location='procesoPlantilla.php?plantilla=pla&eliminar=1'
			form.action='procesoPlantilla.php?eliminar=1';
			form.submit(true);
		};
function Modifica(form){
		form.target='_parent';
		form.action='modificarPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function agregaReg(form){
		form.target='_parent';
		form.action='agregarRegistrosPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

</script>
</head>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
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
							<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      
	  
	    <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  
	  
<form action="procesoPlantilla.php" method="post" name="form">

  <br>  <br>  <br>  <br>
      <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td> <div align="right">
		  <? if ($Modo!="modificar"){ ?>
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="modificar" value="MODIFICAR" onClick="window.location='seteaPlantilla.php?caso=3&plantilla=<? echo $plantilla;?>'">
          <? }else{    ?>
			  <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="guardar" value="GUARDAR" onClick="javascript:document.form.submit(true);">
		  <? } ?>	  
			  <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="volver" value="VOLVER" onClick="window.location='listaPlantillas.php'">
			  <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Agregar" value="AGREGAR ITEM" onClick="window.location='plantilla.php'">
            </div></td>
	  </tr>
	</table>
<br>
	  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
        <td colspan="3" class="tableindex"> <div align="center">MODIFICA 
          PLANTILLA DE INFORME</div></td>
	  </tr>
	</table>
<BR>
      <table  width="500" border="0" align="center" cellpadding="0" cellspacing="1">
        <? for($i=0;$i<@pg_numrows($resultTraeArea);$i++){
		$filaTraeArea= @pg_fetch_array($resultTraeArea,$i); ?>
        <? //trae subareas para cada area y las imprime
			$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
			$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
			$filaTraeSubarea = @pg_fetch_array($resultTraeSubarea,0);?>
        <tr> 
          <td width="52" bordercolor="#FFFFFF"><font face="arial, Helvetica, sans-serif" size="2"> 
            AREA </font></td>
          <td width="225" bordercolor="#FFFFFF"><font face="arial, Helvetica, sans-serif" size="2"> 
            <? if ($Modo=="modificar"){?>
            <input name="NomArea[<? echo $i ?>]" type="text" value="<? echo $filaTraeArea['nombre'];?>" size="20">
			<input name="IdArea[<? echo $i ?>]" type="hidden" value="<? echo $filaTraeArea['id_area'];?>" size="20">
            <? }else{  echo $filaTraeArea['nombre']; }?>
            </font></td>
          <td width="72"><font face="arial, Helvetica, sans-serif" size="2">SUB AREA </font>
          <td width="146"><font face="arial, Helvetica, sans-serif" size="2">
            <? if ($Modo=="modificar"){?>
	            <input name="NomSubArea[<? echo $i ?>]" type="text" value="<? echo $filaTraeSubarea['nombre'];?>" size="20">
				<input name="IdSubArea[<? echo $i ?>]" type="hidden" value="<? echo $filaTraeSubarea['id_subarea'];?>">

            <? }else{ 
				echo $filaTraeSubarea['nombre']; } ?>
		        </font>
		</td>
		</tr>
        <tr bgcolor="#48d1cc"> 
          <td colspan="4" class="tableindex"><div align="center">Detalle de Item</div></td>
        </tr>
        <? 	//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
			$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
			$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
			for($j=0;$j<@pg_numrows($resultTraeItem);$j++){
				$filaTraeItem = @pg_fetch_array($resultTraeItem,$j);
				$CantItem=$CantItem+1;?>
        <tr> 
          <td colspan="4"><font face="arial, Helvetica, sans-serif" size="2"> 
            <? if ($Modo=="modificar"){?>
				<input name="NomItem[<? echo $CantItem ?>]" type="text" value="<? echo $filaTraeItem['glosa'];?>" size="70">
				<input name="IdItem[<? echo $CantItem ?>]" type="hidden" value="<? echo $filaTraeItem['id_item'];?>">
			<? }else{	
				echo $filaTraeItem['glosa']; }?>
				</font>
		  </td>
        </tr>
        <?	
			} // fin FOR ITEM?>

        <tr> 
          <td colspan="4">&nbsp;</td>
        </tr>
        <?	$CantArea = $CantArea+1;
			} // Fin ciclo?>
      </table>
	 <input name="CantItem" type="hidden" value=" <? echo $CantItem;?>">
 	 <input name="CantArea" type="hidden" value="<? echo $CantArea; ?>">
</form>
						   
						       <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

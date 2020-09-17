<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$frmModo		=$_FRMMODO;
	$_POSP = 6;
	$_bot = 2;
	
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
	if ($frmModo==NULL){
	    $_FRMMODO = "mostrar";
	    $frmModo = "mostrar";
	}	
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
	<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
	

    <style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color:#666666
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
    </style>
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						 $menu_lateral=2;
						 include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  


	<center>
	  <table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td bgcolor="#666666"><table width="100%" height="50" border="0" cellpadding="3" cellspacing="0">
            <tr>
              <td width="50%" bgcolor="#FFFFFF" class="cuadro02"><div align="right">SUBSECTOR APRENDIZAJE </div></td>
              <td width="50%" bgcolor="#FFFFFF" class="cuadro01"><label>
			  <? if($ingreso==1){?>
                <input name="Submit2" type="button" onClick="MM_goToURL('parent','form_subsector.php');return document.MM_returnValue" value="CONFIGURAR SUBSECTOR APRENDIZAJE" class="botonXX">
				<? } ?>
              </label></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td class="tableindex"><div align="center"><br>ADMINISTRACI&Oacute;N TIPOS DE ANOTACIONES </div><br></td>
            </tr>
            <tr>
              <td><div align="right">
                  <label>
				  <?
				   if ($situacion !=0){
				   if($ingreso==1){?>
                  <input name="Submit" type="button" onClick="MM_goToURL('parent','form_configuracion.php');return document.MM_returnValue" value="AGREGAR"  class="botonXX">
				  <? } 
				   }//ciere if año escolar?>
                  </label>
              </div></td>
            </tr>
            <tr>
              <td><?
		  $q1 = "select * from tipos_anotacion where rdb = '".trim($institucion)."' order by id_tipo";
		  $r1 = pg_Exec($conn,$q1);
		  $n1 = pg_numrows($r1);
		  ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10%" height="30" class="cuadro02"><div align="center">GRUPO</div></td>
                      <td width="70%" class="cuadro02"><div align="center">TIPO DE ANOTACI&Oacute;N 
					 
                      </div></td>
                      <td colspan="2" class="cuadro02"><div align="center" class="Estilo1">&nbsp; </div></td>
                    </tr>
                    <?
			if ($n1>0){ 
			    $i = 0;
				while ($i < $n1){				
				    $f1 = pg_fetch_array($r1,$i);
					$id_tipo     = $f1['id_tipo'];
					$codtipo     = $f1['codtipo'];
					$descripcion = $f1['descripcion'];
					
					?>
                    <form name="form1" method="post" action="form_configuracion.php">
                      <input type="hidden" name="anotacion" value="editar">
                      <input type="hidden" name="id_tipo" value="<?=$id_tipo ?>">
                      <tr>
                        <td height="35" class="cuadro02"><div align="center">
                          <? if ($_PERFIL==0){ ?><?=$id_tipo ?>  -  <? } ?><?=$codtipo ?>
                        </div></td>
                        <td colspan="2" class="cuadro02"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><span class="Estilo2">
                                <?=$descripcion ?>
                              </span></td>
                              <td width="10%"><div align="right">
							   <? if($modifica==1){?>
                                <input name="E" type="submit" value="EDITAR TIPO DE ANOTACION"  class="botonXX">
								<? } ?>
                              </div></td>
                            </tr>
                          </table>
                            <div align="center"></div></td>
                        <td width="10%" class="cuadro02"><div align="center">
						<? if($elimina==1){?>
                            <input name="B" type="button" value="BORRAR"  class="botonXX" onClick="window.location='proceso_configuracion.php?elimina=1&id_tipo=<?=$id_tipo;?>'">
						<? } ?>
                        </div></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td><!-- detalle de subanotaciones  -->
                            <?
					// busco el detalle de las anotaciones
					$q2 = "select * from detalle_anotaciones where id_tipo =".trim($id_tipo)." order by id_anotacion";
					$r2 = pg_Exec($conn,$q2);
					$n2 = pg_numrows($r2);
					
					if ($n2 > 0){  ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="3">
                              <tr>
                                <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                                    <tr>
                                      <td width="10%" height="35" class="cuadro01"><div align="center">CODIGO</div></td>
                                      <td width="70%" class="cuadro01"><div align="center">DESCRIPCI&Oacute;N</div></td>
                                    </tr>
                                    <?
						     $j = 0;
						     while ($j < $n2){
						         $f2 = pg_fetch_array($r2,$j);
							     $codigo = $f2['codigo'];
							     $detalle = $f2['detalle'];							
								 ?>
                                    <tr>
                                      <td><div align="center" class="Estilo1">
                                        <?=$codigo ?>
                                      </div></td>
                                      <td><span class="Estilo1">
                                        <?=$detalle ?>
                                        </font></span></td>
                                    </tr>
                                    <?
								 $j++;
							 }	 
							 ?>
                                </table></td>
                              </tr>
                            </table>
                          <? } ?>
                            <!-- fin detalle de anotaciones -->
                            <br>
                            <br></td>
                        <td width="10%">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </form>
                    <?
					$i++;
				}
			}
			?>
                </table></td>
            </tr>
          </table></td>
        </tr>
      </table>
	  </center>
					  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

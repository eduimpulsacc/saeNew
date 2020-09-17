<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
   
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
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
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
function valida($num) {
	$num=$numero;
	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};


	frm.submit()
	
}

//-->
</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">					  
					  <form name="form1" method="post" action="">
                        <table width="669" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td colspan="4" align="center"><font face="Arial, Helvetica, sans-serif" size="3"><b>Criterios Selecci&oacute;n</b></font></td>
                            <td colspan="2"><div align="right">
							<? 
							if ($situacion !=0){
							if($ingreso==1){?>
							<input class="botonXX"  type="button" value="AGREGAR" onClick="document.location='agregar_seleccion.php'">
							<? } 
							}//cierre if año escolar?>
							</div></td>
                          </tr>
                          <tr class="tablatit2-1">
                            <td width="61">curso </td>
                            <td width="173">ense&ntilde;anza</td>
                            <td width="173">Descripcion</td>
                            <td width="51">Sigla</td>
                            <td width="82">Ponderación</td>
                            <td width="81">editar</td>
                            <td width="48">borrar</td>
                          </tr>
                          <?
				$sql="SELECT * FROM Criterio_seleccion where id_ano=$ano order by grado desc";
				$result = @pg_Exec($conn,$sql);
				for($i=0;$i < @pg_numrows($result);$i++){
					$fila = @pg_fetch_array($result,$i);
						$sqlensenanza="SELECT nombre_tipo FROM tipo_ensenanza where cod_tipo=".$fila["ensenanza"];
						$result2 = @pg_Exec($conn,$sqlensenanza);
						$fila2 = @pg_fetch_array($result2,0);
						
						$sqlcurso="SELECT grado_curso,id_curso,letra_curso FROM curso where id_curso=".$fila["grado"];
						$result3 = @pg_Exec($conn,$sqlcurso);
						$fila3 = @pg_fetch_array($result3,0);
				?>
                          <tr bgcolor=#ffffff onMouseOver=this.style.background='#CCCCCC';this.style.cursor='hand' onMouseOut=this.style.background='#ffffff' class="Estilo8">
                            <td>&nbsp;
                                <?= $fila["grado"]?></td>
                            <td>&nbsp;
                                <?= $fila2["nombre_tipo"];?></td>
                            <td>&nbsp;
                                <?= $fila["descripcion"];?></td>
                            <td>&nbsp;
                                <?= $fila["sigla"];?></td>
                            <td>&nbsp;
                                <?= $fila["valor"];?></td>
                            <td>
							<? if($modifica==1){?>
							<a href="editar_seleccion.php?id_sel=<?= $fila["id_sel"]?>&modo=3&ensenanza=<?= $fila["ensenanza"]?>&curso=<?= $fila["grado"]?>"><img align="left" src="page_white_edit.png" border="0"></a>
							<? } ?>
							</td>
                            <td>
							<? if($elimina==1){?>
							<a href="procesaseleccion.php?id_sel=<?= $fila["id_sel"]?>&modo=2" onClick="return confirm('¿Desea Eliminar Registro?');"><img src="cross.png" border="0"></a>
							<? } ?>
							</td>
                          </tr>
                          <? }?>
                        </table>
                      </form></td>
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

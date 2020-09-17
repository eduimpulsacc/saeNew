<?
require('../../../util/header.inc');
$_POSP = 3;
$_bot = 10;

$_POSP          = 3;
$_bot           = 10;
$institucion	= $_INSTIT;

$sql="select situacion from ano_escolar where id_ano=$_ANO";
$result =pg_exec($conn,$sql);
$situacion=pg_result($result,0);
	

if ($_FRMMODO==""){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}

/************ PERMISOS DEL PERFIL *************************/
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

?>
<script language="Javascript1.2">
<!-- 
// Carga de htmlarea
_editor_url = "" // URL del archivo htmlarea
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }
// -->
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			include("../../../cabecera/menu_superior.php");
			?>
			
			
			    </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
					
						    <?						
								 $menu_lateral=4;
								 include("../../../menus/menu_lateral.php");
							 ?>					 
						
					  </td>
                      <td width="73%" align="left" valign="top">  
					  
					  <table width="100" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                          <tr>
                            <td valign="top">
							
							
                        
						
						 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top">
							
							<!-- INGRESO DE CONTENIDO NUEVO -->
							
							
							
							
							
							<?php 
	
	$institucion	=$_INSTIT;
	if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
     
	if ($frmModo == NULL){
	   $frmModo = "mostrar";
	}    
     

    

?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>

	
<script language="JavaScript"> 
  function maximaLongitud(texto,maxlong) { 
  var tecla, in_value, out_value; 
  if (texto.value.length > maxlong) { 
    in_value = texto.value; 
    out_value = in_value.substring(0,maxlong); 
    texto.value = out_value; 
    return false; 
  } 
  return true; 
} 
</script> 

    	<?php if($frmModo!="mostrar"){ ?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				return true;
			}
		</SCRIPT>
	<?php };?>

	
	<FORM method=post name="frm" action="procesoNuestraInstitucion.php3">
	<INPUT TYPE="hidden" name=rdb value=<?php echo $institucion;?>>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD valign="top">
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){
										if($ingreso==1){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" onClick=document.location="..">&nbsp;
								<?php 	};
									  }?>
								<?php if($frmModo=="mostrar"){ ?>
									<?
									if ($situacion !=0){ 
									if($modifica==1){?>
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaNuestraInstitucion.php3?caso=3">&nbsp;
											
									<?php } //ACADEMICO Y LEGAL
									}?>
									<?php if($ver==1){ ?>									
									            <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../institucion.php3">&nbsp;
									<?php } ?>
								<?php };?>
								<?php if($frmModo=="modificar"){
										if($modifica==1){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name="btnCancelar" onClick=document.location="seteaNuestraInstitucion.php3?caso=1">&nbsp;
								<?php 	};
									   }?>
							</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class=tableindex>			  									NUESTRA INSTITUCION															</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD WIDTH=570 valign="top">
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 >
									
									<TR  align="justify">
										
                  <TD align="justify" class="datosB"> 
                    <?php if($frmModo=="ingresar"){?>
                    <div align="left">
					<script language="JavaScript1.2" defer>
						editor_generate('txtCONT');
					</script>	
                      <TEXTAREA NAME="txtCONT" ROWS="20" COLS="60" onKeyUp="return maximaLongitud(this,4096)" Onpaste="return anulas ()"></TEXTAREA>
                      <br>
                      <font face="Arial, Helvetica, sans-serif" size="2"> Max. 
                      cantidad de caracteres = 4096 </font> 
                      <?php };?>
                      <font face="Arial, Helvetica, sans-serif" size="2"> 
                      <?php 
												if($frmModo=="mostrar"){ 
													echo nl2br(trim($fila['nuestra_institucion']));
												};
											?>
                      </font> 
                      <?php if($frmModo=="modificar"){ ?>
					<script language="JavaScript1.2" defer>
						editor_generate('txtCONT');
					</script>					  
                        <TEXTAREA NAME="txtCONT" ROWS="20" COLS="60" onKeyUp="return maximaLongitud(this,4096)" Onpaste="return anulas ()"><?php echo trim($fila['nuestra_institucion']); ?></TEXTAREA>
																							<br>
											<font face="Arial, Helvetica, sans-serif" size="2">
											  Max. cantidad de caracteres = 4096
											  </font>

                      <?php };?>
                    </div></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=2>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
	
	
	</td>
     </tr>
      </table>
	
	   <!-- FIN DE CONTENIDO NUEVO -->
	   
	   
							
							
							</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

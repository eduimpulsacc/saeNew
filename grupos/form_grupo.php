<?
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;
$_POSP = 2;
$_bot = 0;

if ($ano > 0){
   $_MDINAMICO = 1;
}else{
   $_MDINAMICO = 0;
}
      
$perfil = $_PERFIL; 

	
$usuarioensesion = $_USUARIOENSESION;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
			  
			  </table>
			  
			  
			  
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
					    $menu_lateral=5;
						include("../menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top">						
							<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="center" valign="top"> 
                                  <td height="162" align="center">
							<?
							if ($id_grupo!=NULL){
							    							 
								  // Selecciono los grupos de la institucion
								  $q1 = "select * from grupos where id_grupo = '".trim($id_grupo)."'";
								  $r1 = pg_Exec($conn,$q1);
								  $f1 = pg_fetch_array($r1,0);
								  
								  $nombre      = $f1['nombre'];
								  $descripcion = $f1['descripcion'];
								  
							}	  							  
							?>						
								  
								<form name="form" method="post" action="proceso_grupo.php">  
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="tableindex"><div align="center">ADMINISTRADOR DE GRUPOS <br>
                                        <br>
                                      </div></td>
                                      </tr>
                                    <tr>
                                      <td><div align="right">
                                        <label>
                                        <input name="id_grupo" type="hidden" id="id_grupo" value="<?=$id_grupo ?>">
										<input name="Submit" type="submit" onClick="MM_validateForm('nombre','','R','descripcion','','R');return document.MM_returnValue"  <? if ($id_grupo!=NULL){ ?>  value="ACTUALIZAR" <? }else{ ?> value="GRABAR" <? } ?> class="botonXX">                                                                          
                                        <input name="Submit2" type="button" onClick="MM_callJS('history.go(-1)')" value="VOLVER" class="botonXX">
                                        </label>
                                      </div></td>
                                      </tr>
                                    <tr>
                                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="40%"  class="textosimple">NOMBRE</td>
                                          <td width="60%" ><label>
                                            <input name="nombre" type="text" id="nombre" size="50" value="<?=$nombre ?>">
                                          </label></td>
                                        </tr>
                                        <tr>
                                          <td  class="textosimple">DESCRIPCI&Oacute;N</td>
                                          <td ><label>
                                            <textarea name="descripcion" cols="45" rows="5" id="descripcion"><?=trim($descripcion); ?></textarea>
                                          </label></td>
                                        </tr>
                                        
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

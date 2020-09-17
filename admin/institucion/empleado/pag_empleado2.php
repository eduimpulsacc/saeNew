<? 
require('../../../util/header.inc');
$institucion	=$_INSTIT;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla);
	document.getElementById('personal').style.display='none';
	document.getElementById('docente').style.display='none';
	document.getElementById('curriculum').style.display='none';
	document.getElementById('accesoweb').style.display='none';
	document.getElementById('grupos').style.display='none';
	    //document.getElementById('habilitado').style.display='none';
	    //document.getElementById('autorizacion').style.display='block';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
	

}

function uno(span){
	
	document.getElementById('habilitado').style.display='block';
	document.getElementById('autorizacion').style.display='none';	

}

function dos(span){
	
	document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';	

}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
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
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
 <script language="javascript" type="text/javascript">
<!--
function getElementObject(elementID) {
         var elemObj = null;
         if (document.getElementById) {
            elemObj = document.getElementById(elementID);
         }
         return elemObj;
       } 

       function mostrar_ocultar(obj){
          a=getElementObject(obj);
	      if (a.style.display==""){
		     a.style.display="none";
	      }else{
		     a.style.display="";
	      }
	   }

       function chekear(obj){
	     //a=getElementObject(obj);
	     a=window.document.frm.cod_subsector;
	     largo=	window.document.frm.cod_subsector.length;
		for (i=0;i<largo;i++)	{
	       if (a[i].checked==true){
		      a[i].checked=false;
	       }else{
		      a[i].checked=true;
		   }
        }
       }	
	function SwitchMenuAnotacion(obj){  
   	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
	
}

<!-- VALIDACIONES A FORMULARIOS -->
function valida_nuevo_empleado(f){
     if (f.rut.value==""){
	     alert('Debe ingresar su rut, en campo Rut');
		 f.rut.focus();
		 return false;
	 }
	 if (f.dig.value==""){
	     alert('Debe ingresar dígito verificador de rut');
		 f.dig.focus();
		 return false;
	 }
	 if (f.nombres.value==""){
	     alert('Debe ingresar nombre de empleado, en campo nombre');
		 f.nombres.focus();
		 return false;
	 }
	 if (f.ape_pat.value==""){
	     alert('Debe ingresar apellido paterno');
		 f.ape_pat.focus();
		 return false;
	 }
	 if (f.ape_mat.value==""){
	     alert('Debe ingresar apellido materno');
		 f.ape_mat.focus();
		 return false;
	 }
	 if (f.region.value==0){
	     alert('Debe seleccionar una Región');
		 f.region.focus();
		 return false;
	 }
}

function val_region(f,reg){
     alert('region es: '+reg);
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}




/************************************************
Listas dependientes por Tunait!(5/1/04)
Si quieres usar este script en tu sitio
eres libre de hacerlo con la condición
de que permanezcan intactas estas líneas,
osea, los créditos.
No autorizo a publicar y ofrecer el código
en sitios de script sin previa autorización
Si quieres publicarlo, por favor, contacta conmigo.
http://javascript.tunait.com/
tunait@yahoo.com
*************************************************/
function slctr(texto,valor){
	this.texto = texto
	this.valor = valor
}
var herramientas=new Array()
	herramientas[0] = new slctr('- -Herramientas- -')
	herramientas[1] = new slctr("Jardínnnn",'jardin')
	herramientas[2] = new slctr("fontanería",'fontaneria')


var muebles=new Array()
	muebles[0] = new slctr('- -Muebles- -')
	muebles[1] = new slctr("Salón",'salon')
	muebles[2] = new slctr("dormitorio",'dormitorio')

//*******Nietos*******************
var jardin = new Array()
	jardin[0] = new slctr('- -Jardín- -')
	jardin[1] = new slctr("podadora",null)
	jardin[2] = new slctr("segadora" ,null)

var fontaneria = new Array()
	fontaneria[0] = new slctr('- -Fontanería- -')
	fontaneria[1] = new slctr("llave inglesa",null)
	fontaneria[2] = new slctr("llave fija",null)

var salon = new Array()
	salon[0] = new slctr('- -Salón- -')
	salon[1] = new slctr("Mesa",null)
	salon[2] = new slctr("silla" ,null)

var dormitorio = new Array()
	dormitorio[0] = new slctr('- -Dormitorio- -')
	dormitorio[1] = new slctr("cama",null)
	dormitorio[2] = new slctr("mesita" ,null)

function slctryole(cual,donde){
	if(cual.selectedIndex != 0){
		donde.length=0
		cual = eval(cual.value)
		for(m=0;m<cual.length;m++){
			var nuevaOpcion = new Option(cual[m].texto);
			donde.options[m] = nuevaOpcion;
			if(cual[m].valor != null){
				donde.options[m].value = cual[m].valor
			}
			else{
				donde.options[m].value = cual[m].texto
			}
		}
	}
}

</script>



//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<?
if ($frmModo!="ingresar"){ 
   if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('personal','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('docente','pesta2');
	  <?
	  if ($m1==1){ ?>
	       uno();
		   
	<? }else{ ?>
	       dos();
	<? }
		  
   }
   if ($pesta == 3){ ?>
      muestra_tabla('curriculum','pesta3'); <?
	  
   }	   
   
   
   if ($pesta == 4){ ?>
      muestra_tabla('accesoweb','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('grupos','pesta5'); <?
   }   
}
 ?>">
<? 
include('../../../util/rpc.php3');
?> 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">	
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="90%"  align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
                    <tr> 
					
                      <td width="20%" height="363" align="left" valign="top"> 
                      <?  include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="100%" align="left" valign="top"><br>
                        <table width="706" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal" ><img src="images/bot_personal.jpg" width="133" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('docente','pesta2');"><span id="pesta2" class="span_normal" ><img src="images/bot_autorizdoc.jpg" width="138" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('curriculum','pesta3');"><span id="pesta3" class="span_normal" ><img src="images/bot_curriculum.jpg" width="137" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('accesoweb','pesta4');"><span id="pesta4" class="span_normal" ><img src="images/bot_accesoweb.jpg" width="138" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('grupos','pesta5');"><span id="pesta5" class="span_normal" ><img src="images/bot_grupos.jpg" width="139" height="20" border="0"></span></a></div></td>
                        </tr>
                        </table>  
						<form name="form_new_emp" method="post" action="ing_nuevo_emp.php">                     
						 <table width="706" border="1" align="center" id="personal" >
                          <tr>
                            <td class="tableindex">
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>Personal </td>
                                <td><div align="right">
                                  <label>
                                  <input type="button" class="botonXX" name="Submit" value="Ingresar nuevo empleado" onClick="return valida_nuevo_empleado(this.form);">
                                  </label>
                                </div></td>
                              </tr>
                            </table>
							</td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="1">
                              <tr>
                                <td colspan="4" class="cuadro02">Datos Personales </td>
                                </tr>
                              <tr>
                                <td width="20%" class="cuadro02">Rut</td>
                                <td width="30%"><label>
                                  <input name="rut" type="text" id="rut" size="10">
                                - 
                                <input name="dig" type="text" id="dig" size="1" maxlength="1">
                                </label></td>
                                <td width="20%" class="cuadro02">Nacionalidad</td>
                                <td width="30%"><label>
                                  <select name="nacionalidad" id="nacionalidad">
                                     <option value="2" selected="selected">Chilena </option>
									 <option value="1">Extranjera </option>
								  </select>
                                </label></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Nombres</td>
                                <td><label>
                                  <input name="nombres" type="text" id="nombres" size="30">
                                </label></td>
                                <td class="cuadro02">Apellido Paterno </td>
                                <td><input name="ape_pat" type="text" id="ape_pat" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Apellido Materno </td>
                                <td><input name="ape_mat" type="text" id="ape_mat" size="30"></td>
                                <td class="cuadro02">Tel&eacute;fono</td>
                                <td><input name="telefono" type="text" id="telefono" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Tel&eacute;fono 2 </td>
                                <td><input name="telefono2" type="text" id="telefono2" size="30"></td>
                                <td class="cuadro02">Tel&eacute;fono 3 </td>
                                <td><input name="telefono3" type="text" id="telefono3" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">E-mail</td>
                                <td><input name="email" type="text" id="email" size="30"></td>
                                <td class="cuadro02">Sexo</td>
                                <td><label>
                                  <select name="sexo" id="sexo">
                                  </select>
                                </label></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Fecha de Nacimiento </td>
                                <td><input name="fecha_nac" type="text" id="fecha_nac" size="30"></td>
                                <td class="cuadro02">Fecha de Ingreso </td>
                                <td><input name="fecha_ing" type="text" id="fecha_ing" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Previsi&oacute;n (AFP) </td>
                                <td><input name="afp" type="text" id="afp" size="30"></td>
                                <td class="cuadro02">Sistema Salud </td>
                                <td><input name="salud" type="text" id="salud" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas Pste. a&ntilde;o </td>
                                <td><input name="horas" type="text" id="horas" size="5"></td>
                                <td class="cuadro02">Estado Civil </td>
                                <td><label>
                                  <select name="estado_civil" id="estado_civil">
                                  </select>
                                </label></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">D&iacute;a y hora atenci&oacute;n </td>
                                <td><input name="atencion" type="text" id="atencion" size="30"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="4" class="cuadro02">Direcci&oacute;n</td>
                                </tr>
                              <tr>
                                <td class="cuadro02">Calle</td>
                                <td><input name="calle" type="text" id="calle" size="30"></td>
                                <td class="cuadro02">Nro.</td>
                                <td><input name="nro" type="text" id="nro" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Dpto.</td>
                                <td><input name="dpto" type="text" id="dpto" size="30"></td>
                                <td class="cuadro02">Blcok</td>
                                <td><input name="block" type="text" id="block" size="30"></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Villa, Poblaci&oacute;n </td>
                                <td><input name="villa_pob" type="text" id="villa_pob" size="30"></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="1">
                                  <tr>
                                    <td class="cuadro02">Regi&oacute;n</td>
                                    <td class="cuadro02">Provincia</td>
                                    <td class="cuadro02">Comuna</td>
                                  </tr>
                                  <tr>
                                    <td><label>
									  <?
									  $sql_REG  = "SELECT * FROM REGION ORDER BY COD_REG ASC";
		                              $res_REG	= @pg_Exec($conn,$sql_REG);
		                              $num_REG  = @pg_numrows($res_REG);
									  
									  ?>
                                      <select name="region" id="region" onChange="val_region(this.form,this.selectedIndex);" >
									     <option value="0" selected="selected">Seleccione </option>
										 <?
										 for($i=0 ; $i < $num_REG; $i++){
										    $fil_REG = @pg_fetch_array($res_REG,$i);
											$nom_reg = $fil_REG['nom_reg'];
										    $cod_reg = $fil_REG['cod_reg'];
											?>
										    <option value="<?=$cod_reg ?>"><?=$nom_reg ?></option>
											<?
										 }
										 ?>	
                                      </select>
                                    </label></td>
                                    <td><label>
									  <?
									  $sql_PROV	= "SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		                              $res_PROV	= @pg_Exec($conn,$sql_PROV);
									  $num_PROV = @pg_numrows($res_PROV);
									  ?>
                                      <select name="provincia" id="provincia" onChange="relate2(this.form,0,this.selectedIndex,0);">
									    <option value="0" selected="selected">Seleccione </option>
										<?
										for ($i=0;  $i < $num_PROV; $i++){
										    $fil_PROV = @pg_fetch_array($res_PROV,$i);
											$nom_pro = $fil_PROV['nom_pro'];
											$cor_pro = $fil_PROV['cor_pro'];
											?>											
										    <option value="<?=$cor_pro ?>"><?=$nom_pro ?></option>
											<?
										}
										?>	
                                      </select>
                                    </label></td>
                                    <td><label>
									  <?
									  $sql_COM = "SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		                              $res_COM = @pg_Exec($conn,$sql_COM);
									  $num_COM = pg_numrows($res_COM);
									  ?>
									  <select name="comuna" id="comuna">
									     <option value="0" selected="selected">Seleccione </option>
										 <?
										 for ($i=0; $i < $num_COM; $i++){
										     $fil_COM = @pg_fetch_array($res_COM,$i);
											 $nom_com = $fil_COM['nom_com'];
											 $cor_com = $fil_COM['cor_com'];
											 ?>
										     <option value="<?=$cor_com ?>"><?=$nom_com ?></option>
											 <?
										}
										?>	 
                                      </select>
                                    </label></td>
                                  </tr>
                                </table>
                                  <table width="100%" border="1">
                                    <tr>
                                      <td width="15%" class="cuadro02">Regi&oacute;n</td>
                                      <td width="19%" class="cuadro02">Provincia</td>
                                      <td width="66%" class="cuadro02">Comuna</td>
                                    </tr>
                                    <tr>
                                      <td>
									  <label>
									  <select name="select" onChange="slctryole(this,this.form.select2)">
										<option>- - Seleccionar - -</option>
										<option value="herramientas">herramientas</option>
										<option value="muebles">muebles</option>
									  </select>

									  </label></td>
                                      <td>
									  <label>
									  <select name="select2" onChange="slctryole(this,this.form.select3)">
										<option>- - - - - -</option>
									  </select>
									  </label></td>
                                      <td>
									  <label>
									  <select name="select3">
										<option>- - - - - -</option>
									  </select>
									  </label></td>
                                    </tr>
                                  </table></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table>
						</form>					
						
						<table width="706" border="1" align="center" id="docente">
                          <tr>
                            <td>Autoriz. Docencia</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						<table width="706" border="1" align="center" id="curriculum"> 
						  <tr>
                            <td>Curriculum</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						<table width="706" border="1" align="center" id="accesoweb">
                          <tr>
                            <td>Acceso Web</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						<table width="706" border="1" align="center" id="grupos">
                          <tr>
                            <td>Grupos</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
<? pg_close($conn);?>
</body>
</html>
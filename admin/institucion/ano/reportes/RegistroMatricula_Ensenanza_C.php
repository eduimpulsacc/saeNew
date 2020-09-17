<?php
require('../../../../util/header.inc');
/*require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');*/
include('../../../clases/class_MotorBusqueda.php');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	

     
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
	
<SCRIPT language="JavaScript">


	function enviapag2(form){
		if (form.cmb_curso.value==0){
			alert("Seleccione Tipo de Enseñanza");
			return false;
		}
	form.target="_blank";
	var curso= document.form.cmb_curso.value;
	//var opcion = document.form.orden.value;
	var x 
	for (x=0;x<document.form.orden.length;x++){ 
	if (document.form.orden[x].checked){ 
	var opcion = document.form.orden[x].value;
	} 
	} 		
	var i 
	for (i=0;i<document.form.SEXO.length;i++){ 
	if (document.form.SEXO[i].checked){ 
	var SEXO = document.form.SEXO[i].value;
	} 
} 
	document.form.action='printRegistroMatricula_Ensenanza_C.php?curso='+curso+'&orden='+opcion+'&SEXO='+SEXO;
	document.form.submit(true);
	}
			
function enviapag_buscar(form){
	if (form.cmb_curso.value==0){
	alert("Seleccione Tipo de Enseñanza");
	return false;
	}
	form.target="_blank";
	var curso= document.form.cmb_curso.value;
	//var opcion = document.form.orden.value;
	var x 
	for (x=0;x<document.form.orden.length;x++){ 
	if (document.form.orden[x].checked){ 
	var opcion = document.form.orden[x].value;
	} 
	} 		
	var i 
	for (i=0;i<document.form.SEXO.length;i++){ 
	if (document.form.SEXO[i].checked){ 
	var SEXO = document.form.SEXO[i].value;
	} 
	} 
	
	var cb_ok="Buscar";
	document.form.action='printRegistroMatricula_Ensenanza_C.php?curso='+curso+'&orden='+opcion+'&SEXO='+SEXO+'&cb_ok='+cb_ok;
	document.form.submit(true);
}	
			
			
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'RegistroMatricula.php?institucion=$institucion';
				form.submit(true);
				}	
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../cabecera/menu_superior.php");
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
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES --><!-- FIN CODIGO DE BOTONES -->
                                

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?

?>
<form method="post" action="printRegistroMatricula_Ensenanza_C.php" target="_blank" name="form" id="form">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor->ano = $ano;
$resultado = $ob_motor ->Ensenanza($conn);

//------------------

?>
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="701" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="120" class="cuadro01">Tipo de Ense&ntilde;anza</td>
    <td width="200">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x" >
          <option value=0 selected>(Seleccione Tipo de Ensenanza)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado,$i); 
		  if ($fila["ensenanza"]==$cmb_curso){
  				echo "<option selected value=".$fila['ensenanza'].">".$fila['nombre_tipo']."</option>";
  		  }else{
  				echo "<option value=".$fila['ensenanza'].">".$fila['nombre_tipo']."</option>";
		  }
          } ?>
        </select>
</font>	  </div></td>
    <td width="40">
      <div align="center"></div></td><? if($_PERFIL==0 OR $_PERFIL==14){?>
	    <td width="40">
	        <div align="right"></div></td><? }?>
  </tr>
  <tr>
    <td class="cuadro01">Ordenado por </td>
    <td><font size="1" face="arial, geneva, helvetica">
	<input name="orden" type="radio" value="1"> 
      N&ordm; Matricula 
        <input name="orden" type="radio" value="2" checked="checked"> 
        Apellido 
		</font>	</td>
    <td colspan="2"><div align="center"></div></td>
  </tr>
  
  <tr>
    <td class="cuadro01">Ordenado por Sexo</td>
    <td><font size="1" face="arial, geneva, helvetica">
	<input name="SEXO" id="SEXO" type="radio" value="2"> 
      Hombres 
        <input name="SEXO" id="SEXO" type="radio" value="1"> 
        Mujeres 
        <input name="SEXO"  id="SEXO" type="radio" value="3" checked="checked"> 
        Ambos 
		</font>	</td>
    <td colspan="2"><div align="center"></div></td>
  </tr>
  
  <tr>
    <td class="cuadro01">Tipo de Libro </td>
    <td><select name="tipolibro" id="tipolibro" >
	<option selected value="1">Clasico</option>
	<option value="2">Subsecretaria-Norte</option>
    <option value="3">Subsecretaria-Sur</option>
    <option value="4">C/Datos Familia</option>
    <option value="5">Subsecretaria Central</option>
    <option value="6">Formato Pe&ntilde;alol&eacute;n</option>
    <option value="7">Formato Nacional</option>
    <option value="8">Formato Propio Instituci&oacute;n</option>
    
    </select>
    </td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

	<table width="650" border="0" align="right" cellpadding="1" cellspacing="0">
      <tr>
        <th width="527" scope="col"><div align="right">
          <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" value="Buscar" onClick="enviapag_buscar(form)">
        </div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="button" class="botonXX" onClick="enviapag2(this.form)"  id="cb_exp" value="Exportar">
        </div></th>
        <th width="53" scope="col"><div align="right">
         <!-- <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver" onClick="window.location='Menu_Reportes_new2.php'">-->
         <input name="cb_ok2" class="botonXX"  type="button" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
        </div></th>
      </tr>
    </table></td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>

<?
	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<SCRIPT language="JavaScript">
		function enviapag2(form){
						form.target="_blank";
						var curso = document.form.cmb_curso.value;
						var periodo = document.form.cmb_periodos.value;
						
					document.form.action='printInformeRendimiento_C.php?cmb_curso='+curso+'&cmb_periodos='+periodo;																						
					document.form.submit(true);
					
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeRendimiento.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
			function envia(form){
				if(form.rdESCALA[0].checked==true){
					form.action='printInformeRendimientoAdventista.php';
					form.submit(true);
				}else if(form.rdESCALA[1].checked==true){
					form.action='printInformeRendimiento.php';
					form.submit(true);
				}else if(form.rdESCALA[2].checked==true){
					form.action='printInformeRendimientoOtro.php';
					form.submit(true);
				}
				
			}
			
			function visible(form){
				if(form.rdESCALA[2].checked==true){
					document.getElementById("otro").style.display = "block";
				}else if(form.rdESCALA[0].checked==true){
					document.getElementById("otro").style.display = "none";
				}else if(form.rdESCALA[1].checked==true){
					document.getElementById("otro").style.display = "none";
				}
			}
			
			function activar(valor){

				var campo = "chkCAMPO"+valor;
				var nombre = "txtNOMBRE"+valor;
				var minimo = "txtMIN"+valor;
				var maximo = "txtMAX"+valor;

				if($("#"+campo+"").is(':checked')){
					$("#"+nombre+"").removeAttr('disabled');
					$("#"+minimo+"").removeAttr('disabled');
					$("#"+maximo+"").removeAttr('disabled');	
					$("#"+nombre+"").focus();
				}else{
					$("#"+nombre+"").attr('disabled', 'disabled');
					$("#"+minimo+"").attr('disabled', 'disabled');
					$("#"+maximo+"").attr('disabled', 'disabled');
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
										  <tr> 
											<td width="" height="0" align="center" valign="top"> 
											  
												
										  
										  
									</table>
									<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method="post" action="#" target="_blank" name="form">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$resultado_query_cue = $ob_motor ->curso2($conn);

$ob_motor ->ano = $ano;
$result_peri = $ob_motor ->periodo($conn);

//
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78" class="textosimple">Curso</td>
    <td width="263">
	  <div align="left"><font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso"  class="ddlb_9_x">
          <option value=0 selected>(Seleccione Curso)</option>
          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
		  
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
		  
          } 
		  ?>
        </select>
	  </font></div></td>
    <td width="61" class="textosimple">Periodo</td>
    <td width="219"><select name="cmb_periodos" class="ddlb_9_x">
			<option value=0 selected>Anual</option>
       <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
	   <? } ?>
    </select></td>
    <td width="80"><div align="right">
      &nbsp;
    </div></td>
  </tr>
  
  <tr>
    <td class="textosimple">Promedio</td>
    <td class="textosimple"><input name="rbOPCION" type="radio" value="1" checked>
      Aritmetico 
        <input name="rbOPCION" type="radio" value="2">
        Apreciacion</td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr valign="top">
    <td class="textosimple">Escala </td>
    <td class="textosimple">
    	<input name="rdESCALA" type="radio" id="rdESCALA" value="0">Rango de 3
	    <input name="rdESCALA" type="radio" id="rdESCALA" value="1" checked>Rango de 4 
        <input name="rdESCALA" type="radio" id="rdESCALA" value="2" onClick="visible(this.form)">Otro
    </td>
    <td colspan="3" class="textosimple">
    <div id="otro" style="display:none">
    <table border="0" style="border-collapse:collapse">
      <tr>
        <td width="12%"><input type="checkbox" name="chkCAMPO1" id="chkCAMPO1" onClick="activar(this.value)" value="1"></td>
        <td width="52%"><input name="txtNOMBRE1" type="text" disabled id="txtNOMBRE1"></td>
        <td width="18%"><input name="txtMIN1" type="text" disabled id="txtMIN1" size="5" maxlength="2"></td>
        <td width="18%"><input name="txtMAX1" type="text" disabled id="txtMAX1" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chkCAMPO2" id="chkCAMPO2" onClick="activar(this.value)"  value="2"></td>
        <td><input name="txtNOMBRE2" type="text" disabled id="txtNOMBRE2"></td>
        <td><input name="txtMIN2" type="text" disabled id="txtMIN2" size="5" maxlength="2"></td>
        <td><input name="txtMAX2" type="text" disabled id="txtMAX2" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chkCAMPO3" id="chkCAMPO3" onClick="activar(this.value)"  value="3"></td>
        <td><input name="txtNOMBRE3" type="text" disabled id="txtNOMBRE3"></td>
        <td><input name="txtMIN3" type="text" disabled id="txtMIN3" size="5" maxlength="2"></td>
        <td><input name="txtMAX3" type="text" disabled id="txtMAX3" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chkCAMPO4" id="chkCAMPO4" onClick="activar(this.value)"  value="4"></td>
        <td><input name="txtNOMBRE4" type="text" disabled id="txtNOMBRE4"></td>
        <td><input name="txtMIN4" type="text" disabled id="txtMIN4" size="5" maxlength="2"></td>
        <td><input name="txtMAX4" type="text" disabled id="txtMAX4" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td><input type="checkbox" name="chkCAMPO5" id="chkCAMPO5" onClick="activar(this.value)"  value="5"></td>
        <td><input name="txtNOMBRE5" type="text" disabled id="txtNOMBRE5"></td>
        <td><input name="txtMIN5" type="text" disabled id="txtMIN5" size="5" maxlength="2"></td>
        <td><input name="txtMAX5" type="text" disabled id="txtMAX5" size="5" maxlength="2"></td>
      </tr>
    </table>
    </div>
    </td>
    </tr>
    <?php if($_PERFIL==0){?>
  <tr valign="top">
    <td class="textosimple">Gr&aacute;fico</td>
    <td class="textosimple"><input type="checkbox" name="graf" id="graf" value="1">
     </td>
    <td colspan="3" class="textosimple">&nbsp;</td>
  </tr>
  <?php }?>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td colspan="2"><input name="cb_ex" type="button" class="botonXX" onClick="enviapag2(this.form)" id="cb_ex" value="Exportar">
      <input name="cb_ok" type="button" class="botonXX"  id="cb_ok"  value="  Buscar " onClick="envia(this.form)">
      <input name="cb_ok2" class="botonXX"  type="button" value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
  </tr>
    </table>

	</td>
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
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
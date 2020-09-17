<?
require('../../../../util/header.inc');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$curso   		=$cmb_curso;
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
<script type="text/javascript">
function enviapag2(form){
        if( document.form.cmb_curso.value!=0){
               // form.target="_blank";
				var periodo= document.form.cmb_periodos.value;
				var curso = document.form.cmb_curso.value;
				document.form.action='printInformeAtrasoPeriodo_C.php?cmb_periodos='+periodo+'&cmb_curso='+curso;
                document.form.submit(true);
       }else{
	   alert("Debe Seleccionar Curso.");
	   }
}
function busqueda(form){
	if(document.form.rdOPCION[0].checked==true){
		document.getElementById("capa1").style.display='block';
		document.getElementById("capa2").style.display='none';
	}
	if(document.form.rdOPCION[1].checked==true){
		document.getElementById("capa1").style.display='none';
		document.getElementById("capa2").style.display='block';
	}
}

</script>
<SCRIPT language="JavaScript">
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
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
		       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<? include("../../../../cabecera/menu_superior.php"); ?>				 
				
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
                       <td width="73%" align="left" valign="top"><!-- cuerpo de la página --><br>
                         <!-- fin cuerpo -->
                         <!-- BUSCADOR AVANZADO -->
						 <? 
						 	$ob_motor = new MotorBusqueda();
							$ob_motor->ano = $ano;
							$ob_motor->perfil=$_PERFIL;
							$ob_motor->curso=$_CURSO;
							$ob_motor->usuario=$_NOMBREUSUARIO;
							$ob_motor->rdb=$institucion;
							$resultado_query_cue = $ob_motor-> curso2($conn);
							$result_per = $ob_motor->periodo($conn);
						 
						 ?>
						<form name="form" method="post" action="printInformeAtrasosMensual_C.php" target="_blank">
						<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
						<input name="nombre" type="hidden" value="<?=$nombre;?>">
                        <input name="numero" type="hidden" value="<?=$numero;?>">						
                         <table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
						  <tr>
							<td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
						  </tr>
						  <tr>
							<td height="27">
						  <table width="100%" border="0" cellspacing="5" cellpadding="0">
							<tr>
							  <td class="textosimple" align="left">Mes</td>
						      <td class="textosimple" align="left"><select name="cmb_meses">
						        <option value="0">seleccione</option>
						        <option value="3">MARZO</option>
						        <option value="4">ABRIL</option>
						        <option value="5">MAYO</option>
						        <option value="6">JUNIO</option>
						        <option value="7">JULIO</option>
						        <option value="8">AGOSTO</option>
						        <option value="9">SEPTIEMBRE</option>
						        <option value="10">OCTUBRE</option>
						        <option value="11">NOVIEMBRE</option>
						        <option value="12">DICIEMBRE</option>
						        </select>						      </td>
						      <td class="textosimple" align="left">&nbsp;</td>
						      <td class="textosimple" align="left">&nbsp;</td>
							</tr>

							<tr>
							
							  <td colspan="4" class="textosimple">
							  <div id="capa2" style="display:none">
							  <table width="100%" border="0">
                                <tr>
                                  <td width="130" class="textosimple">Fecha</td>
                                  <td><input type="text" name="txtFecha"></td>
                                </tr>
                              </table>
							  </div>							  </td>
						    </tr>
							<tr>
							  <td width="100" class="textosimple">Cursos</td>
							  <td width="439">
							  
							  <select name="cmb_curso"  class="ddlb_9_x">
								  <option value=0 selected>(Seleccione Curso)</option>
								  <?
								   for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++) {
									  $fila = @pg_fetch_array($resultado_query_cue,$i); 
									  if ($fila["id_curso"]==$cmb_curso){
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
									  }else{
											$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
											echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
									  }
								  } ?>
							</select>							</td>
							  <td width="73">&nbsp;</td>
							  <? if($_PERFIL == 0){?>
							  <td width="74"><input type="button" onClick="enviapag2(this.form)" name="cb_ex" id="cb_ex" value="Exportar" class="botonXX">							   </td>
								<? }?>
							</tr>
							<tr>
							  <td width="100" class="textosimple">Espacio en filas </td>
							  <td><input name="txtFILAS" type="text" id="txtFILAS" value="2" size="5" maxlength="1"></td>
							  <td colspan="2"><div align="center">
							    <input type="submit" name="cb_ok" id="cb_ok" value="Buscar" class="botonXX">
							    <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
							    </div></td>
							  </tr>
						   </table>
						
							</td>
						   </tr>
						</table>	
						</form>				   
					   <!-- FIN BUSCADOR AVANZADO -->					   
					   
				      </td></tr>
                       <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
<? pg_close($conn);?>
</body>
</html>

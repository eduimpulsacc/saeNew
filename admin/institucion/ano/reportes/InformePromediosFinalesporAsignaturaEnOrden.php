<? 	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$c_periodos;
	$curso			=$c_curso;
	$subsector		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
	function enviapag2(form){
			form.target="_blank";
			var subsector 	= document.form.cmb_subsector.value;
			var curso 		= document.form.cmb_curso.value;
			var periodo 	= document.form.cmb_periodos.value;
			document.form.action='printInformepromediosFinalesEnOrden.php?cmb_periodos='+periodo+'&cmb_curso='+curso+'&cmb_subsector='+subsector;
			document.form.submit(true);
	}
	function enviapag(form){
		if (form.cmb_curso.value!=0){
			form.cmb_curso.target="self";
			window.location= 'InformePromediosFinalesporAsignaturaEnOrden.php?cmb_periodos='+ '&cmb_curso=' + document.form.cmb_curso.value +'&c_reporte=<?=$reporte;?>';
		}	
	}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
	function activa(valor){
		if(valor==1){
			document.form.cmb_periodo.disabled=true;
		}else{
			document.form.cmb_periodo.disabled=false;
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
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
      
	  <?
						
						?>
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="printInformepromediosFinalesEnOrden.php" target="_blank" name="form">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
//------------------

$ob_motor = new MotorBusqueda();

$ob_motor ->ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$resultado_query_cue = $ob_motor ->curso2($conn);

$ob_motor ->ano = $ano;
$result_peri = $ob_motor ->periodo($conn);

if($cmb_curso!=0){
	$ob_motor ->curso =$cmb_curso;
	$resultado_sub = $ob_motor ->Subsector($conn);
}
//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="56" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" height="11" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="650" border="0" cellspacing="0" cellpadding="5">
  
  <tr>
    <td width="145" class="textosimple">Curso</td>
    <td width="465">
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	    <select name="cmb_curso" class="ddlb_9_x" onChange="enviapag(this.form);">
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
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";		  }
          } ?>
        </select>
	    </font>	  </div></td>
    <td width="10" class="textosimple">&nbsp;</td>
    </tr>
  <tr>
    <td class="textosimple">Subsector</td>
    <td>
	<div align="left">
	  		
      <select name="cmb_subsector" class="ddlb_9_x">
		<option value=0 selected>(Seleccionar)</option>
		<?
		
		for($i=0 ; $i < @pg_numrows($resultado_sub) ; $i++){
			$fila = @pg_fetch_array($resultado_sub,$i);?>
			<?
			if ($fila["id_ramo"] == $cmb_subsector){
			   ?>
			   <option value="<? echo $fila["id_ramo"]; ?>" selected><? echo ucwords(strtolower($fila["nombre"]));?></option>
			   <?
			}else{
			   ?>
			   <option value="<? echo $fila["id_ramo"]; ?>"><? echo ucwords(strtolower($fila["nombre"]));?></option>
			   <?
			}
			?>	   
			
			
			<?
		}
		?>
      </select>
    </div>	</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="textosimple">Despues de promocion</td>
    <td class="textosimple"><input type="radio" name="final" id="final" value="1" onClick="activa(this.value)" checked>
      SI 
        <input type="radio" name="final" id="final" value="2"  onClick="activa(this.value)">
        NO</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">Periodo</td>
    <td> <select name="cmb_periodo" class="ddlb_9_x" id="cmb_periodo" disabled>
		<option value=0 selected>(Seleccionar)</option>
		<?
		
		for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
			$fila = @pg_fetch_array($result_peri,$i);?>
			<?
			if ($fila["id_periodo"] == $cmb_periodo){
			   ?>
			   <option value="<? echo $fila["id_periodo"]; ?>" selected><? echo ucwords(strtolower($fila["nombre_periodo"]));?></option>
			   <?
			}else{
			   ?>
			   <option value="<? echo $fila["id_periodo"]; ?>"><? echo ucwords(strtolower($fila["nombre_periodo"]));?></option>
			   <?
			}
			?>	   
			
			
			<?
		}
		?>
      </select></td>
    <td>&nbsp;</td>
  </tr>
	<tr>
		<td class="textosimple">Orden</td>
		<td class="textosimple">
		  Mayor a Menor  <input name="orden" type="radio" id="orden" value="1" checked> &nbsp;
		  Menor a Mayor&nbsp;<input type="radio" name="orden" id="orden" value="2"></td>
		</tr>
    
</table>

	<table width="600" border="0" align="right" cellpadding="1" cellspacing="0">
      <tr>
        <th width="462" scope="col"><div align="right"><span class="textosimple">
          <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar">
        </span></div></th>
        <th width="64" scope="col"><div align="right">
          <input name="cb_exp" type="submit" class="botonXX" onClick="enviapag2(this.form)"  id="cb_exp" value="Exportar">
        </div></th>
        <th width="52" scope="col"><div align="right"> 
          <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
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
<br><br>
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
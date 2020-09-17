<? 	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Reporte.php');
	include ("Calendario/calendario.php");

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$curso			=$c_curso;
	$subsector		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	
	foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);

//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);

// echo "asignacion=$asignacion<br>";
   }
   		//año escolar
  		$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$nro_ano = $fila_ano['nro_ano'];
		  
		  
		  function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
   //------------------- CURSO -----------------------
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript" src="Calendario/javascripts.js"></script>
<SCRIPT language="JavaScript">
	function enviapag2(form){
			form.target="_blank";
			var subsector 	= document.form.cmb_subsector.value;
			var curso 		= document.form.cmb_curso.value;
			var periodo 	= document.form.cmb_periodos.value;
			document.form.action='printInformePlanificacionCurricular_C.php?cmb_periodos='+periodo+'&cmb_curso='+curso+'&cmb_subsector='+subsector;
			document.form.submit(true);
	}
	function enviapag(form){
		if (form.cmb_curso.value!=0){
			form.cmb_curso.target="self";
			window.location= 'InformePlanificacionCurricular_C.php?cmb_periodos=' + document.form.cmb_periodos.value + '&cmb_curso=' + document.form.cmb_curso.value;
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


function comprobar(form1)
{
	if (form1.cmb_periodos.value==0)
	{
		alert("Seleccione periodo ");
		form1.cmb_periodos.focus();
		return false
	}
	
	if (form1.semana.value=="")
	{
		alert("Especifique semana ");
		form1.semana.focus();
		return false
	}
	
	if (form1.eje.value=="")
	{
		alert("Especifique EJE ");
		form1.eje.focus();
		return false
	}

	if (form1.objetivo.value=="")
	{
		alert("Especifique objetivo ");
		form1.objetivo.focus();
		return false
	}
	
	if (form1.FechaDesde.value=="")
	{
		alert("Seleccione Fecha ");
		form1.FechaDesde.focus();
		return false
	}
	
	if (form1.cumplido.value=="")
	{
		alert("Especifique porcentaje de cumplimiento ");
		form1.cumplido.focus();
		return false
	}
	
	if (form1.cobertura.value=="")
	{
		alert("Especifique porcentaje de cobertura ");
		form1.cobertura.focus();
		return false
	}
	

}

function solonumeroypunto()
{
   if ((event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 46) 
    event.returnValue = false; 
}
//-->
</script>

<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
-->
</style>
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
						include("../../../../cabecera/menu_inferior.php");
						?>
  
  
</table>
<!-- FIN CODIGO DE BOTONES -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<!--<form method "post" action="printInformePlanificacionCurricular_C.php"  name="form"> -->
<form method="post" action="printInformePlanificacionCurricular_C.php" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<? 
//------------------

$ob_motor = new MotorBusqueda();

$ob_motor ->ano = $ano;
$resultado_query_cue = $ob_motor ->curso($conn);

$ob_motor ->ano = $ano;
$result_peri = $ob_motor ->periodo($conn);

if($cmb_curso!=0){
	$ob_motor ->curso =$cmb_curso;
	$resultado_sub = $ob_motor ->Subsector($conn);
}

$ob_reporte = new Reporte();

//------------------
?>
<center>
<table width="572" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="56" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" height="11" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="textosimple">Periodo</td>
    <td colspan="2"><select name="cmb_periodos" class="ddlb_9_x">
      <option value=0 >AÑO COMPLETO</option>
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
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="66" class="textosimple">Curso</td>
    <td colspan="2">
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
    <td width="44" class="textosimple">&nbsp;</td>
    <td width="157">&nbsp;</td>
    <td width="66"><div align="right">
      <!--input name="cb_ok" class="botonX" onMouseOver=this.style.background='FFFFD7';this.style.color='003b85' onMouseOut=this.style.background='#5c6fa9';this.style.color='ffffff' type= "submit"  value="Buscar"-->
    </div></td>
  </tr>
  <tr>
    <td class="textosimple">Subsector</td>
    <td colspan="2">
	<div align="left">
	  		
      <select name="cmb_subsector" class="ddlb_9_x">
		<option value=0 selected>--Seleccione--</option>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td width="89"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar"></td>
	
    <td width="150"><input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'"></td>
    
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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

 
 								  								  
								  
                              <p></p>
							  <br></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table></td>
                                </tr>
                              </table>
</body>
</html>
<? pg_close($conn);?>
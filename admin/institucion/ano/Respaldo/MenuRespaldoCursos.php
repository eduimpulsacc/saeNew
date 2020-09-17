<?php require('../../../../util/header.inc');?>

<?
	//---------------
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$_POSP = 4;
	$_bot = 0;
	$ano			=$_ANO;
	//----------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
<SCRIPT language="JavaScript">
<!--
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'MenuRespaldoCursos.php';
				form.submit(true);
	
				}	
			}			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
								  
							
													  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>

								   <!-- INSERTAMOS CODIGO NUEVO -->
							 
							       <center>
<table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>
        <div align="right">
          <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name=btnModificar  onClick=document.location="../Menu_Respaldo.php">
      </div></td>
    </tr>
</table>
  <table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
		
		
		<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="notas_por_asignatura.php">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="56" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" height="11" class="tableindex">Respaldo de Notas desde Colegio Interactivo</td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td class="textosimple">Periodo</td>
    <td><select name="cmb_periodo" class="ddlb_9_x">
      <option value=0 selected>(Seleccione Periodo)</option>
      <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodo)
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
    <td width="69" class="textosimple">Curso</td>
    <td width="272">
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
    <td width="61" class="textosimple">&nbsp;</td>
    <td width="219">&nbsp;</td>
    <td width="80">&nbsp; </td>
  </tr>
  <tr>
    <td class="textosimple">Subsector</td>
    <td>
	<div align="left">
	  		
      <select name="cmb_ramo" class="ddlb_9_x">
      <option value=0 selected>(Todos los Subsectores)</option>
		
		<?
		$sql_sub = "select ramo.id_ramo, subsector.nombre from ramo, subsector ";
		$sql_sub = $sql_sub  . "where id_curso = ".$cmb_curso." and ramo.cod_subsector = subsector.cod_subsector order by id_orden";
		$resultado_sub = pg_exec($conn,$sql_sub);
		for($i=0 ; $i < @pg_numrows($resultado_sub) ; $i++){
			$fila = @pg_fetch_array($resultado_sub,$i);?>
			<?
			if ($fila["id_ramo"] == $cmb_ramo){
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
    <td>
	
<!--	<input type="button" class="botonXX" onClick=window.open("RespaldoNotas.php?id_periodo=<? echo $cmb_periodo?>&id_curso=<? echo $id_curso?>&id_ramo=<? echo $id_ramo?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=400,top=85,left=140") value="Buscar">  -->
	
<!--  <input name="cb_ok" type="button" class="botonXX" id="cb_ok" onClick=window.open("RespaldoNotas.php?id_curso='cmb_curso.options[cmb_curso.selectedIndex].value'&id_periodo='cmb_periodo.options[cmb_periodo.selectedIndex].value&id_ramo='cmb_ramo.options[cmb_ramo.selectedIndex].value","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=400,top=85,left=140") value="Buscar">  -->
<input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="window.open('RespaldoNotas.php?id_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;id_periodo='+cmb_periodo.options[cmb_periodo.selectedIndex].value+'&amp;id_ramo='+cmb_ramo.options[cmb_ramo.selectedIndex].value);return document.MM_returnValue" value="Generar Respaldo"></td>
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
		
		</td>
    </tr>
  </table>
  


</center>
							 
							 
							 	   <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
								   </td>
								 </tr>
							 </table>	
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../cabecera/menu_inferior.php");?></td>
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
<? pg_close ($conn);?>
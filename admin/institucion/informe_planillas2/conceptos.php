<?php require('../../../util/header.inc');

$plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 4;
$_bot = 7;
$query_plantilla="select * from informe_plantilla where id_plantilla='$plantilla'";
$result_planilla=pg_exec($conn,$query_plantilla);
$num_planilla=pg_numrows($result_planilla);
if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}
if ($eliminar){
	$query_del="delete from informe_concepto_eval where id_concepto='$eliminar'";
	$result_del=pg_exec($conn,$query_del);
}
if ($modificar){
	$query_update="update informe_concepto_eval set nombre='$nombre',glosa='$glosa',sigla='$sigla', orden='$orden' where id_concepto='$id_concepto'";
	$result_del=pg_exec($conn,$query_update);
}
if ($nuevo){
		$sqlConcepto="INSERT INTO informe_concepto_eval (id_plantilla, nombre, sigla, glosa, fecha_creacion) VALUES ($plantilla, '$nombre', '$sigla', '$glosa',now ())";
		$resultConcepto=pg_Exec($conn, $sqlConcepto);
}

?>
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
<script language="javascript" type="text/javascript">
<!--
function eliminar(nombre,id){
	txt="esta seguro de eliminar el concepto   "+nombre;
	resp=confirm (txt);
	if (resp==true){
		url="conceptos.php?eliminar="+id;
		window.location=url;
	}else{
	
	}
}
function cambia(tr1,tr2){
	document.getElementById(tr1).style.display="none";
	document.getElementById(tr2).style.display="";
}
function valida(form){
	error="";
	if (form.nombre.value==""){error=error+"Nombre es requerido\r\n";}
	if (form.sigla.value==""){error=error+"Sigla es requerido\r\n";}
	if (form.glosa.value==""){error=error+"Glosa es requerido\r\n";}
	if (form.orden.value==""){error=error+"Orden es requerido\r\n";}
	if (error!=""){
		alert (error);
		return false;
	}else{
		return true;
	}
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top">
								<table width="100%">
								  <tr>
								    <td class="fondo">Administracion de conceptos Evaluativos (<? echo $row_planilla['nombre'];?>) </td>
								  </tr>
								  <tr><td><input name="submit" type="button" class="botonXX" onClick="MM_goToURL('parent','ver_informe.php?plantilla=<?=$plantilla;?>&creada=1');return document.MM_returnValue" value="Volver"></td></tr>
								  <tr>
								  	<td><strong>Conceptos existentes</strong></td>
								  </tr>
								  <tr>
								    <td>
								  	<table>
									<tr> 
										 <td width="33%"><strong>Nombre</strong></td>
                                        <td width="33%"><strong>Sigla</strong></td>
                                        <td width="33%"><strong>Glosa</strong></td>
                                        <td width="33%"><strong>Orden</strong></td>
										 <td width="33%">&nbsp;</td>
									</tr>
									<? $query_todos="SELECT * FROM informe_concepto_eval where id_plantilla='$plantilla' order by id_concepto";
									   $result_todos=pg_exec($conn,$query_todos);
									  $num_todos=pg_numrows($result_todos);?>
									  <? for ($i=0;$i<$num_todos;$i++){
									  $row_todos=pg_fetch_array($result_todos);
									  ?>
									<tr id="tringresa_<? echo $row_todos[id_concepto];?>"> 
										 <td width="33%" class="cuadro01"><? echo $row_todos['nombre'];?></td>
										<td width="33%" class="cuadro01"><? echo $row_todos['sigla'];?></td>
										<td width="33%" class="cuadro01"><? echo $row_todos['glosa'];?></td>
										<td width="33%" class="cuadro01">&nbsp;<? echo $row_todos['orden'];?></td>
										<td nowrap>
										  <input type="button" value="Modificar"  onclick="cambia('tringresa_<? echo $row_todos[id_concepto];?>','trmodifica_<? echo $row_todos[id_concepto];?>')" class="botonXX">
										  <input  type="button" value="Eliminar"  onClick="eliminar('<? echo $row_todos[nombre];?>','<? echo $row_todos[id_concepto];?>')" class="botonXX"></td>
									</tr>
									<form onSubmit="return valida(this);" method="post">
									<tr id="trmodifica_<? echo $row_todos[id_concepto];?>" style="display:none "> 
										 <td width="33%" class="cuadro01"><input name="nombre" type="text" value="<? echo trim($row_todos['nombre']);?>"></td>
                                        <td width="33%" class="cuadro01"><input name="sigla" type="text" value="<? echo trim($row_todos['sigla']);?>" ></td>
                                        <td width="33%" class="cuadro01"><input name="glosa" type="text" value="<? echo trim($row_todos['glosa']);?>"></td>
                                        <td width="33%" class="cuadro01"><input name="orden" type="text" value="<? echo trim($row_todos['orden']);?>" size="10"></td>
										  <td width="33%" nowrap>
										  <input name="id_concepto" type="hidden" value="<? echo $row_todos[id_concepto];?>"> 
										  <input  name="modificar"type="submit" value="Guardar" class="botonXX" >
										  <input  type="button" value="Cancelar" onClick="cambia('trmodifica_<? echo $row_todos[id_concepto];?>','tringresa_<? echo $row_todos[id_concepto];?>')" class="botonXX"></td>
									</tr>
									</form>
									<? }?>
									
									</table>
									</td></tr>
								  
								  </table>
								  <table>
								  	<tr>
								  	  <td><strong>Nuevo Concepto</strong></td>
								  	</tr>
									<tr><td>
									<form method="post" onSubmit="return valida(this);" >
									<table>
									<tr> 
										 <td width="33%"><strong>Nombre</strong></td>
                                        <td width="33%"><strong>Sigla</strong></td>
                                        <td width="33%"><strong>Glosa</strong></td>
									</tr>
									<tr> 
										 <td width="33%"><input name="nombre"></td>
                                        <td width="33%"><input name="sigla" ></td>
                                        <td width="33%"><input name="glosa"> </td>
									</tr>
									<tr> 
										 <td  colspan="3" align="center"><input name="nuevo" type="submit" value="Guardar" class="botonXX"></td>
									</tr>
									</table>
									
								  </form>
								  
								  </table>
								
								</td>
                              </tr></table>                         </td>
                          </tr>
                        </table></td>
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
</body>
</html>

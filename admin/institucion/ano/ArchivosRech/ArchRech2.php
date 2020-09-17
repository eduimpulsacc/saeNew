<? 
	require('../../../../util/header.inc');
	include('../../../../util/rpc.php3');
	
/*	$institucion	=$_INSTIT;
	$_POSP = 3;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	
	if ($_PERFIL == 1){
	   $_MDINAMICO = 1;
	}   
if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
*/
?>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="../../../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript">
	function delRow(a)
	{
		b="adjunta["+a+"]";
		a="td"+a;
		z=document.getElementById(b);
		z.disabled=true;
		x=document.getElementById(a);
		x.style.display="none";
		//x=document.getElementById('mytable').deleteRow(a)
	}
	
	function insRow()
	{
		largo=document.getElementById('mytable').rows.length;
		var x=document.getElementById('mytable').insertRow(largo);
		j=largo;
		var y=x.insertCell(0)
		y.className="td2";
		y.id="td"+j;
		y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
	
	}
	
	function coloca_nombre(){
		largo=document.getElementById('mytable').rows.length;
		for (ii=1;ii<largo;ii++){
			origen="adjunta["+ii+"]";
			z=document.getElementById(origen);
			temp=tomaNombre(z)
			
			destino="nombreadjunta["+ii+"]";
			zz=document.getElementById(destino);
			zz.value=temp;	
		}
	}

</script><script language="JavaScript" type="text/JavaScript">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
           			 <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>	
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
					  		$menu_lateral=1;
							include("../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top">
					  
					  
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                          
                          <tr> 
                            <td height="300" align="left" valign="top">
							
							
                   <table width="100%">
					<tr>
						<td class="tableindex"><CENTER>
						  Subir Archivos RECH
						</CENTER></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>	
		<?		if($caso==4){	?>
					<tr><td>&nbsp;</td></tr>
					<tr><td class="ccctableindex">Ha finalizado con exito el ingreso de datos.</td>
					</tr>
		<?		}			
				else{	?>
					  <tr>
						<td colspan="2" class="tableindex">1.- Adjuntar Archivos</td>
					  </tr>
					  <tr>
						<td>
				<form action="SubeArchivo.php" method="post" enctype="multipart/form-data">
				  <input type="file" name="Documento" accept="application/*" />
				  <input name="rdb" type="hidden" value="<? echo $row_sol[id_sol];?>" />
							<input name="wher" type="hidden" value="<? echo str_replace("'","\'",$wher);?>" />
							<input name="guardar_comentario" type="submit" class="botonXX" value="Guardar" />
				</form>		</td>
					  </tr>
				<?
					if($caso==2 || $caso==3){	?>
						<tr><td>&nbsp;</td></tr>
						<tr><td colspan="2" class="tableindex">2.- Inserta Archivos en Tablas.</td>
						</tr>
						<tr><td>
						<form action="insertaTablas.php" method="post" enctype="multipart/form-data">
						<table>
							<tr>
								<td><input name="inserta" type="submit" class="botonXX" value="Insertar" /></td>
							</tr>
						</table>
						</form>
						</td></tr>
						
				<?		if($caso==3){	?>
							<tr><td>&nbsp;</td></tr>
							<tr><td colspan="2" class="tableindex">3.- Inserta la Informaci&oacute;n en la Base de Datos.</td>
							</tr>
							<tr><td>
								<form action="Distribuye.php" method="post" enctype="multipart/form-data">
								<table>
									<tr>
										<td><input name="distribuye" type="submit" class="botonXX" value="Distribuye" /></td>
									</tr>
								</table>
								</form>
							</td></tr>
				<?		}			
	
					}	?>
		<?	}	?>
</table>							
							
							</td>
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

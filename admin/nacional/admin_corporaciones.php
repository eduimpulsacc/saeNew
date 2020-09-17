<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 2;

   $_MDINAMICO = 1;	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->

</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
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
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<center>
		<form method="post" name="frm" action="procesaCorporacion.php">
			<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
	
				<tr height="20%">
					
					<td colspan="4" align="middle" class="tableindex"><center>ADMINISTRACION DE CORPORACIONES</center></td>
				</tr>
				<tr>
					<td colspan="4" align="middle"><input type="text" name="txt_corp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value="Ingresar Corporación" class="botonXX" onClick="valida()"></td>	
				</tr>			
				<tr>
					<td align="center" width="70%" class="tablatit2-1">
						<div align="center">CORPORACION					  </div></td>
					<td align="center" width="20%" class="tablatit2-1">
						<div align="center">TOTAL</div></td>
					<td align="center" width="10%" class="tablatit2-1">
						<div align="center">ELIMINAR</div></td>						
				</tr>
				<? 	$qry = "select * from corporacion";
					$res = @pg_Exec($conn,$qry);								
				?>			
					<? for($i=0;$i<pg_numrows($res);$i++)
					{	
						$fila = @pg_fetch_array($res);
						?>
						<tr>
							<td align="center" class="textosimple" bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('../corporacion/admin_instituciones.php?variable=<?=$fila['num_corp']?>')><?=$fila['nombre_corp']?></td>
							<? 
							$num_corp = $fila['num_corp'];						
							$qry2 = "select num_corp from corp_instit where num_corp = '$num_corp'";
							$res2 = pg_Exec($conn,$qry2);?>							
							<td align="center" class="textosimple"  bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('../corporacion/admin_instituciones.php?num_corp=<?=$fila['num_corp']?>')><?=pg_numrows($res2)?></td>
							
							<td align="center"  class="textosimple" bgcolor=#ffffff ><img src="eliminar.png" onClick="MM_goToURL('parent','procesaCorporacion.php?del=1&codigo=<?=$fila['num_corp']?>');return document.MM_returnValue" onmouseover=this.style.cursor='hand'></td>
						</tr>										
				<?	}	?>				
			</table>
		</form>


									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							   </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>

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
                                   <table width="66%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="174" valign="top"><!-- inicio codigo antiguo -->
								  <table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>
        <div align="right">
          <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name="btnModificar"  onClick="document.location='../Menu_Respaldo.php'">
      </div></td>
    </tr>
</table>
<form action="RespaldoAsistencia.php" method="post">
<table width="90%" border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
    <td class="tableindex" colspan="3">Buscador Avanzado </td>
   </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td center="left">&nbsp;</td>
    <td center="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="124" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td width="18" center="left">:</td>
    <td width="493" center="left">
	<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}?>
                    <select name="cmb_ano" id="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }?>
                    </td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>MES CONSULTA </strong></FONT></td>
    <td center="left">:</td>
    <td center="left"><label for="cmb_mes"></label>
      <select name="cmb_mes" id="cmb_mes">
        <option value="00">(seleccione)</option>
        <option value="01">Enero</option>
        <option value="02">Febrero</option>
        <option value="03">Marzo</option>
        <option value="04">Abril</option>
        <option value="05">Mayo</option>
        <option value="06">Junio</option>
        <option value="07">Julio</option>
        <option value="08">Agosto</option>
        <option value="09">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>
      </select></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td center="left">&nbsp;</td>
    <td center="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>FORMATO</strong></FONT></td>
    <td center="left">&nbsp;</td>
    <td center="left"><input type="radio" name="formato" id="form1" value="txt">
      <FONT face="arial, geneva, helvetica" size=2><strong>TXT 
      <input name="formato" type="radio" id="form2" value="xls" checked="CHECKED">
      XLS </strong></FONT></td>
  </tr>
  <tr>
    <td colspan="3" align="left"><FONT face="arial, geneva, helvetica" size=2><strong>&nbsp;&nbsp;&nbsp;</strong></FONT></td>
    </tr>
  <tr>
    <td colspan="3" align="right"> <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Generar archivo" onClick="enviapag(this.form);"></td>
  </tr>
   
</table>

</form>


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
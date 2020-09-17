<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

		<SCRIPT language="JavaScript">
			function enviapag2(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="_blank";
//				form.action = form.cmbPERIODO.value;
				form.action = 'Lista_Alumnos_Curso_excel.php?cmb_curso='+ form.cmb_curso.value;
				form.submit(true);
				}
			}
		</SCRIPT>

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../cabecera/menu_superior.php");
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
						include("../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="682" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="682" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								

	
<FORM method="post" name="frm">
<? 
$sql_curso= "SELECT * FROM corporacion";
$resultado_query_cue = pg_exec($conn,$sql_curso);
?>
<center>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="550">
	<table width="550" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" class="tableindex" align="center">Detalle de Conexiones por Corporación</td>
  </tr>
  <tr>
    <td height="27">
	<table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="420" class="cuadro01">Buscar Corporación
      <select name="corporacion" class="ddlb_x">
        <?	while ($fila = @pg_fetch_array($resultado_query_cue)) {?>
		  		
                <option value="<?=$fila['num_corp']?>" <? if (isset($_POST['corporacion']) && $_POST['corporacion'] == $fila['num_corp']) { echo 'selected'; } ?>><?=$fila['nombre_corp']?></option>
                
                
		<? 	}?>
      </select></td>
    
   
    <td width="80">
            <div align="center">
              <input name="cb_ok" class="botonXX"  type="submit" value="Buscar">        
                  </div></td>
  </tr>
</table>

<!--DETALLE ESTADISTICAS POR CORPORACIONES	-->
	<? if (isset($_POST['cb_ok']) && $_POST['cb_ok'] == 'Buscar') { ?>
    <table align="center">
	<tr><td><table width="350" border="1" align="center" cellpadding="0" cellspacing="0">
	     
    <tr> 
	 <td align="center" width="50%" class="tablatit2-1">Institución</td>
      <td align="center" width="50%" class="tablatit2-1">Conexiones</td>
    </tr>
    
    <?	$sql_corp = "SELECT institucion.nombre_instit, SUM(estadistica.cant_conex) AS total FROM institucion INNER JOIN corp_instit ON (corp_instit.num_corp = ".$_POST['corporacion']." AND corp_instit.rdb = institucion.rdb) INNER JOIN estadistica ON (institucion.rdb = estadistica.rdb) and estadistica.fecha BETWEEN '20081130' AND '20090101' GROUP BY institucion.nombre_instit ORDER BY total DESC";
		$res_corp = pg_exec($conn,$sql_corp);
	?>
    <? while ($arr_corp = @pg_fetch_array($res_corp)) {?>
   <tr>
   		
		<td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000"><?=$arr_corp['nombre_instit']?></font> </td>
       
    	<td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000"><?=$arr_corp['total']?></font> </td>
      	
    </tr>
    <? }?>
    <?	$sql_corp2 = "SELECT institucion.nombre_instit FROM institucion
INNER JOIN corp_instit ON (corp_instit.num_corp = ".$_POST['corporacion']."
AND corp_instit.rdb = institucion.rdb) LEFT JOIN estadistica
ON (institucion.rdb = estadistica.rdb)
GROUP BY institucion.nombre_instit
HAVING SUM(estadistica.cant_conex) IS NULL";
		$res_corp2 = @pg_exec($conn,$sql_corp2);
	?>
    <? while ($arr_corp2 = @pg_fetch_array($res_corp2)) {?>
   <tr>
   		
		<td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000"><?=$arr_corp2['nombre_instit']?></font> </td>
       
    	<td align="left" > <font face="arial, geneva, helvetica" size="1" color="#000000">0</font> </td>
      	
    </tr>
    <? }
	}?>
    
    
    
	</table></td></tr>
    
	<tr> 
      <td colspan="5"> <hr width="100%" color="#003b85"> </td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
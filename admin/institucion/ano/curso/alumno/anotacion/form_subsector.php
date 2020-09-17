<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$_POSP          =6;
	$_bot           =5;
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
	<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
	
<script language="javascript1.1">
<!--
function delRow(a)
{
b="sigla"+a+"";
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
	y.innerHTML="Sigla: <input name='sigla"+j+"' type='text' size='10' id='sigla"+j+"'> Descripción: <input name='descripcion"+j+"' size='65' type='text' id='descripcion"+j+"'><input type='hidden' name='total' value='"+j+"'> &nbsp; <a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"

}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						 $menu_lateral= "3_1";
						 include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!--inicio codigo antiguo -->
								  
								  
								  
	
 					  

		  <form name="form" method="post" enctype="multipart/form-data" action="proceso_subsectorapre.php">
			<center>
			  <table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
				  <td class="tableindex"><div align="center">SUBSECTOR DE APRENDIZAJE </div></td>
				</tr>
				<tr>
				  <td><div align="right">
					<label>
					<input name="Submit" type="submit" onClick="MM_validateForm('codigotipo','','R','descripciontipo','','R');return document.MM_returnValue" value="GUARDAR"  class="botonXX">
					<input name="Submit2" type="button" onClick="MM_callJS('history.go(-1)')" value="VOLVER" class="botonXX">
					</label>
				  </div></td>
				</tr>
				<tr>
				  <td>
				  
				  
				  <table width="100%" border="1" cellspacing="0" cellpadding="0">
					
					<tr>
					  <td colspan="2" class="cuadro02"><div align="center">SUBSECTORES</div></td>
					  </tr>
					<tr>
					  <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						  <td>
						  
						  
						  <table width="100%" border="0" cellspacing="0" cellpadding="3" id="mytable">
							 
							 <tr>
							  <td colspan="4"><label><a href="javascript:;" onClick="insRow();">Agregar</a></label></td>
							  </tr>
							   
							<?
							$q1 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion'";
							$r1 = pg_Exec($conn,$q1);
							$n1 = pg_numrows($r1);
							
							$i = 0;
							while ($i < $n1){
							    $f1 = pg_fetch_array($r1,$i);
								$sigla = $f1['sigla'];
								$detalle = $f1['detalle'];
								?>				  
							  
							    <script>
							        largo=document.getElementById('mytable').rows.length;
									var x=document.getElementById('mytable').insertRow(largo);
									j=largo;
									var y=x.insertCell(0)
									y.className="td2";
									y.id="td"+j;
									y.innerHTML="Sigla: <input name='sigla"+j+"' type='text' size='10' id='sigla"+j+"' value='<?=$sigla ?>'> Descripción: <input name='descripcion"+j+"' size='65' type='text' id='descripcion"+j+"' value='<?=$detalle ?>'><input type='hidden' name='total' value='"+j+"'> &nbsp; <a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
                                 </script>
								 <?
								 $i++;
							 }
							 ?>	
						  </table>
						  
						  
						  
						  </td>
						</tr>
						
					  </table></td>
					  </tr>
				  </table>
					  
				  </td>
				</tr>
			  </table>	  
			</center>
			</form>	  
	
	
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>

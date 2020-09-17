<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	//$_POSP = 3;
	$ano			=$_ANO;
   //$_MDINAMICO = 1;	
 //  echo $_POST["cmb_curso"];
   
      //require_once("../../estadisticas/widgets/widgets_start.php"); 
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript">
        function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="acti_extraprogramaticas.php";
				form.action = pag;
				form.submit(true);	
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
//-->
</script>

		<?php include('../../util/rpc.php3');
		$cmb_ensenanza=$_POST["cmb_ensenanza"];?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../../estadisticas/widgets/calendar-brown.css" title="green"/>

		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        	<tr>
			  <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>"></td>
			  <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><? include("../../cabecera/menu_superior.php");?></td>
	        </tr>
            <tr align="left" valign="top"> 
    	        <td height="83" colspan="3">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
                    	<tr> 
                      		<td width="27%" height="363" align="left" valign="top"><? include("../../menus/menu_lateral.php");?></td>
		                    <td width="73%" align="left" valign="top"> codigo</td>
	                    </tr>
    	                <tr align="center" valign="middle"> 
	                    	<td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
	                    </tr>
                  	</table>
				</td>
             </tr>
        </table>
    </td>
    <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>"></td>
  </tr>
</table>

</body>
</html>

<? // require_once("includes/widgets/widgets_end.php");?>

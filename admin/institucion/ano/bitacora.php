<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
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
 ?>
 <SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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
</script>

<SCRIPT language="JavaScript">

			function generar(){
				if(confirm('!!!ADVERTENCIA, esta opción se utiliza creado el nuevo año para traspasar alumnos del año anterior¡¡¡') == false){ return; };
//				document.location="procesoMatAuto.php3"
				document.location="pre_matauto.php"				
			};
			
			function mensaje(){
				alert('Estimado usuario, /n Para traspaso de matrícula del año anterior al año actual, debe contactarse al dpto. de Soporte');		
			};


			function Confirmacion(){
			if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR!') == false){ return; };
			};
</script>
<?php

$qry1="SELECT tipo_regimen FROM ANO_ESCOLAR WHERE id_ano=".$ano;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php include('../../../util/rpc.php3');?>
<?php	if($frmModo=="ingresar"){
			include('../../../util/rpc.php3');?>

			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkVacio(form.txtANO,'Ingresar numero del AÑO.')){
						return false;
					};

					if(!soloNumeros(form.txtANO,'Se permiten sólo numeros.')){
						return false;
					};
					
					 if(form.txtFECHAINI.value==""){
						alert ('debe agregar la fecha de INICIO');
					     return false;
				    };
					if(!chkFecha(form.txtFECHAINI,'Fecha de INICIO inválida.')){
					    return false;
				     };
					 
					if(form.txtFECHATER.value==""){
						alert ('debe agregar la fecha de FIN');
					     return false;
				    };
					if(!chkFecha(form.txtFECHATER,'Fecha de FIN inválida.')){
					    return false;
				     };
					 
	
					if (form.cmbREGIMEN.value==0){
						alert ('seleccione un tipo de regimen');
					     return false;
					}

					return true;
				}
			</SCRIPT>
<?php	}; ?>
<?php	if($frmModo=="modificar"){
			include('../../../util/rpc.php3');?>
			<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
			<SCRIPT language="JavaScript">
				function valida(form){
						
		if(!chkVacio(form.txtANO,'Ingresar numero del AÑO.')){
						return false;
					};

					if(!soloNumeros(form.txtANO,'Se permiten sólo numeros.')){
						return false;
					};
					
					 if(form.txtFECHAINI.value==""){
						alert ('debe agregar la fecha de INICIO');
					     return false;
				    };
					if(!chkFecha(form.txtFECHAINI,'Fecha de INICIO inválida.')){
					    return false;
				     };
					 
					if(form.txtFECHATER.value==""){
						alert ('debe agregar la fecha de FIN');
					     return false;
				    };
					if(!chkFecha(form.txtFECHATER,'Fecha de FIN inválida.')){
					    return false;
				     };
					 return true;
				}
			</SCRIPT>
<?php	}; ?>
	
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 


<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../estilos.css" rel="stylesheet" type="text/css"-->
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
              </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td align="left" valign="top">&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 
<?
pg_close($conn);
?>
</body>
</html>

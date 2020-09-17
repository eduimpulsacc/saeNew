<?php require('../../../util/header.inc');?>
<?php  
	$institucion	=$_INSTIT;
	$_POSP = 3;
	
	$menu = $_GET['menus'];
	
	if ($menu == ''){
	
	$menu =0 ;
	
	}
	
   $_MDINAMICO = 1;	
	
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
//-->
</script>
<script type="text/javascript">

function enviapag(form){
	if(document.form.cmbANO.value==0){
		alert('Ingrese AÑO.');
		return false;
	};

	form.action = 'printDotacionDocente.php';
	form.submit(true);
}	
</script>

		<?php include('../../../util/rpc.php3');?>
	
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<style type="text/css">
<!--
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_info_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_mapa_r.jpg','file:///C|/Documents and Settings/Eduardo/Mis documento/coi/cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
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
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">
		   <form name="form" action="printDotacionDocente.php" method="post">
		  <table width="61%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="3"  class="tableindex">Motor de b&uacute;squeda avanzado </td>
              </tr>
            <tr>
              <td width="33%"  class="cuadro01"> <div align="right">A&Ntilde;O</div></td>
              <td width="44%" class="cuadro01">&nbsp;
                 <?  $year = date("Y")-6;
					$year_act = date("Y");
				?>
                <select name="cmbANO">
                <? for($i=$year_act;$i>=$year;$i--){?>
	                <option value="<?=$i;?>"><?=$i;?></option>
             	<? } ?>
 				</select>  			  </td>
              <td width="23%" class="cuadro01">&nbsp;</td>
            </tr>
            <tr>
              <td  class="cuadro01"><div align="right">TIPO PROFESIONAL </div></td>
              
              <td  colspan="2" class="cuadro01"><span class="Estilo25">
                <input name="docente" type="radio" value="1" checked>
Docentes
<input name="docente" type="radio" value="2">
Directivo Docente
<input name="docente" type="radio" value="3">
T&eacute;cnico-Pedag&oacute;gico</span></td>
            </tr>
            <tr>
              <td  class="cuadro01"><div align="right">SELECCIONE INSTITUCI&Oacute;N </div></td>
              <td  colspan="2" class="cuadro01"><div id="subsectores">
				<table width="100%" border="0" cellpadding="3" cellspacing="0">
					 <? 
					 
$sql ="SELECT rdb, nombre_instit FROM institucion WHERE rdb IN ( select rdb from corp_instit 
inner join nacional_corp on nacional_corp.num_corp = corp_instit.num_corp
inner join nacional on nacional.id_nacional = nacional_corp.id_nacional
where nacional.id_nacional= ".$_NACIONAL.")";

						$rs_corp = @pg_exec($conn,$sql);
							for($i=0;$i<@pg_numrows($rs_corp);$i++){
								$fila = @pg_fetch_array($rs_corp,$i);
						?>
						 <tr>
							<td><input name="instit<?=$i;?>" type="checkbox" value="<?=$fila['rdb'];?>" checked="checked"></td>
							<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?="(".$fila['rdb'].") ".$fila['nombre_instit'];?></font></td>
					    </tr>
					<? } ?>
					<input name="cont" type="hidden" value="<?=$i;?>">
				</table>
			</div></td>
            </tr>
            <tr>
              <td  class="cuadro01">&nbsp;</td>
              <td colspan="2" class="cuadro01"><input type="button" name="Submit" value="BUSCAR" class="botonXX" onClick="enviapag(this.form);">
                &nbsp;&nbsp;                <input name="VOLVER" type="button" value="VOLVER" class="botonXX" onClick="window.location='../reportesCorporativos.php'"></td>
              </tr>
          </table>
		  </form>
		  </td>
        </tr>
      </table>
	</center>
	<!-- FIN DE INGRESO DE CODIGO NUEVO -->								  </td>
							   </tr>
							 </table>							  
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table>
				  </td>
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

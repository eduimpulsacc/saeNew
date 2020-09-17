<?
require('../../../util/header.inc');
$_POSP = 3;
$_bot = 10;

$_POSP          = 3;
$_bot           = 10;
$institucion	= $_INSTIT;
if ($_FRMMODO==""){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
//modo
 $qry="SELECT * FROM SMS_CONFIG WHERE RDB=".$institucion." AND ESTADO=1";
  $result =@pg_Exec($conn,$qry);
  if(pg_numrows($result)==0){
	  $_FRMMODO="ingresar";
	 }


//	echo $_FRMMODO;



/************ PERMISOS DEL PERFIL *************************/
if($nw==1){
	$_MENU =$menu;
	session_register('_MENU');
	$_CATEGORIA = $categoria;
	session_register('_CATEGORIA');
}
$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
$ingreso = @pg_result($rs_permiso,0);
$modifica =@pg_result($rs_permiso,1);
$elimina =@pg_result($rs_permiso,2);
$ver =@pg_result($rs_permiso,3);

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

<script type="text/javascript" src="../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../clases/jquery-ui-1.9.2.custom/development-bundle/themes/base/jquery.ui.datepicker.css">
<script>
$(document).ready(function() { 
$( "#fecha_hab,#fecha_cad" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]/*,
    onSelect: function(dateText){
        var seldate = $(this).datepicker('getDate');
        seldate = seldate.toDateString();
        seldate = seldate.split(' ');
        var weekday=new Array();
            weekday['Mon']="1";
            weekday['Tue']="2";
            weekday['Wed']="3";
            weekday['Thu']="4";
            weekday['Fri']="5";
            weekday['Sat']="6";
            weekday['Sun']="7";
        var dayOfWeek = weekday[seldate[0]];
		 $('#diasemana_accidente').val(dayOfWeek);
		 
    }*/
	
});
});
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
					
						    <?						
								 $menu_lateral=4;
								 include("../../../menus/menu_lateral.php");
							 ?>					 
						
					  </td>
                      <td width="73%" align="left" valign="top">  
					  
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                          <tr>
                            <td valign="top">
							
							
                        
						
						 <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top">
							
							<!-- INGRESO DE CONTENIDO NUEVO -->
							
							
							
							
							
							<?php 
	
	$institucion	=$_INSTIT;
	if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
     
	if ($frmModo == NULL){
	   $frmModo = "mostrar";
	}    
     

    

?>
<?php
	if($frmModo!="ingresar"){
			 $qry="SELECT * FROM SMS_CONFIG WHERE RDB=".$institucion." AND ESTADO=1";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}else{
			 $frmModo = "ingresar";	
			}
		}
	}
?>

	


    	<?php if($frmModo!="mostrar"){ ?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(document.getElementById("cant_sms").value=="" || !parseInt(document.getElementById("cant_sms").value)){
				alert("Ingrese cantidad mensajes asignados");
				return false;
				}
				else if(document.getElementById("fecha_hab").value==""){
				alert("Ingrese fecha habilitacion mensajes");
				return false;
				}
				else if(document.getElementById("fecha_cad").value==""){
				alert("Ingrese fecha caducidad mensajes");
				return false;
				}
				else{
				return true;
				}
			}
		</SCRIPT>
	<?php };?>

	
	<FORM method=post name="frm" action="procesoSMS.php">
	<INPUT TYPE="hidden" name=rdb value=<?php echo $institucion;?>>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center style="border-collapse:">
			<TR height=15>
				<TD valign="top">&nbsp;</TD>
			</TR>
            <TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX" TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" onClick=document.location="seteaSMS.php?caso=1">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
									
											
										<INPUT class="botonXX"TYPE="button" value="INGRESAR NUEVA BOLSA SMS" name=btnModificar  onClick=document.location="seteaSMS.php?caso=2">&nbsp;
											
								
									
								<?php };?>
								
							</TD>
						</TR
            >
            
		</TABLE>
        	<TABLE WIDTH=600 BORDER=1 CELLSPACING=0 CELLPADDING=0 align=center style="border-collapse:"><TR >
                    <TD  colspan=2 class="cuadro02" style="height:40px; border:2px solid #666" valign="middle">
                       CONFIGURACI&Oacute;N SMS
                    </TD>
                </TR>
             <TR>
              <TD colspan="2">&nbsp;</TD>
              
            </TR>
            <TR>
            <TD width="150" class="cuadro02">Cantidad Mensajes</TD>
              <TD width="444" class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												&nbsp;<input name="cant_sms" type="text" id="cant_sms">
											<?php };?>
											<font face="Arial, Helvetica, sans-serif" size="2">
											<?php 
												if($frmModo=="mostrar"){ 
													echo $fila['cantidad'];
												};
											?>
											</font>
											<?php if($frmModo=="modificar"){ ?>
											&nbsp;<input name="cant_sms" type="text" id="cant_sms" value="<?php echo $fila['cantidad'];?>">
												
												
											<?php };?></TD>
            </TR>
            <TR>
              <TD class="cuadro02">Fecha Habilitaci&oacute;n</TD>
              <TD class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												&nbsp;<input name="fecha_hab" type="text" id="fecha_hab" readonly>
											<?php };?>
											<font face="Arial, Helvetica, sans-serif" size="2">
											<?php 
												if($frmModo=="mostrar"){ 
													echo $fila['fecha_habilitacion'];
												};
											?>
											</font>
											<?php if($frmModo=="modificar"){ ?>
											&nbsp;<input name="fecha_hab" type="text" id="fecha_hab" value="<?php echo CambioFD($fila['fecha_habilitacion']);?>" readonly>
												
												
										  <?php };?></TD>
            </TR>
            <TR>
              <TD class="cuadro02">Fecha Caducidad</TD>
              <TD class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												&nbsp;<input name="fecha_cad" type="text" id="fecha_cad" readonly>
											<?php };?>
											<font face="Arial, Helvetica, sans-serif" size="2">
											<?php 
												if($frmModo=="mostrar"){ 
													echo $fila['fecha_caducidad'];
												};
											?>
											</font>
											<?php if($frmModo=="modificar"){ ?>
											&nbsp;<input name="fecha_cad" type="text" id="fecha_cad" value="<?php echo CambioFD($fila['fecha_caducidad']);?>" readonly>
												
												
										  <?php };?></TD>
            </TR>
            </TABLE>
	</FORM>
	<br>
<br>
<?php $sql_hist= "select * from sms_config where rdb=$institucion and estado=0 order by fecha_habilitacion desc";
$rs_hist = pg_exec($conn,$sql_hist);
?>
<?php if(pg_numrows($rs_hist)>0){
	
	?>
<table width="600" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="cuadro02">
    <td colspan="5" align="center">HISTORIAL CARGAS ANTERIORES</td>
    </tr>
  <tr class="cuadro02">
    <td align="center">#</td>
    <td align="center">FECHA HABILITACI&Oacute;N</td>
    <td align="center">FECHA CADUCIDAD</td>
    <td align="center">CARGA INICIAL</td>
    <td align="center">SALDO FINAL</td>
  </tr>
 <?php  for($r=0;$r<pg_numrows($rs_hist);$r++){
	 $fbol=pg_fetch_array($rs_hist,$r);
	 ?>
  <tr class="cuadro01">
    <td align="center"><?php echo $r+1 ?></td>
    <td align="center"><?php echo CambioFD($fbol['fecha_habilitacion']) ?></td>
    <td align="center"><?php echo CambioFD($fbol['fecha_caducidad']) ?></td>
    <td align="center"><?php echo number_format($fbol['cantidad'],0,',','.') ?></td>
    <td align="center"><?php echo number_format($fbol['saldo'],0,',','.') ?></td>
  </tr>
  <?php }?>
</table>
<?php }?>
	
	</td>
     </tr>
      </table>
	
	   <!-- FIN DE CONTENIDO NUEVO -->
	   
	   
							
							
							</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
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

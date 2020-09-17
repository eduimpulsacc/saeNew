<?php require('../../../../util/header.inc');?> 
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$periodo		=$_PERIODO;
	$_POSP = 4;
	$_bot = 1;
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
?>

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>	

	<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												$fila2 = @pg_fetch_array($result,0);	
												if (!$fila2){
													error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
													exit();
												}
												$nro_ano =  trim($fila2['nro_ano']);
											}
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

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtPER,'Ingresar nombre del periodo.')){
					return false;
				};
				if(!alfaOnly(form.txtPER,'Se permiten sólo caracteres alfanumericos para el nombre del periodo.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

			

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				
			

				//VALIDACION INTERVALO DE FECHAS
				/*if(amd(form.txtFECHAINI.value)>amd(form.txtFECHATER.value)){
					alert("Intervalo de fechas inválido.");
					return false;
				}*/


				return true;
			}
		</SCRIPT>

		
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">


<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>
<script>
$(document).ready(function() {
	
	
	
$( "#txtFECHAINI,#txtFECHATER" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	changeMonth: true,
	changeYear: true,
   	yearRange: "<?php echo $nro_ano ?>:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
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
		 
    }
	
});

//$.datepicker.regional['es']	


});

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
						 $menu_lateral=2;
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
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									
	<FORM method=post name="frm" action="procesoPeriodo.php3">
	
		<input type="hidden" name="ano" value="<?php echo $ano ?>">
        <input type="hidden" name="frmModo" value="ingresar">
      	<TABLE WIDTH=600 BORDER=0 align=center CELLPADDING=0 CELLSPACING=0>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong> </FONT> </TD>
							<TD>
                            
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
									<?php echo $nro_ano ?>
									</strong>	</FONT>			</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
                            
								
									<INPUT class="botonXX" TYPE="submit" value="GUARDAR"  name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX" TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarPeriodoQuiz.php">&nbsp;</TD>
						</TR>
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">
								PERIODO
								
								
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD class="cuadro02">
												<STRONG>NOMBRE</STRONG>										</TD>
										<TD class="cuadro02">
												<STRONG>FECHA INICIO</STRONG>										</TD>
										<TD class="cuadro02">
										  <STRONG>FECHA TERMINO</STRONG>										</TD>
										<TD class="cuadro02">POSICION NOTA</TD>
										</TR>
									<TR class="cuadro01">
										<TD class="cuadro01">
											
												<INPUT type="text" name=txtPER size=40 maxlength=50></TD>
										<TD class="cuadro01">
											
												<INPUT type="text" name=txtFECHAINI  id=txtFECHAINI size=10 maxlength=10 onChange="chkFecha(form.txtFECHAINI,'Fecha inicio invalida.');">
												</TD>
										<TD class="cuadro01">
										 
										  <INPUT type="text" name=txtFECHATER id=txtFECHATER size=10 maxlength=10 onChange="chkFecha(form.txtFECHATER,'Fecha termino invalida.');"></TD>
                                          
										<TD class="cuadro01"><INPUT type="text" name=txtPOSICION id=txtPOSICION size=10 maxlength=10 ></TD>
										</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
						
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD class="cuadro01">
											Las Fechas deben ser ingresadas con formato dd-mm-aaaa
										</TD>
									</TR>
								</TABLE>
								
							</TD>
						</TR>
						
					</TABLE>
				</TD>
			</TR>			
		</TABLE>
	</FORM>							
									
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
							  	   </td>
								 </tr>
							 </table>	
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
<? pg_close ($conn);?>
</body>
</html>

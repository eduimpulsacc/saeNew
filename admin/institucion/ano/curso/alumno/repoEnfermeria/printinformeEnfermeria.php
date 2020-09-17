<?php require('../../../../../../util/header.inc');
require('../../../../../clases/class_Reporte.php');
?>

<?php 
	$institucion	=$_INSTIT;
	$usuario		=$_USUARIO;
	$alumno			=$_ALUMNO;
	$_POSP          =6;
	$_bot           = 5;
	$ano            =$_ANO;
	
$ob_reporte = new Reporte();	
$ob_reporte->fecha_inicio = CambioFE($f_incio);
$ob_reporte->fecha_termino = CambioFE($f_fin);
$ob_reporte->ano = $ano;
$ob_reporte->alumno = $alumno;
$rs_atencion=$ob_reporte->EnfermeriaAlumno($conn);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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
<link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/themes/base/jquery.ui.all.css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery/print2.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
 <script>
$(function() {
$( "#f_incio,#f_fin" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
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
});


function detalleAtencion(id){
	//invocar carga listado
			$.ajax({
				url:"detalleAtencion.php",
				data:"id_atencion="+id,
				type:'POST',
				success:function(data){
					//console.log(data);
				 $(".print").html(data);
				$( "#detalle" ).dialog({
      modal: true,
	  width: 500,
	  height:400,
      buttons: {
	 "Imprimir": function(){
		 $( "#dialog_entr" ).dialog( "close" );
	     PrintElem('.print');
		 } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	} ,
	 create:function () {
        $(this).closest(".ui-dialog").find(".ui-button:first").addClass("printer");
    }
    });
		  }
		}); 
}

function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">

			function valida(){
				if($("#f_incio").val()=="" || $("#f_fin").val()==""){
					alert('Debe ingresar ambas fechas dentro del rango.');
					
				}
				
				else
				{
					$("#frm").submit();
				}
			}
		</SCRIPT>
</head>

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
                       <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- inicio codigo antiguo -->
								  
								  
								  

	<?php if (($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)&&($_PERFIL!=8)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
        <?
		include("../../../../../../cabecera/menu_inferiorinstitucion.php");
		?>
	  
	   </td>
  </tr>
</table>	
<?php } ?>
	<?php //echo tope("../../../../../../util/");?>
	<center>
		<table WIDTH="650" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
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
													echo trim($fila['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr> <?php if ($_PERFIL!=16){?>
				<td align=right>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="usuario.php3">
				</td>
				<?php }?>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle">ATENCIONES ENFERMERIA</td>
			</tr>
			<TR>
				<TD>
                <table width="100%" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
    <td width="25%" align="center">Fecha</td>
    <td width="25%" align="center">Periodo</td>
    <td width="25%" align="center">Hora Ingreso</td>
    <td width="25%" align="center">Hora Egreso</td>
    <td width="25%" align="center">Detalle</td>
  </tr>
 <?php  for($a=0;$a<pg_numrows($rs_atencion);$a++){
	 $fila_atencion = pg_fetch_array($rs_atencion,$a);
	 
	 $ob_reporte->fechaacc=$fila_atencion['fecha'];
	 $rs_prd = $ob_reporte->PeriodoFecha($conn);
	 
	 ?>
  <tr class="textosimple">
    <td align="center"><?php echo CambioFD($fila_atencion['fecha']); ?></td>
    <td align="center"><?php echo strtoupper(pg_result($rs_prd,1)); ?></td>
    <td align="center"><?php echo $fila_atencion['hora_ingreso']; ?></td>
    <td align="center"><?php echo $fila_atencion['hora_egreso']; ?></td>
    <td align="center"><img src="../../../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/search.png" width="16" height="16" alt="Detalle atenci&oacute;n" onClick="detalleAtencion(<?php echo $fila_atencion['id_enfermeria']; ?>)"></td>
  </tr>
  <?php  } ?>
</table>

                </TD>
				</TR>
			<tr>
				<td>
				<hr width="100%" color="#003b85"><br>
<br>
<div id="detalle" title="Detalle atención Enfermería">
 <div class="print"></div>
 </div>
				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- fin codigo antiguo -->
								  </td>
                                </tr>
                              </table>
                              
                              </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php");?> </td>
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
</body>
</html>

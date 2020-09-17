<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
//	echo $cmb_ense;
//	echo "<br/>";
//	echo $cmb_curso;
//	echo "<br/>";
//	echo $rut;
//	echo "<br/>";
//	echo $id_practica;
	
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->

<script language="javascript" type="text/javascript">
/*function actualiza(f1){
f1.action='procesaPracticas.php';
f1.submit(true);

}*/
</script>

<SCRIPT language="JavaScript" type="text/javascript">
/*function enviapag2(f1){
    f1.submit(true);		
}*/
function enviapag(){
	form.submit(true);
}


function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
//-->
</script>

<?php /*?>
<link rel="stylesheet" type="text/css" media="all" href="../util/jscalendar-1.0/skins/aqua/theme.css" title="Aqua" />
<link rel="alternate stylesheet" type="text/css" media="all" href="../util/jscalendar-1.0/calendar-blue.css" title="winter" />
<!-- import the calendar script -->
<script type="text/javascript" src="../util/jscalendar-1.0/calendar.js"></script>

<!-- import the language module -->
<script type="text/javascript" src="../util/jscalendar-1.0/lang/calendar-es.js"></script>

<script type="text/javascript">

var oldLink = null;
// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id !== "sel0" || cal.sel.id !== "sel3"))
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;  
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
</script><?php */?>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
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
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>>><? include("../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	
		 <?  if($id_practica==NULL){ ?>
         
		<FORM method="post" name="f1"  id="f1" action="procesaPracticas.php?caso=1">			<center>		 
		 <table width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="4"><div align="right">
  &nbsp;&nbsp;&nbsp;
  <input align="right" type="button" name="button" id="button" value="VOLVER" class="botonXX" onClick="window.location='listaPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">
 </div></td> <br/>
              </tr>
            
           <?
            	$sql= "select rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=$rut";
				$rs_alumno = pg_exec($conn,$sql);
		   		$fila = pg_fetch_array($rs_alumno,0);	
		   
		   
		   ?>
            <tr align="left">
              <td width="24%" class="tableindex">ALUMNO</td>
              <td colspan="3" class="tableindex">:
                <label>&nbsp;<?=ucfirst($fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat'])?></label></td>
              </tr>
            <tr>
              <td colspan="4" class="tablatit2-1">Datos Practica :</td>
              </tr>
			
            <tr align="left">
              <td colspan="4" class="cuadro01">&nbsp;</td>
              </tr>
             <tr align="center">
            
              <td colspan="2" class="cuadro01"><div align="left">Nombre Empresa</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td width="61%" align="left" class="cuadro01">
             <input type="text" name="txtnombreem" id="txtnombreem">             </td>
              </tr>
             <tr align="center">
               <td colspan="2" class="cuadro01"><div align="left">RUT Empresa</div></td>
               <td width="1%" class="cuadro01">:</td>
               <td width="61%" align="left" class="cuadro01">
               <input type="text" name="txtrutemp" id="txtrutemp" maxlength="10"> </td>
             </tr>
             <tr align="center">
               <td colspan="2" class="cuadro01"><div align="left">Telefono Empresa</div></td>
               <td width="1%" class="cuadro01">:</td>
               <td width="61%" align="left" class="cuadro01">
               <input type="text" name="txtfonoemp" id="txtfonoemp"> </td>
             </tr>
             <tr align="center">
               <td colspan="2" class="cuadro01"><div align="left">Encargado Alumno</div></td>
               <td width="1%" class="cuadro01">:</td>
               <td width="61%" align="left" class="cuadro01">
               <input type="text" name="txtencargado" id="txtencargado"> </td>
             </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Fecha Inicio</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
              <input type="text" name="txtinicio" id="txtinicio" maxlength="10"> (dd-mm-aaaa)             </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Fecha Termino</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
             <input type="text" name="txttermino" id="txttermino" maxlength="10">  (dd-mm-aaaa)               </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Cantidad de Horas</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
             <input type="text" name="txtcantidad" id="txtcantidad">             </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Monto de Pago</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td align="left" class="cuadro01">
             <input type="text" name="txtmonto" id="txtmonto">             </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01">&nbsp;</td>
              <td width="1%" class="cuadro01">&nbsp;</td>
              <td align="right" class="cuadro01"><label>
              
              <input type="hidden" name="rut" id="rut" value="<?=$rut;?>"/>
              <input type="hidden" name="cmb_curso" id="cmb_curso" value="<?=$cmb_curso?>"/>
              <input type="hidden" name="cmb_ense" id="cmb_ense" value="<?=$cmb_ense?>"/>
                                
              
                <input type="submit" name="guardar" id="guardar" value="Guardar" class="botonXX">
                          </label></td>
            </tr>
          </table>
		  </FORM>
          
          
          <?  }else{ ?>
          
         <FORM method="post" name="f2"  id="f2" action="procesaPracticas.php?caso=2">			<center>		 
		 <table width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="4"><div align="right">
  &nbsp;&nbsp;&nbsp;
  <input align="right" type="button" name="button" id="button" value="VOLVER" class="botonXX" onClick="window.location='listaPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'">
 </div></td> <br/>
              </tr>
            
           <?
            	$sql= "select rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat from alumno where rut_alumno=$rut";
				$rs_alumno = pg_exec($conn,$sql);
		   		$fila = pg_fetch_array($rs_alumno,0);	
		   
		   
		   ?>
            <tr align="left">
              <td width="24%" class="tableindex">ALUMNO</td>
              <td colspan="3" class="tableindex">:
                <label>&nbsp;<?=ucfirst($fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat'])?></label></td>
              </tr>
            <tr>
              <td colspan="4" class="tablatit2-1">Datos Practica :</td>
              </tr>
			
            <tr align="left">
              <td colspan="4" class="cuadro01">&nbsp;</td>
              </tr>
            <? 
					
					$sql="select * from practicas where id_practica=$id_practica";
					$rs_id = pg_exec($conn,$sql);
					$lista=pg_fetch_array($rs_id,0);	
					
					
				/////////////////////////////////////////////////
				$FECHAC1= $lista['fecha_ini'];
				$AA1 = substr ("$FECHAC1;", 0, -7); 
				$mm1 = substr ("$FECHAC1;", 5, -4);
				$dd1 = substr ("$FECHAC1;", 8, -1);
				$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
				$dia1 = $dia11["mday"];
				if($dia1<10){
					$dia1 = "0".$dia1;
				}else{
					$dia1;
					}
				$mes1 = $dia11["mon"];
				if($mes1<10){
					$mes1 = "0".$mes1;
				}else{
					$mes1;
				}
				$fecha_mes1 = $dia1."-".$mes1;
				$FECHAC1 = $fecha_mes1."-".$dia11["year"];
				////////////////////////////////////////////////	
				
				/////////////////////////////////////////////////
				$FECHAC2= $lista['fecha_ter'];
				$AA2 = substr ("$FECHAC2;", 0, -7); 
				$mm2 = substr ("$FECHAC2;", 5, -4);
				$dd2 = substr ("$FECHAC2;", 8, -1);
				$dia22 = getdate(mktime(0,0,0,$mm2,$dd2,$AA2));
				$dia2 = $dia22["mday"];
				if($dia2<10){
					$dia2 = "0".$dia2;
				}else{
					$dia2;
					}
				$mes2 = $dia22["mon"];
				if($mes2<10){
					$mes2 = "0".$mes2;
				}else{
					$mes2;
				}
				$fecha_mes2 = $dia2."-".$mes2;
				$FECHAC2 = $fecha_mes2."-".$dia22["year"];
				////////////////////////////////////////////////					
					
			?>
            <tr align="center">
            
              <td colspan="2" class="cuadro01"><div align="left">Nombre Empresa</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td width="61%" align="left" class="cuadro01">
             
            
              <input type="text" name="txtnombreem" id="txtnombreem" value="<?=$lista['nombre_emp']?>">                      </td>
              </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">RUT Empresa</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td width="61%" align="left" class="cuadro01">
              <input type="text" name="txtrutemp" id="txtrutemp" value="<?=$lista['rut_emp']?>"></td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Telefono Empresa</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td width="61%" align="left" class="cuadro01">
              <input type="text" name="txtfonoemp" id="txtfonoemp" value="<?=$lista['fono_emp']?>"></td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Encargado Alumno</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td width="61%" align="left" class="cuadro01">
              <input type="text" name="txtencargado" id="txtencargado" value="<?=$lista['encargado_alu']?>"></td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Fecha Inicio</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
                 
             
              <input type="text" name="txtinicio" id="txtinicio" value="<?=$FECHAC1?>">  (dd-mm-aaaa)               </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Fecha Termino</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
             
               
              <input type="text" name="txttermino" id="txttermino" value="<?=$FECHAC2?>"> (dd-mm-aaaa)                </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Cantidad de Horas</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td class="cuadro01" align="left">
             
              <input type="text" name="txtcantidad" id="txtcantidad" value="<?=$lista['cantidad_horas']?>">              </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01"><div align="left">Monto de Pago</div></td>
              <td width="1%" class="cuadro01">:</td>
              <td align="left" class="cuadro01">
             
             <input type="text" name="txtmonto" id="txtmonto" value="<?=$lista['monto_pago']?>">              </td>
            </tr>
            <tr align="center">
              <td colspan="2" class="cuadro01">&nbsp;</td>
              <td width="1%" class="cuadro01">&nbsp;</td>
              <td align="right" class="cuadro01"><label>
              <input type="hidden" name="rut" id="rut" value="<?=$rut;?>"/>
              <input type="hidden" name="id_practica" value="<?=$id_practica;?>"/>
              <input type="hidden" name="cmb_curso" id="cmb_curso" value="<?=$cmb_curso?>"/>
              <input type="hidden" name="cmb_ense" id="cmb_ense" value="<?=$cmb_ense?>"/>
             
       <input type="submit" name="actualizar" id="actualizar" value="Actualizar" class="botonXX">
            
             
              </label></td>
            </tr>
          </table>
		  </FORM>
           <? }?>
		  <!-- FIN CUERPO DE LA PAGINA -->								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
<? pg_close($conn);?>
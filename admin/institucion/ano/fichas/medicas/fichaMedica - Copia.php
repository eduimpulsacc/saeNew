<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	if($tipo_hoja!=1){
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	}else{
	/****************VARIABLES PARA HOJA DE VIDA****************/
	$ano			=$_GET['c_ano'];
	$alumno			=$_GET['c_alumno'];
	$c_curso		=$_GET['c_curso'];
	/**********************************/
	}
	$idFicha		=$_FICHAM;
	$_POSP          = 5;
	
?>
<?php 
    // TOMO LOS DATOS DE LA FICHA_MEDICA, GENERAL, QUE SIEMPRE DEBO MOSTRAR
	

 		$qry="SELECT * FROM FICHA_MEDICA WHERE RUT_ALUMNO=".$alumno." ORDER BY FECHA_ATENCION DESC";
		$result =@pg_Exec($conn,$qry);
		if (!$result){
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
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function esDigito(sChr){
var sCod = sChr.charCodeAt(0);
return ((sCod > 47) && (sCod < 58));
}

function valSep(oTxt){
var bOk = false;
bOk = bOk || ((oTxt.value.charAt(2) == "-") && (oTxt.value.charAt(5) == "-"));
bOk = bOk || ((oTxt.value.charAt(2) == "/") && (oTxt.value.charAt(5) == "/"));
return bOk;
}

function finMes(oTxt){
var nMes = parseInt(oTxt.value.substr(3, 2), 10);
var nRes = 0;
switch (nMes){
case 1: nRes = 31; break;
case 2: nRes = 29; break;
case 3: nRes = 31; break;
case 4: nRes = 30; break;
case 5: nRes = 31; break;
case 6: nRes = 30; break;
case 7: nRes = 31; break;
case 8: nRes = 31; break;
case 9: nRes = 30; break;
case 10: nRes = 31; break;
case 11: nRes = 30; break;
case 12: nRes = 31; break;
}
return nRes;
}

function valDia(oTxt){
var bOk = false;
var nDia = parseInt(oTxt.value.substr(0, 2), 10);
bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt)));
return bOk;
}

function valMes(oTxt){
var bOk = false;
var nMes = parseInt(oTxt.value.substr(3, 2), 10);
bOk = bOk || ((nMes >= 1) && (nMes <= 12));
return bOk;
}

function valAno(oTxt){
var bOk = true;
var nAno = oTxt.value.substr(6);
bOk = bOk && ((nAno.length == 2) || (nAno.length == 4));
if (bOk){
for (var i = 0; i < nAno.length; i++){
bOk = bOk && esDigito(nAno.charAt(i));
}
}
return bOk;
}

function valFecha(oTxt){
var bOk = true;
if (oTxt.value != " 	"){
bOk = bOk && (valAno(oTxt));
bOk = bOk && (valMes(oTxt));
bOk = bOk && (valDia(oTxt));
bOk = bOk && (valSep(oTxt));
if (!bOk){
alert("Fecha inv·lida");
oTxt.value = "";
oTxt.focus();
}
}
}

//-->
</script>
								<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
<!--
function valida(form){
		if(!chkVacio(form.fechacontrol,'Ingresar FECHA ATENCION.')){
			return false;
		};
		
				
		if (form.observaciones.value==0){
		   alert('Debe ingresar OBSERVACIONES');
		   return false;
		}   
		

		return true;
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
/*function validarSiNumero(numero){
	if (!/^([0-9])*$/.test(numero)){	
		alert("Formato de Fecha no Valido");	
		return;
	}
}*/
function fechas(caja)
{ 
  

   if (caja)
   {  
      borrar = caja;
       
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr($i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = ''; // AÒo no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '';
		 
	  if (borrar == '')
	     alert('Fecha erronea');
  
   
   }  // if (caja)   
   
    
} // FUNCION

function CheckTime(str)
{
hora=str.value;
	/*if (hora.length<5) {
		alert("Introdujo una cadena menor a 5 caracteres");
		return;
	}*/

a=hora.charAt(0); //<=2
b=hora.charAt(1); //<4
c=hora.charAt(2); //:
d=hora.charAt(3); //<=5
e=hora.charAt(4); //: 

	if(c!=':'){
		alert('Formato de Hora no Valido');
		document.frm.horacontrol.focus();
		//return;
	}
	if (!/^([0-9])*$/.test(hora.substring(3,5))){	
		alert('Formato de Hora no Valido');
		document.frm.horacontrol.focus();
	}
	
	if (!/^([0-9])*$/.test(hora.substring(0,2))){	
		alert('Formato de Hora no Valido');
		document.frm.horacontrol.focus();
	}
	
	if(hora.substring(0,2)>24){
		alert('Formato de Hora no Valido');
		document.frm.horacontrol.focus();
	}
	
	if(hora.substring(3,5)>59){
		alert('Formato de Hora no Valido');
		document.frm.horacontrol.focus();
	}
}


</SCRIPT>
	
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.Estilo3 {font-family: Arial, Helvetica, sans-serif; font-size: -2; }
.Estilo4 {font-size: -2}
-->
</style>
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
             <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? 
						$menu_lateral = "3_1";
						include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo nuevo -->
								  
								  
	<? if($tipo_hoja!=1){?>								  
	<FORM method=post name="frm" action="ing_fichamedica.php">
	<? }else{?>
	<FORM method=post name="frm" action="ing_fichamedica.php?tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$ano?>&c_curso=<?=$c_curso?>&c_alumno=<?=$alumno?>">
	<? }?>
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 >
			<tr>
			  <td align="right"><input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('pfichaMedica.php?c_curso=<?=$c_curso?>&c_alumno=<?=$alumno ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR"></td>
			</tr>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>A—O</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
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
													echo trim($fila1['nro_ano']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD><br />
				  <table width="100%" border="0" cellpadding="3" cellspacing="0">
                    <tr>
                      <td colspan="2" class="tableindex">Registro de Salud del alumno </td>
                    </tr>
                    <tr>
                      <td width="30%" valign="top" class="cuadro02">
					  <?
					  if ($frmModo == "mostrar"){
					     // TOMO LOS DATOS DE LA TABLA FICHA_MEDICANEW PARA SOLO MOSTRAR
						 $q1 = "select * from ficha_medicanew where id_ficha = '$_FICHAM'";
						 $r1 = pg_Exec($conn,$q1);
						 $n1 = pg_numrows($r1);
						 if ($n1 == 0){
						     echo "Error, Ficha medica no existe";
							 exit();
						 }else{
						     $f1 = pg_fetch_array($r1,0);
							 $fecha = $f1['fecha'];
							 $observaciones = $f1['observaciones'];
							 $dd = substr($fecha,8,2);
							 $mm = substr($fecha,5,2);
							 $aa = substr($fecha,0,4);
							 $fecha = "$dd-$mm-$aa";
							 				  
					     }
					  }
					  ?>
					  <strong>Fecha</strong></td>
                      <td valign="bottom" class="cuadro01"><label>
                        <input  name="fechacontrol" type="text" id="fechacontrol" onBlur="valFecha(this)" value="<?=$fecha ?>" size="10" maxlength="10">
                      dd-mm-aaaa</label></td>
                    </tr>
					<tr>
						<td valign="top" class="cuadro02">
							<strong>Hora</strong>
						</td>
						<td valign="bottom" class="cuadro01">
						  <label>
							<input name="horacontrol" type="text" id="horacontrol" size="5" maxlength="5" value="<?=$f1['hora']; ?>" onBlur="CheckTime(this)">
						  hh:mm</label>
					  	</td>
					</tr>
                    <tr>
                      <td valign="top" class="cuadro02"><strong>Observaciones</strong></td>
                      <td class="cuadro01"><label>
                        <textarea name="observaciones" cols="40" rows="5"><?=$observaciones ?></textarea>
                      </label></td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="center">
					   <?
					   if ($frmModo != "mostrar"){
					       ?>
                           <label>
                           <input type="submit" name="Submit" value="GUARDAR" class="BotonXX" onClick="return valida(this.form);" />
                           </label>
						   <?
					   }	   
                        
						?>
						<label>
                        <input name="Submit2" type="button" class="BotonXX" onClick="MM_callJS('history.go(-2)')" value="Volver"/>
                        </label>
                        <br />
                        <br />
                        <br /><br>

                      </div></td>
                    </tr>
                    <tr>
                      <td colspan="2" class="tableindex">INFORMACION GENERAL </td>
                    </tr>
                    <tr>
                      <td colspan="2"><div align="center">
                        <TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
										      <TR>
										        <TD align=left height=10>
										          <FONT face="arial, geneva, helvetica" size=1 color=#000000>
										            <STRONG>&nbsp;&nbsp;OFTALMOLOGIA</STRONG>
									              </FONT>
									            </TD>
											  </TR>
										      <TR>
										        <TD>
										          <TABLE width=100% height=100% bgcolor=White BORDER=0>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                     
															    <?
															                $chk1 =$fila['of_alta'];
																			
																			if ($chk1 == 1){
																			    ?><INPUT TYPE="checkbox" NAME="chk1" checked="checked"><?
																		    }else{		
																				?><INPUT TYPE="checkbox" NAME="chk1"><?
																			} 	
										                           
															  
															                      
															  ?>
															  
															           
																																							  </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ALTA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			  <?
																			  $chk2 = $fila['of_en_estudio'];
																			  if ($chk2 == 1){
																			  	  ?>																		   
																			       <INPUT TYPE="checkbox" NAME="chk2" checked="checked">
																			      <?
																			  }else{
																			       ?>																		   
																			       <INPUT TYPE="checkbox" NAME="chk2">
																			      <?
																			  }
																			  ?>											
																				
																				
																				
																																		    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>EN ESTUDIO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			  <?
																			    $chk3 = $fila['of_hipermetropia'];
																			    if ($chk3 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk3" checked="checked">
																			       <?
																				}else{   
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk3">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>HIPERMETROPIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
															   <?
															   $chk4 = $fila['of_miopia'];
															   if ($chk4 == 1){
															       ?>
										                           <INPUT TYPE="checkbox" NAME="chk4" checked="checked">
										                           <?
															   }else{
															       ?>
										                           <INPUT TYPE="checkbox" NAME="chk4">
										                           <?
															   }
															   ?>
															   </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>MIOPIA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk5 = $fila['of_astigmatismo_miope'];
																				if ($chk5 == 1){
																				   ?>
																			       <INPUT TYPE="checkbox" NAME="chk5" checked="checked">
																			       <?
																				}else{
																				   ?>
																			       <INPUT TYPE="checkbox" NAME="chk5">
																			       <?
																				}
																				?>   
																				
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ASTIGMATISMO MIOPE</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk6 = $fila['of_astigmatismo_hipermetrope'];
																				if ($chk6 == 1){
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk6" checked="checked">
																			        <?
																				}else{
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk6">
																			        <?
																			    }			
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ASTIGMATISMO HIPERMETROPE</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
															  <?
															  $chk7 = $fila['of_astigmatismo_mixto'];
															  if ($chk7 == 1){
															      ?>
															      <INPUT TYPE="checkbox" NAME="chk7" checked="checked">
										                          <?
														      }else{
															      ?>
															      <INPUT TYPE="checkbox" NAME="chk7">
										                          <?
															  }	  
															  ?> </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ASTIGMATISMO MIXTO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk8 = $fila['of_astigmatismo_miopito_comp'];
																				if ($chk8 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk8" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk8">
																			       <?
																				}   
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ASTIGMATISMO MIOPITO COMP</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    
																			    <?
																				$chk9 = $fila['of_astigmatismo_hipermetria_c'];
																				if ($chk9 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk9" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk9">
																			       <?
																				}   
																				?>
																			    
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ASTIGMATISMO HIPERMETRIA COMP</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk10 = $fila['of_anisometropia'];
															  if ($chk10 == 1){
															     ?>
																 <INPUT TYPE="checkbox" NAME="chk10" checked="checked">
										                         <?
															  }else{
															     ?>
																 <INPUT TYPE="checkbox" NAME="chk10">
										                         <?
															  }	 
															  ?>									                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ANISOMETROPIA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk11 = $fila['of_estrabismo'];
																				if ($chk11 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk11" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk11">
																			       <?
																				}    
																				?>
																			    														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ESTRABISMO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk12 = $fila['of_influencia_convergencia'];
																				if ($chk12 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk12" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk12">
																			       <?
																				}   
																				?>   
																				  														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>INFLUENCIA CONVENGENCIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2 height="86"></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
																	   
																	<INPUT TYPE="text" NAME="of_otros_desc" size=50 value="<?php echo $fila['of_otros_desc']?>">
																			    
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%" align=center>
										                <HR width="80%" color=black><BR>
										                <FONT face="arial, geneva, helvetica" size=2>
										                  <strong>INDICACIONES</strong>
									                    </FONT>
									                  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk14 = $fila['of_lentes_primera_vez'];
															  if ($chk14 == 1){
															     ?>
															     <INPUT TYPE="checkbox"  NAME="chk14" checked="checked">
										                         <?
															  }else{
															     ?>
															     <INPUT TYPE="checkbox"  NAME="chk14">
										                         <?
															  }	 	 
															  ?>
										                      								                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>LENTES PRIMERA VEZ</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk15 = $fila['of_cambiar_lentes'];
																				if ($chk15 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk15" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk15">
																			       <?
																				}   
																				?>
																				
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CAMBIAR LENTES</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk16 = $fila['of_mantener_lentes'];
																				if ($chk16 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk16" checked="checked">
																			       <?
																				}else{   
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk16">
																			       <?
																				}
																				?>    
																				   
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>MANTENER LENTES</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk17 = $fila['of_estudio_estrabismo'];
															  if ($chk17 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk17" checked="checked">
                                                                 <?
															  }else{
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk17">
                                                                 <?
														      }		 
															  ?>     </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ESTUDIO ESTRABISMO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk18 = $fila['of_ejercicios_opticos'];
																				if ($chk18 == 1){
																				   ?>
																			       <INPUT TYPE="checkbox" NAME="chk18" checked="checked">
																			       <?
																				}else{
																				   ?>
																			       <INPUT TYPE="checkbox" NAME="chk18">
																			       <?
																				}
																				?>   
																				
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>EJERCICIOS OPTICOS</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk19 = $fila['of_cirugia'];
																				if ($chk19 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk19" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk19">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CIRUGIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
														<INPUT TYPE="text" NAME="of_otros_desc_indic" size=50 value="<?php echo $fila['of_otros_desc_indic']?>">
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
									              </TABLE>
											    </TD>
											  </TR>
				        </TABLE>
						
						<br /><br />
						
						
						
						<TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
										      <TR>
										        <TD align=left height=10>
										          <FONT face="arial, geneva, helvetica" size=1 color=#000000>
										            <STRONG>&nbsp;&nbsp;OTORRINO</STRONG>
									              </FONT>
									            </TD>
											  </TR>
										      <TR>
										        <TD>
										          <TABLE width=100% height=100% bgcolor=White BORDER=0>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk21 = $fila['ot_alta'];
															  if ($chk21 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk21" checked="checked">
										                         <?
															  }else{
															  	 ?>
															     <INPUT TYPE="checkbox" NAME="chk21">
										                         <?
														      }
															  ?>
															    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ALTA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk22 = $fila['ot_en_estudio'];
																				if ($chk22 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk22" checked="checked">
																			       <?
																				}else{
																				    ?>
																				   <INPUT TYPE="checkbox" NAME="chk22">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>EN ESTUDIO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk23 = $fila['ot_agenesia_pabellon'];
																				if ($chk23 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk23" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk23">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>AGENESIA PABELLON</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk24 = $fila['ot_cerumen_impactado'];
															  if ($chk24 == 1){
															      ?>
															      <INPUT TYPE="checkbox" NAME="chk24" checked="checked">
										                          <?
															  }else{
															      ?>
															      <INPUT TYPE="checkbox" NAME="chk24">
										                          <?
															  }
															  
															  ?>
									                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CERUMEN IMPACTADO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk25 = $fila['ot_mucosis_timpanica'];
																				if ($chk25 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk25" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk25">
																			       <?
																				}
																				?>
																				
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>MUCOSIS TIMPANICA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk26 = $fila['ot_hipoacusia_neurosensorial'];
																				if ($chk26 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk26" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk26">
																			       <?
																				}
																				?>   
																				  
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>HIPOACUSIA NEUROSENSORIAL</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
																 <INPUT TYPE="text" NAME="ot_otros_desc" size=50 value="<?php echo $fila['ot_otros_desc']?>">
																		</TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            
										            <TR>
										              <TD width="100%" align=center>
										                <HR width="80%" color=black><BR>
										                <FONT face="arial, geneva, helvetica" size=2>
										                  <strong>INDICACIONES</strong>
									                    </FONT>
									                  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk28 = $fila['ot_audiometria'];
															  if ($chk28 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk28" checked="checked">
										                         <?
															  }else{
															  	 ?>
															     <INPUT TYPE="checkbox" NAME="chk28">
										                         <?
														      }		 
															  ?>        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>AUDIOMETRIA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk29 = $fila['ot_impedanciometria'];
																				if ($chk29 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk29" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk29">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>IMPEDANCIOMETRIA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk30 = $fila['ot_radiografia'];
																				if ($chk30 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk30" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk30">
																			       <?
																				}
																				?>   
																				   
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>RADIOGRAFIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk31 = $fila['ot_medicamento'];
															  if ($chk31 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk31" checked="checked">
										                         <?
														      }else{
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk31">
										                         <?
														      }		 
															  ?>         </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>MEDICAMENTO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk32 = $fila['ot_audifono'];
																				if ($chk32 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk32" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk32">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>AUDIFONO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk33 = $fila['ot_cirugia'];
																				if ($chk33 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk33" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk33">
																			       <?
																				}
																				?>
																				  
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CIRUGIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
													<INPUT TYPE="text" NAME="ot_otros_desc_indic" size=50 value="<?php echo $fila['ot_otros_desc_indic']?>">
													
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
									              </TABLE>
											    </TD>
											  </TR>
				        </TABLE>
						
						
						
						<br />
                        <br />
						
						
						<TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
										      <TR>
										        <TD align=left height=10>
										          <FONT face="arial, geneva, helvetica" size=1 color=#000000>
										            <STRONG>&nbsp;&nbsp;ORTOPEDIA</STRONG></FONT>
									            </TD>
											  </TR>
										      <TR>
										        <TD>
										          <TABLE width=100% height=100% bgcolor=White BORDER=0>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk35 = $fila['or_alta'];
															  if ($chk35 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk35" checked="checked">
										                         <?
															  }else{
															  	 ?>
															     <INPUT TYPE="checkbox" NAME="chk35">
										                         <?
															  }
															  ?>
															  
															              </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ALTA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk36 = $fila['or_en_estudio'];
																				if ($chk36 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk36" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk36">
																			       <?
																				}   
																				?>   
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>EN ESTUDIO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk37 = $fila['or_pie_plano'];
																				if ($chk37 == 1){
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk37" checked="checked">
																			        <?
																				}else{
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk37">
																			        <?
																			    }		
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>PIE PLANO</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk38 = $fila['or_genu_valgo_varo'];
															  if ($chk38 == 1){
															     ?>
															     <INPUT TYPE="checkbox" NAME="chk38" checked="checked">
										                         <?
															  }else{
															  	 ?>
															     <INPUT TYPE="checkbox" NAME="chk38">
										                         <?
															  }	 
															  ?>
									                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>GENU VALGO/VARO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk39 = $fila['or_deform_adquir_dedos'];
																				if ($chk39 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk39" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk39">
																			       <?
																				}    
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>DEFORM. ADQUIR. DEDOS</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk40 = $fila['or_escoliosis'];
																				if ($chk40 == 1){
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk40" checked="checked">
																			        <?
																				}else{
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk40">
																			        <?
																			     }
																				 ?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>ESCOLIOSIS</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
															 <INPUT TYPE="text" NAME="or_otros_desc" size=50 value="<?php echo $fila['or_otros_desc']?>">
															  </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%" align=center>
										                <HR width="80%" color=black><BR>
										                <FONT face="arial, geneva, helvetica" size=2>
										                  <strong>INDICACIONES</strong>
									                    </FONT>
									                  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk42 = $fila['or_cambiar_plantillas'];
															  if ($chk42 == 1){
															     ?>
																 <INPUT TYPE="checkbox" NAME="chk42" checked="checked">
										                         <?
															  }else{
															  	 ?>
																 <INPUT TYPE="checkbox" NAME="chk42">
										                         <?
														      }
															  ?>		 
																 
																        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CAMBIAR PLANTILLAS</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk43 = $fila['or_mantener_plantillas'];
																				if ($chk43 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk43" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk43">
																			       <?
																				}
																				?>   
																				   														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>MANTENER PLANTILLAS</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk44 = $fila['or_kinesiterapia'];
																				if ($chk44 == 1){
																				   ?>
																				    <INPUT TYPE="checkbox" NAME="chk44" checked="checked">
																			       <?
																				}else{   
																				   ?>
																				    <INPUT TYPE="checkbox" NAME="chk44">
																			       <?
																				}
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>KINESIOTERAPIA</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk45 = $fila['or_rx_extrem_inferiores'];
															  if ($chk45 == 1){
															     ?>
																 <INPUT TYPE="checkbox" NAME="chk45" checked="checked">
										                         <?
														      }else{
															     ?>
																 <INPUT TYPE="checkbox" NAME="chk45">
										                         <?
															  }
															  ?>									                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>RX EXTREM. INFERIORES</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk46 = $fila['or_rx_columna'];
																				if ($chk46 == 1){
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk46" checked="checked">
																			       <?
																				}else{
																				   ?>
																				   <INPUT TYPE="checkbox" NAME="chk46">
																			       <?
																				}   
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>RX COLUMNA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD width=20></TD>
																			  <TD width=2>
																			    <?
																				$chk47 = $fila['or_corse'];
																				if ($chk47 == 1){
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk47" checked="checked">
																			        <?
																				}else{
																				    ?>
																				    <INPUT TYPE="checkbox" NAME="chk47">
																			        <?
																			    }		 	
																				?>
														    </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CORSE</STRONG>
																		        </FONT>
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2>
										                      <?
															  $chk48 = $fila['or_cirugia'];
															  if ($chk48 == 1){
															     ?>
																  <INPUT TYPE="checkbox" NAME="chk48" checked="checked">
										                         <?
														      }else{		 
																 ?>
																  <INPUT TYPE="checkbox" NAME="chk48">
										                         <?
														      }
															  
															  ?>									                        </TD>
																			  <TD width="33%">
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>CIRUGIA</STRONG>
																		        </FONT>
														    </TD>
																			  <TD colspan=5></TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
										            <TR>
										              <TD width="100%">
										                <TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
										                  <TR>
										                    <TD width=2></TD>
																			  <TD width="33%" align=right>
																			    <FONT face="arial, geneva, helvetica" size=1 color=#000000>
																			      <STRONG>OTRO</STRONG>
																		        </FONT>
														    </TD>
																			  <TD COLSPAN=5 align=left>
												 <INPUT TYPE="text" NAME="or_otros_desc_indic" size=50 value="<?php echo $fila['or_otros_desc_indic']?>">
																			    
														    </TD>
														  </TR>
									                    </TABLE>
													  </TD>
												    </TR>
									              </TABLE>
											    </TD>
											  </TR>
				        </TABLE>
                        <br />
                        <br />
                        <table width="100%" bgcolor="#cccccc" border="0" cellpadding="1" cellspacing="0">
                          <tr>
                            <td align="left" height="10"><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong>&nbsp;&nbsp;</strong></font></td>
                          </tr>
                          <tr>
                            <td><table width="100%" height="100%" bgcolor="White" border="0">
                                <tr>
                                  <td width="100%"><div align="center">
								  
								  <TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
				        <TR>
				          <TD align="justify">
				            <FONT face="arial, geneva, helvetica" size=1 color=#000000>
				              <STRONG>ACCIDENTES</STRONG>			                </FONT>			              </TD>
					    </TR>
				        <TR>
				          <TD align="center">
				            <textarea name="txtACCIDENTE" cols="60" rows="3"> <?php echo ($fila['accidentes'])?></textarea>
				            </TD>
					    </TR>
			          </TABLE>
								  
								  
								  </div></td>
                                </tr>
                                <tr>
                                  <td width="100%"><div align="center">
								  
								  <TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
				        <TR>
				          <TD >
				            <FONT face="arial, geneva, helvetica" size=1 color=#000000>
				              <STRONG>ALERGIAS</STRONG>			                </FONT>			              </TD>
					    </TR>
				        <TR>
				          <TD align="center">
				          <textarea name="txtALERGIA" cols="60" rows="3"> <?php echo ($fila['alergias'])?></textarea>
				          </TD>
					    </TR>
			          </TABLE>
								  
								  
								  </div></td>
                                </tr>
                                <tr>
                                  <td width="100%"><div align="center">
								  
								  <TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
				        <TR>
				          <TD>
				            <FONT face="arial, geneva, helvetica" size=1 color=#000000>
				              <STRONG>MEDICAMENTOS</STRONG>			                </FONT>			              </TD>
					    </TR>
				        <TR>
				          <TD align="center">
				   <textarea name="txtMEDICAMENTO" cols="60" rows="3"> <?php echo ($fila['medicamentos'])?></textarea>
				          </TD>
					    </TR>
			          </TABLE>
								  
								  
								  </div></td>
                                </tr>
                                
                            </table></td>
                          </tr>
                        </table>
                        <br />
                        <br />
                        
						
						
						<TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
				        <tr>
				          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>GRUPO SANGUINEO</strong></font></td>
					    </tr>
				        <tr>
				          <td>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				              <tr>
				                <td>									
				                  
				                  
				                  
				                  <table width="100%" bgcolor="#FFFFFF">
				                    <tr>
				                      <td width="30" bgcolor="#FFFFFF" height="30" align="center">
									   <input type="radio" name="GrupoSangre" value="1" <? if($fila['grupo_sanguineo']==1){?> checked<? }?>></td>
                                      <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(-)</font></td>
                                      <td width="30" bgcolor="#FFFFFF" align="center">
									  <input type="radio" name="GrupoSangre" value="2" <? if($fila['grupo_sanguineo']==2){?>checked<? }?>></td>
                                      <td width="230" bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">RH(+)</font></td>
								    </tr>
				                    <tr>
				                      <td bgcolor="#FFFFFF" height="30" align="center">
									  <input type="radio" name="GrupoSangre" value="3" <? if($fila['grupo_sanguineo']==3){?>checked<? }?>></td>
                                      <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">AB(I)</font></td>
                                      <td bgcolor="#FFFFFF" align="center">
									  <input type="radio" name="GrupoSangre" value="4" <? if($fila['grupo_sanguineo']==4){?>checked<? }?>></td>
                                      <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">A(II)</font></td>
                                    </tr>
				                    <tr>
				                      <td bgcolor="#FFFFFF" height="30" align="center">
									  <input type="radio" name="GrupoSangre" value="5" <? if($fila['grupo_sanguineo']==5){?>checked<? }?>></td>
                                      <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">B(III)</font></td>
                                      <td bgcolor="#FFFFFF" align="center">
									  <input type="radio" name="GrupoSangre" value="6" <? if($fila['grupo_sanguineo']==6){?>checked<? }?>></td>
                                      <td bgcolor="#FFFFFF"><font face="Arial, Helvetica, sans-serif" size="-2">0(IV)</font></td>
                                    </tr>
			                      </table>
								  
								  
								  
								  
								  
			                    </td>
						      </tr>
			                </table>								
						  </td>
					    </tr>								
			          </table>
						<br />
						<br />
                        <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
				        <tr>
				          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>PROBLEMAS ESPECÔFICOS DE SALUD DEL ALUMNO</strong></font></td>
					    </tr>
				        <tr>
				          <td>
				            <? //echo $fila['problema_especifico1'];?>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
				              <tr>
				                <td width="30" height="30"  align="center">
								 <input type="checkbox" name="problema_especifico1" <? if($fila['problema_especifico1']==1){?> checked <? }?>></td>
									  <td width="290"><font face="Arial, Helvetica, sans-serif" size="-2">DIABETES</font></td>
									  <td width="30" align="center">
									  <input type="checkbox" name="problema_especifico2" <? if($fila['problema_especifico2']==1){?> checked <? }?>></td>
									  <td width="290"><font face="Arial, Helvetica, sans-serif" size="-2">PROBLEMAS DE COAGULACÕON</font></td>
						      </tr>
				              <tr>
				                <td height="30" align="center">
								      <input type="checkbox" name="problema_especifico3" <? if($fila['problema_especifico3']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">EPILEPSIA</font></td>
									  <td align="center">
									  <input type="checkbox" name="problema_especifico4" <? if($fila['problema_especifico4']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">CRISIS ASM¡TICAS</font></td>
						      </tr>
				              <tr>
				                <td height="30" align="center">
								      <input type="checkbox" name="problema_especifico5" <? if($fila['problema_especifico5']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">CRISIS CONVULSIVAS</font></td>
									  <td align="center">
									  <input type="checkbox" name="problema_especifico6" <? if($fila['problema_especifico6']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">ASMA</font></td>
						      </tr>
				              <tr>
				                <td height="30" align="center">
								      <input type="checkbox" name="problema_especifico7" <? if($fila['problema_especifico7']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">SANGRAMIENTO NASAL FRECUENTE</font></td>
									  <td align="center">
									  <input type="checkbox" name="problema_especifico8" <? if($fila['problema_especifico8']==1){?> checked <? }?>></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="-2">REACCI”N AL…RGICA A PICADURA DE INSECTOS</font></td>
						      </tr>
				              <tr>
				                <td height="48" colspan="4" align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
				                  <tr>
				                    <td width="270" height="55" align="center"><font face="Arial, Helvetica, sans-serif" size="-2">OTROS</font></td>
                                          <td width="330" align="left"><font face="Arial, Helvetica, sans-serif" size="-2">
                                      <input type=text NAME="problema_especifico_otros" size=50 value = "<? echo strtoupper($fila['problema_especifico_otros'])?>">
                                         </font></td>
                                  </tr>
				                  <tr>
				                    <td height="55" colspan="2" align="center">
								<!-- modificacion ficha -->	
								<TABLE width=100% bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
				        <tr>
				          <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>TRATAMIENTO CON ESPECIALISTA</strong></font></td>
					    </tr>
				        <tr>
				          <td>
				            <table width="100%" border="0" cellspacing="0" cellpadding="0">
				              <tr>
				                <td><table width="100%" border="0" cellpadding="3" cellspacing="3" bgcolor="#FFFFFF">
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">NEUROLOG&Iacute;A</font></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo3">
                                      <label>                                      </label>
                                    </span>                                      <span class="Estilo4">
                                    <label></label>
                                    </span>                                    <label><div align="center" class="Estilo3">
                                        <textarea name="te_neu" cols="60" rows="3" id="te_neu"><?php echo ($fila['te_neu'])?></textarea>
                                        </div>
                                    </label></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">PSICOPEDAGOG&Iacute;A</font></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center" class="Estilo3">
                                      <textarea name="te_psig" cols="60" rows="3" id="te_psig"><?php echo ($fila['te_psig'])?></textarea>
                                    </div></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">PSICOLOG&Iacute;A</font></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center" class="Estilo3">
                                      <textarea name="te_psi" cols="60" rows="3" id="te_psi"><?php echo ($fila['te_psi'])?></textarea>
                                    </div></td>
                                  </tr>
                                 
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">FONOAUDIOLOG&Iacute;A</font></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center" class="Estilo3">
                                      <textarea name="te_fono" cols="60" rows="3" id="te_fono"><?php echo ($fila['te_fono'])?></textarea>
                                    </div></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">OTROS</font></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center" class="Estilo3">
                                      <textarea name="te_otr" cols="60" rows="3" id="te_otr"><?php echo ($fila['te_otr'])?></textarea>
                                    </div></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><font face="Arial, Helvetica, sans-serif" size="-2">SEGURO CL&Iacute;NICA </font></td>
                                  </tr>
                                  <tr>
                                    <td><div align="center">
                                      <textarea name="te_se_cli" cols="60" rows="3" id="te_se_cli"><?php echo ($fila['te_se_cli'])?></textarea>
                                    </div></td>
                                  </tr>
                                  
                                </table></td>
				              </tr>
			                </table>								
						  </td>
					    </tr>								
			          </table>	
									
								<!-- fin modificacion ficha -->	
									<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
				                      <tr>
				                        <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SEGURO CLINICA</strong></font></td>
                                      </tr>
				                      <tr>
				                        <td align="center">
				                          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
				                            <tr>
				                              <td height="23"><font face="Arial, Helvetica, sans-serif" size="-2">
				                                <input type=radio value=1 name=tipo_seguro onClick="layerCLINICA.style.visibility='hidden';nro=1" <? if($fila['tipo_seguro']==1){?> checked <? }?>>
				                                </font></td>
                                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><FONT face="arial, geneva, helvetica" size=2 color=black><strong>ESTATAL</strong></FONT></font></td>
                                                    <td colspan="2" rowspan="2" valign="top">
                                                      <div id="layerCLINICA" style="visibility: visible">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                                          <tr>
                                                            <td height="23"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRE CL&Iacute;NICA</strong></font></td>
                                                        <td><input name="clinica" type="text" id="clinica3" size="50" maxlength="100" value="<? echo trim(strtoupper($fila['clinica']))?>">
                                                          
                                                          </tr>
                                                          <tr>
                                                            <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>FONO CLINICA</strong></font></td>
                                                        <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>
                                                          
                                                          <input name="fono_clinica" type="text" id="fono_clinica4" maxlength="10" value="<? echo trim(strtoupper($fila['fono_clinica']))?>">
                                                          
                                                          </strong></font></td>
                                                      </tr>
                                                        </table>
												    </div>
												    </td>
                                            </tr>
				                            <tr>
				                              <td><font face="Arial, Helvetica, sans-serif" size="-2">
				                               <input type=radio value=2 name=tipo_seguro onClick="layerCLINICA.style.visibility='visible';nro=1" <? if($fila['tipo_seguro']==2){?> checked <? }?>>
				                                </font></td>
                                                    <td><font face="Arial, Helvetica, sans-serif" size="-2"><FONT face="arial, geneva, helvetica" size=2 color=black><strong>PRIVADO</strong></FONT></font></td>
                                            </tr>
  <tr><td>&nbsp;</td></tr>
			                              </table></td>
                                      </tr>
				                      
  <!-- aki --> 
				                      <tr>
				                        <!--                                <td height="55" colspan="2" align="center"> -->
				                        <td>
				                          <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
				                            <tr>
				                              <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>ISAPRE</strong></font></td>
                                            </tr>
				                            <tr>
				                              <td align="center">
  <!--                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                                                <tr>
                                                  <td colspan="2" rowspan="2" valign="top">
-->												  <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
    <tr>
      <td height="23"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>NOMBRE</strong></font></td>
                                                        <td>
								<input name="isapre" type="text" id="isapre1" size="50" maxlength="100" value="<? echo trim(strtoupper($fila['isapre']))?>">
                                                          
                                              </tr>
    </table>
									    
											  </td>
                                            </tr>
			                              </table></td>
                                      </tr>
				                      
  <!-- hasta aki -->
				                      
				                      </table></td>
                                  </tr>
				                  
				                  
				                  </table></td>
					          </tr>
			                </table>
						  </td>
					    </tr>
			          </table>
							
							
							

                      </div></td>
                    </tr>
                  </table>
				  
				        <br />
				          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td><hr width="100%" color="#003b85" />
                              </td>
                            </tr>
                          </table>
				         </TD>
			</TR>
		</TABLE>
	</FORM>

								  
								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

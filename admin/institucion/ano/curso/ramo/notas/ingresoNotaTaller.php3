<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$taller			=$_TALLER;
	$_ALUMNO		=$alumno;
	if(!session_is_registered('_ALUMNO'))
		session_register('_ALUMNO');
	$docente		=5; //Codigo Docente
	$periodo		=$_PERIODORAMO;
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


function fn(form,field)
		{
			var next=0, found=false
			var f=frm

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i-1;
						found=true
						break;
					}
				}
			}

			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i-21;
						found=true
						break;
					}
				}
			}

			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i+1;
						found=true
						break;
					}
				}
			}

			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i+21;
						found=true
						break;
					}
				}
			}



			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
				else{
					if(next<f.length-1)
						next=next+1;
					else
						break;
				}
			}

		}
//-->
</script>

<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<?php if($_MODOEVAL==1){ //EVALUACION NUMERICA?>
			<SCRIPT language="JavaScript">
				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaNroOnly(box,'Nota inválida.')) 
						return false;
					return true;
				}

				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}

				function valida(){ 
				var trun = frm.truncado.value;
					//VALIDA NOTAS
					for (var zz=3;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;

					var suma = 0;
					var cant;
					//OBTENER PROMEDIOS
					for (var ff=23;ff<document.frm.elements.length;ff=ff+21){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
                                //alert('suma'+suma);
								cant++;
							}
						}
						if(cant!=0){
							if(trun==1){
								document.frm.elements[ff].value=round((suma/cant),0);
							}else if (trun!=1){
								document.frm.elements[ff].value=parseInt((suma/cant),0);			
							}
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}
			</SCRIPT>
		<?php }?>

		<?php if($_MODOEVAL==2){ //EVALUACION CONCEPTUAL ?>
			<SCRIPT language="JavaScript">
				function validaNota(box){
					if(box.value.length==0)	
						return true; // acepta longitud 0
					if(!notaConOnly(box,'Nota inválida. Usar letras MAYUSCULAS'))
						return false;
					return true;
				}

				function valida(){ 
					//VALIDA NOTAS
					for (var zz=2;zz<document.frm.elements.length;zz++) //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
						if(!validaNota(document.frm.elements[zz]))
								return false;
						var suma = 0;
						var cant;
						var nuevo;
						var prom;
						var letra = 'Z';
						//OBTENER PROMEDIOS
						for (var ff=22;ff<document.frm.elements.length;ff=ff+21){
							cant = 0;
							for (var xx=(ff-20);xx<(ff);xx++){
								if (document.frm.elements[xx].value!=''){
									if (document.frm.elements[xx].value == "MB")
										nuevo = 65;
									if (document.frm.elements[xx].value == "B")
										nuevo = 55;			
									if (document.frm.elements[xx].value == "S")
										nuevo = 45;
									if (document.frm.elements[xx].value == "I")
										nuevo = 35;						
									suma=(parseInt(suma)+parseInt(nuevo));
									cant++;
								}
							}
							if(cant!=0){
									prom = suma/cant;
									if (prom>=60 && prom<=70)
										letra = 'MB';
									if (prom>=50 && prom<=59)
										letra = 'B';
									if (prom>=40 && prom<=49)
										letra = 'S';
									if (prom>=0 && prom<=39)
										letra = 'I';
									document.frm.elements[ff].value=letra;
							}else{
									document.frm.elements[ff].value='';
							}
							suma=0;
						}
				}
			</SCRIPT>
		<?php }?>

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?  include ("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <?  include ("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  <!-- inicio codigo antiguo -->
								  
	<FORM method=post name="frm" action="procesoIngresoTaller.php3">
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
              </strong> </FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>TALLER</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM taller  WHERE (((taller.id_taller)=".$taller."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre_taller']);
												
											}
										?>
              <?php if ($_MODOEVAL==1){ ?>
                        <input name="truncado" type="hidden" value="<?php echo $fila10['truncado']; ?>">
                        <?php 
						
						//$idaux = $fila10['id_taller'];
						
						//echo "$idaux <br>";
						
						//echo $fila10['truncado']; 
			       }?>
				   
			</strong></FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PERIODO</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$periodo;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nombre_periodo']);
												}
											}
										?>
              </strong> </FONT> </TD>
          </TR>
        </TABLE>
				</TD>
			</TR>
			<TR>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR>
							<TD align=right colspan=2>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida();">&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="mostrarNotasTaller.php3">&nbsp;	
							</TD>
						</TR>
						<TR>
							<TD align=middle colspan=2 class="tableindex">
								INGRESO NOTAS
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
								<?php
									//ALUMNOS DEL CURSO
                                  $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene_taller ON alumno.rut_alumno = tiene_taller.rut_alumno) WHERE ((tiene_taller.id_taller)=".$taller.")  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
									$result =@pg_Exec($conn,$qry);
									if(!$result)
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										if(pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (85)</B>');
												exit();
											};
												echo "<TR class='cuadro02'>";
												echo "<TD align=center>Nro.</TD>";
												echo "<TD align=center>ALUMNO</TD>";
												echo "<TD align=center><STRONG>1º</STRONG></TD>";
												echo "<TD align=center><STRONG>2º</STRONG></TD>";
												echo "<TD align=center><STRONG>3º</STRONG></TD>";
												echo "<TD align=center><STRONG>4º</STRONG></TD>";
												echo "<TD align=center><STRONG>5º</STRONG></TD>";
												echo "<TD align=center><STRONG>6º</STRONG></TD>";
												echo "<TD align=center><STRONG>7º</STRONG></TD>";
												echo "<TD align=center><STRONG>8º</STRONG></TD>";
												echo "<TD align=center><STRONG>9º</STRONG></TD>";
												echo "<TD align=center><STRONG>10º</STRONG></TD>";
												echo "<TD align=center><STRONG>11º</STRONG></TD>";
												echo "<TD align=center><STRONG>12º</STRONG></TD>";
												echo "<TD align=center><STRONG>13º</STRONG></TD>";
												echo "<TD align=center><STRONG>14º</STRONG></TD>";
												echo "<TD align=center><STRONG>15º</STRONG></TD>";
												echo "<TD align=center><STRONG>16º</STRONG></TD>";
												echo "<TD align=center><STRONG>17º</STRONG></TD>";
												echo "<TD align=center><STRONG>18º</STRONG></TD>";
												echo "<TD align=center><STRONG>19º</STRONG></TD>";
												echo "<TD align=center><STRONG>20º</STRONG></TD>";
												echo "<TD align=center>PROM</TD>";
												echo "</TR>";
												$X=0;
												$m = 0;
												$n = 0;
											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$X++;
												$Y=0;
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<TR>
														<?php
													}else{
														echo "<TR>";
													}
												}else{
													echo "<TR>";
												}
												echo "<TD align=rigth width=20 class='cuadro01'>";
												echo $i + 1;
												echo "<TD align=left width=400 class='cuadro01'>";
												echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
												echo "</TD>";

												//NOTAS ALUMNO POR RAMO Y PERIODO
											    $qry2="SELECT * FROM notas_taller WHERE (((notas_taller.rut_alumno)='".$fila1['rut_alumno']."') AND ((notas_taller.id_periodo)=".$periodo.") AND ((notas_taller.id_taller)=".$taller."))"; 

												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);	
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														  for($j=1;$j<22;$j++){
															$Y++;
															$fila2 = @pg_fetch_array($result2,0);
															$var="nota"."$j";
															
														echo "<TD align=center width=100>";
														
														$n = $n+1;
														
														
														if ($Y==21){
														    	if ($fila10['modo_eval']==2){
															  		 if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
														        		
																			
																		echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3 value=\"".trim($fila2['promedio'])."\">";
														       		  }else{
														           		 echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\"  onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3;>";
															          		}
														        	}else{
															   		  if ($fila2['promedio']!=0){
															      		echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=3 value=\"".trim($fila2['promedio'])."\">";   
																    	}else{
														            	echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3;>";
															        		 }
																	}
														   }else{
														        if ($fila10['modo_eval']==2){
															 		 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
														       		        echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3 value=\"".trim($fila2["$var"])."\">";
														              }else{
														              		echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3;>";
															                }
														          }else{
														             if (trim($fila2["$var"])!=0){
														                echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3 value=\"".trim($fila2["$var"])."\">";
														                 }else{
														                echo "<INPUT TYPE=text NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=3;>";
																         }
																	}
														    }
														echo "\n";
														echo "</TD>";
														}
													}else{
													    /*
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][1]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][2]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][3]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][4]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][5]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][6]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][7]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][8]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][9]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][10]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][11]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][12]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][13]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][14]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][15]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][16]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][17]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][18]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][19]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][20]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][21]\" onkeyup=fn(this.form,this) size=2  maxlength=3;>";
														echo "</TD>";  */
														
														$m = $m+1;
														echo "<TD align=center>";
														echo "<INPUT TYPE=text id=\"a_".$X."_1\"  NAME=\"a_".$X."_1\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_2\" NAME=\"a_".$X."_2\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_3\" NAME=\"a_".$X."_3\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_4\" NAME=\"a_".$X."_4\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_5\" NAME=\"a_".$X."_5\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_6\" NAME=\"a_".$X."_6\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_7\" NAME=\"a_".$X."_7\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_8\" NAME=\"a_".$X."_8\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_9\" NAME=\"a_".$X."_9\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_10\" NAME=\"a_".$X."_10\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_11\" NAME=\"a_".$X."_11\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_12\" NAME=\"a_".$X."_12\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_13\" NAME=\"a_".$X."_13\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_14\" NAME=\"a_".$X."_14\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_15\" NAME=\"a_".$X."_15\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_16\" NAME=\"a_".$X."_16\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_17\" NAME=\"a_".$X."_17\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_18\" NAME=\"a_".$X."_18\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_19\" NAME=\"a_".$X."_19\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_20\" NAME=\"a_".$X."_20\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														echo "<INPUT TYPE=text id=\"a_".$X."_21\" NAME=\"a_".$X."_21\" onkeyup=fn(this.form,this,".$m.") size=2  maxlength=3;>";
														echo "</TD>";
														
														
														
														
													}
												};
										
											echo "</TD>";
											echo "</TR>";
											};
										};
									};
								?>
								</TABLE>
							</TD>
						</TR>
						<!--TR>
							<TD align=right>
								<?php 
									if($_MODOEVAL==1){ //EVALUACION NUMERICA
								?>
									<!--INPUT TYPE="button" value="PROM" name=btnPromedio onClick="document.frm.NP.value=promedio(this.form);"-->&nbsp;
								<?php }?>
							</TD>
						</TR-->
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>
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
							
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
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

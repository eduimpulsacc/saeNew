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
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">
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
				}
			</SCRIPT>
		<?php }?>

	
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../../periodo/listarPeriodo.php3"><img src="../../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../feriado/listaFeriado.php3"><img src="../../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../../atributos/listarTiposEnsenanza.php3"><img src="../../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../../matricula/listarMatricula.php3"><img src="../../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../../util/");?>
	<FORM method=post name="frm" action="procesoIngresoTaller.php3">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
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
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
              </strong> </FONT> </TD>
          </TR>
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
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>TALLER</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT * FROM taller  WHERE (((taller.id_taller)=".$taller."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
												
											}
										?>
              <?php if ($_MODOEVAL==1){ ?>
              <input name="truncado" type="hidden" value="<?php echo $fila10['truncado']; ?>">
              <?php echo $fila10['truncado']; 
			  }?> </strong> </FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PERIODO</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
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
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50">
							<TD align=right colspan=2>
								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida();">&nbsp;
								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="mostrarNotas.php3">&nbsp;	
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INGRESO NOTAS</strong>
								</FONT>
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
												echo "<TR>";
												echo "<TD align=center>ALUMNO";
												echo "</TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";
												$X=0;
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
														echo "<TR bgcolor=#ffffff>";
													}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}
												echo "<TD align=left width=400>";
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
														
														
														if ($Y==21){
														    	if ($fila10['modo_eval']==2){
															  		 if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
														        		echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2 value=\"".trim($fila2['promedio'])."\">";
														       		  }else{
														           		 echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\"  onkeyup=fn(this.form,this) size=2  maxlength=2;>";
															          		}
														        	}else{
															   		  if ($fila2['promedio']!=0){
															      		echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this)  size=2  maxlength=2 value=\"".trim($fila2['promedio'])."\">";   
																    	}else{
														            	echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
															        		 }
																	}
														   }else{
														        if ($fila10['modo_eval']==2){
															 		 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
														       		        echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2 value=\"".trim($fila2["$var"])."\">";
														              }else{
														              		echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
															                }
														          }else{
														             if (trim($fila2["$var"])!=0){
														                echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2 value=\"".trim($fila2["$var"])."\">";
														                 }else{
														                echo "<INPUT TYPE=text NAME=\"a[".$X."][".$Y."]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
																         }
																	}
														    }
														echo "\n";
														echo "</TD>";
														}
													}else{
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][1]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][2]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][3]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][4]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][5]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][6]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][7]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][8]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][9]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][10]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][11]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][12]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][13]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][14]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][15]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][16]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][17]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][18]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][19]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][20]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
														echo "</TD>";
														echo "<TD align=center>";
														echo "<INPUT TYPE=text NAME=\"a[".$X."][21]\" onkeyup=fn(this.form,this) size=2  maxlength=2;>";
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
</BODY>
</HTML>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
-->
    </style>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){				
				document.form.action = "ficha_matricula.php3";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="ficha_matricula.php3";
			document.form.ssww.value=1;
			document.form.submit();
		}	
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}


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
//-->
</script>


</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="610" height="171" border="0">
  <tr>
   </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td width="589">
	<table width="640" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;		</td>
	<td>
	<table align="right">
		<tr><td>CURSO</td><td>
		  		</td><td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
		<tr><td>NIVEL</td>
		<td>
		
		</td>
		</tr>
		<tr><td>A�O PROMOCION</td>
		<td>
		</td>
		</tr>		
	</table>	
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr><td colspan="2" bgcolor="#CCCCCC">
      
	  <table align="center"><tr>
	    <td><b>FICHA DE MATRICULA</b> </td>
	  </tr></table>
  </td></tr>
   <tr><td colspan="2">
	  <table  width="100%"><tr><td><br>
	  N� de Matricula</td><td align="right"><br>
	  <table width="1%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td nowrap>&nbsp;</td>
		  <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td nowrap class="Estilo4">Fecha de Matr&iacute;cula</td>
        </tr>
      </table>
	  </tr></table>
  </td></tr>
  <tr><td colspan="2"   ><b><br>
    DATOS ALUMNO<br>
    <br>
  </b></td>
  </tr>
  <tr>
	  <td colspan="2">
	  	<table width="100%">
			<tr>
				<td height="40" valign="bottom"><b></b>
                _____________________ <br>
			    Apellido paterno </td>
				<td valign="bottom"><b></b>
                _____________________ <br>
			    Apellido Materno </td>
				<td valign="bottom"><b></b>
                _____________________ <br>
			    Nombre</td>
			</tr>
			<tr>
			  <td height="40" valign="bottom">
			  
<b>			   
</b>_____________________ <bR>
			  Fecha de Nacimiento </td>
			  <td valign="bottom"><b></b>
              _____________________ <br>
		      RUN</td>
			  <td valign="bottom"><b></b>
              _____________________ <br>
              Nacionalidad</td>
		  </tr>
		</table>	  </td>
  </tr>
  <tr>
  	<td colspan="2"><table width="100%">
  	  <tr><td height="40">
	  <b>
		</b>
_____________________<br>
Direccion</td>
  	  <td><b></b>
			_____________________<br>
            Comuna</td>
  	  <td></b>
      _____________________<br>
      Ciudad</td>
  	  </tr>
  	  <tr>
  	    <td colspan="3"><hr width="100%" size="3"></hr></td>
  	    </tr>
  	</table></td>
  </tr>
<tr><td colspan="2"  bgcolor="#CCCCCC"><b><br>
  DATOS PADRES<br>
</b></td>
</tr>
<tr>
	<td colspan="2">
	
	<table width="100%">
	
				<tr>
				<td height="54">
				 _____________________ <br>
				  Nombre Padre </td>
				<td>
				  ________________<br>
				  RUN</td>
				<td>
				 _________________ <br>
				  Profesion</td>
				<td>
				  _________________<br>
				  Nivel Educacional </td>
				<td>
				<!-- _____________ <br>
				  Renta--></td>
			  </tr>
				<tr>
				  <td>
                  _____________________<br>
                  Telefono</td>
				  <td>
                  _____________________<br>
                  E-Mail</td>
				  <td>
                  _____________________<br>
                  Religion</td>
				  <td colspan="2"><!--<table width="242" align="left" cellpadding="0" cellspacing="0">
		<tr>
			<td width="40%">Sistema de Salud </td>
			<td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <td nowrap>Fonasa </td>
			    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
			    </tr>
			  <tr>
			    <td nowrap>Consalud&nbsp;&nbsp; </td>
			    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr>
			        <td>&nbsp;&nbsp;&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
			  <tr>
			    <td nowrap>Banmedica</td>
			    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr>
			        <td>&nbsp;&nbsp;&nbsp;</td>
			        </tr>
			      </table></td>
			    </tr>
                <td nowrap>Cruz Blanca </td>
			    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
			    </tr>
                <td nowrap>Mas Vida</td>
			    <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr><td>&nbsp;&nbsp;&nbsp;</td></tr></table></td>
			  </table></td>
              </tr>
            
	</table>--></td>
			  </tr>
              <tr>
				<td><br>
				   _____________________ <br>
				  Nombre Madre </td>
				<td><br>
				 ________________<br>
				  RUN</td>
				<td><br>
				 _________________<br>
				  Profesion</td>
				<td><br>
				 _________________<br>
				  Nivel Educacional </td>
				<td><!--<br>
				 _____________ <br>
				  Renta--></td>
			  </tr>
              <tr>
                <td height="40">_____________________<br>
                  Telefono</td>
                <td>_____________________<br>
                E-Mail</td>
                <td> _____________________<br>
                  Religion</td>
                <td colspan="2"><!--<table width="242" align="left">
                  <tr>
                    <td width="40%">Sistema de Salud </td>
                    <td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap>Fonasa </td>
                        <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td nowrap>Consalud&nbsp;&nbsp; </td>
                        <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td nowrap>Banmedica</td>
                        <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <td nowrap>Cruz Blanca </td>
                        <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <td nowrap>Mas Vida</td>
                        <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                          <tr>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                          </tr>
                        </table></td>
                                      </table></td>
                  </tr>
                </table>--></td>
              </tr>
              <tr>
                <td colspan="5"><hr width="100%" size="3"></hr></td>
              </tr>
				
	</table>
	
	
	
	</td>
</tr>
<tr><td colspan="2">
 </td>
</tr>
<tr><td colspan="2" bgcolor="#CCCCCC"><b><br>
  DATOS APODERADOS<br>
  <br> 
</b></td>
</tr>
<tr>
	<td colspan="2">
		<table width="30%" border="0" cellpadding="1" cellspacing="0">
			<tr>
				<td width="1%">
				
				<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;</td>
                  </tr>
                </table>
				
				</td>
				<td>Padre</td>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;</td>
                  </tr>
                </table></td>
				<td>Madre</td>
				<td width="1%"><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                  <tr>
                    <td>&nbsp;&nbsp;&nbsp;</td>
                  </tr>
                </table></td>
				<td>Otro</td>
			</tr>
	  </table>
	  
	  
	  
	  </td>
</tr>
<tr><td colspan="2"><table width="100%">
  <tr>
    <td><br>_____________________<br>
      Nombre</td>
    <td><br>____________<br>
      RUN</td>
    <td><br>___________________________________ <br>
      Direccion</td>
    <td><br>___________ <br>
      Comuna</td>
   </tr>
   
</table></td></tr>
<tr>
  <td colspan="2"><table width="100%">
  <tr>
    <td width="18%"><br>____________ <br>
      Telefono</td>
    <td width="10%"><br>____________ <br>
      Celular</td>
    <td width="30%"><br>
      ____________<br>
      Telefono Recados </td>
    <td width="15%"><br>
      ____________<br>
      Fax</td>
    <td width="27%"><br>____________ <br>
      E-mail</td>
  </tr>
  <tr>
    <td><br>Alumno Vive Con Apoderado</td>
    <td colspan="2"><br>____________________________________________<br></td>
    <td colspan="2"><table width="242" align="left">
      <tr>
        <td width="40%">Situacion Conyugal de los Padres</td>
        <td width="40%"><table width="1%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td nowrap>Casado(a) </td>
            <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td nowrap>Separado(a)&nbsp;&nbsp; </td>
            <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td nowrap>Divorciado(a)</td>
            <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
            <td nowrap>Viudo(a) </td>
            <td nowrap><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td height="20" colspan="5"><hr width="100%" size="3"></hr></td>
    </tr>
  </table></td></tr>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
<tr>
<td colspan="2"><em><strong>ANTECEDENTES ACADEMICOS</strong></em></td>
</tr>
<tr>
  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>Ha Repetido Curso</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <th align="left">_______________________________</th>
      <th align="left"><table>
        <tr>
          <td>Procedencia _____________________________</td>
          </tr>
      </table></th>
    </tr>
    <tr>
      <td>Pertenece Al Programa de Integraci&oacute;n</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td align="right"><!--Alumna Embarazada--></td>
      <td align="left"><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
    </tr>
    <tr>
      <td><!--Pertenece A Subvenci&oacute;n Preferencial(SEP)--></td>
      <td><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
      <td align="right"><!--Alumno(a) con Beca Puente--></td>
      <td align="left"><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
    </tr>
    <tr>
      <td><!--Alumno Calificado Con Retos Multiples--></td>
      <td><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
      <td align="right"><!--Alumno(a) Con Financiamiento Compartido--></td>
      <td align="left"><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
    </tr>
    <tr>
      <td><!--Alumno Origen Indigena--></td>
      <td><!--<table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>--></td>
      <td align="right" valign="top">Presenta Alguna Sancion 2013</td>
      <td align="left"><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table>
        <br>
      &iquest;Cu&aacute;l?________________________________</td>
    </tr>
    <tr>
      <td height="29">&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="left" valign="bottom"></td>
    </tr>
  </table></td>
</tr>
<tr>

  <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <th colspan="4" align="left" scope="col"><strong><em>ANTECEDENTES DE SALUD</em></strong></th>
      </tr>
    <!--<tr>
      <td>El Alumno(a) Sufre Alguna Enfermedad importante en la Actualidad</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td valign="bottom">________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Ha sido Sometido a Alguna Cirugia</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td valign="bottom">________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Toma Algun Medicamento en forma Periodica</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Presenta Alguna Alergia</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Tiene Algun Impedimento Para Realizar Educaci&oacute;n Fisica</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Puede Tomar Algun Medicamento en caso de Fiebre</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>________________________________</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>El Alumno(a) Tiene Algun Seguro Distinto Del Escolar</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>________________________________</td>
      <td>&nbsp;</td>
    </tr>-->
    <tr>
      <td width="41%" height="25">&iquest;Qu&eacute; medicamentos utiliza actualmente?</td>
      <td colspan="3">______________________________________________</td>
      </tr>
    <tr>
      <td>&iquest;El alumno sufre alguna patolog&iacute;a que le impida realizar la pr&aacute;ctica de Educaci&oacute;n f&iacute;sica?</td>
      <td width="10%"><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td width="28%">&nbsp;____________________________________</td>
      <td width="21%">&nbsp;Especificar</td>
    </tr>
    <tr>
      <td>&iquest;Adjunta Certificado m&eacute;dico?</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Observaci&oacute;n De Salud<br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<bR>
<br><br></td>
      </tr>
  </table></td>
</tr>
<tr>
  <td colspan="2"><!--<table width="100%" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr>
      <th colspan="4" align="left" scope="col"><strong><em>EMERGENCIAS Y RETIROS</em></strong></th>
      </tr>
    <tr>
      <td>Autoriza al Establecimiento a sacar a su pupilo en caso de Emergencia de Salud</td>
      <td><table>
        <tr>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>SI</td>
          <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr>
              <td>&nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table></td>
          <td>NO</td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="left">PERSONAS AUTORIZADAS PARA RETIRAR EL ALUMNO, EN CASO DE NO SER LOS PADRES O APODERADOS</td>
      </tr>
    <tr>
      <td>________________<br>
RUT</td>
      <td>_____________________ <br>
Nombre</td>
      <td>_____________________<br>
Telefono</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>_____________________<br>
        Parentesco</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>--></td>
</tr>
<tr><td cols&npan="4"><b><br>
  OTROS<br>
</b></td></tr>
<tr>
	<td colspan="2">
		<table>
			<tr>
				<td width="165">Autoriza religion Catolica (anual)</td>
				<td width="75">
					<table><tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>SI</td>
					<td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>NO</td>
					</tr></table>				</td>
				<td width="6">&nbsp;</td>
				<td width="110">&iquest;Religi&oacute;n Evang&eacute;lica?</td>
				<td width="75"><table>
				  <tr>
				    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
				      <tr>
				        <td>&nbsp;&nbsp;&nbsp;</td>
				        </tr>
				      </table></td>
				    <td>SI</td>
				    <td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
				      <tr>
				        <td>&nbsp;&nbsp;&nbsp;</td>
				        </tr>
				      </table></td>
				    <td>NO</td>
				    </tr>
			    </table></td>
				<td width="6">&nbsp;</td>
				<td width="141"><table width="133"><tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>Artes</td>
					<td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td>
					<td>M&uacute;sica</td>
				</tr></table></td>
			  </tr>
		</table></td>
</tr>
<!--<tr>
  <td colspan="2"><br>
    Tiene algun problema de salud significativo __________________________________________________________________________________<br></td></tr>
-->
<tr><td colspan="2"><table width="100%">
    <tr>
      <td valign="bottom"><br>
        ___________________________<br>
        N&ordm; Boleta Matr&iacute;cula</td>
      <td valign="bottom"><br>
        __________________________<br>
        Monto Cancelado </td>
      <td valign="bottom"><br>
        ______________<br>
        Fecha Cancelacion </td>
    </tr>
  </table></td></tr>
  <tr><td colspan="2"><table width="100%">
    <tr>
      <td valign="bottom"><br>
        ___________________________<br>
        N&ordm; Boleta C.G.P.A </td>
      <td valign="bottom"><br>
        __________________________<br>
        Monto Cancelado </td>
      <td valign="bottom"><br>
        ______________<br>
        Fecha Cancelacion </td>
    </tr>
  </table></td></tr>
  <tr><td colspan="2"><table width="100%">
    <tr>
      <td valign="bottom"><br>
        ___________________________<br>
        Facultad Delegada</td>
      <td valign="bottom"><br>
        __________________________<br>
        Monto Cancelado </td>
      <td valign="bottom"><br>
        ______________<br>
        Fecha Cancelacion </td>
    </tr>
  </table></td></tr>
  <tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td colspan="2">
	<table width="70%">
		<tr>
			
			<td width="22%" valign="top" nowrap>Entrega Cert. Nac.</td>
			<td width="16%" valign="top">
				<table>
					<tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                      </tr>
                    </table></td></tr>
					<tr><td>Si</td><td>No</td></tr>
				</table>		  </td>
		  <td width="18%" valign="top" nowrap>Entrega Fotos</td>
			<td width="44%" valign="top">
			  <table>
			    <tr><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			      <tr>
			        <td>&nbsp;&nbsp;&nbsp;</td>
			        </tr>
			      </table></td><td><table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
			        <tr>
			          <td>&nbsp;&nbsp;&nbsp;</td>
			          </tr>
			        </table></td></tr>
			    <tr><td>Si</td><td>No</td></tr>
			    </table>		  </td>
			</tr>
	</table>	</td>
</tr>
 <br>
  <br>
   <br>
    <br>
    <tr><td colspan="2"> Observaciones:<br>
    <br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<br>
    <br>
    ___________________________________________________________________________________________________________________________<bR>
<br><br>
<br></td>
<tr>
  <td colspan="2">    YO, ____________________________________________, RUT _______________, declaro haber recepcionado el Manual de Convivencia, C&oacute;digo de Conducta, Proyecto Educativo Institucional, Reglamento de Evaluaci&oacute;n y Promoci&oacute;n. Adem&aacute;s me comprometo a asistir a reuniones de subcentro de padres y/o entrevista cuando el liceo me requiera.<br>
    <br></td>
<tr>
  <td align="center"="2"><br>
    ________________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>
    <b>NOMBRE Y FIMA APODERADO</b> </td>
</table>
	</td>
  </tr>
</table>


</body>
</html>
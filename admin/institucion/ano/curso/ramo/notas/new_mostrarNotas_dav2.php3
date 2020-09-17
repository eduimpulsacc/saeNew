<?php require('../../../../../../util/header.inc');?>
<?php 

if ($id_ramo != NULL or $id_ramo != 0){
	$_RAMO=$id_ramo;
	session_register('_RAMO');
}


$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$ramo			=$_RAMO;

$docente		=5; //Codigo Docente
$_POSP          =6;
$_bot           =5;
$periodo = $periodo;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript1.5" type="text/JavaScript">
<!--
function enviapag(form){
    if (form.cmbPERIODO.value!=0){
	    form.cmbPERIODO.target="self";
	    form.action = 'new_mostrarNotas_dav2.php3?id_ramo=<?=$ramo?>&aux=1&periodo='+form.cmbPERIODO.value;
	    form.submit(true);
    }
}


<!-- nueva validación -->
function valida_all(v,modoeval,f,id_box,x){
    
	if (modoeval==1){
	    
	    /// validaciones para modo de evaluacion numérica
		if ((v>70 || v<10) && v != '' || v == 'i' || v == 's' || v == 'b' || v == 'mb' || v == 'I' || v == 'S' || v == 'B' || v == 'MB'){
		    alert('Nota inválida, evaluación numérica');
		    f.item(id_box).value="";
		    f.item(id_box).focus();
		    
		}else{	
		
			var trun = frm.truncado.value;
			var suma = 0;
			var cant = 0;
			var re = 0;
			
			//OBTENER PROMEDIOS
			var ff = 23;
			
			if (x>1){
			   x = x - 1;
			   ff = ff + (21*x);
			}
			
			var hasta = ff + 1;
			
			for (ff=ff;ff<hasta;ff=ff+1){
				cant = 0;
				for (var xx=(ff-20);xx<(ff);xx++){
					if (document.frm.elements[xx].value!=''){
						suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
						cant++;
					}
				}
				
				if(cant!=0){
					if(trun==1){
					    document.frm.elements[ff].value=Math.round((suma/cant),0);						
					}else{
					    
					    document.frm.elements[ff].value=parseInt((suma/cant),0);							  			
					}
				}else{
				    
					document.frm.elements[ff].value='';
				}				
				suma=0;			
			}
		}	 
	}
	
	
	if (modoeval==2){
	    //validaciones para modod de evaluacion conceptual
		if (v!='I' && v !='S' && v != 'B' && v != 'MB' && v!='' && v != null){
		     alert('Nota inválida, evaluación conceptual');
			 f.item(id_box).value="";
		     f.item(id_box).focus();
		}else{
		    
			 var suma = 0;
			 var cant;
			 var nuevo;
			 var prom;
			 var letra = 'Z';
			 //OBTENER PROMEDIOS
			 var ff = 23;
			
			 if (x>1){
			    x = x - 1;
			    ff = ff + (21*x);
			 }
			
			 var hasta = ff + 1;
			 for (ff=ff;ff<hasta;ff=ff+1){
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
	}		
	
	
	
	
	if (modoeval==3){
	    //Validaciones para modo numérico conceptual;
		
				if ((v>70 || v<10) && v != '' && v != ' ' || v=='I' || v=='S' || v=='B' || v=='MB' || v=='i' || v=='s' || v=='b' || v=='mb'){
					alert('Nota inválida, evaluación numérica - conceptual');
					f.item(id_box).value="";
					f.item(id_box).focus();		    
				
				}else{	
					var trun = frm.truncado.value;
					var suma = 0;
					var cant;
					var prom;
					var letra;
					var instit=0;
					
					//OBTENER PROMEDIOS
					var ff = 23;
					
					if (x>1){
					   x = x - 1;
					   ff = ff + (21*x);
					}
					
					var hasta = ff + 1;
					
					for (ff=ff;ff<hasta;ff=ff+1){
						cant = 0;
						
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								suma=(parseInt(suma)+parseInt(document.frm.elements[xx].value));
								cant++;
							}
						}
						
						if(cant!=0){
								if(trun==1){
									prom = Math.round((suma/cant),0);
								}
								if (trun!=1){
									prom = parseInt((suma/cant),0);
								}
								
								
								
								if(instit==2278){
									if (prom>=61 && prom<=70)
										letra = 'MB';
									if (prom>=51 && prom<=60)
										letra = 'B';
									if (prom>=40 && prom<=50)
										letra = 'S';
									if (prom>=0 && prom<=39)
										letra = 'I';
										
									document.frm.elements[ff].value=letra;
								}else{						
									
								
									if (prom>=60 && prom<=70)
										letra = 'MB';
										
									if (prom>=50 && prom<=59)
										letra = 'B';
										
									if (prom>=40 && prom<=49)
										letra = 'S';
										
									if (prom>=0 && prom<=39)
										letra = 'I';								
									document.frm.elements[ff].value=letra;
								}
								
						}else{
								document.frm.elements[ff].value='';
						}
						suma=0;
					}
				}
				
	}
	
	
	
	if (modoeval==4){
			//validaciones para modo conceptual - numerico
						
			if (v!='I' && v !='S' && v != 'B' && v != 'MB' && v!='' && v != null){
				 alert('Nota inválida, evaluación conceptual - numérico');
				 f.item(id_box).value="";
				 f.item(id_box).focus();
			}else{
		         		  
				 var trun = frm.truncado.value;
				 var suma = 0;
				 var cant;
				 var nueva_nota;
				 var prom_nuevo;
				 var prom;
				
				 //OBTENER PROMEDIOS
				 var ff = 23;
				 if (x>1){
					x = x - 1;
					ff = ff + (21*x);
				 }
				 var hasta = ff + 1;
			
				 for (ff=ff;ff<hasta;ff=ff+1){
						cant = 0;
						for (var xx=(ff-20);xx<(ff);xx++){
							if (document.frm.elements[xx].value!=''){
								if (document.frm.elements[xx].value == "MB")
									nueva_nota = 65;
								if (document.frm.elements[xx].value == "B")
									nueva_nota = 55;			
								if (document.frm.elements[xx].value == "S")
									nueva_nota = 45;
								if (document.frm.elements[xx].value == "I")
									nueva_nota = 35;						
								suma=(parseInt(suma)+parseInt(nueva_nota));
								cant++;
							}
						}
						
						
						if(cant!=0){
								prom = parseInt((suma/cant),0);
								if (prom>=65 && prom<=70)
									prom_nuevo = 70;
								if (prom>=60 && prom<=64)
									prom_nuevo = 60;
								if (prom>=55 && prom<=59)
									prom_nuevo = 55;
								if (prom>=50 && prom<=54)
									prom_nuevo = 50;								
								if (prom>=45 && prom<=49)
									prom_nuevo = 45;
								if (prom>=40 && prom<=44)
									prom_nuevo = 40;
								if (prom>=0 && prom<=39)
									prom_nuevo = 35;
								
								
								document.frm.elements[ff].value = prom_nuevo;			
						}else{
						        
								document.frm.elements[ff].value='';
						}
						suma=0;
				 }
				
					
			} 	
	}
	
}	
<!-- fin nueva validación -->
//-->
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


		function fn(form,field,m)
		{
			var next=0, found=false, x, y, g;
			var f=frm;
		    //alert(bloq);
			//return false;
			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						next=m+1;						  
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						next=m-19;
						found=true
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						next=m+3;
						
						found=true
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
						next=m+23;
						found=true
			}

			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
			}

		}

		
</SCRIPT>
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
<script language="javascript">
<!--
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
} 

function eliminaEspacios(cadena)
{
	// Funcion equivalente a trim en PHP
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}


function cargaDatos(idInput,alumno,ramo,periodo,n,promedio){
	var valorInput=document.getElementById(idInput).value;
	var promedio=document.getElementById(promedio).value;
	var divError=document.getElementById("error");
	
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('alumno:'+alumno+' ramo:'+ramo+' periodo:'+periodo+' casilla:'+casilla);
	
	ajax.open("GET", "ingreso_sin_recargar_proceso.php?valor="+valorInput+"&alumno="+alumno+"&ramo="+ramo+"&periodo="+periodo+"&casilla="+n+"&promedio="+promedio, true);
	ajax.send(null);	
	
}

function blanco(f,v){
	f.item(v).style.backgroundColor='#FFFF33';	
}
function blanco2(f,v){
	f.item(v).style.backgroundColor='#B6E7CE';	
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>	
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
.Estilo1 {
	font-size: 14px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo2 {
	color: #000000;
	font-weight: bold;
}
.Estilo3 {
	color: #990000;
	font-size: 12px;
}
.Estilo4 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #990000; }
.Estilo6 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
</style>
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
								  
								  


	<?php //echo tope("../../../../../../util/");?>
	<div class="mensaje" id="error"></div>
	<FORM method=post name="frm" action="new_procesoIngreso.php3">
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
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
													$ano_act = trim($fila1['nro_ano']);
													echo $ano_act;
													$_ANOACTUAL = $ano_act;
												
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
									<strong>CURSO</strong>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo, curso.bloq_nota FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													$grado = $fila1['grado_curso'];
													$ensenanza = $fila1['cod_tipo'];
													$bloq_nota = $fila1['bloq_nota'];
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>
								</FONT></TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>SUBSECTOR</strong>
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
											$qry="SELECT subsector.nombre, modo_eval, truncado, prueba_nivel, pct_nivel, modo_eval_pnivel, truncado_pnivel,aprox_entero FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila10 = @pg_fetch_array($result,0);	
												echo trim($fila10['nombre']);
												$modo_eval_p_nivel = $fila10['modo_eval_pnivel'];
												$truncado_pnivel   = $fila10['truncado_pnivel'];
												$aprox_entero		=$fila10["aprox_entero"];
											}
										?>
			<?php if ($fila10[modo_eval]==1 || $fila10[modo_eval]==3 || $fila10[modo_eval]==4 || $fila10[modo_eval]==2){ ?>
              <input name="truncado" type="hidden" value="<?php echo $fila10['truncado']; ?>">
			
			<?php 
			  
			  }
			 			  			  
			  ?>

									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>PERIODO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<select name="cmbPERIODO" onChange="enviapag(this.form)" class="imput">
								     <option value="0">Seleccione Período</option>
									<?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$periodo){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};
									?>
								</Select>
							</TD>
						</TR>
						
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ESTADO DE INGRESO DE NOTAS</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<? if ($bloq_nota==1){ ?>								
								      <img src="../../../../../configuracion/cand_cerrado.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>BLOQUEADO POR EL ADMINISTRADOR</strong></FONT>
							  <?  }else{ ?>
							          <img src="../../../../../configuracion/cand_abierto.jpg">
									  &nbsp; <FONT face="arial, geneva, helvetica" size=2>
									<strong>DISPONIBLE PARA INGRESO</strong></FONT>							  
							  <? } ?>							  								
							</TD>
						</TR>					
						
					</TABLE>
					
				   
				 
					
					</TD>
			</TR>
			<TR height=15>
				<TD>
				   
				     <table width="100%" border="0">
                      <tr>
                        <td><div align="center"><INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="../listarRamos.php3?plan=&ext=">&nbsp;</div></td>
                      </tr>
                    </table>
					<!-- muestra si hay periodo seleccionado -->
					<?
					if ($periodo>0){ ?>
					
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0 height="100%">
						<TR height="50">
							<TD  colspan=2>
					          <table width="100%" border="0" cellpadding="0" cellspacing="1">
                                <tr>
                                  <td bgcolor="#FFFFFF"><p class="Estilo1"><span class="Estilo2">Estimado usuario:</span><br>
                                      <span class="Estilo3">Para el ingreso de notas solo es necesario que haga click en una casilla e ingrese la evaluaci&oacute;n. <br>
                                      Para desplazarse por las casillas use las &quot;teclas de direcci&oacute;n arriba, abajo, derecha, izquierda o haciendo click en otra casilla.<br> Al abandonar la casilla donde ingres&oacute; la nota, el promedio del alumno se reflejar&aacute; en forma instant&aacute;nea y toda la informaci&oacute;n  estar&aacute; ingresada en el sistema.  </span></p></td>
                                </tr>
                                <tr>
                                  <td height="20" bgcolor="#FFFFFF"><div align="center" class="Estilo1">SE REQUIERE EL USO DE NAVEGADOR INTERNET EXPLORER VERSI&Oacute;N 6 &Oacute; 7 </div></td>
                                </tr>
                              </table></TD>
						</TR>		
						
						<?
		$sql_busca = "SELECT * FROM notas$ano_act n INNER JOIN  ramo r ON r.id_ramo=n.id_ramo WHERE n.id_ramo=".$ramo." AND n.id_periodo=".$periodo." AND n.nota20 is not null AND n.nota20<>'0'";
		$result_busca =@pg_Exec($conn,$sql_busca);
		$p_nivel = @pg_numrows($result_busca);
                        ?>						
						
						<TR height=20>
							<TD align=center colspan=2><font face="Verdana, Arial, Helvetica, sans-serif" size="2">INGRESO NOTAS</font></TD>
						</TR>
						
						<?		
						// VERIFICO SI EL PERIODO ESTA CERRADO
						$q1 = "select * from periodo where id_periodo = ".$periodo."";
						$r1 = pg_Exec($conn,$q1);
						if (!$r1){
						   echo "<TR height=20><TD align=middle colspan=2 >Erro: No encontró el periodo</TD></TR>";
						   exit();
						}else{
						   $f1 = pg_fetch_array($r1,0);
						   $cerradop = $f1['cerrado'];
						   
						   if ($cerradop==1){
						       echo "<TR height=20><TD align=middle colspan=2 ><p class='Estilo1'><span class='Estilo3'>(No es posible ingresar notas. El periodo esta cerrado.)</span></p></TD></TR>";
						   }	   
						}	
						
						// VERIFICO SI EL SUBSECTOR PERTENECE A UN SUBSECTOR FORMULA
						$qry_formula = "select * from formula where id_ramo = '$ramo' and modo = '2'";
						$res_formula = @pg_Exec($conn,$qry_formula);
						$num_formula = @pg_numrows($res_formula);	
						
						if ($num_formula!=0){
						       echo "<TR height=20><TD align=middle colspan=2 ><p class='Estilo1'><span class='Estilo3'>(No es posible ingresar notas. El subsector obtiene el promedio luego de procesar el subsector fórmula al cual pertenece.)</span></p></TD></TR>";
						}
											
						?>	
						
						<!--
						<?
						if ($_PERFIL==14 or $_PERFIL==0){  ?>
						     <TR height=20><TD  colspan=2 ><p class='Estilo1'><span class='Estilo3'><input name="conf_porcentaje" type="button" class="botonXX" id="conf_porcentaje" onClick="MM_openBrWindow('config_porcentaje.php?periodo=<?=$periodo?>&id_ramo=<?=$ramo ?>','','width=1024,height=250')" value="CONFIGURAR PORCENTAJE (opcional)">
						</span></p></TD></TR>
					  <? } ?>					
						-->
						
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width="100%" align="left">
								<?php
									//ALUMNOS DEL CURSO
//                                    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso FROM (alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno) WHERE tiene$ano_act.id_ramo=".$ramo."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                                $qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso, matricula.nro_lista, matricula.bool_ar "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$ano_act.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " AND matricula.bool_ar=0 ";
										$qry = $qry . " ORDER BY  matricula.nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc";
										$result =@pg_Exec($conn,$qry);

										//matricula.nro_lista asc,

									if(!$result)
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										if(pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);
												echo "<TR>";
												echo "<TD align=center>Nº";
												echo "</TD>";
												echo "<TD align=center>ALUMNO";
												echo "</TD>";
												$sumo_valor=0;
												for ($i=1; $i < 21; $i++){ 											
													
													?>										
												     <TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(<?=$i?>º)<br></STRONG></FONT></TD>
													 <?
												}
												
												
												
												echo "<TD align=center>PROM";
												echo "</TD>";
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
														echo "<TR class=textolink>";
													}
												}else{
													echo "<TR class=textolink>";
												}
												
												echo "<TD align=left width=20 class=textolink>";
												echo  $fila1["nro_lista"];
												echo "</TD>";
												
												if ($fila1['bool_ar'] == 1){
												    echo "<TD align=left width=400  class=tachado>";
												    echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
												    echo "</TD>";  
													  
												}else{	  
												    echo "<TD align=left width=400 class=textolink>";
												    echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
												    echo "</TD>";
												}
												

												//NOTAS ALUMNO POR RAMO Y PERIODO
												$qry2="SELECT * FROM notas$ano_act WHERE (((notas$ano_act.rut_alumno)=".$fila1['rut_alumno'].") AND ((notas$ano_act.id_periodo)=".$periodo.")  AND ((notas$ano_act.id_ramo)=".$ramo.")) and notas$ano_act.rut_alumno in (SELECT matricula.rut_alumno FROM alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno WHERE  tiene$ano_act.id_ramo=".$ramo." AND matricula.id_ano=".$ano." AND matricula.bool_ar=0 )"; 

												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
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
															echo "<TD align=center width=100 >";
															$n = $n+1;
															
															///// NUEVO CÓDIGO PARA GUARDAR TODAS LAS NOTAS DE ESTE ALUMNO /////
															if ($j<21){		
															     $nota = $fila2["$var"];
																 if ($nota>0){													 
															         $arreglonotas['r'][]=$fila1['rut_alumno'];
																	 $arreglonotas['n'][]=$nota;
									  						     }
																 if ($nota==0){
									     							 $nota=NULL;
									  						     }
															}
															
																		
				
															if ($Y==21){   // columna promedios
																	if ($fila10['modo_eval']==2){
																		 if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I) ){
																			 echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";
																		  }
																		  else{
																		     
																			  echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") size=2  maxlength=2;>";
																		  }
																	}
																	
																	if ($fila10['modo_eval']==1){
																		  if ($fila2['promedio']!=0){ 	
																		      if ($fila1['bool_ar']==1){
																				   echo "&nbsp;".$fila2['promedio'];																				
																			  }else{
																			       ?>										
																				   <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onkeyup="fn(this.form,this,<?=$n?>)" value="<?=trim($fila2['promedio']); ?>" size="2"  maxlength="2"  <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				   <?   
																			  } 
																		  }
																		  else{
																		      if ($fila1['bool_ar']==1){
																				   echo "&nbsp;".$fila2['promedio'];																				
																			  }else{
																			       ?>
																			       <INPUT TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onkeyup="fn(this.form,this,<?=$n?>)"  size="2"  maxlength="2"  <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				   <?
																		      }
																		  }
																	}
																	if ($fila10['modo_eval']==3){
																		  if ((trim($fila2['promedio'])==MB) OR (trim($fila2['promedio'])==B) OR (trim($fila2['promedio'])==S) OR (trim($fila2['promedio'])==I)){
																			echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";   
																		  }
																		  else{
																		     
																			echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";
																		  }
																	}
																	
																	if ($fila10['modo_eval']==4){
																		  if ($fila2['promedio']!=0){
																			echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.") value=\"".trim($fila2['promedio'])."\" size=2  maxlength=2;>";  
																		  }
																		  else{
																		     
																			echo "<INPUT TYPE=text id=\"a_".$X."_".$Y."\"  NAME=\"a_".$X."_".$Y."\" onkeyup=fn(this.form,this,".$n.")  size=2  maxlength=2;>";  
																		  }
																	}
															}
															else{
															////////// ALGUNAS VALIDACIONES /////
															$qry_formula = "select * from formula where id_ramo = '$ramo' and modo = '2'";
														    $res_formula = @pg_Exec($conn,$qry_formula);
														    $num_formula = @pg_numrows($res_formula);	
															
																												
															if ($fila2["$var"]==0){
															    $nota_casilla="";
															}else{
															    $nota_casilla=$fila2["$var"];
															}															
															////////// FIN VALIDACIONES /////////////	
															
															
															
															
																	if ($fila10['modo_eval']==2){
																		 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I) OR trim($fila2["$var"])!=0){
																				?>
																				<INPUT style="color:#003399; background-color:#FFFF33" TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>"  size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				<?																				
																		 }else{  ?>
																		        <INPUT style="color:#003399; background-color:#FFFF33" TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>"  size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				<?
																		 }
																	 }
																	if ($fila10['modo_eval']==1){
																		if(!strcmp($var,'nota20')){
																			 if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
																				
																				
																				 ?>																				
																				<INPUT style="color:#003399; background-color:#FFFF33" TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($nota_casilla)?>"  size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				<?
																				
																			 }else{
																				 if (trim($fila2["$var"])!=0){ 
																					
																				   ?>
																					<INPUT style="color:#003399; background-color:#FFFF33" TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($nota_casilla)?>"  size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>> <?
																				    
																				 }else{ 
																				     ?>
																					<INPUT style="color:#003399; background-color:#FFFF33" TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($nota_casilla)?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?  
																				    
																				 }
																			 }
																		}
																		else{
																			 if (trim($fila2["$var"])!=0){	?>																			  
																				<INPUT style="color:#003399; background-color:#FFFF33"  TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($nota_casilla)?>" size="2" maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1 ){ ?> disabled="disabled" <? } ?>><?   									
																		    }else{  ?>														  
																				<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($nota_casilla)?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1 ){ ?> disabled="disabled" <? } ?>><?   							   																		  
																			 }
																		}
																	 }
																	if ($fila10['modo_eval']==3){
																		  if (trim($fila2["$var"])!=0){
																		     
																			    ?>
																				<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																				<?
																		  }else{
																		        ?>
																		        <INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<? if ($fila2["$var"]==0){ echo NULL; }else{ echo trim($fila2["$var"]); } ?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
																		        <?
																		  }
																	}
																	
																	if ($fila10['modo_eval']==4){
																		  if ((trim($fila2["$var"])==MB) OR (trim($fila2["$var"])==B) OR (trim($fila2["$var"])==S) OR (trim($fila2["$var"])==I)){
																		        ?>
																				<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>> 
																				<?
																	     }else{
																		        ?>
																				<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_<?=$Y?>"  NAME="a_<?=$X?>_<?=$Y?>" onKeyUp="fn(this.form,this,<?=$n?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','<?=$Y?>','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop==1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>> <?																				
																		  }
																	}
																	
																	
															}  
															echo "\n";
															echo "</TD>";
														}  // fin for j
													}	// fin if
													else{   // CUANDO SE INSERTAN NOTAS POR PRIMERA VEZ
														$Y=1;
														$m = $n+1;
														echo "<TD align=center>"; ?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_1"  NAME="a_<?=$X?>_1" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','1','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m + 1;
														$Y++;
														
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_2"  NAME="a_<?=$X?>_2" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','2','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
													
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_3"  NAME="a_<?=$X?>_3" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','3','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_4"  NAME="a_<?=$X?>_4" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','4','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_5"  NAME="a_<?=$X?>_5" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','5','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_6"  NAME="a_<?=$X?>_6" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','6','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_7"  NAME="a_<?=$X?>_7" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','7','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_8"  NAME="a_<?=$X?>_8" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','8','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_9"  NAME="a_<?=$X?>_9" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','9','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_10"  NAME="a_<?=$X?>_10" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','10','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_11"  NAME="a_<?=$X?>_11" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','11','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_12"  NAME="a_<?=$X?>_12" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','12','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_13"  NAME="a_<?=$X?>_13" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','13','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_14"  NAME="a_<?=$X?>_14" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','14','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_15"  NAME="a_<?=$X?>_15" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','15','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_16"  NAME="a_<?=$X?>_16" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','16','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_17"  NAME="a_<?=$X?>_17" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','17','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_18"  NAME="a_<?=$X?>_18" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','18','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_19"  NAME="a_<?=$X?>_19" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','19','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														$Y++;
														?>
														<INPUT style="color:#003399; background-color:#FFFF33"   TYPE="text" id="a_<?=$X?>_20"  NAME="a_<?=$X?>_20" onKeyUp="fn(this.form,this,<?=$m?>)" onBlur="blanco(this.form,this.id); valida_all(this.value,<?=$_MODOEVAL?>,this.form,this.id,<?=$X?>); cargaDatos(this.id,'<?=$fila1['rut_alumno']?>','<?=$ramo?>','<?=$periodo?>','20','a_<?=$X?>_21')" onClick="blanco2(this.form,this.id)" onFocus="blanco2(this.form,this.id)"  value="<?=trim($fila2["$var"])?>" size="2"  maxlength="2" <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>><?
														
														$Y++;
														echo "</TD>";
														echo "<TD align=center>";
														$m = $m+1;
														?>
														<INPUT TYPE=text id="a_<?=$X?>_21" NAME="a_<?=$X?>_21" onkeyup="fn(this.form,this,<?=$m?>)" size="2"   maxlength="2"  <? if ($cerradop == 1 or $num_formula!=0 or $bloq_nota==1){ ?> disabled="disabled" <? } ?>>
														<?
														echo "</TD>";
														
														$n=$m;

													}
													
													
													
												};
										
												echo "</TD>";
												echo "</TR>";
											};

										};
									};
								?>
								</TABLE>							</TD>
						</TR>
						
						
						
						
						

						
						
						
						
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					</TABLE>
					<? } ?>
					<!-- fin condicion si hay periodo seleccionado -->
					
				</TD>
			</TR>
		</TABLE>
	</FORM>
	<!--a href="promedio/proceso_promedio.php"> Promedios</a-->


 <? 
 
 pg_close($conn);?>
								  
								  <!-- fin codigo antiguo -->
								
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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

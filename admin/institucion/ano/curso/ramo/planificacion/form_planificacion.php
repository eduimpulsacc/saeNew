<?php require('../../../../../../util/header.inc');?>
<?php 
	
	if ($modificar){
		$_FRMMODO="modificar";
	}
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}

	$_POSP          =6;
	$_bot           =5;
?>
<?php 
   
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$frmModo 		=$_FRMMODO;

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	
	
	$qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista, matricula.bool_ar "; 
	$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
	$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
	$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$Rs_Notas = @pg_exec($conn,$qry);
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

<script language="javascript" type="text/javascript">
<!--
// Valida Fecha By Luciano 1998
// Uso: Simple... se debe pasar la cadena de la fecha y devuelve false si no es válida...
// El Formato es dd-mm-aaaa
// Ejemplo: if (Validar('14-08-1981')==false) { alert('Entrada Incorrecta') }
// Uso en formularios: onSubmit="return Validar(this.fecha.value)"
//
// Este script y otros muchos pueden
// descarse on-line de forma gratuita
// en El Código: www.elcodigo.com


function validafechaini(){
    var Fecha = new String(document.frm.fecha_ini.value)
	//var Fecha= new String(Cadena)	// Crea un string
	var RealFecha= new Date()	// Para sacar la fecha de hoy
	// Cadena Año
	var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))
	// Cadena Mes
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))
	// Cadena Día
	var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))
	
	if (Fecha.length < 10){
	    alert ('Fecha inicio inválida');
		document.frm.fecha_ini.value="";
		document.frm.fecha_ini.focus();
		return false
	}
	

	// Valido el año
	if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
        	alert('Fecha inicio inválida');
			document.frm.fecha_ini.value="";
			document.frm.fecha_ini.focus();
		return false
	}
	// Valido el Mes
	if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
		alert('Fecha inicio inválida');
		document.frm.fecha_ini.value="";
		document.frm.fecha_ini.focus();
		return false
	}
	// Valido el Dia
	if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
		alert('Fecha inicio inválida');
		document.frm.fecha_ini.value="";
		document.frm.fecha_ini.focus();
		return false
	}
	if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {
		if (Mes==2 && Dia > 28 || Dia>30) {
			alert('Fecha inicio inválida');
			document.frm.fecha_ini.value="";
			document.frm.fecha_ini.focus();
			return false
		}
	}	
  //para que envie los datos, quitar las  2 lineas siguientes
  //alert("Fecha correcta.")
  return false	
}


function validafechafin(){
    var Fecha = new String(document.frm.fecha_fin.value)
	//var Fecha= new String(Cadena)	// Crea un string
	var RealFecha= new Date()	// Para sacar la fecha de hoy
	// Cadena Año
	var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))
	// Cadena Mes
	var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))
	// Cadena Día
	var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))
	
	if (Fecha.length < 10){
	    alert ('Fecha de término inválida');
		document.frm.fecha_fin.value="";
		document.frm.fecha_fin.focus();
		return false
	}
	

	// Valido el año
	if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){
        	alert('Fecha de término inválida');
			document.frm.fecha_fin.value="";
			document.frm.fecha_fin.focus();
		return false
	}
	// Valido el Mes
	if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){
		alert('Fecha de término inválida');
		document.frm.fecha_fin.value="";
		document.frm.fecha_fin.focus();
		return false
	}
	// Valido el Dia
	if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){
		alert('Fecha de término inválida');
		document.frm.fecha_fin.value="";
		document.frm.fecha_fin.focus();
		return false
	}
	if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {
		if (Mes==2 && Dia > 28 || Dia>30) {
			alert('Fecha de término inválida');
			document.frm.fecha_fin.value="";
			document.frm.fecha_fin.focus();
			return false
		}
	}	
  //para que envie los datos, quitar las  2 lineas siguientes
  //alert("Fecha correcta.")
  return false	
}



function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

<script language="javascript" type="text/javascript">
//Validacion de campos de texto no vacios by Mauricio Escobar
//
//Iván Nieto Pérez
//Este script y otros muchos pueden
//descarse on-line de forma gratuita
//en El Código: www.elcodigo.com


//*********************************************************************************
// Function que valida que un campo contenga un string y no solamente un " "
// Es tipico que al validar un string se diga
//    if(campo == "") ? alert(Error)
// Si el campo contiene " " entonces la validacion anterior no funciona
//*********************************************************************************

//busca caracteres que no sean espacio en blanco en una cadena
function vacio(q) {
        for ( i = 0; i < q.length; i++ ) {
                if ( q.charAt(i) != " " ) {
                        return true
                }
        }
        return false
}

//valida que el campo no este vacio y no tenga solo espacios en blanco
function validaformulario() {
        
        if( vacio(document.frm.titulo.value) == false ) {
                alert("Debe ingresar título de la planificación.")
				document.frm.titulo.value="";
			    document.frm.titulo.focus();
			    return false                
        }else{
		
		        if( vacio(document.frm.descripcion.value) == false ) {
					alert("Debe ingresar descripción de la planificación.")
					document.frm.descripcion.value="";
					document.frm.descripcion.focus();
					return false 
				}else{
		
                      document.frm.submit();
                      return false
				}	  
        }
        
}

</script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
        </style>
</head>
<style>
.tachado {
    text-decoration: line-through;
}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif}
</style>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
                       <? $menu_lateral="3_1";?> <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo antiguo  -->
								  
<FORM method="post" name="frm" action="grabar_planificacion.php">
        <input type="hidden" name="id_ramo" value="<?=$ramo ?>">
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
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
									</strong></FONT>							</TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
									$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
									$result =@pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
									}else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
												exit();
											}
											echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
										}
									}
								?>
									</strong></FONT></TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>SUBSECTOR</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
//									$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
									$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval, prueba_nivel, pct_nivel, modo_eval_pnivel FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
									$result =@pg_Exec($conn,$qry);
									if (pg_numrows($result)!=0){
										$fila10 = @pg_fetch_array($result,0);	
										echo trim($fila10['nombre']);
									}
								?>
									</strong></FONT>							</TD>
						</TR> 
						
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>DOCENTE</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
									
									$qry_pl="SELECT * from empleado where rut_emp in  (select rut_emp from dicta where id_ramo = '$ramo')";
									$result_pl = pg_Exec($conn,$qry_pl);
									if (pg_numrows($result_pl)!=0){
										$fila10 = @pg_fetch_array($result_pl,0);
										$rut_emp = $fila10['rut_emp'];
										$nombre_emp = $fila10['nombre_emp'];
										$paterno    = $fila10['ape_pat'];
										$materno    = $fila10['ape_mat'];
									}
																		
									echo "$nombre_emp $paterno $materno";									
								?>
								<input type="hidden" name="rut_docente" value="<?=$rut_emp ?>">
								</strong></FONT></TD>
						</TR>
						
						
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>PERIODO</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								
							  
									<?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_periodo)=".$periodo."))  order by id_periodo";
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
													$id_periodo = $fila1['id_periodo'];
													$nombre_periodo = $fila1['nombre_periodo'];
													?>
													<?=$nombre_periodo ?>
													<?
												}
											}
										};
									?>
								<input type="hidden" name="id_periodo" value="<?=$periodo ?>">
							
								</strong></FONT></TD>
						</TR>                           
                        
					</TABLE>
				</TD>
			</TR>
	</table>
        <br>
        <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td colspan="4" class="tableindex"><div align="center">Planificaci&oacute;n</div></td>
            </tr>
          <tr>
            <td class="tablatit2-1">Fecha Inicio </td>
            <td bgcolor="#FFFFFF"><label>
              <input name="fecha_ini" type="text" id="fecha_ini" size="10" maxlength="12">
              <span class="Estilo1">(01-10-2007)</span></label></td>
            <td class="tablatit2-1">Fecha T&eacute;rmino </td>
            <td bgcolor="#FFFFFF">
				
			<input name="fecha_fin" type="text" id="fecha_fin" onFocus="validafechaini()" size="10" maxlength="12"> 
              <span class="Estilo1">(01-10-2007)</span></td>
          </tr>
          <tr>
            <td class="tablatit2-1">T&iacute;tulo</td>
            <td colspan="3" bgcolor="#FFFFFF"><label>
              <input name="titulo" type="text" id="titulo" onFocus="validafechafin()" size="60">
            </label></td>
            </tr>
          <tr>
            <td class="tablatit2-1">Descripci&oacute;n</td>
            <td colspan="3" bgcolor="#FFFFFF"><label>
              <textarea name="descripcion" cols="57" rows="9" id="descripcion"></textarea>
            </label></td>
            </tr>
          <tr>
            <td colspan="4" bgcolor="#FFFFFF"><div align="center">
              <label>
              <input type="button" class="Botonxx" name="Submit" value="Guardar Planificaci&oacute;n" onClick="validaformulario()">
              </label>
              <label>
              <input name="Submit2" class="Botonxx" type="button" onClick="MM_goToURL('parent','planificacion.php?id_ramo=<?=$ramo ?>');return document.MM_returnValue" value="Volver">
              </label>
            </div></td>
            </tr>
        </table>
        <br>
<br>
</strong>
</form>
<br>


				  
				  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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

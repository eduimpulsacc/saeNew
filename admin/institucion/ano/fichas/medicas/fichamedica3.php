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
	
 		 $qry="SELECT * FROM ficha_medicanew3 WHERE rut_alumno=".$alumno;
		$result =@pg_Exec($conn,$qry);
		/*if (!$result){
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{*/
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				/*if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}*/
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

function activa(nombre,tipo){
var cadena = nombre.split("_");
var elemento = cadena[1];

if(tipo==1){
 document.getElementById("txt_"+elemento).readOnly = false;
}
else if(tipo==0){
 document.getElementById("txt_"+elemento).readOnly = true;
 document.getElementById("txt_"+elemento).value = "";
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
	<FORM method=post name="frm" action="ing_fichamedica3.php">
	<? }else{?>
	<FORM method=post name="frm" action="ing_fichamedica3.php?tipo_hoja=<?=$tipo_hoja?>&c_ano=<?=$ano?>&c_curso=<?=$c_curso?>&c_alumno=<?=$alumno?>">
	<? }?>
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 >
			<tr>
			  <td align="right">
               <?php

               if(pg_numrows($r2)==0 ){ 
              if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==15 || $_PERFIL==6)
			  {
			  ?>
              <input type="submit" name="Submit" value="GUARDAR" class="BotonXX"  />    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <?php } else if(pg_numrows($r2)>=0 ){
				   if($_PERFIL==0 ||  $_PERFIL==15){
					  ?>
					   <input type="submit" name="Submit" value="GUARDAR" class="BotonXX"  />    
					   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <?
					  }
				 }
			 
			 
			  }?> 
              <?php if($_PERFIL!=15 && $_PERFIL!=16){?> 
			    <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('pfichaMedica3.php?c_curso=<?=$c_curso?>&c_alumno=<?=$alumno ?>&id_ficha=<?php echo $_FICHAM ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
                <?php }?></td>
			</tr>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO</strong>								</FONT>							</TD>
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
									</strong>								</FONT>							<input type="hidden" name="id_ano" id="id_ano" value="<?php echo $ano ?>"></TD>
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
                          $fecha_nac = $fila1['fecha_nac'];
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>								</FONT>							<input type="hidden" name="rut_alumno" id="rut_alumno" value="<?php echo $alumno ?>"></TD>
						</TR>
						<TR>
						  <TD align=left><FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong></FONT></TD>
						  <TD><FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong></FONT></TD>
						  <TD>
                          <? 				 $sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_GET["c_curso"];
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);
											
											?>
                          
                          <FONT face="arial, geneva, helvetica" size=2>
									<strong>
									<input type="hidden" name="id_curso" id="id_curso" value="<?php echo $c_curso ?>"><?php echo CursoPalabra($_GET["c_curso"], 1, $conn);?>
									</strong></FONT></TD>
						  </TR>
              <tr>
                <td align="left">
                  <font face="arial, geneva, helvetica" size=2><strong>FECHA DE NACIMIENTO</strong></font>
                </td>
                <td>
                  <font face="arial, geneva, helvetica" size=2><strong>:</strong></font>
                </td>
                <td>
                 <FONT face="arial, geneva, helvetica" size=2><strong><?php echo cambioFD($fecha_nac); ?></strong></FONT>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <font face="arial, geneva, helvetica" size=2><strong>RUT</strong></font>
                </td>
                <td>
                  <font face="arial, geneva, helvetica" size=2><strong>:</strong></font>
                </td>
                <td>
                  <FONT face="arial, geneva, helvetica" size=2><strong><?php echo $alumno."-".$fila1['dig_rut']?></strong></FONT>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <font face="arial, geneva, helvetica" size=2><strong>EDAD</strong></font>
                </td>
                <td>
                  <font face="arial, geneva, helvetica" size=2><strong>:</strong></font>
                </td>
                <td>
                   <FONT face="arial, geneva, helvetica" size=2><strong><?php 
                    echo CalcularEdad($fecha_nac);
                   ?></strong></FONT>
                </td>
              </tr>
              <tr>
                <td align="left">
                  <font face="arial, geneva, helvetica" size=2><strong>DOMICILIO</strong></font>
                </td>
                <td>
                  <font face="arial, geneva, helvetica" size=2><strong>:</strong></font>
                </td>
                <td>
                   <FONT face="arial, geneva, helvetica" size=2><strong><?php 

                  $getComuna ="SELECT nom_com FROM COMUNA WHERE cor_com=".$fila1['ciudad'];
                      $result =@pg_Exec($conn,$getComuna);
                      if (!$result) {
                        error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
                      }else{
                        if (pg_numrows($result)!=0){
                          $comuna = @pg_fetch_array($result,0);  
                          if (!$comuna){
                            error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
                            exit();
                          }
                          
                        }
                      }



                    echo $fila1['calle']." #".$fila1['nro'].", ".$comuna['nom_com'];
                   ?></strong></FONT>
                </td>
              </tr>
					</TABLE>
					<br>
				</TD>
			</TR>
			<TR height=15>
				<TD>
                <table width="100%" border="0">
  <tr>
    <td colspan="6">
      <input type="hidden" name="id_ficha" id="id_ficha" value="<?php echo $_FICHAM ?>">
    </td>
  </tr>
  <tr>
    <td colspan="6">Telefonos de contacto en caso de emergencia</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="tableindex">Instituci&oacute;n Particular de Seguro Escolar (Todos los alumnos tienen Seguro Escolar p&uacute;blico por ley N&deg; 17.644 y Decreto Supremo N&deg; 313)</td>
  </tr>
  <tr>
    <td colspan="6">
      <input name="txt_seguropart" type="text" id="txt_seguropart" size="80" value="<?php echo $fila['txt_seguropart'] ?>">
    </td>
  </tr>
  
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">
    <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
      <tr class="tableindex">
        <td colspan="3" width="50%">Nombre de la Madre</td>
        <td colspan="3" width="50%">Nombre del Padre</td>
        </tr>
      <tr class="textosimple">
        <td colspan="3">
        <?php  $sqlmadre="select apoderado.* from apoderado, tiene2 where tiene2.rut_apo =apoderado.rut_apo and tiene2.rut_alumno = $alumno and apoderado.relacion=2";
		$rsmadre =@pg_Exec($conn,$sqlmadre);
		 $fila_madre = pg_fetch_array($rsmadre,0);
		 echo strtoupper($fila_madre['nombre_apo']." ".$fila_madre['ape_pat']." ".$fila_madre['ape_mat']);
		 ?>
          &nbsp;
        </td>
        <td colspan="3">
         <?php  $sqlpadre="select apoderado.* from apoderado, tiene2 where tiene2.rut_apo =apoderado.rut_apo and tiene2.rut_alumno = $alumno and apoderado.relacion=1";
		$rspadre =@pg_Exec($conn,$sqlpadre);
		 $fila_padre = pg_fetch_array($rspadre,0);
		 echo strtoupper($fila_padre['nombre_apo']." ".$fila_padre['ape_pat']." ".$fila_padre['ape_mat']);
		 ?>&nbsp;
        </td>
        </tr>
      <tr class="textosimple">
        <td width="17%"><?php echo $fila_madre['celular'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['fono_pega'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_madre['telefono'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['celular'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['fono_pega'] ?>&nbsp;</td>
        <td width="17%"><?php echo $fila_padre['telefono'] ?>&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td width="17%" align="center">Celular</td>
        <td width="17%" align="center">Fono Trabajo</td>
        <td width="17%" align="center">Fono Casa</td>
        <td width="17%" align="center">Celular</td>
        <td width="17%" align="center">Fono Trabajo</td>
        <td width="17%" align="center">Fono Casa</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="100%" border="1" cellspacing="0" bordercolor="#000000">
      <tr>
        <td colspan="6" class="tableindex">Nombre de personas alternativas en caso de no ubicar padres (en par&eacute;ntesis indicar parentesco)</td>
        </tr>
      <tr>
        <td colspan="3"><input name="nombre_alt1" type="text" id="nombre_alt1" size="40" value="<?php echo $fila['nombre_alt1'] ?>"></td>
        <td colspan="3"><input name="nombre_alt2" type="text" id="nombre_alt2" size="40" value="<?php echo $fila['nombre_alt2'] ?>"></td>
      </tr>
      <tr>
        <td align="center"><input name="cel_alt1" type="text" id="cel_alt1" size="15" value="<?php echo $fila['celular_alt1'] ?>"></td>
        <td align="center"><input name="fonotrab_alt1" type="text" id="fonotrab_alt1" size="15" value="<?php echo $fila['fonotrab_alt1'] ?>"></td>
        <td align="center"><input name="fonocasa_alt1" type="text" id="fonocasa_alt1" size="15" value="<?php echo $fila['fonocasa_alt1'] ?>"></td>
        <td align="center"><input name="cel_alt2" type="text" id="cel_alt2" size="15" value="<?php echo $fila['celular_alt2'] ?>"></td>
        <td align="center"><input name="fonotrab_alt2" type="text" id="fonotrab_alt2" size="15" value="<?php echo $fila['fonotrab_alt2'] ?>"></td>
        <td align="center"><input name="fonocasa_alt2" type="text" id="fonocasa_alt2" size="15" value="<?php echo $fila['fonocasa_alt2'] ?>"></td>
        </tr>
      <tr class="textosimple">
        <td align="center">Celular</td>
        <td align="center">Fono Trabajo</td>
        <td align="center">Fono Casa</td>
        <td align="center">Celular</td>
        <td align="center">Fono Trabajo</td>
        <td align="center">Fono Casa</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="tableindex"><p>ANTECEDENTES DE SALUD (En los casos afirmativos indicar detalles abajo en observaciones)</p></td>
    </tr>
  
  <tr>
    <td colspan="6" valign="top">
    <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
      <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
         <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
          <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
         <td width="170">Atenci&oacute;n</td>
         <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
         <td width="170">Atenci&oacute;n</td>
      </tr>
      <tr class="textosimple">
      <td width="20" align="center"><label>
          <input type="radio" name="bool_alergia" id="radio" value="1" <?php echo ($fila['bool_alergia']==1)?"checked":"" ?>>
        </label></td>
        <td width="20" align="center"><input name="bool_alergia" type="radio" id="radio2" value="0" <?php echo ($fila['bool_alergia']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Alergias</td>
        
       
        <td width="20" align="center"><input type="radio" name="bool_afeccioncardiaca" id="radio9" value="1" <?php echo ($fila['bool_afeccioncardiaca']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_afeccioncardiaca" type="radio" id="radio10" value="0" <?php echo ($fila['bool_afeccioncardiaca']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
         <td width="170">Afecciones Cardiacas</td>
       
        <td width="20" align="center"><input type="radio" name="bool_alteracionmotriz" id="radio17" value="1" <?php echo ($fila['bool_alteracionmotriz']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_alteracionmotriz" type="radio" id="radio18" value="0" <?php echo ($fila['bool_alteracionmotriz']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td> <td width="170">Alteraciones Motrices</td>

        <td width="20" align="center"><input type="radio" name="medicion_antropometrica" id="radio25" value="1" <?php echo ($fila['medicion_antropometrica']==1)?"checked":""?>></td>
        <td width="20" align="center"><input name="medicion_antropometrica" type="radio" id="radio26" value="0" <?php echo ($fila['medicion_antropometrica']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Autoriza a medici&oacute;n antropom&eacute;trica</td>
      </tr>
      <tr class="textosimple">
        <td width="20" align="center"><input type="radio" name="bool_asma" id="radio3" value="1" <?php echo ($fila['bool_asma']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_asma" type="radio" id="radio4" value="0" <?php echo ($fila['bool_asma']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Afecciones Respiratorias</td>
        
        <td width="20" align="center"><input type="radio" name="bool_afeccionrespiratoria" id="radio11" value="1" <?php echo ($fila['bool_afeccionrespiratoria']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_afeccionrespiratoria" type="radio" id="radio12" value="0" <?php echo ($fila['bool_afeccionrespiratoria']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Asma</td>
        
        <td width="20" align="center"><input type="radio" name="bool_cirugia" id="radio19" value="1" <?php echo ($fila['bool_cirugia']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_cirugia" type="radio" id="radio20" value="0" <?php echo ($fila['bool_cirugia']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Interveci&oacute;n Quir&uacute;rgica</td>
        
        <td width="20" align="center"><input type="radio" name="vacuna" id="radio27" value="1" <?php echo ($fila['vacunas_ministeriales']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="vacuna" type="radio" id="radio28" value="0" <?php echo ($fila['vacunas_ministeriales']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Vacunas ministeriales</td>
      </tr>
      <tr class="textosimple">
        <td width="20" align="center"><input type="radio" name="bool_diabetes" id="radio5" value="1" <?php echo ($fila['bool_diabetes']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_diabetes" type="radio" id="radio6" value="0" <?php echo ($fila['bool_diabetes']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Diabetes</td>
        
        
        <td width="20" align="center"><input type="radio" name="bool_afeccioncutanea" id="radio13" value="1" <?php echo ($fila['bool_afeccioncutanea']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_afeccioncutanea" type="radio" id="radio14" value="0" <?php echo ($fila['bool_afeccioncutanea']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Afecciones cut&aacute;neas</td>
        
        <td width="20" align="center"><input type="radio" name="bool_medacamentoabitual" id="radio21" value="1"  <?php echo ($fila['bool_medacamentoabitual']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_medacamentoabitual" type="radio" id="radio22" value="0" <?php echo ($fila['bool_medacamentoabitual']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> ></td>
        <td width="170">Medicamentos Habituales</td>
        
        <td width="20" align="center"><input type="radio" name="sueno" id="radio29" value="1" <?php echo ($fila['trastorno_sueno']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="sueno" type="radio" id="radio30" value="0" <?php echo ($fila['trastorno_sueno']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Trastorno de sueño</td>
      </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><input type="radio" name="bool_epilepsia" id="radio7" value="1" <?php echo ($fila['bool_epilepsia']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input type="radio" name="bool_epilepsia" id="radio8" value="1" <?php echo ($fila['bool_epilepsia']==1)?"checked":"" ?>></td>
         <td width="170">Epilepsia</td>
       
        <td width="20" align="center"><input type="radio" name="bool_alteracionsensorial" id="radio15" value="1" <?php echo ($fila['bool_alteracionsensorial']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_alteracionsensorial" type="radio" id="radio16" value="0" <?php echo ($fila['bool_alteracionsensorial']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
         <td width="170">Alteraciones Sensoriales</td>
        
        <td width="20" align="center"><input type="radio" name="bool_otrasenfermedades" id="radio23" value="1" <?php echo ($fila['bool_otrasenfermedades']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_otrasenfermedades" type="radio" id="radio24" value="0" <?php echo ($fila['bool_otrasenfermedades']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Otras Enfermedades</td>

        <td colspan="3">
          Grupo sangu&iacute;neo: &nbsp;
          <input type="text" name="blood_group" id="bloodGroup" size="20" value="<?php echo $fila['txt_sangre'] ?>" style="text-align: left;">
        </td>
        
        
      </tr>
      <tr class="textosimple">
        <td align="center"><input type="radio" name="bool_desmayo3m" id="radio53" value="1" <?php echo ($fila['bool_desmayo3m']==1)?"checked":"" ?>></td>
        <td align="center"><input type="radio" name="bool_desmayo3m" id="radio54" value="1" <?php echo ($fila['bool_desmayo3m']==1)?"checked":"" ?>></td>
        <td colspan="4">El alumno ha tenido alguna vez p&eacute;rdia de consciencia por m&aacute;s de 3 minutos</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr class="textosimple">
        <td colspan="6">Enfermedad m&aacute;s recurrente durante el a&ntilde;o </td>
        <td colspan="6">Qu&eacute; medicamentos toma habitualmente cuando est&aacute; enfermo</td>
        </tr>
      <tr class="textosimple">
        <td colspan="6">
          <input name="enf_recurrente" type="text" id="enf_recurrente" size="50" value="<?php echo $fila['enf_recurrente'] ?>" ></td>
        <td colspan="6"><input name="med_recurrente" type="text" id="med_recurrente" size="50" value="<?php echo $fila['med_recurrente'] ?>" ></td>
        </tr>
        <tr class="textosimple">
        <td colspan="6">Medicamentos tratamiento alergias</td>
        <td colspan="6">&nbsp;</td>
        </tr>
      <tr class="textosimple">
        <td colspan="6">
          <input name="med_alergias" type="text" id="med_alergias" size="50" value="<?php echo $fila['med_alergias'] ?>" ></td>
        <td colspan="6">&nbsp;</td>
        </tr>
    </table></td>
    </tr>
    
    
  <tr>
    <td colspan="6">&nbsp;</td>
    </tr>
   <tr>
    <td colspan="6" class="tableindex"><p>RIESGO CARDIOVASCULAR (Se&ntilde;ale si ha presentado s&iacute;ntoma extra&ntilde;os durante o inmediatamente despu&eacute;s de hacer ejercicios)</p></td>
    </tr>
  
  <tr>
    <td colspan="6"><table width="100%" border="1" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
        
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">Atenci&oacute;n</td>
        <td width="440">DETALLES</td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><input type="radio" name="bool_mareos" id="radio25" value="1" onClick="activa(this.name,1)"  <?php echo ($fila['bool_mareos']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_mareos" type="radio" id="radio26" value="0" <?php echo ($fila['bool_mareos']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> onClick="activa(this.name,0)"></td>
        <td width="170">Mareos</td>
        <td width="440"><input name="txt_mareos" type="text" id="txt_mareos" size="40" value="<?php echo $fila['txt_mareos'] ?>" <?php  echo ($fila['bool_mareos']==0)?"readonly":""; ?>></td>
        </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><input type="radio" name="bool_desmayos" id="radio27" value="1"  <?php echo ($fila['bool_desmayos']==1)?"checked":"" ?> onClick="activa(this.name,1)"></td>
        <td width="20" align="center"><input name="bool_desmayos" type="radio" id="radio28" value="0" <?php echo ($fila['bool_desmayos']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> onClick="activa(this.name,0)"></td>
         <td width="170">Desmayos</td>
        <td width="440"><input name="txt_desmayos" type="text" id="txt_desmayos" size="40" value="<?php echo $fila['txt_desmayos'] ?>" <?php  echo ($fila['bool_desmayos']==0)?"readonly":""; ?>></td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><input type="radio" name="bool_dolorpecho" id="radio29" value="1"  <?php echo ($fila['bool_dolorpecho']==1)?"checked":"" ?> onClick="activa(this.name,1)"></td>
        <td width="20" align="center"><input name="bool_dolorpecho" type="radio" id="radio30" value="0" <?php echo ($fila['bool_dolorpecho']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> onClick="activa(this.name,0)"></td>
        <td width="170">Dolor al pecho</td>
        <td width="440"><input name="txt_dolorpecho" type="text" id="txt_dolorpecho" size="40" value="<?php echo $fila['txt_dolorpecho'] ?>" <?php  echo ($fila['bool_dolorpecho']==0)?"readonly":""; ?>></td>
        </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><input type="radio" name="bool_difrespiratoria" id="radio31" value="1"  <?php echo ($fila['bool_difrespiratoria']==1)?"checked":"" ?> onClick="activa(this.name,1)"></td>
        <td width="20" align="center"><input name="bool_difrespiratoria" type="radio" id="radio32" value="0" <?php echo ($fila['bool_difrespiratoria']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> onClick="activa(this.name,0)"></td>
        <td width="170">Dificultad respiratoria grave</td>
        <td width="440"><input name="txt_difrespiratoria" type="text" id="txt_difrespiratoria" size="40" value="<?php echo $fila['txt_boolrespiratoria'] ?>" <?php  echo ($fila['bool_difrespiratoria']==0)?"readonly":""; ?>></td>
        </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><input type="radio" name="bool_antecedentefamiliar" id="radio33" value="1"  <?php echo ($fila['bool_antecedentefamiliar']==1)?"checked":"" ?> onClick="activa(this.name,1)"></td>
        <td width="20" align="center"><input name="bool_antecedentefamiliar" type="radio" id="radio34" value="0" <?php echo ($fila['bool_antecedentefamiliar']==0 || $fila['id_fichamedica']=="")?"checked":"" ?> onClick="activa(this.name,0)"></td>
         <td width="170">Antecedentes familiares</td>
        <td width="440"><input name="txt_antecedentefamiliar" type="text" id="txt_antecedentefamiliar" size="40" value="<?php echo $fila['txt_antecedentefamiliar'] ?>"  <?php  echo ($fila['bool_antecedentefamiliar']==0)?"readonly":""; ?>></td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td colspan="6" class="tableindex"><p>MEDICAMENTOS (La enfermer&iacute;a del colegio no administra medicamentos salvo indicaci&oacute;n m&eacute;dica certificada. En caso de dolor mayor se podr&iacute;a administrar lo siguiente, previa autorizaci&oacute;n se&ntilde;alada en esta ficha. Dosificaci&oacute;n seg&uacute;n peso)</p></td>
    </tr>
  <tr>
    <td colspan="6" valign="top"><table width="100%" border="1" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#cccccc" class="textonegrita">
       
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
         <td width="170">Autorizo administrar</td>
         <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
        <td width="170">&nbsp;</td>
        
       
        <td width="20" align="center">SI</td>
        <td width="20" align="center">NO</td>
         <td width="170">&nbsp;</td>
      </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><input type="radio" name="bool_paracetamolgo" id="radio35" value="1" <?php echo ($fila['bool_paracetamolgo']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_paracetamolgo" type="radio" id="radio36" value="0"<?php echo ($fila['bool_paracetamolgo']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
         <td width="170">Paracetamol gotas</td>
        
        <td width="20" align="center"><input type="radio" name="bool_ibuprofeno" id="radio41" value="1" <?php echo ($fila['bool_ibuprofeno']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_ibuprofeno" type="radio" id="radio42" value="0" <?php echo ($fila['bool_ibuprofeno']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
         <td width="170">Ibuprofeno 400 mg.</td>
        
        <td width="20" align="center"><input type="radio" name="bool_salbutamol" id="radio47" value="1" <?php echo ($fila['bool_salbutamol']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_salbutamol" type="radio" id="radio48" value="0"<?php echo ($fila['bool_salbutamol']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
       <td width="170">Salbutamol Inhalador</td>
       </tr>
      <tr class="textosimple">
       
        <td width="20" align="center"><input type="radio" name="bool_paracetamolgr" id="radio37" value="1" <?php echo ($fila['bool_paracetamolgr']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_paracetamolgr" type="radio" id="radio38" value="0" <?php echo ($fila['bool_paracetamolgr']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
         <td width="170">Paracetamol 80-160-500 mg.</td>
         
        <td width="20" align="center"><input type="radio" name="bool_diclofenaco" id="radio43" value="1" <?php echo ($fila['bool_diclofenaco']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_diclofenaco" type="radio" id="radio44" value="0" <?php echo ($fila['bool_diclofenaco']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Diclofenaco 50 mg.</td>
        <td width="20" align="center"><input type="radio" name="bool_viadil" id="radio49" value="1" <?php echo ($fila['bool_viadil']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_viadil" type="radio" id="radio50" value="0" <?php echo ($fila['bool_viadil']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Viadil gotas</td>
      </tr>
      <tr class="textosimple">
        
        <td width="20" align="center"><input type="radio" name="bool_predual" id="radio39" value="1" <?php echo ($fila['bool_predual']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_predual" type="radio" id="radio40" value="0" <?php echo ($fila['bool_predual']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Predual</td>
        
        <td width="20" align="center"><input type="radio" name="bool_loratadina" id="radio45" value="1" <?php echo ($fila['bool_loratadina']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_loratadina" type="radio" id="radio46" value="0" <?php echo ($fila['bool_loratadina']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
        <td width="170">Loratadina 10 mg.</td>
        
        <td width="20" align="center"><input type="radio" name="bool_valpin" id="radio51" value="1" <?php echo ($fila['bool_valpin']==1)?"checked":"" ?>></td>
        <td width="20" align="center"><input name="bool_valpin" type="radio" id="radio52" value="0" <?php echo ($fila['bool_valpin']==0 || $fila['id_fichamedica']=="")?"checked":"" ?>></td>
      <td width="170">Valpin gotas</td>
      </tr>
      <tr class="textosimple">
        <td align="center"><input type="radio" name="aut_enfermeria" id="radio55" value="1" <?php echo ($fila['aut_enfermeria']==1)?"checked":"" ?>></td>
        <td align="center"><input name="aut_enfermeria" type="radio" id="radio56" value="0" <?php echo ($fila['aut_enfermeria']==0 || $fila['aut_enfermeria']=="")?"checked":"" ?>></td>
        <td colspan="7">Autoriza a que si hija(a) pueda ser atendido en la unidad de enfermer&iacute;a del colegio en caso de requerir atenci&oacute;n primaria (solo ciudados b&aacute;sicos) por ca&iacute;da, golpe o dolor que le impida estar en la sala de clases, durante su jornada escolar</td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td colspan="6" class="tableindex"><p>OBSERVACIONES (Anote detalle de afecciones o cualquier otro antecedente de salud que quiera agregar)</p></td>
    </tr>
  <tr>
    <td colspan="6"><label>
      <textarea name="observaciones" cols="80" rows="5" id="observaciones" style="height: 80px; min-height: 80px; max-height: 120px;"><?php echo $fila['observaciones'] ?></textarea>
    </label></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
                </table>

                <br />
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

<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	
	
?>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
					
<SCRIPT LANGUAGE="JavaScript">
function valida(form){
	for (x=0;x<=form.length-1;x++){
		if (form[x].name.substr(0,5)=="order"){
			if(!chkVacio(form[x],'Ingrese orden del subsector')){
				return false;
			};
		};
	};
	return true;
};
</SCRIPT>
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
        function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=1&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

</script>

			
	
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

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
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
								  
<table width="90%" height="" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="" align="center" valign="top">&nbsp;  </td>
  </tr>
</table>
<center>

<br>
<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=1  width="90%">
	<TR>
		<TD width="110" align=left>
			<FONT face="arial, geneva, helvetica" size=2>
				<strong>INSTITUCION</strong>
			</FONT>
		</TD>
		<TD width="12">
			<FONT face="arial, geneva, helvetica" size=2>
				<strong>:</strong>
			</FONT>
		</TD>
		<TD width="510">
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
							error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
						}else{
							if (pg_numrows($result)!=0){
								$fila = @pg_fetch_array($result,0);	
								if (!$fila){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
								echo trim($fila['nro_ano']);
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
			<form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		  
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>	 
				</strong>
			</FONT>
		</TD></form>
	</TR>
	
<form action="ProcesoOrdenar.php" name="FrmOrder" method="post">	
	<TR>
	  <TD colspan="3" align="right">
	    <input class="botonXX"  type="submit" name="Submit" value="GUARDAR" onClick="return valida(this.form);">
	    <input class="botonXX"  type="button" name="Volver" value="VOLVER" onClick=document.location="listarRamos.php3">      </TD>
    </TR>
</TABLE>
<table width="650" border="0" cellspacing="1" cellpadding="3">
  <tr height="20" class="tableindex">
	<td align="center" colspan="2">
		ASIGNATURAS DEL CURSO
	</td>
  </tr>	
  <tr class="tablatit2-1">
    <td align="center"> NOMBRE</td>
    <td align="center"> ORDEN</td>
  </tr>
  <?
  $sqlSubsector = "select ramo.id_ramo, ramo.cod_subsector, subsector.nombre, ramo.id_orden ";
  $sqlSubsector = $sqlSubsector . "from ramo, subsector, curso where curso.id_curso = ".$curso." and ramo.id_curso = curso.id_curso and subsector.cod_subsector = ramo.cod_subsector order by id_orden ";
  $rsSubsector =@pg_Exec($conn,$sqlSubsector);  
  for($i=0 ; $i < @pg_numrows($rsSubsector) ; $i++){
    $fSubsector = @pg_fetch_array($rsSubsector,$i);
	$subsector = $fSubsector['nombre'];
	$orden = $fSubsector['id_orden'];
	$ramo = $fSubsector['id_ramo'];
  ?>	
  <input name="id_ramo[<? echo $i?>]" type="hidden" value="<? echo $ramo?>">
  <tr>
    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $subsector;?></strong></font></td>
    <td align="center"><input name="order[<? echo $i?>]" type="text" value="<? echo trim($orden)?>" size="5" maxlength="2"></td>
  </tr>
  <? } ?>
	  
   
</table>
<input name="cantidad" type="hidden" value="<? echo @pg_numrows($rsSubsector)?>">
</form>
</center>
<?
pg_close($conn);
?>
								  
								  <!-- fin cdigo nuevo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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

<?php require('../../../../util/header.inc');
      require('../../../../util/LlenarCombo.php3');
	  require('../../../../util/SeleccionaCombo.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$_POSP          =4;
	$_bot           =5;

	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto ";
	$sqlCurso = $sqlCurso . " from institucion, ano_escolar, curso, tipo_ensenanza ";
	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano and curso.id_curso = $curso";
	$sqlCurso = $sqlCurso . "and curso.ensenanza = tipo_ensenanza.cod_tipo";
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);	
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
     function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../curso/seteaCurso.php3?caso=11&p=11&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=9&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
</script>
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- INICIO CODIGO NUEVO-->
								  
<center>
<table width="95%" height="" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="" align="center" > 
      <? include("../../../../cabecera/menu_inferior.php"); ?> 
	  </td>
  </tr>
</table>

<FORM method=post name="frm" action="procesoRamoInscribir.php">

<table width="95%" border="0" cellspacing="1" cellpadding="3">

  <tr>
    <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>
			
			
											<?php
												$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
												$result =@pg_Exec($conn,$qry);
												if (!$result) {
													error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
													exit();
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
			
			</strong></FONT></TD>
		</TR>
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>
			
			<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."</option>";
                              }
							} ?>
							</select>
				<? }	?>
			
			
			</strong></FONT></TD></form>
		</TR>
		<TR>
			<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></TD>
			<TD><FONT face="arial, geneva, helvetica" size=2><strong>
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
					</strong></FONT>
			</TD></form>
		</TR>
		
	</TABLE></td>
  </tr>
</table >
<br>
<br>
<TABLE align="center" width="50%">
<TR>
	<TD><FONT face="arial, geneva, helvetica" size=2>CLAVES DE APODERADOS</font></TD>
</TR>
<TR>
	<TD><FONT face="arial, geneva, helvetica" size=2>CLAVES DE ALUMNOS</font></TD>
</TR>
</TABLE>



								  
								  <!--FIN CODIGO NUEVO --> </td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

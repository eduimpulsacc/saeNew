<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--

function ChequearTodos(chkbox)
{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var elemento = document.forms[0].elements[i];
		if (elemento.type == "checkbox")
		{
			elemento.checked = chkbox.checked
		}
	}
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
     function enviapag(form){
		    var curso, frmModo; 
			curso=form.cmb_curso.value;
			cmb_acti=form.cmb_acti.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="muestra_actextra.php"
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function imprSelec(nombre)
{
  var ficha = document.getElementById(nombre);
  var ventimp = window.open(' ', 'popimpr');
  ventimp.document.write( ficha.innerHTML);
  ventimp.document.close();
 ventimp.print( );
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>

          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
                <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>		
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=3; 
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <form name="form1" method="post" action="procesa_actextra.php">
					  <div align="center">
					  <table>
                          <tr class="textosimple">
                            <td align="center">&nbsp;</td>
                            <td align="center"><input type="button" value="Volver" class="botonxx" onClick="window.location.href='hoja_de_vida.php?cmb_curso=<?= $_GET["curso"]?>'"></td>
                            <td align="center">
							<input name="button3" TYPE="button" class="botonXX" onClick="MM_openBrWindow('pcita_apo.php?curso=<?= $_GET["curso"]?>&alumno=<?= $alumno?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
							</td>
                          </tr>
					  </table>
					  </div>
						<br>
					    <DIV ID="seleccion">
						<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">	
						<table width="714" border="0" align="center">
                          <tr>
                            <td width="704"><table align="left" border="0">
                              <tr>
                                <td align=left><font face="arial, geneva, helvetica" size=2> <strong>ALUMNO</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>
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
												?>
                                </strong></font></td>
                              </tr>
                              <tr>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>RUT ALUMNO</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>
                                  <?= $fila1['rut_alumno']?>
      -
      <?= $fila1['dig_rut']?>
                                </strong></font></td>
                              </tr>
                              <tr>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>FECHA DE NACIMIENTO</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>
                                  <?= date("d-m-Y",strtotime($fila1['fecha_nac']))?>
                                </strong></font></td>
                              </tr>
                              <? $sqlcurso="select * from curso where id_ano=".$ano." and id_curso=".$_GET["curso"];
											$resultcurso =@pg_Exec($conn,$sqlcurso);
											$filacurso = @pg_fetch_array($resultcurso,0);	
										?>
                              <tr>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                <td><font face="arial, geneva, helvetica" size=2> <strong>
                                  <?= $filacurso["grado_curso"]." ".$filacurso["letra_curso"]?>
                                </strong></font></td>
                              </tr>
                              <?
											}
										?>
                            </table></td>
                          </tr>
                          <tr>
                            <td><table width="632" height="69" border="0" cellpadding="0" cellspacing="0" align="left">
                              <tr class="tableindex">
                                <td width="209" align="center">APODERADO</td>
                                <td width="116" align="center">FECHA</td>
                                <td width="120" align="center">OBSERVACI&Oacute;N</td>
                              </tr>
                              <? 	$sql="select * from citacion_apo LEFT JOIN tiene2 on citacion_apo.rut_alumno=tiene2.rut_alumno where citacion_apo.rut_alumno=".$_GET["alumno"]." and id_curso=".$_GET["curso"];
									$result =@pg_Exec($conn,$sql);
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila= @pg_fetch_array($result,$i);
									
									$sql_apo="select nombre_apo,ape_pat from apoderado where rut_apo=".$fila["rut_apo"];
									$result2 =@pg_Exec($conn,$sql_apo);
									$fila2= @pg_fetch_array($result2,0);
								?>
                              <tr class="textosimple">
                                <td width="209" align="center"><?= $fila2["nombre_apo"]." ".$fila2["ape_pat"] ?>
&nbsp;</td>
                                <td width="116" align="center">&nbsp;
                                    <?= $fila["fecha"]?></td>
                                <td align="center"><?= $fila["observacion"]?></td>
                              </tr>
                              <? }?>
                              <tr class="textosimple">
                                <td align="center" colspan="4">&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
						<p>&nbsp;</p>
					  </form></td>
					  </div>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	   </td>
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

<?php require('../util/header.inc');

	//--------------------------------

	$institucion	=$_INSTIT;

	$ano			=$_ANO;

	$alumno			=$_ALUMNO;

	$curso			=$_CURSO;

	//-------------------------------

	

	$sqlProfesor = "select * from empleado where empleado.rut_emp ='".$rut_profe."' ";

	$rsProfesor = @pg_Exec($conn,$sqlProfesor);	

	$fProfesor  = @pg_fetch_array($rsProfesor,0); 
	
	$sqlTitulo = "select nombre from empleado_estudios where rut_empleado ='".$rut_profe."'";
	$rsTitulo = @pg_Exec($conn,$sqlTitulo);
	
	$nombre = ucwords(strtolower(trim($fProfesor['ape_pat'])." ".trim($fProfesor['ape_mat'])." ".trim($fProfesor['nombre_emp'])));

	$mail = strtolower(trim($fProfesor['email']));

	$atencion = ucwords(strtolower(trim($fProfesor['atencion'])));

	$foto = $fProfesor['foto'];

	//-------------------------------

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../Sea/cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  
								  
								  

<center>

<table width="650" border="0" cellspacing="1" cellpadding="3">

  <tr>

  <?

		
		

		if (isset($fProfesor['nom_foto2'])){
			
			?>
		
	    <td width="100"><img src="../tmp/<?php echo chop($fProfesor['nom_foto2'])?>" width=87 height="109"></td>

		<? }else{
		
		?>
										    <img src="/fichas/icono_profesores.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="48" height="70" id="ALUMNO">
											<?	}?>

    <td width="535"></td>

  </tr>

</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">

  <TR height=20 class="tableindex">

    <TD align="center" colspan=3>DETALLE DEL PROFESOR</TD>

</table>

<br>

<table width="650" border="0" cellspacing="1" cellpadding="3">

  <tr>

    <td height="71" align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>NOMBRE COMPLETO</strong></font></td>

  </tr>

  <tr>

    <td align="left"><font face="Arial, Helvetica, sans-serif" ><strong><?  echo $nombre ?></strong></font></td>

  </tr>

  <tr>

    <td align="left">&nbsp;</td>

  </tr>

  <tr>

    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>T&Iacute;TULO</strong></font></td>

  </tr>

<?php	for($i=0;$i<@pg_numrows($rsTitulo);$i++)
		{ 
			$fTitulo  = @pg_fetch_array($rsTitulo,$i); ?>
		  <tr>
		    <td align="left"><font face="Arial, Helvetica, sans-serif" ><strong>
			      <?  echo $fTitulo['nombre'] ?>  </strong></font></td>
		  </tr>
<?php 	} ?>

  <tr>

    <td align="left">&nbsp;</td>

  </tr>

  <tr>
    <?php
	if($institucion==9940){
		
		
		}else{
	
	
	?>

    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>CORREO</strong></font></td>

  </tr>

  <tr>

    <td align="left"><font face="Arial, Helvetica, sans-serif" ><strong>
	
  
		
      <a href="mailto:<?  echo $mail ?>"><?  echo $mail ?></a> </strong></font></td>

	<?php
		}
	?>
  </tr>

  <tr>

    <td align="left">&nbsp;</td>

  </tr>  

  <tr>

    <td align="left"><font face="arial, geneva, helvetica" size="1" color="#000000"><strong>HORARIO DE ATENCION </strong></font></td>

  </tr>

  <tr>

    <td align="left"><font face="Arial, Helvetica, sans-serif" ><strong>

      <?  echo $atencion ?>

    </strong></font></td>

  </tr>

</table>

<?

	//--------------------------------

	$sqlInformacion = "select * from info_profesor where rut_emp = '".$rut_profe."' and id_ano = ".$ano." and id_curso = ".$curso." order by id_info desc";

	$rsInformacion =@pg_Exec($conn,$sqlInformacion);

	//--------------------------------

	

?><br>

<table width="650" border="0" cellspacing="1" cellpadding="3">

<TR height=20 class="tableindex">

	<TD align="center" colspan=3>

		INFORMACI&Oacute;N DEL PROFESOR

	</TD>

</table>

<table width="650" border="0" cellspacing="1" cellpadding="3">

  <tr class="tablatit2-1">

    <td>FECHA</td>

    <td>TIPO</td>

    <td>DESCRIPCI&Oacute;N</td>
    
    
  </tr>

  <?

	for($i=0 ; $i < @pg_numrows($rsInformacion) ; $i++){

		$fInformacion = @pg_fetch_array($rsInformacion,$i); 

		$fecha = Cfecha2($fInformacion['fecha']);

		if ($fInformacion['tipo']==1) $tipo = "Informaci&oacute;n General";

		if ($fInformacion['tipo']==2) $tipo = "Fecha de Pruebas";

		$curso_pal = CursoPalabra($curso, 0, $conn);

		$descripcion = strip_tags(trim($fInformacion['descripcion']));

		

  ?>

  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('DetalleInfoProfe.php?id_info=<?php echo trim($fInformacion['id_info']);?>')>

    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fecha;?></strong></font></td>

    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $tipo;?></strong></font></td>

    <td><font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo strip_tags(trim($fInformacion['descripcion']));?></strong></font></td>

  </tr>

  <? } ?>

</table>

</center>


								  
								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../Sea/cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

<?
require('../../../../util/header.inc');
//include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
?>

<html>
<head>
	<title>Utilizaci&oacute;n del calendario</title>

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

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/feriados_roll.gif" name="Image3" width="81" height="30" border="0" id="Image3"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>



<?php //echo tope("../../../../util/");?>

<br>
<br>
<br>
  <table width="64%" border="0" align="center">
    <tr>
      <td><table width="61%" border="0">
          <tr> 
            <td width="34%"><FONT face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></FONT></td>
            <td width="2%"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td width="64%"><FONT face="arial, geneva, helvetica" size=2><strong>
              <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												//if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												//}
 											}
										?>
              </strong></FONT></td>
          </tr>
          <tr>
            <td> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong> 
              </FONT> </td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=2><strong>
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
													$nroAno=trim($fila1['nro_ano']);
												}
											}
										?>
              </strong></FONT></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            
          <td align="right"> 
            <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Button" value="AGREGAR" onClick=document.location="seteaFeriado.php3?caso=2"> 
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="button" name="Submit3" value="VOLVER" onClick=document.location="../ano_escolar.php3"></td>
          </tr>
        </table>

      
        <table width="100%" border="0">
          <tr> 
            
          <td></td>
          </tr>
        </table>
		<table width="100%" border="0" bordercolor="#003b85">
          <tr>
            
          <td bgcolor="#003b85">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>FERIADOS 
            CALENDARIO (no asociados a su instituci&oacute;n)</strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left" bgcolor="#48d1cc"> 
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA</font></td>
        </tr>
        <tr align="center" bgcolor="#48d1cc"> 
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESDE</font></td>
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">HASTA</font></td>
          <td width="60%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESCRIPCI&Oacute;N</font></td>
        </tr>
		<?php
		  	$fecSis=getdate();
			$anoActual=$fecSis["year"];
					$sqlFer="select * from feriados_nac where descripcion not in (select descripcion from feriado where id_ano=".$ano.") order by id_feriado";
					$resultFerNac=pg_Exec($conn,$sqlFer);
					
					for($k=0 ; $k<=pg_numrows($resultFerNac) ; $k++){
					$filaFerNac=@pg_fetch_array($resultFerNac,$k);
					$fecIniFer=$filaFerNac["fecha_inicio"];
					if ($filaFerNac["fecha_fin"]!=0){
						$fecFinFer=$filaFerNac["fecha_fin"];
					}else{
						$fecFinFer="";
					}
					$descFer=$filaFerNac["descripcion"];
					?>
					<tr align="center" bgcolor=#ffffff onClick=go('seteaFeriado.php3?caso=3&id_feriado=<?php echo $filaFerNac["id_feriado"];?>&bool_fer=<?php echo $filaFerNac["bool_fer"];?>') onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $fecIniFer;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $fecFinFer;?></font></td>
					<td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $descFer;?></font></td>
					</tr>
				<?php } ?>
					

      </table>
	  <table width="100%" border="0">
        <tr>
          <td>
            <?php  $sql2="select * from feriado where id_ano=".$ano." order by fecha_inicio";
					$result2=@pg_Exec($conn,$sql2);
						if (!$result2) {
							error('<b> ERROR :</b>Error al acceder a la BD. (7)'.$sql2);
						}

				?>
          </td>
        </tr>
      </table>
      <table width="100%" border="0" bordercolor="#003b85">
          <tr>
          </tr>
        </table>
        <table width="100%" border="0" bordercolor="#003b85">
          <tr>
            
          <td bgcolor="#003b85">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>FERIADOS 
            INGRESADOS (asociados a su instituci&oacute;n)</strong></font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="center">
        <tr align="left" bgcolor="#48d1cc"> 
          <td colspan="3" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHA</font></td>
        </tr>
        <tr align="center" bgcolor="#48d1cc"> 
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESDE</font></td>
          <td width="20%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">HASTA</font></td>
          <td width="60%" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif">DESCRIPCI&Oacute;N</font></td>
        </tr>
        <?php 
		
		for($j=0 ; $j<pg_numrows($result2) ; $j++){
		  $filaFeriado=@pg_fetch_array($result2,$j);
		  $fecIni = $filaFeriado["fecha_inicio"];
		  $fecFin = $filaFeriado["fecha_fin"];
		  $desc = $filaFeriado["descripcion"];
		  
		   ?>
        <tr align="center" bgcolor=#ffffff onClick=go('seteaFeriado.php3?caso=3&id_feriado=<?php echo $filaFeriado["id_feriado"];?>&bool_fer=<?php echo $filaFeriado["bool_fer"];?>') onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'> 
          <td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecIni);//($filaFeriado["fecha_inicio"])?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          <td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo impF ($fecFin);//($filaFeriado["fecha_fin"]);?></font></td>
          <td align="left"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $desc;//$filaFeriado["descripcion"];?></font></td>
        </tr>
        <?php } ?>
      </table>
	
		<table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr>
            <td><hr width="100%" color=#003b85></td>
          </tr>
        </table>
        
      <table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr bgcolor="#48d1cc"> 
          <td align="center"> <table WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0" bgcolor=white>
              <tr> 
                <td align="left"> <font face="arial, geneva, helvetica" size="1" color=black> 
                  <ul>
                    <li>Para asociar un &quot;Feriado Calendario&quot; a su Instituci&oacute;n 
                      haga click sobre la fecha y despu&eacute;s presione &quot;GUARDAR&quot;.</li>
                    <li>Para Modificar un &quot;Feriado Ingresado&quot; haga click 
                      sobre la fecha en el listado.</li>
                    <li>Para agregar un feriado propio presione el bot&oacute;n 
                      &quot;AGREGAR&quot;.</li>
                    <li>Para abandonar la sesión de usuario presionar "CERRAR 
                      SESION".</li>
                  </ul>
                  </font> </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br>
<br>

</body>
</html>
	
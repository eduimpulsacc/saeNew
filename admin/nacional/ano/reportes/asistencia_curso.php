<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../util/header.inc');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 8;  	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="90%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  


<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->



  <form action="" method="get">
<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div align="right">
	<div id="capa0">
      <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('asistencia_curso.php?cmb_curso=<?=$cmb_curso ?>&fecha1=<?=$fecha1 ?>&fecha2=<?=$fecha2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
	 </div>
    </div></td>
  </tr>
</table>
    <table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%">Corporaci&oacute;n</td>
              <td>qweqwe</td>
            </tr>
            <tr>
              <td colspan="2"><hr></td>
              </tr>
            <tr>
              <td>Curso</td>
              <td>qweqw</td>
            </tr>
          </table>
          <?
		  // aqui tomo la informacion del curso //
		  //SELECT DISTINCT <columna1>, <columna2,....> FROM <nombre-tabla1>
		   
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		 ?>  
		        <table width="100%" border="1" cellspacing="0" cellpadding="0">
				<tr>
				  <td><div align="center">Instituci&oacute;n</div></td>
				  <td><div align="center">Ins.</div></td>
				  <td colspan="4"><div align="center">Enero</div></td>
				  <td colspan="4"><div align="center">Febrero</div></td>
				  <td colspan="4"><div align="center">Marzo</div></td>
				  <td colspan="4"><div align="center">Abril</div></td>
				  <td colspan="4"><div align="center">Mayo</div></td>
				  <td colspan="4"><div align="center">Junio</div></td>
				  <td colspan="4"><div align="center">Julio</div></td>
				  <td colspan="4"><div align="center">Agosto</div></td>
				  <td colspan="4"><div align="center">Septiembre</div></td>
				  <td colspan="4"><div align="center">Octubre</div></td>
				  <td colspan="4"><div align="center">Noviembre</div></td>
				  <td colspan="4"><div align="center">Diciembre</div></td>
				  </tr>
				<tr>
				  <td><div align="center"></div></td>
				  <td><div align="center"></div></td>
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				  
				  <td><div align="center">Asistencia</div></td>
				  <td><div align="center">Ausentes</div></td>
				  <td><div align="center">Matr&iacute;cula</div></td>
				  <td><div align="center">% asistencia </div></td>
				</tr>
			 <? 
			 
		     $i = 0;
			 while($i < $num_asis){
			     $fila_asis = pg_fetch_array($res_asis,$i);
				 $rdb_asis = $fila_asis['rdb'];	
				 				  
		         ?>				
				<tr>
				  <td><div align="center"><?=$rdb_asis ?></div></td>
				  <td><div align="center"><img src="1111.jpg" width="15" height="15"></div></td>
				  <?
				  // tomo los correspondientes valores para esta institucion
				  $ii=0;
				  $mes = 1;
				  $asistencia = 0;
			      $ausentes   = 0;
				  $matricula  = 0;
				  while($ii < 12){
				      $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
					  $res_val = pg_Exec($qry);
					  $num_mes = pg_numrows($res_val);
					  $jj = 0;				  
					  while ($jj < $num_mes){
					      $fila_mes = pg_fetch_array($res_val,$jj);
						  $r_asistencia = $fila_mes['asistencia'];
						  $r_ausentes   = $fila_mes['ausentes'];
						  $r_matricula  = $fila_mes['matricula'];
						  
						  $asistencia = $asistencia + $r_asistencia;
						  $ausentes   = $ausentes   + $r_ausentes;
						  $matricula  = $matricula  + $r_matricula;
						  
						  
						  $jj++;
					  }
					  $porcentaje = @round(($asistencia * 100)/$matricula,2);
					  ?>				  
					  <td><div align="center"><?=$asistencia ?></div></td>
					  <td><div align="center"><?=$ausentes ?></div></td>
					  <td><div align="center"><?=$matricula ?></div></td>
					  <td><div align="center"><?=$porcentaje ?></div></td>
					  <?
					  $asistencia = 0;
			          $ausentes   = 0;
				      $matricula  = 0;
					  $porcentaje = 0;
					  $r_asistencia = 0;
					  $r_ausentes   = 0;
					  $r_matricula  = 0;
				  
					  $ii++;
					  $mes++;
				  }
				  ?>		  
				  
				  </tr>
			   
			   <? 
			   $i++;
			 } ?>
			 </table>   
	  		  
		  </td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

</center>
</form>


<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

  
				 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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

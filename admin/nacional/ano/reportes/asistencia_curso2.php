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
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
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



<form action="" method="post">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<div align="right">
	<div id="capa0">
      <input name="button3" type="button" class="botonXX" onClick="MM_openBrWindow('print_asistencia_curso2.php?cmb_curso=<?=$cmb_curso ?>&fecha1=<?=$fecha1 ?>&fecha2=<?=$fecha2 ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" value="IMPRIMIR">
	 </div>
    </div></td>
  </tr>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><br>
          <table width="100%" border="0" cellspacing="1" cellpadding="0">
             <tr>
               <td width="20%" class="cuadro02">Corporaci&oacute;n</td>
               <td class="cuadro01"><?= ($_NOMCORP) ?></td>
              </tr>              
            </tr>
          </table>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
<?
/// colores
$color1  = "#df8486";
$color2  = "#79c0db";
$color3  = "#c1b039";
$color4  = "#0fdfea";
$color5  = "#C7705A";
$color6  = "#CCCC33";
$color7  = "#6699CC";
$color8  = "#666666";
$color9  = "#993333";
$color10 = "#000000";
$color11 = "#009966";
$color12 = "#0099FF";
$color13 = "#996633";
$color14 = "#336666";
$color15 = "#FFCC99";
$color16 = "#CCCC66";
?>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td colspan="2" class="cuadro02">Instituciones</td>
    </tr>
	<?
     $qry_asis = "select distinct rdb from asistencia_instituciones where rdb in (select rdb from corp_instit where estado = 't')";
	 $res_asis = pg_Exec($qry_asis);
	 $num_asis = pg_numrows($res_asis);
	 $j = 1;
     for ($i=0; $i<$num_asis; $i++){
	      $fila_asis   = @pg_fetch_array($res_asis,$i);
		  $rdb_asis    = $fila_asis['rdb'];
		  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
		  $res_inst    = pg_Exec($qry_inst);
		  $fila_inst   = pg_fetch_array($res_inst,0); 
		  $nombre_inst = $fila_inst['nombre_instit'];
		  $color = "color".$j;
		  $color = $$color;
		  	  
		   ?>			
			<tr>
			<td bgcolor="<?=$color ?>" width="10">&nbsp;</td>
			<td class="cuadro01"><?=$nombre_inst ?></td>
			</tr>
		   <?
		   $j++;
	 }
	 ?>	   	
</table>

<?
if ($num_asis!=0){  ?>

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="cccccc">
  <tr>
    <td width="15%" class="cuadro02">&nbsp;</td>
    <td width="20%"  class="cuadro02"><div align="center">Asistencia</div></td>
    <td width="20%"  class="cuadro02"><div align="center">Ausencias</div></td>
    <td width="20%"  class="cuadro02"><div align="center">Matricula</div></td>
    <td width="25%"  class="cuadro02"><div align="center">Porcentaje</div></td>
  </tr>
  <tr>
    <td class="cuadro02">&nbsp;</td>
    <td>
	  <table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
		  <tr>
		  <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td bgcolor="<?=$color ?>" width="33%">&nbsp;</td>
			  <?
			  $j++;  
			  $i++;
	       }
		   ?>	
	      </tr>
	   </table>	  </td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td bgcolor="<?=$color ?>" width="33%">&nbsp;</td>
			  <?
			  $j++;  
			  $i++;
	       }
		   ?>	
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td bgcolor="<?=$color ?>" width="33%">&nbsp;</td>
			  <?
			  $j++;  
			  $i++;
	       }
		   ?>	
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td bgcolor="<?=$color ?>" width="33%">&nbsp;</td>
			  <?
			  $j++;  
			  $i++;
	       }
		   ?>	
      </tr>
    </table></td>
  </tr>
  <?
  /// ciclo para desplegar los meses //
  $mes = 1;
  while ($mes < 13){
      if ($mes==1){
	      $mes_palabra = "Enero";
	  }
	  if ($mes==2){
	      $mes_palabra = "Febrero";
	  }
	  if ($mes==3){
	      $mes_palabra = "Marzo";
	  }
	  if ($mes==4){
	      $mes_palabra = "Abril";
	  }
	  if ($mes==5){
	      $mes_palabra = "Mayo";
	  }
	  if ($mes==6){
	      $mes_palabra = "Junio";
	  }
	  if ($mes==7){
	      $mes_palabra = "Julio";
	  }
	  if ($mes==8){
	      $mes_palabra = "Agosto";
	  }
	  if ($mes==9){
	      $mes_palabra = "Septiembre";
	  }
	  if ($mes==10){
	      $mes_palabra = "Octubre";
	  }
	  if ($mes==11){
	      $mes_palabra = "Noviembre";
	  }
	  if ($mes==12){
	      $mes_palabra = "Diciembre";
	  }	
	  
	  $asistencia_a = 0;
	  $ausentes_a   = 0;
	  $matricula_a  = 0;
	  
	  
	    
      ?> 
  
  <tr>
    <td class="cuadro02"><?=$mes_palabra ?></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td  width="33%" align="right"><div align="right"><font style="font-size:10px">
			      <?
			      
				  $asistencia = 0;			      
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_asistencia = $fila_mes['asistencia'];
					  $asistencia = $asistencia + $r_asistencia;
					  
					  $jj++;
				  }
			      echo "$asistencia";
				  ?></font></div> </td>
			   <?
			   $j++;  
			   $i++;
	       }
		   ?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td  width="33%" align="right"><div align="right"><font style="font-size:10px">
			      <?
			      
				  $ausentes = 0;			      
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_ausentes = $fila_mes['ausentes'];
					  $ausentes   = $ausentes + $r_ausentes;
					  
					  
					  $jj++;
				  }
			      echo "$ausentes";
				  ?></font></div> </td>
			   <?
			   $j++;  
			   $i++;
	       }
		?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
       <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
			  <td  width="33%" align="right"><div align="right"><font style="font-size:10px">
			      <?			      
				  $matricula = 0;			      
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_matricula = $fila_mes['matricula'];
					  $matricula   = $matricula + $r_matricula;
					  
					  $jj++;
				  }
			      echo "$matricula";
				  ?></font></div> </td>
			   <?
			   $j++;  
			   $i++;
	       }
		?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
	   <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>			
	  
	  
	  
         
			 <?
			  // tomo los correspondientes valores para esta institucion
			  $ii=0;
			  
			  $asistencia = 0;
			  $ausentes   = 0;
			  $matricula  = 0;
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
				  <td  width="33%" align="right"><div align="right"><font style="font-size:10px"><?=$porcentaje ?>%</font></div></td>
				  <?
				  $asistencia = 0;
				  $ausentes   = 0;
				  $matricula  = 0;
				  $porcentaje = 0;
				  $r_asistencia = 0;
				  $r_ausentes   = 0;
				  $r_matricula  = 0;			  		  
			  ?>
			  
			  <?
			  $i++; $j++;
		  } 
		  ?>	  		  		
      </tr>
    </table></td>
  </tr>
  <?
	$mes++;
   }
  ?>	 
  <tr>
    <td class="cuadro02">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Anual</td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>
        <td  width="33%" align="right"><div align="right"><font style="font-size:10px">
            <?
			$mes = 1;
			$asistencia = 0;	
            while ($mes < 13){
			      
				  	      
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_asistencia = $fila_mes['asistencia'];
					  $asistencia = $asistencia + $r_asistencia;
					  $jj++;
				  }
			      
				  $mes++;
			 }
			 echo "$asistencia";	  
			 ?>
			 </font></div>
        </td>
        <?
			   $j++;  
			   $i++;
	       }
		   ?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>
        <td  width="33%" align="right" ><div align="right"><font style="font-size:10px">
            <?
			 $mes = 1;
			 $ausentes = 0;
             while ($mes < 13){    
				  		      
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_ausentes = $fila_mes['ausentes'];
					  $ausentes   = $ausentes + $r_ausentes;
					  $jj++;
				  }
			      
				  $mes++;
			  }
			  echo "$ausentes";	  
			  ?>
			</font></div>
        </td>
        <?
			   $j++;  
			   $i++;
	       }
		?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>
        <td  width="33%" align="right" ><div align="right"><font style="font-size:10px">
            <?
			$mes = 1;
			$matricula = 0;	
            while ($mes < 13){	
				  $qry = "select * from asistencia_instituciones where mes = '".trim($mes)."' and rdb = '".trim($rdb_asis)."'";
				  $res_val = pg_Exec($qry);
				  $num_mes = pg_numrows($res_val);
				  $jj = 0;				  
				  while ($jj < $num_mes){
				      $fila_mes = pg_fetch_array($res_val,$jj);
					  $r_matricula = $fila_mes['matricula'];
					  $matricula   = $matricula + $r_matricula;
					  $jj++;
				  }
			      
			      $mes++;
			  }	
			  echo "$matricula"; 	  
			  ?>
			 </font> </div>
        </td>
        <?
			   $j++;  
			   $i++;
	       }
		?>
      </tr>
    </table></td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
      <tr>
        <?
		  $qry_asis = "select distinct rdb from asistencia_instituciones";
		  $res_asis = pg_Exec($qry_asis);
		  $num_asis = pg_numrows($res_asis);
		  $i = 0; $j = 1;
		  while ($i < $num_asis){
			  $fila_asis   = @pg_fetch_array($res_asis,$i);
			  $rdb_asis    = $fila_asis['rdb'];
			  $qry_inst    = "select * from institucion where rdb = '$rdb_asis'";
			  $res_inst    = pg_Exec($qry_inst);
			  $fila_inst   = pg_fetch_array($res_inst,0);
			  $nombre_inst = $fila_inst['nombre_instit'];  
			  $color = "color".$j;
			  $color = $$color;
			  ?>
        <?
			  // tomo los correspondientes valores para esta institucion
			  $ii=0;
			  $mes = 1;
			  $asistencia = 0;
			  $ausentes   = 0;
			  $matricula  = 0;
			  
              while ($mes < 13){	  
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
				  $mes++;
			  }	  
			  $porcentaje = @round(($asistencia * 100)/$matricula,2);
		?>
        <td  width="33%" align="right" ><div align="right"><font style="font-size:10px">
          <?=$porcentaje ?>
          %</font></div></td>
        <?
				  $asistencia = 0;
				  $ausentes   = 0;
				  $matricula  = 0;
				  $porcentaje = 0;
				  $r_asistencia = 0;
				  $r_ausentes   = 0;
				  $r_matricula  = 0;			  		  
			  ?>
        <?
			  $i++; $j++;
		  } 
		  ?>
      </tr>
    </table></td>
  </tr>
    
</table>

<? } ?>

<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>

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

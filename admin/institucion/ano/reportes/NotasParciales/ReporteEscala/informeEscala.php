<?
require('../../../../../../util/header.inc');
/*require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');*/
include('../../../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<SCRIPT language="JavaScript">
$(document).ready(function() {
    periodo();
	ense();
	escala();
});
			
function periodo(){
var ano = $("#cmbANO").val();
var funcion =1;
	$.ajax({
		url:"contInformeEscala.php",
		data:"funcion="+funcion+"&ano="+ano,
		type:'POST',
		success:function(data){
			//console.log(data);
		 $("#periodo").html(data);
				
		  }
		});
}

function ense(){
var ano = $("#cmbANO").val();
var funcion =2;
	$.ajax({
		url:"contInformeEscala.php",
		data:"funcion="+funcion+"&ano="+ano,
		type:'POST',
		success:function(data){
			//console.log(data);
		 $("#ense").html(data);
				
		  }
		});
}

function escala(){
var ano = $("#cmbANO").val();
var rdb = <?php echo $institucion ?>;
var funcion =3;
	$.ajax({
		url:"contInformeEscala.php",
		data:"funcion="+funcion+"&ano="+ano+"&rdb="+rdb,
		type:'POST',
		success:function(data){
			//console.log(data);
		 $("#escala").html(data);
				
		  }
		});
}
			
						
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
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../../cabecera/menu_superior.php");
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
						include("../../../../../../menus/menu_lateral.php");
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
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES --><!-- FIN CODIGO DE BOTONES -->
                                  <!-- INICIO CUERPO DE LA PAGINA -->
                                  <center>
  <br>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method "post" action="printInformeEscala.php" target="_blank" name="form">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

<center>
<table width="709" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701"  class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27"><table width="650" border="0" align="center">
  <tr>
    <td width="212" class="textonegrita">A&Ntilde;O</td>
    <td width="13" class="textonegrita">:</td>
    <td width="411">
    <? 	$sql="SELECT id_ano, nro_ano FROM ano_escolar WHERE id_institucion=".$institucion." order by nro_ano";
		$rs_ano = pg_exec($conn,$sql);
	?>
    <select name="cmbANO" id="cmbANO" onChange="periodo(),ense(),escala()">
    	<option value="0">seleccione...</option>
    <? for($i=0;$i<pg_numrows($rs_ano);$i++){
			$fila=pg_fetch_array($rs_ano,$i);
		if($fila['id_ano']==$ano){
	?>
    	<option value="<?=$fila['id_ano'];?>" selected><?=$fila['nro_ano'];?></option>
    <? }else{ ?>
    	<option value="<?=$fila['id_ano'];?>"><?=$fila['nro_ano'];?></option>    
    <? }
	}
	?>
	</select>
    </td>
  </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td class="textonegrita">:</td>
    <td><div id="periodo">
      <select name="cmbPeriodo" id="cmbPeriodo">
        <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td class="textonegrita">TIPO ENSE&Ntilde;ANZA</td>
    <td class="textonegrita">:</td>
    <td><div id="ense">
      <select name="cmbEnse" id="cmbEnse">
      <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td class="textonegrita">ESCALA</td>
    <td class="textonegrita">:</td>
    <td><div id="escala">
      <select name="cmbEscala" id="cmbEscala">
      <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" name="button" id="button" value="Buscar" class="botonXX">&nbsp;&nbsp;<input name="cb_ok2" class="botonXX"  type="button" value="Volver" onClick="window.location='../../Menu_Reportes_new2.php'"></td>
  </tr>
    </table>
</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form> 
<!-- FIN FORMULARIO DE BUSQUEDA --> 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
        </
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
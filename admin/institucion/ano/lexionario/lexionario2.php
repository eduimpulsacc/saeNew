<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

</script>

<?
require('../../../../util/header.inc');
//include ("../calendario/calendario.php");


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_POST['cmb_curso'];
	$ramo			=$_POST['cmb_ramo'];
	

	$_POSP = 4;
	$_bot = 6;
	
	
	
	$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_ano'];
	
	if($_POST['ingresar']=="agregar"){
		$frmModo="ingresar";
	}

	if ($_GET['frmModo']=="modificar"){
		$sql= "select * from lexionario where id_lexionario=$_GET[id_lexionario]";
		$res_modificar = @pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($res_modificar,0);
		$fecha = $fila['fecha'];
		$descripcion = $fila['descripcion'];
		$tipo = $fila['tipo'];
		$nota = $fila['nota'];
		$curso = $fila['id_curso'];
		$ramo = $fila['id_ramo'];
		
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<style type="text/css">
	body.a{
		/*
		You can remove these four options 
		
		*/
		background-repeat:no-repeat;
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		margin:0px;
		

	}
	#ad{
		padding-top:220px;
		padding-left:10px;
	}
	</style>
	<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
	<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>


<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}
-->
</style><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin9">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" ></script>

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

function valida(x){


	if(document.form.txt_obser.value.length==0){
		alert('Ingrese Descripción.');
		return false;
	};

	if(document.form.cmb_tipo.value==0){
		alert('Ingrese Tipo.');
		return false;
	};

	if(document.form.cmb_nota.value==0){
		alert('Ingrese Nota.');
		return false;
	};

	
    if ( x == 0 )
	   { var Cuenta = 0;
	    }
	else { var Cuenta = x;
		}
    	
	var curso=document.form.txt_obser.value.length;
	var curso=document.form.cmb_tipo.value;
	var ano=document.form.cmb_nota.value;
	
							var var1 = $("#cmb_curso").val();
							var var2 = $("#cmb_ramo").val();							
							
							/*window.location = 'listarlexionario.php';
							window.location = 'listarlexionario.php?xsdee4='+var1+'';*/
							window.location = 'listarlexionario.php?cmb_ramo='+var2+'&cmb_curso='+var1;
	
	document.form.submit(true);
	
 							


}

//-->>
// FIN FUNCION  

</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
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
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								 
	<table width="100%" align="center">				 
	<td align="middle" colspan="6" class="tableindex">Lexionario</td></tr></table>
<form name="form" id="form" action="procesoLexionario.php" method="post">
<input type="hidden" name="curso" value="<?=$curso?>" />
<input type="hidden" name="ramo" value="<?=$ramo?>" />
<input type="hidden" name="frmModo" value="<?=$frmModo?>" />
<input type="hidden" name="id_lexionario" value="<?=$_GET[id_lexionario]?>" />
							 <br>
					  <table cellpadding="5" cellspacing="0">
					    <tr>
					      <td height="15" class="textonegrita">CURSO</td>
					      <td class="textonegrita">:</td>
					      
			<TD> <FONT face="arial, geneva, helvetica" size=2> 
                          <?
					echo $Curso_pal = CursoPalabra($curso, 1, $conn);
						?>
                         </FONT> 
						
						</TD>			  
						  
					    </tr>
<tr>
<td height="15" class="textonegrita">ASIGNATURA</td>
<td class="textonegrita">:</td>
<td class="textosimple">
    <!--AQUI-->

  <?
  		$sql = "select subsector.nombre
from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector
where id_ramo=$ramo ";
$rs_ramo = pg_Exec($conn,$sql);
echo pg_result($rs_ramo,0);
  
  ?> 
  
   </td>
<td>
<input class="botonXX" type="button" value="GUARDAR" name="btnGuardar" onClick="valida(0);" ></td>
<td>
<input class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)">
</td>

</tr>
 </table>
 
					    	

<br />
<table width="100%" align="center">				 
	<td align="middle" colspan="6" class="tableindex">Lexionario</td></tr></table>
<table class="textonegrita" >
					
		 
		<tr>
		
		<tr><td>Fecha Tipo (YYYY/MM/DD): </td><td>
	
		<input type="text"  value="2008/04/04" readonly name="theDate" onclick="displayCalendar(document.forms[0].theDate,'yyyy/mm/dd',this)">
		
		<input type="button" class="botonXX"  value="Cal" onclick="displayCalendar(document.forms[0].theDate,'yyyy/mm/dd',this)"></td></tr>

<td> 
<tr>
<td nowrap="nowrap" >DESCRIPCION:</td>
<td nowrap="nowrap" >
<? if($frmModo=="modificar"){?>
	<textarea name="txt_obser" cols="40" rows="5"><?=$descripcion?> </textarea>
<?php }else{;?>
	<textarea name="txt_obser" cols="40" rows="5"></textarea>
<? } ?>
</td>
</tr>

<tr>
<td >TIPO:  </td>
<td  >
<? if($frmModo=="modificar"){?>
<select id="cmb_tipo" name="cmb_tipo" class="textosimple">
<option value=0 >(Seleccione Tipo)</option>

			        <option value="1" <? echo ($tipo==1)?"selected":"";?>>Tipo 01</option>
					<option value="2" <? echo ($tipo==2)?"selected":"";?>>Tipo 02</option>
					<option value="3"<? echo ($tipo==3)?"selected":"";?>>Tipo 03</option>
					<option value="4"<? echo ($tipo==4)?"selected":"";?>>Tipo 04</option>
					<option value="5"<? echo ($tipo==5)?"selected":"";?>>Tipo 05</option>
</select> 
<?php }else{;?>

<select id="cmb_tipo" name="cmb_tipo" class="textosimple">
<option value=0 selected>(Seleccione Tipo)</option>

			        <option value="1">Tipo 01</option>
					<option value="2">Tipo 02</option>
					<option value="3">Tipo 03</option>
					<option value="4">Tipo 04</option>
					<option value="5">Tipo 05</option>
</select>					
<? } ?>
<span >(*)</span></td>
	</tr>
	
	<tr>
<td >CASILLERO:  </td>
<td  >
<? if($frmModo=="modificar"){?>

<select id="cmb_nota" name="cmb_nota" class="">
<option value=0 selected>(Seleccione Nota)</option>
					
					<option value="01"<? echo ($nota==01)?"selected":"";?>>01</option>
					<option value="02"<? echo ($nota==02)?"selected":"";?>>02</option>
					<option value="03"<? echo ($nota==03)?"selected":"";?>>03</option>
					<option value="04"<? echo ($nota==04)?"selected":"";?>>04</option>
					<option value="05"<? echo ($nota==05)?"selected":"";?>>05</option>
					<option value="06"<? echo ($nota==06)?"selected":"";?>>06</option>
					<option value="07"<? echo ($nota==07)?"selected":"";?>>07</option>
					<option value="08"<? echo ($nota==08)?"selected":"";?>>08</option>
					<option value="09"<? echo ($nota==09)?"selected":"";?>>09</option>
					<option value="10"<? echo ($nota==10)?"selected":"";?>>10</option>
					<option value="11"<? echo ($nota==11)?"selected":"";?>>11</option>
					<option value="12"<? echo ($nota==12)?"selected":"";?>>12</option>
					<option value="13"<? echo ($nota==13)?"selected":"";?>>13</option>
					<option value="14"<? echo ($nota==14)?"selected":"";?>>14</option>
					<option value="15"<? echo ($nota==15)?"selected":"";?>>15</option>
					<option value="16"<? echo ($nota==16)?"selected":"";?>>16</option>
					<option value="17"<? echo ($nota==17)?"selected":"";?>>17</option>
					<option value="18"<? echo ($nota==18)?"selected":"";?>>18</option>
					<option value="19"<? echo ($nota==19)?"selected":"";?>>19</option>
					<option value="20"<? echo ($nota==20)?"selected":"";?>>20</option>
					</select>
		<?php }else{;?>
		
	<select id="cmb_nota" name="cmb_nota" class="">
	<option value=0 selected>(Seleccione Nota)</option>
					
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					
</select>
  <? } ?>
<span >(*)</span></td>
	</tr>
</table>
	

</form>
	
								 
								  <!-- FIN DEL NUEVO CÓDIGO -->                                  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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
</tr>
</tr>
</body>
</html>
<? pg_close($conn);?>
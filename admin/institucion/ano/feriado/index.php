<?
require('../../../../util/header.inc');
//include ("calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$id_feriado		=$_IDFERIADO;
	$bool_fer		=$_BOOLFER;
	$_POSP = 4;
	$_bot = 2; 
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}*/
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}


//nro ano
$sql_ano ="select * from ano_escolar where id_ano=$ano";
$rs_ano = @pg_exec($conn,$sql_ano) or die ("SELECT FALLO :".$sql_ano);
$nro_ano = pg_result($rs_ano,1);

$fiano=explode("-",pg_result($rs_ano,2));
$ftano=explode("-",pg_result($rs_ano,3));

//if($_PERFIL==0){
//voy a buscar los feriados
$sql2="select * from feriado where id_ano=".$ano." order by fecha_inicio";
$result2=pg_Exec($conn,$sql2);
$arr_feriados='';
for($j=0 ; $j<pg_numrows($result2) ; $j++){
$filaFeriado=pg_fetch_array($result2,$j);
	
$fecIni = $filaFeriado["fecha_inicio"];
$fecFin = $filaFeriado["fecha_fin"];

$fecha_inicial = $fecIni; 
$fecha_final = $fecFin ; 
$partesfi = explode ( "-", $fecha_inicial ); 
$partesff = explode ( "-", $fecha_final ); 

$primera = mktime ( 0, 0, 0, date ("$partesfi[1]"), date ("$partesfi[2]"), date ("$partesfi[0]") ); 
$segunda = mktime ( 0, 0, 0, date ("$partesff[1]"), date ("$partesff[2]"), date ("$partesff[0]") ); 
$cuenta_dias = ($segunda - $primera) / 86400; 

$contador = 0; 

for ( $e = 0; $e <= $cuenta_dias; $e++ ) 
{ 

   $fecha_inicial = mktime ( 0, 0, 0, date ("$partesfi[1]"), date ("$partesfi[2]") + $contador, date ("$partesfi[0]") ); 

  $arr_feriados.='"'.date ( "n-j-Y", $fecha_inicial ).'",'; 

   $contador += 1; 
} 

}

//echo $arr_feriados;

$arr_feriados = substr($arr_feriados, 0, -1);
//echo $arr_feriados;
//}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">-->
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" scr="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" scr="../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
-->
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/base/jquery.ui.datepicker.css">
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

			    
function valida(form){					
	if(!chkVacio(form.fecha1,'Debe ingresar FECHA DE INICIO.')){
		return false;
	};
	
	if(!chkVacio(form.fecha2,'Debe ingresar FECHA DE TERMINO.')){
		return false;
	};
	
	if(form.cmbPeriodo.value==0){
	   alert ('Debe seleccionar PERIODO');
		return false;
	};
	
	return true;
}


function fechas(caja)
{ 
  

   if (caja)
   {  
      borrar = caja;
       
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr($i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = ''; // Año no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '';
		 
	  if (borrar == '')
	     alert('Fecha erronea');
  
   
   }  // if (caja)   
   
    
} // FUNCION

var disabledDays = [<?php echo $arr_feriados ?>];
//var disabledDays = ["2-21-2015","2-24-2015","2-27-2015","2-28-2015","3-3-2015","3-17-2015","4-2-2015","4-3-2015","4-4-2015","4-5-2015"];

function nationalDays(date) {
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
	for (i = 0; i < disabledDays.length; i++) {
		if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1 ) {
			//console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
			return [false, "festivos", 'Día festivo'];
			//return [false];
		}
	}
	//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
	return [true];
}
function noWeekendsOrHolidays(date) {
	var noWeekend = jQuery.datepicker.noWeekends(date);
	return noWeekend[0] ? nationalDays(date) : noWeekend;
}

/* create datepicker */
jQuery(document).ready(function() {
	jQuery('#fecha1,#fecha2').datepicker({
		minDate: new Date('<?php echo $fiano[1]."/".$fiano[2]."/".$fiano[0] ?>'),
		maxDate: new Date('<?php echo $ftano[1]."/".$ftano[2]."/".$ftano[0] ?>'),
		dateFormat: 'dd-mm-yy',
		constrainInput: true,
		changeMonth: true,
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
	  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
	  firstDay: 1,
	  beforeShowDay: noWeekendsOrHolidays
	});
});

</script>
<!--<script language="JavaScript" src="../feriado/calendario/javascripts.js"></script>-->
<style>
.festivos span {
 color: red !important; //muestra rojos los festivos
}
.ui-datepicker-week-end span {
 color: #333 !important; //muestra grises los fines de semana
}

</style>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	
								   <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
								
								  <table border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"> 
      
	  
	  
	  
	  
	  </td>
  </tr>
</table>



<form method=post name="fcalen" action="procesoFeriado.php3">
<table width="90%" border="0" align="center">
    <tr>
      <td><table width="90%" border="0">
          <tr>
            <td width="34%"> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO ESCOLAR</strong> 
              </FONT> </td>
            <td width="2%"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
            <td width="64%"><FONT face="arial, geneva, helvetica" size=2><strong>
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
            <td align="left"><input class="botonXX" type="submit" name="Submit" value="GUARDAR" onClick="return valida(this.form);">
			<?php if (($frmModo=="modificar") and ($bool_fer!=0)){
						if($elimina==1){?>
            <input class="botonXX" type="button" name="Submit4" value="ELIMINAR" onClick=document.location="seteaFeriado.php3?caso=9&id_feriado=<?php echo $id_feriado;?>">
			<?php 		}
					} ?>
            <input class="botonXX" type="button" name="Submit3" value="CANCELAR" onClick=document.location="seteaFeriado.php3?caso=4"></td>
            <td align="right"><img src="../images/icono_feriado2.png" width="133" height="103"></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="17%" height="20" align="left" class="tableindex"><strong>Ingreso de Feriados </strong></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td height="30" align="left" valign="middle"><font color="#000033" size="1" face="Arial, Helvetica, sans-serif">NOTA:<br>
En caso de ingresar s&oacute;lo un d&iacute;a, debe igualmente ingresar los campos &quot;Fecha inicio&quot; y &quot;Fecha final&quot;.<br>
              En caso de que sea un rango de días que incluya fines de semana, debe ingresar sólo los días hábiles correspondientes entre lunes y viernes.<br>
En caso de que coincida un día festivo entre un rango de días que desee incluir como feriado en su institución, no debe ser considerado. Por ende, no es necesario agregarlo como día adicional.</font></td>
          </tr>
        </table>
        
      <table width="100%" border="0" align="left">
        <tr align="left" valign="top"> 
            <td width="17%" valign="middle" class="cuadro02"><strong>Fecha inicio</strong></td>
            <td width="2%" valign="middle" class="cuadro01"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td width="81%" class="cuadro01"> &nbsp; 
              <?php
						if ($bool_fer==0){
							/*$fecSis=getdate();
							$anoActual=$fecSis["year"];
							$sql="select feriados_nac.id_feriado,feriados_nac.bool_fer,feriados_nac.fecha_inicio, feriados_nac.fecha_fin, feriados_nac.descripcion from feriados_nac where id_feriado=".$id_feriado;
							$result =@pg_Exec($conn,$sql);
								if (@pg_numrows($result)!=0){
									$fila=@pg_fetch_array($result,0);
								}*/
							//$fecIni=$fila["fecha_inicio"]."-".$anoActual;
						//	$fecIni=/*$fila["fecha_inicio"].*/"-".$nroAno;
							//if ($fila["fecha_fin"]!=0){
								//$fecFin=$fila["fecha_fin"]."-".$anoActual;
								//$fecFin=/*$fila["fecha_fin"].*/"-".$nroAno;
								$fecIni="";
								$fecFin="";
							//}
						}else{//fin if ($bool_fer==0)
						$sql="select distinct feriado.id_feriado, feriado.bool_fer, feriado.fecha_inicio, feriado.fecha_fin, feriado.descripcion, feriado.id_periodo from feriado where id_ano=".$ano." and id_feriado=".$id_feriado;
						$result =@pg_Exec($conn,$sql);
								if (@pg_numrows($result)!=0){
									$fila=@pg_fetch_array($result,0);
								}
									$fecIni=substr($fila["fecha_inicio"],8,2); //dia
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],5,2); //mes
									$fecIni=$fecIni. "-";
									$fecIni=$fecIni. substr($fila["fecha_inicio"],0,4);  //año

									$fecFin=substr($fecFin=$fila["fecha_fin"],8,2); //dia
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],5,2); //mes
									$fecFin=$fecFin."-";
									$fecFin=$fecFin.substr($fila["fecha_fin"],0,4); 
						}//fin else
						?>
						
						
						
              <?php
					//escribe_formulario_fecha_vacio("fecha1","fcalen","$fecIni");
?>
<input name="fecha1" type="text" id="fecha1" value="<?php echo $fecIni ?>" size="10" maxlength="10" readonly>
            </td>
          </tr>
          <tr align="left" valign="top"> 
            <td valign="middle" class="cuadro02"><strong>Fecha final </strong> </td>
            <td valign="middle" class="cuadro01"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td class="cuadro01"> &nbsp;
              <?
				//escribe_formulario_fecha_vacio("fecha2","fcalen","$fecFin");
?><input name="fecha2" type="text" id="fecha2" value="<?php echo $fecFin ?>" size="10" maxlength="10" readonly >
            </td>
          </tr>
		  <tr align="left" valign="top"> 
            <td valign="middle" class="cuadro02"><strong>Periodo</strong>              </td>
            <td valign="middle" class="cuadro01"><font size="2" face="Arial, Helvetica, sans-serif"><strong>:</strong></font></td>
            <td class="cuadro01"> &nbsp; 
			<?php $sqlPeriodo="select * from periodo where id_ano=".$ano."order by nombre_periodo";
					$resultPeriodo=pg_Exec($conn,$sqlPeriodo);
					if(!$resultPeriodo){
						error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>'.$sqlPeriodo);
					}else{
					echo "<select name=cmbPeriodo>";
					echo "<option value=0>Seleccione Periodo</option>";
						for($x=0 ; $x<pg_numrows($resultPeriodo) ; $x++){
							$filaPeriodo=pg_fetch_array($resultPeriodo);
								if($filaPeriodo["id_periodo"]==$fila["id_periodo"]){
									echo "<option value=".$filaPeriodo["id_periodo"]." selected>".$filaPeriodo["nombre_periodo"]."</option>";
								}else{
									echo "<option value=".$filaPeriodo["id_periodo"].">".$filaPeriodo["nombre_periodo"]."</option>";
								}
						}
					echo "</select>";
					}
			?>
			</td>
          </tr>
		  
          <tr align="left" valign="top"> 
            <td valign="middle" class="cuadro02"><strong>Descripci&oacute;n</strong></td>
            <td valign="middle" class="cuadro01"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></td>
          <td class="cuadro01"> &nbsp; 
            <?php if($frmModo=="ingresar"){ ?>
            <input name="descripcion" type="text" size="50" maxlength="60">
			<?php } ?>
			<?php if($frmModo=="modificar"){
					$descripcion= $desc;
					//$descripcion= $fila["descripcion"];?>
            <input type="text" name="descripcion" size="50" maxlength="60" value="<?php imp ($fila["descripcion"]);?>">
			</td>
			<?php } ?>
          </tr>
        </table>

	</table>
  
</form>
								
								
								
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
															
								  </td>
								 </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><?
						 include("../../../../cabecera/menu_inferior.php");
						 ?></td>
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

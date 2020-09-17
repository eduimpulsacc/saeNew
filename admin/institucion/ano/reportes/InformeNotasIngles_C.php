<? 
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
//setlocale("LC_ALL","es_ES");

?>
<SCRIPT language="JavaScript">
			function enviapag(form){
				if (form.cmb_curso.value!=0){
					window.location= 'InformeNotasIngles_C.php?cmb_curso='+ document.form.cmb_curso.value + '&cmb_periodos=' + document.form.cmb_periodos.value +'&c_reporte=' + document.form.c_reporte.value;
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
						
			
									
</script>

<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso; 
	$alumno		    =$c_alumno; 
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	
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
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

</head>

<body target="mainFrame">

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC¡ DEBE IR CON INCLUDE -->
			
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
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
	   
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->


<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method="post" action="printNotasParcialesIngles_C.php" name="form" target="_blank">
<input type="hidden" name="c_reporte" value="<? echo $reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
$ob_motor = new MotorBusqueda();
$ob_motor -> ano = $ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$resultado_query_cue = $ob_motor -> curso2($conn);
//------------------
//$ob_motor ->ano =$ano;
$result_peri = $ob_motor ->periodo($conn);

//------------------
?>
<center>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="53%" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="5" class="textosmediano"><span class="textosimple">Period</span><br>
      <select name="cmb_periodos" class="ddlb_9_x">
        <option value=0 selected>(Select Period)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
			  $fila = @pg_fetch_array($result_peri,$i); 
				$periodo_nuevo= trim(strtoupper($fila['nombre_periodo'])) ;
				if( !strcasecmp($periodo_nuevo,"PRIMER TRIMESTRE")  ){
					$periodo_nuevo="FIRST TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"SEGUNDO TRIMESTRE")  ){
					$periodo_nuevo="SECOND TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"TERCER TRIMESTRE")  ){
					$periodo_nuevo="THIRD TRIMESTER"; }
				if( !strcasecmp($periodo_nuevo,"PRIMER SEMESTRE")  ){
					$periodo_nuevo="FIRST SEMESTER"; }
				if( !strcasecmp($periodo_nuevo,"SEGUNDO SEMESTRE")  ){
					$periodo_nuevo="SECOND SEMESTER"; }
	
			  if ($fila['id_periodo']==$cmb_periodos)
				echo  "<option selected value=".$fila["id_periodo"]." >".$periodo_nuevo."</option>";
			  else
				echo  "<option value=".$fila["id_periodo"]." >".$periodo_nuevo."</option>";
			  ?>
        <? } ?>
          </select></td>
    </tr>
  <tr>
    <td colspan="5" class="textosmediano"><br>
    <div>
      <span class="textosimple">Class</span>
	  <div align="left"> 
	    <font size="1" face="arial, geneva, helvetica">
	      <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
	        <option value=0 selected>(Select Class)</option>
	        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
				if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option selected value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option selected value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option selected value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option selected value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option selected value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}else{
				echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
				}		  
  		  }else{
				$ensenanza_nuevo= trim(strtoupper($fila['nombre_tipo'])) ;
				if( !strcasecmp($ensenanza_nuevo,"ENSEÒANZA B·SICA")  ){
					$ensenanza_nuevo="PRIMARY"; }
				if( !strcasecmp($ensenanza_nuevo,"ENSEÒANZA MEDIA HUMANÌSTICO - CIENTÌFICO")  ){
					$ensenanza_nuevo="SECONDARY HUMANISTIC - SCIENTIST"; }
				if( !strcasecmp($ensenanza_nuevo,"ENSEÒANZA MEDIA")  ){
					$ensenanza_nuevo="SECONDARY"; }
		  
		  		if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
					echo "<option value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
					echo "<option value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
					echo "<option value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
					echo "<option value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
					echo "<option value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}else{
				echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$ensenanza_nuevo."</option>";
				}		
		  }
          } ?>
	        </select>
</font>	  </div>
	 
      </div></td>
    </tr>
  <tr>
    <td colspan="5" class="textosmediano"><br>
      <span class="textosimple">Name</span>
	  <div align="left">
	    
	    <select name="cmb_alumno" class="ddlb_9_x">
	      <option value=0 selected>(All Names)</option>
	      <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
	      <?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
	      <?
			}else{
			   ?>
	      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>   	
	      <?
		    }		
			
		}
		?>
	      </select>
	      </div></td>
    </tr>
  <tr>
    <td width="39" class="textosmediano">&nbsp;</td>
    <td width="498" colspan="4"><div align="right">
      <? if ($flag==0) {?>	   
      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Search">
      <? }?>
	  	<? if($_PERFIL==0){?>		  
	<input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Export">
		<? }?>
		<input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
    </div></td>
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
</body>
</html>
<? pg_close($conn);?>
<? 
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
//setlocale("LC_ALL","es_ES");

?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
//				form.action = 'NotasParciales_Taller.php?institucion=$institucion';
				form.action = 'NotasParciales_Taller_Ingles.php?institucion=$institucion'+'flag=$flag';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<script>
function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';	

}
	</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso; 
	$alumno		    =$c_alumno; 
	$periodo		=$c_periodos;
	
	$_POSP = 4;
	$_bot = 8;
	
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw == 1) //exit;

	$sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by fecha_inicio" ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
	  //error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
	  {
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  //error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  //exit();
		  }
	  }
	}
	//-----------------------
	$sql = "select count(id_periodo) as num_periodos from periodo where id_ano = $ano";
	$resultPeri =@pg_Exec($conn,$sql);	
    $fila1Peri = @pg_fetch_array($resultPeri,0);		
	$num_periodos = $fila1Peri['num_periodos'];
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//-----------------------

	function Nombre($paterno,$materno,$nombres){
		$Nombres = strtoupper($nombres." ".$paterno." ".$materno);
		echo $Nombres;
	}
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
<style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
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
	    <?
		include("../../../../cabecera/menu_inferior.php");
	    ?> 
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->


<!-- INICIO FORMULARIO DE BUSQUEDA -->

<form method="post" action="">
<input type="hidden" name="flag" value="<? echo $flag;?>">
<? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="53%" class="tableindex">Advanced Finder </td>
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
	  <!--    <td width="199"><div align="right">
      <input name="cb_ok" type="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'mainFrame\']','NotasParciales_3y4.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar"> -->
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
      <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','NotasParciales_Ingles.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Search">
      <? }?>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
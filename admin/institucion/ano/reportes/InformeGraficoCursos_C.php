<? 	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	 $institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">


	/*function valida()
	{
	
	 var cb_ok = "Buscar";
	 var c_reporte="<?=$c_reporte?>";
	 var periodo=document.form.cmb_periodos.value;
	 var ensenanza=document.form.cmb_ense.value;
		if (periodo==0){
			alert("Seleccione Periodo");
			return false;
			}
		if (ensenanza==0){
			alert("Seleccione Tipo enseñanza");
			return false;
			}	
			
		     var enviar= document.form.action='printInformeGraficoCursos_C2.php?cmb_periodos='+periodo+'&cmb_ense='+ensenanza+'&c_reporte='+c_reporte+'&cb_ok='+cb_ok;
			   alert(enviar);
			  // 'curso='+curso+'&ano='+ano+"&rutusuario="+rutusuario;
			   //c_reporte
				document.form.submit(true);	
		
	}*/

	function enviapag2(form){
				form.target="_blank";
				var periodo = document.form.cmb_periodos.value;
				document.form.action='printInformeGraficoCursos_C.php?cmb_periodos='+periodo;
				document.form.submit(true);
	}
	function enviapag(form){
		form.action = 'InformeGraficoCursos.php?institucion=$institucion';
		form.submit(true);
    }
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
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
								  <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
      
	   
  
</table>
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>
<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form method "post" action="printInformeGraficoCursos_C2.php" target="_blank" name="form">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
//------------------
$ob_motor = new MotorBusqueda();
$ob_motor ->ano = $ano;
$result_peri = $ob_motor ->periodo($conn);

//------------------
?>
<center>
<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="61" class="textosimple">Periodo</td>
        <td width="109" colspan="2">
		<select name="cmb_periodos" id="cmb_periodos" class="ddlb_9_x" >
		<option value=0 selected>(Seleccione Periodo)</option>
        <?
		for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
		  $fila = @pg_fetch_array($result_peri,$i); 
		  if ($fila['id_periodo']==$cmb_periodos)
   			  echo  "<option selected value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  else
   			  echo  "<option value=".$fila["id_periodo"]." >".$fila['nombre_periodo']."</option>";
		  ?>
	    <?
		} ?>
        </select></td>       
        <td width="55">&nbsp;</td>
        <td width="55">&nbsp;</td>
    	<td width="55">&nbsp;</td>
    	
	</tr>
    
    
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>       
	</tr>
    
     <tr>
        <td width="61" class="textosimple">Ense&ntilde;anza</td>
        <td width="109" colspan="5">
		<select name="cmb_ense" id="cmb_ense" class="ddlb_9_x" >
		<option value=0 selected>(Seleccione Ense&ntilde;anza)</option>
        <?
		
		
		$sql_ense="select DISTINCT te.nombre_tipo ,te.cod_tipo
					from tipo_ense_inst tip 
					INNER JOIN tipo_ensenanza te ON tip.cod_tipo=te.cod_tipo
					WHERE tip.rdb=".$institucion;
						
		 $result_ense=@pg_Exec($conn,$sql_ense);
		 
		for($j=0 ; $j < @pg_numrows($result_ense) ; $j++){
		  $fila1 = @pg_fetch_array($result_ense,$j); 
		  		  
   			  echo  "<option value=".$fila1["cod_tipo"]." >".$fila1['nombre_tipo']."</option>";
		  
   			 
		  ?>
	    <?
		} ?>
        </select></td>       
	</tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>       
	</tr>
    
   <tr>
        <td><input type="submit" name="cb_ok" value="Buscar" class="botonXX"  ></td>
        <? if($_PERFIL==0){?>
        <td width="27"><input type="button" name="cb_ex" value="Exportar" onClick="enviapag2(this.form)" class="botonXX" ></td>
        <td width="28"><input type="button" name="cb_ok2" value="Volver" onClick="window.location='Menu_Reportes_new2.php'"class="botonXX" ></td>
    	<? }?>
	</tr>
   <tr>
     <td>&nbsp;</td>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
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
<?
pg_close();

?>
</body>
</html>
<? pg_close($conn);?>
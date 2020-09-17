<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$_MDINAMICO = 1;	
	$cmb_curso=$_POST["cmb_curso"];
	$rut=$_GET["rut"];
	
    require_once("../../estadisticas/widgets/widgets_start.php");
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" src="../../estadisticas/widgets/calendar.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../estadisticas/js/moodalbox.js"></SCRIPT>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open(pagina,"",opciones);
}
</script>
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.target="_parent";
		form.action = 'Postular.php';
		form.submit(true);
	}	
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
   function ver_confirm()
   {
   	
    if (document.form.txtrut.value.length==0){
       alert("Favor Escribir rut")
       document.form.txtrut.focus()
       return 0;
    } 
	
	 document.form.action = "Buscar_rut.php";
     document.form.submit();
   }
   
   
   
    function ver_confirm2()
   {
   	
   /* if (document.form.txtrut.value.length==0){
       alert("Favor Escribir rut")
       document.form.txtrut.focus()
       return 0;
    } 
	
    if (document.form.txtdv.value.length==0){
       alert("Favor Escribir Dv")
       document.form.txtdv.focus()
       return 0;
    } 
	
    if (document.form.txtnom.value.length==0){
       alert("Favor Escribir Nombre")
       document.form.txtnom.focus()
       return 0;
    } 
	
    if (document.form.txtapepater.value.length==0){
       alert("Favor Escribir Apellido Paterno")
       document.form.txtapepater.focus()
       return 0;
    } 
	*/
	
	if (document.form.txtproc.value.length==0){
       alert("Favor Escribir Establecimiento Procedencia")
       document.form.txtproc.focus()
       return 0;
    } 
    if (document.form.prom7.value.length==0){
       alert("Favor Escribir Promedio")
       document.form.prom7.focus()
       return 0;
    } 
    if (document.form.prom8.value.length==0){
       alert("Favor Escribir Promedio")
       document.form.prom8.focus()
       return 0;
    } 
	
    if (document.form.prompostu.value.length==0){
       alert("Favor Escribir Promedio")
       document.form.prompostu.focus()
       return 0;
    } 
	  if (document.form.txt_edad.value.length==0){
       alert("Favor Escribir Edad al 31 de Marzo")
       document.form.txt_edad.focus()
       return 0;
    } 
	/*
    if (document.form.fecha.value.length==0){
       alert("Favor Escribir Fecha de Nacimiento")
       document.form.fecha.focus()
       return 0;
    } 
	
    if (document.form.txtdire.value.length==0){
       alert("Favor Escribir Dirección")
       document.form.txtdire.focus()
       return 0;
    } */
	 document.form.action = "Procesa_postular.php";
     document.form.submit();
   }



//-->
</script>


		<?php include('../../util/rpc.php3');
		  //$sql="select * from formulario_postulacion where rut=".$rut;
						 
		?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" media="all" href="../../estadisticas/widgets/calendar-brown.css" title="green"/>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="16%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 $sql="select * from alumno  where rut_alumno=".$rut;
						 $resp = pg_exec($conn,$sql);
						$fila = @pg_fetch_array($resp,0);
						
						 	$sqlgrado="select grado_curso from matricula inner join curso on matricula.id_curso=curso.id_curso where rut_alumno=".$rut." and matricula.id_ano=".$_ANO;
						  	$respgrado = pg_exec($conn,$sqlgrado);
							$filagrado = @pg_fetch_array($respgrado,0);
						 ?>
					  </td>
                      <td width="84%" align="left" valign="top">
                        <form name="form" method="post">
							<table width="794" border="0">
							  <tr>
						<input type="hidden" name="hd_grado" value="<?= $filagrado["grado_curso"]?>">
						<td colspan="3" class="tableindex">Formulario De Postulaci&oacute;n </td>
								
							  </tr>
							  <tr>
								<td width="279" class="textosimple">Rut:</td>
								<td width="505"><input name="txtrut" type="text" value="<?=$fila["rut_alumno"] ?>" size="7" maxlength="8">
								-  
							    <input name="txtdv" type="text" id="txtdv" size="1" maxlength="1" value="<?=$fila["dig_rut"] ?>">
							    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="botonXX" type="button" name="buscar" value="Buscar" onClick="ver_confirm()"></td>
							  <tr  class="textosimple">
							    <td>Nombres</td>
							    <td><?=$fila["nombre_alu"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Apellido Paterno </td>
							    <td><?=$fila["ape_pat"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Apellido Materno </td>
							    <td><?=$fila["ape_mat"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Sexo</td>
							    <td>
			      				<? if($fila['sexo']==1){
										$sexo= "Femenino";
									}else{
										$sexo= "Masculino";
									}?>
									<?=$sexo?>
								&nbsp;</td>
						      </tr>
							  <tr class="textosimple">
							    <td>Establecimiento Procedencia</td>
							    <td><input name="txtproc" type="text" id="txtproc" value="<?=$fila["colegioprocedencia"] ?>"></td>
							  </tr>
							  <tr>
							    <td colspan="2"  class="textosimple">Promedio de notas 7&deg; a&ntilde;o y promedio general de 8&deg; a&ntilde;o (1&deg; y 2&deg; trimestre o 1&deg; semestre) </td>
						      </tr>
							  <tr  class="textosimple">
							    <td height="28" colspan="2">7&deg; a&ntilde;o 
						        <input name="prom7" type="text" id="prom7" size="4" maxlength="3" value="<?=$fila["prom7"] ?>">
						        (1 decimal) 8&deg; a&ntilde;o 
						        <input name="prom8" type="text" id="prom8" size="4" maxlength="3" value="<?=$fila["prom8"] ?>"> 
						        Prom. Postulaci&oacute;n 
						        <input name="prompostu" type="text" id="prompostu" size="4" maxlength="3" value="<?=$fila["prom_postu"] ?>"></td>
						      </tr>
							  <tr>
							  <td height="23" colspan="2">&nbsp;</td>
							  </tr>
							  <tr>
							    <td height="313" colspan="2">
								<table border="0">
                                  <tr class="tableindex">
                                    <td height="39" colspan="4">Preferencia de la postulaci&oacute;n </td>
                                  </tr>
                                  <tr>
                                    <td colspan="3" width="370">
									
									<table>
									
									<? 
									$sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
							  		$resultcorp= @pg_Exec($conn,$sqlcorp);
									$filacorp = @pg_fetch_array($resultcorp,0);
									$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
									$result2= @pg_Exec($conn,$sqlinsti);
									
								 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila2 = @pg_fetch_array($result2,$z); ?>
									<tr class="textosimple">
									<td><?= $fila2['nombre_instit'] ?></td>
									</tr>
									<? } ?>
									</table>
									</td>
                                    <td width="385">
									<table>
                                      <tr class="textosimple">
                                        <td><strong>
                                          <center>Preferencias</center>
                                        </strong></td>
                                      </tr>
                                      <tr class="textosimple">
                                        <td>1&deg;
								<? 
                                echo "<select name='pref1' class='ddlb_9_x' id='pref1'>";
								
								if ($fila["prefe_1"]!=0){
										$sqlnom ="select nombre_instit from institucion where rdb=".$fila["prefe_1"];
										$resultnom= @pg_Exec($conn,$sqlnom);
										$filanom = @pg_fetch_array($resultnom,0);
										echo "<option value='".$fila["prefe_1"]."' selected>".$filanom["nombre_instit"]."</option>";
							 
							 	}else{
								echo "<option value=0 selected>(Seleccione Institucion)</option>";
										 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
											{  
											$fila3 = @pg_fetch_array($result2,$z); 
											
											if (($fila3['rdb'] == $cmb_insti) or ($fila3['rdb'] == $cmb_insti)){
											   echo "<option value=".$fila3['rdb']." selected>".$fila3['nombre_instit']." </option>";
											}else{	    
											   echo "<option value=".$fila3['rdb'].">".$fila3['nombre_instit']." </option>";
											}
									}
								}
								 echo "</select>";
								 ?></td>
                                      </tr>
                                      <tr class="textosimple">
                                        <td>2&deg;
                                            
								<? echo "<select name='pref2' class='ddlb_9_x' id='pref2'>";
											
								if ($fila["prefe_2"]!=0){
										$sqlnom ="select nombre_instit from institucion where rdb=".$fila["prefe_2"];
										$resultnom= @pg_Exec($conn,$sqlnom);
										$filanom = @pg_fetch_array($resultnom,0);
										echo "<option value='".$fila["prefe_2"]."' selected>".$filanom["nombre_instit"]."</option>";
							 
							 	}else{
											echo "<option value=0 selected>(Seleccione Institucion)</option>";
											 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
											{  
											$fila4 = @pg_fetch_array($result2,$z); 
											
											if (($fila4['rdb'] == $cmb_insti) or ($fila4['rdb'] == $cmb_insti)){
											   echo "<option value=".$fila4['rdb']." selected>".$fila4['nombre_instit']." </option>";
											}else{	    
											   echo "<option value=".$fila4['rdb'].">".$fila4['nombre_instit']." </option>";
											}
										 } 
								 }
                                  echo "</select>"; ?>
                                        </td>
                                      </tr>
                                      <tr class="textosimple">
                                        <td>3&deg;
                                    <?
								echo "<select name='pref3' class='ddlb_9_x' id='pref3'>"; 
									if ($fila["prefe_3"]!=0){
										$sqlnom ="select nombre_instit from institucion where rdb=".$fila["prefe_3"];
										$resultnom= @pg_Exec($conn,$sqlnom);
										$filanom = @pg_fetch_array($resultnom,0);
										echo "<option value='".$fila["prefe_3"]."' selected>".$filanom["nombre_instit"]."</option>";
							 
							 	}else{
                                        echo "<option value=0 selected>(Seleccione Institucion)</option>";
                                     for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila5 = @pg_fetch_array($result2,$z); 
									
									if (($fila5['rdb'] == $cmb_insti) or ($fila5['rdb'] == $cmb_insti)){
									   echo "<option value=".$fila5['rdb']." selected>".$fila5['nombre_instit']." </option>";
									}else{	    
									   echo "<option value=".$fila5['rdb'].">".$fila5['nombre_instit']." </option>";
									}
								 } 
								 }
                                  echo "</select>"; ?>
                                        </td>
                                      </tr>
                                      <tr class="textosimple">
                                        <td>4&deg;
                                    <? echo "<select name='pref4' class='ddlb_9_x' id='pref4'>";
                                     if ($fila["prefe_4"]!=0){
										$sqlnom ="select nombre_instit from institucion where rdb=".$fila["prefe_4"];
										$resultnom= @pg_Exec($conn,$sqlnom);
										$filanom = @pg_fetch_array($resultnom,0);
										echo "<option value='".$fila["prefe_4"]."' selected>".$filanom["nombre_instit"]."</option>";
							 
							 		}else{
									 echo "<option value=0 selected>(Seleccione Institucion)</option>";
                                    for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila6 = @pg_fetch_array($result2,$z); 
									
									if (($fila6['rdb'] == $cmb_insti) or ($fila6['rdb'] == $cmb_insti)){
									   echo "<option value=".$fila6['rdb']." selected>".$fila6['nombre_instit']." </option>";
									}else{	    
									   echo "<option value=".$fila6['rdb'].">".$fila6['nombre_instit']." </option>";
									}
								 } 
								 }
								 ?>
                                            </select>
                                        </td>
                                      </tr>
                                      <tr class="textosimple">
                                        <td>5&deg;
                                   <?
										echo "<select name='pref5' class='ddlb_9_x' id='pref5' >";
                                        
									 if ($fila["prefe_5"]!=0){
										$sqlnom ="select nombre_instit from institucion where rdb=".$fila["prefe_5"];
										$resultnom= @pg_Exec($conn,$sqlnom);
										$filanom = @pg_fetch_array($resultnom,0);
										echo "<option value='".$fila["prefe_5"]."' selected>".$filanom["nombre_instit"]."</option>";
							 
							 		}else{
										
									echo "<option value=0 selected>(Seleccione Institucion)</option>";
                                         for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila7 = @pg_fetch_array($result2,$z); 
									
									if (($fila7['rdb'] == $cmb_insti) or ($fila7['rdb'] == $cmb_insti)){
									   echo "<option value=".$fila7['rdb']." selected>".$fila7['nombre_instit']." </option>";
									}else{	    
									   echo "<option value=".$fila7['rdb'].">".$fila7['nombre_instit']." </option>";
									}
								 } 
								 }
								 ?>
                                            </select>
                                        </td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4">&nbsp;</td>
                                  </tr>
                                </table></td>
						      </tr>
							  <tr class="tableindex">
							    <td colspan="2">Datos Para el Establecimiento </td>
						      </tr>
							  <tr class="textosimple">
							    <td>Fecha Nacimiento:
								<? if($fila["fecha_nac"]==""){ 
									echo "&nbsp;";
										}else{
								echo date("d-m-Y",strtotime($fila["fecha_nac"]));
						    	 }?>
							<!--<input type="button" id="txtFecha" class="botadd" value=".">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha",      // id of the input field
										ifFormat       :    "%m-%d-%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true*/
									});
									</script>--></td>
						        <td>Edad al 31 de Marzo de 2009 
					            <input name="txt_edad" type="text" id="txt_edad" size="3" value="<?=$fila["edad31mar"] ?>"></td>
							  </tr>
							  <tr class="textosimple">
							    <td>Domicilio Particular </td>
							    <td><?=$fila["calle"]?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>N&uacute;mero Domicilio </td>
							    <td><?=$fila["nro"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Sector o cerro </td>
							    <td><?=$fila["cerro"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Cuidad</td>
								<?  $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila["region"]." and cor_pro= ".$fila["ciudad"];
		      						//$qryPRO		="SELECT * FROM region WHERE COD_REG=".$fila["region"];
									$resultPRO	=@pg_Exec($connRPC,$qryPRO);
									$filaPRO = @pg_fetch_array($resultPRO,0);
			      					?>
							    <td><?=$filaPRO['nom_pro'] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Tel&eacute;fono</td>
							    <td><?=$fila["telefono"] ?></td>
						      </tr>
							  <tr class="textosimple">
							    <td>Tipo Procedencia</td>
								<td><?php
									echo "<select name='cmbproce'>";
									switch ($fila["id_procedencia"]) {
										case 1:
											echo "<option value='1' selected>Municipal</option>";
											break;
										case 2:
											echo "<option value='2' selected>Particular Suvencionado</option>";
											break;
										case 3:
										echo "<option value='3' selected>Particular</option>";
											break;
										default:
								echo "<option value='1'>Municipal</option> <option value='2'>Particular Suvencionado</option> <option value='3'>Particular</option> </select>";

											break;
									}
									?>&nbsp;</td>
						      </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
						      </tr>
							  <tr>
							    <td colspan="3"><div align="center">
<input type="button" onClick="ver_confirm2()" name="btnguardar" value="Guardar" class="botonXX">						          
<input type="reset" name="btncancel" value="Cancelar" class="botonXX">
						        </div></td>
						      </tr>
							</table>
                        </form></td>
                    </tr>	
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
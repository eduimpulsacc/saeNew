<?	require('../../../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
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
<!--<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->
<SCRIPT language="JavaScript">
function enviapag3(f2){
    f2.submit(true);		
}
function enviapag2(f1){
    f1.submit(true);		
}
function enviapag(){
	form.submit(true);
}
function valida(){

	if(document.f1.cmb_ense.value==0){
	alert('DEBE SELECCIONAR UN TIPO ENSEÑANZA')
	document.f1.cmb_ense.focus();
	return false;
	}
	if(document.f2.cmb_curso.value==0){
	alert('DEBE SELECCIONAR UN CURSO')
	document.f2.cmb_curso.focus();	
	return false;
	}
	if(document.form.cmb_alumnos.value==0 && document.form.cmb_estados.value==0){
	alert('DEBE SELECCIONAR UN ALUMNO O UN ESTADO')
	document.form.cmb_alumnos.focus();	
	return false;
	}
	
	if(document.form.acta.checked==true){
	// alert('dentro');
		pag="PrintInformeActas.php";
		form.action = pag; 
		form.target="_blank";
		form.submit(true);	
	}else{
	//alert('fuera');
		pag="PrintInformePracticas.php";
		form.action = pag; 
		form.target="_blank";
		form.submit(true);
	
	}
 
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
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>><? include("../../../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	

					<center>		 
		 <table width="86%" border="0" cellpadding="0" cellspacing="0">
            
            <tr>
              <td colspan="4" class="tableindex">REPORTE</td>
              </tr>
            <tr>
              <td colspan="4" class="tablatit2-1">&nbsp;</td>
              </tr>
			
            
              <td width="21%" class="cuadro01">Tipo Ense&ntilde;anza
                        <td width="2%" class="cuadro01">:                        
                        <td width="77%" class="cuadro01">
                        <form method="post" name="f1" action="">
                       
                          <select name="cmb_ense" id="cmb_ense" onChange="enviapag2(this.form);">
                            <option value="0">Seleccione el Tipo enseñanza</option>
                            <?
              		$sql="select distinct a.nombre_tipo,cod_tipo from tipo_ensenanza a inner join ";
					$sql.= " curso b on (a.cod_tipo=b.ensenanza) where b.id_ano=$ano and b.ensenanza>300";
					$rs_ense = pg_exec($conn,$sql);
					
				 for($i=0;$i<pg_numrows($rs_ense);$i++){
					$combo=pg_fetch_array($rs_ense,$i);
					if($combo['cod_tipo']==$cmb_ense){		
			  ?>
                            <option value="<?=$combo['cod_tipo'];?>" selected="selected">
                            <?=ucfirst($combo['nombre_tipo']);?>
                            </option>
                            <? }else{ ?>
                            <option value="<?=$combo['cod_tipo'];?>">
                            <?=ucfirst($combo['nombre_tipo']);?>
                            </option>
                            <? }
		 } ?>
                          </select>
              </form>                        
            <tr>
             <td class="cuadro01">Cursos
             <td class="cuadro01">:                        
             <td width="77%" class="cuadro01">
             <form method="post" name="f2" action="">
             <input type="hidden" name="cmb_ense" value="<?=$cmb_ense?>"/>
             <select name="cmb_curso" id="cmb_curso" onChange="enviapag3(this.form);">
                                <option value="0">Seleccione el curso</option>
                                <?
              		$sql_curso="select distinct id_curso,grado_curso,letra_curso from curso where ensenanza=$cmb_ense";
					$sql_curso.=" and id_ano=$ano and grado_curso=4";
					$rs_curso = pg_exec($conn,$sql_curso);
					
				for($j=0;$j<pg_numrows($rs_curso);$j++){
			  		$combo_curso=pg_fetch_array($rs_curso,$j);
					if($combo_curso['id_curso']==$cmb_curso){
			    
			  ?>
                                <option value="<?=$combo_curso['id_curso'];?>" selected="selected">
                                <?=ucfirst($combo_curso['grado_curso']."".$combo_curso['letra_curso']);?>
                                </option>
                                <? }else{ ?>
                                <option value="<?=$combo_curso['id_curso'];?>">
                                <?=ucfirst($combo_curso['grado_curso']."".$combo_curso['letra_curso']);?>
                                </option>
                                <? }
		 } ?>
                              </select>
                          </form> 
            <tr>
              <td class="cuadro01">Alumnos
                        <td class="cuadro01">:                        
                        <td width="77%" class="cuadro01">
                        <form method="post" name="form" action="PrintInformePracticas.php" target="_blank">
						<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
                            
                             
                                <select name="cmb_alumnos" id="cmb_alumnos" onChange="document.getElementById('cmb_estados').disabled=this.value>1,(document.getElementById('cmb_estados').value=0)=this.value>1">
                                  <option value="0">Seleccione el Alumno</option>
                                  <option value="1">(Todos)</option>
                                  <?
              		$sql_alumnos="select a.rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat from alumno a inner join ";
					$sql_alumnos.=" matricula b on (a.rut_alumno=b.rut_alumno) where b.id_ano=$ano and b.id_curso=$cmb_curso ";
					$sql_alumnos.=" and b.rdb=$institucion ";
					$rs_alumno = pg_exec($conn,$sql_alumnos);
					
				for($k=0;$k<pg_numrows($rs_alumno);$k++){
			  		$combo_alumnos=pg_fetch_array($rs_alumno,$k);
					if($combo_alumnos['rut_alumno']==$cmb_alumnos){
			    
			  ?>
                                  <option value="<?=$combo_alumnos['rut_alumno'];?>" selected="selected">
                                    <?=ucfirst($combo_alumnos['nombre_alu']." ".$combo_alumnos['ape_pat']." ".$combo_alumnos['ape_mat']);?>
                                    </option>
                                  <? }else{ ?>
                                  <option value="<?=$combo_alumnos['rut_alumno'];?>">
                                    <?=ucfirst($combo_alumnos['nombre_alu']." ".$combo_alumnos['ape_pat']." ".$combo_alumnos['ape_mat']);?>
                                    </option>
                                  <? }
		 } ?>
                                </select>
                       
                             
                              <tr>
              <td class="cuadro01">Estados
              <td class="cuadro01">:              
              <td width="77%" class="cuadro01"><select name="cmb_estados" id="cmb_estados">
                          <option value="0">Seleccione el Estado</option>
                          <option value="100">(Todos)</option>
                          <?
              		$sql_es="select * from estado_practica order by cod_estado DESC ";
					$rs_estado = pg_exec($conn,$sql_es);
					
				for($x=0;$x<pg_numrows($rs_estado);$x++){
			  		$combo_es=pg_fetch_array($rs_estado,$x);
					if($combo_es['cod_estado']==$cmb_estados){
			    
			  ?>
                          <option value="<?=$combo_es['cod_estado'];?>" selected="selected">
                          <?=$combo_es['nombre_estado'];?>
                          </option>
                          <? }else{ ?>
                          <option value="<?=$combo_es['cod_estado'];?>">
                          <?=$combo_es['nombre_estado'];?>
                          </option>
                          <? }
		 } ?>
                        </select>
              <label></label>
                                            <tr>
              <td colspan="2" class="cuadro01"><p></p>            
              <td width="77%" class="cuadro01"><!--<input type="checkbox" name="nomina" id="nomina">
                NOMINA              -->
              
                <input type="checkbox" name="acta" id="acta" value="1">
Acta 
              <tr>
              <td colspan="2" class="cuadro01">
              <td width="77%" class="cuadro01">
              <input type="hidden" name="cmb_curso" value="<?=$cmb_curso?>">
              <input type="button" name="buscar" value="BUSCAR"  class="botonXX" onClick="valida(this.form);">  
              <!--<input type="button" name="estadisticas" value="ESTADISTICAS"  
              onclick="window.open('InformeEstadisticoPracticas.php','','width=650,height=750,resizable=yes,scrollbars=yes');void(false)"class="botonXX"> -->
                            <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
              </form>             
              </table>
		  <!-- FIN CUERPO DE LA PAGINA -->								  </td>
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
<? pg_close($conn);?>
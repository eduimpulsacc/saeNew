<?	require('../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 4;
	$_bot = 8;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}


if($curso!=""){
		$qryplan ="SELECT * FROM CURSO WHERE id_curso = '$curso'";
		$resultplan = pg_Exec($conn,$qryplan);
		$rowplan = pg_fetch_array($resultplan);
		$_PLAN=$rowplan[cod_decreto];
		if(!session_is_registered('_PLAN')){
				session_register('_PLAN');
		};
}	

/// guardamnos si existe el boton guardar.
if (isset($_POST['guardar'])){
     
		$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto, bloq_nota  ";
		$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$_ANO.")) $whe_perfil_curso  ";
		$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";											
		$resultado_query_cue = pg_exec($conn,$sql_curso);	
		
		
		for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){  
			 $fila = @pg_fetch_array($resultado_query_cue,$i); 
			 $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
			 $bloq_nota = $fila['bloq_nota'];
			 $id_curso  = $fila['id_curso'];
		
			 $che = "che".$i;
			 $che = $$che;
			 
			 if ($che==1){
				  $sql_up = "update curso set bloq_nota='1' where id_curso = '$id_curso'";
				  $res_up = pg_Exec($conn, $sql_up);
			 }else{
				  $sql_up = "update curso set bloq_nota='0' where id_curso = '$id_curso'";
				  $res_up = pg_Exec($conn, $sql_up);				 
			 }				
		}     
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
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

function enviapag(form){
	 var curso2, frmModo; 
	 curso2=form.cmb_curso.value;
	 frmModo = "mostrar";
	
	 if (form.cmb_curso.value!=0){
		 form.cmb_curso.target="self";
		 pag="../institucion/ano/curso/seteaCurso.php3?caso=11&curso="+curso2+"&frmModo="+frmModo+"&p=19";
		 form.action = pag;
		 form.submit(true);	
	 }		
}


function marcar(){ 
   for (i=0;i<document.form.elements.length;i++){ 
      if(document.form.elements[i].type == "checkbox"){
	     
		 if (document.form.opcion.checked==1){
	         document.form.elements[i].checked=1;
		 }else{
		     document.form.elements[i].checked=0;
		 }	  
	  }
   }	  	 	  
} 



//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="muestra('listado');">
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
				include("../../cabecera/menu_superior.php");
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
						include("../../menus/menu_lateral.php");
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
                                  <td valign="top">
								  
							
								 
								  <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                    <tr>
                                      <td width="100%" class="tableindex">BLOQUEO DE NOTAS POR CURSO </td>
                                    </tr>
									<?
									for ($i=0; $i < @pg_numrows($res_cic_niv); $i++){
										?>
                                  <? } ?>
                                  </table>
								  <br>
								  <form name="form"  action="#" method="post">	
								  <table width="100%" border="1">
                                    <tr>
                                      <td><div align="right">
                                        <? if ($situacion !=0){
										if (!isset($_POST['editar'])){  ?>										
										    <label>
                                              <input name="editar" type="submit" class="botonXX" id="editar" value="EDITAR">
                                            </label>
									 <? }
										}//cierre if año escolar?>
									    <?
										if (isset($_POST['editar'])){
										     $swe=1;
										     ?>		
                                            <label>
                                              <input name="guardar" type="submit" class="botonXX" id="guardar" value="GUARDAR">&nbsp;
											  <input name="volver" type="submit" class="botonXX" id="volver" value="VOLVER">
                                            </label>
									 <? } ?> 		
                                      </div></td>
                                    </tr>
                                  </table>
								  
								  <table width="100%" border="1">
                                    <tr>
                                      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">CURSO:</font> 
                                        <label>
                                        							  
										   <?
										  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>									  
											<? 
											$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto, bloq_nota  ";
											$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
											$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$_ANO.")) $whe_perfil_curso  ";
											$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";											
											$resultado_query_cue = pg_exec($conn,$sql_curso);										
											 ?>										 
											<table width="50%" cellpadding="0" cellspacing="0" border="0" align="center">
											    <?
												if (isset($_POST['editar'])){ ?>												
												 	<tr>
												       <td width="10%" height="30">
													    <input type="checkbox" name="opcion" value="1" onClick="marcar()" >												      </td>
														<td width="90%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">Marcar / Desmarcar Todos</font></td>
											  </tr>
											 <? } ?>		 
											
											
											
											
												 <?
												 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i){  
													 $fila = @pg_fetch_array($resultado_query_cue,$i); 
													 $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													 $bloq_nota = $fila['bloq_nota'];
													 
													 if ($bloq_nota==1){
													    $candado = "candado_cerrado2.png";
													 }else{
													    $candado = "candado_abierto2.png";
													 }													 
													 
													 ?>
													 <tr>
												       <td width="10%">
													   <?
													   if (!isset($_POST['editar'])){ ?>													   
													         <img src="<?=$candado?>" height="30">
													<? }else{ ?>
													        <input type="checkbox" name="che<?=$i?>" value="1" <? if ($bloq_nota==1){ ?> checked="checked" <? } ?>>
													<? } ?>				 
													   
													   
											         </td>
														<td width="90%"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><?  echo   $Curso_pal;  ?></font></td>
													 </tr>
													 <? 														   
												 }												
												 ?>
										   </table> 
									       
                                      </label></td>
                                    </tr>
                                  </table>								  
								  </form>
												  
								  
								  </td>
                                </tr>
                              </table>
							 							  
							                                
							  </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../cabecera/menu_inferior.php"); ?></td>
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
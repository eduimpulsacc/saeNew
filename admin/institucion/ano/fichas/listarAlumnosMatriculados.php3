<?php require('../../../../util/header.inc');?>
<?php 

if ($id_ano){

$_ANO=$id_ano;
	if(!session_is_registered('_ANO')){
		session_register('_ANO');
	};

}
if ($id_curso){

$_CURSO=$id_curso;
	if(!session_is_registered('_CURSO')){
		session_register('_CURSO');
	};

}
	$institucion	=$_INSTIT;
	$curso			=$_CURSO;
	$_POSP = 4;
	$ano	=	$_ANO;
	$_bot   = 5;
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//ANDcurso.ensenanza=".pg_result($rs_acceso,3)."
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND   id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=6)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&& ($_PERFIL!=35)&&($_PERFIL!=6)&&($_PERFIL!=22)&&($_PERFIL!=19)&&($_PERFIL!=32) &&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
		}



?>



<html>
	<head>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	

<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../curso/seteaCurso.php3?caso=11&p=10&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=8&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
</script>
</head>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
             <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <? $menu_lateral="3_1"; include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height=""><!--inicio nuevo codigo -->
								  
	<center>
		
  <table WIDTH="90%" BORDER="0" CELLSPACING="1" CELLPADDING="3">
    <TR height=15> 
      <TD COLSPAN=6> 
	  <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
             <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" onChange="window.location='listarAlumnosMatriculados.php3?tipoFicha=<? echo $tipoFicha;?>&id_ano='+this.value">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }	?>
				
				
              </strong> </FONT> </TD>
          </TR>
		  
		  <TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										 <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="window.location='listarAlumnosMatriculados.php3?tipoFicha=<? echo $tipoFicha;?>&id_curso='+this.value">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
		  
		        if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
		           echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>	 
									</strong>
								</FONT>
							</TD></form>
						</TR>
		  
		  
		  
		  
		  
		  
        </TABLE>
		
		</TD>
    </TR>
    
	<?
	if ($_PERFIL!="6") { ?>
	   <tr>
       <td colspan=6 align=right>
		   <?
		   if (($_PERFIL!=2) and ($_PERFIL!=20)){ ?> 
              <INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="../curso/curso.php3"> 
         <? } ?>
		</td>
       
       </tr>
 <? } ?>   
	
	
	<tr height="20" class="tableindex"> 
      <td align="middle" colspan="6">  
        <?php 
		if($tipoFicha==1) {//FICHA MEDICA?>
               FICHA MEDICA
               TOTAL ALUMNOS MATRICULADOS <? if($curso>0){ ?>EN EL CURSO<? }?>
        <?php
		}
		if ($tipoFicha==2){ // FICHA DEPORTIVA ?>		
              FICHA DEPORTIVA<BR>
              TOTAL ALUMNOS MATRICULADOS
  <?php }
        if ($tipoFicha==3){  //FICHA  PSICOPEDAGOGICA  ?>
			FICHA PSICOPEDAGOGICA  <BR>
	<? } ?>			
  
  
        
        </td>
    </tr>
    <tr class="tablatit2-1"> 
      <td align="center" width="80">  
        RUT_ALUMNO </td>
      <td align="center" width="130"> APELLIDO PATERNO </td>
      <td align="center" width="150"> APELLIDO MATERNO</td>
      <td align="center" width="220"> NOMBRES </td>
      <td align="center" width="139"> CURSO </td>
      <td align="center" width="140"><? if ($tipoFicha==3){ ?> ESTADO <? }else{ ?>EMERGENCIA<? } ?></td>
    </tr>
    <?php 
	
	  // SELECCIONO SIEMPRE Y CUENDO TENGA UN CURSO SELECCIONADO
	  if ($curso!=0){
	
	//, alumno.psico_proceso
				$qry = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.grado_curso, curso.letra_curso, curso.ensenanza, tipo_ensenanza.nombre_tipo,curso.id_curso ";
				$qry = $qry . "FROM ((curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
				$qry = $qry . "WHERE ((curso.id_ano)=".$ano.") ";
				if($curso>0){
					$qry = $qry . "AND ((curso.id_curso)=".$curso.") ";
				}
				$qry = $qry . "ORDER BY curso.grado_curso, curso.letra_curso, curso.ensenanza, alumno.ape_pat, alumno.ape_mat,alumno.nombre_alu ; ";

				//$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
				$result = @pg_Exec($conn,$qry);
				
			?>
    <?php 
	for($i=0 ; $i < @pg_numrows($result) ; $i++){
		$fila = @pg_fetch_array($result,$i);
			?>
    <?php if($tipoFicha==1){ //FICHA MEDICA?>
    <tr bgcolor=#ffffff onmouseover=this.style.background='#ffff00';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('medicas/listarFichasAlumno.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1&curso=<? echo $fila[id_curso];?>')> 
      <?php }?>
      <?php if($tipoFicha==2){ //FICHA DEPORTIVA?>
    <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('deportivas/seteaFicha.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1&curso=<? echo $fila[id_curso];?>')> 
      <?php }?>
	  <?php if($tipoFicha==3){ //FICHA PSICOPEDAGOGICA?>
    <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('psicopedagogica/seteaFicha.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1&curso=<? echo $fila[id_curso];?>')> 
      <?php }?>
      <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong> 
        </font> </td>
      <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong><?php echo $fila["ape_pat"];?></strong> </font> </td>
      <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong><?php echo $fila["ape_mat"];?></strong> </font> </td>
      <td align="left"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong><?php echo $fila["nombre_alu"];?></strong> </font> </td>
      <td align="center"> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong> 
        <?php echo $fila["grado_curso"]." - ".$fila["letra_curso"]." ".$fila["nombre_tipo"];?>
        <font size="2"> 
        <!--input class="botonM" type="button" name="Emergencia" value="Emergencia" onClick=window.open("datosEmergenciaAlumno.php?alumno=<?php echo trim($fila["rut_alumno"])?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=650,top=85,left=140")-->
        </font> </strong> </font> </td>
      <td align="center">&nbsp;<?
	   if ($tipoFicha==3){ 
	     
		  if ($fila["psico_proceso"]==1){ 
		       echo "<font face=arial, geneva, helvetica size=1 color=#000000>En evaluación</font>";
		  }
		  if ($fila["psico_proceso"]==2){
		       echo "<font face=arial, geneva, helvetica size=1 color=#000000>Finalizado</font>";
		  } ?>
	        
	  
	<? }else{ ?>	  
		  <font face="arial, geneva, helvetica" size="1" color="#000000"><strong><font size="2"><a href=# onClick=window.open("datosEmergenciaAlumno.php?alumno=<?php echo trim($fila["rut_alumno"])?>","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=600,height=400,top=85,left=140")>Emergencia</a></font></strong></font>	  
	<? } ?>  
	  </td>
    </tr>
    <?php
					}

			?>
			
   <? }  // fin de if distinto de cero  ?>   			
    
  </table>
	
  </center>

								  
								  
								  
								  <!-- fin nuevo codigo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
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

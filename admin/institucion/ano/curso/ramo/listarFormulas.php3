<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	//-------
	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto from ((institucion inner join ano_escolar on institucion.rdb=ano_escolar.id_institucion)inner join curso on ano_escolar.id_ano=curso.id_ano)inner join tipo_ensenanza on curso.ensenanza = tipo_ensenanza.cod_tipo where curso.id_curso=".$curso;
	$rsCurso =@pg_Exec($conn,$sqlCurso);												
	$fCurso = @pg_fetch_array($rsCurso,0);		
	//-------	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
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
				pag="../seteaCurso.php3?caso=11&p=2&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

</script>
					
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	

</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="95%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
       </td>
  </tr>
</table>
<?php } ?>
<center>
  <table width="95%" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> <table border=0 cellspacing=1 cellpadding=1 height="100%">
          <tr> 
            <td align=left><font face="arial, geneva, helvetica" size=2><strong>INSTITUCION</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nombre_instit']); ?></strong></font></td>
          </tr>
          <tr> 
            <td align=left><font face="arial, geneva, helvetica" size=2><strong>AÑO 
              ESCOLAR</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso['nro_ano']); ?></strong></font></td>
          </tr>
          <tr> 
            <td align=left><font face="arial, geneva, helvetica" size=2><strong>CURSO</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></td>
            <td><font face="arial, geneva, helvetica" size=2><strong> 
             
			      <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		  
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>	 
			 
			 
              </strong> </font> </td></form>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan=5 align=right> 
        <?php if ($situacion !=0){ 
		if($_PERFIL!=17){?>
        <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
        <?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
								if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){?>
        <input name="button" type="button" class="botonXX" onClick=document.location="seteaFormula.php3?caso=2"  value="AGREGAR"> 
        <?php }
		}?>
        <?php }?>
        <?php }?>
        <?php }?>
        <input name="button2" type="button" class="botonXX" onClick=document.location="../seteaCurso.php3?caso=4"  value="VOLVER"> 
      </td>
    </tr>
    <tr height="20" class="tableindex"> 
      <td align="middle" colspan="5">TOTAL DE ASIGNATURAS FORMULAS</td>
    </tr>
    <tr height="20" class="tableindex">
      <td align="middle" colspan="5">&nbsp;</td>
    </tr>
    <tr class="tablatit2-1"> 
      <td width="92" align="center">ASIGNATURA 
        PADRE</td>
      <td align="center" width="84">ASIGNATURA 
        HIJA</td>
      <td align="center" width="302">ASIGNATURA 
        </td>
	  <td align="center" width="100">FORMULA 
        </td>	
    </tr>
    <?php
				$qry="SELECT ramo.id_ramo, subsector.nombre, id_formula, modo FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula ON ramo.id_ramo=formula.id_ramo WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
    <?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						
						$formula = $fila['modo'];
						if ($formula==1){
							$formula = "Modo 1";
						}
						if ($formula==2){
							$formula = "Modo 2";
						}
						if ($formula==3){
							$formula = "Modo 3";
						}	
			?>
   <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFormula.php3?formula=<?php echo $fila["id_formula"];?>&caso=1&modo=<? echo $fila['modo']; ?>')>
	  <td align="center">&nbsp;<img src="../../../../../cortes/tic.gif" width="16" height="15"></td>
	  <td>&nbsp;</td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila['nombre'];?></font></td>
	  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $formula;?></font></td>
	</tr>	
    <?php
						
						$qry="SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE (((formula_hijo.id_formula)=" . $fila['id_formula'] ."))";
						$Rs_Hijo   =@pg_Exec($conn,$qry);
						if (!$Rs_Hijo) {
							error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
						}else{
							if (pg_numrows($Rs_Hijo)!=0){
								$fila_hijo = @pg_fetch_array($Rs_Hijo,0);	
								if (!$fila_hijo){
									error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
									exit();
								}
							}
							for($j=0;$j<pg_numrows($Rs_Hijo);$j++){
								$fila_hijo = pg_fetch_array($Rs_Hijo,$j);
								
							?>
							  <tr> 
							  <td>&nbsp;</td>							  
						      <td align="center">&nbsp; <img src="../../../../../cortes/tic.gif" width="16" height="15"></td>
							  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;<? echo $fila_hijo['nombre'];?></font></td>
							  <td>&nbsp;<font size="1" face="arial, geneva, helvetica">&nbsp;</font></td>
							</tr>
							
							<?
							}		
						}
					}
				}		
						?>
						
   
    
    
  </table>
  
</center>

								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

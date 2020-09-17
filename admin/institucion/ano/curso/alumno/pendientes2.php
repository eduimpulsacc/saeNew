<?php 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	if ($cmb_curso > 0){
	    $_CURSO = $cmb_curso;
	}
	 
	$curso			=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	
		
//if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
//if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
		
			
	if (trim($_url)=="") $_url=0;

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

<SCRIPT language="JavaScript">
	function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.action = 'pendientes1.php?cmb_curso<?=$cmb_curso ?>';
		form.submit(true);

		}	
	}			
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
	
	function valida(form){
		if(!chkSelect(form.cmb_periodos,'Debe Seleccionar PERIODO.')){
			return false;
		};
		if(!chkSelect(form.cmb_curso,'Debe Seleccionar CURSO.')){
			return false;
		};
		if(!chkSelect(form.cmb_subsector,'Debe Seleccionar SUBSECTOR.')){
			return false;
		};
		
	    return true;
	}
</script>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo7 {font-size: 14px}
.Estilo8 {font-size: 12px}
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="" valign="top"><div align="center">
                                    <!--inicio codigo nuevo -->
                                    <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td class="tableindex"><div align="center">ALUMNOS PENDIENTES DE NOTAS </div></td>
                                      </tr>
                                    </table>
                                    
                                  </div>
								  
  
  <form name="form1" method="post" action="pendientes3.php">
	<table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bordercolor="e5e5e5">               
        <tr>
          <td width="20%"><span class="Estilo1">Instituci&oacute;n</span></td>
          <td><span class="Estilo1"> : 
		  <?
		  $q1 = "select * from institucion where rdb = '".trim($institucion)."'";
		  $r1 = @pg_Exec($conn,$q1);
		  $f1 = @pg_fetch_array($r1,0);
		  $nombre_institucion = $f1['nombre_instit'];
		  echo $nombre_institucion;
		  ?>	  
		  </span></td>
        </tr>
        <tr>
          <td><span class="Estilo1">A&ntilde;o</span></td>
          <td><span class="Estilo1">: 
		  <?
		  $q2 = "select * from ano_escolar where id_ano = '".trim($ano)."' and id_institucion = '".trim($institucion)."'";
		  $r2 = @pg_Exec($conn,$q2);
		  $f2 = @pg_fetch_array($r2,0);
		  $nro_ano = $f2['nro_ano'];
		  echo $nro_ano;
		  ?>	  
		  </span></td>
        </tr>        
		<tr>
          <td><span class="Estilo1">Periodo</span></td>
          <td><span class="Estilo1">:
		  <?
		  $q3 = "select * from periodo where id_periodo = '".trim($cmb_periodos)."'";
		  $r3 = @pg_Exec($conn,$q3);
		  $f3 = @pg_fetch_array($r3,0);
		  $nombre_periodo = $f3['nombre_periodo'];
		  echo $nombre_periodo;
		  ?></span>
            <input type="hidden" name="periodo_pn" value="<?=$cmb_periodos ?>"></td>
        </tr>
		<tr>
          <td><span class="Estilo1">Curso</span></td>
          <td><font face="arial, geneva, helvetica" size=2>: 
            
            <?					  
   		    $Curso_pal = CursoPalabra($cmb_curso, 1, $conn);
		    echo $Curso_pal;		    
		    ?>
            
            <input type="hidden" name="curso_pn" value="<?=$cmb_curso ?>">
          </font></td>
        </tr>
        <tr>
          <td><span class="Estilo1">Subsector</span></td>
          <td><span class="Estilo1">: 
		    <?
			$sql_sub = "select ramo.id_ramo, subsector.nombre from ramo, subsector ";
			$sql_sub = $sql_sub  . "where id_curso = ".$cmb_curso." and ramo.cod_subsector = subsector.cod_subsector and ramo.id_ramo = '$cmb_subsector' order by id_orden";
			$resultado_sub = @pg_exec($conn,$sql_sub);
		    $fila = @pg_fetch_array($resultado_sub,0);				     
			echo ucwords(strtolower($fila["nombre"]));
			
			?></span> <input type="hidden" name="subsector_pn" value="<?=$cmb_subsector ?>"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><div align="right">
            <label>
            <input name="Submit2" class="BotonXX" type="button" onClick="MM_goToURL('parent','pendientes1.php');return document.MM_returnValue" value="VOLVER">
            </label>
          </div></td>
        </tr>
        <tr>
          <td colspan="2"><span class="Estilo1">
		  <?
		  // aqui buscar los alumnos todos o uno en particular
		  if ($cmb_alumno==0){		      
		      // busco todos los alumnos
		      $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = '".trim($cmb_curso)."' and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		      $result= @pg_Exec($conn,$sql);			    		  
		  }else{
		      $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = '".trim($cmb_curso)."' and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '".trim($cmb_alumno)."' order by ape_pat, ape_mat, nombre_alu";
		      $result= @pg_Exec($conn,$sql);
		  }	  
		      
		  
		  ?>	  
		  </span>
		  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="E5E5E5">
            <tr class="tableindex_01">
              <td width="40%" height="35" class="tableindex"><div align="center" class="Estilo1">Alumnos</div></td>
              <td width="10%" class="tableindex"><div align="center" class="Estilo1">Pendiente</div></td>
              <td width="50%" class="tableindex"><div align="center" class="Estilo1">Observaci&oacute;n</div></td>
            </tr>
			
			<? 
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
			    $fila = @pg_fetch_array($result,$i);
				$rut_alumno = $fila['rut_alumno'];
				$num_pen = 0;
								
				// busco si ya esta en la tabla alumnos_pendientes
				$qry_pen  = "select * from alumnos_notaspendientes where rdb = '".trim($institucion)."' and id_ano = '".trim($ano)."' and id_curso = '".trim($cmb_curso)."' and id_ramo = '".trim($cmb_subsector)."' and rut_alumno = '".trim($rut_alumno)."' and id_periodo = '".trim($cmb_periodos)."'";
				$res_pen  = @pg_Exec($conn,$qry_pen);
				$num_pen  = @pg_numrows($res_pen);
				$fila_pen = @pg_fetch_array($res_pen,0);
				$observacion = $fila_pen['observacion'];
				 	
							          
			    ?>
			    <tr>
				  <td><span class="Estilo10"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></span></td>
				  <td><div align="center">
					<label>
					 <input type="checkbox" name="ch<?=$i ?>" value="<?=$fila['rut_alumno'] ?>" <? if ($num_pen>0){ ?> checked="checked" <? } ?>>
					</label>
				  </div></td>
				  <td><label>
				    <div align="center">
				      <input name="observacion<?=$i ?>" type="text"  size="40" value="<?=$observacion ?>">
				        </div>
				  </label></td>
			    </tr>
				<?
			}
			?>	
          </table></td>
          </tr>
		<tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><div align="center">
            <label>
            <input type="submit" name="Submit" value="ACTUALIZAR INFORMACI&Oacute;N" class="BotonXX"  onClick="return valida(this.form);">
            </label>
          </div></td>
          </tr>
      </table>
	  <br>
     </FORM></td>
</tr>
</table>
	 							  
				  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td height="" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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
<? pg_close($conn); ?>
</body>
</html>

<?php 	require('../../../../util/header.inc');?>
<?php 
    
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	echo"--->".$cmb_curso=$_REQUEST["cmb_curso"];
	$cmb_acti=$_REQUEST["cmb_acti"];
	$_PERFIL;
	$_POSP          =4;
	$_MDINAMICO     =1;
	if($_PERFIL==26)
	{
		$_MDINAMICO     =0;		
	}	
	
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
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	?>

	  		<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
     function enviapag(form){
		    var curso; 
			curso=document.form.cmb_curso.value;
			
 			if (document.form.cmb_curso.value!=0){
			    document.form.cmb_curso.target="self";
				pag="lista_citacion.php3"
				document.form.action = pag;
				document.form.submit(true);	
			}		
		 }
		 function enviapag2(form){
		    var curso; 
			curso=document.form.cmb_acti.value;
			
 			if (document.form.cmb_acti.value!=0){
			    document.form.cmb_acti.target="self";
				pag="lista_citacion.php3"
				document.form.action = pag;
				document.form.submit(true);	
			}		
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

function valida_elimina(a,b,c,d){
    if(confirm('Esta seguro que desea eliminar registro?')){
	     window.location='elimina_citacion.php?alumno='+a+'&cita='+b;
		 
	}


}

//-->
</script>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
}
.Estilo3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php");
			?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include ("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="1" cellpadding="0" cellspacing="0" class="cajaborde" style=" border-collapse:collapse">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
		  
								  
								  
			 <FORM method="post" name="form" action="">
	
	        <input type="hidden" value="<?=$institucion ?>" name="rdb">
			<input type="hidden" value="<?=$ano ?>" name="ano">
	         
			 <table width="609" border="0" align="center" style=" border-collapse:collapse">
               <tr>
                 <td colspan="8" class="TABLEINDEX"><center>
                     LISTADO CITACIONES
                 </center></td>
               </tr>
               <tr>
                 <td width="103" class="textosimple">
      CURSOS:</td>
                 <td width="168" colspan="6" class="textosimple"><? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
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
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
                   </select>
&nbsp;</td>
                 <td class="textosimple">
                   <? if($ingreso==1){?>
                   <input type="button" class="botonxx" value="Agregar" onClick="document.location = 'citacion.php3'">&nbsp;
                   <? } ?>
                 </td>
                 </tr>
               <tr>
                 <td class="textosimple">ALUMNOS&nbsp;</td>
                 <td class="textosimple" colspan="6"><? 
							  $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,alumno.telefono, alumno.calle, alumno.nro, alumno.depto, alumno.region, alumno.ciudad, alumno.comuna, matricula.id_curso, matricula.nro_lista, matricula.bool_ar, matricula.num_mat FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$_REQUEST["cmb_curso"].") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
				 				$result =@pg_Exec($conn,$qry);
				 			//echo $fila_acti['rut_alumno'];
                 ?>
                   <select name="cmb_acti" class="ddlb_x" onChange="enviapag2(this.form);">
                   <option value=0 selected>(Seleccione un Alumno)</option>
                   <?
		     for($i=0 ; $i < @pg_numrows($result) ; $i++)
		      {  
		       $fila_acti = @pg_fetch_array($result,$i); 
				  if (($fila_acti['rut_alumno'] == $cmb_acti)){
		           echo "<option value=".$fila_acti['rut_alumno']." selected>".$fila_acti['nombre_alu']." ".$fila_acti['ape_pat']." </option>";
		        }else{	     
				echo "<option value=".$fila_acti['rut_alumno']." >".$fila_acti['nombre_alu']." ".$fila_acti['ape_pat']." </option>";
                }
		     } ?>
                   &nbsp;
                 </select></td>
                 <td class="textosimple">&nbsp;</td>
                 </tr>
               <tr>
                 <td class="textosimple">&nbsp;</td>
                 <td class="textosimple" colspan="6">&nbsp;</td>
                 <td class="textosimple">&nbsp;</td>
                 </tr>
               <tr>
                 <td height="57" colspan="8" class="textosimple"><table width="100%" border="1" style="border-collapse:collapse; text-align: center;">
                   <tr class="tabla01">
                     <td><b>Rut Alumno&nbsp;</b></td>
                     <td><b>Fecha&nbsp;</b></td>
                     <td><b>Observacion&nbsp;</b></td>
                     <td>Eliminar</td>
                     <td>Imprimir</td>
                   </tr>
                   
                     <?  $sql_cita="select * from citacion_apo where rut_alumno=".$cmb_acti;
			  	$result_cita =@pg_Exec($conn,$sql_cita);
				 for($i=0 ; $i < @pg_numrows($result_cita) ; $i++)
		      		{  
		       $fila_cita = @pg_fetch_array($result_cita,$i);
			  ?>
             
                   <tr>
                     <td><? echo $fila_cita["rut_alumno"]?></td>
                     <td><? echo $fila_cita["fecha"]?></td>
                     <td><? echo $fila_cita["observacion"]?></td>
                     <td><? if($elimina==1){?>
                       <input type="button" name="eliminar" value="Eliminar" class="botonxx" onClick="valida_elimina('<?php echo $cmb_acti?>','<?= $fila_cita["id_citacion"]?>')">
                       <? } ?></td>
                     <td> <a href="print_cita_apo.php?id=<?=$fila_cita['id_citacion'];?>&rut_alumno=<? echo $fila_cita["rut_alumno"]?>" target="_blank"> <img  src="../curso/print_cita.png" width="44" height="44" border="0"></a></td>
                   </tr>
                     <? }?>
                 </table></td>
                 </tr>
             
             </table>
			 </FORM>
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>"><font face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso2['nro_ano']); ?></strong></font></td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>

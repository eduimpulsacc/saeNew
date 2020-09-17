<?	require('../../../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$cmb_opcion;
	$r_opcion;
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>

<script language="javascript" type="text/javascript">

function enviapag(form){
			if (form.cmb_opcion.value!=0){
				form.target="_self";
				form.cmb_opcion.target="self";
				form.action = 'informe_simce.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
function enviapag2(form){
			if (form.cmb_curso.value!=0){
				form.target="_self";
				form.cmb_curso.target="self";
				form.action = 'informe_simce.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
					
		
function valida(form){

	if(form.cmb_opcion.value==0){
		alert('Debe seleccionar una opción para generar reporte');
		return false;
		}
	
	if(form.opcion.value==1){	
		if(form.cmb_opcion.value==1 & form.cmb_curso.value==0){
			alert('Debe seleccionar un curso');
			return false;
			}
		}
	form.submit(true);


}	


function enviapag3(form){ 
	var ano, frmModo; 
	ano2=form.cmb_ano.value;
		
	if (form.cmb_ano.value!="0"){	
		pag="../seteaAno.php3?caso=10&pa=38&ano="+ano2
		//ssssssspag="motor_informe_becas_beneficio.php?ano2="+ano2 
		form.action = pag; 
		form.target="_self";
		form.submit(true);		
	}		
 }	

			
</script>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->

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
    <td width="" height="" align="center" valign="top"> >>>>>>>>></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<table width="100%" border="0" class="cuadro01" cellpadding="0" cellspacing="0">
<form method="post" name="form" action="print_informe_simce.php" target="_blank">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
  <tr>
    <td colspan="3" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
    </tr>
  <tr>
    <td>&nbsp;&nbsp;A&ntilde;o</td>
    <td><?  $sql = "SELECT * FROM ano_escolar WHERE id_institucion =".$institucion." ORDER BY nro_ano ASC";
		$resp = pg_exec($conn,$sql);
		$num = pg_numrows($resp);
		
		?>
      <select name="cmb_ano" id="cmb_ano" class="ddlb_x" onChange="enviapag3(this.form);">
        <? for($i=0;$i<$num;$i++){
			$fila_ano = pg_fetch_array($resp,$i); 
			if($fila_ano['id_ano']==$ano){?>
        <option value="<?=$fila_ano['id_ano']?>" selected>
          <?=$fila_ano['nro_ano']?>
          </option>
		  <? }else{?>
		   <option value="<?=$fila_ano['id_ano']?>">
          <?=$fila_ano['nro_ano']?>
          </option>
		  <? }?>
        <? }?>
      </select>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="30%">&nbsp;&nbsp;Opción de reporte</td>
    <td width="30%"><select name="cmb_opcion" id="cmb_opcion" onChange="enviapag(this.form)" class="ddlb_9_x">
	 <option value="0" selected>(Seleccione su opción)</option>
	<option value="1"  <? if($cmb_opcion==1){?>selected="selected"<? }?>>ALUMNOS</option>
	<option value="2"  <? if($cmb_opcion==2){?>selected="selected"<? }?>>CURSOS</option>
    </select> 
	<input type="hidden" name="opcion" value="<?=$cmb_opcion?>">   </td>
    <td width="30%"><div align="left">
      <input name="cb_ok" type="button" class="botonXX" id="cb_ok" value="Buscar" onClick="valida(this.form)">
    <input type="submit" name="cb_ok2" class="botonXX" value="Exportar">
    <input name="cb_ok22" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
    </div></td>
  </tr>
  <tr>
   <? if($cmb_opcion==1){?>
    <td width="30%">&nbsp;&nbsp;Curso</td>
	<? }?>
	 <? if($cmb_opcion==1){
	 
	 $sql="SELECT DISTINCT a.id_curso,b.grado_curso,b.letra_curso,b.ensenanza FROM simce_notas_2009 a INNER JOIN ";
	 $sql.="curso b ON (a.id_curso=b.id_curso) WHERE b.id_ano=".$ano." 	ORDER BY b.letra_curso ASC";
	 $res_sql=@pg_exec($conn,$sql);
	 $conteo=pg_numrows($res_sql);
	
	
	if($conteo!=0){
	 ?> 
    <td width="30%">
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag2(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < $conteo ; $i++)
		        {  
		        $fila = @pg_fetch_array($res_sql,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select>     </td>
		<? }else{?>  
		
		  	<td>No hay alumnos con puntajes ingresados</td>
		  
		<? }?>  
	<td width="30%">&nbsp;</td>
	<? }?>
  </tr>
  <tr>
   <? if($cmb_curso!=NULL and $cmb_opcion==1){?>
    <td width="30%">&nbsp;&nbsp;Subsectores</td>
	<? }?>
	<? if($cmb_curso!=NULL and $cmb_opcion==1){?>
    <td width="30%">&nbsp;
      <table width="100%" border="0" class="cuadro01" cellpadding="0" cellspacing="0">
       <? 
	   $sql_sub="SELECT DISTINCT b.cod_subsector,b.id_sub_sim,c.nombre FROM simce_notas_2009 a INNER JOIN ";
	   $sql_sub.="simce_conf_2009 b ON (a.id_sub_sim=b.id_sub_sim) INNER JOIN subsector c ON ";
	   $sql_sub.="(b.cod_subsector=c.cod_subsector) WHERE b.rdb=".$institucion." and b.id_ano=".$ano." and ";
	   $sql_sub.="id_curso=".$cmb_curso."";
	   $res_sub=@pg_exec($conn,$sql_sub);
	   $conteo2=pg_numrows($res_sub);
	   
	   for($i=0;$i<$conteo2;$i++){
	   	$sub=pg_fetch_array($res_sub,$i);
	   ?> 
		<tr>
          <td><input name="chk<?=$i?>" type="checkbox" id="chk<?=$i?>" value="<?=$sub['id_sub_sim']?>">
		  <input type="hidden" name="contador" value="<?=$conteo2?>">
          &nbsp;<?=$sub['nombre']?></td>
        </tr>
      <? }?>
	  </table></td>
  	<td width="30%">
   <input name="r_opcion" type="checkbox" value="1"/>
  	  Puntaje v/s Promedio </td>
  	<? }?>
	

	   <? if($cmb_opcion==2){?>
    <td width="30%">&nbsp;&nbsp;Subsectores</td>
	<? }?>
	<? if($cmb_opcion==2){?>
    <td width="30%">&nbsp;
      <table width="100%" border="0" class="cuadro01" cellpadding="0" cellspacing="0">
       <? 
	   $sql_cur="SELECT DISTINCT a.id_curso,b.grado_curso,b.letra_curso,b.ensenanza FROM simce_notas_2009 a INNER JOIN ";
	   $sql_cur.="curso b ON (a.id_curso=b.id_curso) WHERE b.id_ano=".$ano." ORDER BY b.letra_curso ASC";
	   $res_cur=@pg_exec($conn,$sql_cur);
	   $conteo2=pg_numrows($res_cur);
	   
	   for($i=0;$i<$conteo2;$i++){
	   	$curso=pg_fetch_array($res_cur,$i);
		if($i==0){
			$id_curso = $curso['id_curso'];
		}else{
			$id_curso = $id_curso.",".$curso['id_curso'];
		}
	   }
		$sql_sub="SELECT DISTINCT b.cod_subsector,b.id_sub_sim,c.nombre FROM simce_notas_2009 a INNER JOIN simce_conf_2009 b ";	
		$sql_sub.="ON (a.id_sub_sim=b.id_sub_sim) INNER JOIN subsector c ON (b.cod_subsector=c.cod_subsector) WHERE ";
		"<br>".$sql_sub.="b.rdb=".$institucion." and b.id_ano=".$ano." and a.id_curso in (".$id_curso.")";
	    $res_sub=@pg_exec($conn,$sql_sub);
	   $conteo3=pg_numrows($res_sub);
		
		
		if($conteo3!=0){
		
		 for($j=0;$j<$conteo3;$j++){
	   		$sub=pg_fetch_array($res_sub,$j);
			if($subsector!=$sub['cod_subsector']){ ?> 
				<tr>
				  <td><input name="chk<?=$j?>" type="checkbox" id="chk<?=$j?>" value="<?=$sub['id_sub_sim']?>">
				  <input type="hidden" name="contador" value="<?=$conteo3?>">
				  &nbsp;<?=$sub['nombre']?></td>
				</tr>
			
      <?	}
			$subsector = $sub['cod_subsector'];
	   }
	  }else{?>
	  <tr>
          <td>No hay puntajes ingresados en ningun subsector</td>
        </tr>
	  
	  
	  <? }?>
	  </table></td>
  	<td width="30%">&nbsp;</td>
  	<? }?>
  </tr>
 </form>
</table>
	
<!-- FIN CUERPO DE LA PAGINA -->
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
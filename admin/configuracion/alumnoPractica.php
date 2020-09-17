<?	require('../../util/header.inc');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		/*if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}*/
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--<link href="../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">-->
<SCRIPT language="JavaScript">
function enviapag2(f1){
    f1.submit(true);		
}
function enviapag(){
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
<!--								  <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="" align="center" valign="top"> >>>>>>>>><? include("../../cabecera/menu_inferior.php");?></td>	  
	  
	  <tr>
		</tr> 
  
  
</table>-->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<center>
</center>	

		<FORM method="post" name="form" action="alumnoPractica.php">			<center>		 
		 <table width="95%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="6"><div align="right">
  &nbsp;&nbsp;&nbsp;
  <input align="right" type="button" name="button" id="button" value="VOLVER" class="botonXX" onClick="window.location='practicas.php'">
 </div></td> <br/>
              </tr>
            <tr>
              <td colspan="6" class="cuadro01">&nbsp;
                <input name="agregar" value="E" type="button" class="botonXX">
 EVALUACIONES&nbsp;
              <input name="agregar3" value="I" type="button" class="botonXX">
              INGRESAR PRACTICA&nbsp;
              <input name="agregar2" value="T" type="button" class="botonXX">
              N&Oacute;MINA TITULACION 
              &nbsp;<input name="agregar4" value="V" type="button" class="botonXX"> 
              VARIOS
</td>
            </tr>
           <?
           		$sql= "select distinct a.nombre_tipo,b.grado_curso,letra_curso from tipo_ensenanza a ";
				$sql.=" inner JOIN curso b on (a.cod_tipo=b.ensenanza) where b.id_ano=$ano and b.ensenanza=$cmb_ense ";
				$sql.=" and b.id_curso=$cmb_curso";
		        $rs_curso = pg_exec($conn,$sql);
		   		$fila = pg_fetch_array($rs_curso,0);	
		   
		   
		   ?>
            <tr align="left">
              <td width="12%" class="tableindex">CURSO </td>
              <td colspan="5" class="tableindex">:
                <label><?=$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo']?></label></td>
              </tr>
            <tr>
              <td colspan="6" class="tablatit2-1">ALUMNOS</td>
              </tr>
			
            <tr align="left">
              <td colspan="2" class="cuadro01">RUT</td>
              <td width="22%" class="cuadro01">NOMBRE</td>
              <td width="19%" class="cuadro01">ESTADO</td>
              <td width="16%" class="cuadro01">ESTADO<br/>PRACTICA</td>
              <td width="25%" class="cuadro01">AGREGAR <br/>PRACTICA</td>
            </tr>
            <? 
					$sql=" select a.rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat from alumno a ";
					$sql.=" inner join matricula b on (a.rut_alumno=b.rut_alumno) where b.id_ano=$ano ";
					$sql.=" and b.id_curso=$cmb_curso and b.rdb=$institucion";
					$rs_alumno = pg_exec($conn,$sql);
					
				for($i=0;$i<pg_numrows($rs_alumno);$i++){
				   $fila = pg_fetch_array($rs_alumno,$i);
				   $rut = $fila['rut_alumno'];
				   $sql_pro ="select situacion_final from promocion where rdb=$institucion and id_ano=$ano and ";
				   $sql_pro.="id_curso=$cmb_curso and rut_alumno=$rut";
				   $rs_pro = pg_exec($conn,$sql_pro);
				   $situacion_final = pg_result($rs_pro,0);
			
			?>
            <tr align="center">
            
              <td colspan="2" class="cuadro01"><?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
              <td width="22%" class="cuadro01"><?=ucfirst(strtolower($fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat']));?></td>
              <td width="19%" class="cuadro01"><? if($situacion_final==2){?>
                REPROBADO
                  <? }else{?>
                  APROBADO
                  <? }?>
                  </td>
                <?
										
					/*$sql2= " select max(a.calificacion) from eval_practicas a INNER JOIN practicas b ";
					$sql2.=" ON (a.id_practica=b.id_practica) where b.rut_alu=$rut";
					$rs_sql2 = pg_exec($conn,$sql2);
				    $total2  = pg_result($rs_sql2,0);
					
					if($total2==NULL){
					$sql1    = "select * from practicas where rut_alu=$rut ";
					$rs_sql1 = pg_exec($conn,$sql1);
					$total1  = pg_numrows($rs_sql1);
					
					}
				*/
				   $sql2="select a.id_practica,b.* from practicas a INNER JOIN estado_practica b ";
				   $sql2.=" ON (a.estado=b.cod_estado) ";
				   $sql2.=" WHERE rut_alu=$rut order by b.cod_estado DESC ";
				   $rs_sql2 = pg_exec($conn,$sql2);
				   $resultado  = pg_fetch_array($rs_sql2,0);
				   
				?>
              <td width="16%" class="cuadro01">
              
              <? if($resultado==NULL and $situacion_final==1){	?> 
              
              			EGRESADO          
			    
				<? }else{ 
						
				
				?>
                <? echo $resultado['nombre_estado']; ?>
               <? } ?>
              </td>
              <td width="25%" align="center" class="cuadro01">
		
			  <? if($ingreso==1 || $modifica==1){?>
			  <? if($situacion_final==2){?>
			  
			  <? }else{?>
              
              <? if($resultado['cod_estado']<6){?>
               <? if($resultado['cod_estado']==4 or $resultado['cod_estado']==5){?>
            
                <? }else{?>
          <input name="ingresar" value="I" type="button" onClick="window.location='listaPractica.php?rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'" class="botonXX">
           		 <? }?>   
           <? }?>
          <? if($resultado['cod_estado']>0 and $resultado['cod_estado']<6){?>
            <? if($resultado['cod_estado']==4 or $resultado['cod_estado']==5){?>
            
             <? }else{?>
           <input name="evaluacion" value="E" type="button" onClick="window.location='listaevaluacion.php?rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'"  class="botonXX">
           	  <? }?>
           <? }?>
           <? if($resultado['cod_estado']==3 or $resultado['cod_estado']==4){?>
        <input name="titulacion" value="T" type="button" onClick="window.location='procesaPracticas.php?id_practica=<?=$resultado['id_practica']?>&caso=5&rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'"  class="botonXX">    
           <? }?>
           <? if($resultado['cod_estado']==0){?> <input name="varios" value="V" type="button" onClick="window.location='varios.php?id_practica=<?=$resultado['id_practica']?>&caso=5&rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'"  class="botonXX">   
           <? }?>
           
             <? if($resultado['cod_estado']>5){?> <input name="varios" value="V" type="button" onClick="window.location='varios.php?id_practica=<?=$resultado['id_practica']?>&caso=1&rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>'" class="botonXX">   
           <? }?>
         			<? }?>  
             <? }?>
			 </td>
            </tr>
			
           <? } ?>
          </table>
		  </FORM>
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
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
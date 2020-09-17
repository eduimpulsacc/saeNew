<?php 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}	
		
			
	if (trim($_url)=="") $_url=0;
?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
	 alert ("No Autorizado");
	 window.location="../../../../../index.php";
</script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="javascript" type="text/javascript">
	function delRow(a)
	{
		b="adjunta["+a+"]";
		a="td"+a;
		z=document.getElementById(b);
		z.disabled=true;
		x=document.getElementById(a);
		x.style.display="none";
		//x=document.getElementById('mytable').deleteRow(a)
	}
	
	function insRow()
	{
		largo=document.getElementById('mytable').rows.length;
		var x=document.getElementById('mytable').insertRow(largo);
		j=largo;
		var y=x.insertCell(0)
		y.className="td2";
		y.id="td"+j;
		y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
	
	}
	
	function coloca_nombre(){
		largo=document.getElementById('mytable').rows.length;
		for (ii=1;ii<largo;ii++){
			origen="adjunta["+ii+"]";
			z=document.getElementById(origen);
			temp=tomaNombre(z)
			
			destino="nombreadjunta["+ii+"]";
			zz=document.getElementById(destino);
			zz.value=temp;	
		}
	}

</script><script language="JavaScript" type="text/JavaScript">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
           			 <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>	
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					  		$menu_lateral="3_1";
							include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="right" valign="top" >
					  
					  <table><tr></tr></table>
					  <br>
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                      
                          <tr> 						  
                            <td height="250" colspan="6" align="left" valign="top">
                              <DIV style="float:right; margin-right:100" align="right" ><img src="../../../../../images/icono_busqueda_alumno.png" width="112" height="120"> </DIV>  
							 <form name="form"   action="resultadoalumno.php" method="post">
							<table align="center">
							
							  <tr>
							    <td height="30" colspan="2" valign="top" class="cuadro01">Seleccione los campos a buscar, puede ser mas de uno </td>
							    </tr>							
                              <tr>                               
                                <td class="cuadro02">RUT</td>
                                <td class="cuadro01">
								<input type="text" name="filtroRBD"> sin puntos ni DV
								<input type="hidden" name="swrbd"  value=1 size="12" ></td>
                              </tr>
                              <tr>							  	
                                <td class="cuadro02">NOMBRE</td>
                                <td class="cuadro01"><input name="Nombre" type="text" maxlength="40" ></td>
                              </tr>
                              <tr>							  	
                                <td class="cuadro02">APELLIDO PATERNO</td>
                                <td class="cuadro01"><input name="ApellidoP" type="text"  size="20" maxlength="40" ></td>
                              </tr>
                              <tr>							    
                                <td class="cuadro02">APELLIDO MATERNO</td>
                                <td class="cuadro01"><input name="ApellidoM" type="text"  size="20" maxlength="40" ></td>
                              </tr>
                              <tr>							   
                                <td class="cuadro02">CURSO</td>								
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <td  valign="bottom" class="cuadro01">  
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
					$sql_curso= " SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
					$sql_curso.= " FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
					$sql_curso.= " WHERE (((curso.id_ano)=".$ano.")) ";
					$sql_curso.= " ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
					$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value="" selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
	        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		     } ?>
          </select>
		  
		  

		  	  
		 
			    </strong> </font> </td>
                    </tr>
							  <tr>
							  	<td height="100" colspan="8" align="center">
								<? if($ver==1 || $modifica==1){?>
								<input class="botonXX" type="submit" name="submit2" value="BUSCAR">
								<? } ?></td>
                                
							  </tr>
                              
                            </table>
							 </form> 
                           
							
				</td>
              </tr>
            </table></td>
        </tr>
					
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
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
							 
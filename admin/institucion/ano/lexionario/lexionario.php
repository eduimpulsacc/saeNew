<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

</script>

<?
require('../../../../util/header.inc');
//include ("../calendario/calendario.php");



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
	$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_actual'];
	
	
	
	
	
	
		
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link type="text/css" rel="stylesheet" href="dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" ></script>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}

</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" ></script>

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

function valida_ingreso(){
	if((document.frm1.BUSCARX[0].checked)&&(document.frm1.filtroRUT.value=="")){
		alert("Debe ingresar Rut");
		return;
	}
	if((document.frm1.BUSCARX[1].checked)&&(document.frm1.Apellido.value=="")){
		alert("Debe ingresar Apellido");
		return;
	}
	document.frm1.submit();
}
//-->


//-->>
function elimina_matricula(xrut,xinstitucion,xano){ 
		
	if(!confirm('¿Desea Eliminar Este Registro?'))
       { 
	     return false; 
	   }
	else
	   {	
	   
	     var parametros = "xrut="+xrut+"&xinstitucion="+xinstitucion+"&xano="+xano;
	     
		 //alert(parametros);
		 
		  	$.ajax({
		 		  url:'elimina_matricula.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
		 			      if (data==1){ 
					        alert("Se ha eliminado El Registro"); 
					        window.location = 'listarMatricula.php3';
					      } 
		 			  } 
		 		  })
	   }
	   
} // FIN FUNCION  


</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
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
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								 
	<div style="background-color:#FFFF00" align="center" ><B>LECCIONARIO</B></div>
<form name="form" id="form" action="procesoAnotacion.php3" method="post">
							 <br>
					  <table cellpadding="5" cellspacing="0">
                      
                      
        
      
                      
					    <tr>
					      <td height="15" class="textonegrita">CURSO</td>
					      <td class="textonegrita">:</td>
					      <td>
	<?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso)or die("f".$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onchange="enviapag(this.form);">
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
							
												  </td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					    </tr>
<tr>
<td height="15" class="textonegrita">ASIGNATURA</td>
<td class="textonegrita">:</td>
<td>
    <select title="curso" name="cmbCurso" id="cmbCurso">
      <option value="0">Selecciona opci&oacute;n...</option>
	</select>  </td>
<td>
<input class="botonXX" type="button" value="GUARDAR" name="btnGuardar" onclick="valida(this.form);" ></td>
<td>
<input class="botonXX"  TYPE="button" value="VOLVER" onclick="window.history.go(-1)"></td>
</tr>
 </table>
 
					    	

<br /><center>
<div style="background-color:#FF0000" class="tableindex" >LECCIONARIO</div>
</center>

<div id="tabs" style="width:700px; margin: 20px auto 0 auto; text-align:center" align="center" >
  <div id="codigo">
  
 		

<table class="textonegrita" ><tr>

<tr><td>Fecha Tipo(YYYY/MM/DD): </td><td><input type="text" value="2011/04/04" readonly name="theDate"><input type="button" value="Calendario" onclick="displayCalendar(document.forms[0].theDate,'yyyy/mm/dd',this)"></td></tr>

<td nowrap="nowrap" >DESCRIPCION:</td>
<td nowrap="nowrap" >
<textarea name="txtOBS2" cols="40" rows="5"></textarea>	<br />							  </td>
</tr>

<tr>
<td >TIPO:  </td>
<td  >
<select id="cmb_periodos2" name="cmb_periodos2" class="">
<option value=0 selected>(Seleccione Tipo)</option>
</select> 
<span >(*)</span></td>
	</tr>
	
	<tr>
<td >TIPO NOTA:  </td>
<td  >
<select id="cmb_periodos2" name="cmb_periodos2" class="">
<option value=0 selected>(Seleccione Tipo Nota)</option>
 </select> 
<span >(*)</span></td>
	</tr>
</table>
	
</div> <!--PRIMER DIV-->



<div id="seleccion">  <!--SEGUNDO DIV-->
</div>  
<!--SEGUNDO DIV-->
	


<div id="tradicional"> <!--TERCER DIV-->
</div> 
<!--TERCER DIV-->
<!--CUARTO DIV-->
</div>
</div><!-- End demo -->


	
</form>
	
								 
								  <!-- FIN DEL NUEVO CÓDIGO -->                                  </td>
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
</tr>
</tr></div>
</body>
</html>
<? pg_close($conn);?>
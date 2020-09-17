<?php 
require('../../util/header.inc');
require('../../util/funciones_new.php'); 

	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
   $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =2;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];
	
	
			
			
			
  $sql="select ramo.id_ramo,su.nombre,ramo.id_orden,su.cod_subsector 
    from ramo 
	inner join subsector su on ramo.cod_subsector=su.cod_subsector
	inner join curso cu on ramo.id_curso=cu.id_curso
	where ramo.id_curso=".$curso." order by ramo.id_orden ASC"; 
	$regis=@pg_Exec($conn,$sql);		


	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'LISTADO DE PROFESORES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	





	
	//<a href="../../admin/clases">clases</a>
	//-------------------------------
?><link rel="stylesheet" type="text/css" href="../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../admin/clases/jqueryui/jquery.ui.core.js"></script>

<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>


<script type="text/javascript">


	function carga_grafico(){
		
		//var id_curso = $('#').val();
		var select_ramos = $('#select_ramos').val();
		//var ano = "<?=$ano?>"
		//var funcion=1;
		
		var parametros='select_ramos='+select_ramos;
	//alert(parametros);
	
		$.ajax({
	  url:'GraficosEnsayosPsu.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#grafico").html(data);
		  }
	  })
	}


</script>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../Sea/cortes/b_ayuda_r.jpg','../../Sea/cortes/b_info_r.jpg','../../Sea/cortes/b_mapa_r.jpg','../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="%" height="%" border="0" cellpadding="0" cellspacing="0" >
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
<center>

<table width="650" border="0" cellspacing="1" cellpadding="3">
  <TR height=20 class="tableindex">
    <TD align="center" colspan=3> INIFORME NEM </TD>
   </TR>
   
</table>
<form action="GraficosEnsayosPsu.php" method="post" name="frm" runat="server" target="_blank">
<table align="center" width="650" border="0" style="border-collapse:collapse" cellspacing="1" cellpadding="3">
  <tr class="tablatit2-1">
  <td width="66">
  Ramos:
  </td>
   <td width="206" align="left">
   
   <?
   
   		$sql_1="select ensenanza from curso where id_curso=".$curso;
		$regis_1=@pg_Exec($conn,$sql_1);
		$fila_1=pg_fetch_array($regis_1,0);
		//if($fila_1[0] >309 ){
		
		?>
		<select name='select_ramos' id='select_ramos' onChange='carga_alumnos(this.value)' >
		<option value='0' select='select' >(Selecccionar)</option>";
			<?	
		for($i=0;$i<pg_numrows($regis);$i++){
			$fila2=pg_fetch_array($regis,$i);
		?>
			<option value=<?=$fila2['id_ramo']?> ><?=$fila2['nombre']?></option>
            <?
			}  
			?>
		 </select> 
		
		<?
		//}else{
			
			
		//	echo "El Alumno Debe Ser de Enseñanza Media";
   ?>
   
   
   
   <?
		//}
   ?>
   
   
	</td>
    <td width="356"><input type="button" class="botonXX" name="buscar" value="BUSCAR" onClick="carga_grafico()"></td>
    </tr>
 
 
 
</table>

<div id="grafico"></div>
</form>
</center>

								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
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
          <td width="53" align="left" valign="top" background="../../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

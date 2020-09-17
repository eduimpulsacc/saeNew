
<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_MotorBusqueda.php');
 	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 6;
	$_bot           =5;
	$_MDINAMICO     = 1;
	$curso			= $c_curso;


	$reporte		=$c_reporte;
	
$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$result_curso = $ob_motor ->curso($conn);

/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  

?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="/images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
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


function selCurso(){
	$('#lista').html("");
	
	var curso =  $('#c_curso').val();
	var anio =  <?php echo $ano ?>;
	//alert(curso);
		if (curso !=0)
		{
			$('#btn_agregar').css("display","block");
			//invocar carga listado
			$.ajax({
				url:"modulos.php",
				data:"curso="+curso+"&anio="+anio,
				type:'POST',
				success:function(data){
				$('#lista').html(data);
		  }
		})  
		//mostrar listado e pagina
		$('#lista').css("display","block");
		$('#data').css("display","none");
		
	}
		
	else
	//borrar todo el listado
	{
		$('#lista').html("");
		
	}
	
}

function mod_data(ramo){
	//alert("hola");
	var curso = $('#c_curso').val();
		$.ajax({
				url:"modulosData.php",
				data:"curso="+curso+"&ramo="+ramo,
				type:'POST',
				success:function(data){
				$('#data_'+ramo+'').html(data);
				$('#relacion_'+ramo+'').css("display","none");
				$('#data_'+ramo+'').css("display","block");
		  }
		})
		
		
		//$('#lista').css("display","none");
	
		
		
	}
	
	function mues_data(ramo){
	//alert("hola");
	var curso = $('#c_curso').val();
		$.ajax({
				url:"modulosVista.php",
				data:"curso="+curso+"&ramo="+ramo,
				type:'POST',
				success:function(data){
				$('#relacion_'+ramo+'').css("display","block");
				$('#relacion_'+ramo+'').html(data);
				$('#data_'+ramo+'').css("display","none");
		  }
		})
		
		
		//$('#lista').css("display","none");
		$('#relacion'+ramo+'').css("display","block");
		
		
	}
      
	  
function guardaRel(frm){
	
	var form=$('#'+frm+'').serialize();
	//var ramo=$('#rm').val();
	var r= frm.split("_");
	var rm = r[1];
	//alert(rm);	
	
	$.ajax({
				url:"moduloGuarda.php",
				data:form,
				type:'POST',
				success:function(data){
					if(data==1){
					alert("Módulo creado");	
					mues_data(rm);
					}
					else
					{
						alert("Debe seleccionar al menos un (1) ramo como hijo");	
					}
			
				//console.log(data);
		  }
		})
		
		
}	  
	  
	  
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function cierra(ramo){
	$('#relacion_'+ramo+'').html("");
	$('#relacion_'+ramo+'').css("display","none");
	$('#data_'+ramo+'').html("");
	$('#data_'+ramo+'').css("display","none");
}

//-->
</script>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
							<? $menu_lateral="3_1"; include("../../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height=""><!-- codigo antiguo -->

                                    <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
                                      <tr> 
    <td height="" align="center" valign="top"> 
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex">Listado m&oacute;dulos</td>
    </tr>
  <tr>
    <td colspan="2" class="cuadro01" >&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td width="12%" class="textosimple" >A&ntilde;o: </td>
    <td width="88%" class="textosimple"><? echo trim($nro_ano) ?></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">Curso:</td>
    <td><form id="combo"><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="selCurso();">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select></form></td>
    </tr>
    <tr class="cuadro01"><td colspan="2" align="right"><input class="botonXX" type="button" value="VOLVER" onclick="document.location='../listarRamos.php3'">&nbsp;&nbsp;</td></tr>
    <tr class="cuadro01">
      <td colspan="2" align="right">
      
      </td>
    </tr>
  <tr >
    <td colspan="2" >
     <div id="lista" style="display:none" class="print">
    </div>
   
   </td>
    </tr>
                    </table>
       </td>
  </tr>
</table>
                                    <center>
                                      
                                      
                                      <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0000FF">
          <tr>
            <td align="right"></td>
          </tr>
        </table>
					
		
		
	</center>
			  

      </td>
	  </tr>
	  </table>

                              <!-- fin codigo antiguo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2"><? include("../../../../../../cabecera/menu_inferior.php"); ?> </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>

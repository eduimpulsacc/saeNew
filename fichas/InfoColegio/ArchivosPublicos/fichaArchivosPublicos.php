<?php 
require('../../../util/header.inc');
require('../../../util/funciones_new.php'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP = 3;

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'FICHA CONTENIDOS DISPONIBLES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../menu_new/css/styles.css">
<link rel="stylesheet" type="text/css" href="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../../../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../../../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../../../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="25%" width="%"> <? include("../../../menu_new/menu_alu_apo.php"); ?></td>
    <td valign="top" height="50%" ><br>
    <table width="95%" border="0" class="cajaborde" align="center">
      <tr>
        <td>


   <table width="85%" border="0" align="center">
  <tr>
    <td class="textonegrita">INSTITUCION</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;
    <? $sql="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion;
		$rs_rdb = pg_exec($conn,$sql);
		echo pg_result($rs_rdb,0);
   ?>
    </td>
    <td rowspan="7">&nbsp;
    <?php
												
	$nombre_archivo = '../infousuario/images/'.$alumno;																																		
	if (file_exists($nombre_archivo)) {?>
	   <img src="../infousuario/images/<?php echo $alumno?>" ALT="NO DISPONIBLE" width=150></p>
<?	} else { ?>
	   <img src="../../apoderado/imag/alumno222.jpg" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
<?	}?>
    </td>
  </tr>
  <tr>
    <td class="textonegrita">A&Ntilde;O ESCOLAR</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;
    <? $sql="SELECT nro_ano FROM ano_escolar WHERE id_institucion=".$institucion;
		$rs_ano = pg_exec($conn,$sql);
		echo pg_result($rs_ano,0);
	?>
    </td>
    </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;<? echo CursoPalabra($_CURSO,0,$conn);?></td>
    </tr>
  <tr>
    <td class="textonegrita">ALUMNO</td>
    <td class="textonegrita">:</td>
    <td class="textosimple">&nbsp;
    <? $sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat as nombre FROM alumno WHERE rut_alumno=".$alumno;
		$rs_alumno = pg_exec($conn,$sql);
		echo pg_result($rs_alumno,0);
		
	?>
    </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   </table><br>
<br>
<TABLE width=85%  Border=0 cellpadding=1 cellspacing=3 align="center">
    <TR class="tableindexredondo">
      <TD align=left height=10 class="textoNegrita">&nbsp;FECHA</TD>
      <TD align=left class="textoNegrita">&nbsp;NOMBRE ARCHIVO</TD>
      <TD align=left class="textoNegrita">&nbsp;DESCARGAR</TD>
     </TR>
    <!--SUBSECTORES DEL ALUMNO-->
    <?php
        //TOTAL DE RAMOS INGRESADOS
        $qryX="SELECT * FROM archivos_publicos WHERE id_ano=".$ano." " ;

        $resultX =@pg_Exec($conn,$qryX);
        if(pg_numrows($resultX)!=0){
            for($i=0 ; $i < @pg_numrows($resultX) ; $i++){
                $filaX = @pg_fetch_array($resultX,$i);
				
				if(($i % 2)==0){
					$class="detalleof";	
				}else{
					$class="detalleon";
				}
    ?>
        
            <TR class="<?=$class;?>">
                <TD align=left height=10><?=$filaX['fecha'];?>
                    
                </TD>
                <TD align=left>&nbsp;<FONT face="arial, geneva, helvetica" size=1 >
                        <STRONG>&nbsp;&nbsp;
                            <?php echo $filaX['observacion'];?>
                        </STRONG>
                    </FONT></TD>
                <TD align=left>&nbsp;<a href="../admin/institucion/ano/archivos_publicos/archivos/<?=$filaX['nombre_archivo'];?>"><img src="../../../util/disk2.png"  width=30 border="0"></a></TD>
            </TR>
            
            <!--ARCHIVOS DEL SUBSECTOR-->
            
        
    <?php
            }
        }
    ?>
    </TABLE>

 <br>
    <img src="../../../cortes/10774/sombra.png" width="885" height="32">
   &nbsp;</td>
      </tr>
    </table>
    
  


    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../../../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>
</body>
</html>

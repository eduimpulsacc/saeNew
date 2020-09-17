<?php 
require('../util/header.inc');
require('../util/funciones_new.php'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";
	
	session_start();

	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'FICHA CONTENIDOS DISPONIBLES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
	


	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO=".$alumno;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (111111)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../menu_new/css/styles.css">
<link rel="stylesheet" type="text/css" href="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
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
		
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar A�O.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="50%" width="287"> <? include("../menu_new/menu_alu_apo.php"); ?></td>
    <td width="866" height="50%" valign="top"><br>
	<table width="95%" border="0" class="cajaborde" align="center">
  <tr>
    <td>&nbsp;<table width="95%" border="0" align="center">
  <tr>
    <td width="16%" class="titulo_new">INSTITUCI&Oacute;N</td>
    <td width="59%" class="textosimple">&nbsp;
	<?php
		$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
					exit();
				}
				echo trim($fila1['nombre_instit']);
			}
		}
	?></td>
    <td width="25%" rowspan="6">&nbsp;
    <?php
		$sql_arr = "select * from alumno where rut_alumno= '$alumno'";
		$result = pg_Exec($conn,$sql_arr);												
		$arr=pg_fetch_array($result);
														/*
		$output= "select lo_export('/opt/www/newsae/infousuario/images/".$arr[rut_alumno]."');";
		$retrieve_result = @pg_exec($conn,$output);
		$retrieve_result;
	if (!$retrieve_result){ */												
		$nombre_archivo = '../infousuario/images/'.$arr[rut_alumno];																																		 
	
		if (file_exists($nombre_archivo)) {?>
		   <img src="../infousuario/images/<?php echo $arr[rut_alumno]?>" ALT="NO DISPONIBLE" width=150></p>
	<?	} else { ?>
		   <img src="apoderado/imag/alumno222.jpg" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="150" height="150" id="ALUMNO">
	<?	}?>
    </td>
  </tr>
  <tr>
    <td class="titulo_new">A&Ntilde;O ESCOLAR</td>
    <td class="textosimple">&nbsp;
    <?php
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
					exit();
				}
				echo trim($fila1['nro_ano']);
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">CURSO</td>
    <td class="textosimple">&nbsp;
    <?php
// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
		$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
// ---------------------------------------------------------------------
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				}
				echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
				$tipo=$fila1['cod_tipo'];
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">ALUMNO</td>
    <td class="textosimple">&nbsp;
    <?php
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				}
				echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
				
			}
		}
	?>
    </td>
    </tr>
  <tr>
    <td class="titulo_new">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    </tr>
  <tr>
    <td class="titulo_new">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    </tr>
    </table>      <br>
    <table width="650" border="0" align="center">
 	 <tr>
    	 <TD colspan=2 align=middle class="tableindex"> FICHA CONTENIDOS DISPONIBLES</TD>
  	 </tr>
	</table>
    <table width="650" border="0" align="center" class="cajaborde">
    <?
    $qryX="SELECT subsector.nombre, ramo.id_ramo FROM (((alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((alumno.rut_alumno)=".$_ALUMNO.") and curso.id_ano=$ano)";

	$resultX =@pg_Exec($conn,$qryX);
	if(pg_numrows($resultX)!=0){
		for($i=0 ; $i < @pg_numrows($resultX) ; $i++){
			$filaX = @pg_fetch_array($resultX,$i);
	?>
	  <tr>
        <td class="detalleon"><?php echo $filaX['nombre'];?></td>
      </tr>
     <?php
		 $qryY="SELECT * FROM (archivo INNER JOIN adjunta ON archivo.id_archivo = adjunta.id_archivo) INNER JOIN ramo ON adjunta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$filaX['id_ramo']."))";

		$resultY =@pg_Exec($conn,$qryY);
		if(pg_numrows($resultY)!=0){
			for($j=0 ; $j < @pg_numrows($resultY) ; $j++){
				$filaY = @pg_fetch_array($resultY,$j);
	?>
      <tr>
        <td>
        <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
        <TR>
            <TD width=28% rowspan="3" class="textonegrita"><?php echo trim($filaY['nombre_archivo']);?></TD>
            <TD width=66%> 
            <? $url1=str_replace("http://","",$filaY['web1']);?>
                <a href="http://<? echo $url1;?>" target="_blank"><? echo $filaY['web1'];?></a>																								</TD>
          <TD width=6% rowspan="3" class="textosimple">
            <input name="archivo" type="hidden" value=<?php echo "../tmp/".trim($filaY['nombre_archivo'])?>>
            <a  href="../tmp/<?php echo trim($filaY['nombre_archivo'])?>" onmouseover=this.style.cursor='hand' title="Descargar"><img src="../util/disk2.png"  width=30 border="0"></a></TD>
        </TR>
        <TR>
          <TD><? $url2=str_replace("http://","",$filaY['web2']);?>
                <a href="http://<? echo $url2;?>" target="_blank"><? echo $filaY['web2'];?></a></TD>
      </TR>
        <TR>
          <TD><? $url3=str_replace("http://","",$filaY['web3']);?><a href="http://<? echo $url3;?>" target="_blank"><? echo $filaY['web3'];?></a></TD>
      </TR>
        <TR>
            <TD colspan="3" class="textosimple">&nbsp;&nbsp;&nbsp;<?php echo trim($filaY['descripcion_archivo'])?></TD>
        </TR>
    </TABLE>
        </td>
      </tr>
     <? } 
		}else{
	?>
		<TR>
			<TD>
				<TABLE width=100% height=100% bgcolor=White BORDER=0>
					<TR>
						<TD align=center class="textosimple">NO se registran archivos ingresados.</TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
	<?php 
		} 
    } 
	}?>
    </table>



</td>
  </tr>
</table>

    
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>
</body>
</html>

<?php require('../../../../../util/header.inc');?>
<script>
function imprimir() 
{
	document.getElementById("capa1").style.display='block';
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa2").style.display='none';
	window.print();
	document.getElementById("capa1").style.display='none';
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa2").style.display='block';
}
	</script>
<?php 
//		$institucion	=$_INSTIT;
//		$frmModo		=$_FRMMODO;
//		$ano			=$_ANO;
//		$alumno			=$_ALUMNO;
//		$curso			=$_CURSO;
	
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =5;
	$_bot           = 5;
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
		  		

<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>		
			
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height=""><!-- inicio codigo antiguo -->
								  
								  
								  
<table width="90%" height="" border="0" cellpadding="0" cellspacing="0">
  <tr> 								  
<? if(($_PERFIL!=2)&&($_PERFIL!=17)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

    <td height="" align="center" valign="top"> 
	<div id="capa0">
       <?
			   include("../../../../../cabecera/menu_inferior.php");
			   ?>
	  </div>
	  <?php } ?>
	    </td>
  </tr>
</table>

<center>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa2"><div align="right">
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="alumno.php3"  value="VOLVER">
	  </div>
    </div></td>
  </tr>
  
  <tr>
    <td>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="131"><?php
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);
						
					?><!--img src=../../../../../../../tmp/<?php echo $institucion ?> ALT="NO DISPONIBLE"  width=100 ></td>
            <td width="503"><table width="504" border="0" cellpadding="0" cellspacing="0"-->
			
			<?
			$sql10 = "select id_curso from matricula where rut_alumno = " . $alumno. " and id_ano = " . $ano;
			$result10 =@pg_Exec($conn,$sql10);
			if (!$result10) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}
			else
			{
				if (pg_numrows($result10)!=0)
				{
					$fila10 = @pg_fetch_array($result10,0);	
					if (!$fila10)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			$curso = $fila10['id_curso'];
			
			$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit ";
			$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
			
			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
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
													$ano_act = trim($fila1['nro_ano']);
												
												}
											}
				

			?>
              <tr>
                <td width="133"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>INSTITUCI&Oacute;N</strong></font></div></td>
                <td width="8"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td width="350"><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nombre_instit']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>AÑO ESCOLAR</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['nro_ano']) ?></strong></font></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>CURSO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo trim($fila['grado_curso']). "-" . trim($fila['letra_curso']) . " " . trim($fila['nombre_tipo']) ?></strong></font></div></td>
              </tr>	
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>ALUMNO</strong></font></div></td>
                <td><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong><? echo strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']));?></strong></div></td>
              </tr>
              <tr>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>PROFESOR JEFE</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>:</strong></font></div></td>
                <td><div align="left"><font face="arial, geneva, helvetica" size="2"><strong>
				<?
				$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
				$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$curso.")); ";
				$result4 =@pg_Exec($conn,$sql4);
				if (!$result4) 
				{
					error('<B> ERROR :</b>Error al acceder a la BD. (100)</B>');
				}
				else
				{
					if (pg_numrows($result4)!=0)
					{
						$fila4 = @pg_fetch_array($result4,0);	
						if (!$fila4)
						{
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
				}
				echo strtoupper(trim($fila4['ape_pat']) . " " . trim($fila4['ape_mat']) . " " . trim($fila4['nombre_emp']));
				$nombre_profe = strtoupper(trim($fila4['ape_pat']) . " " . trim($fila4['ape_mat']) . " " . trim($fila4['nombre_emp']));
				?>
				</strong></font></div></td>
              </tr>
            </table>
			<br></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">NOTAS PARCIALES DEL ALUMNO</div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $sql = "select  * from periodo where id_ano = ".$ano." order by id_periodo" ;
		  $result1 =@pg_Exec($conn,$sql);
		  if (!$result1) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (1000)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result1)!=0)
			  {
				  $fila1 = @pg_fetch_array($result1,0);	
				  if (!$fila1)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$fila1 = @pg_fetch_array($result1,$i);
				$id_periodo = $fila1['id_periodo'];
				$sql8 = "select count(*) as contador from notas$ano_act where id_periodo = ". $id_periodo . " and rut_alumno = " . $alumno;

			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (10000)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				if ($fila8['contador']>0)
				{
				?>			
		  <table width="650" border="1" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231"><div align="left"></div>
              <strong>
              <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $fila1['nombre_periodo'] ?></font></div></td>
            <td colspan="20"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOTAS</font></strong></div></td>
            <td width="33" ><strong><font size="1" face="Arial, Helvetica, sans-serif"><strong>PROM</font></strong></td>
			
            </tr>
         
		  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  $sql2 = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval ";
		  $sql2 = $sql2 . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
		  $sql2 = $sql2 . "WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden; ";

          $result =@pg_Exec($conn,$sql2);
		  if (!$result) 
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (100000)</B>');
    		}
		  else
    		{
    			if (pg_numrows($result)!=0)
			  {
				  $fila = @pg_fetch_array($result,0);	
				  if (!$fila)
				  {
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$nombre	= $fila['nombre'];
			?>		
          <tr>
		  <?
		  	$sql3 = "SELECT notas$ano_act.* ";
			$sql3 = $sql3 . "FROM notas$ano_act WHERE (((notas$ano_act.rut_alumno)='".$alumno."') AND ((notas$ano_act.id_ramo)=".$id_ramo.") AND ((notas$ano_act.id_periodo)=".$id_periodo.")); ";

			$result2 =@pg_Exec($conn,$sql3);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (10020)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
				/*$nota1 = $fila2['nota1'] ;	
				if (empty($nota1) or ($nota1 == 0)) $nota1 = "&nbsp;";
				$nota2 = $fila2['nota2'];
				if (empty($nota2) or ($nota2 == 0)) $nota2 = "&nbsp;" ;
				$nota3= $fila2['nota3'] 		 ;
				if (empty($nota3) or ($nota3 == 0)) $nota3 = "&nbsp;" ;
				$nota4 = $fila2['nota4'] 	 ;
				if (empty($nota4) or ($nota4 == 0)) $nota4 = "&nbsp;" ;
				$nota5 = $fila2['nota5'] 	 ;
				if (empty($nota5) or ($nota5 == 0)) $nota5 = "&nbsp;" ;
				$nota6 = $fila2['nota6'] 	 ;
				if (empty($nota6) or ($nota6 == 0)) $nota6 = "&nbsp;" ;
				$nota7 = $fila2['nota7'] 	 ;
				if (empty($nota7) or ($nota7 == 0)) $nota7 = "&nbsp;" ;
				$nota8 = $fila2['nota8'] 	 ;
				if (empty($nota8) or ($nota8 == 0)) $nota8 = "&nbsp;" ;
				$nota9 = $fila2['nota9'] 	 ;
				if (empty($nota9) or ($nota9 == 0)) $nota9 = "&nbsp;" ;
				$nota10 = $fila2['nota10'] 	 ;
				if (empty($nota10) or ($nota10 == 0)) $nota10 = "&nbsp;" ;
				$nota11 = $fila2['nota11'] 	 ;
				if (empty($nota11) or ($nota11 == 0)) $nota11 = "&nbsp;" ;
				$nota12 = $fila2['nota12'] 	 ; 
				if (empty($nota12) or ($nota12 == 0)) $nota12 = "&nbsp;" ;
				$nota13 = $fila2['nota13'] 	 ;
				if (empty($nota13) or ($nota13 == 0)) $nota13 = "&nbsp;" ;
				$nota14 = $fila2['nota14'] 	 ;
				if (empty($nota14) or ($nota14 == 0)) $nota14 = "&nbsp;" ;
				$nota15 = $fila2['nota15'] 	 ;
				if (empty($nota15) or ($nota15 == 0)) $nota15 = "&nbsp;" ;
				$nota16 = $fila2['nota16'] 	 ;
				if (empty($nota16) or ($nota16 == 0)) $nota16 = "&nbsp;" ;
				$nota17 = $fila2['nota17'] 	 ;
				if (empty($nota17) or ($nota17 == 0)) $nota17 = "&nbsp;" ;
				$nota18 = $fila2['nota18'] 	 ;
				if (empty($nota18) or ($nota18 == 0)) $nota18 = "&nbsp;" ;
				$nota19 = $fila2['nota19'] 	 ;
				if (empty($nota19) or ($nota19 == 0)) $nota19 = "&nbsp;" ;
				$nota20 = $fila2['nota20'] 	 ;
				if (empty($nota20) or ($nota20 == 0)) $nota20 = "&nbsp;" ;
				$prom = $fila2['promedio'] 	 ;
				if (empty($prom) or ($prom == 0)) $prom = "&nbsp;" ;*/
				if ($modo_eval == 1){
					if ($fila2['nota1']>0) $nota1 = $fila2['nota1']; else $nota1 = "&nbsp;";
					if ($fila2['nota2']>0) $nota2 = $fila2['nota2']; else $nota2 = "&nbsp;";
					if ($fila2['nota3']>0) $nota3 = $fila2['nota3']; else $nota3 = "&nbsp;";
					if ($fila2['nota4']>0) $nota4 = $fila2['nota4']; else $nota4 = "&nbsp;";
					if ($fila2['nota5']>0) $nota5 = $fila2['nota5']; else $nota5 = "&nbsp;";
					if ($fila2['nota6']>0) $nota6 = $fila2['nota6']; else $nota6 = "&nbsp;";
					if ($fila2['nota7']>0) $nota7 = $fila2['nota7']; else $nota7 = "&nbsp;";
					if ($fila2['nota8']>0) $nota8 = $fila2['nota8']; else $nota8 = "&nbsp;";
					if ($fila2['nota9']>0) $nota9 = $fila2['nota9']; else $nota9 = "&nbsp;";
					if ($fila2['nota10']>0) $nota10 = $fila2['nota10']; else $nota10 = "&nbsp;";
					if ($fila2['nota11']>0) $nota11 = $fila2['nota11']; else $nota11 = "&nbsp;";
					if ($fila2['nota12']>0) $nota12 = $fila2['nota12']; else $nota12 = "&nbsp;";
					if ($fila2['nota13']>0) $nota13 = $fila2['nota13']; else $nota13 = "&nbsp;";
					if ($fila2['nota14']>0) $nota14 = $fila2['nota14']; else $nota14 = "&nbsp;";
					if ($fila2['nota15']>0) $nota15 = $fila2['nota15']; else $nota15 = "&nbsp;";
					if ($fila2['nota16']>0) $nota16 = $fila2['nota16']; else $nota16 = "&nbsp;";
					if ($fila2['nota17']>0) $nota17 = $fila2['nota17']; else $nota17 = "&nbsp;";
					if ($fila2['nota18']>0) $nota18 = $fila2['nota18']; else $nota18 = "&nbsp;";
					if ($fila2['nota19']>0) $nota19 = $fila2['nota19']; else $nota19 = "&nbsp;";
					if ($fila2['nota20']>0) $nota20 = $fila2['nota20']; else $nota20 = "&nbsp;";
					if ($fila2['promedio']>0) $prom = $fila2['promedio']; else $prom = "&nbsp;";																																																																												
				} else {
					if (chop($fila2['nota1'])=="0" or chop($fila2['nota1'])=="") $nota1 = "&nbsp;";  else $nota1 = $fila2['nota1'];
					if (chop($fila2['nota2'])=="0" or chop($fila2['nota2'])=="")  $nota2 = "&nbsp;"; else $nota2 = $fila2['nota2'];
					if (chop($fila2['nota3'])=="0" or chop($fila2['nota3'])=="")  $nota3 = "&nbsp;"; else $nota3 = $fila2['nota3'];
					if (chop($fila2['nota4'])=="0" or chop($fila2['nota4'])=="")  $nota4 = "&nbsp;"; else $nota4 = $fila2['nota4'];
					if (chop($fila2['nota5'])=="0" or chop($fila2['nota5'])=="")  $nota5 = "&nbsp;"; else $nota5 = $fila2['nota5'];
					if (chop($fila2['nota6'])=="0" or chop($fila2['nota6'])=="")  $nota6 = "&nbsp;"; else $nota6 = $fila2['nota6'];
					if (chop($fila2['nota7'])=="0" or chop($fila2['nota7'])=="")  $nota7 = "&nbsp;"; else $nota7 = $fila2['nota7'];
					if (chop($fila2['nota8'])=="0" or chop($fila2['nota8'])=="")  $nota8 = "&nbsp;"; else $nota8 = $fila2['nota8'];
					if (chop($fila2['nota9'])=="0" or chop($fila2['nota9'])=="")  $nota9 = "&nbsp;"; else $nota9 = $fila2['nota9'];
					if (chop($fila2['nota10'])=="0" or chop($fila2['nota10'])=="")  $nota10 = "&nbsp;"; else $nota10 = $fila2['nota10'];
					if (chop($fila2['nota11'])=="0" or chop($fila2['nota11'])=="")  $nota11 = "&nbsp;"; else $nota11 = $fila2['nota11'];
					if (chop($fila2['nota12'])=="0" or chop($fila2['nota12'])=="")  $nota12 = "&nbsp;"; else $nota12 = $fila2['nota12'];
					if (chop($fila2['nota13'])=="0" or chop($fila2['nota13'])=="")  $nota13 = "&nbsp;"; else $nota13 = $fila2['nota13'];
					if (chop($fila2['nota14'])=="0" or chop($fila2['nota14'])=="")  $nota14 = "&nbsp;"; else $nota14 = $fila2['nota14'];
					if (chop($fila2['nota15'])=="0" or chop($fila2['nota15'])=="")  $nota15 = "&nbsp;"; else $nota15 = $fila2['nota15'];
					if (chop($fila2['nota16'])=="0" or chop($fila2['nota16'])=="")  $nota16 = "&nbsp;"; else $nota16 = $fila2['nota16'];
					if (chop($fila2['nota17'])=="0" or chop($fila2['nota17'])=="")  $nota17 = "&nbsp;"; else $nota17 = $fila2['nota17'];
					if (chop($fila2['nota18'])=="0" or chop($fila2['nota18'])=="")  $nota18 = "&nbsp;"; else $nota18 = $fila2['nota18'];
					if (chop($fila2['nota19'])=="0" or chop($fila2['nota19'])=="")  $nota19 = "&nbsp;"; else $nota19 = $fila2['nota19'];
					if (chop($fila2['nota20'])=="0" or chop($fila2['nota20'])=="")  $nota20 = "&nbsp;"; else $nota20 = $fila2['nota20'];
					if (chop($fila2['promedio'])=="0" or chop($fila2['promedio'])=="")  $prom = "&nbsp;"; else $prom = $fila2['promedio'];
				}
			?>
            <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $fila['nombre']; ?></font></div></td>
			
			<td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota1<40 && $nota1>0){ ?><font color="#FF0000"><? echo $nota1 ?></font><? } else { echo $nota1; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota2<40 && $nota2>0){ ?><font color="#FF0000"><? echo $nota2 ?></font><? } else { echo $nota2; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota3<40 && $nota3>0){ ?><font color="#FF0000"><? echo $nota3 ?></font><? } else { echo $nota3; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota4<40 && $nota4>0){ ?><font color="#FF0000"><? echo $nota4 ?></font><? } else { echo $nota4; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota5<40 && $nota5>0){ ?><font color="#FF0000"><? echo $nota5 ?></font><? } else { echo $nota5; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota6<40 && $nota6>0){ ?><font color="#FF0000"><? echo $nota6 ?></font><? } else { echo $nota6; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota7<40 && $nota7>0){ ?><font color="#FF0000"><? echo $nota7 ?></font><? } else { echo $nota7; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota8<40 && $nota8>0){ ?><font color="#FF0000"><? echo $nota8 ?></font><? } else { echo $nota8; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota9<40 && $nota9>0){ ?><font color="#FF0000"><? echo $nota9 ?></font><? } else { echo $nota9; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota10<40 && $nota10>0){ ?><font color="#FF0000"><? echo $nota10 ?></font><? } else { echo $nota10; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota11<40 && $nota11>0){ ?><font color="#FF0000"><? echo $nota11 ?></font><? } else { echo $nota11; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota12<40 && $nota12>0){ ?><font color="#FF0000"><? echo $nota12 ?></font><? } else { echo $nota12; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota13<40 && $nota13>0){ ?><font color="#FF0000"><? echo $nota13 ?></font><? } else { echo $nota13; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota14<40 && $nota14>0){ ?><font color="#FF0000"><? echo $nota14 ?></font><? } else { echo $nota14; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota15<40 && $nota15>0){ ?><font color="#FF0000"><? echo $nota15 ?></font><? } else { echo $nota15; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota16<40 && $nota16>0){ ?><font color="#FF0000"><? echo $nota16 ?></font><? } else { echo $nota16; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota17<40 && $nota17>0){ ?><font color="#FF0000"><? echo $nota17 ?></font><? } else { echo $nota17; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota18<40 && $nota18>0){ ?><font color="#FF0000"><? echo $nota18 ?></font><? } else { echo $nota18; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota19<40 && $nota19>0){ ?><font color="#FF0000"><? echo $nota19 ?></font><? } else { echo $nota19; } ?></font></div></td>
            <td width="17"><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? if($nota20<40 && $nota20>0){ ?><font color="#FF0000"><? echo $nota20 ?></font><? } else { echo $nota20; } ?></font></div></td>
			<? 
			if (($prom <> 0) and ($nombre<>"RELIGION"))
			  {
			  $cont_prom=$cont_prom+1;
			  //echo "Contador ". $cont_prom. "<br>";
			  $promedio = ($promedio + $prom);
			  //echo "Suma" . $promedio ;
			  }
			?>
            <td><div align="center"><font size="0" face="Arial, Helvetica, sans-serif"><? 
					if($prom<40 && $prom>0){ ?><font color="#FF0000"><? 
						 echo $prom; ?></font><? 
					}
					else { 
						echo $prom; 
					}?></font></div></td>
          </tr>
		  <? } ?>
        </table>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="461">&nbsp;</td>
            <td width="153"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">Promedio Per&iacute;odo </font></strong></font></div></td>
            <td width="36"><div align="center"><font size="1"><strong><font face="Arial, Helvetica, sans-serif">
			<? 
			if (($promedio > 0) and ($nombre!='RELIGION')) 
			{
				echo $promedio = round($promedio / $cont_prom,0);
				$promedio_gen = $promedio_gen + $promedio;
				$cont_promgen=$cont_promgen +1;
			}
			else
				echo "&nbsp;";
			
			?></font></strong></font></div></td>
          </tr>
        </table>
		<? } //for?>
		<? } //if?> 
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		  	<HR width="100%" color=#003b85>
			<td width="461">&nbsp;</td>
		    <td width="153"><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Promedio General </font></strong></font></div></td>
		    <td width="36"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">
			<? 
			//echo "contador " . $cont_promgen . "<br>" . "suma " . $promedio_gen  ;
			if ($promedio_gen > 0) 
				echo $promedio_gen  = round($promedio_gen  / $cont_promgen,0);
			else
				echo "&nbsp;";
			?>	</font></strong></font></div>			</td>
		  </tr>
		</table>
		
		<div id="capa1">
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			<td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">Observaciónes:_______________________________________________________________</font></strong></font></div></td>
		  </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td><div align="left"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">_____________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		</table>
		<table width="650" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
			<td>&nbsp;</td>
		    <td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
		    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">________________________________</font></strong></div></td>
		  </tr>
		  <tr>
		    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Profesor(a) Jefe </font></div></td>
		    <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Director(a) Establecimiento </font></div></td>
		  </tr>
		  <tr>
		    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2"><? echo $nombre_profe; ?> </font></strong></div></td>
		    <td><div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="2">
			<?
			$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";
			$result =@pg_Exec($conn,$sql);
			if (!$result) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (10030)</B>');
			}
			else
			{
				if (pg_numrows($result)!=0)
				{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}
			echo trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']);
			?></font></strong></div>			</td>
		  </tr>
		</table>
		</div>
		<script>
			document.getElementById("capa1").style.display='none';
		</script>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</td>
</tr>
</table>
<!-- fin codigo  antiguo --></td>
                                </tr>
                              </table></td>
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

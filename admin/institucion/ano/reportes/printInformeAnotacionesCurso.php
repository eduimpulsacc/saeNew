<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAnotacionesCurso.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>

<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodo;
	$_POSP = 4;
	$_bot = 8;
	if($periodo == "")
	{
		$periodo = $cmb_periodos;
	}
	
	//----------------------------------------------------------------------------
	//-------------- INSTITUCION -------------------------------------------------------------
	$sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_ins =@pg_Exec($conn,$sql_ins);
	$fila_ins = @pg_fetch_array($result_ins,0);	
	$ins_pal = $fila_ins['nombre_instit'];
	$direccion = $fila_ins['calle'] . " " . $fila_ins['nro'] . " " . $fila_ins['nom_com'];
	$telefono = $fila_ins['telefono'];	
	//----------------------------------------------------------------------------
	// A�O ESCOLAR
	//----------------------------------------------------------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila_ano['nro_ano'];
	// Curso //
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------- PROFE JEFE
	$sql_profe = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
	$sql_profe = $sql_profe . "FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
	$sql_profe = $sql_profe . "WHERE (((supervisa.id_curso)=".$curso.")); ";
	$result_profe =@pg_Exec($conn,$sql_profe);
	$fila_profe = @pg_fetch_array($result_profe,0);	
	$profe_jefe = ucwords(strtoupper(trim($fila_profe['ape_pat']) . " " . trim($fila_profe['ape_mat'] ) . " " . trim($fila_profe['nombre_emp'])));
	//-----------------------------------------	
	//------------------FECHAS DE PERIODOS -----------------------
	$sql="";
	if($periodo==0)
	{
		$sql_peri = "select * from periodo where id_ano = ".$ano." order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		for($i=0;$i<pg_numrows($result_peri);$i++)
		{
			if($i==0) //primer semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_inicio = $fila_per['fecha_inicio'];					
			}
			if($i==1) //segundo semestre
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
			if($i==3)//tercer semestre en caso q haya
			{
				$fila_per = pg_fetch_array($result_peri,$i);
				$fecha_termino = $fila_per['fecha_termino'];
			}
		}	
	}else{
	
	$sql="SELECT fecha_inicio,fecha_termino FROM periodo WHERE id_periodo=".$periodo;
	$Rs_Periodo = @pg_exec($conn,$sql);
	$fila_Periodo=@pg_fetch_array($Rs_Periodo,0);
	$fecha_inicio=$fila_Periodo['fecha_inicio'];
	$fecha_termino=$fila_Periodo['fecha_termino'];
	}
	//-----------------------------------------------------------
	
	
	
	
	

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INSERTO CUERPO DE LA P�GINA -->
	   
<?
if ($curso != 0){
   
   ?>
    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td>
	   <div id="capa0">
	     <table width="100%">
	       <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	       <td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	      </td></tr>
		 </table>
      </div>
	</td>
    </tr>
   </table>
 
<br>
<?
	
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
			<?	
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## c�digo para tomar la insignia
			
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			?>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">CANTIDAD DE ANOTACIONES DEL CURSO</div></td>
    </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor Jefe</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $profe_jefe?></font></td>
        </tr>
  </table>
	 <br>

     <table width="650" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#DBDBDB">
          <tr>
	      <?
		  $q1 = "select * from tipos_anotacion where rdb = '".trim($institucion)."' order by id_tipo";
		  $r1 = pg_Exec($conn,$q1);
		  $n1 = pg_numrows($r1);
		  
		  if ($n1>0){ 
			 $i = 0;
			 while ($i < $n1){				
			    $f1 = pg_fetch_array($r1,$i);
				$id_tipo     = $f1['id_tipo'];
				$codtipo     = $f1['codtipo'];
				$descripcion = $f1['descripcion'];		  
		        ?>
                <td colspan="2" valign="top" width="130"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<?=$codtipo ?><br><?=$descripcion ?></font></td>
				<?
				$i++;
			 }
		  }
		  ?>		  
		  </tr>
       
	      <?
		  for ($ii=0; $ii < 27; $ii++){ ?>
			   <tr>
			   <?
			   if ($n1>0){ 
				 $i = 0;
				 while ($i < $n1){				
					$f1 = pg_fetch_array($r1,$i);
					$id_tipo     = $f1['id_tipo'];
					$codtipo     = $f1['codtipo'];
					$descripcion = $f1['descripcion'];	
										
					$q2 = "select * from detalle_anotaciones where id_tipo =".trim($id_tipo)." order by id_anotacion";
					$r2 = @pg_Exec($conn,$q2);
					$n2 = @pg_numrows($r2);
					
					$f2 = @pg_fetch_array($r2,$ii);
			        $id_anotacion  = $f2['id_anotacion'];
					$codigo  = $f2['codigo'];
			        $detalle = $f2['detalle'];	
								
						 ?>
						 
						 <td width="9%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<?=$codigo ?></font></td>
						 
						 <?
						 $sql_curso_alumnos = "select * from anotacion where id_periodo = '$periodo' and rut_alumno in (select rut_alumno from matricula where id_curso = '$curso' and bool_ar = '0') and codigo_tipo_anotacion > 0 and codigo_anotacion = '$codigo'";
						 $res_curso_alumnos = @pg_Exec($conn,$sql_curso_alumnos);
						 $num_curso_alumnos = @pg_numrows($res_curso_alumnos);
						 ?>
						 
						 <td width="9%" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp; <? if ($num_curso_alumnos > 0){ ?> <?=$num_curso_alumnos ?> <? } ?></font></td>
						 
						 <?
						 
													 
					$i++;					 
				 }
			   }
			   ?>            
			   </tr>
			   <?
		   }
		   ?>
		   
		   <!--
       	      <tr>
		      <?
		      if ($n1>0){ 
			     $i = 0;
			     while ($i < $n1){				
			        $f1 = pg_fetch_array($r1,$i);
				    $id_tipo     = $f1['id_tipo'];
				    $codtipo     = $f1['codtipo'];
				    $descripcion = $f1['descripcion'];	
				    ?>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<?
					$i++;
			     }
		      }
			  ?>
			  </tr>	
			-->  		  		      
		  
     </table>

</center>
<?
}
?>   
<!-- FIN CUERPO DE LA PAGINA -->					  
								
</body>
</html>
<? pg_close($conn);?>
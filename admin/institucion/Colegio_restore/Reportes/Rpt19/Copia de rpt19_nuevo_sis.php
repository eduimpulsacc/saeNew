<?php 
require('../../../../../util/header.inc');

$c_alumno=$cmb_alumno;
$ano		= $_ANO;
$curso		= $c_curso;
$alumno		= $c_alumno;
$institucion= $_INSTIT;
$_POSP = 5;
$_bot = 8;
if ($cmb_ano){
	$ano=$cmb_ano;
	$_ANO=$ano;
	if(!session_is_registered('_ANO')){
		session_register('_ANO');
	}
$curso=0;	

}

	
if ($cmb_curso){
	$curso=$cmb_curso;
	$_CURSO=$curso;
	if(!session_is_registered('_CURSO')){
		session_register('_CURSO');
	}
}
//if ($c_alumno==0)
// exit;
if ($cb_ok){
 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
 	$sqlMatri="select * from curso where id_curso=$curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);
			if($filaMatri['grado_curso']==1) $gr="pa";
			if($filaMatri['grado_curso']==2) $gr="sa";
			if($filaMatri['grado_curso']==3) $gr="ta";
			if($filaMatri['grado_curso']==4) $gr="cu";
			if($filaMatri['grado_curso']==5) $gr="qu";
			if($filaMatri['grado_curso']==6) $gr="sx";
			if($filaMatri['grado_curso']==7) $gr="sp";
			if($filaMatri['grado_curso']==8) $gr="oc";

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$filaMatri['ensenanza']." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	$plantilla=$filaPlantilla[id_plantilla];
	
	
	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);

	$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultORI =@pg_Exec($conn,$qryORI);
	$filaORI=@pg_fetch_array($resultORI);

//	$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo from periodo where id_periodo=".$periodo;
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
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
		
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$sql_ano="select nro_ano from ano_escolar where id_ano=".$_ANO;
    $res_ano =@pg_Exec($conn,$sql_ano);
	$filaAno=@pg_fetch_array($res_ano);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt19.php?institucion=$institucion';
				form.submit(true);
	
				}	
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','<? echo $c; ?>botones/periodo_roll.gif','<? echo $c; ?>botones/feriados_roll.gif','<? echo $c; ?>botones/planes_roll.gif','<? echo $c; ?>botones/tipos_roll.gif','<? echo $c; ?>botones/cursos_roll.gif','<? echo $c; ?>botones/matricula_roll.gif','<? echo $c; ?>botones/informe_roll.gif','<? echo $c; ?>botones/reportes_roll.gif','<? echo $c; ?>botones/actas_roll.gif','<? echo $c; ?>botones/generar_roll.gif')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="1038"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%"  align="left" valign="top"> 
                        <?
						$menu_lateral=3;	?><? 					
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr valign="top"> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <?php if(($_PERFIL!=2)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){  ?>
<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="30" align="center" valign="top"> 
       <?
	   include("../../../../../cabecera/menu_inferior.php");
	   ?>
	  <tr>
    <td> <div align="right"><font color="#000099" size="2">*para volver presione 
        Reportes</font><font color="#000099"><strong> </strong></font></div></td>
		</tr> 
  
  
</table>
<? } ?>

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

<div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td> <div align="right">
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonXX" 
		id="cmdimprimiroriginal" 
		onclick="MM_openBrWindow('printrpt19.php?c_curso=<?=$c_curso ?>&c_alumno=<?=$c_alumno ?>','','scrollbars=yes,resizable=yes,width=770,height=500')" 
		value="Imprimir">
        </div></td>
  </tr>
</table>
</div>

<script>

function imprimir1() 
{
	document.getElementById("capa0").style.display='none';
	//document.getElementById("capa2").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
	//document.getElementById("capa2").style.display='block';
	
}
function imprimir2() 
{
	document.getElementById("capa0").style.display='none';
	document.getElementById("capa1").style.display='none';
	
	window.print();
	document.getElementById("capa0").style.display='block';
	document.getElementById("capa1").style.display='block';
}
</script>
<?
 if ($cb_ok){
 	if ($c_alumno==0)
		$sql_alu = "select * from matricula, alumno where id_curso =" . $curso . " and matricula.rut_alumno = alumno.rut_alumno order by alumno.ape_pat, alumno.ape_mat";
	else
		$sql_alu = "select * from matricula where rut_alumno ='" . $c_alumno ."' and id_ano = " . $ano;
	//echo $sql_alu;	
	$result_alu =pg_Exec($conn,$sql_alu);
	$cont_alumnos = pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	echo "contador $cont_paginas;---$cont_alumnos";
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	
	 //$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$filaAno['id_ano']." and matricula.id_curso=curso.id_curso";
	$sqlMatri="SELECT matricula.rut_alumno,matricula.rdb,matricula.id_ano,matricula.id_curso,curso.grado_curso,curso.letra_curso,curso.ensenanza,curso.cod_es, curso.cod_sector,curso.cod_rama FROM matricula, curso WHERE matricula.rut_alumno='".$alumno."' and matricula.id_ano=".$ano." and matricula.id_curso=curso.id_curso";
	$resultMatri=@pg_exec($conn,$sqlMatri);
	$filaMatri=@pg_fetch_array($resultMatri,0);

	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno='".$alumno."'";
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno,0);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$filaMatri['id_curso'];
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$filaMatri['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$filaMatri['id_curso'];
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$titulo2 = $filaPlantilla['titulo_informe2'];

?>
<?php  $filaPlantilla['id_plantilla'];
//
//
//***AJUSTA EL ANCHO DE LA PAGINA PARA IMPRIMIR MAS A LA IZQUIERDA LA PLANTILLA CUANDOI ES HORIZONTAL
//
//
 if($filaPlantilla['orientacion']==0){
			echo "<table width=\"76%\" border=\"0\" align=\"center\">";
	 	}else if($filaPlantilla['orientacion']==1){
			echo "<table width=\"90%\" border=\"0\" align=\"center\">";
		} ?>
  <tr> 
      <td><table width="100%" border="0">
          <tr> 
            <td colspan="4">
  <div id="capa0">
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
	  <!--input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal" 
		onclick="imprimir1();" 
		value="Imprimir parte1">
		 <input 
		name="cmdimprimiroriginal2" 
		type="button" 
		class="botonZ" 
		id="cmdimprimiroriginal2" 
		onclick="imprimir2();" 
		value="Imprimir parte2"--> 
	  </td>
    </tr>
  </table>
  </div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{
			$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
			$retrieve_result = @pg_exec($conn,$output);?>  
      <td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $institucion ?> ALT="NO DISPONIBLE" height="100"></div></td>
	  <? }?>
  <!--     <td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><? echo $nombre_institu;?></strong></font></td>
		<? /*
		$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['foto']))
		{
			$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
			$retrieve_result = @pg_exec($conn,$output);*/?>  		
    <td width="119" rowspan="6"><div align="center"><img src=../../../../../../../tmp/<? echo $alumno ?> ALT="FOTO"  height="100"></div></td>
 -->	<? /*}*/?>
    </tr>
                <tr> 
                  <td width="405" rowspan="5">&nbsp;</td>
                  <td width="191">&nbsp;</td>
                  <td width="78"><strong><font size="1" face="Arial, Helvetica, sans-serif">REGION</font></strong></td>
                  <td width="297"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                    <? echo $fila_reg['nom_reg']?></font></strong></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">PROVINCIA</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                    <? echo $fila_pro['nom_pro']?></font></strong></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">COMUNA</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                    <? echo $fila_com['nom_com']?></font></strong></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O 
                    ESCOLAR</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                    <? echo $filaAno['nro_ano']?></font></strong></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">RBD</font></strong></td>
                  <td><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                    <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?></font></strong></td>
                </tr>
                <tr> 
                  <td colspan="3">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
  
</td>
          </tr>
          <tr align="center" bgcolor="#003b85"> 
              <td colspan="4"></td>
          </tr>
        </table>
	    <div id="capa1">
          <table width="100%" border="0" align="center">
            <tr> 
              <td align="center" class="tableindex"><div align="center"><? echo $titulo2;?>&nbsp;</td>
            </tr>
            <tr> 
              <td align="center" class="tableindex">  
                <?php for($countP=0 ; $countP<@pg_numrows($resultPeriodo) ; $countP++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countP);
						/*if(trim($filaPeriodo['nombre_periodo'])=="PRIMER TRIMESTRE") $per="1 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO TRIMESTRE") $per="2 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="TERCER TRIMESTRE") $per="3 Tr.";
						if(trim($filaPeriodo['nombre_periodo'])=="PRIMER SEMESTRE") $per="1 Sem.";
						if(trim($filaPeriodo['nombre_periodo'])=="SEGUNDO SEMESTRE") $per="2 Sem.";*/
						
						echo $filaPeriodo['nombre_periodo'] ; }?>
              &nbsp;</td>
            </tr>
          </table>
            <table width="100%" border="0">
              <tr> 
                
            <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
                <?php echo trim($filaInstit['nombre_instit']);?></font></strong></td>
              </tr>
            </table>
		    <table width="100%" border="0">
              <tr valign="middle"> 
                <td width="23%" align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif">Res. 
                  Exta. de Educaci&oacute;n N&ordm; <?php echo $filaInstit['nu_resolucion']?> 
                  de fecha 
                  <?php impF($filaInstit['fecha_resolucion'])?>
                  Rol Base de Datos <?php echo $filaInstit['rdb']," - ",$filaInstit['dig_rdb']?> 
                  </font></strong></td>
              </tr>
            </table>
          <table width="100%" border="0">
            <tr> 
              <td colspan="4"><hr noshade color="#000000"></td>
            </tr>
		    </table>          
          <table width="100%" border="0">
            <tr> 
              <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Alumno</font></strong></td>
              <td width="39%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></strong></td>
              <td width="5%"><strong><font size="1" face="Arial, Helvetica, sans-serif">RUT</font></strong></td>
              <td width="47%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></strong></td>
            </tr>
          </table>
          <table width="100%" height="10%">
            <tr > 
              <td width="9%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Curso</font></strong></td>
              <td width="91%" height="20"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></strong></td>
            </tr>
          </table>
	    <?php if($filaMatri['ensenanza']>310){?>
          <table width="100%" border="0">
            <tr> 
              <td width="10%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Especialidad</font></strong></td>
              <td width="90%"><strong>: <font size="1" face="Arial, Helvetica, sans-serif"> 
                <?php $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaMatri['cod_es']." and cod_sector=".$filaMatri['cod_sector']." and cod_rama=".$filaMatri['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];?>
                </font></strong></td>
            </tr>
          </table>
	    <?php } ?>

          
          
          <table width="100%" border="0">
            <tr> 
              <td width="13%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Profesor 
                (a) Jefe</font></strong></td>
              <td width="32%"><strong><font size="1" face="Arial, Helvetica, sans-serif">: 
                <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></strong></td>
              <td width="11%"><strong><font size="1" face="Arial, Helvetica, sans-serif">Orientador 
                (a)</font></strong></td>
              <td width="44%"><strong><font size="1" face="Arial, Helvetica, sans-serif">:
			  <?php echo $filaORI['nombre_emp']." ".$filaORI['ape_pat']." ".$filaORI['ape_mat']?>&nbsp;</font></strong></td>
            </tr>
            <tr> 
              <td><strong><font size="1" face="Arial, Helvetica, sans-serif">Fecha</font></strong></td>
              <td><strong><font size="1" face="Arial, Helvetica, sans-serif"> : 
                <?php setlocale ("LC_TIME", "es_ES"); echo (strftime("%d de %B de %Y")); ?>
              &nbsp;</font></strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
          <hr noshade color="#000000">
          <table width="100%" border="0">
          <tr> 
		  <td><table width="100%" border="1">
            <? 	
	$contador=0;
echo   	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	?>
            <? for ($i=0;$i<$num_cat;$i++){
	$row_cat=pg_fetch_array($result_cat);
?>
            <tr>
              <td colspan="2"  class="tabla04"><? echo $row_cat['glosa'];?></td>
            </tr>
            <? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
			$result_sub=pg_exec($conn,$query_sub);
			$num_sub=pg_numrows($result_sub);?>
            <? for ($j=0;$j<$num_sub;$j++){
				$row_sub=pg_fetch_array($result_sub);
			?>
            <tr class="tabla04">
              <td><img src="../../../../../cortes/p.gif" width="10" height="1" border="0"><? echo $row_sub['glosa'];?></td>
              <? if ($modificar){?>
              <td width="1%" nowrap><? if ($row_sub[con_concepto]==null){?>
&nbsp;
      <? }else{?>
      <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
      <? }?>
      <? if ($row_sub[con_concepto]=="0"){?>
      <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
      <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
      <? $contador++;}?>
      <? if ($row_sub[con_concepto]=="1"){?>
      <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
      <? 
					$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
					$result_concep=pg_exec($conn,$query_concep);
					$num_concep=pg_numrows($result_concep);?>
      <select name="respuesta[<? echo $contador;?>]">
        <? 		for ($ii=0;$ii<$num_concep;$ii++){
							$row_concep=pg_fetch_array($result_concep);
					?>
        <option  value="<? echo $row_concep[id_concepto];?>"<? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[glosa];?></option>
        <? }?>
      </select>
      <? $contador++;}?>
              </td>
              <? }else{?>
              <td width="1%" nowrap><?   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
										$result_respuesta=pg_exec($conn,$query_respuesta);
										$num_respuesta=pg_numrows($result_respuesta);
										if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													echo $row_con[nombre];
												}
											}else{
												echo $row_respuesta[respuesta];
											}
										}
									
									
									?>
          &nbsp; </td>
              <? }?>
            </tr>
            <? 	 $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_item=pg_exec($conn,$query_item);
					$num_item=pg_numrows($result_item);?>
            <? for ($z=0;$z<$num_item;$z++){
						$row_item=pg_fetch_array($result_item);
					?>
            <tr class="tablatit2-1">
              <td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
              <? if ($modificar){?>
              <td width="1%" nowrap><input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
                  <? if ($row_item[con_concepto]=="0"){?>
                  <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                  <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                  <? $contador++;}?>
                  <? if ($row_item[con_concepto]=="1"){?>
                  <? 
							$query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
							$result_concep=pg_exec($conn,$query_concep);
							$num_concep=pg_numrows($result_concep);?>
                  <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
	$result_respuesta=pg_exec($conn,$query_respuesta);
	$num_respuesta=pg_numrows($result_respuesta);
	if ($num_respuesta>0){
	$row_respuesta=pg_fetch_array($result_respuesta);
	$valor=$row_respuesta[respuesta];
	}
	?>
                  <select  name="respuesta[<? echo $contador;?>]">
                    <? 							for ($ii=0;$ii<$num_concep;$ii++){
									$row_concep=pg_fetch_array($result_concep);
							?>
                    <option value="<? echo $row_concep[id_concepto];?>" <? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[glosa];?></option>
                    <? }?>
                  </select>
                  <? $contador++;}?></td>
              <? }else{?>
              <td width="1%" nowrap><? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
										$result_respuesta=pg_exec($conn,$query_respuesta);
										$num_respuesta=pg_numrows($result_respuesta);
										if ($num_respuesta>0){
											$row_respuesta=pg_fetch_array($result_respuesta);
											if ($row_respuesta[concepto]==1){
												$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													echo $row_con[nombre];
												}
											}else{
											echo $row_respuesta[respuesta];
											}
										}
									
									
									?>
          &nbsp;</td>
              <? }?>
            </tr>
            <? }?>
            <? }?>
            <? }?>
          </table></td>
          </tr>
        </TABLE>
   
  <?php //if($filaPlantilla['orientacion']==0){?>
  
            
   <?   if  (($cont_alumnos - $cont_paginas)<>1) 	echo "<H1 class=SaltoDePagina></H1>";}?>
  
<? }?>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?
$institucion	=$_INSTIT;
$ano			=$_ANO;
?>	

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'rpt19.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<form method "post" action="">
<? 

$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);

//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
<center>
<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>A&ntilde;o Escolar<br>
				  <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
					
		    	    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
                    <select name="cmb_ano" class="ddlb_x"  onChange="window.location='rpt19_nuevo_sis.php?cmb_ano='+this.value;">
                      <option value=0 selected>(Seleccione un Año)</option>
                      <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
                    </select>				
                    <? }	?>		
						 
			  
				
				</td>
			</tr>
 
                  <tr> 
                    <td class="textosmediano"><br>
                      <span class="textosimple">Curso</span><font size="1" face="arial, geneva, helvetica"><br>
                      <select name="cmb_curso"  class="textosimple" onChange="window.location='rpt19_nuevo_sis.php?cmb_curso='+this.value;">
                        <option value=0 selected>(Seleccione Curso)</option>
                        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
                      </select>
                    </font> <div align="left"></div>                    <div align="right"></div></td>
                    </tr>
                  <tr>
                    <td class="textosmediano"><br>
                      <span class="textosimple">Alumno</span><br>
                      <select name="cmb_alumno" class="textosimple">
                        <option value=0 selected>(Todos los alumnos)</option>
                        <?
		 $sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		if ($cmb_curso!=0){
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
                        <?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
                        <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                        <?
		    }else{
			    ?>
                        <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>		
                        <?  
		    }
		}
		?><? }?>
                      </select></td>
                    </tr>
					                 <tr>
                    <td class="textosmediano"><span class="textosimple"><br>Per&iacute;odo</span><br>
                      <select name="periodo" class="textosimple">
					  
                        <option value=0 selected>(Seleccione Periodo)</option>
                        <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $filaP = @pg_fetch_array($result_peri,$i); 
		  if ($filaP["id_periodo"]==$periodo){
				echo "<option selected value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
  		  }else{
				echo "<option value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
		  }
          } ?>
                                          </select></td>
                    </tr>
                  <tr>
                    <td class="textosmediano"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','rpt19_nuevo_sis.php?periodo='+periodo.options[periodo.selectedIndex].value+'&amp;c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;periodo='+periodo.options[periodo.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cb_ok=1');return document.MM_returnValue" value="Buscar"></td>
                    </tr>
                </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>

<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="12" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
</body>
</html>

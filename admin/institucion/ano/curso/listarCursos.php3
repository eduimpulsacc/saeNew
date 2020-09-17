<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;	

	$_POSP          = 4;
	$_bot           = 5;
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
	$result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);

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
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
		
	
	if (!$ano){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la intitucion \r\n');
	window.location= '../listarAno.php3';
</script>	
	
	<? exit;
		
	}
	
	

	//-------

	$sqlCurso = "select institucion.nombre_instit, ano_escolar.nro_ano ";

	$sqlCurso = $sqlCurso . " from institucion, ano_escolar ";

	$sqlCurso = $sqlCurso . " where institucion.rdb = $institucion and ano_escolar.id_ano = $ano ";

	$rsCurso =@pg_Exec($conn,$sqlCurso);												

	$fCurso = @pg_fetch_array($rsCurso,0);		

	//-------		



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
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

<?php if($_PERFIL==0){?>
function traspaso(){
	var ano=<?php echo $ano ?>;
	if(confirm("Seguro de trasapasar configuración de los cursos")){
		$.ajax({
				url:"traspaso_conf/traspaso_conf.php",
				data:"ano="+ano,
				type:'POST',
				success:function(data){
				
				alert("Datos Traspasados");
				window.location.reload();
		  }
		}); 
	}

}
<?php }?>
</script>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

	

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../Sea/cortes/b_ayuda_r.jpg','../../../../Sea/cortes/b_info_r.jpg','../../../../Sea/cortes/b_mapa_r.jpg','../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr valign="top"> 
                                  <td height="390"><!-- inicio codigo nuevo -->
<center>


<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="left" valign="top"> 
     <!-- <table width="810" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../matricula/listarMatricula.php3"><img src="../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="periodo/listarPeriodo.php3"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table>	-->	
	   </td>
  </tr>
</table>


<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			

		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
		
		

			<TR height=15>

				<TD COLSPAN=4 valign="top">

					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>

						<TR>

                          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>

                          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>

                          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php echo trim($fCurso['nro_ano']); ?> </strong> </FONT> </TD>
					  </TR>
					</TABLE>
					<!--<table width="50" border="0" align="right" cellpadding="0" cellspacing="0">
					  <tr>
					    <td><img  src="../../../../images/BUHO_SAE.png" title="Necesitas Ayuda ?" width="56" height="37"></td>
					    </tr>
					  </table>--></TD>

			</TR>

			<tr>

				<td colspan=4 align=right>

					<?php
					 if ($situacion !=0){
					 if($ingreso==1 || $_PERFIL==0){ ?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick="document.location='seteaCurso.php3?caso=2'">
					<?php }?>
 <?php if($_PERFIL==0){ ?>
						<INPUT class="botonXX"  TYPE="button" value="MODIFICAR TODOS" onClick="document.location='seteaConfig.php?caso=1'">
					<?php }
					 }else{
						 if($_PERFIL==0){ ?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR" onClick="document.location='seteaCurso.php3?caso=2'">
                        
                        
					<?php }
                    
					 }// cierre if año academico?>  
                     <?php if($_PERFIL==0){?>
					 <INPUT class="botonXX"  TYPE="button" value="TRASPASAR CONFIGURACION" onClick="traspaso()">
					 <?php } ?>                

					<!--<input name="button" TYPE="button" class="botonXX" onClick=window.open("ImprimeListadoCurso.php?_url=0","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=650,top=85,left=140")  value="IMPRIMIR">-->

					<!--INPUT class="botonXX" TYPE="button" value="VOLVER" onClick=document.location="../seteaAno.php3?caso=4"-->

				</td>
               

			</tr>

			              <tr height="20"> 
                            <td colspan="4" align="middle" valign="top" class="tableindex">  
                              Total de Cursos = 
                              <?php

							$qry="SELECT curso.id_curso, curso.cod_decreto, curso.grado_curso, curso.letra_curso, curso.acta, curso.bool_jor,   tipo_ensenanza.nombre_tipo, cod_tipo FROM tipo_ensenanza INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by tipo_ensenanza.nombre_tipo,curso.grado_curso, curso.letra_curso asc"; 
							$result =@pg_Exec($conn,$qry);

							$fila = @pg_fetch_array($result,0);

							echo @pg_numrows($result);

						?></td>

			</tr>

			<tr class=" tablatit2-1">

				<td width="40" align="center" class="tablatit2-1">

					GRADO				</td>

				<td align="center" width="40" class=" tablatit2-1">

					LETRA

				</td>

				<td align="center" width="320" class=" tablatit2-1">

					ENSEÑANZA

				</td>

				<td align="center" width="200" class=" tablatit2-1">

				PROFESOR JEFE

				</td>

			</tr>

			

			<?php
                    $cant_errores = 0;
					
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						if($modifica==1 || $ver==1){
						
						$bool_jor = $fila['bool_jor'];
						$acta     = $fila['acta'];
						$cod_tipo = $fila['cod_tipo'];
						
						if (($acta==NULL or $acta==0)   and $cod_tipo > 10){
						    $error_conf = 1;
							$color = "#FF0000";
						}else{
						    $color = "#000000";
						}	
												
			            ?>
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='#ffffff' onClick=go('seteaCurso.php3?curso=<?php echo $fila["id_curso"];?>&caso=1&ano=<?=$ano ?>&institucion=<?=$institucion ?>')>
				<? }else{?>
						<tr bgcolor="#ffffff" onmouseover=this.style.background='#ffff00';this.style.cursor='hand' onmouseout=this.style.background='#ffffff'>
				<? } ?>		

							<td align="center" >

								<font face="arial, geneva, helvetica" size="1" color="<?=$color?>">

									<strong>

									<?php
							if ($error_conf==1){
							    echo "* ";
							}			
									
									 

							if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){

								echo "PRIMER NIVEL";

							}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){

								echo "PRIMER CICLO";

							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1001) and ($fila['cod_tipo']==363)){

								echo "PRIMER NIVEL";

							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1001) and ($fila['cod_tipo']==363)){

								echo "SEGUNDO NIVEL";

							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){

								echo "SALA CUNA";

							}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){

								echo "SEGUNDO NIVEL";
								
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==871990) or ($fila['cod_tipo']==212)) ){

								echo "PRÉBASICO 2º - 3";

							}//else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){

								//echo "SEGUNDO CICLO";

							else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){

								echo "NIVEL MEDIO MENOR";

							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){

								echo "TERCER NIVEL";
								
							}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==121987)) ){

								echo "SEGUNDO CICLO";	

							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){

								echo "NIVEL MEDIO MAYOR";

							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){

								echo "TRANSICIÓN 1er NIVEL";
							
							}else if ( ($fila['grado_curso']==23) and ($fila['cod_decreto']==125)){

								echo "NIVEL MEDIO MAYOR";
								
							}else if ( ($fila['grado_curso']==24) and ($fila['cod_decreto']==125)){

								echo "PRIMER NIVEL TRANSICIÓN";
							
							}else if ( ($fila['grado_curso']==25) and ($fila['cod_decreto']==125)){

								echo "SEGUNDO NIVEL TRANSICIÓN";
										
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==871990 and ($fila['cod_tipo']==212))){

								echo "PRÉBASICO 2º - 4";
							
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "PRÉBASICO 1º - 3";
							
							}else if ( ($fila['grado_curso']==6) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "PRÉBASICO 2º - 5";
								
							}else if ( ($fila['grado_curso']==11) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "BASICO 2º - 5";

							}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){

								echo "TRANSICIÓN 2do NIVEL";
								
							}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==871990 and ($fila['cod_tipo']==212) )){

								echo "BÁSICO 1º - 5";
								
							}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211) )){

								echo "PRÉBASICO 2º - 4";
								
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==771982)){

								echo "CUARTO NIVEL";
	
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==165) ){

								echo "1er NIVEL BÁSICO";	
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==363) ){

								echo "3er NIVEL MEDIO";	
							
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==2572009) and ($fila['cod_tipo']==160) ){

								echo "1er NIVEL BÁSICO";	
							
							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==2572009) and ($fila['cod_tipo']==160) ){

								echo "2do NIVEL BÁSICO";	
							
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2572009) and ($fila['cod_tipo']==160) ){

								echo "3er NIVEL BÁSICO";	
								
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==165) ){

								echo "2do NIVEL BÁSICO";	

							
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==167) ){

								echo "2do NIVEL BÁSICO";	

							
							}else if ( ($fila['grado_curso']==8) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==165) ){

								echo "3er NIVEL BÁSICO";	

							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==5842007) and ($fila['cod_tipo']==160) ){

								echo "3er NIVEL BÁSICO";	

							
							}else if ( ($fila['grado_curso']==8) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==167) ){

								echo "3er NIVEL BÁSICO";	
							
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==365) ){

								echo "1er NIVEL MEDIO";	
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==363) ){

								echo "1er NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==2392004) and ($fila['cod_tipo']==363) ){

								echo "2do NIVEL MEDIO";	
							
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==2572009) and ($fila['cod_tipo']==363) ){

								echo "1er NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==2572009) and ($fila['cod_tipo']==363) ){

								echo "2do NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==2572010) and ($fila['cod_tipo']==663) ){

								echo "1er NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==2572010) and ($fila['cod_tipo']==663) ){

								echo "2do NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==2572010) and ($fila['cod_tipo']==663) ){

								echo "3er NIVEL MEDIO";	

							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==34888) and ($fila['cod_tipo']==960) ){

								echo "2do GEM";	

							}else if ( ($fila['grado_curso']==6) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "BÁSICO 1º - 6";	
							
							}else if ( ($fila['grado_curso']==7) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "BÁSICO 1º - 7";	
							
							}else if ( ($fila['grado_curso']==7) and ($fila['cod_decreto']==2119999) and ($fila['cod_tipo']==211) ){
								echo "BÁSICO 1º - 1";	

							}else if ( ($fila['grado_curso']==8) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "BÁSICO 2º - 8";	

							}else if ( ($fila['grado_curso']==9) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "BÁSICO 2º - 9";	
							
							}else if ( ($fila['grado_curso']==9) and ($fila['cod_decreto']==2119999) and ($fila['cod_tipo']==211) ){

								echo "BÁSICO 1º - 3";	

							}else if ( ($fila['grado_curso']==10) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "BÁSICO 2º - 10";
							
							}else if ( ($fila['grado_curso']==10) and ($fila['cod_decreto']==2119999) and ($fila['cod_tipo']==211) ){

								echo "BÁSICO 1º - 4";
							
							}else if ( ($fila['grado_curso']==11) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "LABORAL 1";	
							
							}else if ( ($fila['grado_curso']==12) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){

								echo "LABORAL 2";	
							}else if ( ($fila['grado_curso']==13) and ($fila['cod_decreto']==871990) and ($fila['cod_tipo']==212) ){
								echo "LABORAL 3";
								
							}else if ( ($fila['grado_curso']==14) and ($fila['cod_decreto']==2119999) and ($fila['cod_tipo']==211) ){

								echo "BÁSICO 2º - 8";
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==5842007) and ($fila['cod_tipo']==165 || $fila['cod_tipo']==167) ){

								echo "NIVEL BASICO 1(1 Y 4 BASICO)";	
										
							}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==5842007) and ($fila['cod_tipo']==165 || $fila['cod_tipo']==167) ){

								echo "NIVEL BASICO 2(5 Y 6 BASICO)";	
								
							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==5842007) and ($fila['cod_tipo']==165 || $fila['cod_tipo']==167) ){
								echo "NIVEL BASICO 3(7 Y 8 BASICO)";
		
							}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==10002009) and ($fila['cod_tipo']==363) ){
								echo "1er NIVEL(1 Y 2 MEDIO)";
							
							}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==10002009) and ($fila['cod_tipo']==363) ){
								echo "2do NIVEL(3 Y 4 MEDIO)";
						
							}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==10002009) and ($fila['cod_tipo']==463 || $fila['cod_tipo']==563 || $fila['cod_tipo']==663) ){
								echo "3er NIVEL(4 MEDIO)";
	
							}
			else if ( ($fila['grado_curso']==12) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "BÁSICO 2º - 6";
							
							}
			else if ( ($fila['grado_curso']==12) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "BÁSICO 2º - 6";
							
							}
			else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "1° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "2° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "3° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "4° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "5° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==6) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "6° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==7) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "7° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==8) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "8° BÁSICO ";
							
			}
			else if ( ($fila['grado_curso']==25) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "NIVEL DE TRANSICIÓN 2";
							
			}
			else if ( ($fila['grado_curso']==25) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==216))){

								echo "NIVEL DE TRANSICIÓN 2";
							
			}
			else if ( ($fila['grado_curso']==31) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "LABORAL 1";
							
			}
			else if ( ($fila['grado_curso']==31) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==216))){

								echo "LABORAL 1";
							
			}
			else if ( ($fila['grado_curso']==32) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "LABORAL 2";
							
			}
			else if ( ($fila['grado_curso']==32) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==216))){

								echo "LABORAL 2";
							
			}
			else if ( ($fila['grado_curso']==33) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==212))){

								echo "LABORAL 3";
							
			}
			else if ( ($fila['grado_curso']==33) and ($fila['cod_decreto']==832015 and ($fila['cod_tipo']==216))){

								echo "LABORAL 3";
							
			}
			
			
			
			
			
			
			
			
			
			
			else if ( ($fila['grado_curso']==13) and ($fila['cod_decreto']==2119999 and ($fila['cod_tipo']==211))){

								echo "BÁSICO 2º - 7";
							
							}
		else if($fila['cod_tipo']==214){
		if($fila['grado_curso']==1){
			
			echo  "NIVEL MEDIO MENOR";

		
			
			}
			if($fila['grado_curso']==2){
			
			echo  "NIVEL MEDIO MAYOR";

			
			}
			if($fila['grado_curso']==3){
			echo  " TRANSICI&Oacute;N PRIMER NIVEL ";

		
			
			}
			if($fila['grado_curso']==4){
			echo " TRANSICI&Oacute;N SEGUNDO NIVEL ";

			
			}
		
		}
							else{

								imp($fila['grado_curso']);

							}

									//echo $fila["grado_curso"];?></strong>

								</font>

							</td>

							<td align="center" >

								<font face="arial, geneva, helvetica" size="1" color="<?=$color?>">

									<strong><?php echo $fila["letra_curso"];?></strong>

								</font>

							</td>

							<td align="left">

								<font face="arial, geneva, helvetica" size="1" color="<?=$color?>">

									<strong><?php echo $fila["cod_tipo"];?> - <?php echo $fila["nombre_tipo"];?></strong>

								</font>

							</td>

							<?php
							    //------------------
								$qry55="select * from supervisa where id_curso=".$fila['id_curso'];
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								$qry5="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
								$result5 =@pg_Exec($conn,$qry5);
								$fila5 = @pg_fetch_array($result5,0);
								
								//------------------
							?>

							<td align="left">
							 <?
							 if ($fila5['nombre_emp']==NULL){
							     echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
								 $cant_errores++;
								 $tipo_error_1 = 1;
						    }else{ ?>		 
								  <font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"];?></strong></font>
								  
						 <? } ?>						     	  

							</td>
						</tr>

			<?php

					

				}

			?>

			
		</table>
		
		
								<?
								if ($cant_errores>0){ ?>	  
	                                  <br>
									  <table width="80%" border="1"  cellpadding="0" cellspacing="0">
									  <tr>
									  <td bgcolor="#FFFFFF">
										  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td width="10%"><div align="center"><img src="../../../../icono_atencion.gif" width="33" height="28"></div></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" >Atenci&oacute;n esta p&aacute;gina contiene <font color="#FF0000"><b><?=$cant_errores?></b></font> observaciones, las cuales debe corregir. </font></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td>
											   <? if ($tipo_error_1==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta informaci&oacute;n, </font> En uno o más campos falta informaci&oacute;n para determinar ciertos procesos. </font><br><? } ?>
											   <? if ($tipo_error_2==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Información incorrecta, </font> Información errónea o no concuerda con la información requerida. </font><br><? } ?>
											   <? if ($error_conf==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><font color="#FF0000">*</font> Entre a la configuración del Curso y corriga la información faltante</font><? } ?>
											   
											   <br>											   											  
											 </td>
											</tr>
										  </table>
									  </td>
									  </tr>
									  </table>
							 <? } ?>
							 
							 <br>
		
	</center>

								  
								  <!-- fin codigo nuevo --></td>
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
</body>
</html>

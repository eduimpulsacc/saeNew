<?php require('../../../../../util/header.inc');?>
<?php 
	if ($id_ramo){
		$_RAMO=$id_ramo;
		$_FRMMODO="mostrar";
	}
	if ($modificar){
		$_FRMMODO="modificar";
	}
	
	if ($eliminar){
		$_FRMMODO="eliminar";
	}
	
	//echo $_FRMMODO;

	$_POSP          =6;
	$_bot           =5;
?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$frmModo 		=$_FRMMODO;

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
	
	$qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista, matricula.bool_ar "; 
	$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
	$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno AND tiene$nro_ano.id_curso=matricula.id_curso";
	$qry = $qry . " WHERE tiene$nro_ano.id_ramo=".$ramo." AND matricula.id_ano=".$ano." ";
	$qry = $qry . " ORDER BY matricula.nro_lista asc, ape_pat, ape_mat, nombre_alu, rut_alumno asc ";
	$Rs_Notas = @pg_exec($conn,$qry);
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

	
<script>function MM_preloadImages() { //v3.0
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

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
		function fn(form,field)
		{
			var next=0, found=false
			var f=frm

//			field.value=toUpperCase(field.value);
			field.value=field.value.toUpperCase();
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i-1;
						found=true
						break;
					}
				}
			}
			
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
				for(var i=0;i<f.length;i++)	{
					if(field.name==f.item(i).name){
						next=i+1;
						found=true
						break;
					}
				}
			}



			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
				else{
					if(next<f.length-1)
						next=next+1;
					else
						break;
				}
			}
		}
		function validaNota(box){
			if(box.value.length==0)	
				return true; // acepta longitud 0
			if(!notaNroOnly(box,'Nota inválida.')){
				return false;
			}
			return true;
		}

		function Valida(){ 
		//VALIDA NOTAS
			for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
				if(!validaNota(document.frm.elements[zz])){
						return false;
				}
			}
			alert('El promedio debe procesarse en el ingreso de las notas');
			frm.submit(true);
		}

		function validaNotaConceptual(box){
			
			if(box.value.length==0)	
				return true; // acepta longitud 0
			if(!notaConOnly(box,'ingrese un concepto valido!!!'))
				return false;
			return true;
		}

		function Valida_Conceptual(){ 
		//VALIDA NOTAS
			for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
				if(!validaNotaConceptual(document.frm.elements[zz])){
						return false;
				}
			}
			confirm('El promedio debe procesarse en el ingreso de las notas');
			frm.submit(true);
		}
		
		
		function limpia_txt(x)
		{
			
				document.getElementById(''+x+'').value="";
				
		}
		
		function suma_l(x,j)
		{
			//alert(j);
		var nota = 'Nota'+j+'';
		var promedio_final = 'p_final'+j+''
		
		var Nota = document.getElementById(''+nota+'').value;
		//var Prom_Final = document.getElementById(''+promedio_final+'').value;
		
		var largo = document.getElementById(''+x+'').value.length;
		if(largo == 2)
		{

		var prueba_especial = document.getElementById(''+x+'').value;
		
		if(parseInt(prueba_especial)> parseInt(Nota) && parseInt(prueba_especial)>39){
			var Promedio_Final = 40;
		}else if(parseInt(prueba_especial)> parseInt(Nota) && parseInt(prueba_especial)<40){
			var Promedio_Final = parseInt(prueba_especial)			
		}else{
			var Promedio_Final = parseInt(Nota)
		}

		document.getElementById(''+promedio_final+'').value=Math.ceil(Promedio_Final);
									
			}	
		}


		</SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
				form.action = 'mostrarNotasNivel.php3?id_ramo=<? echo $ramo?>&caso=2&modificar=1&aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		
		</SCRIPT>
        
        <script>
    function confirmReset() {
 var r = confirm('Se procedera a resetear este reporte. Desea continuar?');
 if (r == true) {
   document.location.href = 'prueba_especial.php?id_ramo=<?=$ramo?>&conex= <?php echo $conex ?>&caso=2&eliminar=1';
 } 
 return false;
}
</script>
</head>
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                       <? $menu_lateral="3_1";?> <? include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo antiguo  -->
								  
<FORM method="post" name="frm" action="procesa_prueba_especial.php">
		<TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>AÑO ESCOLAR</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
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
									</strong></FONT>							</TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
									$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, truncado_per FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
									$result =@pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
									}else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);
											$truncado_per = $fila1['truncado_per']; 	
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
												exit();
											}
											echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
										}
									}
								?>
									</strong></FONT></TD>
						</TR>
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>SUBSECTOR</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
//									$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
									$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval, prueba_nivel, pct_nivel, modo_eval_pnivel,conex FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
									$result =@pg_Exec($conn,$qry);
									if (pg_numrows($result)!=0){
										$fila10 = @pg_fetch_array($result,0);	
										echo trim($fila10['nombre']);
										
										$conex = $fila10['conex'];
									}
								?>
									</strong></FONT>							</TD>
						</TR>
                        <TR>
						 <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PLAN DE ESTUDIO</strong></FONT>						 </TD>
						 <TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>						 </TD>
                         <TD><FONT face="arial, geneva, helvetica" size=2><strong>
							 <?php
								$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
											$result4 =@pg_Exec($conn,$qry4);
											$fila4= @pg_fetch_array($result4,0);
										
									echo trim($fila4['nombre_decreto']);
								
							?>
                             </strong></FONT>                          </TD>
						</TR>
                        <TR>
							<TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>DECRETO DE EVAL</strong> </FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
                            <TD><FONT face="arial, geneva, helvetica" size=2><strong>
							  <?php 
								 	$qry4="SELECT curso.id_curso, evaluacion.cod_eval FROM curso INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval WHERE (((curso.id_curso)=".$curso."))";
									$result4 =@pg_Exec($conn,$qry4);
									$fila4= @pg_fetch_array($result4,0);
									$qry5="SELECT * FROM EVALUACION WHERE COD_EVAL=".$fila4['cod_eval'];
									$result5 =@pg_Exec($conn,$qry5);
									if (!$result5) {
										error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
									}else{
										if (pg_numrows($result5)!=0){
											$fila9 = @pg_fetch_array($result5,0);	
											if (!$fila9){
												error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
												exit();
											}
											echo trim($fila9['nombre_decreto_eval'])." (".trim($fila9['cursos']).")";
										}
									
								}
							?>
								</strong></FONT>							</TD>
						</TR> 
					</TABLE>
				</TD>
			</TR>
	</table>
<br>
 <? if($frmModo=="eliminar"){
	 
	 if($conex==1){
		$sql_update_sf ="update situacion_final set prueba_especial= 0 where id_ramo = $ramo";
		 $rs_update_sf=pg_exec($conn,$sql_update_sf);
		 
		 }
	 else{
	$sql_delete = "delete from situacion_final where id_ramo = $ramo";
	$rs_delete=pg_exec($conn,$sql_delete);
	 }
	 ?>
    <script>
     document.location.href = 'prueba_especial.php?id_ramo=<?=$ramo?>';
    </script>
    <?php }?>
    <?php 
	//veo si 
	$sql_pp ="select count(*) as conteo_pe from situacion_final where id_ramo =$ramo";	
	$rs_pp=pg_exec($conn,$sql_pp);
	$ar_conteo= @pg_fetch_array($rs_pp,0);
	 $conteo =$ar_conteo['conteo_pe'];
	?>
<table width="650" border="0" align="center">
  <tr>
    <td align="right">&nbsp;<?php if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){
		if($frmModo=="mostrar"){
	        if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==24977)){
			}
			else{	
			
			if($conex == 1 && $conteo ==0){
				echo "<div align=\"left\"><FONT face=\"arial, geneva, helvetica\" size=2><strong>INGRESE NOTAS EXAMEN</font></div>";
				}
			else{
			
			?>
         <INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name="btnEliminar" onClick="return confirmReset();"> 
		
        <INPUT class="botonXX"  TYPE="button" value="INGRESAR" name="btnCancelar" onClick=document.location="prueba_especial.php?id_ramo=<?=$ramo?>&caso=2&modificar=1">&nbsp;
		<?	
			}
		}	?>
		<INPUT class="botonXX"  TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="listarRamos.php3">
		<?php }
		}
		if($frmModo!="mostrar"){
		
		 //modo de evaluación conceptual ?>
				<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnCancelar>
		<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="prueba_especial.php?id_ramo=<?php echo $ramo?>&caso=2">
	<?  } ?>		&nbsp;</td>
  </tr>
  <tr class="tableindex">
    <td>PRUEBA ESPECIAL</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<br>
</strong>


<table width="600" border="1" align="center" style="border-collapse:collapse">
  <tr class="tablatit2-1">
    <td width="%" align="center">ALUMNOS</td>
    <td width="%" align="center">PROMEDIO</td>
    <?
        $sql_sf="select * from situacion_final sf where sf.id_ramo=$ramo";
		$rs_sf=pg_exec($conn,$sql_sf);
		$comp_sf=pg_result($rs_sf,3);
		if($comp_sf>0){
			?>
	<td width="%" align="center">EXAMEN</td>		
	<?
    }
	?>
    <td width="%" align="center">PRUEBA&nbsp;ESPECIAL</td>
    <td width="%" align="center">PROMEDIO&nbsp;FINAL</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($Rs_Notas);$i++){
  		$fils =@pg_fetch_array($Rs_Notas,$i);
		$Nombre	=$fils['ape_pat']." ".$fils['ape_mat']." ".$fils['nombre_alu'];
		$Rut = $fils['rut_alumno'];
		$sql ="";
		
		$promedio=0;
		$sql ="SELECT round(avg(promedio)) as promedio FROM promedio_examen WHERE rut_alumno=" .$Rut ."  AND id_ramo=".$ramo.";";
		
		$Rs_promedios = @pg_exec($conn,$sql);
		$cantidad_prom = pg_numrows($Rs_promedios);
		if(pg_numrows($Rs_promedios)==0 || pg_result($Rs_promedios,0)==NULL){
			$sql ="SELECT promedio FROM notas$nro_ano WHERE rut_alumno=" .$Rut ."  AND id_ramo=".$ramo ."and promedio > '0'"; 
			//if($_PERFIL==0){echo "<br>".$sql;}
			$Rs_promedios = @pg_exec($conn,$sql);
			$cantidad_prom = pg_numrows($Rs_promedios);
		}
		for($j=0;$j < pg_numrows($Rs_promedios);$j++){
			$fila = @pg_fetch_array($Rs_promedios,$j);
			$promedio = $promedio + $fila['promedio'];
			
		}
		if($_PERFIL==0){
			// echo $promedio."-->".$cantidad_prom;
			 
		}
		if($truncado_per==1){
			$promedio = round($promedio / $cantidad_prom);
		}else{
			$promedio = intval($promedio / $cantidad_prom);
		}
		
		$sql_sf="select * from situacion_final sf where sf.rut_alumno = $Rut and sf.id_ramo=$ramo";
		$rs_sf=@pg_exec($conn,$sql_sf);
		//for($x=0;$x < pg_numrows($rs_sf);$x++){
		$fila_sf=pg_fetch_array($rs_sf,0);
		$comp_examen = pg_numrows($rs_sf);;
		
		if($comp_examen>0){
			
			$promedio=$fila_sf['prom_gral'];
			$nota_examen = $fila_sf['nota_examen'];
	        $prueba_especial = $fila_sf['prueba_especial'];
			$prom_final = $fila_sf['nota_final'];
		}else{
			//	$promedio=0;
			$nota_examen = "";
	        $prueba_especial = "";
			$prom_final = "";
		}
	//	}
		
		
		
       if ($fils['bool_ar'] == 1){
	       ?>
		   <TR bgcolor=#f74215 onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='red'>
           <td class="tachado">
		   <?
	   }else{
	        ?>	   
            <TR onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'>
              <td>
	 <? } ?>		
  
     
    <font size="1" face="Geneva, Arial, Helvetica, sans-serif"><? echo $Nombre;?></font>
    <input type="hidden" name="rut_alumno[<?=$i?>]" value="<?=$Rut?>">
    <input type="hidden" name="id_ramo" value="<?=$ramo?>">
    </td>
	<? 	if($frmModo=="mostrar"){
			if (trim($promedio)==MB || trim($promedio)==B || trim($promedio)==S || trim($promedio)==I || trim($promedio)>0)
				{ $promedio; }
			else{ $promedio = "&nbsp;";}
?>
		<td align="center">
        
        <font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<? echo $promedio;?></font></td>
        
        <?
        	if($comp_sf>0){
				?>
				 <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<? echo $nota_examen;?></font></td>
				<?
                }
		
		?>
        <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<? echo $prueba_especial;?></font></td>
        <td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<? echo $prom_final;?></font></td>
	<? }
		if(($frmModo=="ingresar")||($frmModo=="modificar")){
			if (trim($promedio)==MB || trim($promedio)==B || trim($promedio)==S || trim($promedio)==I || trim($promedio)>0) { //!=0	?>
				<td width="12" align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif"><?  echo trim($promedio);?></font>
                <input type="hidden" readonly id="Nota[<? echo $i;?>]" name="Nota[<? echo $i;?>]" value="<?  echo trim($promedio);?>" onKeyUp="fn(this.form,this)" size="2"  maxlength="2"></td>
	<?		}else {	?>
				<td width="12" align="center"><input type="text" readonly id="Nota[<? echo $i;?>]" name="Nota[<? echo $i;?>]" onKeyUp="fn(this.frm,this)" size="2"  maxlength="2"></td>
	<?		}	
	
	if($comp_sf > 0){
		?>
		<td align="center"><font size="1" face="Geneva, Arial, Helvetica, sans-serif">&nbsp;<? echo $nota_examen;?></font>
        <input type="hidden" name="n_examen[<?=$i?>]" id="n_examen[<?=$i?>]" value="<?=$nota_examen?>">
        
        </td>
        <?
        }
		if($promedio<=39){
	?>
   <td width="12" align="center"><input type="text" id="p_especial[<? echo $i;?>]" name="p_especial[<? echo $i;?>]" value="<?  echo trim($prueba_especial);?>"  onKeyUp="suma_l(this.name,'[<?=$i;?>]')" size="2"  maxlength="2"></td>
   <?
		}else{
   ?>
   <td width="12" align="center"><input readonly type="text" id="p_especial[<? echo $i;?>]" name="p_especial[<? echo $i;?>]" value="<?  echo trim($prueba_especial);?>" onKeyUp="fn(this.frm,this)" size="2"  maxlength="2"></td>
   <?
   }
   if($prom_final==""){
	   ?>
        <td width="12" align="center"><input readonly type="text" id="p_final[<? echo $i;?>]" name="p_final[<? echo $i;?>]" value="<?  echo trim($promedio);?>" onKeyUp="fn(this.frm,this)" size="2"  maxlength="2"></td>
       <?
	   }else{
   ?>
    <td width="12" align="center"><input readonly type="text" id="p_final[<? echo $i;?>]" name="p_final[<? echo $i;?>]" value="<?  echo trim($prom_final);?>" onKeyUp="fn(this.frm,this)" size="2"  maxlength="2"></td>
	<? } 
	
	}?>
    
   </tr>
  <? }  ?>
  
</table>
</form>
<br>


				  
				  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
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
</body>
</html>

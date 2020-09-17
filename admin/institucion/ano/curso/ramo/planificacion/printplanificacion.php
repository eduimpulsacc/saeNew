<?php require('../../../../../../util/header.inc');?>
<?php 
	if ($id_ramo){
		$_RAMO=$id_ramo;
		$_FRMMODO="mostrar";
	}
	if ($modificar){
		$_FRMMODO="modificar";
	}
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}

	$_POSP          =6;
	$_bot           =5;
?>
<?php 
    $periodo        =$periodo; 
   
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$ramo;
	$id_ramo		=$ramo;
	$docente		=5; //Codigo Docente
	$frmModo 		=$_FRMMODO;

	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($periodo==NULL)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
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
		
	$qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso, matricula.nro_lista, matricula.bool_ar "; 
	$qry = $qry . " FROM alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno ";
	$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
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

<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
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


		</SCRIPT>

		<SCRIPT language="JavaScript">
<!--



function enviapag(form){
	if (form.cmbPERIODO.value!=0){
		form.cmbPERIODO.target="self";
		form.submit(true);
	}
}
//-->
</SCRIPT>
<script> 
function cerrar(){ 
window.close() 
} 



function imprimir() 
{

	document.getElementById("capa0").style.display='none';
	window.print();

	document.getElementById("capa0").style.display='block';
}

</script>


<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #006666;
}
-->
</style>
</head>
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">


<!-- inicio codigo antiguo  -->


		<TABLE WIDTH=770 BORDER=0 CELLSPACING=0 CELLPADDING=0 >
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
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
									$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
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
									$qry="SELECT subsector.nombre, subsector.cod_subsector, modo_eval, prueba_nivel, pct_nivel, modo_eval_pnivel FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
									$result =@pg_Exec($conn,$qry);
									if (pg_numrows($result)!=0){
										$fila10 = @pg_fetch_array($result,0);	
										echo trim($fila10['nombre']);
									}
								?>
									</strong></FONT></TD>
						</TR> 
						
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>DOCENTE</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								<?php
									
									$qry_pl="SELECT * from empleado where rut_emp in  (select rut_emp from dicta where id_ramo = '$ramo')";
									$result_pl = pg_Exec($conn,$qry_pl);
									if (pg_numrows($result_pl)!=0){
										$fila10 = @pg_fetch_array($result_pl,0);
										$nombre_emp = $fila10['nombre_emp'];
										$paterno    = $fila10['ape_pat'];
										$materno    = $fila10['ape_mat'];
									}
									
									echo "$nombre_emp $paterno $materno";									
								?>
									</strong></FONT></TD>
						</TR>     
						
						<TR>
							<TD align=left><FONT face="arial, geneva, helvetica" size=2><strong>PERIODO</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT>							</TD>
							<TD><FONT face="arial, geneva, helvetica" size=2><strong>
								
							  
									<?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_periodo)=".$periodo."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													$id_periodo = $fila1['id_periodo'];
													$nombre_periodo = $fila1['nombre_periodo'];
													?>
													<?=$nombre_periodo ?>
													<?
												}
											}
										};
									?>
							
							
								</strong></FONT></TD>
						</TR>                       
				  </TABLE>				</TD>
			</TR>
	</table>
<div id="capa0">
			<table width="770" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td align="left"><table>
						<tr>
						  <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
						  </td>
						</tr>
					</table></td>
					<td align="right">
					 
					  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
					</td>
				  </tr>
		  </table>
            <br>
        </div>


        <table width="770" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
          <tr>
            <td colspan="5" class="tableindex">Planificaci&oacute;n
              <div align="right">
                <label></label>
              </div></td>
          </tr>
          <tr>
            <td width="20%" class="tablatit2-1">Fecha Inicio </td>
            <td width="20%" class="tablatit2-1">Fecha T&eacute;rmino </td>
            <td width="20%" class="tablatit2-1">T&iacute;tulo</td>
            <td width="20%" class="tablatit2-1">Descripci&oacute;n</td>
            <td width="10%" class="tablatit2-1"> Realizado</td>
          </tr>
		  <?
		  /// listar las planificaciones ingresadas
		  $select_pla = "select * from planificacion where id_ramo = '$id_ramo' and id_periodo = '$periodo'";
		  $res_pla = @pg_Exec($conn,$select_pla);
		  $fil_pla = @pg_fetch_array($res_pla,0);
		  $id_planificacion = $fil_pla['id'];
		  
		  /// aqui realizo la evaluacion porcentual de lo realizado
		  $cont_detalle = "select * from detalle_planificacion where id_planificacion = '$id_planificacion' and activo = '1'";
		  $res_cont_detalle = @pg_Exec($conn,$cont_detalle);
		  $num_cont_detalle = @pg_numrows($res_cont_detalle);
		  
		  $cont_realizados = "select * from detalle_planificacion where id_planificacion = '$id_planificacion' and realizado = '1' and activo = '1'";
		  $res_cont_realizados = @pg_Exec($conn,$cont_realizados);
		  $num_cont_realizados = @pg_numrows($res_cont_realizados);
		  		  		  
		  $porcentaje = @round(($num_cont_realizados * 100) / $num_cont_detalle);
		  
		  /// buscar el detalle de las planificaciones
		  $select_deta = "select * from detalle_planificacion where id_planificacion = '$id_planificacion' order by id";
		  $res_deta = @pg_Exec($conn,$select_deta);
		  $num_deta = @pg_numrows($res_deta);
		  
		  for ($i = 0; $i < $num_deta; $i++){
		       $fil_deta    = @pg_fetch_array($res_deta,$i);
			   $id_detalle  = $fil_deta['id'];
			   $fecha_ini   = $fil_deta['fecha_ini'];
			   $fecha_fin   = $fil_deta['fecha_fin'];
			   $titulo      = $fil_deta['titulo'];
			   $descripcion = $fil_deta['descripcion'];
			   $realizado   = $fil_deta['realizado'];
			   $activo      = $fil_deta['activo'];
			   
			   $dd = substr($fecha_ini,8,2);
			   $mm = substr($fecha_ini,5,2);
			   $aa = substr($fecha_ini,0,4);
			   
			   $fecha_ini = "$dd-$mm-$aa";
			   
			   $dd = substr($fecha_fin,8,2);
			   $mm = substr($fecha_fin,5,2);
			   $aa = substr($fecha_fin,0,4);
			   
			   $fecha_fin = "$dd-$mm-$aa";			   
			   
			   if ($activo==0){
			       $estado = 1;
				   $font = "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000'>";
			   }
			   if ($activo==1){
			       $estado = 0;
				   $font = "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#000000'>";
				  
			   }	   
			   
			   $cerrar = "</font>";
			   
			   
			   if ($realizado==0){
			       $realizado="No";
			   }
			   if ($realizado==1){
			       $realizado="Si";
			   }
			   ?>	  
		  
				  <tr>
					<td bgcolor="#FFFFFF"><?=$font ?>&nbsp;<?=$fecha_ini ?><?=$cerrar ?></font></td>
					<td bgcolor="#FFFFFF"><?=$font ?>&nbsp;<?=$fecha_fin ?><?=$cerrar ?></td>
					<td bgcolor="#FFFFFF"><?=$font ?>&nbsp;<?=$titulo ?><?=$cerrar ?></td>
					<td bgcolor="#FFFFFF"><?=$font ?>&nbsp;<?=$descripcion ?><?=$cerrar ?></td>
					<td bgcolor="#FFFFFF"><?=$font ?>&nbsp;<?=$realizado ?><?=$cerrar ?></td>
				  </tr>
		       <?
		   }
		   ?> 
</table>
        <br>
        <table width="770" border="0" cellpadding="3" cellspacing="1" bgcolor="cccccc">
          <tr>
            <td width="30%" class="tablatit2-1">Evaluaci&oacute;n seg&uacute;n items realizados </td>
            <td width="70%" bgcolor="#FFFFFF"><FONT face="arial, geneva, helvetica" size=2><strong><?=$porcentaje ?> % realizado, sobre los &iacute;tmes activos </strong></FONT></td>
          </tr>
</table>
        <br>
        <!-- fin codigo nuevo -->
</body>
</html>

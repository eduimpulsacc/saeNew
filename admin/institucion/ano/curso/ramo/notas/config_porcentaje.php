<?php require('../../../../../../util/header.inc');?>
<?php 

if ($id_ramo != NULL or $id_ramo != 0){
	$_RAMO=$id_ramo;
	session_register('_RAMO');
}


$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$ramo			=$_RAMO;

$docente		=5; //Codigo Docente
$_POSP          =6;
$_bot           =5;

$sql_ano="select nro_ano from ano_escolar where id_ano=".$_ANO;
$res_ano =@pg_Exec($conn,$sql_ano);
$filaAno =@pg_fetch_array($res_ano);
$nro_ano = $filaAno['nro_ano'];



$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);
?>
<script language="javascript">
function recargar(f){
    f.submit();	
}
</script>
<form name="form" method="post" action="#">
<input type="hidden" name="id_ramo" value="<?=$id_ramo?>">
<table>
   <tr>
	  <td >
	       <select name="periodo" class="textosimple" id="periodo" onChange="recargar(this.form);">
		    <option value=0 selected>(Seleccione Periodo)</option>
			   <?
				for($i=0 ; $i < @pg_numrows($result_peri) ; ++$i){
					$filaP = @pg_fetch_array($result_peri,$i); 
					if ($filaP["id_periodo"]==$periodo){
						echo "<option selected value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
					}else{
						echo "<option value=".$filaP['id_periodo'].">".$filaP['nombre_periodo']."</option>";
					}
				}
			   ?>
             </select>
			</td>
  </tr>
</table>
</form>
<?

if ($periodo==NULL and !isset($bot_ingresar)){
   	exit();
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
		$_ANOACTUAL = $ano_act;
	
	}
}


/// guarda la  relacion
if (isset($bot_ingresar)){
    /// buscar si el registro existe
	
	/// verificamos los campos
	if ($val_1<"" or $val_1==NULL or $val_1==" "){
	    $val_1=0;
	}
	if ($val_2<"" or $val_2==NULL or $val_2==" "){
	    $val_2=0;
	}
	if ($val_3<""  or $val_3==NULL or $val_3==" "){
	    $val_3=0;
	}
	if ($val_4<""  or $val_4==NULL or $val_4==" "){
	    $val_4=0;
	}
	if ($val_5<""  or $val_5==NULL or $val_5==" "){
	    $val_5=0;
	}
	if ($val_6<""  or $val_6==NULL or $val_6==" "){
	    $val_6=0;
	}
	if ($val_7<""  or $val_7==NULL or $val_7==" "){
	    $val_7=0;
	}
	if ($val_8<""  or $val_8==NULL or $val_8==" "){
	    $val_8=0;
	}
	if ($val_9<""  or $val_9==NULL or $val_9==" "){
	    $val_9=0;
	}
	if ($val_10<""  or $val_10==NULL or $val_10==" "){
	    $val_10=0;
	}
	if ($val_11<""  or $val_11==NULL or $val_11==" "){
	    $val_11=0;
	}
	if ($val_12<""  or $val_12==NULL or $val_12==" "){
	    $val_12=0;
	}
	if ($val_13<""  or $val_13==NULL or $val_13==" "){
	    $val_13=0;
	}
	if ($val_14<""  or $val_14==NULL or $val_14==" "){
	    $val_14=0;
	}
	if ($val_15<""  or $val_15==NULL or $val_15==" "){
	    $val_15=0;
	}
	if ($val_16<""  or $val_16==NULL or $val_16==" "){
	    $val_16=0;
	}
	if ($val_17<""  or $val_17==NULL or $val_17==" "){
	    $val_17=0;
	}
	if ($val_18<""  or $val_18==NULL or $val_18==" "){
	    $val_18=0;
	}
	if ($val_19<""  or $val_19==NULL or $val_19==" "){
	    $val_19=0;
	}
	if ($val_20<""  or $val_20==NULL or $val_20==" "){
	    $val_20=0;
	}
	if ($val_21<""  or $val_21==NULL or $val_21==" "){
	    $val_21=0;
	}
	
	
	$sql_np = "select id_ramo from nota_porcentaje$nro_ano where id_ramo = '$id_ramo' and id_periodo = '$periodo'";
	$res_np = @pg_Exec($conn, $sql_np);
	if (@pg_numrows($res_np)>0){
	     /// existe hay que actualizar	     
		 $sql_np_update = "update nota_porcentaje$nro_ano set pos1='$val_1', pos2 = '$val_2', pos3 = '$val_3', pos4 = '$val_4', pos5 = '$val_5', pos6 = '$val_6', pos7 = '$val_7', pos8 = '$val_8', pos9 = '$val_9', pos10 = '$val_10', pos11 = '$val_11', pos12 = '$val_12', pos13 = '$val_13', pos14 = '$val_14', pos15 = '$val_15', pos16 = '$val_16', pos17 = '$val_17', pos18 = '$val_18', pos19 = '$val_19', pos20 = '$val_20', pos21 = '$val_21' where id_ramo = '$id_ramo' and id_periodo = '$periodo'";
		 $res_np_update = @pg_Exec($conn, $sql_np_update);
		 echo "<script>alert('Información Actualizada correctamente');</script>";
		 echo "<script>window.close();</script>";	
		 
	}else{
	     /// no existe hay que insertar
		 $sql_np_insert = "insert into nota_porcentaje$nro_ano (id_ramo, id_periodo, pos1, pos2, pos3, pos4, pos5, pos6, pos7, pos8, pos9, pos10, pos11, pos12, pos13, pos14, pos15, pos16, pos17, pos18, pos19, pos20, pos21) values ('$id_ramo','$periodo','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21')";
		 $res_np_insert = @pg_Exec($conn, $sql_np_insert);
		 echo "<script>alert('Información ingresada correctamente');</script>";
		 echo "<script>window.close();</script>";	
	}
}else{
     $sql_np_select = "select * from nota_porcentaje$nro_ano where id_ramo = '$id_ramo' and id_periodo='$periodo'";
	 $res_np_select = @pg_Exec($conn, $sql_np_select);
	 
	 if (@pg_numrows($res_np_select)>0){   
	     $fila_np = @pg_fetch_array($res_np_select,0);
		 $val_1  = $fila_np['pos1'];
		 $val_2  = $fila_np['pos2'];
		 $val_3  = $fila_np['pos3'];
		 $val_4  = $fila_np['pos4'];
		 $val_5  = $fila_np['pos5'];
		 $val_6  = $fila_np['pos6'];
		 $val_7  = $fila_np['pos7'];
		 $val_8  = $fila_np['pos8'];
		 $val_9  = $fila_np['pos9'];
		 $val_10 = $fila_np['pos10'];
		 $val_11 = $fila_np['pos11'];
		 $val_12 = $fila_np['pos12'];
		 $val_13 = $fila_np['pos13'];
		 $val_14 = $fila_np['pos14'];
		 $val_15 = $fila_np['pos15'];
		 $val_16 = $fila_np['pos16'];
		 $val_17 = $fila_np['pos17'];
		 $val_18 = $fila_np['pos18'];
		 $val_19 = $fila_np['pos19'];
		 $val_20 = $fila_np['pos20'];
		 $val_21 = $fila_np['pos21'];
     }
	 
}
/////

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript1.5" type="text/JavaScript">
<!--
function enviapag(form){
    if (form.cmbPERIODO.value!=0){
	    form.cmbPERIODO.target="self";
	    form.action = 'new_mostrarNotas_dav2.php3?id_ramo=<?=$ramo?>&aux=1&periodo='+form.cmbPERIODO.value;
	    form.submit(true);
    }
}


<!-- nueva validación -->
function valida_all(f,v,id_box){	   
    
	/// validaciones para modo de evaluacion numérica
	if (v>100 || v<0){
		alert('Error, Porcentaje inválido');
		f.item(id_box).value="";
		f.item(id_box).focus();
					
	}else{	
	    	
		var suma = 0;
		var cant = 0;
		var ff=0;
		
		for (ff=0;ff<20;ff=ff+1){
			if (document.frm.elements[ff].value!=''){
				suma=(parseInt(suma)+parseInt(document.frm.elements[ff].value));
				cant++;
			}			
		}
		
		if (parseInt(suma)>100){
		       document.frm.val_21.value=parseInt(suma);
			   alert('Error, suma de porcentaje no puede superar el valor 100');
			   document.frm.val_1.value="";
			   document.frm.val_2.value="";
			   document.frm.val_3.value="";
			   document.frm.val_4.value="";
			   document.frm.val_5.value="";
			   document.frm.val_6.value="";
			   document.frm.val_7.value="";
			   document.frm.val_8.value="";
			   document.frm.val_9.value="";
			   document.frm.val_10.value="";
			   document.frm.val_11.value="";
			   document.frm.val_12.value="";
			   document.frm.val_13.value="";
			   document.frm.val_14.value="";
			   document.frm.val_15.value="";
			   document.frm.val_16.value="";
			   document.frm.val_17.value="";
			   document.frm.val_18.value="";
			   document.frm.val_19.value="";
			   document.frm.val_20.value="";
			   document.frm.val_21.value="";
			   document.getElementById('divboton').style.visibility='hidden';
		       return false;
		}else{
		       document.frm.val_21.value=parseInt(suma);
		       if (parseInt(suma)==100){
		           document.getElementById('divboton').style.visibility='visible';
		       }			
		}	
	}	
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
		//-->


		function fn(form,field,m)
		{
			var next=0, found=false, x, y, g;
			var f=frm;

			if(event.keyCode==37)  // codigo ascii de la flecha hacia la izquierda <---
			{
						next=m+1;
						found=true;
			}
			if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
			{
						next=m-19;
						found=true
			}
			if(event.keyCode==39)  // codigo ascii de la flecha hacia la derecha --->
			{
						next=m+3;
						found=true
			}
			if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
			{
						next=m+23;
						found=true
			}


			while(found){
				if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
					f.item(next).focus();
					break;
				}
			}

		}

		
</SCRIPT>
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>
<script language="javascript">
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
} 

function eliminaEspacios(cadena)
{
	// Funcion equivalente a trim en PHP
	var x=0, y=cadena.length-1;
	while(cadena.charAt(x)==" ") x++;	
	while(cadena.charAt(y)==" ") y--;	
	return cadena.substr(x, y-x+1);
}


function cargaDatos(idInput,alumno,ramo,periodo,n,promedio){
	var valorInput=document.getElementById(idInput).value;
	var promedio=document.getElementById(promedio).value;
	var divError=document.getElementById("error");
	
	// Elimino todos los espacios en blanco al principio y al final de la cadena
	valorInput=eliminaEspacios(valorInput);
		
	// Valido con una expresion regular el contenido de lo que el usuario ingresa
	var reg=/(^[a-zA-Z0-9._áéíóúñ¡!¿? -]{1,40}$)/;
	
	// Creo objeto AJAX y envio peticion al servidor
	var ajax=nuevoAjax();
	//alert('alumno:'+alumno+' ramo:'+ramo+' periodo:'+periodo+' casilla:'+casilla);
	
	ajax.open("GET", "ingreso_sin_recargar_proceso.php?valor="+valorInput+"&alumno="+alumno+"&ramo="+ramo+"&periodo="+periodo+"&casilla="+n+"&promedio="+promedio, true);
	ajax.send(null);	
	
}

function blanco(f,v){
	f.item(v).style.backgroundColor='#FFFF33';	
}
function blanco2(f,v){
	f.item(v).style.backgroundColor='#B6E7CE';	
}

function calcula(f,v){
    alert('valor ingresado: '+v);
}
</script>	
<style type="text/css">
<!--
.Estilo7 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<?
if ($periodo>0){ 
                 
		$sql_busca = "SELECT * FROM notas$ano_act n INNER JOIN  ramo r ON r.id_ramo=n.id_ramo WHERE n.id_ramo=".$id_ramo." AND n.id_periodo=".$periodo." AND n.nota20 is not null AND n.nota20<>'0'";
		$result_busca =@pg_Exec($conn,$sql_busca);
		$p_nivel = @pg_numrows($result_busca);
                        ?>
                              <br>
                              <table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
                                <tr>
                                  <td><span class="Estilo7">Debe ingresar el porcentaje entre (1 y 100), para las notas que evaluar&aacute; en el subsector. <br>
                                  La suma de todos los porcentajes debe ser igual a 100. </span></td>
                                </tr>
                              </table>
                              <br>
							  <FORM method=post name="frm" action="#">
							    <TABLE BORDER=1 CELLSPACING=0 CELLPADDING=0 width="95%" align="center">
								<?php
									//ALUMNOS DEL CURSO
//                                    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso FROM (alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno) WHERE tiene$ano_act.id_ramo=".$ramo."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
    	                               $qry="SELECT matricula.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$ano_act.id_curso, matricula.nro_lista, matricula.bool_ar "; 
										$qry = $qry . " FROM alumno INNER JOIN tiene$ano_act ON alumno.rut_alumno = tiene$ano_act.rut_alumno ";
										$qry = $qry . " INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno ";
										$qry = $qry . " WHERE tiene$ano_act.id_ramo=".$id_ramo." AND matricula.id_ano=".$ano." ";
										$qry = $qry . " AND matricula.bool_ar=0 ";
										$qry = $qry . " ORDER BY  matricula.nro_lista, ape_pat, ape_mat, nombre_alu, rut_alumno asc limit 1";
										
																				
										$result =@pg_Exec($conn,$qry);

										//matricula.nro_lista asc,

									if (!$result){
										echo "error  <br>";
									    exit();
										//error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									}else{
										
										if(pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);
											    ?>
												<TR>
												<TD align=center>Nº
												</TD>
												<TD align=center>Notas
												</TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19º)</STRONG></FONT></TD>
												<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20º)</STRONG></FONT></TD>
												
												<TD align=center>Porcentaje Total</TD>
												</TR>
												
												<TR>
												<TD align=center>&nbsp;
												</TD>
												<TD align=center>Porcentaje
												</TD>
												<TD align=center><input name="val_1" id="val_1" type="text" value="<?=$val_1?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_2" id="val_2" type="text" value="<?=$val_2?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_3" id="val_3" type="text" value="<?=$val_3?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_4" id="val_4" type="text" value="<?=$val_4?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_5" id="val_5" type="text" value="<?=$val_5?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_6" id="val_6" type="text" value="<?=$val_6?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_7" id="val_7" type="text" value="<?=$val_7?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_8" id="val_8" type="text" value="<?=$val_8?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_9" id="val_9" type="text" value="<?=$val_9?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_10" id="val_10" type="text" value="<?=$val_10?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_11" id="val_11" type="text" value="<?=$val_11?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_12" id="val_12" type="text" value="<?=$val_12?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_13" id="val_13" type="text" value="<?=$val_13?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_14" id="val_14" type="text" value="<?=$val_14?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_15" id="val_15" type="text" value="<?=$val_15?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_16" id="val_16" type="text" value="<?=$val_16?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_17" id="val_17" type="text" value="<?=$val_17?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_18" id="val_18" type="text" value="<?=$val_18?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_19" id="val_19" type="text" value="<?=$val_19?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_20" id="val_20" type="text" value="<?=$val_20?>" size="2" onBlur=" valida_all(this.form,this.value,this.id);"></TD>
												<TD align=center><input name="val_21" id="val_21" type="text" value="<?=$val_21?>" size="2" >
												</TD>
												</TR>
												
												<?

												
											

										};
									};
								?>
							  </TABLE>
							  <div id="divboton" style="visibility:hidden">
							  <br>
							  <table align="center">
							   <tr>
							     <td><input name="bot_ingresar" type="submit" class="botonXX" id="bot_ingresar" value="INGRESAR">
								 </td>
							   </tr>
							  </table>
							  </div>
							  <input type="hidden" name="periodo" value="<?=$periodo?>" id="id_periodo"> 	 
							  
							</FORM>	
					<? } ?>
					
 <?  
 pg_close($conn); ?>						
</body>
</html>

<?php 
require('../../../../../util/header.inc');
require_once("includes/widgets/widgets_start.php");
?>
<?php 
	if($sw2==1)
	{
	$_FRMMODO = 'mostrar';
	}
	$institucion	=8933;
	$frmModo		='modificar';
	$ano			=$_ANO;
	$_POSP          =5;
	$_bot           =5;
	
	//echo $_PERFIL;
	//if ($_ALUMNO!=""){
	if ($sw != 1){
	   $alumno			=$_ALUMNO;
    }else{
	   $_ALUMNO = $alumno;
	}   
	//}
	$curso			=$_CURSO;
	if( $_PERFIL ==109 && $institucion!=516 && $institucion!=12086 && $institucion!=14912 && $institucion!=770 && $institucion!=12838  && $institucion!=9276 )
	{
		$curso = $curso_act; 
	}
		

    $estado = array (                
                 'BAJ' =>"disabled",
                 'BCHS' =>"disabled",
                 'AOI' =>"disabled",
                 'RG' =>"disabled",
                 'AE' =>"disabled",
                 'GD' =>"disabled",
                 'I' =>"disabled"
        );

?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>

<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
		
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
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
	
	if ($r == "no"){
	     if($AR)        $AR=1;      else    $AR=0;
		 
	    // borramos la fecha de el ticket de retiro 
		$q2="UPDATE matricula SET  bool_ar ='".$AR."', fecha_retiro = NULL  WHERE (((rut_alumno)='".trim($_ALUMNO)."') AND (ID_ANO='".trim($ano)."'));";
		$r2=pg_Exec($conn,$q2);
		if (!$r2){
		   echo "Error no se producido la actualizacion";
		}    
		
	}
		$empleado = $fila['rut_emp'];	
?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
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

<?php include('../../../../../util/rpc.php3');?>
	<?php if($frmModo!="mostrar"){?>
		     	
		
		<?php if($frmModo=="modificar"){?>
			<SCRIPT language="JavaScript">
			    
				function valida(form){					
					if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del alumno.')){
						return false;
					};
					
					if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
						return false;
					};
					
					if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO')){
						return false;
					};
/*					if(!alfaOnly(form.txtAPEMAT,'Se permiten s�lo caracteres alfanum�ricos en el campo APELLIDO MATERNO.')){
						return false;
					};					
*/					
					if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
						return false;
					};
					if(!chkSelect(form.cmbNac,'Seleccionar NACIONALIDAD.')){
						return false;
					};				
						
					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};
					if(form.txtTELEF.value!=''){
						if(!phoneOnly(form.txtTELEF,'Se permiten s�lo numeros telef�nicos en el campo TELEFONO.')){
							return false;
						};
					};

					if(form.txtEMAIL.value!=''){
						if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
							return false;
						};
					};
/*					if(form.txtNAC.value==""){
						alert ('FECHA NACIMIENTO invalida.');
						return false;
					};
*/					
     				return true;
				}
			</SCRIPT>
		<?php }?>
		<?php if($frmModo=="ingresar"){?>
		<SCRIPT language="JavaScript">
        <!--
                function valida(form){
					if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
						return false;
					};

					if(!nroOnly(form.txtRUT,'Se permiten s�lo numeros en el RUT.')){
						return false;
					};

					if(!chkVacio(form.txtDIGRUT,'Ingresar d�gito verificador del RUT.')){
						return false;
					};

					if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT invalido.')){
						return false;
					};
					
					if(!chkVacio(form.txtNOMBRE,'Ingrese NOMBRE.')){
						return false;
					};


					if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
						return false;
					};

					

					if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO')){
						return false;
					};

					
					
					if(!chkFecha(form.txtNAC,'FECHA NACIMIENTO invalida.')){
						return false;
					};

					if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
						return false;
					};

					if(!chkSelect(form.cmbNac,'Seleccionar NACIONALIDAD.')){
						return false;
					};		
										
					
					if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
						return false;
					};

					if(form.txtTELEF.value!=''){
						if(!phoneOnly(form.txtTELEF,'Se permiten s�lo numeros telef�nicos en el campo TELEFONO.')){
							return false;
						};
					};

					if(form.txtEMAIL.value!=''){
						if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
							return false;
						};
					};
					
					if(form.FechaRetiro.value!=''){
						if(!chkVacio(form.FechaRetiro,'Ingresar Fecha de Retiro.')){
							return false;
						};
					};

					
					
					
					return true;
				}			
				

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>
		<?php }?>
	<?php }?>
	
<?
if ($_FRMMODOH == "ingresar"){ ?>
   <script language="javascript">
        function valida2(form){
					if(!chkVacio(form.rut_hermano,'Ingresar RUT.')){
						return false;
					};

					if(!nroOnly(form.rut_hermano,'Se permiten s�lo numeros en el RUT.')){
						return false;
					};

					if(!chkVacio(form.dig_rut,'Ingresar d�gito verificador del RUT.')){
						return false;
					};

					if(!chkCod(form.rut_hermano,form.dig_rut,'RUT invalido.')){
						return false;
					};
					
					if(!chkVacio(form.nombre_hermano,'Ingrese NOMBRE.')){
						return false;
					};

					

					if(!chkVacio(form.ape_pat,'Ingresar APELLIDO PATERNO.')){
						return false;
					};

					

					if(!chkVacio(form.ape_mat,'Ingresar APELLIDO MATERNO.')){
						return false;
					};

					
					
					if(!chkVacio(form.fecha_nac,'Ingresar FECHA NACIMIENTO.')){
						return false;
					};

					if(!chkFecha(form.fecha_nac,'FECHA NACIMIENTO invalida.')){
						return false;
					};				
					
					return true;
				}
    </script>				
  <? } ?>	
  
<? if ($_FRMMODOH == "modificar"){ ?>
  <script language="javascript">
        function valida2(form){
		           		            
					if(!chkVacio(form.fecha_nac,'Ingresar FECHA NACIMIENTO.')){
						return false;
					};

					if(!chkFecha(form.fecha_nac,'FECHA NACIMIENTO invalida.')){
						return false;
					};
									
					if(!chkVacio(form.nombre_hermano,'Ingrese NOMBRE.')){
						return false;
					};

				

					if(!chkVacio(form.ape_pat,'Ingresar APELLIDO PATERNO.')){
						return false;
					};

				

					if(!chkVacio(form.ape_mat,'Ingresar APELLIDO MATERNO.')){
						return false;
					};

/*					if(!alfaOnly(form.ape_mat,'Se permiten s�lo caracteres alfanum�ricos en el campo APELLIDO MATERNO.')){
						return false;
					};								
*/					
					
					return true;
				}
    </script> 
<? } ?>
	
<script language="javascript">
<!--

<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla).style.display;
	document.getElementById('personal').style.display='none';
	document.getElementById('familiar').style.display='none';
	document.getElementById('academico').style.display='none';
	document.getElementById('conducta').style.display='none';
	document.getElementById('becas').style.display='none';
	document.getElementById('grupos').style.display='none';
	document.getElementById('entrevista').style.display='none';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	document.getElementById('pesta6').className='span_normal';
	document.getElementById('pesta7').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
	
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
	

function fechas(caja)
{ 
  

   if (caja)
   {  
      borrar = caja;
       
      if ((caja.substr(2,1) == "-") && (caja.substr(5,1) == "-"))
      {      
         for (i=0; i<10; i++)
	     {	
            if (((caja.substr(i,1)<"0") || (caja.substr($i,1)== " ") || (caja.substr(i,1)>"9")) && (i != 2) && (i != 5))
			{
               borrar = '';
               break;  
			}  
         }
	     if (borrar)
	     { 
	        a = caja.substr(6,4);
		    m = caja.substr(3,2);
		    d = caja.substr(0,2);
		    if((a < 1900) || (a > 2050) || (m < 1) || (m > 12) || (d < 1) || (d > 31))
		       borrar = '';
		    else
		    {
		       if((a%4 != 0) && (m == 2) && (d > 28))	   
		          borrar = ''; // A�o no viciesto y es febrero y el dia es mayor a 28
			   else	
			   {
		          if ((((m == 4) || (m == 6) || (m == 9) || (m==11)) && (d>30)) || ((m==2) && (d>29)))
			         borrar = '';	      				  	 
			   }  // else
		    } // fin else
         } // if (error)
      } // if ((caja.substr(2,1) == \"/\") && (caja.substr(5,1) == \"/\"))			    			
	  else
	     borrar = '';
		 
	  if (borrar == '')
	     alert('Fecha erronea');
  
   
   }  // if (caja)   
   
    
} // FUNCION
//-->
</script>


<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<? if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('personal','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('familiar','pesta2'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('becas','pesta5'); <?
   }
   if ($pesta == 6){ ?>
      muestra_tabla('grupos','pesta6'); <?
   }
   if ($pesta == 7){ ?>
      muestra_tabla('entrevista','pesta7'); <?
   }
   if ($pesta == 4){ ?>
      muestra_tabla('conducta','pesta4'); <?
   }
   if ($pesta == 3){ ?>
      muestra_tabla('academico','pesta3'); <?
   } ?>	    MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg') 
<? if ($r == "si"){ ?>;MM_openBrWindow('v_respaldo.php','','width=250,height=200')<? }?>">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
        </tr>
		<tr align="left" valign="top"> 
			<td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> <?
					  $menu_lateral = '3_1';   include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top">
						  <table width="100%" border="0" cellpadding="0" cellspacing="0">
							  <tr> 
								<td align="left" valign="top">&nbsp;</td>
							  </tr>
							  <tr> 
								<td height="395" align="left" valign="top"> 
								  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
									<tr> 
									  <td height="390" valign="top">
									  
								  <!--inicio codigo nuevo pagina con fallas de tablas-->
								  
								 
								 
								
				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width="100%">
						
						<TR valign="top">
							<TD width="117" align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>A�O ESCOLAR</strong>								</FONT>							</TD>
							<TD width="1%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD width="51%">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result){
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
													$situacion = $fila1['situacion']; 
												}
											}
										?>
									</strong>								</FONT>							</TD>
							<td width="33%" rowspan="2"><table align="right">
							<?
							$foto = trim($fila['nom_foto']);
							?>
							
							  <tr><td><img src="../../../../../infousuario/images/<?=trim($alumno)  ?>" width="80" height="90"> </td></tr>
							  </table></td>
						</TR>
						<TR>
							<TD align=left valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>CURSO</strong>								</FONT>							</TD>
							<TD valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD valign="top">
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
										   
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".trim($curso).")) and curso.id_ano = '$ano'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (106)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													
													if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														echo "SALA CUNA"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MENOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MAYOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICI�N 1er NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICI�N 2do NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else{
														echo $fila1['grado_curso']."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}

													
													//echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>								</FONT>							</TD>
							</TR>
					</TABLE>					
									<?	if($_PERFIL==19 and $_INSTIT!=516 and  $_INSTIT!=12086 and $_INSTIT!=14912 and $_INSTIT!=9276 and $_INSTIT!=12838 and $_INSTIT!=770 and $_INSTIT!=769 and $_INSTIT!=26080 ){	?>
								 <table border="0" cellspacing="0" cellpadding="0" align="left">
                    			  <tr> 
                                   <td>&nbsp;</td>
                     			   <td width="75"><a href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal" ></span></a></td>
                                   <td>&nbsp;</td>
                                   <td width="75"><a href="javascript:;" onClick="muestra_tabla('familiar','pesta2');"><span id="pesta2" class="span_normal" ></span></a></td>
                                   <td>&nbsp;</td>
                                   <td width="75"><a href="javascript:;" onClick="muestra_tabla('academico','pesta3');"><span id="pesta3" class="span_normal" ></span></a></td>
                                   <td>&nbsp;</td>	
								   <td width="75"><a href="javascript:;" onClick="muestra_tabla('conducta','pesta4');"><span id="pesta4" class="span_normal" ></span></a></td>
                                   <td width="21">&nbsp;</td>
								   <td width="75"><a href="javascript:;" onClick="muestra_tabla('becas','pesta5');"><span id="pesta5" class="span_normal" ></span></a></td>
                                   <td width="21">&nbsp;</td>
								   <td width="75"><a href="javascript:;" onClick="muestra_tabla('grupos','pesta6');"><span id="pesta6" class="span_normal" ></span></a></td>
								   <td width="21">&nbsp;</td>
								   <td width="75"><a href="javascript:;" onClick="muestra_tabla('entrevista','pesta7');"><span id="pesta7" class="span_normal" ></span></a></td>
								   <td width="21">&nbsp;</td>
                                   </tr>
                                 </table>																																																			
									<?		}else{			?>									
								 <table border="0" cellspacing="0" cellpadding="0" align="left">
                    			  <tr> 
                                   <td class="bot1">&nbsp;</td>
                     			   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal" >Personal</span></a></td>
                                   <td class="bot3">&nbsp;</td>
                                   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('familiar','pesta2');"><span id="pesta2" class="span_normal" >Familiar</span></a></td>
                                   <td class="bot3">&nbsp;</td>
                                   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('academico','pesta3');"><span id="pesta3" class="span_normal" >Acad�mico</span></a></td>
                                   <td class="bot3">&nbsp;</td>	
								   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('conducta','pesta4');"><span id="pesta4" class="span_normal" >Conducta</span></a></td>
                                   <td width="21" class="bot3">&nbsp;</td>
								   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('becas','pesta5');"><span id="pesta5" class="span_normal" >Becas</span></a></td>
                                   <td width="21" class="bot3">&nbsp;</td>
								   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('grupos','pesta6');"><span id="pesta6" class="span_normal" >Grupos</span></a></td>
								   <td width="21" class="bot3">&nbsp;</td>
								   <td width="75" class="bot2"><a href="javascript:;" onClick="muestra_tabla('entrevista','pesta7');"><span id="pesta7" class="span_normal" >Entrevista</span></a></td>
								   <td width="21" class="bot4">&nbsp;</td>
                                   </tr>
                                 </table>
								 	<?			}			?>
								  <br>
								   
							
								  
								  
								  
								  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr id="personal">
                                      <td valign="top">
									  
								      <FORM method=post name="frm_aux" action="procesoAlumno.php3?pesta=1" onSubmit="return valida(this.form);">					  
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					   <td colspan="3" class="tableindex">Datos personales</td>
					 </tr>
				</table>
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
                    <tr>
                        <td colspan="3">
	
	                       <TABLE width="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
									<TR>
										<TD colspan=4 class="cuadro02">														RUT										</TD>
									</TR>
									<TR>
										<TD width="20" class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
											<input type="text" name="txtRUT" size="8" maxlength="8" onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rut_alumno']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['rut_alumno']);
												};
											?>										</TD>
										<TD class="cuadro01" width="3">&nbsp;-</TD>
										<TD class="cuadro01" width="250">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtDIGRUT" size="1" maxlength="1">
												<?php };?>
												<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['dig_rut']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['dig_rut']);
												};
											?>
											<?
											if (($frmModo == "modificar") and ($_PERFIL == 0 or $_PERFIL == 14)){ 
											   $ract = $fila['rut_alumno'];
											   $dact = $fila['dig_rut'];
											  
                                               $string = base64_encode($fila['rut_alumno']);
										


											   ?>											&nbsp; &nbsp;<input name="mrut" type="button" class="botonXX" onClick="MM_openBrWindow('vmrut.php?ract=<?=$string ?>&amp;dact=<?=$dact ?>','','toolbar=no,location=no,resizable=yes,width=300,height=250')" value="MODIFICAR RUT">
											<? } ?>										</TD>
									    <TD align="right">
										<!-- botones para modificar, grabar   -->									
										
										
										    <?php /*---	echo ("Perfil:".$_PERFIL); VERIFICAR VARIABLE DE SESSION _PERFIL ---*/
								if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
							<?php if($frmModo=="ingresar"){ ?>
							<input class="botonXX"  type="submit" value="GUARDAR"   name=btnGuardar2 onClick="return valida(this.form);" >
							&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAlumnos.php3">&nbsp;
							<?php }; ?>
									<?php if($frmModo=="mostrar"){ ?>
										<?php if($_PERFIL!=17){?>
											<?php if(($_PERFIL!=2)&&($_PERFIL!=3)&&($_PERFIL!=4)&&($_PERFIL!=5)&&($_PERFIL!=6)&&
													($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&
													($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=26)
													){ ?>
												<?php if($situacion != 0){ // para a�os cerrados?>
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&caso=3">&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="FOTO" name=btnFoto  onClick="window.open('frmFoto.php3?rut=<?php echo trim($alumno)?>&swfoto=1','','width=600,height=180')">&nbsp;
										
												<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaAlumno.php3?caso=9;"-->
												<?php }	?>
										   <?php } ?>
											      
										   <? }else{ ?>
										   
										           <? 
												   if ($_PERFIL==17 and $_INSTIT==1756){ ?>
											        <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&caso=3">&nbsp;
												 <? } ?>						   
										    						   
										   
										<?php }?>&nbsp;
										<?php };?>
									<?php if($frmModo=="modificar"){ ?>
										<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&caso=1">&nbsp;
									<?php };?>
								<?php };?>
										
										
										
										<!-- fin botones -->										</TD>
									</TR>
	  </TABLE>	</td>
  </tr>
  <tr>
    <td width="33%" class="cuadro02">Nombre</td>
    <td width="34%" class="cuadro02">A. Paterno </td>
    <td width="33%" class="cuadro02">A. Materno </td>
  </tr>
  <tr>
    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
											<input type="text" name=txtNOMBRE2 size=25 maxlength=50 />
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_alu']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim($fila['nombre_alu'])?>">
	<?php };?>									  </td>
    <td class="cuadro01"><?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['ape_pat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim($fila['ape_pat'])?>">
	<?php };?>										</td>
    <td class="cuadro01">
	<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['ape_mat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim($fila['ape_mat'])?>">
											<?php };?>										</td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha Nacimiento </td>
    <td class="cuadro02">Sexo</td>
    <td class="cuadro02">Nacionalidad</td>
  </tr>
  <tr>
    <td class="cuadro01">
	<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtNAC" size="10" maxlength="10">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_nac']);
												};
											?>
									<?php if($frmModo=="modificar"){ 
/*vel*/											   ?>
									<!--input type='text' name=txtNAC size="10" maxlength="10" onChange='fechas(this.value); this.value=borrar'  value="<?php echo trim(impF($fila['fecha_nac'])) ?>"-->
									<input name="txtNAC" type="widget" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%d-%m-%Y" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<? echo trim(impF($fila['fecha_nac'])) ?>	"/>		
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>												</FONT>
											<?php };?>										</td>
    <td class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbSEXO" >
													<option value=0 selected></option>
													<option value=2>Masculino</option>
													<option value=1>Femenino</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbSEXO">
													<option value=0></option>
											<option value=2 <?php echo ($fila['sexo'])==2?"selected":"" ?>>Masculino</option>
											<option value=1 <?php echo ($fila['sexo'])==1?"selected":"" ?>>Femenino</option>
												</Select>
											<?php };?></td>
    <td class="cuadro01">
	<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbNac">
													<option value=0></option>
													<option value=2>Chilena</option>
													<option value=1>Extranjera</option>
												</Select>
											<?php }; ?>
											<?php if ($frmModo=="mostrar"){
														switch ($fila['nacionalidad']){
															case 0:
																imp('INDETERMINADO');
																break;
															case 1:
																imp('Extranjera');
																break;
															case 2:
																imp('Chilena');
																break;
														};
												}; ?>
											<?php if ($frmModo=="modificar"){ ?>
												<Select name="cmbNac">
													<option value=0></option>
													<option value=2 <?php echo($fila['nacionalidad'])==2?"selected":"" ?>>Chilena</option>
													<option value=1 <?php echo($fila['nacionalidad'])==1?"selected":"" ?>>Extranjera</option>
												</Select>
											<?php }; ?>	</td>
  </tr>
  
  
  <tr>
    <td class="cuadro02">Alumna Embarazada </td>
    <td colspan="2" class="cuadro02">Alumno(a) Ind�gena </td>
    </tr>
  
  <tr>
    <td class="cuadro01">&nbsp;
	<? 
		//ALUMNA EMBARAZADA
	if($frmModo=="ingresar"){ ?>
              <input type="checkbox" name=AE size=83 maxlength=50> 

    <? }else{
	 
			$qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='$alumno' AND RDB='$institucion' AND ID_ANO='$ano'";                          
			$resultB =@pg_Exec($conn,$qryB);
			if (!$resultB) {
				 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
			}else{
				 if (pg_numrows($resultB)!=0){
					 $filaB = @pg_fetch_array($resultB,0);	
					 if (!$filaB){
						 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						 exit();
					 }
				 }
			}
			if($frmModo=="mostrar"){ 
				imp( ($filaB['bool_ae']==0)?"NO":"SI");
				if ($filaB['bool_ae']==1) { $estado['AE']="enabled";}
			}
			if($frmModo=="modificar"){ ?>
				  <input type="checkbox" name=AE size=83 maxlength=50 value=1 <?php echo ($filaB['bool_ae']==1)?"checked":"" ?>> 
			<?php }
		}?>
			
		</td>
		
		
		<td colspan="2" class="cuadro01">
			<? 
			//ALUMNO INDIGENA
			if($frmModo=="ingresar"){ ?>
					  <input type="checkbox" name=AOI size=83 maxlength=50> 
		
			<? }else{
			 
					if($frmModo=="mostrar"){ 
						imp( ($filaB['bool_aoi']==0)?"NO":"SI");
						if ($filaB['bool_aoi']==1) { $estado['AOI']="enabled";}
					}
					if($frmModo=="modificar"){ ?>
						  <input type="checkbox" name=AOI size=83 maxlength=50 value=1 <?php echo ($filaB['bool_aoi']==1)?"checked":"" ?>> 
					<?php }
				}?>
		</td>
    </tr>
  </table>
  <table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td colspan="3" class="tableindex">Direcci&oacute;n</td>
  </tr>
  </table>
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#666666">
  <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Nro.</td>
    <td class="cuadro02">Block</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp; 
	<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtCALLE" size="30" maxlength="50">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['calle']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtCALLE" size="30" maxlength="50" value="<?php echo trim($fila['calle'])?>">
																<?php };?>	</td>
    <td class="cuadro01">&nbsp; 
	<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtNRO" size="10" maxlength="5">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nro']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtNRO" size="10" maxlength="5" value=<?php echo $fila['nro']?> >
																<?php };?>	</td>
    <td class="cuadro01">&nbsp; <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtBLO" size="12" maxlength="10">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtBLO" size="12" maxlength="10" value="<?php echo trim($fila['block']); ?>">
																<?php };?>															</td>
  </tr>
  <tr>
    <td class="cuadro02">Departamento</td>
    <td class="cuadro02">Villa / Poblaci&oacute;n </td>
    <td class="cuadro02"><!--Comuna. -->&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp; <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtDEP" size="12" maxlength="10">
															  <?php };?>
															  <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
															  <?php if($frmModo=="modificar"){ ?>
															  <input type="text" name="txtDEP" size="12" maxlength="10" value="<?php echo trim($fila['depto']); ?>" />
															  <?php };?>															</td>
    <td class="cuadro01">&nbsp;
	<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtVIL" size="30" maxlength="50">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtVIL" size="30" maxlength="50" value="<?php echo trim($fila['villa'])?>">
																<?php };?>	</td>
    <td class="cuadro01">&nbsp;
	
	
     <?  
	  //----------------------combos---------------------------------------//
	if($cod_reg==0 and $cod_pro==0){
		$sql="SELECT region,ciudad,comuna FROM institucion WHERE rdb=8933 " ;
		$res=@pg_exec($conn,$sql);
	 	$fila_2=pg_fetch_array($res);
		$cod_reg = trim($fila_2['region']);
     	$cod_pro = trim($fila_2['ciudad']);
     	$cod_com = trim($fila_2['comuna']);
	 }else{
	 	$cod_reg = trim($fila['region']);
     	$cod_pro = trim($fila['ciudad']);
     	$cod_com = trim($fila['comuna']);
	 }
	 ?>
	 <INPUT type="hidden" name="txtREG" size="20" value="<?=$cod_reg ?>">
	 <INPUT type="hidden" name="txtCIU" size="20" value="<?=$cod_pro ?>">
	 <input type="hidden" name="txtCOM" size="20" value="<?=$cod_com ?>">
	   										
	 </td>
  </tr>
  
  <tr>
    <td class="cuadro02">Tel&eacute;fono</td>
    <td colspan="2" class="cuadro02">E-mail </td>
    </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	<?php if($frmModo=="ingresar"){ ?>
                      <input type="text" name=txtTELEF size=20 maxlength=30> 
                      <?php };?>
                      <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['telefono']);
															};
														?>
                      <?php if($frmModo=="modificar"){ ?>
                      <input type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo trim($fila['telefono'])?>"> 
                      <?php };?></td>
    <td colspan="2" class="cuadro01">&nbsp;
	<?php if($frmModo=="ingresar"){ ?>
                      <input type="text" name=txtEMAIL size=30 maxlength=100> 
                      <?php };?>
                      <?php 
															if($frmModo=="mostrar"){ 
																imp($fila['email']);
															};
														?>
                      <?php if($frmModo=="modificar"){ ?>
                      <input type="text" name=txtEMAIL size=30 maxlength=100 value="<?php echo trim($fila['email']); ?>"> 
                      <?php };?>	 </td>
    </tr>
  
  </FORM>	
  
  
  <!-- nuevo c�digo  para cambiar de region  -->
  <tr>
    <td class="cuadro02">Regi�n</td>
    <td class="cuadro02">Provincia </td>
    <td class="cuadro02">Comuna</td>
  </tr>
  
  <tr>
    <td class="cuadro01">&nbsp;
	<!-- sacar nombre de region -->
	<?php if($frmModo=="ingresar"){ ?>
				<FORM method="post" name="f1" onSubmit="return false;">
				<SELECT id="m1" name="m1" onChange="relate(this.form,0,this.selectedIndex);document.frm_aux.txtREG.value=document.f1.m1.value;">
				<?php
		        //SELECCIONAR TODAS LAS REGIONES
		        $qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		        $resultREG	=@pg_Exec($connRPC,$qryREG);
		        for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			       $filaREG = @pg_fetch_array($resultREG,$i);
			       echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		        }//for resultREG
	            ?>
                </SELECT>
                </FORM>
    <?php };?>
    
	
	<?php if($frmModo=="mostrar"){ 
			  $qryREG		="SELECT * FROM REGION WHERE COD_REG=".$cod_reg;
			  $resultREG	=@pg_Exec($conn,$qryREG);
			  $filaREG	= @pg_fetch_array($resultREG,0);
			  imp($filaREG['nom_reg']);
		  };?>
		  
	<?php if($frmModo=="modificar"){?>
              <FORM method="post" name="f1" onSubmit="return false;">
              <SELECT id="m1" name="m1" onChange="relate(this.form,0,this.selectedIndex);document.frm_aux.txtREG.value=document.f1.m1.value;">
              <?php
		      //SELECCIONAR TODAS LAS REGIONES
			  $qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		      $resultREG	=@pg_Exec($connRPC,$qryREG);
		       
			 for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			  		 $filaREG = @pg_fetch_array($resultREG,$i);   			  
			      if($filaREG['cod_reg']==$cod_reg)
				      echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				  else
					  echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
					  
		      }//for resultREG
	          ?>
			  </SELECT>
              </FORM>
    <?php };?>   
	<!-- fin codigo de region -->
	
	
	</td>
    <td class="cuadro01">&nbsp;
	<!-- codigo de la provincia -->
	<?php if($frmModo=="ingresar"){ ?>
              <FORM method="post" name="f2" onSubmit="return false;">
              <SELECT id="m2" name="m2" onChange="relate2(this.form,0,this.selectedIndex,0);document.frm_aux.txtCIU.value=document.f2.m2.value;">
              <?php
		      //SELECCIONAR TODAS LAS PROVINCIAS
		      $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		      $resultPRO	=@pg_Exec($connRPC,$qryPRO);
		      for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			      $filaPRO = @pg_fetch_array($resultPRO,$i);
			      echo "<OPTION value=\"".trim($filaPRO['cod_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		      }//for resultPRO
	          ?>
              </SELECT>
              </FORM>
     <?php };?>
     
	 
	 <?php if($frmModo=="mostrar"){ 
			   $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$cod_reg." AND COR_PRO=".$cod_pro;
			   $resultPRO	=@pg_Exec($conn,$qryPRO);
			   $filaPRO	= @pg_fetch_array($resultPRO,0);
		       imp($filaPRO['nom_pro']);
		   };?>
		   
		   
	  <?php if($frmModo=="modificar"){ ?>
	             <FORM method="post" name="f2" onSubmit="return false;">
                 <SELECT id="m2" name="m2" onChange="relate2(this.form,0,this.selectedIndex,0);document.frm_aux.txtCIU.value=document.f2.m2.value;">
                 <?php
		         //SELECCIONAR TODAS LAS PROVINCIAS
		        $qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$cod_reg." ORDER BY NOM_PRO ASC";
		        $resultPRO	=@pg_Exec($connRPC,$qryPRO);
				 
		         for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			         $filaPRO = @pg_fetch_array($resultPRO,$i);
					 if($filaPRO['cor_pro']==$cod_pro)
				         echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
				     else
					     echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
							 
		          }//for resultPRO
	              ?>
                  </SELECT>
				  </FORM>
      <?php };?>  
	
	<!-- fin codigo de provincia -->
	</td>
    <td class="cuadro01">&nbsp;
	<!-- c�digo para determinar la comuna  -->
	<?php if($frmModo=="ingresar"){ ?>
             <FORM  method="post" name="f3" onSubmit="return false;">
             <select id="select" name=select onChange="document.frm_aux.txtCOM.value=document.f3.m3.value;">
             <?php
		     //SELECCIONAR TODAS LAS COMUNAS
		     $qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		     $resultCOM	=@pg_Exec($connRPC,$qryCOM);
		     for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			     $filaCOM = @pg_fetch_array($resultCOM,$i);
			     echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		     }//for resultPRO
	         ?>
             </select>
             </FORM>
   <?php };?>
      
	  
	  
   <?php if($frmModo=="mostrar"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$cod_reg." AND COR_PRO=".$cod_pro." AND COR_COM=".$cod_com;
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
	     };?>
		 
		 
   <?php if($frmModo=="modificar"){ ?>
              <FORM method="post" name="f3" onSubmit="return false;">
              <SELECT id="m3" name="m3" onChange="document.frm_aux.txtCOM.value=document.f3.m3.value;">
              <?php
		      //SELECCIONAR TODAS LAS COMUNAS
		      $qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$cod_reg." AND COR_PRO=".$cod_pro." ORDER BY NOM_COM ASC";
		      $resultCOM	=@pg_Exec($connRPC,$qryCOM);
			 
			 for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			      $filaCOM = @pg_fetch_array($resultCOM,$i);
			      if($filaCOM['cor_com']==$cod_com)
				      echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected>".trim($filaCOM['nom_com'])." </OPTION>\n";
				  else
					  echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
					 
		      }//for resultPRO
	          ?>
              </SELECT>
              </FORM>
 <?php };?>
	
	<!-- fin codigo de comuna -->
	</td>
  </tr> 
  <!-- fin nuevo codigo para cambiar de region -->    
</table>




 </td>
   </tr>
   <tr id="familiar">
 <td>				  
									  
<?
// AQU� DEBO OBTENER LA INFORMACI�N DE LA TABLA APODERADO DEL ALUMNO //
$q1 = "select * from tiene2 where tiene2.rut_alumno = '".trim($_ALUMNO)."'";
$r1 = pg_Exec($conn,$q1);
if (!$r1){
    echo "Error, no hay apoderado para este alumno";
	exit();
}else{
    $n1 = pg_numrows($r1);
	if ($n1 == 0){
		
	}
	$f1 = pg_fetch_array($r1);
	$rut_apo = $f1['rut_apo'];
	
}	

?>
	 	
<FORM method=post name="frm" action="apoderado/procesoApoderado.php3?apoderado=<?=$rut_apo ?>">							  
<table width="100%" border="0" cellspacing="0" cellpadding="5">
 <tr>
   <td colspan="3" class="tableindex">Antecedentes Familiares </td>
 </tr>  
   <tr>
    <td colspan="3">
	    <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
		   <tr>
		   <td>
		 <? if ($frmModo != "ingresar"){ ?>		   
		   
		   <select name="familiar" onChange="document.location.href=this.options[this.selectedIndex].value;">
		   <?
		   if ($frmModo == "mostrar"){
		      ?>
		      <option value="apoderado/seteaApoderado.php3?apoderado=0&caso=1">Seleccione familiar</option>
		 <? }
		   if ($frmModo == "ingresar"){
		      ?>
			   <option value="apoderado/seteaApoderado.php3?apoderado=0&caso=3">Seleccione familiar</option>
		 <? } 
		 
		 	   
		   // Aqu� llenamos el combobox para que seleccione un apoderado si tiene mas de uno. 
		   $i = 0;
		   while ($i < $n1){
		      $f1 = pg_fetch_array($r1,$i);
			  $rut_apo = $f1['rut_apo'];
			  // ac� tomo el nombre del apoderado
			  $q2 = "select * from apoderado where rut_apo = '".trim($rut_apo)."'";
			  $r2 = pg_Exec($conn,$q2);
			  $n2 = pg_numrows($r2);
			  $f2 = pg_fetch_array($r2);		  
			  $rut_apo     = $f2['rut_apo'];
			  $nombre_apo  = $f2['nombre_apo'];
			  $ape_pat_apo = $f2['ape_pat'];
			  $ape_mat_apo = $f2['ape_mat'];
			  $dig_apo = $f2['dig_rut'];
			  $calle_apo = $f2['calle'];
			  $nro_apo = $f2['nro'];
			  $depto_apo = $f2['depto'];
			  $block_apo = $f2['block'];
			  $villa_apo = $f2['villa'];
			  $region_apo = $f2['region'];
			  $ciudad_apo = $f2['ciudad'];
			  $comuna_apo = $f2['comuna'];
			  $telefono_apo = $f2['telefono'];
			  $relacion_apo = $f2['relacion'];
			  $email_apo = $f2['email'];
			  $id_usuario_apo = $f2['id_usuario'];
			  $foto_apo = $f2['foto'];
			  $celular_apo = $f2['celular'];
			  $nivel_edu_apo = $f2['nivel_edu'];
			  $profesion_apo = $f2['profesion'];
			  $lugar_trabajo_apo = $f2['lugar_trabajo'];
			  $cargo_apo = $f2['cargo_apo'];
			  $nom_foto_apo = $f2['nom_foto'];
			  $fecha_nac_apo = $f2['fecha_nac'];
			  $sexo_apo     = $f2['sexo'];
			  $nacionalidad = $f2['nacionalidad_apo'];
			  $situacion_familiar = $f2['situacion_familiar'];	
			  $ocupacion_actual = $f2['ocupacion'];	
			  $nivelsocial = $f2['nivel_social'];
			  			  		  
			  if (($familiar == $rut_apo) or ($rut_apo == $_APODERADO)){ 
			      if ($frmModo == "mostrar"){ ?>		  
		              <option value="apoderado/seteaApoderado.php3?apoderado=<?=$rut_apo ?>&caso=1" selected="selected"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></option>
				 <? } 
				  if ($frmModo == "modificar"){ ?>
				      <option value="apoderado/seteaApoderado.php3?apoderado=<?=$rut_apo ?>&caso=3" selected="selected"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></option>
				 <? } ?>			  	    		  
				  	  
		   <? }else{ 
		          if ($frmModo == "mostrar"){ ?> 
		              <option value="apoderado/seteaApoderado.php3?apoderado=<?=$rut_apo ?>&caso=1"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></option>
			     <? } 
				  if ($frmModo == "modificar"){ ?>		  
		   	   	      <option value="apoderado/seteaApoderado.php3?apoderado=<?=$rut_apo ?>&caso=3"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></option>
				 <? } ?>			  
				  	  
		   <? } ?>		  
			  <?
			  $i++;
		   }  ?>	  
			  </select>
			  
			 <? } ?>			  </td>
			  <td align="right">	
			  	 <?
				 if ($frmModo != "ingresar"){ ?>	  
			        <?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1) ||($_PERFIL==27)||($_PERFIL==25)){ ?>
						<INPUT class="botonXX"  TYPE="button" value="AGREGAR FAMILIAR" onClick=document.location="apoderado/seteaApoderado.php3?caso=2">
					<?php }else{ 
					         if ($_PERFIL==17){ 
						     $sql_profjefe_1 = "select rut_emp from supervisa where rut_emp = '$_NOMBREUSUARIO'"; // Profesor Jefe
		                     $res_profjefe_1 = pg_Exec($conn,$sql_profjefe_1);
		                     $num_profjefe_1 = pg_numrows($res_profjefe_1);
							 ?> <? if ($frmModo != "modificar"){?>
							      <INPUT class="botonXX"  TYPE="button" value="AGREGAR FAMILIAR" onClick=document.location="apoderado/seteaApoderado.php3?caso=2">			
								<? if(pg_numrows($res_profjefe_1)!=0){?> 
								
								   <INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="apoderado/seteaApoderado.php3?caso=9&apoderado=<?=trim($rut_apo); ?>">	
								  <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="apoderado/seteaApoderado.php3?apoderado=<?php echo trim($rut_apo)?>&caso=3">&nbsp;			 
						    <? } 
							    }
							     }?>
					
					   <? } ?>
					
					
					
					
						
			  <? } ?>			  </td>
		   </tr>
		   <TR>
			    <TD colspan=2>
				   <?
				   if ($frmModo == "ingresar"){
				      $n1 = 1;
				   }				
				   
			  $q2 = "select * from apoderado where rut_apo = '".trim($_APODERADO)."'";
			  $r2 = @pg_Exec($conn,$q2);
			  $n2 = @pg_numrows($r2);
			  $f2 = @pg_fetch_array($r2);		  
			  $rut_apo     = $f2['rut_apo'];
			  $nombre_apo  = $f2['nombre_apo'];
			  $ape_pat_apo = $f2['ape_pat'];
			  $ape_mat_apo = $f2['ape_mat'];
			  $dig_apo = $f2['dig_rut'];
			  $calle_apo = $f2['calle'];
			  $nro_apo = $f2['nro'];
			  $depto_apo = $f2['depto'];
			  $block_apo = $f2['block'];
			  $villa_apo = $f2['villa'];
			  $region_apo = $f2['region'];
			  $ciudad_apo = $f2['ciudad'];
			  $comuna_apo = $f2['comuna'];
			  $telefono_apo = $f2['telefono'];
			  $relacion_apo = $f2['relacion'];
			  $email_apo = $f2['email'];
			  $id_usuario_apo = $f2['id_usuario'];
			  $foto_apo = $f2['foto'];
			  $celular_apo = $f2['celular'];
			  $nivel_edu_apo = $f2['nivel_edu'];
			  $profesion_apo = $f2['profesion'];
			  $lugar_trabajo_apo = $f2['lugar_trabajo'];
			  $cargo_apo = $f2['cargo_apo'];
			  $nom_foto_apo = $f2['nom_foto'];
			  $fecha_nac_apo = $f2['fecha_nac'];
			  $sexo_apo     = $f2['sexo'];
			  $nacionalidad = $f2['nacionalidad_apo'];
			  $nivelsocial = $f2['nivel_social'];
			  $situacion_familiar = $f2['situacion_familiar'];	
			  $ocupacion_actual = $f2['ocupacion'];	
			       if ($frmModo == "ingresar"){
				      $rut_apo = 1;
				   }		     
						   				   			      
				   if (($n1 > 0 or $familiar != 0) and $rut_apo > 0){ ?>
			     		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                              <td><FONT face="arial, geneva, helvetica" size=1 color=#000000>
							  <STRONG>RUT</STRONG>											</FONT></td>
                              <td><div align="right">											            			
							  <?php if($frmModo=="ingresar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="apoderado/seteaApoderado.php3?caso=1">&nbsp;
							<?php };?>
							<?php if($frmModo=="mostrar"){ ?>
							      
								<?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==27)||($_PERFIL==1)){ ?>								   
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="apoderado/seteaApoderado.php3?apoderado=<?php echo trim($rut_apo)?>&caso=3">&nbsp;
									<? if ($_PERFIL!=27){?><INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="apoderado/seteaApoderado.php3?caso=9&apoderado=<?=trim($rut_apo); ?>">&nbsp;
								<?php }}?>
							<!--	  <INPUT class="botonXX"  TYPE="button" value="ALUMNO" onClick=document.location="../alumno.php3">&nbsp; -->
							<?php };?>
							<?php if($frmModo=="modificar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida(this.form);">&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="apoderado/seteaApoderado.php3?apoderado=<?php echo trim($rut_apo)?>&caso=1">&nbsp;
							<?php };?>

								</div></td>
                                   </tr>
                                    </table></TD>
									</TR>
									<TR>
										<TD valign=top class="cuadro01">
										   <table><tr><td>
										   
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRUT size=8 maxlength=8 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar" || $frmModo=="reporte"){ 
													imp($rut_apo);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($rut_apo);
												};
											?></td>
											<td valign="middle">										
											&nbsp;-&nbsp; </td>
											<td>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRUT size=1 maxlength=1 >
										    <?php };?>
										    <?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($dig_apo);
												};
											?>
										    <?php 
												if($frmModo=="modificar"){ 
													imp($dig_apo);
												};
											?></td></tr></table>	
											
											
											
											</TD>
										<TD align=right width=90% class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
                  <TR align=center> 
                    <TD width="136" align="left"> <INPUT TYPE="checkbox" NAME="chkRESP" value=1>
                      <span class="cuadro02">APODERADO</span> </TD>
                    <TD width="164" align="left"><input type="checkbox" name="chkSOS" value="1">
					  <span class="cuadro02">SOSTENEDOR</span> </TD>
                  </TR>
                </TABLE>
						<?php };?>
						<?php
											?>
											<?php 
												if($frmModo=="modificar"){ 							

							$q3 = "select * from tiene2 where rut_apo = '$_APODERADO' and rut_alumno = '$_ALUMNO'";
							$r3 = pg_Exec($conn,$q3);
							if (!$r3){
							   echo "Error, no encontr� apoderado asignado";
							   exit();
							}else{
							   $f3 = pg_fetch_array($r3);   				
													
								if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
									if(($f3['responsable']==1) and ($f3['sostenedor']==0)){ 
										imp("APODERADO RESPONSABLE");
									};
									if(($f3['sostenedor']==1) and ($f3['responsable']==0)){
										imp("SOSTENEDOR");
									}
									if(($f3['sostenedor']==1) and ($f3['responsable']==1)){
								 		imp("APODERADO RESPONSABLE Y SOSTENEDOR");
									}
								};
							}	
?>
													
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
                  <TR align=center> 
                    <TD width="136" align="left"> <INPUT TYPE="checkbox" NAME="chkRESP" <?php if($f3['responsable']==1) echo "checked"?> value=1>
                      <span class="cuadro02">APODERADO</span> </TD>
                    <TD width="164" align="left"><input type="checkbox" name="chkSOS" <?php if($f3['sostenedor']==1) echo "checked"?> value=1>
					  <span class="cuadro02">SOSTENEDOR</span> </TD>
                  </TR>
                </TABLE>
											<? };?>										</TD>
									</TR>
								</TABLE>	</td>
  </tr>
  <tr>
    <td class="cuadro02">Nombres</td>
    <td class="cuadro02">Apellido Paterno </td>
    <td class="cuadro02">Apellido Materno</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	    <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($nombre_apo);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo imp($nombre_apo);?>">
											<?php };?>	</td>
    <td class="cuadro01">&nbsp;
	
	   <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($ape_pat_apo);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo imp($ape_pat_apo);?>">
											<?php };?></td>
    <td class="cuadro01">&nbsp;
	
	   <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($ape_mat_apo);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo imp($ape_mat_apo);?>">
											<?php };?> </td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha de Nacimiento </td>
    <td class="cuadro02">Sexo</td>
    <td class="cuadro02">Nacionalidad</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtNAC" size="10" maxlength="10">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
												    impF($f2['fecha_nac']);													
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name="txtNAC" size="10" maxlength="10" value="<?php echo impF($f2['fecha_nac'])?>" onChange='fechas(this.value); this.value=borrar'>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>												</FONT>
											<?php };?>										</td>
    <td class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbSEXO" >
													<option value=0 selected></option>
													<option value=2>Masculino</option>
													<option value=1>Femenino</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($f2['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbSEXO">
													<option value=0></option>
											<option value=2 <?php echo ($f2['sexo'])==2?"selected":"" ?>>Masculino</option>
											<option value=1 <?php echo ($f2['sexo'])==1?"selected":"" ?>>Femenino</option>
												</Select>
											<?php };?></td>
    <td class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbNac">
													<option value=0></option>
													<option value=2>Chilena</option>
													<option value=1>Extranjera</option>
												</Select>
											<?php }; ?>
											<?php if ($frmModo=="mostrar"){
														switch ($f2['nacionalidad']){
															case 0:
																imp('INDETERMINADO');
																break;
															case 1:
																imp('Extranjera');
																break;
															case 2:
																imp('Chilena');
																break;
														};
												}; ?>
											<?php if ($frmModo=="modificar"){ ?>
												<Select name="cmbNac">
													<option value=0></option>
													<option value=2 <?php echo($f2['nacionalidad'])==2?"selected":"" ?>>Chilena</option>
													<option value=1 <?php echo($f2['nacionalidad'])==1?"selected":"" ?>>Extranjera</option>
												</Select>
											<?php }; ?>	</td>
  </tr>
  <tr>
    <td colspan="3" class="tableindex">Direcci&oacute;n</td>
  </tr>
  <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Nro</td>
    <td class="cuadro02">Block</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ 
	   $sql_alum = "select calle, nro, depto, block, villa, comuna, telefono from alumno where rut_alumno = '$alumno'";
	   $res_alum = pg_Exec($conn,$sql_alum);
	   $fila_alum = pg_fetch_array($res_alum);?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?=imp($fila_alum['calle']);?>">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($calle_apo);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo imp($calle_apo);?>" >
											  <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	    <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value="<?=imp($fila_alum['nro']);?>">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($nro_apo);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value=<?php echo imp($nro_apo);?> >
											  <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?=imp($fila_alum['block']);?>">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($block_apo);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?php echo imp($block_apo);?>">
											  <?php };?>	</td>
  </tr>
  <tr>
    <td class="cuadro02">Dpto.</td>
    <td class="cuadro02">Villa / Poblaci&oacute;n </td>
    <td class="cuadro02">Comuna</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtDEP" size=12 maxlength=10 value="<?=imp($fila_alum['depto']);?>">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($depto_apo);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtDEP" size=12 maxlength=10 value="<?php echo imp($depto_apo);?>" >
											  <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name="txtVIL" size=34 maxlength=50 value="<?=imp($fila_alum['villa']);?>">
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($villa_apo);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name="txtVIL" size=34 maxlength=50 value="<?php echo imp($villa_apo);?>">
											  <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	
	
	
	<?php if($frmModo=="ingresar"){ ?>
	
	<SELECT class=saveHistory  name=m4 style="font-size:9px"> 
	     <?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			echo "<OPTION value=\"".trim($filaCOM['nom_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
<?php };?>



<?php 
if($frmModo=="mostrar"  || $frmModo=="reporte"){
     if ($_PERFIL==0){ 
          $qryCOM	= "SELECT * FROM COMUNA WHERE COD_REG=".$f2['region']." AND COR_PRO = ".$f2['ciudad']." AND COR_COM = ".$f2['comuna'];
	 }else{
	      $qryCOM	= "SELECT * FROM COMUNA WHERE COD_REG=".$f2['region']." AND COR_PRO = ".$f2['ciudad']." AND COR_COM = ".$f2['comuna'];
	 
	 }
	 
	 $resultCOM	=@pg_Exec($conn,$qryCOM);
	 $filaCOM	= @pg_fetch_array($resultCOM);
	 imp($filaCOM['nom_com']);
};
?>


<?php if($frmModo=="modificar"){ ?>         

	<SELECT class="saveHistory" id="m3" name="m3" style="font-size:9px" > 
	<?php
	   	//SELECCIONAR TODAS LAS COMUNAS
		
		$qryCOM	= "SELECT * FROM COMUNA WHERE COD_REG=".$f2['region']." AND COR_PRO = ".$f2['ciudad']." AND COR_COM = ".$f2['comuna'];
					 
		 $resultCOM	=@pg_Exec($conn,$qryCOM);
		 $filaCOM	= @pg_fetch_array($resultCOM);
		 $nombre_comuna = trim($filaCOM['nom_com']); ?>
		 <option value="<?=$nombre_comuna ?>" selected="selected"><?=imp($filaCOM['nom_com']);?></option>
<?		if(pg_numrows($resultCOM)!="0"){
			$qryCOM		="SELECT * FROM COMUNA ORDER BY NOM_COM ASC";
			$resultCOM	=@pg_Exec($connRPC,$qryCOM);
			for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
				$filaCOM = @pg_fetch_array($resultCOM,$i);
				echo "<OPTION value=\"".trim($filaCOM['nom_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
			}//for resultPRO
		}else{
		    // NO EXISTE LA comuna para este apoderado
			// busco la comuna del alumno
			$sql_com = "select region, ciudad, comuna from alumno where rut_alumno = '$alumno'";
			$res_com = @pg_Exec($conn,$sql_com);
			$fil_com = @pg_fetch_array($res_com);
			
			$reg_alu = $fil_com['region'];
			$ciu_alu = $fil_com['ciudad'];
			$com_alu = $fil_com['comuna'];
			
			
		    $qryCOM	= "SELECT * FROM COMUNA WHERE COD_REG='$reg_alu' AND COR_PRO = '$ciu_alu' AND COR_COM = '$com_alu'";
		    $resultCOM	=@pg_Exec($conn,$qryCOM);
		    $filaCOM	= @pg_fetch_array($resultCOM);
			
			$nombre_comuna = trim($filaCOM['nom_com']);
			?>
		    <option value="<?=$nombre_comuna ?>" selected="selected"><?=imp($filaCOM['nom_com']);?></option>
			<?
		    $qryCOM		="SELECT * FROM COMUNA ORDER BY NOM_COM ASC";
		    $resultCOM	=@pg_Exec($connRPC,$qryCOM);
		    for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			    $filaCOM = @pg_fetch_array($resultCOM,$i);
			    echo "<OPTION value=\"".trim($filaCOM['nom_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		    }   //for resultPRO			
			
		}		
		//fin IF
	?>
	</SELECT>
 <?php }  ;?>
	
	</td>
  </tr>
  
  
  <tr>
    <td class="cuadro02">Tel&eacute;fono</td>
    <td class="cuadro02">E-mail</td>
    <td class="cuadro02">Relaci&oacute;n</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
	   <input type="text" name="txtTELEF" size="20" maxlength="30" value="<?=imp($fila_alum['telefono']);?>">
	   <?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																imp($telefono_apo);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name="txtTELEF" size="20" maxlength="30" value="<?php echo trim($telefono_apo);?>">
									    <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	
	   <?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name="txtEMAIL" size="30" maxlength="50">
														<?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																imp($f2['email']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name="txtEMAIL" size="30" maxlength="50" value="<?php echo trim($f2['email']);?>">
											  <?php };?>	</td>
    <td class="cuadro01">&nbsp;<?php if($frmModo=="ingresar"){?>
															<Select name="cmbRELACION" >
																<option value="0" selected></option>
																<option value="1" >Padre</option>
																<option value="2" >Madre</option>
																<option value="3" >Otro</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																switch ($f2['relacion']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Padre');
																		 break;
																	 case 2:
																		 imp('Madre');
																		 break;
																	 case 3:
																		 imp('Otro');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbRELACION">
																<option value=0></option>
														<option value=1 <?php echo ($f2['relacion'])==1?"selected":"" ?>>Padre</option>
														<option value=2 <?php echo ($f2['relacion'])==2?"selected":"" ?>>Madre</option>
														<option value=3 <?php echo ($f2['relacion'])==3?"selected":"" ?>>Otro</option>
															</Select>
											  <?php };?>													</td>
  </tr>
  <tr>
    <td class="cuadro02">Nivel Educacional </td>
    <td class="cuadro02">Profesi&oacute;n</td>
    <td class="cuadro02">Lugar de Trabajo </td>
	
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?
	   if ($frmModo == "ingresar"){  ?>
	        <input type="text" name="nivel_edu" size="30" maxlength="100">  <?
	  }else{	?>	
	       <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                     <INPUT type="text" name="nivel_edu" size=30 maxlength=100 value="<?php echo trim($f2['nivel_edu']);?>">
              <? } else { imp(trim($f2['nivel_edu']))?>
           <?php };
	   } ?>
				 
				 
				 	</td>
    <td class="cuadro01">&nbsp;
	    <?
	   if ($frmModo == "ingresar"){  ?>
	       <input type="text" name="profesion" size="30" maxlength="100"> <?
	   }else{ ?>		   
	        <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                      <INPUT type="text" name="profesion" size=30 maxlength=100 value="<?php echo trim($f2['profesion']);?>">
               <? } else { imp(trim($f2['profesion']))?>
            <?php };
	   }  ?>	</td>
    <td class="cuadro01">&nbsp;
	   <?
	   if ($frmModo == "ingresar"){  ?>
	       <input type="text" name="lugar_trabajo" size="30" maxlength="100"> <?
	   }else{ 	   
	      if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
               <INPUT type="text" name="lugar_trabajo" size=30 maxlength=100 value="<?php echo trim($f2['lugar_trabajo']);?>"><?           }else{ 
			   imp(trim($f2['lugar_trabajo']));
          }
	   }	   
   ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Cargo</td>
    <td class="cuadro02">Direcci&oacute;n trabajo </td>
	 <td class="cuadro02">Ingresos Familiares </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?
	   if ($frmModo == "ingresar"){  ?>
	       <input type="text" name="cargo" size="30"  maxlength="100"> <?
	   }else{  ?>
	   	   <?php
		    if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                <INPUT type="text" name="cargo" size=30 maxlength=100 value="<?php echo trim($f2['cargo']);?>"> <?
			}else{ ?>	
                <? imp(trim($f2['cargo']));
			}
		}	?>	</td>
    <td class="cuadro01">&nbsp;
	     <?
	   if ($frmModo == "ingresar"){  ?>
	       <input type="text" name="direccion_lab" size="30" maxlength="100"> <?
	   }else{	   
	         if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                 <INPUT type="text" name="direccion_lab" size=30 maxlength=100 value="<?php echo trim($f2['direccion_lab']);?>"><?             }else{ 
				 imp(trim($f2['direccion_lab']))?>
       <?php };
	   } ?>
			 	</td>
				
				
		<td class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="nivelsocial" >
													<option value=0 selected>Seleccione Nivel de Ingresos</option>
													<option value=1>0-100.000</option>
													<option value=2>100.000-200.000</option>
													<option value=3>200.000-300.000</option>
													<option value=4>300.000-400.000</option>
													<option value=5>400.000-500.000</option>
													<option value=6>500.000-600.000</option>
													<option value=7>600.000-700.000</option>
													<option value=8>700.000-800.000</option>
													<option value=9>800.000-900.000</option>
													<option value=10>900.000-1.000.000</option>
													<option value=11>Mas de 1.000.000</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($f2['nivel_social']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														case 1:
															 imp('0-100.000');
															 break;
													    case 2:
															 imp('100.000-200.000');
															 break;
														case 3:
															 imp('200.000-300.000');
															 break;
														case 4:
															 imp('300.000-400.000');
															 break;
														case 5:
															 imp('400.000-500.000');
															 break;
														case 6:
															 imp('500.000-600.000');
															 break;
													    case 7:
															 imp('600.000-700.000');
															 break;	
														case 8:
															 imp('700.000-800.000');
															 break;
															 
														case 9:
															 imp('800.000-900.000');
															 break;	
														case 10:
															 imp('900.000-1.000.000');
															 break;	  	 
														case 11:
														    imp('Mas de 1.000.000')	;
															break;	 	 	 
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="nivelsocial">
													<option value=0>Seleccione Nivel de Ingresos</option>
											<option value=1 <?php echo ($f2['nivel_social'])==1?"selected":"" ?>>0-100.000</option>
											<option value=2 <?php echo ($f2['nivel_social'])==2?"selected":"" ?>>100.000-200.000</option>
										    <option value=3 <?php echo ($f2['nivel_social'])==3?"selected":"" ?>>200.000-300.000</option>
											<option value=4 <?php echo ($f2['nivel_social'])==4?"selected":"" ?>>300.000-400.000</option>
											<option value=5 <?php echo ($f2['nivel_social'])==5?"selected":"" ?>>400.000-500.000</option>
											<option value=6 <?php echo ($f2['nivel_social'])==6?"selected":"" ?>>500.000-600.000</option>
											<option value=7 <?php echo ($f2['nivel_social'])==7?"selected":"" ?>>600.000-700.000</option>
											<option value=8 <?php echo ($f2['nivel_social'])==8?"selected":"" ?>>700.000-800.000</option>
											<option value=9 <?php echo ($f2['nivel_social'])==9?"selected":"" ?>>800.000-900.000</option>
											<option value=10 <?php echo ($f2['nivel_social'])==10?"selected":"" ?>>900.000-1.000.000</option>
											<option value=11 <?php echo ($f2['nivel_social'])==11?"selected":"" ?>>Mas de de 1.000.000</option>
															
												</Select>
											<?php };?></td>		
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="center" class="cuadro02">Ocupaci�n Actual </div></td>
	<td ><div align="center" class="cuadro02">&nbsp; </div></td>
	<td ><div align="center" class="cuadro02">&nbsp; </div></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="center" class="cuadro01">
	 <?
	 if ($frmModo == "ingresar"){  ?>
	     <input type="text" name="ocupacion_actual" size="30"  maxlength="100">
	<? }  ?>
	
	<?
	 if ($frmModo == "modificar"){  ?>
	     <input type="text" name="ocupacion_actual" size="30"  maxlength="100" value="<?=$ocupacion_actual ?>">
	<? } ?>	 
	
	<?
	 if ($frmModo == "mostrar"){ 
	       echo "$ocupacion_actual";
	 } ?>	
	 </div></td>
	<td ><div align="center" class="cuadro01">&nbsp; </div></td>
	<td ><div align="center" class="cuadro01">&nbsp; </div></td>
	<td>&nbsp;</td>
  </tr>
  
  
  
  
  
  <tr>
    <td colspan="3"><div align="center" class="cuadro02">Situaci&oacute;n Familiar </div></td>
	
  </tr>
  <tr>
    <td colspan="3"><div align="center">
      <label>
	    <?
	   if ($frmModo == "ingresar"){  ?>
	       <textarea name="situacion_familiar" cols="60" rows="10"></textarea> <?
	   }
	    
	   if ($frmModo == "modificar"){  ?>
           <textarea name="situacion_familiar" cols="60" rows="10" id="situacion_familiar"><?=$situacion_familiar ?></textarea><?
	   }
	   
	   if ($frmModo == "mostrar"){ ?>
	       <textarea name="situacion_familiar" cols="60" disabled="disabled" rows="10" id="situacion_familiar"><?=$situacion_familiar ?></textarea> <?
	   } ?>	   
	   	   
      </label>
    </div></td>
  </tr>
 
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  <?
  
  }else{ ?>
     </td>
	 </tr>
	 </table>
<? } // fin if si familiar es distinto de 0
  
  ?>
  
  <tr>
    <td colspan="3" class="tableindex">Hermanos</td>
  </tr>
  <tr>
    <td colspan="3">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="cuadro02">&nbsp;</td>
              <td><div align="right">
			     <!-- ac� verifico si tiene hermanos -->
  <?      
 
    
  if ($_FRMMODOH == "modificar"){
         $qry="select * from hermanos where rut_alumno = '".trim($alumno)."' and rut_hermano = '".trim($_HERMANOMOD)."'";
         $result =@pg_Exec($conn,$qry);
         $nh = @pg_numrows($result);
         
  
  }else{
        $qry="select hermanos.* from relacion_hermanos, hermanos where relacion_hermanos.rut_alumno = '".$alumno."' and relacion_hermanos.rut_hermano = hermanos.rut_hermano";
  $result =@pg_Exec($conn,$qry);
  $nh = @pg_numrows($result);
  
  }  
  ?>  
			  
			  		<?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1)){ ?>
							   <INPUT class="botonXX"  TYPE="button" value="AGREGAR HERMANO" onClick=document.location="apoderado/seteaHermano.php?caso=2">  <?
						  } ?>								
							
			  </div></td>
            </tr>
          </table>
	</td>
  </tr>
 <?
  
     if ($_FRMMODOH == "ingresar" or $_FRMMODOH == "modificar"){
		   $nh = 1;
	 }
   
     if ($nh > 0){ // tiene hermanos
	    $i = 0;
        while ($i < $nh){
		 
  	    $fila = @pg_fetch_array($result,$i);
	    $hermano = $fila['rut_hermano']; 
          
				
      ?> 
      <tr>
        <td colspan="3" class="cuadro02"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="cuadro02">Rut</td>
              <td>
			     <div align="right"><?
				 			 
					    if ($_FRMMODOH == "mostrar"){  ?>
						    <INPUT name=btnModificar  TYPE="button" class="botonXX" onClick="MM_goToURL('parent','apoderado/seteaHermano.php?hermanomod=<?=trim($hermano); ?>&caso=3');return document.MM_returnValue" value="MODIFICAR">
							<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name="btnEliminar" onClick=document.location="apoderado/seteaHermano.php?caso=9&hermanoelim=<?=trim($hermano); ?>"> <?
					    }
						
						
						
						if ($_FRMMODOH == "modificar"){ ?>						   
						   	<input name="modh" type="hidden"  value="1">
							<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"  name=btnGuardar onClick="return valida2(this.form);">	
							<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="apoderado/seteaHermano.php?hermano=<?php echo trim($hermano)?>&caso=1"> <?
					    }
						
						
						
						if ($_FRMMODOH == "ingresar"){ ?>						    					    
						     <input name="pestah" type="hidden" id="pestah" value="1">
							 <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name="btnGuardar" onClick="return valida2(this.form);">	
						     <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="apoderado/seteaHermano.php?hermano=<?php echo trim($hermano)?>&caso=1"> 
					 <? } ?>					 
				
			       
			          </div></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="3" class="cuadro01">&nbsp;
	
	         <?php if($_FRMMODOH == "ingresar"){ ?>
						<INPUT type="text" name="rut_hermano" size=8 maxlength=8 onChange="checkRutField(this);">
					<?php };?>
					<?php 
						if($_FRMMODOH=="mostrar" or $_FRMMODOH == "modificar"){ 
							imp($fila['rut_hermano']);
						};
				?> - 
				<?php if($_FRMMODOH=="ingresar"){ ?>
						<INPUT type="text" name="dig_rut" size=2 maxlength=1 >
					<?php };?>
					<?php 
						if($_FRMMODOH=="mostrar" or $_FRMMODOH == "modificar"){ 
							imp($fila['dig_rut']);
						};
				?>
			
	    </td>
        </tr>
       <tr>
        <td class="cuadro02">Nombre</td>
        <td class="cuadro02">Apellido Paterno</td>
        <td class="cuadro02">Apellido Materno</td>
      </tr>
      <tr>
        <td class="cuadro01">&nbsp;
		<?php if($_FRMMODOH=="ingresar"){ ?>
			     <INPUT type="text" name="nombre_hermano" size=25 maxlength=50>
		 <?php };?>
		 <?php 
			if($_FRMMODOH=="mostrar"){ 
				imp($fila['nombre_hermano']);
			};
	 	?>
	  	<?php if($_FRMMODOH=="modificar"){ ?>
		 	<INPUT type="text" name="nombre_hermano" size=25 maxlength=50 value="<?php echo trim($fila['nombre_hermano']);         ?>">
		 <?php };?>
		 
		 </td>
       <td class="cuadro01">&nbsp;
	     <?php if($_FRMMODOH=="ingresar"){ ?>
			<INPUT type="text" name="ape_pat" size=25 maxlength=50>
		 <?php };?>
	 	<?php 
			if($_FRMMODOH=="mostrar"){ 
				imp($fila['ape_pat']);
			};
	 	?>
	 	<?php if($_FRMMODOH=="modificar"){ ?>
			<INPUT type="text" name="ape_pat" size=25 maxlength=50 value="<?php echo trim($fila['ape_pat']);?>">
	 	<?php };?>			
			
			</td>
        <td class="cuadro01">&nbsp;
		<?php if($_FRMMODOH=="ingresar"){ ?>
	 		<INPUT type="text" name="ape_mat" size=25 maxlength=50>
	 	<?php };?>
 		<?php  
			if($_FRMMODOH=="mostrar"){ 
				imp($fila['ape_mat']);
			};
		?>
		<?php if($_FRMMODOH=="modificar"){ ?>
			<INPUT type="text" name="ape_mat" size=15 maxlength=10 value="<?php echo trim($fila['ape_mat']);?>">
		<?php };?>						
			</td>
      </tr>
      <tr>
        <td class="cuadro02">Fecha de Nacimiento</td>
        <td colspan="2" class="cuadro02">Estudios</td>
        </tr>
      <tr>
        <td class="cuadro01">&nbsp;<?php
		    if($_FRMMODOH=="ingresar"){ ?>
			   <INPUT type="text" name="fecha_nac" size=10 maxlength=10><FONT face="arial, geneva, helvetica" size=1 color=#000000>    <STRONG>DD-MM-AAAA</STRONG></FONT>
	 	<?php };?>
	 	<?php 
			if($_FRMMODOH=="mostrar"){ 
				imp(Cfecha($fila['fecha_nac']));
			};
		?>
		<?php if($_FRMMODOH=="modificar"){ ?>
		   	      <INPUT type="text" name="fecha_nac" size=10 maxlength=10 onChange='fechas(this.value); this.value=borrar' value="<?php echo trim((Cfecha($fila['fecha_nac'])));?>">   <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>DD-MM-AAAA</STRONG></FONT>
		<?php };?>	 </td>
       <td colspan="2" class="cuadro01">&nbsp;
	      <?php if($_FRMMODOH=="ingresar"){ ?>
			        <INPUT type="text" name="estudios" size=50 maxlength=50>
		<?php };?>
		<?php 
			if($_FRMMODOH=="mostrar"){ 
				imp($fila['estudios']);
			};
		?>
		<?php if($_FRMMODOH=="modificar"){ ?>
			     <INPUT type="text" name="estudios" size=50 maxlength=50 value="<?php echo trim($fila['estudios']);?>">
		<?php };?>									
			</td>
       </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	 <?
	 
	 $i++;
	  
	  } // fin de ciclo
	} // fin muestra de hermanos
	
	?>  
  
</table>
</FORM>
									  
  </td>
</tr>
<tr id="academico">
  <td>
							  
<FORM method=post name="frm" action="apoderado/procesoApoderado.php3?apoderado=<?=$rut_apo ?>">
 <input name="pesta" type="hidden" value="3">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="4" class="tableindex">Antecedentes acad�micos</td>
    </tr>
  <tr>
    <td class="cuadro02">Curso</td>
    <td class="cuadro02">Fecha Matricula </td>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div align="right">
		   <!-- botones -->
		   
		               <? 
					   if ($_PERFIL!=19){ ?>
					   <table>
						<TR height="50" >
							<TD align=right colspan=2>
								<?php
								
																
								 /*---	echo ("Perfil:".$_PERFIL); VERIFICAR VARIABLE DE SESSION _PERFIL ---*/
								if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
									<?php if($frmModo=="ingresar"){ ?>
										<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAlumnos.php3">&nbsp;
									<?php }; ?>
									<?php if($frmModo=="mostrar"){ ?>
										<?php if($_PERFIL!=17){?>
											<?php if(($_PERFIL!=2)&&($_PERFIL!=3)&&($_PERFIL!=4)&&($_PERFIL!=5)&&($_PERFIL!=6)&&
													($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&
													($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=26)
													){ ?>
												<?php if($situacion != 0){ // para a�os cerrados ?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&pesta=3&caso=3">&nbsp;
												<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaAlumno.php3?caso=9;"-->
												<?php }?>
											<?php }?>
										<?php }?>&nbsp;
										<?php };?>
									<?php if($frmModo=="modificar"){ ?>
									         <INPUT  class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar>&nbsp;
										     <INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&caso=1&pesta=3">&nbsp;
									<?php };?>
								<?php };?>								</TD>
								</TR>
								</table>
		
		                   <? } ?>
		
		</div></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	 <?															
		if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														echo "SALA CUNA"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MENOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MAYOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICI�N 1er NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICI�N 2do NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);;
													}else{
														imp($fila1["grado_curso"]."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]);
													}

																
																//imp($fila1["grado_curso"]."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]);
		echo "<input type=hidden name=curso value=".$fila1['id_curso'].">";

															
			?>
               	</td>
    <td class="cuadro01">&nbsp;
	     <?php	//*************** MODIFICACION 07-02-2003 ********************** 
											//----------- Agregar campo Fecha Matricula --------------------

                                         $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='$alumno' AND RDB='$institucion' AND ID_ANO='$ano'";
		                                     $resultB =@pg_Exec($conn,$qryB);
		                                        if (!$resultB) {
			                                         error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		                                         }else{
			                                    if (pg_numrows($resultB)!=0){
				                                     $filaB = @pg_fetch_array($resultB,0);	
				                                if (!$filaB){
					                           error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					                         exit();
				                              }
			                                }
		                                 }							
                
				impF($filaB['fecha']);  ?>				 
					                 
					</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Retirado</td>
    <td class="cuadro02">Fecha de Retiro </td>
    <td class="cuadro02">Religi&oacute;n </td>
    <td class="cuadro02">Repitente del grado </td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
      
        <div align="left">
          <?php if($frmModo=="ingresar"){ ?>
          <input type="checkbox" name=AR size=83 maxlength=50 > 
          <?php };?>
          <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_ar']==0)?"NO":"SI");
												};
											?>
          <?php if($frmModo=="modificar"){ ?>
          <input type="checkbox" name=AR size=83 maxlength=50 value=1 
				<?php 
				  echo ($filaB['bool_ar']==1)?"checked":"";
				?>> 
          <?php };?>              
          </div></td>
    <td class="cuadro01">&nbsp;
	
	    <div align="left">
	      <?php if($frmModo=="ingresar"){ ?>
	      <input type="text" name="FechaRetiro" size="10" maxlength="10" onChange='fechas(this.value); this.value=borrar'> 
	      <br> 
	      <font face="arial, geneva, helvetica" size=1 color=#000000> <strong>(DD-MM-AAAA)</strong> </font> 
	      <?php	}; ?>
	      <?php if($frmModo=="mostrar"){ 
                                                        impF($filaB['fecha_retiro']);
														     }; ?>
	      <?php if ($frmModo=="modificar"){ 
                                                                ?>
	      <input type="text" name="FechaRetiro" value="<?php  impF($filaB['fecha_retiro']); ?>" size="10" maxlength="10" onChange='fechas(this.value); this.value=borrar'> 
	      <br> 
	      <font face="arial, geneva, helvetica" size=1 color=#000000> 
	        <strong>(DD-MM-AAAA)</strong> </font> 
	      <?php }; ?>				
	      </div></td>
    <td class="cuadro01">&nbsp;
	    <?
		// busco el a�o en que esta:
		$q1 = "select * from ano_escolar where id_ano = '$ano'";
		$r1 = pg_Exec($conn,$q1);
		$f1 = pg_fetch_array($r1);
		$nro_ano = $f1['nro_ano'];
		
		$q2 = "select * from tiene$nro_ano , ramo where tiene$nro_ano.rut_alumno = '$_ALUMNO' and tiene$nro_ano.id_ramo = ramo.id_ramo and ramo.cod_subsector = '13'";
		$r2 = pg_Exec($conn,$q2);
		$n2 = pg_numrows($r2);
		if ($n2 > 0){  // entonces opta a religi�n 
		    echo "Opta <br>";			
		}else{
		    echo "No opta";
		}
		?>
	
	<div align="left"></div></td>
    <td class="cuadro01">&nbsp;
      
        <div align="left">
          <?php if($frmModo=="ingresar"){ ?>
          <input name=RDG type="checkbox" id="RDG" size=83 maxlength=50>
          <?php };?>
          <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_rg']==0)?"NO":"SI");
													if ($filaB['bool_rg']==1) 
														 $estado['RDG']="enabled";

												};
											?>
          <?php if($frmModo=="modificar"){ ?>
          <input name=RDG type="checkbox" id="RDG"	value=1 size=83 maxlength=50 <?php echo ($filaB['bool_rg']==1)? "checked":"" ?>>
          <?php };?>
          </div></td>
  </tr>
  <tr>
    <td class="cuadro02">Ev. Diferencial </td>
    <td class="cuadro02">Integrado </td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">
      
            <div align="left">
              <?php if($frmModo=="ingresar"){ ?>
                         <input name="ED" type="checkbox" id="ED" value="1">
              <?php };?>
              <?php 
					if($frmModo=="mostrar"){ 
						imp( ($filaB['bool_ed']==0)?"NO":"SI");
					};
				?>
              <?php if($frmModo=="modificar"){ 
				          if ($filaB['bool_ed']==1){ ?>
                               <input name="ED" type="checkbox" id="ED" value="1" checked="checked">
                          <?
						  }else{  ?>
                              <input name="ED" type="checkbox" id="ED" value="1">
                          <?
					      }
				   } ?>
            </div></td>
    <td class="cuadro01">
      
            <div align="left">
              <?php if($frmModo=="ingresar"){ ?>
              <input name=I type="checkbox" id="I" size=83 maxlength=50>
              <?php };?>
              <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_i']==0)?"NO":"SI");
													if ($filaB['bool_i']==1) 
														 $estado['I']="enabled";

												};
											?>
              <?php if($frmModo=="modificar"){ ?>
              <input name=I type="checkbox" id="I" value=1 size=83 maxlength=50 <?php echo ($filaB['bool_i']==1)?"checked":"" ?>
												>
              <?php };?>
            </div></td>
    <td class="cuadro01">&nbsp;<div align="left"></div></td>
    <td class="cuadro01">&nbsp;
      <div align="left"></div></td>
  </tr>
</table>
</FORM>					
									  
									  </td>
                                    </tr>
                             
					
					
					
					
					<tr id="conducta">
                    <td valign="top">								
									
							
							<table WIDTH="100%" BORDER="0" align="center" CELLPADDING="5" CELLSPACING="0">
			<tr height="20">
				<td align="middle" colspan="5" class="tableindex">
					CONDUCTA
				</td>
			</tr>
			<tr>
				<td colspan=5 align=right>
				<?php
			    if ($_PERFIL!=15){   				
					if(($_PERFIL==17) && ($institucion==24977 || $institucion==9566)){   					
						// no muestra nada 
					}else{
					    if (($_PERFIL!=2) and ($_PERFIL!=20)){
				           ?>
					       <INPUT TYPE="button" class="botonXX"  value="AGREGAR" onClick=document.location="../../../empleado/anotacion/seteaAnotacion.php3?alumno=<?php echo $alumno ?>&caso=2&desde=alumno">
				           <?
						}   
					}
				}
				?>
				<!--PARA AGREGAR UNA ANOTACION SE HACE DESDE EMPLEADO--></td>
			</tr>
			
			<tr class="tablatit2-1">
				<td align="center" width="10%">
					FECHA				</td>
				<td align="center" width="15%">
					RESPONSABLE				</td>
				<td align="center" width="20%">
					SIGLA </td>
				<td align="center" width="30%">
					TIPO ANOTACION				</td>
				<td align="center" width="25%">
					ANOTACION				</td>
			</tr>
			<?php
				
					//$qry="SELECT anotacion.id_anotacion,anotacion.sigla,anotacion.codigo_tipo_anotacion,anotacion.codigo_anotacion,anotacion.rdb,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=".trim($alumno).")) order by id_anotacion Desc ";				
				  
				$qry="SELECT anotacion.id_anotacion, anotacion.sigla, anotacion.codigo_tipo_anotacion, anotacion.codigo_anotacion, anotacion.tipo, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=".trim($alumno).")) and anotacion.id_periodo in (select id_periodo from periodo where id_ano = '".trim($_ANO)."') order by fecha ";
				$result =@pg_Exec($conn,$qry);
//				echo $numero_filas = pg_numrows($result);
				if (!$result){
					error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');
				}else{
				    if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					    $fila = @pg_fetch_array($result,0);	
					    if (!$fila){
						    error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						    exit();
					    }
					}
					    	
				}
			?>
			<?php 
			
			$nu_anotaciones = 0;
			
			
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						
						$sigla_aux = $fila["sigla"];
						
						if($fila['tipo']==2){
			               $nu_anotaciones++;
			            }					
						
						//if ($sigla_aux!=NULL){
						
						/// NO MUESTRO NADA					
												
								 
								 if ($sigla_aux!=NULL){
								     if ($nu_anotaciones==3){
								        ?>
								        <tr bgcolor="#F47068" onClick=go('../../../empleado/anotacion/seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1&desde=alumno')>
							            <?
										$nu_anotaciones = 0;
									 }else{
									    ?>
								        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('../../../empleado/anotacion/seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1&desde=alumno')>
							            <?									 
									 }	
							     }else{
								     if ($nu_anotaciones==3){
									     ?>
										 <tr bgcolor="#F47068" onClick=go('../../../empleado/anotacion/seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1&desde=alumno&old=1')>
										 <?
										 $nu_anotaciones = 0;
									 }else{										 
								         ?>
								         <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('../../../empleado/anotacion/seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=1&desde=alumno&old=1')>
							             <?
							         }
								    
								 }    
								 
								 ?> 	
															
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php echo impF($fila["fecha"]);?></strong></font></td>
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></strong></font></td>
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php 
												// busco la sigla
												
												$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
												$r1 = @pg_Exec($conn,$q1);
												$f1 = @pg_fetch_array($r1,0);
																					
												
												echo $f1["sigla"];?> </strong></font></td>						
												
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong><?php
												   if($fila["codigo_tipo_anotacion"]=="")
													{
													
													   if ($fila['tipo']==1){
													        echo "CONDUCTA ";
															if ($fila['tipo_conducta']==1){
															    echo "POSITIVA";
															}	
													        if ($fila['tipo_conducta']==2){
															    echo "NEGATIVA";
															}
													   }
													   	
														
														if($fila['tipo']==2){
															echo "ATRASO";
														}															
															
														if($fila['tipo']==3){
															echo "INASISTENCIA";
														}
															
														if($fila['tipo']==4){
															echo "ENFERMERIA";
														}												
																											
												   	}else{
																							 
													   $cod_ta = $fila["codigo_tipo_anotacion"];													   
													   $q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
													   $r1 = @pg_Exec($conn,$q1);
													   $f1 = @pg_fetch_array($r1,0);
														
													   $codta       = $f1['codtipo'];
													   $descripcion	= $f1['descripcion'];
																																
													   echo "$codta - $descripcion";  
													  }
													  
													  ?>
												   </strong></font></td>
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php 
												   $codigo_anotacion = $fila["codigo_anotacion"];
												
												   $q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
												   $r1 = @pg_Exec($conn,$q1);
												   $f1 = @pg_fetch_array($r1,0);
												   
												   $detalle = $f1["detalle"];
												   
												   echo "$codigo_anotacion - $detalle"; 
												   ?>
												
												   </strong></font></td>
								</tr>
						<? // } ?>		
			<?php
			           
			
					}
				
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
		</table>		  
		   
			
							
							
								
								  </td>
                                     </tr>	
									 
									 
									 							 
									 <tr id="becas">
                                      <td valign="top">
									   <?
                                         $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='$alumno' AND RDB='$institucion' AND ID_ANO='$ano'";                          $resultB =@pg_Exec($conn,$qryB);
		                                 if (!$resultB) {
			                                 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		                                 }else{
			                                 if (pg_numrows($resultB)!=0){
				                                 $filaB = @pg_fetch_array($resultB,0);	
				                                 if (!$filaB){
				                                     error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					                                 exit();
				                                 }
			                                 }
		                                 }  ?>  
									  
		                               <FORM method=post name="frm" action="apoderado/procesoApoderado.php3?apoderado=<?=$rut_apo ?>">
						             <input name="pesta" type="hidden" value="5">	  
									    <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" class="tableindex">Becas</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;
	
	            <? if ($_PERFIL!=19){ ?>
	                 <table align="right">
						<TR height="0" >
							<TD align=right colspan=2>
								<?php
								
																
								 /*---	echo ("Perfil:".$_PERFIL); VERIFICAR VARIABLE DE SESSION _PERFIL ---*/
								if(($_PERFIL!=16)&&($_PERFIL!=15)){ ?>
									<?php if($frmModo=="ingresar"){ ?>
										<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAlumnos.php3">&nbsp;
									<?php }; ?>
									<?php if($frmModo=="mostrar"){ ?>
										<?php if($_PERFIL!=17){?>
											<?php if(($_PERFIL!=2)&&($_PERFIL!=3)&&($_PERFIL!=4)&&($_PERFIL!=5)&&($_PERFIL!=6)&&
													($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)&&
													($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=26)
													){ ?>
												<?php if($situacion != 0){ // para a�os cerrados?>
												<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&pesta=5&caso=3">&nbsp;
												<!--INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaAlumno.php3?caso=9;"-->
												<?php }?>
											<?php }?>
										<?php }?>&nbsp;
										<?php };?>
									<?php if($frmModo=="modificar"){ ?>
									    <INPUT  class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar>&nbsp;
										<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaAlumno.php3?alumno=<?php echo trim($alumno)?>&caso=1&pesta=5">&nbsp;
									<?php };?>
								<?php };?>								</TD>
								</TR>
								</table>
				<? } ?>				
								
	</td>
  </tr>
  <tr>
    <td class="cuadro02">Alimentaci&oacute;n Junaeb </td>
    <td class="cuadro02">C. de Padres </td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	  <?php
				 if($frmModo=="ingresar"){ ?>
	  <input name=BAJ type="checkbox" id="BAJ" size=83 maxlength=50 >
	  <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_baj']==0)?"NO":"SI");
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name=BAJ size=83 maxlength=50 value=1 
											<?php 
											  echo ($filaB['bool_baj']==1)?"checked":"";
											?>> 
                <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	    
	   <?php if($frmModo=="ingresar"){ ?>
                <input type="checkbox" name=CPADRE size=83 maxlength=50> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_cpadre']==0)?"NO":"SI");
													if ($filaB['bool_cpadre']==1) 
														 $estado['CPADRE']="enabled";
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name=CPADRE size=83 maxlength=50	value=1 <?php echo ($filaB['bool_cpadre']==1)? "checked":"" ?>
												> 
                <?php };?>	</td>
  </tr>
  <tr>
    <td class="cuadro02">Seguro</td>
    <td class="cuadro02">Otras</td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
                <input type="checkbox" name=SEG size=83 maxlength=50> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_seg']==0)?"NO":"SI");
													if ($filaB['bool_seg']==1) 
														 $estado['SEG']="enabled";
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name=SEG size=83 maxlength=50	value=1 <?php echo ($filaB['bool_seg']==1)? "checked":"" ?>
												> 
                <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	    
	   <?php if($frmModo=="ingresar"){ ?>
                <input type="checkbox" name=OTROS size=83 maxlength=50> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_otros']==0)?"NO":"SI");
													if ($filaB['bool_otros']==1) 
														 $estado['OTROS']="enabled";
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name=OTROS size=83 maxlength=50	value=1 <?php echo ($filaB['bool_otros']==1)? "checked":"" ?>
												> 
                <?php };?>	</td>
  </tr>
  <tr>
    <td class="cuadro02">Chile Solidario</td>
    <td class="cuadro02">Municipal </td>
  </tr>
  <tr>
    <td class="cuadro01">&nbsp;
	   <?php if($frmModo=="ingresar"){ ?>
                <input type="checkbox" name=BCHS size=83 maxlength=50> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_bchs']==0)?"NO":"SI");
													if ($filaB['bool_bchs']==1) 
														 $estado['BCHS']="enabled";
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name=BCHS size=83 maxlength=50	value=1 <?php echo ($filaB['bool_bchs']==1)? "checked":"" ?>
												> 
                <?php };?>	</td>
    <td class="cuadro01">&nbsp;
	
	           <?php if($frmModo=="ingresar"){ ?>
                <input type="checkbox" name=MUN size=83 maxlength=50> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaB['bool_mun']==0)?"NO":"SI");
													if ($filaB['bool_mun']==1) 
														 $estado['MUN']="enabled";
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="checkbox" name="MUN" size="83" maxlength="50"	value=1 <?php echo ($filaB['bool_mun']==1)? "checked":"" ?>
												> 
                <?php };?>
	
	           </td>
  </tr>
 
</table>
	</FORM>		
	  </td>
      </tr>
									 
	
	
	<!-- NUEVA PESTA�A, GRUPOS -->
			
			 <tr id="grupos">
			  <td valign="top">
			   <?
				 $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='$alumno' AND RDB='$institucion' AND ID_ANO='$ano'";                          $resultB =@pg_Exec($conn,$qryB);
				 if (!$resultB) {
					 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
				 }else{
					 if (pg_numrows($resultB)!=0){
						 $filaB = @pg_fetch_array($resultB,0);	
						 if (!$filaB){
							 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							 exit();
						 }
					 }
				 }  ?>  
									  
 <FORM method=post name="frm" action="procesoAlumno.php3?pesta=6&graba=1">
 <input name="pesta" type="hidden" value="6">	 
 <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="tableindex">Grupos</td>
    </tr>
  <tr>
    <td>
	
	<?
	if ($agregarg==1){
	       $q1 = "select * from grupos where rdb = '".trim($institucion)."' order by id_grupo Desc";
		   $r1 = pg_Exec($conn,$q1);
		   $n1 = pg_numrows($r1);
				
		     ?>
		    <table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<td colspan="3">
				<? if (($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
					 <div align="right">
					  <label>
					  <input name="GRABAR" type="submit" id="GRABAR" value="GRABAR" class="BotonXX">
					  <input name="Submit" type="button" class="BotonXX" onClick="MM_goToURL('parent','alumno.php3?pesta=6');return document.MM_returnValue" value="VOLVER">
					  </label>
					</div>
				<? }else{ ?>
				      &nbsp;
				<? } ?> 				      	
				</td>
				</tr>
				<tr>
				<td width="30%" class="cuadro02"><div align="left">Nombre</div></td>
				<td width="65%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
				<td width="5%" class="cuadro02"><div align="center">&nbsp;</div></td>
				</tr>
				<?
				$i = 0;
				while ($i < $n1){
					 $f1 = pg_fetch_array($r1,$i);
					 $nombre      = $f1['nombre'];
					 $descripcion = $f1['descripcion'];
					 $id_grupo    = $f1['id_grupo'];
					 
					 // busco este grupo en la relacion_grupo
					 $q2 = "select * from relacion_grupo where id_grupo = '$id_grupo' and rut_integrante = '".trim($_ALUMNO)."'";
					 $r2 = pg_Exec($conn,$q2);
					 $n2 = pg_numrows($r2);
					 	 
					 
					  if ($nombre!=NULL){ ?>
						 <?
						 if ($n2==0){ ?>
							 <tr>
							 <td class="cuadro01"><?=$nombre ?></td>
							 <td class="cuadro01"><?=$descripcion ?></td>
							 <td class="cuadro01"><div align="center">
							   <label></label>
							   <label><input type="checkbox" name="chg<?=$i ?>" value="<?=$id_grupo ?>">
							   </label>
							 </div></td>
							 </tr>
							 <?
						 }
					 }	 
					 
					 
					 $i++;
				}
				?>	 
			</table>
		    <?	
		  
		
	}else{
		
			$q1 = "select * from grupos, relacion_grupo where grupos.id_grupo = relacion_grupo.id_grupo and relacion_grupo.rut_integrante = '".trim($alumno)."' and grupos.rdb = '".trim($institucion)."'";
			$r1 = pg_Exec($conn,$q1);
			$n1 = pg_numrows($r1);
			?>
				 
			 <table width="100%" border="0" cellspacing="0" cellpadding="3">
			  <tr>
				<td colspan="3"><div align="right">
				  <?
				  if (($_PERFIL!=19) and ($_PERFIL!=2) and ($_PERFIL!=20)){ ?>				  
					  <label>
					  <input name="AGREGARGRUPO" type="submit" id="AGREGARGRUPO" onClick="MM_goToURL('parent','alumno.php3?pesta=6&agregarg=1');return document.MM_returnValue" value="AGREGAR">
					  </label>
				 <? } ?> 
				  
				</div></td>
				</tr>
				<tr>
				<td width="45%" class="cuadro02"><div align="left">Nombre</div></td>
				<td width="45%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
				
				<?
				if (($_PERFIL=="14") OR ($_PERFIL=="0")){ ?>				
				      <td width="10%" class="cuadro02"><div align="center">Borrar</div></td>
			 <? } ?>	
	
				</tr>
				<?
				$i = 0;
				while ($i < $n1){
					 $f1 = pg_fetch_array($r1,$i);
					 $nombre      = $f1['nombre'];
					 $descripcion = $f1['descripcion'];
					 $id_aux      = $f1['id_aux'];
					 $id_grupo    = $f1['id_grupo'];
					 
					 if ($nombre!=NULL){ ?>			    				 
						
						 <tr>
						 <td class="cuadro01"><?=$nombre ?></td>
						 <td class="cuadro01"><?=$descripcion ?></td>
						 <?
						 if (($_PERFIL=="14") OR ($_PERFIL=="0")){ ?>
							 <td class="cuadro01">
							 <? if (($_PERFIL!=19) and ($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
								 <div align="center">
								 <input name="Submit2" type="button" onClick="MM_goToURL('parent','procesoAlumno.php3?pesta=6&borrar=1&id_grupo=<?=$id_grupo ?>');return document.MM_returnValue" value="B">
								 </div>
							 <? } ?>
							 
							 </td>
					   <? } ?>		 
						 </tr>
				  <? } ?>		 
					 
					 <?
					 $i++;
				}
				?>	 
			</table>
	<? } ?>	
	
	
	
	</td>
    </tr>
</table>
</FORM>		
         </td>
      </tr>
									 
	<!-- FIN PESTA�A GRUPOS -->		
	
	
	
	
	
	
	     <!-- NUEVA PESTA�A, PARA ENTREVISTAS APODERADOS -->
			
		 <tr id="entrevista">
		  <td valign="top">
		   <?
			 $qryB="SELECT * FROM MATRICULA WHERE RUT_ALUMNO='$alumno' AND RDB='$institucion' AND ID_ANO='$ano'";                          $resultB =@pg_Exec($conn,$qryB);
			 if (!$resultB) {
				 error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
			 }else{
				 if (pg_numrows($resultB)!=0){
					 $filaB = @pg_fetch_array($resultB,0);	
					 if (!$filaB){
						 error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						 exit();
					 }
				 }
			 }  ?>  
									  
 
 
 <FORM method=post name="frm" action="procesoAlumno.php3?pesta=7&graba=1">
 <input name="pesta" type="hidden" value="7">	 
 <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="tableindex">Entrevista Apoderados</td>
    </tr>
  <tr>
    <td><?
	if ($agregarg==1){
	
	      $q1 = "select * from tiene2 where rut_alumno = '".$_ALUMNO."'";
		  $r1 = @pg_Exec($conn,$q1);
		  $f1 = @pg_fetch_array($r1);
		  $rut_apo = $f1['rut_apo'];
		
		  $select_apo = "select * from apoderado where rut_apo = '$rut_apo'";
		  $res_apo = @pg_Exec($conn,$select_apo);
		  $fil_apo = @pg_fetch_array($res_apo);
		
		  $nom_apo = $fil_apo['nombre_apo'];
		  $ape_pat = $fil_apo['ape_pat'];
		  $ape_mat = $fil_apo['ape_mat'];	
				
		  ?>
          <br />
          <table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="40%"  class="cuadro02">Apoderado</td>
            <td class="cuadro01"><? echo "$nom_apo $ape_pat $ape_mat"; ?></td>
          </tr>
          <tr>
            <td  class="cuadro02">Fecha</td>
            <td class="cuadro01"><label>
              <input name="fecha" type="text" id="fecha" size="11" maxlength="10" />
            (dd-mm-aaaa)</label></td>
          </tr>
          <tr>
            <td  class="cuadro02">Asunto</td>
            <td class="cuadro01"><label>
              <input name="asunto" type="text" id="asunto" size="58" />
            </label></td>
          </tr>
          <tr>
            <td  class="cuadro02">Observaciones</td>
            <td class="cuadro01"><label>
              <textarea name="observaciones" cols="60" rows="10" id="observaciones"></textarea>
            </label></td>
          </tr>
          <tr>
            <td colspan="2" class="cuadro01"><div align="center">
              <label>
              <input type="submit" name="Submit3" value="GRABAR" />
              </label>
              <label>
              <input name="Submit4" type="button" onClick="MM_goToURL('parent','alumno.php3?pesta=7');return document.MM_returnValue" value="VOLVER" />
              </label>
            </div></td>
          </tr>
        </table>
        <br />
        <br />
        <br />
        <?
				
	}else{
		
		$q1 = "select * from tiene2 where rut_alumno = '".$_ALUMNO."'";
		$r1 = @pg_Exec($conn,$q1);
		$f1 = @pg_fetch_array($r1);
		$rut_apo = $f1['rut_apo'];
		
		$select_apo = "select * from apoderado where rut_apo = '$rut_apo'";
		$res_apo = @pg_Exec($conn,$select_apo);
		$fil_apo = @pg_fetch_array($res_apo);
		
		$nom_apo = $fil_apo['nombre_apo'];
		$ape_pat = $fil_apo['ape_pat'];
		$ape_mat = $fil_apo['ape_mat'];	
				
		?>
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
          <td colspan="4"><div align="right">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">APODERADO: <? echo "$nom_apo $ape_pat $ape_mat";  ?></font> </td>
                <td><div align="right">
                  <?
				  if (($_PERFIL!=19) and ($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
                </div>
                  <label>
                  <div align="right">
                    <? if ($ape_mat!=NULL){?><input name="AGREGARGRUPO" type="submit" id="AGREGARGRUPO" onClick="MM_goToURL('parent','alumno.php3?pesta=7&agregarg=1');return document.MM_returnValue" value="AGREGAR" /> <? } else{?> <input name="AGREGARGRUPO" type="submit" id="AGREGARGRUPO" onClick="MM_goToURL('parent','alumno.php3?pesta=7&agregarg=1');return document.MM_returnValue" disabled="disabled" value="AGREGAR" /><? } ?>
                  </div>
                  </label>
                  <div align="right">
                    <? } ?>
                  </div></td>
              </tr>
            </table>
            </div></td>
		  </tr>
          <tr>
          <td width="15%" class="cuadro02"><div align="left">Fecha</div></td>
		  <td width="20%" class="cuadro02"><div align="left">Asunto</div></td>
		  <td width="60%" class="cuadro02"><div align="left">Descripci&oacute;n</div></td>
				  
				<?
				if (($_PERFIL=="0") OR ($_PERFIL=="0")){ ?>				
                        <td width="5%" class="cuadro02"><div align="center">Borrar</div></td>
			   <? } ?>	
          
               </tr>
                <?
				$sql_1 = "select * from entrevista where rut_apo = '$rut_apo'";
				$r1    = @pg_Exec($conn,$sql_1);
				$n1    = @pg_numrows($r1);
								
				$i = 0;
				while ($i < $n1){
					 $f1 = pg_fetch_array($r1,$i);
					 $id_entrevista  = $f1['id_entrevista'];
					 $rut_alumno     = $f1['rut_alumno'];
					 $rut_apo        = $f1['rut_apo'];
					 $fecha          = $f1['fecha'];
					 $asunto         = $f1['asunto'];
					 $observaciones  = $f1['observaciones'];
					 
					 $dd = substr($fecha,8,2);
					 $mm = substr($fecha,5,2);
					 $aa = substr($fecha,0,4);
					 
					 $fecha = "$dd-$mm-$aa";					 
					 
					 if ($rut_apo!=0){ ?>			    				 
                        <tr>
					      <td class="cuadro01"><?=$fecha ?></td>
					      <td class="cuadro01"><?=$asunto ?></td>
					      <td class="cuadro01"><?=$observaciones ?></td>
					      <?
			              if (($_PERFIL=="0") OR ($_PERFIL=="0")){ ?>
                              <td class="cuadro01">
                              <? if (($_PERFIL!=19) and ($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
                                  <div align="center">
                                     <input name="Submit2" type="button" onClick="MM_goToURL('parent','procesoAlumno.php3?pesta=7&borrar=1&id_entrevista=<?=$id_entrevista ?>');return document.MM_returnValue" value="B">
                                  </div>
			                <? } ?>
                             </td>
			           <? } ?>		 
                       </tr>
                  <? } ?>		 
                  <?
		          $i++;
		      }
		    ?>	 
          </table>
	  <? } ?>	
           
    </td></tr>
</table>
</FORM>	
 
       </td>
      </tr>
									 
	<!-- FIN PESTA�A GRUPOS -->		
			
			
			
			
			
									 
                    
                    </table>
			        <!-- codigo nuevo con pesta�as -->
			 		<!--fin codigo nuevo  paginas con fallas de tablas--->
							  </td>
                                </tr>
                              </table>
						    </td>
                          </tr>
                        </table>
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007</td>
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
<? require_once("includes/widgets/widgets_end.php");


?>